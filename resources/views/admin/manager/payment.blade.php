@extends('admin.layout_admin.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center m-4">
        <div class="text-uppercase fw-bold">
            @if (request()->has('q') && request()->input('q') != '')
                Tìm kiếm giao dịch
            @else
                Danh sách giao dịch
            @endif
        </div>
        <div class="fw-bold text-capitalize">
            <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('admin.payments.index') }}">Danh sách giao dịch</a>
        </div>
    </div>

    <div class="card shadow-sm m-4">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <div class="search-container" title="Tìm kiếm giao dịch">
                    <form action="{{ route('admin.payments.index') }}" method="GET">
                        <input type="text" placeholder="Từ khóa (mã GD hoặc tên người dùng)" name="q" value="{{ request('q') }}" title="Tìm kiếm giao dịch">
                        <button type="submit"><i class="fas fa-search search-icon"></i></button>
                    </form>
                </div>
                <div class="d-flex justify-content-end my-2 align-items-center">
                    {{-- Nếu cần nút xuất file Excel --}}
                    {{-- <a href="{{ route('admin.payments.export') }}" class="btn btn-label-success btn-round btn-sm me-2">Excel</a> --}}
                </div>
            </div>
        </div>

        <div class="card-body">
            @if (request()->has('q') && request()->input('q') != '')
                <p class="alert alert-info">
                    Kết quả tìm kiếm cho từ khóa: <strong>{{ request()->input('q') }}</strong>
                </p>
            @endif

            @if ($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">Mã GD</th>
                                <th scope="col">Tên người dùng</th>
                                <th scope="col">Số tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Xử lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_code }}</td>
                                    <td>{{ $payment->user->name ?? 'Không rõ' }}</td>
                                    <td>{{ number_format($payment->amount) }} VNĐ</td>
                                    <td>
                                        @if($payment->status === 'pending')
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                        @elseif($payment->status === 'success')
                                            <span class="badge bg-success">Thành công</span>
                                        @elseif($payment->status === 'failed')
                                            <span class="badge bg-danger">Thất bại</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $payment->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($payment->status === 'pending')
                                                <form action="{{ route('admin.payment.confirm', $payment->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="success">
                                                    <button class="btn btn-success btn-sm" title="Duyệt giao dịch">
                                                        <i class="fas fa-check"></i> Duyệt
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.payment.confirm', $payment->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="failed">
                                                    <button class="btn btn-danger btn-sm" title="Từ chối giao dịch">
                                                        <i class="fas fa-times"></i> Từ chối
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">{{ ucfirst($payment->status) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @if (request()->has('q') && request()->input('q') != '')
                    <p class="alert alert-danger">Không tìm thấy giao dịch nào cho từ khóa <strong>{{ request()->input('q') }}</strong>!</p>
                @else
                    <p class="alert alert-danger">Chưa có giao dịch nào!</p>
                @endif
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
