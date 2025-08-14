<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerIntro extends Model
{
    use HasFactory;

    protected $table = 'banner_details';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'heading',
        'title',
        'description',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
