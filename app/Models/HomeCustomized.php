<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCustomized extends Model
{
    use HasFactory;

    protected $table = 'home_customized';
    public $timestamps = false;

    protected $fillable = [
        'section_title',
        'banner_image',
        'description',
        'inserted_at',
        'inserted_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
