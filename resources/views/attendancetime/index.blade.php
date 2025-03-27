@php
    use Carbon\Carbon;
@endphp
@extends('master')
@section('title', 'Chấm công theo thời gian')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h4 class="mb-0 text-center">Bảng Chấm Công Nhân Viên Theo Thời Gian</h4>
                <div class="card-body">
                    {{-- Bộ lọc theo ngày --}}
                    <form method="GET" action="{{ route('attendance-time.index') }}" class="mb-4">
                        <div class="form-row align-items-center justify-content-center">
                            <div class="col-auto">
                                <input type="date" id="filter_date" name="filter_date" class="form-control"
                                    value="{{ request('filter_date') ?? now()->format('Y-m-d') }}">
                            </div>
                            <div class="col-auto">
                                <input type="submit" class="btn btn-primary" value="Lọc">
                            </div>
                            <div class="col-auto">
                                <a href="javascript:void(0)" id="export-excel" class="btn btn-success">Xuất
                                    file
                                    Excel <i class="fa fa-print"></i></a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-bordered table-hover">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th>Ca Làm</th>
                                    <th>Ngày thực hiện</th>
                                    <th>Mã số nhân viên</th>
                                    <th>Họ và tên</th>
                                    <th>Thời gian có mặt</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td class="text-center">{{ $attendance->sche_name }}</td>
                                        <td class="text-center">{{ $attendance->workday }}</td>
                                        <td class="text-center">{{ $attendance->emp_id }}</td>
                                        <td>{{ $attendance->name }}</td>
                                        <td class="text-center text-nowrap">
                                            {{ $attendance->attendance_time }}
                                            @php
                                                $time1 = Carbon::createFromFormat(
                                                    'H:i:s',
                                                    $attendance->attendance_time,
                                                );
                                                $time2 = Carbon::createFromFormat('H:i:s', $attendance->time_in);
                                                $diffInMinutes = $time1->diffInMinutes($time2);
                                                if ($diffInMinutes <= 15) {
                                                    echo '<sup><span class="badge badge-success badge-pill ml-2">On Time</span></sup>';
                                                } else {
                                                    echo '<sup><span class="badge badge-danger badge-pill ml-2">Late</span></sup>';
                                                }
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            {{ $attendance->time_in }}</td>
                                        <td class="text-center">
                                            {{ $attendance->time_out }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary btn-detail">
                                                <i class="fa fa-eye"></i> Xem chi tiết
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="attendanceTimeDetail" tabindex="-1" aria-labelledby="attendanceTimeDetailLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="attendanceTimeDetailLabel">Thông tin chấm công nhân viên: <span
                            id="employee-info"></span></h5>
                    <button type="button" class="btn-close border-0 bg-secondary font-weight-bold text-white"
                        data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-start">Ca làm:</td>
                                    <td><span id="attendance-schedule"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Ngày thực hiện:</td>
                                    <td><span id="attendance-workday"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Mã số nhân viên:</td>
                                    <td><span id="employee-id"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Họ và tên:</td>
                                    <td><span id="employee-name"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Thời gian có mặt:</td>
                                    <td><span id="attendance-time"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Time In:</td>
                                    <td><span id="time-in"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Time Out:</td>
                                    <td><span id="time-out"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Trạng thái:</td>
                                    <td><span id="attendance-status" class="badge"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary btn-close" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let modalElement = document.getElementById("attendanceTimeDetail");
            let modal = new bootstrap.Modal(modalElement);

            document.querySelectorAll(".btn-detail").forEach(button => {
                button.addEventListener("click", function() {
                    let row = this.closest("tr");
                    document.getElementById("attendance-schedule").innerText = row.cells[0]
                        .innerText;
                    document.getElementById("attendance-workday").innerText = row.cells[1]
                        .innerText;
                    document.getElementById("employee-id").innerText = row.cells[2].innerText;
                    document.getElementById("employee-name").innerText = row.cells[3].innerText;
                    document.getElementById("attendance-time").innerText = row.cells[4].innerText;
                    document.getElementById("time-in").innerText = row.cells[5].innerText;
                    document.getElementById("time-out").innerText = row.cells[6].innerText;

                    let statusElement = document.getElementById("attendance-status");
                    let statusBadge = row.cells[4].querySelector(".badge");
                    if (statusBadge) {
                        statusElement.innerText = statusBadge.innerText;
                        statusElement.className = statusBadge.className;
                    }

                    modal.show();
                });
            });

            // Đóng modal khi nhấn nút "Đóng"
            document.querySelectorAll(".btn-close").forEach(button => {
                button.addEventListener("click", function() {
                    modal.hide();
                });
            });
        });
    </script>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#export-excel').click(function(e) {
                e.preventDefault();
                var date = $('#filter_date').val();
                window.location.href = '/export-excel-attendance?date=' + date;
            })
        })
    </script>
@endsection
