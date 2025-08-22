<?php

namespace App\Livewire\Elements;

use App\Models\Comment;
use Livewire\Component;

class DashboardComments extends Component
{
    public $comments;

    public function mount()
    {
        $this->comments = Comment::with(['user', 'model'])
            ->approved()
            ->latest()
            ->take(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.elements.dashboard-comments');
    }
}
