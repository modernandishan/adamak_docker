<?php

namespace App\Livewire\Elements;

use Livewire\Component;

class HomeTestsCategoryList extends Component
{
    public $test_categories;
    public function render()
    {
        $this->test_categories = \App\Models\TestCategory::where('is_active', 1)
            //->orderBy('order', 'asc')
            ->get();
        return view('livewire.elements.home-tests-category-list',[
            'test_categories' => $this->test_categories,
        ]);
        }
}
