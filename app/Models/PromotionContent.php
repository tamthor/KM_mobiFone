<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionContent extends Model
{
    //
    use HasFactory;
    protected $fillable = ['title', 'content', 'start_at', 'end_at', 'tag_ids', 'status'];

    // Tự động kiểm tra và cập nhật trạng thái nếu end_at đã qua
    public function getStatusAttribute($value)
    {
        if ($this->end_at && Carbon::parse($this->end_at)->isPast() && $value === 'active') {
            $this->update(['status' => 'inactive']);
            return 'inactive';
        }
        return $value;
    }
}
