<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'quantity',
        'available_quantity',
        'image',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('uploads/equipment/' . $this->image);
        }
        return asset('images/default-equipment.png'); // or use a placeholder
    }

    public function isAvailable()
    {
        return $this->status === 'available' && $this->available_quantity > 0;
    }
}