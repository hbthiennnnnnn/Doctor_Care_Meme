<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
{
    $query = Payment::with('user'); // tải sẵn user để tránh N+1

    if ($request->filled('q')) {
        $keyword = $request->q;

        // Tìm kiếm theo mã giao dịch hoặc tên người dùng
        $query->where('payment_code', 'like', "%{$keyword}%")
              ->orWhereHas('user', function($q) use ($keyword) {
                  $q->where('name', 'like', "%{$keyword}%");
              });
    }

    $payments = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.manager.payment', compact('payments'));
}

    public function confirm(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Giao dịch đã được xử lý.');
        }

        $status = $request->input('status'); // success hoặc fail

        $payment->status = $status;
        $payment->save();

        if ($status === 'success') {
            $user = $payment->user;
            $user->balance += $payment->amount;
            $user->save();
        }

        return back()->with('success', 'Cập nhật trạng thái giao dịch thành công.');
    }
}
