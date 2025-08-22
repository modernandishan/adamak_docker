<?php

namespace App\Livewire\Elements;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddCommentForm extends Component
{
    public $modelId;
    public $modelType;
    public $text;
    public $rating = 5;
    public function mount($modelId, $modelType)
    {
        $this->modelId = $modelId;
        $this->modelType = $modelType;
    }
    public function addComment()
    {
        if (!Auth::check()) {
            session()->flash('error', 'برای افزودن نظرتان، ابتدا وارد شوید.');
            return;
        }
        $latestComment = Comment::where('user_id', Auth::user()->id)->latest()->first();

        if ($latestComment) {
            $commentCreatedAt = $latestComment->created_at;
            $isOlderThanOneDay = $commentCreatedAt->lt(Carbon::now()->subDay());
            if (!$isOlderThanOneDay) {
                $this->dispatch('totalCommentAllowedLimit');
                return;
            }
        }
        $this->validate([
            'text' => 'required|string|min:25|max:1000',
            'rating' => 'required|integer|between:1,5',
        ], [
            'text.required' => 'متن نظر الزامی است.',
            'text.min' => 'متن نظر باید حداقل ۲۵ کاراکتر باشد.',
            'text.max' => 'متن نظر نمی‌تواند بیش از ۱۰۰۰ کاراکتر باشد.',
            'rating.required' => 'لطفاً امتیاز خود را مشخص کنید.',
            'rating.between' => 'امتیاز باید عددی بین ۱ تا ۵ باشد.',
        ]);
        Comment::create([
            'model_id' => $this->modelId,
            'model_type' => $this->modelType,
            'user_id' => Auth::user()->id,
            'text' => $this->text,
            'rating' => $this->rating,
        ]);
        $this->reset(['text', 'rating']);
        $this->dispatch('addCommentSuccessful');
    }

    public function render()
    {
        return view('livewire.elements.add-comment-form');
    }
}
