<?php

namespace App\Filament\Admin\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'تنظیمات';

    protected static ?string $navigationGroup = 'تنظیمات سیستم';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.admin.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getFormData());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Payment Settings Section
                Section::make('تنظیمات درگاه پرداخت')
                    ->description('تنظیمات مربوط به درگاه پرداخت زرین‌پال')
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Select::make('payment_gateway_type')
                            ->label('نوع درگاه پرداخت')
                            ->options([
                                'sandbox' => 'Sandbox (تست)',
                                'normal' => 'Normal (عادی)',
                                'zaringate' => 'ZarinGate',
                            ])
                            ->required()
                            ->helperText('نوع درگاه پرداخت را انتخاب کنید'),

                        TextInput::make('payment_merchant_id')
                            ->label('شناسه مرچنت')
                            ->required()
                            ->helperText('شناسه مرچنت درگاه پرداخت زرین‌پال'),
                    ])
                    ->columns(2),

                // General Settings Section
                Section::make('تنظیمات عمومی')
                    ->description('تنظیمات کلی سایت')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('نام سایت')
                            ->required(),

                        TextInput::make('contact_email')
                            ->label('ایمیل تماس')
                            ->email()
                            ->required(),

                        TextInput::make('contact_phone')
                            ->label('شماره تماس')
                            ->tel()
                            ->required(),

                        Textarea::make('site_description')
                            ->label('توضیحات سایت')
                            ->rows(3),
                    ])
                    ->columns(2),

                // System Settings Section
                Section::make('تنظیمات سیستم')
                    ->description('تنظیمات عملکرد سیستم')
                    ->icon('heroicon-o-cpu-chip')
                    ->schema([
                        Toggle::make('maintenance_mode')
                            ->label('حالت تعمیر و نگهداری')
                            ->helperText('در این حالت سایت در دسترس کاربران عادی نخواهد بود'),

                        Toggle::make('registration_enabled')
                            ->label('فعال بودن ثبت‌نام')
                            ->helperText('اجازه ثبت‌نام به کاربران جدید'),

                        TextInput::make('default_commission_percentage')
                            ->label('درصد کمیسیون پیش‌فرض')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->required(),

                        TextInput::make('min_wallet_charge_amount')
                            ->label('حداقل مبلغ شارژ کیف پول')
                            ->numeric()
                            ->minValue(1000)
                            ->suffix('تومان')
                            ->required(),

                        TextInput::make('max_wallet_charge_amount')
                            ->label('حداکثر مبلغ شارژ کیف پول')
                            ->numeric()
                            ->minValue(10000)
                            ->suffix('تومان')
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormData(): array
    {
        $settings = Setting::all()->keyBy('key');

        return [
            'payment_gateway_type' => $settings->get('payment_gateway_type')?->value ?? 'sandbox',
            'payment_merchant_id' => $settings->get('payment_merchant_id')?->value ?? 'c39ad497-7ae5-47a0-a56e-42ea624193ac',
            'site_name' => $settings->get('site_name')?->value ?? 'آدامک',
            'site_description' => $settings->get('site_description')?->value ?? '',
            'contact_email' => $settings->get('contact_email')?->value ?? 'info@adamak.com',
            'contact_phone' => $settings->get('contact_phone')?->value ?? '021-12345678',
            'maintenance_mode' => $settings->get('maintenance_mode')?->value === '1' || $settings->get('maintenance_mode')?->value === 'true',
            'registration_enabled' => $settings->get('registration_enabled')?->value !== '0' && $settings->get('registration_enabled')?->value !== 'false',
            'default_commission_percentage' => (int) ($settings->get('default_commission_percentage')?->value ?? 10),
            'min_wallet_charge_amount' => (int) ($settings->get('min_wallet_charge_amount')?->value ?? 10000),
            'max_wallet_charge_amount' => (int) ($settings->get('max_wallet_charge_amount')?->value ?? 10000000),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            // Save payment settings
            Setting::set('payment_gateway_type', $data['payment_gateway_type'], 'string', 'payment', 'نوع درگاه پرداخت');
            Setting::set('payment_merchant_id', $data['payment_merchant_id'], 'string', 'payment', 'شناسه مرچنت درگاه پرداخت');

            // Save general settings
            Setting::set('site_name', $data['site_name'], 'string', 'general', 'نام سایت');
            Setting::set('site_description', $data['site_description'], 'string', 'general', 'توضیحات سایت');
            Setting::set('contact_email', $data['contact_email'], 'string', 'general', 'ایمیل تماس');
            Setting::set('contact_phone', $data['contact_phone'], 'string', 'general', 'شماره تماس');

            // Save system settings
            Setting::set('maintenance_mode', $data['maintenance_mode'] ? '1' : '0', 'boolean', 'system', 'حالت تعمیر و نگهداری');
            Setting::set('registration_enabled', $data['registration_enabled'] ? '1' : '0', 'boolean', 'system', 'فعال بودن ثبت‌نام');
            Setting::set('default_commission_percentage', $data['default_commission_percentage'], 'integer', 'system', 'درصد کمیسیون پیش‌فرض');
            Setting::set('min_wallet_charge_amount', $data['min_wallet_charge_amount'], 'integer', 'system', 'حداقل مبلغ شارژ کیف پول');
            Setting::set('max_wallet_charge_amount', $data['max_wallet_charge_amount'], 'integer', 'system', 'حداکثر مبلغ شارژ کیف پول');

            // Clear cache
            Setting::clearCache();

            Notification::make()
                ->title('تنظیمات با موفقیت ذخیره شد')
                ->success()
                ->send();

        } catch (\Exception $e) {
            \Log::error('Settings save error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            Notification::make()
                ->title('خطا در ذخیره تنظیمات')
                ->body('خطا: '.$e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('ذخیره تنظیمات')
                ->action('save')
                ->icon('heroicon-o-check')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('تأیید ذخیره تنظیمات')
                ->modalDescription('آیا می‌خواهید تنظیمات را ذخیره کنید؟')
                ->modalSubmitActionLabel('ذخیره')
                ->modalCancelActionLabel('انصراف'),
        ];
    }
}
