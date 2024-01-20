<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookKitchen extends Model
{
    use HasUuids;

    protected $fillable = [
        "book_id", "NIP", "stuff_id", "start_time", "end_time", "photo", "status_id", "is_late"
    ];

    protected $table = "book_kitchens";
    protected $primaryKey = 'book_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function userBookStuff(): BelongsTo{
        return $this->belongsTo(User::class, 'NIP', 'NIP');
    }
    public function statusStuff(): BelongsTo{
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }
    public function stuff(): BelongsTo{
        return $this->belongsTo(KitchenStuff::class, 'stuff_id', 'stuff_id');
    }
}
