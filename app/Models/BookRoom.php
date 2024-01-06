<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookRoom extends Model
{
    use HasUuids;

    protected $fillable = [
        "book_id", "NIP", "room_id", "start_time", "end_time", "photo", "type", "participant", "status_id"
    ];

    protected $table = "book_rooms";
    protected $primaryKey = 'book_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function userBookRoom(): BelongsTo{
        return $this->belongsTo(User::class, 'NIP', 'NIP');
    }
    public function statusRoom(): BelongsTo{
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }
    public function room(): BelongsTo{
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
    
}
