<div style="border-top: 3px solid #0d6efd;" class="card mb-4 px-0">
    <div class="card-header">
        <h3 class="card-title">{{ $config['tableHeading']['index'] }}</h3>
    </div>
    <div class="row">
        @include('backend.course.components.filter')
    </div>
    <div class="card-body p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><input type="checkbox" class="check-all"></th>
                    <th style="width: 10px">ID</th>
                    <th>Khóa học</th>
                    <th>Giáo viên giảng dạy</th>
                    <th>Học phí</th>
                    <th>Số buổi học</th>
                    <th>Số lượng học viên</th>
                    <th>Trạng thái</th>
                    <th>Hành động </th>
                </tr>
            </thead>
            <tbody>
                @if ($courses && $courses->count() > 0)
                    @foreach ($courses as $key => $course)
                        <tr>
                            <td><input type="checkbox" class="row-check"></td>
                            <td>{{ $key + 1 }}</td>

                            <td class="course-infor name">{{ $course->name }}</td>
                            <td class="course-infor teacher_id fw-semiboldpS">
                                {{ $course->teachers->pluck('fullname')->join(',') }}
                            </td>
                            <td>
                                @if ($course->fee > 0)
                                    {{ number_format($course->fee, 0, '.', '.') . ' đ' }}
                                @else
                                    <span class="text-danger fw-semibold">Chưa cập nhật</span>
                                @endif
                            </td>
                            <td>
                                @if ($course->number_of_lessions > 0)
                                    {{ $course->number_of_lessions . ' buổi' }}
                                @else
                                    <span class="text-danger fw-semibold">Chưa cập nhật</span>
                                @endif
                            </td>
                            </td>
                            <td>
                                @if ($course->students()->count() > 0)
                                    {{ $course->students()->count() . ' học viên' }}
                                @else
                                    <span class="text-danger fw-semibold">Đang cập nhật</span>
                                @endif
                            </td>
                            @if ($course->status == 'completed')
                                <td class="{{ $course->status }} text-primary fw-semibold">Đã hoàn thành</td>
                            @elseif ($course->status == 'active')
                                <td class="{{ $course->status }} text-success fw-semibold">Đang hoạt động</td>
                            @elseif($course->status == 'pending')
                                <td class="{{ $course->status }} text-danger fw-semibold">Sắp khai giảng</td>
                            @endif
                            <td>
                                <a href="{{ route('course.edit', $course->id) }}" class="btn btn-success">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('course.delete', $course->id) }}" class="btn btn-danger">
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

{{ $courses->links() }}
