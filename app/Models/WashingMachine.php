<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WashingMachine extends Model
{
    use HasUuids;

    protected $fillable = [
        "machine_id", "name"
    ];

    protected $table = "washing_machines";
    protected $primaryKey = 'machine_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function books(): HasMany{
        return $this->hasMany(BookMachine::class, 'machine_id', 'machine_id');
    }
}
