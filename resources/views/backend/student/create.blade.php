<div class="row">
    <div class="col-sm-6 mt-3">
        <ol class="breadcrumb float-sm-start">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$config['breadcrumb']['create']}}</li>
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

<form method="POST" action="{{route('student.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">{{$config['breadcrumb']['create']}}</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên</label>
                        <input type="text" id="fullname" name="fullname" value="{{old('fullname')}}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" id="address" name="address" value="{{old('address')}}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Chọn môn học</label>
                        <select name="subject_id" class="form-select" id="">
                            <option value="0">---Chọn môn học giảng dạy---</option>
                            @foreach ($subjects as $key => $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Chọn lớp học</label>
                        <select name="class_id" class="form-select" id="">
                            <option value="0">---Chọn lớp dạy học---</option>
                            @foreach($classes as $key => $class)
                                <option value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>



                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" value="{{old('phone')}}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="birthday" class="form-label">Ngày sinh</label>
                        <input type="date" id="birthday" name="birthday" value="{{old('birthday')}}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Hình ảnh</label>
                        <input type="file" id="avatar" name="avatar" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Giáo viên phụ trách</label>
                        <select name="teacher_id" class="form-select" id="">
                            <option value="1">---Chọn giáo viên---</option>
                            @foreach($teachers as $key => $teacher)
                                <option value="{{$teacher->id}}">{{$teacher->fullname}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="bio" class="form-label">Giới thiệu bản thân</label>
                        <textarea id="bio" name="bio" rows="3" class="form-control">{{old('bio')}}</textarea>
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