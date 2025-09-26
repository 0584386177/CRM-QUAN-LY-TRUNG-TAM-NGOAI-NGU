<form action="{{ route('course.filter') }}" method="GET" class="my-3">

    <div class="d-flex justify-content-between align-items-center flex-wrap mt-2">
        <div class="d-flex align-items-center">
            <a href="" class="btn btn-danger btn-sm ms-3">
                <i class="bi bi-filetype-pdf"></i> Export PDF
            </a>
            <a onclick="return confirm('Vui lòng nhấn xác nhận để tải danh sách sinh viên xuống excel.')"
                {{-- {{ route('courses.export.xlsx') }} --}} href="" class="btn btn-success btn-sm ms-3">
                <i class="bi bi-filetype-csv"></i> Export EXCEL
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap my-2">
        <!-- Bulk actions -->
        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-outline-secondary btn-sm ms-3 me-3">
                <i class="bi bi-arrow-repeat"></i> Refresh
            </button>
            <select name="course_status" class="form-select form-select-sm custom-select ms-1 me-1"
                style="width:200px;">
                <option value="">Trạng thái lớp</option>
                <option value="active">Đang hoạt động</option>
                <option value="completed">Đã hoàn thành</option>
                <option value="pending">Sắp khai giảng</option>
            </select>
            <button type="submit" class="btn btn-outline-primary btn-sm ms-1">
                <i class="bi bi-funnel"></i> Lọc
            </button>
        </div>

        <!-- Search + New + Export -->
        <div class="d-flex align-items-center">
            <div class="input-group input-group-sm me-2" style="width: 300px;">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm học viên...">
                <button type="submit" class="input-group-text" id="basic-addon2"><i class="bi bi-search"></i></button>
            </div>
            <a href="{{ route('course.create') }}" class="btn btn-dark btn-sm me-3">
                <i class="bi bi-plus-circle"></i> Thêm khóa học
            </a>
        </div>
    </div>
</form>
