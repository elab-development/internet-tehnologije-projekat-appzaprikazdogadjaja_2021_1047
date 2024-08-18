<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'venue_id', 'category_id', 'source_id', 'url', 'image'
    ];
}
