<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
   use HasFactory;

    protected $table = 'sub_category';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'solution_id',
        'category_id',
        'sub_category',
        'thumbnail_image',
        'slug',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
