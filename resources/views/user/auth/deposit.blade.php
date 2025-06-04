@extends('user.auth.layout_profile')

@section('content_profile')
<!-- <div class="container py-5"> -->
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Thông báo --}}
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Thông tin hồ sơ --}}
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div class="me-3 position-relative d-inline-block">
                    <img id="user-avatar"
                        src="{{ Auth::user()->avatar ? Auth::user()->avatar : '/user/assets/img/default.jpg' }}"
                        alt="User Avatar"
                        class="rounded-circle img-fluid shadow"
                        style="width: 60px; height: 60px; object-fit: cover;">
                </div>
                <h4 class="text-primary mb-0 ms-3">Hồ sơ cá nhân</h4>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Họ tên:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Số dư hiện tại:</strong> <span class="text-success fw-bold">{{ number_format(Auth::user()->balance) }} VNĐ</span></p>
                    <button id="toggleDepositForm" class="btn btn-outline-success">
                        💵 Nạp tiền vào tài khoản
                    </button>
                </div>
            </div>

            {{-- Form nạp tiền (ẩn/hiện) --}}
            <div id="depositForm" class="mt-4" style="display: none;">
                <hr>
                <h5 class="text-info">🔁 Nhập số tiền cần nạp</h5>
                <form action="{{ route('user.deposit.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Số tiền (tối thiểu 1.000 VNĐ):</label>
                        <input type="number" name="amount" id="amount" class="form-control" min="1000" required>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Tiếp tục</button>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
@endsection

@section('js')
<script>
    document.getElementById('toggleDepositForm').addEventListener('click', function() {
        const form = document.getElementById('depositForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
        this.textContent = form.style.display === 'block' ? '❌ Hủy nạp tiền' : '💵 Nạp tiền vào tài khoản';
    });
</script>
@endsection