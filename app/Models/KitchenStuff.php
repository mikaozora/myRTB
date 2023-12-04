<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KitchenStuff extends Model
{
    use HasUuids;

    protected $fillable = [
        "stuff_id", "name"
    ];

    protected $table = "kitchen_stuffs";
    protected $primaryKey = 'stuff_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function books(): HasMany{
        return $this->hasMany(BookKitchen::class, 'stuff_id', 'stuff_id');
    }
}
