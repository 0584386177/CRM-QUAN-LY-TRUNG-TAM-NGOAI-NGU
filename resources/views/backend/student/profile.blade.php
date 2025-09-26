@use('App\Helpers\Helper')
@use('App\Enum\PaymentMethod')
<section class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @if ($student->avatar)
                        <img src="{{ asset($student->avatar ?? 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg') }}"
                            alt="Avatar" class="img-thumbnail rounded-circle mb-3">
                    @else
                        <span
                            class="bg-secondary bg-opacity-50 text-white rounded-circle d-inline-flex align-items-center justify-content-center fs-1"
                            style="width:80px; height:80px;">
                            {{ trim(ucfirst(substr($student->fullname, 0, 1))) }}
                        </span>
                    @endif
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Họ và tên</strong>
                        <span>{{ $student->fullname }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Email</strong>
                        <span>{{ $student->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Điện thoại</strong>
                        <span>{{ Helper::formatPhoneNumber($student->phone) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Ngày sinh</strong>
                        <span>{{ $student->birthday }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Địa chỉ</strong>
                        <span>{{ $student->address }}</span>
                    </li>

                </ul>
                <div class="card-body">
                    <a href="#" class="btn btn-primary w-100">Chỉnh sửa thông tin</a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <ul class="nav nav-tabs card-header-tabs" id="teacherTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="courses-tab" data-bs-toggle="tab"
                                data-bs-target="#courses" type="button" role="tab">Lớp học</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule"
                                type="button" role="tab">Lịch dạy</button>
                        </li> --}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary"
                                type="button" role="tab">
                                <i class="fas fa-dollar-sign me-1"></i> Học phí
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content" id="teacherTabContent">
                        <div class="tab-pane fade show active" id="courses" role="tabpanel">
                            <h4 class="mb-3">LỚP ĐANG HỌC</h4>
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã HP</th>
                                        <th>Lớp học</th>
                                        <th>Khóa học</th>
                                        <th>Giáo viên</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($student->classes as $class)
                                            <td>{{ $class->id }}</td>
                                            <td>{{ $class->name }}</td>
                                            <td>{{ $class->course->name }}</td>
                                            <td>{{ $student->teachers->pluck('fullname')->join(',') }}</td>
                                        @endforeach
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        {{-- THAY THẾ NỘI DUNG CŨ CỦA TAB HỌC PHÍ BẰNG ĐOẠN MÃ NÀY --}}

                        <div class="tab-pane fade" id="salary" role="tabpanel">
                            <div class="row">
                                <div class="tuition-timeline-layout">
                                    <div class="row summary-boxes">
                                        <div class="col-md-4">
                                            <div class="summary-box">
                                                <span class="label fw-semibold text-dark">Tổng Học Phí</span>
                                                <span class="value fee_amount text-dark">
                                                    {{ Helper::formatPrice($student->courses->pluck('fee')->first() ?? 0) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="summary-box">
                                                <span class="label fw-semibold text-dark">Đã Thanh Toán</span>
                                                <span class="value paid_amount text-dark">
                                                    {{ Helper::formatPrice($summary['paid_amount']) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="summary-box">
                                                <span class="label fw-semibold text-dark">Còn nợ</span>
                                                <span class="value remaining">
                                                    {{ Helper::formatPrice($summary['remaining']) }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>


                                    <hr class="my-4">

                                    <div class="add-payment-form mb-4">
                                        <h6 class="mb-3">Ghi nhận thanh toán mới</h6>

                                        <form method="POST"
                                            action="{{ route('student.tuition.update', $student->id) }}">
                                            @csrf
                                            <div class="input-group">
                                                <input type="number" class="form-control update_amount" name="tuition"
                                                    placeholder="Nhập số tiền... (ví dụ: 1000000)" required>
                                                <select class="form-select" name="payment_method"
                                                    style="max-width: 180px;" required>
                                                    @foreach (PaymentMethod::label() as $key => $method)
                                                        <option value="{{ $key }}">{{ $method }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-plus"></i> Thêm
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <h5 class="mt-4">Lịch sử giao dịch</h5>
                                    <ul class="payment-timeline">
                                        @foreach ($student->payments as $payment)
                                            <li>
                                                <div class="timeline-card">
                                                    <div class="timeline-header">
                                                        <span
                                                            class="date fw-semibold text-dark">{{ $payment->payment_date }}</span>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <i class="fas fa-receipt text-primary me-1"></i>
                                                        Thanh toán với số tiền <strong
                                                            class="text-danger">{{ Helper::formatPrice($payment->paid_amount) }}</strong>.
                                                        <span
                                                            class="badge {{ $payment->payment_method == 'cash' ? 'bg-success-light' : 'bg-primary-light' }}">{{ $payment->payment_method }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .card {
        border: none;
        border-radius: 0.5rem;
    }

    /* Cột trái */
    .img-thumbnail {
        border-color: #dee2e6;
        padding: 0.3rem;
        width: 120px;
        height: 120px;
    }

    /* Cột phải */
    .card-header-tabs {
        margin-bottom: -0.7rem;
        /* Giúp tab liền với card-body */
    }

    .nav-tabs .nav-link {
        border: none;
        border-top-left-radius: 0.3rem;
        border-top-right-radius: 0.3rem;
        color: #6c757d;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: #fff;
        border-bottom: 3px solid #0d6efd !important;
    }

    /* Thẻ thông tin lớp chủ nhiệm */
    .homeroom-info-card {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 0.3rem;
        padding: 1rem;
    }

    /* Bảng lịch dạy */
    .session-active {
        background-color: #e7f1ff;
        color: #0a58ca;
        font-weight: 500;
    }

    .salary-summary strong {
        color: #0d6efd;
    }

    .confidential-notice {
        padding: 0.75rem 1rem;
        background-color: #fffbe6;
        border: 1px solid #ffe58f;
        border-radius: 0.3rem;
        color: #664d03;
        font-size: 0.9rem;
        text-align: center;
    }
</style>
