@use('App\Helpers\Helper')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-start">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $config['breadcrumb']['create'] }}</li>
            </ol>
        </div>
        @if ($errors->any())
            <div class="col-12">
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-circle me-2"></i>Thông tin cá nhân</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Họ và tên <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="fullname" name="fullname" value="{{ old('fullname') }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birthday" class="form-label">Ngày sinh</label>
                                <input type="date" id="birthday" name="birthday" value="{{ old('birthday') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại <span
                                        class="text-danger">*</span></label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Giới thiệu bản thân</label>
                            <textarea id="bio" name="bio" rows="4" class="form-control">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-graduation-cap me-2"></i>Thông tin đăng ký học</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="course_id" class="form-label">Chọn môn học <span
                                        class="text-danger">*</span></label>
                                <select name="course_id" class="form-select" id="course_id" required>
                                    <option value="">--- Chọn khóa học ---</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->name }} {{ Helper::formatPrice($course->fee) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="class_id" class="form-label">Chọn lớp học <span
                                        class="text-danger">*</span></label>
                                <select name="class_id" class="form-select" id="class_id" required>
                                    <option value="">--- Chọn lớp học ---</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="teacher_id" class="form-label">Giáo viên phụ trách</label>
                            <select name="teacher_id" class="form-select" id="teacher_id">
                                <option value="">--- Chọn giáo viên ---</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-image me-2"></i>Ảnh đại diện</h3>
                    </div>
                    <div class="card-body text-center">
                        <img id="avatar-preview" src="#" alt="Xem trước ảnh" />
                        <p class="text-muted small mt-2">Chọn ảnh đại diện cho học viên</p>
                        <input type="file" id="avatar" name="avatar" class="form-control"
                            onchange="previewImage(event)">
                    </div>
                </div>

                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-dollar-sign me-2"></i>Thông tin học phí</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="amount_paid" class="form-label">Số tiền đã đóng (VNĐ)</label>
                            <input type="number" id="amount_paid" name="paid_amount"
                                value="{{ old('amount_paid', 0) }}" class="form-control" placeholder="VD: 2000000">
                        </div>
                        <div class="mb-3">
                            <label for="amount_paid" class="form-label">Số tiền còn nợ (VNĐ)</label>
                            <input type="number" id="amount_paid" name="remaining" class=" form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                            <select name="payment_method" class="form-select" id="payment_method">
                                <option value="cash">Tiền mặt</option>
                                <option value="transfer">Chuyển khoản</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline mb-4">
                    <div class="card-body">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                value="1" checked>
                            <label class="form-check-label" for="is_active">Kích hoạt tài khoản</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit"
                                class="btn btn-primary btn-lg">{{ $config['breadcrumb']['create'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


{{-- @endsection --}}
