<?php

namespace App\Filament\Pages;

use App\Services\OtpService;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static string $view = 'filament.pages.edit-profile';
    protected static ?string $title = 'ویرایش پروفایل';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        $profileData = $user->profile ? $user->profile->attributesToArray() : [];
        $this->form->fill($user->attributesToArray() + $profileData);
    }

    protected function getFormSchema(): array
    {
        $user = Auth::user();
        $isMobileVerified = !is_null($user->mobile_verified_at);

        return [
            Section::make('اطلاعات کاربری')
                ->schema([
                    TextInput::make('name')->label('نام')->required(),
                    TextInput::make('family')->label('نام خانوادگی')->required(),
                ])->columns(2),

            Section::make('تأیید و تغییر شماره موبایل')
                ->description('در صورتی که شماره موبایل خود را تأیید نکرده‌اید، می‌توانید آن را ویرایش کرده و کد تأیید دریافت کنید.')
                ->schema([
                    TextInput::make('mobile')
                        ->label('موبایل')
                        ->required()
                        ->tel()
                        ->regex('/^09[0-9]{9}$/')
                        ->unique('users', 'mobile', ignoreRecord: true)
                        ->disabled($isMobileVerified)
                        ->validationMessages([
                            'regex' => 'فرمت شماره موبایل صحیح نمی‌باشد.',
                            'unique' => 'این شماره موبایل قبلا ثبت شده است.',
                        ]),
                    TextInput::make('otp_code')
                        ->label('کد تأیید')
                        ->placeholder('کد ارسال شده را وارد کنید')
                        ->required(false)
                        ->visible(!$isMobileVerified)
                        ->numeric(),
                ])->columns(2),

            Section::make('اطلاعات پروفایل')
                ->schema([
                    FileUpload::make('avatar')
                        ->label('آواتار')
                        ->image()
                        ->disk('public') // Explicitly specify the public disk
                        ->directory('avatars')
                        ->visibility('public')
                        ->maxSize(1024)
                        ->imageEditor()
                        ->imagePreviewHeight('100')
                        ->hint('حداکثر ۱ مگابایت'),
                    Select::make('province')
                        ->label('استان')
                        ->options($this->getProvinces())
                        ->searchable()
                        ->nullable(),
                    TextInput::make('address')
                        ->label('آدرس')
                        ->maxLength(255)
                        ->nullable(),
                    TextInput::make('postal_code')
                        ->label('کد پستی')
                        ->maxLength(10)
                        ->nullable(),
                    TextInput::make('national_code')
                        ->label('کد ملی')
                        ->maxLength(10)
                        ->nullable(),
                    DatePicker::make('birth')
                        ->label('تاریخ تولد')
                        ->jalali()
                        ->nullable(),
                ])->columns(2),

            Section::make('تغییر رمز عبور')
                ->schema([
                    TextInput::make('password')->label('رمز عبور جدید')->password()->nullable()->confirmed(),
                    TextInput::make('password_confirmation')->label('تکرار رمز عبور جدید')->password()->dehydrated(false),
                ])->columns(2),
        ];
    }

    protected function getProvinces(): array
    {
        // This is a sample list. You can populate it from a database or a config file.
        return [
            'آذربایجان شرقی' => 'آذربایجان شرقی',
            'آذربایجان غربی' => 'آذربایجان غربی',
            'اردبیل' => 'اردبیل',
            'اصفهان' => 'اصفهان',
            'البرز' => 'البرز',
            'ایلام' => 'ایلام',
            'بوشهر' => 'بوشهر',
            'تهران' => 'تهران',
            'چهارمحال و بختیاری' => 'چهارمحال و بختیاری',
            'خراسان جنوبی' => 'خراسان جنوبی',
            'خراسان رضوی' => 'خراسان رضوی',
            'خراسان شمالی' => 'خراسان شمالی',
            'خوزستان' => 'خوزستان',
            'زنجان' => 'زنجان',
            'سمنان' => 'سمنان',
            'سیستان و بلوچستان' => 'سیستان و بلوچستان',
            'فارس' => 'فارس',
            'قزوین' => 'قزوین',
            'قم' => 'قم',
            'کردستان' => 'کردستان',
            'کرج' => 'کرج',
            'کرمان' => 'کرمان',
            'کرمانشاه' => 'کرمانشاه',
            'کهگیلویه و بویراحمد' => 'کهگیلویه و بویراحمد',
            'گلستان' => 'گلستان',
            'گیلان' => 'گیلان',
            'لرستان' => 'لرستان',
            'مازندران' => 'مازندران',
            'مرکزی' => 'مرکزی',
            'هرمزگان' => 'هرمزگان',
            'همدان' => 'همدان',
            'یزد' => 'یزد',
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data')
            ->model(Auth::user());
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('sendOtp')
                ->label('ارسال کد تأیید')
                ->action('sendOtpAction')
                ->color('success')
                ->visible(fn() => is_null(Auth::user()->mobile_verified_at)), // <-- always visible if not verified
            Action::make('save')
                ->label('ذخیره تغییرات')
                ->submit('save'),
        ];
    }

    public function sendOtpAction(OtpService $otpService): void
    {
        $data = $this->form->getState();
        $mobile = $data['mobile'];

        $lastSent = session('otp_last_sent_at');
        $now = Carbon::now();

        if ($lastSent) {
            $lastSentCarbon = $lastSent instanceof Carbon ? $lastSent : Carbon::parse($lastSent);
            $secondsPassed = (int)$lastSentCarbon->diffInSeconds($now, false);
            $cooldown = 60;
            $secondsLeft = max(0, $cooldown - $secondsPassed);

            if ($secondsLeft > 0) {
                Notification::make()
                    ->title('کمی صبر کنید')
                    ->body('برای ارسال مجدد کد، باید ' . $secondsLeft . ' ثانیه صبر کنید.')
                    ->warning()
                    ->send();
                return;
            }
        }

        try {
            $otpService->sendOtp($mobile, true);
            session(['otp_last_sent_at' => $now]);
            Notification::make()->title('کد تأیید ارسال شد')->body("کد تأیید به شماره {$mobile} ارسال گردید.")->success()->send();
        } catch (Exception $e) {
            Notification::make()->title('خطا در ارسال کد')->body($e->getMessage())->danger()->send();
        }
    }

    public function save(OtpService $otpService): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        // Handle mobile verification if not already verified
        if (is_null($user->mobile_verified_at)) {
            if (empty($data['otp_code'])) {
                Notification::make()->title('خطا')->body('کد تأیید الزامی است.')->danger()->send();
                return;
            }

            $isVerified = $otpService->verifyOtp($data['mobile'], $data['otp_code']);

            if (!$isVerified) {
                Notification::make()->title('خطا')->body('کد تأیید وارد شده صحیح نمی‌باشد.')->danger()->send();
                return;
            }
            // The verifyOtp method already updates mobile_verified_at
            $user->mobile = $data['mobile'];
        }

        // Update user's name and family
        $user->name = $data['name'];
        $user->family = $data['family'];

        // Update password if provided
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        // Update or create profile data
        $profileData = [
            'avatar' => $data['avatar'] ?? null,
            'province' => $data['province'] ?? null,
            'address' => $data['address'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'national_code' => $data['national_code'] ?? null,
            'birth' => $data['birth'] ?? null,
        ];
        $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);

        Notification::make()->title('پروفایل با موفقیت بروزرسانی شد.')->success()->send();

        // Refresh the page to reflect changes (e.g., disable mobile field)
        $this->redirect(static::getUrl());
    }
}
