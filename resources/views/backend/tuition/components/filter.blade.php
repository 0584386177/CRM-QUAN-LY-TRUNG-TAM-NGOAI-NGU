<form action="" method="GET" class="my-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <!-- Bulk actions -->
        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-outline-secondary btn-sm ms-3 me-3">
                <i class="bi bi-arrow-repeat"></i> Refresh
            </button>
            <button type="button" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>

        <!-- Search + New + Export -->
        <div class="d-flex align-items-center">
            <div class="input-group input-group-sm me-2" style="width: 220px;">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm...">
            </div>
            <a href="{{ route('course.create') }}" class="btn btn-success btn-sm me-1">
                <i class="bi bi-plus-circle"></i> New course
            </a>
            <select class="form-select form-select-sm me-2" style="width: 100px;" name="export_type" id="exportType">
                <option value="">Export</option>
                <option value="csv">CSV </option>
                <option value="pdf">PDF</option>
                <option value="xlsx">Excel </option>
            </select>
        </div>

    </div>

</form>
