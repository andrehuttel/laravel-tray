<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminDailySalesSummary extends Mailable
{
    use Queueable, SerializesModels;

    public $totalSales;
    public $totalValue;
    public $totalCommission;

    /**
     * Create a new message instance.
     */
    public function __construct($totalSales, $totalValue, $totalCommission)
    {
        $this->totalSales = $totalSales;
        $this->totalValue = $totalValue;
        $this->totalCommission = $totalCommission;
    }

    public function build()
    {
        return $this->view('emails.admin_daily_sales_summary')
            ->with([
                'totalSales' => $this->totalSales,
                'totalValue' => $this->totalValue,
                'totalCommission' => $this->totalCommission,
            ])
            ->subject('Admin Daily Sales Summary');
    }
}
