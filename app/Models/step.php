<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class step extends Model
{
    use HasFactory;

    protected $fillable = ['step_descripton'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'tasks_steps');
    }
}
