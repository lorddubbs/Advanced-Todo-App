<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Elasticity;


class Task extends Model
{
    use HasFactory, MediaAlly, Elasticity;

    protected $guarded = [
        'category_id'
    ];

    protected $hidden = [
        'user_id',
    ];

    /**
     * Set Relationships
     */

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'task_categories', 'task_id', 'category_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function toElasticsearchDocumentArray(): array {
        return $this->toArray();
    }


}
