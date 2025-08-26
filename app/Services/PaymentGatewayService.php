<?php

namespace App\Services;

use App\Models\Setting;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Payment;

class PaymentGatewayService
{
    /**
     * Get configured payment instance
     */
    public static function getPayment(): Payment
    {
        $gatewayType = Setting::get('payment_gateway_type', 'sandbox');
        $merchantId = Setting::get('payment_merchant_id', 'c39ad497-7ae5-47a0-a56e-42ea624193ac');

        // Create custom config based on settings
        $config = [
            'default' => 'zarinpal',
            'drivers' => [
                'zarinpal' => [
                    /* normal api */
                    'apiPurchaseUrl' => 'https://api.zarinpal.com/pg/v4/payment/request.json',
                    'apiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/',
                    'apiVerificationUrl' => 'https://api.zarinpal.com/pg/v4/payment/verify.json',

                    /* sandbox api */
                    'sandboxApiPurchaseUrl' => 'https://sandbox.zarinpal.com/pg/v4/payment/request.json',
                    'sandboxApiPaymentUrl' => 'https://sandbox.zarinpal.com/pg/StartPay/',
                    'sandboxApiVerificationUrl' => 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json',

                    /* zarinGate api */
                    'zaringateApiPurchaseUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
                    'zaringateApiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/:authority/ZarinGate',
                    'zaringateApiVerificationUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',

                    'mode' => $gatewayType,
                    'merchantId' => $merchantId,
                    'callbackUrl' => route('wallet.callback'),
                    'description' => 'payment using zarinpal',
                    'currency' => 'T',
                ],
            ],
            'map' => [
                'zarinpal' => \Shetabit\Multipay\Drivers\Zarinpal\Zarinpal::class,
            ],
        ];

        return new Payment($config);
    }

    /**
     * Create payment invoice
     */
    public static function createInvoice(int $amount): Invoice
    {
        return (new Invoice)->amount($amount);
    }

    /**
     * Get minimum charge amount from settings
     */
    public static function getMinChargeAmount(): int
    {
        return Setting::get('min_wallet_charge_amount', 10000);
    }

    /**
     * Get maximum charge amount from settings
     */
    public static function getMaxChargeAmount(): int
    {
        return Setting::get('max_wallet_charge_amount', 10000000);
    }

    /**
     * Validate charge amount
     */
    public static function validateChargeAmount(int $amount): bool
    {
        $minAmount = self::getMinChargeAmount();
        $maxAmount = self::getMaxChargeAmount();

        return $amount >= $minAmount && $amount <= $maxAmount;
    }

    /**
     * Get charge amount validation rules
     */
    public static function getChargeAmountRules(): array
    {
        $minAmount = self::getMinChargeAmount();
        $maxAmount = self::getMaxChargeAmount();

        return [
            'amount' => [
                'required',
                'numeric',
                "min:{$minAmount}",
                "max:{$maxAmount}",
            ],
        ];
    }
}
