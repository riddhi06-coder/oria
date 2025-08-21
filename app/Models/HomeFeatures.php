<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeFeatures extends Model
{
     use HasFactory;

    protected $table = 'home_features';
    public $timestamps = false;

    protected $fillable = [
        'section_title',
        'gallery_images',
        'features',
        'inserted_at',
        'inserted_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
