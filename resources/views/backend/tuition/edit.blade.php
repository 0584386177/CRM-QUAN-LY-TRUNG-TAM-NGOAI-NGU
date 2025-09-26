<div class="row"> {{-- <div class="col-sm-6">
        <h3 class="mb-0">{{$config['breadcrumb']['index']}}</h3>
    </div> --}} <div class="col-sm-6 mt-3">
        <ol class="breadcrumb float-sm-start">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $config['breadcrumb']['edit'] }}</li>
        </ol>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<div class="card card-primary card-outline mb-4 " bis_skin_checked="1"> <!--begin::Header-->
    <div class="card-header" bis_skin_checked="1">
        <div class="card-title" bis_skin_checked="1">{{ $config['breadcrumb']['edit'] }}</div>
    </div> <!--end::Header--> <!--begin::Form-->
    <form method="POST" action="{{ route('tuition.update', $tuition->id) }}"> @csrf <!--begin::Body-->
        <div class="card-body">
            <div class="row"> <!-- Cột trái -->
                <div class="col-md-6">
                    <div class="mb-3"> <label for="fullname" class="form-label">Tên môn học</label> <input
                            type="text" name="name" value="{{ $tuition->name }}" class="form-control"> </div>
                    <div class="mb-3"> <label class="form-label">Học phí</label> <input type="text" name="fee"
                            value={{ @price($tuition->fee ?? 0) }} class="form-control">
                    </div>
                    <div class="mb-3"> <label class="form-label"> Trạng thái khóa học </label>
                        <select name="status" class="form-select">
                            <option value="0">---Chọn---</option>
                            @foreach ($status as $key => $val)
                                <option value="{{ $key }}" {{ $tuition->status == $key ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>

                    </div>


                </div> <!-- Cột phải -->
                <div class="col-md-6">
                    <div class="mb-3"> <label class="form-label">Phụ trách môn </label>
                        <select name="teacher_id" class="form-select">
                            <option value="0">---Chọn giáo viên---</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ $tuition->teachers->contains('id', $teacher->id) ? 'selected' : '' }}>
                                    {{ $teacher->fullname }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="mb-3"> <label class="form-label">Số buổi học</label> <input type="text"
                            name="number_of_lessions" value="{{ $tuition->number_of_lessions }}" class="form-control">
                    </div>


                </div>
            </div>
        </div> <!-- Checkbox ở dưới -->
</div> <!--end::Body--> <!--begin::Footer-->
<div class="card-footer" bis_skin_checked="1"> <button type="submit" class="btn btn-primary">Cập nhật thông
        tin</button>
</div>
<!--end::Footer--> </form> <!--end::Form--> </div>
