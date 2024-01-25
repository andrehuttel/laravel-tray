<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\DailySalesReport;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReportToSellers implements ShouldQueue
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
        $sellers = Seller::all();

        foreach ($sellers as $seller) {
            $sales = Sale::where('seller_id', $seller->id)
                ->whereDate('created_at', today())
                ->get();

            $totalSales = $sales->count();
            $totalValue = $sales->sum('value');
            $totalCommission = $sales->sum('commission');

            Mail::to($seller->email)->send(new DailySalesReport($seller, $totalSales, $totalValue, $totalCommission));
        }
    }
}
