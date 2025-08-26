<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Payment Gateway Settings
        Setting::set(
            'payment_gateway_type',
            'sandbox',
            'string',
            'payment',
            'نوع درگاه پرداخت (sandbox, normal, zaringate)'
        );

        Setting::set(
            'payment_merchant_id',
            'c39ad497-7ae5-47a0-a56e-42ea624193ac',
            'string',
            'payment',
            'شناسه مرچنت درگاه پرداخت'
        );

        // General Settings
        Setting::set(
            'site_name',
            'آدامک',
            'string',
            'general',
            'نام سایت'
        );

        Setting::set(
            'site_description',
            'پلتفرم آزمون آنلاین',
            'string',
            'general',
            'توضیحات سایت'
        );

        Setting::set(
            'contact_email',
            'info@adamak.com',
            'string',
            'general',
            'ایمیل تماس'
        );

        Setting::set(
            'contact_phone',
            '021-12345678',
            'string',
            'general',
            'شماره تماس'
        );

        // System Settings
        Setting::set(
            'maintenance_mode',
            false,
            'boolean',
            'system',
            'حالت تعمیر و نگهداری'
        );

        Setting::set(
            'registration_enabled',
            true,
            'boolean',
            'system',
            'فعال بودن ثبت‌نام'
        );

        Setting::set(
            'default_commission_percentage',
            10,
            'integer',
            'system',
            'درصد کمیسیون پیش‌فرض'
        );

        Setting::set(
            'min_wallet_charge_amount',
            10000,
            'integer',
            'system',
            'حداقل مبلغ شارژ کیف پول (تومان)'
        );

        Setting::set(
            'max_wallet_charge_amount',
            10000000,
            'integer',
            'system',
            'حداکثر مبلغ شارژ کیف پول (تومان)'
        );
    }
}
