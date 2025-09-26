<div class="row">
    <div class="col-sm-6 mt-3">
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

<form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
    <input type="hidden" name="activation_token" class="form-control">
    @csrf
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">{{ $config['breadcrumb']['create'] }}</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên</label>
                        <input type="text" id="fullname" name="fullname" value="{{ old('fullname') }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="birthday" class="form-label">Ngày sinh</label>
                        <input type="date" id="birthday" name="birthday" value="{{ old('birthday') }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                            class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="hire_date" class="form-label">Ngày vào làm</label>
                        <input type="date" id="hire_date" name="hire_date" class="form-control">
                    </div>

                    `

                    <div class="mb-3">
                        <label for="teacher_type" class="form-label">Trạng thái làm việc</label>
                        <select name="teacher_type" id="teacher_type" class="form-select">
                            <option value="0">-- Chọn trạng thái --</option>
                            @foreach ($teacher_type as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('teacher_type') == $key ? 'selected' : '' }}>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="re_password" class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" id="re_password" name="re_password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Tình trạng công tác</label>
                        <select name="class_id" class="form-select" id="">
                            <option>--- Chọn ---</option>
                            <option value="1">Đang công tác</option>
                            <option value="0">Đã nghỉ làm</option>
                        </select>
                    </div>


                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="base_salary" class="form-label">Mức lương cơ bản</label>
                        <div class="input-group">
                            <input type="text" id="base_salary" name="base_salary" class="form-control"
                                value="{{ old('base_salary') }}"> <span class="input-group-text">VND</span>
                        </div>
                    </div>
                    <div class=" mb-3">
                        <label for="" class="form-label">Chọn môn học giảng dạy</label>
                        <select name="course_id" class="form-select" id="">
                            <option value="0">---Chọn môn học giảng dạy---</option>
                            @foreach ($courses as $key => $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-md-6">


                    <div class="mb-3">
                        <label for="avatar" class="form-label">Hình ảnh</label>
                        <input type="file" id="avatar" name="avatar" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Chọn lớp học để dạy</label>
                        <select name="class_id" class="form-select" id="">
                            <option value="0">---Chọn lớp dạy học---</option>
                            @foreach ($classes as $key => $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="bio" class="form-label">Giới thiệu bản thân</label>
                        <textarea id="bio" name="bio" rows="3" class="form-control">{{ old('bio') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
    </div>
</form>
