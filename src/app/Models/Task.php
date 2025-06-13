<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'priority', 'status', 'due_date'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publicLinks()
    {
        return $this->hasMany(TaskPublicLink::class);
    }

    public function histories()
    {
        return $this->hasMany(TaskHistory::class);
    }
}