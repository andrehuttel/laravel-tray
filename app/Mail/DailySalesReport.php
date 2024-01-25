<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Seller;

class DailySalesReport extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;
    public $totalSales;
    public $totalValue;
    public $totalCommission;

    /**
     * Create a new message instance.
     */
    public function __construct(Seller $seller, $totalSales, $totalValue, $totalCommission)
    {
        $this->seller = $seller;
        $this->totalSales = $totalSales;
        $this->totalValue = $totalValue;
        $this->totalCommission = $totalCommission;
    }

    public function build()
    {
        return $this->view('emails.daily_sales_report')
            ->with([
                'seller' => $this->seller,
                'totalSales' => $this->totalSales,
                'totalValue' => $this->totalValue,
                'totalCommission' => $this->totalCommission,
            ])
            ->subject('Daily Sales Report');
    }
}
