<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected  $fillable = 
    [
        'name',
        'street',
        'colony',
        'zip_code',
        'city'
    ];

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
