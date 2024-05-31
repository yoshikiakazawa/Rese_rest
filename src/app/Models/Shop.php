<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = ['owner_id', 'region_id', 'genre_id', 'overview', 'path'];

    public function owners()
    {
        return $this->belongsTo(Owner::class, "owner_id");
    }

    public function regions()
    {
        return $this->belongsTo(Region::class, "region_id");
    }

    public function genres()
    {
        return $this->belongsTo(Genre::class, "genre_id");
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'region_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'favorite_id');
    }
}
