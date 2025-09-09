<div class="row"> {{-- <div class="col-sm-6">
        <h3 class="mb-0">{{$config['breadcrumb']['index']}}</h3>
    </div> --}} <div class="col-sm-6 mt-3">
        <ol class="breadcrumb float-sm-start">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$config['breadcrumb']['delete']}}</li>
        </ol>
    </div> @if ($errors->any())
        <div class="alert alert-danger">
            <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
    </div> @endif
</div>
<div class="card card-primary card-outline mb-4 " bis_skin_checked="1"> <!--begin::Header-->
    <div class="card-header" bis_skin_checked="1">
        <div class="card-title" bis_skin_checked="1">{{$config['breadcrumb']['delete']}}</div>
    </div> <!--end::Header--> <!--begin::Form-->
    <form method="POST" action="{{route('classroom.destroy', $classroom->id)}}"> @csrf <!--begin::Body-->
        <div class="card-body">
            <div class="row"> <!-- Cột trái -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Mã lớp học</label>
                        <input type="text" name="name" value="{{$classroom->name}}" class="form-control" readonly>

                    </div>

                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div> <!-- Checkbox ở dưới -->

</div> <!--end::Body--> <!--begin::Footer-->
<div class="card-footer" bis_skin_checked="1"> <button type="submit" class="btn btn-danger">Xóa lớp học</button>
</div>
<!--end::Footer--> </form> <!--end::Form--> </div>