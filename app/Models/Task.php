<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'assigned_to_id',
        'created_by_id'
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->created_by_id)) {
                $model->created_by_id = auth()->id();
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id', 'id');
    }
}
