<div style="border-top: 3px solid #0d6efd;" class="card mb-4 px-0">
    <div class="card-header">
        <h3 class="card-title">{{ $config['tableHeading']['index'] }}</h3>
    </div>
    <div class="row">
        @include('backend.classroom.components.filter')
    </div>
    <div class="card-body p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><input type="checkbox" class="check-all"></th>
                    <th style="width: 10px">ID</th>
                    <th>Mã lớp</th>
                    <th>Khóa học</th>
                    <th>Giáo viên giảng dạy</th>
                    <th>Số lượng học viên</th>
                    <th>Hành động </th>
                </tr>
            </thead>
            <tbody>
                @if ($classes && $classes->count() > 0)
                    @foreach ($classes as $key => $class)
                        <tr>
                            <td><input type="checkbox" class="row-check"></td>
                            <td>{{ $key + 1 }}</td>
                            <td class="class-infor class">
                                {{ $class->name }}
                            </td>
                            <td class="class-infor course_id">
                                {{ $class->course->name }}
                            </td>
                            <td class="class-infor teacher_id">
                                {{-- @foreach ($class->teachers as $teacher)
                                {{ $teacher->fullname }} @if (!$loop->last), @endif
                                @endforeach --}}
                                {{-- or --}}
                                {{ $class->teachers->pluck('fullname')->join(',') }}
                            </td>
                            <td>
                                @if ($class->students->count() > 0)
                                    <span class="fw-semibold">{{ $class->students->count() }} học viên</span>
                                @else
                                    <span class="text-danger fw-semibold">Chưa có HV</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('classroom.edit', $class->id) }}" class="btn btn-success">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('classroom.delete', $class->id) }}" class="btn btn-danger">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="6" class="text-center text-danger fw-bold py-3">Không có thông tin lớp học
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
