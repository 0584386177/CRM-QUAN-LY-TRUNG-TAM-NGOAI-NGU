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
                    <th>Học viên</th>
                    <th>Khóa học </th>
                    <th>Tổng học phí</th>
                    <th>Đã đóng</th>
                    <th>Còn nợ</th>
                    <th>Trạng thái</th>
                    <th>Hành động </th>
                </tr>
            </thead>
            <tbody>
                @if ($data && $data->count() > 0)
                    @foreach ($data as $key => $val)
                        <tr>
                            <td><input type="checkbox" class="row-check"></td>
                            <td>{{ $key + 1 }}</td>

                            <td class="payment-history-infor fullname">{{ $val['fullname'] }}</td>
                            <td class="payment-history-infor course">{{ $val['course'] }}</td>
                            <td>
                                {{ Helper::formatPrice((int) $val['fee']) }}
                            </td>
                            <td>
                                {{ Helper::formatPrice((int) $val['total_paid']) }}
                            </td>
                            <td>
                                {{ Helper::formatPrice((int) $val['remaining']) }}
                            </td>
                            @if ($val['fee_status'] == 'unpaid')
                                <td class="{{ $val['fee_status'] }} text-warning fw-semibold">Chưa đóng tiền</td>
                            @elseif ($val['fee_status'] == 'paid')
                                <td class="{{ $val['fee_status'] }} text-success fw-semibold">Đã đóng tiền</td>
                            @elseif($val['fee_status'] == 'partial')
                                <td class="{{ $val['fee_status'] }} text-warning fw-semibold">Còn thiếu</td>
                            @else
                                <td class="{{ $val['fee_status'] }} text-danger fw-semibold">Chưa thanh toán</td>
                            @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-info" data-bs-toggle="tooltip" title="Xem thống kê">
                                    <i class="bi bi-graph-up"></i>
                                </a>
                                <a href="#" class="btn btn-primary" data-bs-toggle="tooltip" title="Xem chi tiết">
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                                {{-- <a href="#" class="btn btn-success" data-bs-toggle="tooltip" title="Sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger" data-bs-toggle="tooltip" title="Xóa">
                                    <i class="bi bi-trash3"></i> --}}
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
