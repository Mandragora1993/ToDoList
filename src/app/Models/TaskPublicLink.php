<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPublicLink extends Model
{
    protected $fillable = ['task_id', 'token', 'expires_at'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function isValid()
    {
        return $this->expires_at->isFuture();
    }
}