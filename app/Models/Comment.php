<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['promotion_id', 'name', 'email', 'content', 'status', 'parent_id'];

    public function promotion()
    {
        return $this->belongsTo(PromotionContent::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}