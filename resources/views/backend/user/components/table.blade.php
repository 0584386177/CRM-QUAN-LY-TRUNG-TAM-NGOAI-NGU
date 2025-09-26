<div style="border-top: 3px solid #0d6efd;" class="card mb-4 px-0">
    <div class="card-header">
        <h3 class="card-title">{{ $config['tableHeading']['index'] }}</h3>
    </div>
    <div class="row">
        @include('backend.user.components.filter')
    </div>
    <div class="card-body p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><input type="checkbox" class="check-all"></th>
                    <th>Hình ảnh</th>
                    <th>Họ tên</th>
                    <th>Ngày vào làm</th>
                    <th>Lớp giảng dạy</th>
                    <th>Đảm nhiệm khóa học</th>
                    <th>Số điện thoại</th>
                    <th>Tình trạng làm việc</th>
                    <th>Hành động </th>
                </tr>
            </thead>
            <tbody>
                @if($users && $users->count() > 0)
                    @foreach ($users as $key => $user)
                        <tr>
                            <td><input type="checkbox" class="row-check"></td>
                            <td class="user-infor avatar"><img width="80" height="80" src="{{asset($user->avatar)}}"
                                    alt="Avatar">
                            </td>
                            <td class="user-infor fullname">{{ $user->fullname }}</td>
                            <td class="user-infor hire_date">
                                {{$user->hire_date?->format('d-m-Y') ?? ''}}
                            </td>

                            <td class="user-infor class_id">
                                {{$user->classes->pluck('name')->join(',')}}

                            </td>


                            <td class="user-infor course_id">
                                @foreach ($user->courses as $course)
                                    <ol class="list-group list-unstyled">
                                        <li>
                                            - {{$course->name}} <br>
                                        </li>
                                    </ol>
                                @endforeach
                            </td>

                            <td class="user-infor phone">{{ $user->phone}}</td>
                            <td class="user-infor status">
                                @if ($user->status == true)

                                    <span class="text-success fw-semibold">Đang công tác</span>
                                @else
                                    <span class="text-danger fw-semibold">Đã nghỉ làm</span>

                                @endif


                            </td>
                            <td>
                                <a href="{{ route('user.profile', $user->id) }}" class="btn btn-primary">
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">
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

{{ $users->links() }}
