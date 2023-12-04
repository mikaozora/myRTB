<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasUuids;

    protected $fillable = [
        "room_id", "name"
    ];

    protected $table = "rooms";
    protected $primaryKey = 'room_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function books(): HasMany{
        return $this->hasMany(BookRoom::class, 'room_id', 'room_id');
    }
}
