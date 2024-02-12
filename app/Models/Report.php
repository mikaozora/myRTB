<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasUuids;

    protected $fillable = [
        "report_id", "NIP", "type", "description", "photo", "status_id", "admin photo"
    ];

    protected $table = "reports";
    protected $primaryKey = 'report_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function userReport(): BelongsTo{
        return $this->belongsTo(User::class, 'NIP', 'NIP');
    }
    public function statusReport(): BelongsTo{
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }
}
