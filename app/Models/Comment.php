<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['promotion_id', 'name', 'email', 'content', 'status'];

    public function promotion()
    {
        return $this->belongsTo(PromotionContent::class);
    }
}