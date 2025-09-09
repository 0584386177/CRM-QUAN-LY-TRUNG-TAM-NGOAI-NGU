<div style="border-top: 3px solid #0d6efd;" class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">{{ $config['tableHeading']['index'] }}</h3>
    </div>
    <div class="row">
        @include('backend.student.components.filter')
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th><input type="checkbox" class="check-all"></th>
                    <th style="width: 10px">ID</th>
                    <th>Họ tên</th>
                    <th>Khóa học</th>
                    <th>Lớp học</th>
                    <th>Giáo viên đảm nhiệm </th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Hành động </th>
                </tr>
            </thead>
            <tbody>
                @if($students && $students->count() > 0)
                    @foreach ($students as $key => $student)
                        <tr>
                            <td><input type="checkbox" class="row-check"></td>
                            <td>{{ $key + 1 }}</td>

                            <td class="student-infor fullname">{{ $student->fullname }}</td>
                            <td class="student-infor subject">
                                @foreach($student->subjects as $subject)
                                    {{ $subject->name }}
                                @endforeach
                            </td>
                            <td class="student-infor class">
                                @foreach($student->classes as $class)
                                    {{ $class->name }}
                                @endforeach
                            </td>
                            <td class="student-infor teacher">
                                @foreach ($student->teachers as $teacher)
                                    {{$teacher->fullname}}
                                @endforeach
                            </td>
                            <td class="student-infor birthday">
                                {{$student->birthday}}
                            </td>
                            <td class="student-infor phone">{{ $student->phone}}</td>
                            <td>
                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-success">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('student.delete', $student->id) }}" class="btn btn-primary">
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                                <a href="{{ route('student.delete', $student->id) }}" class="btn btn-danger">
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

{{ $students->links() }}