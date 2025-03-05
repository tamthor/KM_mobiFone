<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promotion;
use Illuminate\Support\Carbon;

class UpdatePromotionStatus extends Command
{
    protected $signature = 'promotion:update-status';
    protected $description = 'Cập nhật trạng thái của các khuyến mãi đã hết hạn';

    public function handle()
    {
        $expiredPromotions = Promotion::where('end_at', '<', Carbon::now())->where('status', 'active')->get();

        foreach ($expiredPromotions as $promotion) {
            $promotion->update(['status' => 'inactive']);
        }

        $this->info('Đã cập nhật trạng thái khuyến mãi hết hạn.');
    }
}
