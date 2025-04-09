@can('managers')
    @extends('master')

    @section('title', 'Thông tin ca làm việc')

@section('content')
    @if (Session::has('success'))
        <div class="shadow-lg p-2 move-from-top js-div-dissappear" style="width: 18rem; display:flex; text-align:center">
            <i class="fas fa-check p-2 bg-success text-white rounded-circle pe-2 mx-2"></i>{{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="shadow-lg p-2 move-from-top js-div-dissappear" style="width: 18rem; display:flex; text-align:center">
            <i class="fas fa-times p-2 bg-danger text-white rounded-circle pe-2 mx-2"></i>{{ Session::get('error') }}
        </div>
    @endif
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 m-auto">Thông tin các ca làm việc</h1>
        </div>

        <div class="card shadow">
            <div class="card-sub p-3">
                <form method="GET" action="{{ route('schedule.search') }}">
                    {{-- @csrf --}}
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="input-group shadow-sm rounded">
                                <input name="query" type="text" class="form-control border-0 rounded-start"
                                    placeholder="Nhập tên ca, hoặc id ca..." />
                                <button type="submit" class="btn btn-primary text-white rounded-end">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-around align-items-center">
                            <a href="{{ route('schedule-shift.create') }}" class="btn btn-success me-2 btn-add-schedule">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>

                </form>
            </div>
            <div class="p-3">
                <table class="table table-hover table-bordered">
                    <tr class="bg-dark text-white">
                        <th class="scope">ID</th>
                        <th class="scope">Tên ca làm việc</th>
                        <th class="scope">Nhân viên làm việc</th>
                        <th class="scope">Ngày làm việc</th>
                        <th class="scope">Time in</th>
                        <th class="scope">Time out</th>
                        <th class="scope">KPI</th>
                        <th class="scope text-center">Hành động</th>
                    </tr>
                    @foreach ($data as $model)
                        <tr class="text-dark">
                            <td>{{ $model->id }}</td>
                            <td>{{ $model->sche_name }}</td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="text-primary show-emp-list"
                                    data-id="{{ $model->emp_id }}">Xem danh sách</a>
                            </td>
                            <td>{{ $model->workday }}</td>
                            <td>{{ $model->time_in }}</td>
                            <td>{{ $model->time_out }}</td>
                            <td>{{ $model->KPI }}</td>
                            <td class="text-center">
                                <a href="{{ route('export.exportExcelSchedule', $model->id) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fa fa-print"></i> In
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $model->id }}" data-name="{{ $model->sche_name }}"
                                    data-bs-toggle="modal" data-bs-target="#scheduleDelete">
                                    <i class="fa fa-trash"></i> Xóa
                                </a>


                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="d-flex justify-content-center"> {{ $data->links() }}</div>

        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Xác nhận Xóa Lịch Làm Việc -->
    <div class="modal fade" id="scheduleDelete" tabindex="-1" aria-labelledby="scheduleDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">


                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="scheduleDeleteLabel">Xác nhận xóa lịch làm việc</h5>
                    <button type="button" class="btn-close text-dark bg-danger border-0 font-weight-bold off-modal"
                        data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>


                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa lịch làm việc <strong id="schedule-name-delete"></strong> không?</p>
                    <small class="text-muted">Hành động này không thể hoàn tác.</small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary off-modal" data-bs-dismiss="modal">Hủy</button>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger ">Xóa</button>
                    </form>
                </div>

            </div>
        </div>
    </div>





    {{-- Modal Add Schedule Shift --}}
    <div class="modal fade" id="addnew">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Tạo ca làm việc</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body text-left">
                    <form class="form-horizontal" method="POST" action="">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Tên ca làm việc <i>{*}</i></label>


                            <div class="bootstrap-timepicker">
                                <input type="text" placeholder="Nhập tên ca làm việc" class="form-control timepicker"
                                    id="name" name="slug">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="time_out" class="col-sm-3 control-label text-nowrap">Ngày làm việc</label>
                            <div class="bootstrap-timepicker">
                                <input type="date" min="{{ now()->format('Y-m-d') }}"
                                    class="form-control datepicker workday" id="workday" name="workday" required>
                            </div>
                        </div>
                        <div class="form-group d-none time-in-out time-in">
                            <label for="time_in" class="col-sm-3 control-label">Giờ bắt đầu</label>
                            <div class="bootstrap-timepicker">
                                <input type="time" class="form-control timepicker" id="time_in" name="time_in"
                                    required>
                            </div>
                        </div>
                        <div class="form-group d-none time-in-out time-out">
                            <label for="time_out" class="col-sm-3 control-label">Giờ kết thúc</label>
                            <div class="bootstrap-timepicker">
                                <input type="time" class="form-control timepicker" id="time_out" name="time_out"
                                    required>
                            </div>
                        </div>
                        <div><span class="text-danger error-message"></span></div>
                        <div class="form-group">
                            <label for="time_out" class="col-sm-3 control-label">KPI</label>
                            <div class="bootstrap-timepicker">
                                <input type="number" class="form-control timepicker" id="KPI" name="KPI"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="employee_list" class="col-sm-6 control-label">Danh sách nhân viên</label>
                            <div class="bootstrap-timepicker">
                                <a href="javascript:void(0);" class="text-primary show-add-emp-list">Nạp danh sách nhân
                                    viên cho ca làm việc</a>

                                <!-- Dropdown hiển thị danh sách nhân viên đã chọn -->
                                <div class="dropdown mt-2">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="selectedEmployeeCount" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Chưa chọn nhân viên nào
                                    </button>
                                    <div class="dropdown-menu" id="selectedEmployeeDropdown"
                                        aria-labelledby="selectedEmployeeCount">
                                        <!-- Danh sách nhân viên được thêm vào đây -->
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i
                            class="fa fa-close"></i> Thoát</button>
                    <button type="submit" class="btn btn-success btn-flat" id="saveShift"><i class="fa fa-save"></i>
                        Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal xem danh sách nhân viên -->
    <div class="modal fade" id="employeeListModal" tabindex="-1" role="dialog"
        aria-labelledby="employeeListModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeListModalLabel">Danh sách nhân viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên nhân viên</th>
                                <th>Chức vụ</th>
                                <th>Phòng ban</th>
                            </tr>
                        </thead>
                        <tbody id="employeeList">
                            <!-- Danh sách nhân viên -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="employeeAddListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chọn danh sách nhân viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="employeeAddList"></table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addShift">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/message.css') }}" />
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    @if (Session::has('success') || Session::has('error'))
        <script src="{{ asset('js/message.js') }}"></script>
    @endif

    <script>
        $(document).ready(function() {
            const employeeList = @json($employeeList);
            let isShiftConflict = false;

            // console.log(employeeList);
            let selectedEmpIds = [];
            let selectedEmpNames = [];
            let availableEmployeeList = [];
            let employeeHasShift = [];

            // Modal xóa lịch
            $('.off-modal').click(() => $('#scheduleDelete').modal('hide'));
            // Xử lý xoá lịch
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                $('#scheduleDelete').modal('show');
                const scheduleId = $(this).data('id');
                const scheduleName = $(this).data('name');
                $('#schedule-name-delete').text(scheduleName);
                const url = '{{ route('schedule-shift.destroy', ':id') }}'.replace(':id', scheduleId);
                $('#delete-form').attr('action', url);
            });

            // Xem danh sách nhân viên của lịch
            $('.show-emp-list').click(function(e) {
                e.preventDefault();
                const empIds = $(this).data('id');
                const scheduleId = $(this).closest('tr').find('td').eq(0).text();

                $.post('/api/schedule-shift', {
                    listId: empIds,
                    schedule_id: scheduleId
                }, function(response) {
                    let html = '';
                    if (response.data?.length > 0) {
                        response.data.forEach((employee, index) => {
                            html +=
                                `<tr><td>${index + 1}</td><td>${employee.name}</td><td>${employee.position}</td><td>${employee.department_name}</td></tr>`;
                        });
                        $('#employeeListModalLabel').html(
                            `Danh sách nhân viên của Ca làm việc ${scheduleId}<br>Tổng: ${response.data.length}`
                        );
                    } else {
                        html =
                            `<tr><td colspan="4" class="text-center"><strong>Không có nhân viên nào!</strong></td></tr>`;
                    }
                    $('#employeeList').html(html);
                    $('#employeeListModal').modal('show');
                }).fail(xhr => {
                    console.error(xhr);
                    alert('Lỗi: ' + xhr.responseText);
                });
            });

            // Mở modal thêm lịch và reset các input
            $('.btn-add-schedule').click(e => {
                e.preventDefault();
                $('#addnew').modal('show');
                $('#name, #time_in, #time_out, #KPI').val('');
                $('.workday').val('');
            });

            // Khi chọn ngày làm việc
            $(document).on('change', '.workday', function() {
                if ($(this).val()) {
                    $('.time-in-out').removeClass('d-none');
                } else {
                    $('.time-in-out').addClass('d-none');
                }
                $('.time-in-out').trigger('change');
            });

            // Kiểm tra trùng lịch khi chọn giờ
            $(document).on('change', '.time-in-out', function() {
                const workday = $('.workday').val();
                const timeIn = $('#time_in').val();
                const timeOut = $('#time_out').val();

                if (!workday || !timeIn || !timeOut) return;

                // console.log(workday, timeIn, timeOut);

                $.post('/api/check-shift', {
                    workday,
                    time_in: timeIn,
                    time_out: timeOut,
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    // console.log("Dữ liệu từ API /api/check-shift:", response);
                    if (response.status_code === 200) {
                        $('.error-message').text(''); // ← Xoá thông báo lỗi cũ
                        isShiftConflict = false;
                        // console.log(response.message);
                        // $('.success-message').text(response.message);
                        const listEmp = employeeList;
                        // console.log("DS nhân viên: ", listEmp);
                        employeeHasShift = response.data.map(emp => emp.id.toString());
                        // console.log("DS nhân viên: ", employeeHasShift);

                        const idsArray = (listEmp[0]?.emp_ids || "").split(',');
                        const namesArray = (listEmp[0]?.emp_names || "").split(',');

                        const filteredIds = [];
                        const filteredNames = [];

                        idsArray.forEach((id, index) => {
                            if (!employeeHasShift.includes(id)) {
                                filteredIds.push(id);
                                filteredNames.push(namesArray[index]);
                            }
                        });

                        availableEmployeeList = [{
                            emp_ids: filteredIds.join(','),
                            emp_names: filteredNames.join(',')
                        }];
                    } else {
                        isShiftConflict = true;
                        $('.error-message').text(response.message);
                    }
                }).fail(xhr => {
                    console.error(xhr.responseText);
                });
            });
            // Show danh sách nhân viên
            $(document).on('click', '.show-add-emp-list', function(e) {
                e.preventDefault();
                // console.log(availableEmployeeList);

                if (!availableEmployeeList.length || availableEmployeeList[0].emp_ids === '') {
                    alert('Vui lòng chọn ngày và giờ hợp lệ trước!');
                    return;
                }

                const filteredIds = availableEmployeeList[0].emp_ids.split(',');
                const filteredNames = availableEmployeeList[0].emp_names.split(',');

                if (filteredIds.length === 0) {
                    alert('Tất cả nhân viên đã bị trùng khung giờ này!');
                    return;
                }

                let html = `
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên</th>
                    </tr>`;

                filteredIds.forEach((id, index) => {
                    html += `<tr>
                        <td><input type="checkbox" class="emp-checkbox" value="${id}"></td>
                        <td>${index + 1}</td>
                        <td>${id}</td>
                        <td>${filteredNames[index]}</td>
                    </tr>`;
                });

                $('#employeeAddList').html(html);
                $('#employeeAddListModal').modal('show');

                $('#selectAll').off('click').on('click', function() {
                    $('.emp-checkbox').prop('checked', this.checked);
                });

                $(document).off('change', '.emp-checkbox').on('change', '.emp-checkbox', function() {
                    $('#selectAll').prop('checked', $('.emp-checkbox:checked').length === $(
                        '.emp-checkbox').length);
                });

                $('#addShift').off('click').on('click', function() {
                    selectedEmpIds = [];
                    selectedEmpNames = [];

                    $('.emp-checkbox:checked').each(function() {
                        selectedEmpIds.push($(this).val());
                        selectedEmpNames.push($(this).closest('tr').find('td').eq(3)
                            .text());
                    });

                    $('#selectedEmployeeCount').text(
                        `Đã chọn ${selectedEmpNames.length} nhân viên`);
                    const dropdownList = selectedEmpNames.map((name, i) =>
                        `<a class="dropdown-item">${i + 1}. ${name}</a>`
                    ).join('');
                    $('#selectedEmployeeDropdown').html(dropdownList);

                    $('#employeeAddListModal').modal('hide');
                    $('#addnew').modal('show');
                });
            });

            // Lưu ca làm việc
            $('#saveShift').click(function() {
                const shiftName = $('#name').val();
                const timeIn = $('#time_in').val();
                const timeOut = $('#time_out').val();
                const KPI = $('#KPI').val();
                const workday = $('.workday').val();

                if (!shiftName || !timeIn || !timeOut || !workday) {
                    alert('Vui lòng điền đầy đủ thông tin!');
                    return;
                }
                if (isShiftConflict) {
                    alert('Lịch đã bị chiếm dụng! Không thể lưu.');
                    return;
                }

                // if (timeIn >= timeOut) {
                //     alert('Giờ vào phải trước giờ ra!');
                //     return;
                // }

                if (selectedEmpIds.length === 0) {
                    alert('Vui lòng chọn nhân viên trước khi lưu!');
                    return;
                }

                const overlap = selectedEmpIds.some(id => employeeHasShift.includes(id));
                if (overlap) {
                    alert('Danh sách có nhân viên đã bị trùng ca! Vui lòng chọn lại.');
                    return;
                }

                $.ajax({
                    url: '{{ route('schedule-shift.store') }}',
                    method: 'POST',
                    data: {
                        shift_name: shiftName,
                        time_in: timeIn,
                        time_out: timeOut,
                        KPI: KPI,
                        employee_ids: selectedEmpIds,
                        workday: workday,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Ca làm việc đã được lưu thành công!');
                        $('#addnew').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Đã xảy ra lỗi khi lưu ca làm việc!');
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
@else
{{ abort(403, 'Bạn không có quyền truy cập trang này!') }}
@endcan
