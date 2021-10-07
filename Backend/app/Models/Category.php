<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'task_id',
    ];

    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task', 'task_categories', 'category_id', 'task_id')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
