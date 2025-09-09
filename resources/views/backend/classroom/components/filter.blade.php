<form action="{{route('classroom.filter')}}" method="GET" bis_skin_checked="1" class="my-3">

    <div class="d-flex justify-content-end gap-3">
        {{-- <div class="input-group input-group-sm" style="width: 250px;" bis_skin_checked="1">
            <input type="text" name="keyword" class="form-control float-right" placeholder="Tìm kiếm giáo viên ">

        </div> --}}
        <div>
            <a href="{{route('classroom.create')}}" class="btn btn-primary">Thêm lớp học</a>
        </div>
    </div>

</form>