<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Hiển thị form nạp tiền
    public function depositForm()
    {
        return view('user.auth.deposit');
    }

    // Xử lý khi user submit số tiền nạp
    public function depositSubmit(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000',
        ]);

        $user = Auth::user();
        $amount = $request->amount;
        $code = 'DEP' . time(); // mã giao dịch

        // Tạo giao dịch mới trạng thái pending (chờ admin duyệt)
        Payment::create([
            'user_id' => $user->id,
            'payment_code' => $code,
            'amount' => $amount,
            'method' => 'demo',
            'type' => 'deposit',
            'status' => 'pending',
            'note' => 'Chờ admin duyệt',
        ]);

        return redirect()->route('user.deposit')->with('success', 'Yêu cầu nạp tiền đã được gửi. Vui lòng chờ admin xác nhận.');
    }

    // (Nếu cần) Hiển thị danh sách các giao dịch của user
    // public function paymentHistory()
    // {
    //     $user = Auth::user();
    //     $payments = Payment::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
    //     return view('user.auth.payment_history', compact('payments'));
    // }
}
