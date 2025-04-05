<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeMedia extends Model
{
    use HasFactory;

    protected $table = 'types_media';

    protected $fillable = 
    [
        'name'
    ];

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
