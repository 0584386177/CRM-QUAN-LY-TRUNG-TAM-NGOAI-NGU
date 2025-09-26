@use('App\Helpers\Helper')
<section class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @if ($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="Avatar" class="img-thumbnail rounded-circle mb-3">
                    @else
                        <span>{{ trim(ucfirst(substr($user->fullname, 0, 1))) }}</span>
                    @endif
                    <h4 class="fw-bold mb-1">{{ $user->fullname }}</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Mã nhân viên</strong>
                        <span>{{ $user->id }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Email</strong>
                        <span>{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Điện thoại</strong>
                        <span>{{ Helper::formatNumber($user->phone) }}</span>
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
                                data-bs-target="#courses" type="button" role="tab">Khóa học</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="homeroom-tab" data-bs-toggle="tab" data-bs-target="#homeroom"
                                type="button" role="tab">Lớp chủ nhiệm</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule"
                                type="button" role="tab">Lịch dạy</button>
                        </li> --}}
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary"
                                type="button" role="tab">
                                <i class="fas fa-dollar-sign me-1"></i> Lương & Phụ cấp
                            </button>
                        </li> --}}
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content" id="teacherTabContent">
                        <div class="tab-pane fade show active" id="courses" role="tabpanel">
                            <h5 class="mb-3">KHÓA HỌC ĐANG PHỤ TRÁCH</h5>
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã HP</th>
                                        <th>Tên học phần</th>
                                        <th>Số buổi học</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($user->courses as $course)
                                            <td>{{ $course->id }}</td>
                                            <td>{{ $course->name }}</td>
                                            <td>{{ $course->number_of_lessions }}</td>
                                        @endforeach
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="homeroom" role="tabpanel">
                            <h5 class="mb-3">Thông tin lớp chủ nhiệm</h5>
                            @foreach ($user->classes as $class)
                                <div class="homeroom-info-card">
                                    <h6 class="fw-bold">Lớp: {{ $class->name }}</h6>
                                    <p class="mb-1"><strong>Sĩ
                                            số:
                                        </strong>

                                        @if ($class->students->count() > 0)
                                            <span
                                                class=" text-primary fw-semibold">{{ $class->students->count() }}</span>
                                        @else
                                            <span class="text-danger fw-semibold">Chưa có</span>
                                        @endif
                                    </p>
                                    <hr>
                                    <a href="{{ route('classroom.index') }}" class="btn btn-sm btn-outline-primary">Xem
                                        danh
                                        sách lớp</a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary ms-2">Gửi thông báo</a>
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="schedule" role="tabpanel">
                            <h5 class="mb-3">Lịch giảng dạy tuần</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Buổi</th>
                                            <th>Thứ 2</th>
                                            <th>Thứ 3</th>
                                            <th>Thứ 4</th>
                                            <th>Thứ 5</th>
                                            <th>Thứ 6</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sáng</td>
                                            <td class="session-active">CS331<br><small>Phòng B1.02</small></td>
                                            <td></td>
                                            <td class="session-active">CE221<br><small>Phòng C3.01</small></td>
                                            <td></td>
                                            <td class="session-active">CS331<br><small>Phòng B1.02</small></td>
                                        </tr>
                                        <tr>
                                            <td>Chiều</td>
                                            <td></td>
                                            <td class="session-active">CE401<br><small>Phòng Lab 2</small></td>
                                            <td></td>
                                            <td class="session-active">CE221<br><small>Phòng C3.01</small></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="salary" role="tabpanel">
                            <h5 class="mb-3">Bảng lương chi tiết (Tháng 09/2025)</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group salary-summary">
                                        <li class="list-group-item d-flex justify-content-between"><span>Lương cơ
                                                bản</span> <strong>15,000,000 đ</strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span>Phụ cấp chức
                                                vụ</span> <strong>2,500,000 đ</strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span>Thưởng hiệu
                                                suất</span> <strong>3,000,000 đ</strong></li>
                                        <li class="list-group-item d-flex justify-content-between bg-light">
                                            <h6>Tổng thu nhập</h6>
                                            <h6 class="text-primary">20,500,000 đ</h6>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mt-4 mt-md-0">Lịch sử nhận lương gần đây</h6>
                                    <table class="table table-sm table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kỳ</th>
                                                <th>Số tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Tháng 08/2025</td>
                                                <td>20,100,000 đ</td>
                                            </tr>
                                            <tr>
                                                <td>Tháng 07/2025</td>
                                                <td>19,850,000 đ</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="confidential-notice mt-4">
                                <i class="fas fa-lock me-2"></i>
                                Thông tin lương là bảo mật. Vui lòng không chia sẻ.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* style.css */
    body {
        background-color: #f4f6f9;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

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

    /* Tab lương */
    #salary-tab.active {
        color: #198754;
        border-bottom-color: #198754 !important;
    }

    #salary-tab i {
        color: #198754;
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
