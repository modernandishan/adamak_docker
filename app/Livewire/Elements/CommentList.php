<?php

namespace App\Livewire\Elements;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class CommentList extends Component
{
    use WithPagination;

    public $modelType;
    public $modelId;
    public $model;
    public function mount($modelType, $modelId)
    {
        $this->modelType = $modelType;
        $this->modelId = $modelId;
        $this->model = app($modelType)->findOrFail($modelId);
    }
    public function render()
    {
        $comments = Comment::where('model_type', $this->modelType)
            ->where('model_id',$this->modelId)
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.elements.comment-list', [
            'comments' => $comments,
        ]);
    }
}
