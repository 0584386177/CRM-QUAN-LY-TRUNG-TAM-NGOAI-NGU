<form action="{{route('user.filter')}}" method="GET" bis_skin_checked="1" class="my-3">

    <div class="d-flex justify-content-end gap-3">
        <div class="input-group input-group-sm" style="width: 250px;" bis_skin_checked="1">
            <input type="text" name="keyword" class="form-control float-right" placeholder="Tìm kiếm giáo viên ">
            {{-- <i class="bi bi-search"></i> --}}

        </div>
        <div>
            <a href="{{route('user.create')}}" class="btn btn-primary">Thêm giáo viên</a>
        </div>
    </div>

</form>