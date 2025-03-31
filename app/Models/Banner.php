<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',  // Tiêu đề của banner
        'image',  // Đường dẫn ảnh
        'link',  // Liên kết khi nhấn vào banner
        'status',  // Trạng thái hiển thị (0: Ẩn, 1: Hiển thị)
    ];

    /**
     * Kiểm tra xem banner có đang hoạt động không
     * @return bool
     */
    // public function isActive()
    // {
    //     $now = now();
    //     return $this->status == 1 && ($this->start_date <= $now && ($this->end_date === null || $this->end_date >= $now));
    // }

    // /**
    //  * Trả về đường dẫn ảnh đầy đủ
    //  * @return string
    //  */
    // public function getImageUrlAttribute()
    // {
    //     return $this->image ? Storage::url($this->image) : asset('images/default-banner.jpg');
    // }
}
