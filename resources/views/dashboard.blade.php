{{-- @php
    dd($percentOntime, $percentLatetime, $quantityEmployee, $quantitySchedule);
@endphp --}}
@extends('master')

@section('title', 'Dashboard')

@section('content')
    @if (Session::has('success'))
        <div class="shadow-lg p-2 move-from-top js-div-dissappear" style="width: 18rem; display:flex; text-align:center">
            <i class="fas fa-check p-2 bg-success text-white rounded-circle pe-2 mx-2"></i>{{ Session::get('success') }}
        </div>
    @endif
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Số lượng nhân viên:</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $quantityEmployee }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Số lượng ca làm việc:</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $quantitySchedule }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tỉ lệ đúng giờ
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $percentOntime }}%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="{{ $percentOntime }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tỉ lệ trễ giờ
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $percentLatetime }}%
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="{{ $percentLatetime }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-12 mb-2">
                <canvas id="attendanceChart" class="w-100 h-100" width="500" height="500"></canvas>
            </div>
            <div class="col-md-9 col-12 mt-2">
                <h5 class="text-center text-primary text-uppercase font-weight-bold">
                    Lịch làm việc của bạn hôm nay
                    @if (!empty($getScheduleOfCurrentEmployee) && isset($getScheduleOfCurrentEmployee[0]->workday))
                        <span class="text-danger">
                            ({{ \Carbon\Carbon::parse($getScheduleOfCurrentEmployee[0]->workday)->format('d-m-Y') }})
                        </span>
                    @else
                        <span class="text-danger">(Không có lịch)</span>
                    @endif
                </h5>
                <table class="table table-bordered table-hover align-middle">
                    <thead class="bg-dark text-white">
                        <tr class="text-center">
                            <th scope="col">STT</th>
                            <th scope="col">Ca làm việc</th>
                            <th scope="col">Giờ bắt đầu</th>
                            <th scope="col">Giờ kết thúc</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($getScheduleOfCurrentEmployee) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Không có lịch làm việc nào.</td>
                            </tr>
                        @else
                            @for ($i = 0; $i < count($getScheduleOfCurrentEmployee); $i++)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $getScheduleOfCurrentEmployee[$i]->name }}</td>
                                    <td>{{ $getScheduleOfCurrentEmployee[$i]->time_in }}</td>
                                    <td>{{ $getScheduleOfCurrentEmployee[$i]->time_out }}</td>
                                    <td class="text-center">
                                        <a class="btn-sm btn-primary text-decoration-none p-2 w-100 p-sm-2"
                                            href="{{ route('attendance-time.check-in') }}">
                                            <i class="fas fa-arrow-circle-right pr-1"></i><span
                                                class="d-none d-sm-inline">Đến
                                                trang
                                                điểm danh</span>
                                        </a>
                                    </td>
                                </tr>
                            @endfor
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/message.css') }}" />
@endsection

@section('js')
    @if (Session::has('success'))
        <script src="{{ asset('js/message.js') }}"></script>
    @endif
    <script src="{{ asset('js/chart.min.js') }}"></script>

    <script>
        const percentOntime = @json($percentOntime);
        const percentLatetime = @json($percentLatetime);

        const ctx = document.getElementById('attendanceChart').getContext('2d');

        const attendanceChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Đúng giờ', 'Trễ giờ'],
                datasets: [{
                    data: [percentOntime, percentLatetime],
                    backgroundColor: ['#36A2EB', '#FF6384'],
                    hoverBackgroundColor: ['#1E88E5', '#D32F2F']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
