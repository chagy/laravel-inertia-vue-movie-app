<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'season_id',
        'name',
        'episode_number',
        'is_public',
        'visits',
        'slug',
        'overview',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
