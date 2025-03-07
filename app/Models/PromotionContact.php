<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionContact extends Model
{
    //
    use HasFactory;
    protected $fillable = ['promotion_content_id', 'full_name', 'email', 'phone_number', 'city', 'note'];

}