<?php

namespace App\Livewire\Elements;

use App\Models\Comment;
use Livewire\Component;

class DashboardAverageStars extends Component
{
    public $averageRating;
    public $totalReviews;
    public $ratingDistribution;
    public $maxRatingCount;

    public function mount()
    {
        // محاسبه میانگین امتیاز
        $this->averageRating = Comment::approved()->avg('rating') ?? 0;

        // تعداد کل نظرات تأیید شده
        $this->totalReviews = Comment::approved()->count();

        // توزیع امتیازها
        $this->ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = Comment::approved()->where('rating', $i)->count();
            $this->ratingDistribution[$i] = $count;
        }

        // بیشترین تعداد برای محاسبه درصد
        $this->maxRatingCount = max($this->ratingDistribution) ?: 1;
    }

    public function render()
    {
        return view('livewire.elements.dashboard-average-stars');
    }
}
