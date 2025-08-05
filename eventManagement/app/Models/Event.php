<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'date',
        'location',
        'limit',
    ];

    public function registrations(){
        return $this->hasMany(Registration::class);
    }

    public function users(){
        return $this->belongsToMany(Event::class, 'registrations')->withPivot(['status, checked_in_at']);
    }
}
