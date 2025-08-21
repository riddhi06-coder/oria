<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePartner extends Model
{
    use HasFactory;

    protected $table = 'home_partner';
    public $timestamps = false;

    protected $fillable = [
        'section_title',
        'gallery_images',
        'banner_image',
        'section_description',
        'inserted_at',
        'inserted_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
