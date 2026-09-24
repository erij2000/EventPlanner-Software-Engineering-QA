<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'place', 
        'capacity', 'price', 'is_free', 'image', 'status', 'category_id', 'created_by'
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function users() { return $this->belongsToMany(User::class, 'registrations')->withTimestamps(); }

    /**
     * ACCESSEUR: Logic to display image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800';
        }

        // If it's a full URL (Unsplash), return it as is
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // If it's your local file (football.jpg), look in public/storage
        return asset('storage/' . $this->image);
    }
}