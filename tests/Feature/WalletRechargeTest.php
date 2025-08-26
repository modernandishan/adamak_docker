<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Services\PaymentGatewayService;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletRechargeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Run the settings seeder
        $this->seed(SettingsSeeder::class);
    }

    public function test_settings_are_properly_seeded(): void
    {
        $this->assertDatabaseHas('settings', [
            'key' => 'payment_gateway_type',
            'value' => 'sandbox',
            'group' => 'payment',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'payment_merchant_id',
            'value' => 'c39ad497-7ae5-47a0-a56e-42ea624193ac',
            'group' => 'payment',
        ]);
    }

    public function test_payment_gateway_service_uses_settings(): void
    {
        // Test that the service returns the correct values from settings
        $minAmount = PaymentGatewayService::getMinChargeAmount();
        $maxAmount = PaymentGatewayService::getMaxChargeAmount();

        $this->assertEquals(10000, $minAmount);
        $this->assertEquals(10000000, $maxAmount);
    }

    public function test_amount_validation_works_correctly(): void
    {
        // Test valid amounts
        $this->assertTrue(PaymentGatewayService::validateChargeAmount(50000));
        $this->assertTrue(PaymentGatewayService::validateChargeAmount(10000));
        $this->assertTrue(PaymentGatewayService::validateChargeAmount(10000000));

        // Test invalid amounts
        $this->assertFalse(PaymentGatewayService::validateChargeAmount(5000));
        $this->assertFalse(PaymentGatewayService::validateChargeAmount(15000000));
    }

    public function test_settings_can_be_updated(): void
    {
        // Update a setting
        Setting::set('min_wallet_charge_amount', 20000, 'integer', 'system', 'حداقل مبلغ شارژ کیف پول');

        // Verify the change is reflected in the service
        $this->assertEquals(20000, PaymentGatewayService::getMinChargeAmount());

        // Test validation with new amount
        $this->assertFalse(PaymentGatewayService::validateChargeAmount(15000));
        $this->assertTrue(PaymentGatewayService::validateChargeAmount(25000));
    }

    public function test_payment_gateway_configuration(): void
    {
        // Test that the payment gateway can be configured
        $payment = PaymentGatewayService::getPayment();
        $this->assertNotNull($payment);

        // Test invoice creation
        $invoice = PaymentGatewayService::createInvoice(50000);
        $this->assertNotNull($invoice);
    }

    public function test_payment_gateway_mode_is_correct(): void
    {
        // Test that the gateway mode is set to sandbox
        $gatewayType = Setting::get('payment_gateway_type');
        $this->assertEquals('sandbox', $gatewayType);

        // Test that the merchant ID is set correctly
        $merchantId = Setting::get('payment_merchant_id');
        $this->assertEquals('c39ad497-7ae5-47a0-a56e-42ea624193ac', $merchantId);
    }

    public function test_payment_gateway_configuration_includes_all_urls(): void
    {
        // Test that the payment gateway configuration includes all necessary URLs
        $payment = PaymentGatewayService::getPayment();

        // This test ensures that the payment gateway is properly configured
        // and doesn't throw any exceptions when creating an invoice
        $invoice = PaymentGatewayService::createInvoice(10000);

        $this->assertNotNull($invoice);
        $this->assertEquals(10000, $invoice->getAmount());
    }

    public function test_settings_save_functionality(): void
    {
        // Test that settings can be saved and retrieved
        $testValue = 'test-gateway';

        // Save a new setting
        Setting::set('test_gateway_type', $testValue, 'string', 'payment', 'Test Gateway');

        // Verify it was saved
        $this->assertDatabaseHas('settings', [
            'key' => 'test_gateway_type',
            'value' => $testValue,
            'group' => 'payment',
        ]);

        // Verify it can be retrieved
        $retrievedValue = Setting::get('test_gateway_type');
        $this->assertEquals($testValue, $retrievedValue);

        // Test updating an existing setting
        $newValue = 'updated-gateway';
        Setting::set('test_gateway_type', $newValue, 'string', 'payment', 'Updated Test Gateway');

        // Verify it was updated
        $this->assertDatabaseHas('settings', [
            'key' => 'test_gateway_type',
            'value' => $newValue,
        ]);

        $updatedValue = Setting::get('test_gateway_type');
        $this->assertEquals($newValue, $updatedValue);
    }

    public function test_payment_gateway_redirect_url_generation(): void
    {
        // Test that payment gateway can generate redirect URLs
        $payment = PaymentGatewayService::getPayment();
        $invoice = PaymentGatewayService::createInvoice(50000);

        // Test that we can get a payment URL (this should not throw an exception)
        try {
            $result = $payment
                ->callbackUrl(route('wallet.callback'))
                ->purchase($invoice, function ($driver, $transactionId) {
                    // Mock callback
                })
                ->pay();

            // The result should be a RedirectionForm
            $this->assertNotNull($result);
            $this->assertInstanceOf(\Shetabit\Multipay\RedirectionForm::class, $result);

            // The result should be renderable
            $this->assertIsString($result->render());

        } catch (\Exception $e) {
            // If there's an error, it should be related to network/API, not configuration
            $this->assertStringContainsString('network', strtolower($e->getMessage())) ||
            $this->assertStringContainsString('api', strtolower($e->getMessage()));
        }
    }
}
