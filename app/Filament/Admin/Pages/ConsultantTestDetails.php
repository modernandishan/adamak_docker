<?php

namespace App\Filament\Admin\Pages;

use App\Models\Attempt;
use App\Models\ConsultantResponse;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ConsultantTestDetails extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.admin.pages.consultant-test-details';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public Attempt $attempt;

    public function mount($attempt): void
    {
        try {
            $this->attempt = Attempt::with([
                'user',
                'test.questions.answers' => function ($query) use ($attempt) {
                    $query->where('attempt_id', $attempt);
                },
                'test.questions',
                'family',
                'answers.question',
                'consultantResponse',
                'assignedConsultant',
            ])
                ->whereNotNull('assigned_consultant_id')
                ->findOrFail($attempt);

            $this->form->fill([
                'response_text' => $this->attempt->consultantResponse?->response_text ?? '',
                'recommendations' => $this->attempt->consultantResponse?->recommendations ?? '',
                'is_urgent' => $this->attempt->consultantResponse?->is_urgent ?? false,
            ]);

        } catch (ModelNotFoundException $e) {
            Notification::make()
                ->title('خطا')
                ->body('آزمون مورد نظر یافت نشد یا به شما اختصاص داده نشده است.')
                ->danger()
                ->send();

            $this->redirect(route('filament.admin.pages.consultant-dashboard'));
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('پاسخ مشاوره')
                    ->description('پاسخ خود را برای کاربر ارسال کنید')
                    ->schema([
                        Forms\Components\RichEditor::make('response_text')
                            ->label('متن پاسخ مشاوره')
                            ->required()
                            ->maxLength(5000)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('recommendations')
                            ->label('توصیه‌ها و راهکارها')
                            ->maxLength(2000)
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_urgent')
                            ->label('نیاز به پیگیری فوری دارد')
                            ->helperText('در صورت فعال بودن، این پاسخ به عنوان فوری علامت‌گذاری می‌شود'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $consultantResponse = ConsultantResponse::updateOrCreate(
            ['attempt_id' => $this->attempt->id],
            [
                'consultant_id' => Auth::id(),
                'response_text' => $data['response_text'],
                'recommendations' => $data['recommendations'] ?? null,
                'is_urgent' => $data['is_urgent'] ?? false,
                'sent_at' => now(),
            ]
        );

        Notification::make()
            ->title('موفقیت')
            ->body('پاسخ مشاوره با موفقیت ارسال شد.')
            ->success()
            ->send();

        // Refresh the attempt to get the updated response
        $this->attempt->load('consultantResponse');
    }

    public function getTitle(): string
    {
        return 'جزئیات آزمون: '.$this->attempt->test->title;
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('back')
                ->label('بازگشت به لیست')
                ->icon('heroicon-m-arrow-right')
                ->url(route('filament.admin.pages.consultant-dashboard')),
        ];
    }
}
