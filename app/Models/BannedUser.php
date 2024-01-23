<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BannedUser extends Model
{
    use HasUuids;

    protected $table = "banned_users";
    protected $primaryKey = 'banned_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public function userBookStuff(): BelongsTo{
        return $this->belongsTo(User::class, 'NIP', 'NIP');
    }
}
