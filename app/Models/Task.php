<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'task', 'task_descripton'];

    public function steps()
    {
        return $this->belongsToMany(step::class, 'tasks_steps');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
