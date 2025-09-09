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

<form method="POST" action="{{route('subject.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">{{$config['breadcrumb']['create']}}</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên môn học</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Phụ trách môn </label>
                        <select name="teacher_id" class="form-select">
                            <option value="0">-- Chọn giáo viên --</option>
                            @foreach($teachers as $key => $teacher)
                                <option value="{{$teacher->id}}">{{$teacher->fullname}}</option>
                            @endforeach
                        </select>
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