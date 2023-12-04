<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookMachine extends Model
{
    use HasUuids;

    protected $fillable = [
        "book_id", "machine_id", "NIP", "start_time", "end_time", "photo", "status_id"
    ];

    protected $table = "book_machines";
    protected $primaryKey = 'book_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function userBookMachine(): BelongsTo{
        return $this->belongsTo(User::class, 'NIP', 'NIP');
    }
    public function statusMachine(): BelongsTo{
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }
    public function machine(): BelongsTo{
        return $this->belongsTo(WashingMachine::class, 'machine_id', 'machine_id');
    }
}
