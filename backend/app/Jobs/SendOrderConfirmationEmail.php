<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class SendOrderConfirmationEmail implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public function __construct(public Order $order)
    {
        
    }


    public function handle(): void
    {
        $orderNumber = $this->order->order_number;
        $totalAmount = $this->order->total_amount;

        Log::info('Order confirmation email sent for order: ' . $this->order->order_number);
    }
}
