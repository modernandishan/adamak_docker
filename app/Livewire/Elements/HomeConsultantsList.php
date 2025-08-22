<?php

namespace App\Livewire\Elements;

use App\Models\User;
use Livewire\Component;

class HomeConsultantsList extends Component
{
    public $consultants;
    public function render()
    {
        $this->consultants = User::whereHas("roles", function($q){ $q->where("name", "consultant"); })
            //->whereNull('deleted_at')
            ->get();
        return view('livewire.elements.home-consultants-list', [
            'consultants' => $this->consultants,
        ]);
    }
}
