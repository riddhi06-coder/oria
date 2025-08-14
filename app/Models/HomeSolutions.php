<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSolutions extends Model
{
    use HasFactory;

    protected $table = 'home_solutions';
    public $timestamps = false;

    protected $fillable = [
        'solution_type_id',
        'banner_image',
        'inserted_at',
        'inserted_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
    
}
