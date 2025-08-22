<?php

namespace App\Livewire\Elements;

use App\Models\PostCategory;
use Livewire\Component;

class PostCategoryDashboardSidebar extends Component
{
    public function render()
    {
        $topCategories = PostCategory::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->take(10)
            ->get();

        return view('livewire.elements.post-category-dashboard-sidebar', [
            'topCategories' => $topCategories
        ]);
    }
}
