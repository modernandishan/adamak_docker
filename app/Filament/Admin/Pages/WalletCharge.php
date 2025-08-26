<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\WalletStatsWidget;
use App\Models\WalletTransaction;
use App\Services\PaymentGatewayService;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class WalletCharge extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'مدیریت کیف پول';

    protected static ?string $navigationGroup = 'مالی';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.admin.pages.wallet-charge';

    public ?array $data = [];

    public $wallet;

    public function mount(): void
    {
        $this->wallet = Auth::user()->wallet()->firstOrCreate(['user_id' => Auth::id()], ['balance' => 0]);
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('اطلاعات کیف پول')
                    ->description('مشاهده وضعیت فعلی کیف پول')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Placeholder::make('current_balance')
                                    ->label('موجودی فعلی')
                                    ->content(fn () => number_format($this->wallet->balance).' تومان')
                                    ->extraAttributes(['class' => 'text-2xl font-bold text-success-600']),

                                Placeholder::make('total_transactions')
                                    ->label('تعداد تراکنش‌ها')
                                    ->content(fn () => number_format($this->wallet->transactions()->count()))
                                    ->extraAttributes(['class' => 'text-lg font-semibold text-primary-600']),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(false),

                Section::make('شارژ کیف پول')
                    ->description('شارژ کیف پول از طریق درگاه پرداخت')
                    ->schema([
                        TextInput::make('amount')
                            ->label('مبلغ شارژ (تومان)')
                            ->numeric()
                            ->minValue(PaymentGatewayService::getMinChargeAmount())
                            ->maxValue(PaymentGatewayService::getMaxChargeAmount())
                            ->required()
                            ->helperText('حداقل مبلغ: '.number_format(PaymentGatewayService::getMinChargeAmount()).' تومان - حداکثر مبلغ: '.number_format(PaymentGatewayService::getMaxChargeAmount()).' تومان')
                            ->suffix('تومان'),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                WalletTransaction::query()
                    ->where('wallet_id', $this->wallet->id)
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                TextColumn::make('transaction_id')
                    ->label('شناسه تراکنش')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('شناسه تراکنش کپی شد')
                    ->copyMessageDuration(1500),

                BadgeColumn::make('type')
                    ->label('نوع')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'charge' => 'شارژ',
                            'purchase' => 'خرید',
                            'refund' => 'بازگشت',
                            default => $state
                        };
                    })
                    ->colors([
                        'success' => 'charge',
                        'warning' => 'purchase',
                        'info' => 'refund',
                    ]),

                TextColumn::make('amount')
                    ->label('مبلغ')
                    ->formatStateUsing(fn (string $state): string => number_format($state).' تومان')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('وضعیت')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'completed' => 'تکمیل شده',
                            'pending' => 'در انتظار',
                            'failed' => 'ناموفق',
                            'processing' => 'در حال پردازش',
                            default => $state
                        };
                    })
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'pending',
                        'danger' => 'failed',
                        'info' => 'processing',
                    ]),

                TextColumn::make('description')
                    ->label('توضیحات')
                    ->limit(30)
                    ->tooltip(function ($state) {
                        return $state;
                    }),

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->formatStateUsing(function ($state) {
                        return Jalalian::fromDateTime($state)->format('Y/m/d H:i');
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('نوع تراکنش')
                    ->options([
                        'charge' => 'شارژ',
                        'purchase' => 'خرید',
                        'refund' => 'بازگشت',
                    ]),
                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'completed' => 'تکمیل شده',
                        'pending' => 'در انتظار',
                        'failed' => 'ناموفق',
                        'processing' => 'در حال پردازش',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10);
    }

    public function chargeWallet()
    {
        $amount = $this->data['amount'] ?? 0;

        // Validate amount using service
        if (! PaymentGatewayService::validateChargeAmount($amount)) {
            Notification::make()
                ->title('خطا')
                ->body('مبلغ وارد شده خارج از محدوده مجاز است. حداقل: '.number_format(PaymentGatewayService::getMinChargeAmount()).' تومان - حداکثر: '.number_format(PaymentGatewayService::getMaxChargeAmount()).' تومان')
                ->danger()
                ->send();

            return;
        }

        // پرداخت آنلاین با استفاده از درگاه پرداخت
        try {
            $payment = PaymentGatewayService::getPayment();
            $invoice = PaymentGatewayService::createInvoice($amount);

            $result = $payment
                ->callbackUrl(route('wallet.callback'))
                ->purchase($invoice, function ($driver, $transactionId) use ($amount) {
                    $this->wallet->transactions()->create([
                        'transaction_id' => $transactionId,
                        'amount' => $amount,
                        'type' => 'charge',
                        'description' => 'در انتظار پرداخت',
                        'status' => 'pending',
                    ]);
                })
                ->pay();

            // Redirect to payment gateway
            $paymentUrl = $result->getAction();
            
            // Log the payment URL for debugging
            \Log::info('Payment URL generated:', ['url' => $paymentUrl]);
            
            if (empty($paymentUrl)) {
                Notification::make()
                    ->title('خطا')
                    ->body('خطا در دریافت آدرس درگاه پرداخت')
                    ->danger()
                    ->send();
                return;
            }
            
            // Redirect directly to the payment gateway
            return redirect()->away($paymentUrl);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Filament payment gateway error: '.$e->getMessage(), [
                'amount' => $amount,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            Notification::make()
                ->title('خطا')
                ->body('خطا در اتصال به درگاه پرداخت: '.$e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function resetForm(): void
    {
        $this->form->fill();
        $this->data = [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WalletStatsWidget::class,
        ];
    }
}
