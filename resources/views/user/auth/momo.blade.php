@extends('user.auth.layout_profile')
@section('content_profile')
<form action="confirm_momo" method="POST">
    <input type="hidden" name="sotien" id="selectedAmountInput" />

    <button type="submit" name="payUrl" class="btn btn-danger thanhtoan" data-bs-toggle="modal" data-bs-target="#thanhtoan">
        Thanh toán QR MOMO
    </button>
</form>

@endsection