<div style="border-top: 3px solid #0d6efd;" class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">{{ $config['tableHeading']['index'] }}</h3>
    </div>
    <div class="row">
        @include('backend.subject.components.filter')
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th><input type="checkbox" class="check-all"></th>
                    <th style="width: 10px">ID</th>
                    <th>Khóa học</th>
                    <th>Giáo viên giảng dạy</th>
                    <th>Học phí</th>
                    <th>Số buổi học</th>
                    <th>Số lượng học viên</th>
                    <th>Hành động </th>
                </tr>
            </thead>
            <tbody>
                @if($subjects && $subjects->count() > 0)
                    @foreach ($subjects as $key => $subject)
                        <tr>
                            <td><input type="checkbox" class="row-check"></td>
                            <td>{{ $key + 1 }}</td>

                            <td class="subject-infor name">{{ $subject->name }}</td>
                            <td class="subject-infor teacher_id">
                                {{$subject->teachers->pluck('fullname')->join(',')}}
                            </td>
                            <td>{{number_format($subject->fee, 0, '.', '.')}} đ</td>
                            <td>{{$subject->number_of_lessions}} buổi</td>
                            <td>{{$subject->students()->count()}}</td>
                            <td>
                                <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-success">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('subject.delete', $subject->id) }}" class="btn btn-danger">
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

{{ $subjects->links() }}