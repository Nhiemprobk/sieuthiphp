<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill; // Gọi Model Bill để lưu đơn hàng
use App\Jobs\SendOrderConfirmationEmail; // Bắt buộc phải gọi Job class này vào

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate dữ liệu đầu vào (Bạn giữ nguyên code validate cũ của nhóm ở đây)

        // 2. Lưu đơn hàng vào database
        $bill = new Bill();
        // ... gán các thông tin cho $bill từ $request (VD: $bill->name = $request->name; ...)
        $bill->save();

        // 3. KÍCH HOẠT QUEUE: Đẩy tác vụ gửi email vào hàng đợi chạy ngầm
        SendOrderConfirmationEmail::dispatch($bill);

        // 4. Trả về kết quả THÀNH CÔNG NGAY LẬP TỨC cho khách hàng
        return redirect()->route('checkout.success')
                         ->with('message', 'Đặt hàng thành công! Vui lòng kiểm tra email.');
    }
}