<form action="{{ route('student.filter') }}" method="GET" class="my-3">

    <div class="d-flex justify-content-between align-items-center flex-wrap mt-2">
        <div class="d-flex align-items-center">
            <a href="" class="btn btn-danger btn-sm ms-3">
                <i class="bi bi-filetype-pdf"></i> Export PDF
            </a>
            <a onclick="return confirm('Vui lòng nhấn xác nhận để tải danh sách sinh viên xuống excel.')"
                href="{{ route('students.export.xlsx') }}" class="btn btn-success btn-sm ms-3">
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
            <select name="filter_tuition" class="form-select form-select-sm custom-select ms-1 me-1"
                style="width:200px;">
                <option value="0">Lọc học phí</option>
                <option value="unpaid">Chưa thanh toán</option>
                <option value="partial">Còn thiếu</option>
                <option value="paid">Đã đóng</option>
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
            <a href="{{ route('student.create') }}" class="btn btn-dark btn-sm me-3">
                <i class="bi bi-plus-circle"></i> Thêm học viên
            </a>
        </div>
    </div>
</form>
