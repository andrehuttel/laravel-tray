<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AdminDailySalesSummary;
use App\Models\Sale;
use Illuminate\Support\Facades\Mail;

class SendDailySalesSummaryToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $totalSales = Sale::whereDate('created_at', today())->count();
        $totalValue = Sale::whereDate('created_at', today())->sum('value');
        $totalCommission = Sale::whereDate('created_at', today())->sum('commission');

        Mail::to('admin@example.com')->send(new AdminDailySalesSummary($totalSales, $totalValue, $totalCommission));
    }
}
