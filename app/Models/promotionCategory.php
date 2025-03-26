<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class promotionCategory extends Model
{
    //
    use HasFactory;
    protected $fillable = ['title', 'status'];

    public function promotion_contents():HasMany
    {
        return $this->hasMany(PromotionContent::class);
    }
}
