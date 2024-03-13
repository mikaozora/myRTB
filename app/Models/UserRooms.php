<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRooms extends Model
{

    protected $fillable = [
        "room_number", "capacity"
    ];

    protected $table = "user_rooms";
    protected $primaryKey = 'room_number';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function userRoom(): HasMany{
        return $this->hasMany(User::class, 'number_rooms', 'number_rooms');
    }

}
