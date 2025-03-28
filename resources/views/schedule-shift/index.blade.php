@can('managers')
    @extends('master')

    @section('title', 'Thông tin ca làm việc')

@section('content')
    @if (Session::has('success'))
        <div class="shadow-lg p-2 move-from-top js-div-dissappear" style="width: 18rem; display:flex; text-align:center">
            <i class="fas fa-check p-2 bg-success text-white rounded-circle pe-2 mx-2"></i>{{ Session::get('success') }}
        </div>
    @endif
    {{-- @if (Session::has('success'))
        <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-check'></i> Success!</h4>
            {{ Session::has('success') }}
        </div>
    @endif --}}

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
            $('.off-modal').click(function() {
                $('#scheduleDelete').modal('hide');
            });

            $('.btn-delete').click(function(e) {
                e.preventDefault();
                $('#scheduleDelete').modal('show');
                var scheduleId = $(this).data('id');
                var scheduleName = $(this).data('name');

                // Hiển thị tên lịch trong modal
                $('#schedule-name-delete').text(scheduleName);

                // Cập nhật đường dẫn xóa trong form
                var url = '{{ route('schedule-shift.destroy', ':id') }}';
                url = url.replace(':id', scheduleId);
                $('#delete-form').attr('action', url);
            });

            $('.show-emp-list').click(function(e) {
                e.preventDefault();
                let empIds = $(this).data('id');
                let scheduleId = $(this).closest('tr').find('td').eq(0).text();
                $.ajax({
                    type: 'POST',
                    url: '/api/schedule-shift',
                    data: {
                        listId: empIds,
                        schedule_id: scheduleId,
                    },
                    success: function(response) {
                        if (response.data && response.data.length > 0) {
                            let employeeList = '';
                            response.data.forEach(function(employee, index) {
                                employeeList += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${employee.name}</td>
                                    <td>${employee.position}</td>
                                    <td>${employee.department_name}</td>
                                </tr>`;
                            });
                            $('#employeeListModalLabel').html(
                                'Danh sách nhân viên của Ca làm việc ' + scheduleId +
                                '<br>Tổng nhân viên thuộc ca: ' + response.data.length
                            );
                            $('#employeeList').html(employeeList);
                        } else {
                            let employeeList = `
                            <tr>
                                <td colspan="4" class="text-center"><strong>Không có nhân viên nào!</strong></td>
                            </tr>`;
                            $('#employeeList').html(employeeList);
                        }
                        $('#employeeListModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Lỗi: ' + xhr.responseText);
                    }
                });
            });

            $('.btn-add-schedule').click(function(e) {
                e.preventDefault();
                $('#addnew').modal('show');
            });

            $('.show-add-emp-list').click(function(e) {
                e.preventDefault();
                // let add_EmpIds = $(this).data('listId');
                // console.log(add_EmpIds);
                let empList = @json($employeeList);
                // console.log(empList);
                let employeeAddList = '';
                let rowIndex = 1;
                employeeAddList += `
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>STT</th>
                                <th>ID</th>
                                <th>Tên</th>
                            </tr>
                        `;
                empList.forEach(function(employee) {
                    let empIds = employee.emp_ids ? employee.emp_ids.split(',') : [];
                    let empNames = employee.emp_names ? employee.emp_names.split(',') : [];

                    empIds.forEach((id, index) => {
                        employeeAddList += `
                                        <tr>
                                            <td><input type="checkbox" class="emp-checkbox" value="${id}"></td>
                                            <td>${rowIndex++}</td>
                                            <td>${id}</td>
                                            <td>${empNames[index]}</td>
                                        </tr>`;
                    });
                });


                $('#employeeAddList').html(employeeAddList);
                $('#employeeAddListModal').modal(
                    'show');

                // Xử lý chọn tất cả
                $('#selectAll').click(function() {
                    $('.emp-checkbox').prop('checked', this.checked);
                });

                // Xử lý chọn nhân viên riêng lẻ
                $(document).on('change', '.emp-checkbox', function() {
                    // Nếu có bất kỳ checkbox nào chưa được chọn, bỏ chọn "Chọn tất cả"
                    if ($('.emp-checkbox:checked').length !== $('.emp-checkbox').length) {
                        $('#selectAll').prop('checked', false);
                    }
                    // Nếu tất cả đều được chọn, đánh dấu "Chọn tất cả"
                    else {
                        $('#selectAll').prop('checked', true);
                    }
                });
                // Xử lý khi bấm nút thêm ca làm việc
                $('#addShift').click(function() {
                    let selectedEmpIds = [];
                    let selectedEmpNames = [];
                    $('.emp-checkbox:checked').each(function() {
                        selectedEmpIds.push($(this).val());
                        selectedEmpNames.push($(this).closest('tr').find('td').eq(3)
                            .text());
                    });

                    // Đổ dữ liệu ra modal bên ngoài
                    $('#selectedEmployeeCount').text(
                        `Đã chọn ${selectedEmpNames.length} nhân viên`);
                    let dropdownList = '';
                    selectedEmpNames.forEach((name, index) => {
                        dropdownList +=
                            `<a class="dropdown-item">${index + 1}. ${name}</a>`;
                    });

                    $('#selectedEmployeeDropdown').html(dropdownList);
                    $('#employeeAddListModal').modal('hide');
                    $('#addnew').modal('show');
                    // console.log(selectedEmpIds);

                    // Xử lý lưu vào database
                    $('#saveShift').click(function() {
                        let shiftName = $('#name').val();
                        let timeIn = $('#time_in').val();
                        let timeOut = $('#time_out').val();
                        let KPI = $('#KPI').val();
                        console.log(selectedEmpIds);


                        $.ajax({
                            url: '{{ route('schedule-shift.store') }}',
                            method: 'POST',
                            data: {
                                shift_name: shiftName,
                                time_in: timeIn,
                                time_out: timeOut,
                                KPI: KPI,
                                employee_ids: selectedEmpIds,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                alert(
                                    'Ca làm việc đã được lưu thành công!'
                                );
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

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.workday').on('change', function() {
                let workday = $(this).val();
                if (workday) {
                    $('.time-in-out').removeClass('d-none');
                } else {
                    $('.time-in-out').addClass('d-none');
                }
            });

            $('.time-in-out').on('change', function() {
                let workday = $('.workday').val();
                let timeIn = $('#time_in').val();
                let timeOut = $('#time_out').val();

                $.ajax({
                    url: '/api/check-shift',
                    method: 'POST',
                    data: {
                        workday: workday,
                        time_in: timeIn,
                        time_out: timeOut,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            let listEmp = @json($employeeList);
                            console.log(listEmp);
                            console.log(response.data);
                            // alert(response.message);

                            let employeeHasShift = response.data.map(emp => emp.id.toString());

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

                            let employeeAddListHasNoShift = [{
                                "emp_ids": filteredIds.join(','),
                                "emp_names": filteredNames.join(',')
                            }];

                            $('.show-add-emp-list').off('click').on('click', function(e) {
                                e.preventDefault();
                                let empList = employeeAddListHasNoShift;
                                let employeeAddList = `
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>STT</th>
                                <th>ID</th>
                                <th>Tên</th>
                            </tr>`;

                                empList.forEach(function(employee) {
                                    let empIds = employee.emp_ids ? employee
                                        .emp_ids.split(',') : [];
                                    let empNames = employee.emp_names ? employee
                                        .emp_names.split(',') : [];

                                    empIds.forEach((id, index) => {
                                        employeeAddList += `
                                    <tr>
                                        <td><input type="checkbox" class="emp-checkbox" value="${id}"></td>
                                        <td>${index + 1}</td>
                                        <td>${id}</td>
                                        <td>${empNames[index]}</td>
                                    </tr>`;
                                    });
                                });

                                $('#employeeAddList').html(employeeAddList);
                                $('#employeeAddListModal').modal('show');

                                $(document).off('change', '.emp-checkbox').on('change',
                                    '.emp-checkbox',
                                    function() {
                                        $('#selectAll').prop('checked', $(
                                                '.emp-checkbox:checked')
                                            .length === $('.emp-checkbox')
                                            .length);
                                    });

                                $('#selectAll').off('click').on('click', function() {
                                    $('.emp-checkbox').prop('checked', this
                                        .checked);
                                });

                                $('#addShift').off('click').on('click', function() {
                                    let selectedEmpIds = [];
                                    let selectedEmpNames = [];

                                    $('.emp-checkbox:checked').each(function() {
                                        selectedEmpIds.push($(this)
                                            .val());
                                        selectedEmpNames.push($(this)
                                            .closest('tr').find(
                                                'td').eq(3).text());
                                    });

                                    $('#selectedEmployeeCount').text(
                                        `Đã chọn ${selectedEmpNames.length} nhân viên`
                                    );
                                    $('#selectedEmployeeDropdown').html(
                                        selectedEmpNames.map((name, i) =>
                                            `<a class="dropdown-item">${i + 1}. ${name}</a>`
                                        ).join(''));

                                    $('#employeeAddListModal').modal('hide');
                                    $('#addnew').modal('show');

                                    $('#saveShift').off('click').on('click',
                                        function() {
                                            $.ajax({
                                                url: '{{ route('schedule-shift.store') }}',
                                                method: 'POST',
                                                data: {
                                                    shift_name: $(
                                                            '#name')
                                                        .val(),
                                                    time_in: $(
                                                        '#time_in'
                                                    ).val(),
                                                    time_out: $(
                                                        '#time_out'
                                                    ).val(),
                                                    KPI: $('#KPI')
                                                        .val(),
                                                    workday: $(
                                                        '.workday'
                                                    ).val(),
                                                    employee_ids: selectedEmpIds,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(
                                                    response) {
                                                    alert(
                                                        'Ca làm việc đã được lưu thành công!'
                                                    );
                                                    $('#addnew')
                                                        .modal(
                                                            'hide'
                                                        );
                                                    location
                                                        .reload();
                                                },
                                                error: function(
                                                    xhr) {
                                                    alert(
                                                        'Đã xảy ra lỗi khi lưu ca làm việc!'
                                                    );
                                                    console
                                                        .error(
                                                            xhr
                                                            .responseText
                                                        );
                                                }
                                            });
                                        });
                                });
                            });
                        } else {
                            $('.error-message').text(response.message);
                        }
                    },
                    error: function(xhr) {
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
