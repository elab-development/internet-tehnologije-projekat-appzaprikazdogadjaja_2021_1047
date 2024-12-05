<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'address', 'city', 'country', 'postal_code',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
