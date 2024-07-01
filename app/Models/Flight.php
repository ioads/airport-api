<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'origin_id',
        'destination_id',
        'code',
        'departure',
        'seats_available'
    ];

    public function classes()
    {
        return $this->hasMany(ClassFlight::class);
    }

    public function origin()
    {
        return $this->belongsTo(Airport::class, 'origin_id', 'id');
    }

    public function destination()
    {
        return $this->belongsTo(Airport::class, 'destination_id', 'id');
    }
}
