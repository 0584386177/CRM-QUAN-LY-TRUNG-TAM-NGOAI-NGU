@use('App\Helpers\Helper')
<div style="border-top: 3px solid #0d6efd;" class="card mb-4 px-0">
    {{-- <div class="card-header">
        <h3 class="card-title">{{ $config['tableHeading']['index'] }}</h3>
    </div> --}}
    <div class="row">
        @include('backend.tuition.components.filter')
    </div>
    <div class="card-body p-0">
        <table class="table table-hover text-nowrap">
            <thead class="thead-dark">
                <tr>
                    <th><input type="checkbox" class="check-all"></th>
                    <th style="width: 10px">ID</th>
                    <th>Khóa học</th>
                    <th>Trạng thái</th>
                    <th>Học phí</th>
                    <th>Số buổi học</th>
                    <th>Số lượng học viên</th>
                    <th>Hành động </th>
                </tr>
            </thead>
            <tbody>
                @if ($data && $data->count() > 0)
                    @foreach ($data as $key => $course)
                        <tr>
                            <td><input type="checkbox" class="row-check"></td>
                            <td>{{ $key + 1 }}</td>

                            <td class="course-infor tuition-name">{{ $course['name'] }}</td>
                            @if ($course['status'] == 'completed')
                                <td class="{{ $course['status'] }} text-primary fw-semibold">Đã hoàn thành</td>
                            @elseif ($course['status'] == 'active')
                                <td class="{{ $course['status'] }} text-success fw-semibold">Đang hoạt động</td>
                            @elseif($course['status'] == 'pending')
                                <td class="{{ $course['status'] }} text-danger fw-semibold">Sắp khai giảng</td>
                            @endif
                            <td>
                                {{ Helper::formatPrice($course['tuition']) }}
                            </td>
                            <td>
                                @if ($course['lessions'] > 0)
                                    {{ $course['lessions'] . ' buổi' }}
                                @else
                                    <span class="text-danger fw-semibold">Chưa cập nhật</span>
                                @endif
                            </td>
                            </td>
                            <td>
                                @if ($course['student_count'] > 0)
                                    <i class="bi bi-people"></i> {{ $course['student_count'] }}
                                @else
                                    <span class="text-danger fw-semibold">Đang cập nhật</span>
                                @endif
                            </td>

                            <td>
                                <a href="#" class="btn btn-info" data-bs-toggle="tooltip" title="Xem thống kê">
                                    <i class="bi bi-graph-up"></i>
                                </a>
                                <a href="#" class="btn btn-primary" data-bs-toggle="tooltip" title="Xem chi tiết">
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                                <a href="#" class="btn btn-success" data-bs-toggle="tooltip" title="Sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger" data-bs-toggle="tooltip" title="Xóa">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>




                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="6" class="text-center text-danger fw-bold py-3">Không có thông tin người dùng
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                delay: {
                    "show": 0,
                    "hide": 0
                } // hiển thị ngay lập tức
            })
        })
    });
</script>
