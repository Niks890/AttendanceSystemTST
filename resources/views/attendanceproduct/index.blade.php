@php
    use Carbon\Carbon;
    // dd($attendanceData);
@endphp
@extends('master')
@section('title', 'Chấm công theo sản phẩm')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h4 class="mb-0 text-center">Bảng Chấm Công Nhân Viên Theo Sản phẩm</h4>
                <div class="card-body">
                    {{-- Bộ lọc theo ngày --}}
                    <form method="GET" action="{{ route('attendance-product.index') }}" class="mb-4">
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
                                    <th>Chức vụ</th>
                                    <th>Họ và tên</th>
                                    <th>Ca làm việc</th>
                                    <th>KPI</th>
                                    <th>Số lượng hoàn thành</th>
                                    <th>Đánh giá</th>
                                    <th>Xưởng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendanceData as $model)
                                    <tr>
                                        <td>{{ $model->date_only . ' ' . $model->time_only }}</td>
                                        <td class="text-center">{{ $model->employee_id }}</td>
                                        <td>{{ $model->position }}</td>
                                        <td>{{ $model->employee_name }}</td>
                                        <td>{{ $model->schedule_name }}</td>
                                        <td>{{ $model->KPI }}</td>
                                        <td class="text-center">{{ $model->KPI_done }}</td>
                                        <td>{!! $model->status == 0
                                            ? '<span class="text-danger">Chưa hoàn thành</span>'
                                            : '<span class="text-success">Hoàn thành</span>' !!}</td>
                                        <td>{{ $model->factory_name }}</td>
                                        <td>Xem chi tiết</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center"> {{ $attendanceData->links() }}</div>

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
                var date = $('#filter_date').val().split(' ')[0];
                window.location.href = '/export-excel-attendance-product?date=' + date;
            })
        })
    </script>
@endsection
