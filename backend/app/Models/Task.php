<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status'
    ];

    protected $appends = ['status_text'];

    protected $casts = [
        'status' => TaskStatus::class
    ];

    protected function getStatusTextAttribute(): string
    {
        return $this->status->label();
    }
}
