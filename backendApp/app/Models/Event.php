<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'location_id', 'category_id', 'reference_id', 'url', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function reference()
    {
        return $this->belongsTo(Reference::class);
    }
}
