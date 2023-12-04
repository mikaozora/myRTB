<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $fillable = [
        "NIP", "name", "password", "class", "gender", "room_number", "phone_number", "photo"
    ];

    protected $table = "users";
    protected $primaryKey = 'NIP';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function bookStuff(): HasMany{
        return $this->hasMany(BookKitchen::class, 'NIP', 'NIP');
    }
    public function bookMachine(): HasMany{
        return $this->hasMany(BookMachine::class, 'NIP', 'NIP');
    }
    public function bookRoom(): HasMany{
        return $this->hasMany(BookRoom::class, 'NIP', 'NIP');
    }
    public function report(): HasMany{
        return $this->hasMany(Report::class, 'NIP', 'NIP');
    }
    public function forum(): HasMany{
        return $this->hasMany(Forum::class, 'NIP', 'NIP');
    }
}

