@extends('master')
@section('title', 'Chấm công theo thời gian')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <h4 class="mb-0 text-center">Bảng Chấm Công Nhân Viên Theo Thời Gian</h4>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-bordered table-hover">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>Ngày thực hiện</th>
                                <th>Mã số nhân viên</th>
                                <th>Họ và tên</th>
                                <th>Thời gian có mặt</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Xác nhận của Phòng ban</th>
                                <th>Xác nhận của Nhân viên</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td class="text-center">{{ $attendance->attendance_date }}</td>
                                    <td class="text-center">{{ $attendance->emp_id }}</td>
                                    <td>{{ $attendance->employee->name }}</td>
                                    <td class="text-center">
                                        {{ $attendance->attendance_time }}
                                        @if ($attendance->status == 1)
                                            <span class="badge badge-success badge-pill ml-2">On Time</span>
                                        @else
                                            <span class="badge badge-danger badge-pill ml-2">Late</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $attendance->employee->schedules->first()->time_in }}</td>
                                    <td class="text-center">{{ $attendance->employee->schedules->first()->time_out }}</td>
                                    <td class="text-center"><i class="fa fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fa fa-times text-danger"></i></td>
                                    <td class="text-center">
                                        <a href="">Xem chi tiết</a>
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

@endsection
