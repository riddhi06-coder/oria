<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solutions extends Model
{
     use HasFactory;

    protected $table = 'solution_type';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'solution_type',
        'slug',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
