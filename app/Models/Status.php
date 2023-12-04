<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasUuids;

    protected $fillable = [
        "status_id", "name"
    ];

    protected $table = "status";
    protected $primaryKey = 'status_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function report(): HasMany{
        return $this->hasMany(Report::class, 'status_id', 'status_id');
    }
    public function bookStuff(): HasMany{
        return $this->hasMany(BookKitchen::class, 'status_id', 'status_id');
    }
    public function bookMachine(): HasMany{
        return $this->hasMany(BookMachine::class, 'status_id', 'status_id');
    }
    public function bookRoom(): HasMany{
        return $this->hasMany(BookRoom::class, 'status_id', 'status_id');
    }
}
