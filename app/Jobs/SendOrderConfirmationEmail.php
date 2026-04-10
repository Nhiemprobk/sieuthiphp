<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Bill; // Nhớ import Model Bill của dự án
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed; // Giả sử bạn đã có Mailable class này

class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $bill;

    /**
     * Create a new job instance.
     */
    public function __construct(Bill $bill)
    {
        // Truyền data của đơn hàng vào Job
        $this->bill = $bill;
    }

    /**
     * Execute the job.
     * Logic gửi email sẽ nằm ở đây
     */
    public function handle(): void
    {
        // Gửi email cho khách hàng dựa trên thông tin $this->bill
        // (Đây là tác vụ mất thời gian, nhưng giờ nó đã chạy ngầm)
        Mail::to($this->bill->customer_email)->send(new OrderConfirmed($this->bill));
    }
}