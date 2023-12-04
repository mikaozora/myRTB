<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Forum extends Model
{
    use HasUuids;

    protected $fillable = [
        "message_id", "NIP", "message", "created_at"
    ];

    protected $table = "forums";
    protected $primaryKey = 'message_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function userReport(): BelongsTo{
        return $this->belongsTo(User::class, 'NIP', 'NIP');
    }
}
