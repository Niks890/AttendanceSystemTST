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
