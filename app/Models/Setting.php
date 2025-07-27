<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Setting extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'meta_title',
        'meta_data',
        'meta_description',
    ];
}
