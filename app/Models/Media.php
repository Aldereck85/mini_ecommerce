<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;
    
    protected $fillable = 
    [
        'name',
        'location_id',
        'type_id',
        'price_day',
    ];

    protected $casts = 
    [
        'price_day' => 'decimal:2',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeMedia::class);
    }
}
