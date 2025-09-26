<div class="row"> {{-- <div class="col-sm-6">
        <h3 class="mb-0">{{$config['breadcrumb']['index']}}</h3>
    </div> --}} <div class="col-sm-6 mt-3">
        <ol class="breadcrumb float-sm-start">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$config['breadcrumb']['edit']}}</li>
        </ol>
    </div> @if ($errors->any())
        <div class="alert alert-danger">
            <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
    </div> @endif
</div>
<div class="card card-primary card-outline mb-4 " bis_skin_checked="1"> <!--begin::Header-->
    <div class="card-header" bis_skin_checked="1">
        <div class="card-title" bis_skin_checked="1">{{$config['breadcrumb']['edit']}}</div>
    </div> <!--end::Header--> <!--begin::Form-->
    <form method="POST" action="{{route('student.update', $student->id)}}"> @csrf <!--begin::Body-->
        <div class="card-body">
            <div class="row"> <!-- Cột trái -->
                <div class="col-md-6">
                    <div class="mb-3"> <label for="fullname" class="form-label">Họ và tên</label> <input type="text"
                            name="fullname" value="{{$student->fullname}}" class="form-control"> </div>
                    <div class="mb-3"> <label for="address" class="form-label">Địa
                            chỉ</label> <input type="text" name="address" value="{{$student->address}}"
                            class="form-control"> </div>



                    <div class="mb-3"> <label for="birthday" class="form-label">Ngày sinh</label> <input type="date"
                            name="birthday" value="{{ $student->birthday ? $student->birthday->format('Y-m-d') : '' }}"
                            class="form-control">
                    </div>


                    <div class="mb-3"> <label class="form-label">Khóa học</label>
                        <select name="course_id" id="" class="form-control">
                            <option value="0">--- Chọn khóa học ---</option>
                            @foreach ($courses as $course)
                                <option
                                    value="{{$course->id}}" {{$student->courses->contains('id', $course->id) ? 'selected' : ""}}>
                                        {{$course->name}}
                                    </option>
                            @endforeach
                        </select>
                    </div>

                    <div class=" mb-3">
                                <label for="" class="form-label">Chọn lớp học</label>
                                <select name="class_id" class="form-select" id="">
                                    <option value="0">---Chọn lớp dạy học---</option>
                                    @foreach ($classes as $class)
                                        <option value="{{$class->id}}" {{$student->classes->contains('id', $class->id) ? 'selected' : ""}}>
                                            {{$class->name}}
                                        </option>
                                    @endforeach
                                </select>
                    </div>

                </div> <!-- Cột phải -->
                <div class="col-md-6">
                    <div class="mb-3"> <label class="form-label">Email</label> <input type="email" name="email"
                            value="{{$student->email}}" class="form-control"> </div>
                    <div class="mb-3"> <labeclass="form-label">Số điện thoại</label> <input type="tel" name="phone"
                                value="{{$student->phone}}" class="form-control"> </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Giáo viên phụ trách</label>
                        <select name="teacher_id" class="form-select" id="">
                            <option value="1">---Chọn giáo viên---</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{$teacher->id}}" {{$student->teachers->contains('id', $teacher->id) ? 'selected' : ""}}>
                                    {{$teacher->fullname}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3"> <label class="form-label">Giới thiệu bản thân</label> <textarea name="bio"
                            value={{$student->bio}} rows="3" class="form-control"></textarea> </div>
                </div>
            </div>
        </div> <!-- Checkbox ở dưới -->
        <div class="mb-3 form-check"> <input type="checkbox" class="form-check-input" id="exampleCheck1"> <label
                class="form-check-label" for="exampleCheck1">Check me out</label> </div>
</div> <!--end::Body--> <!--begin::Footer-->
<div class="card-footer" bis_skin_checked="1"> <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
</div>
<!--end::Footer--> </form> <!--end::Form--> </div>