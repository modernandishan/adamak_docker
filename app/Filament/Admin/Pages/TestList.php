<?php

namespace App\Filament\Admin\Pages;

use App\Models\Test;
use App\Models\TestCategory;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class TestList extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static string $view = 'filament.admin.pages.test-list';
    protected static ?string $title = 'آزمون‌های آدمک';
    protected static ?string $navigationLabel = 'مشاهده آزمون‌ها';
    protected static ?int $navigationSort = 1;
    public ?string $search = '';
    public ?string $category = '';
    public string $sortBy = 'newest';

    public function getTests(): Collection
    {
        $query = Test::query()
            ->with('category')
            ->active();

        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }

        if ($this->category) {
            $query->where('test_category_id', $this->category);
        }

        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('price');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'title':
                $query->orderBy('title');
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->get();
    }

    public function getCategories(): Collection
    {
        return TestCategory::active()->ordered()->get();
    }

    protected function getViewData(): array
    {
        return [
            'tests' => $this->getTests(),
            'categories' => $this->getCategories(),
        ];
    }

    public function getSortOptions(): array
    {
        return [
            'newest' => 'جدیدترین',
            'oldest' => 'قدیمی‌ترین',
            'price_low' => 'ارزان‌ترین',
            'price_high' => 'گران‌ترین',
            'title' => 'بر اساس عنوان',
        ];
    }
}
