<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    
    protected function schedule(Schedule $schedule): void
    {
        // Đặt lịch cho các lệnh
        $schedule->command('rental:expire-payments')->everyFiveMinutes();
        $schedule->command('payment:check-status')
        ->daily() // Chạy mỗi ngày vào nửa đêm
        ->appendOutputTo(storage_path('logs/payment_check_status.log')); // Ghi nhật ký
    }
    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        
        require base_path('routes/console.php');
    }
}
