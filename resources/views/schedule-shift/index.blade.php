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
                <form method="GET" action="{{ route('employee.search') }}">
                    {{-- @csrf --}}
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="input-group shadow-sm rounded">
                                <input name="query" type="text" class="form-control border-0 rounded-start"
                                    placeholder="Nhập tên nhân viên..." />
                                <button type="submit" class="btn btn-primary text-white rounded-end">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-around align-items-center">
                            <a href="{{ route('schedule-shift.create') }}" class="btn btn-success me-2 btn-add-schedule">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                            <a href="{{ route('export.excel') }}" class="btn btn-primary">
                                <i class="fas fa-download fa-sm text-white-50"></i> In danh sách
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
                            <td>{{ $model->time_in }}</td>
                            <td>{{ $model->time_out }}</td>
                            <td>{{ $model->KPI }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning btn-edit"
                                    data-id="{{ $model->id }}">
                                    <i class="fa fa-pen"></i> Sửa
                                </button>
                                <button type="button" class="btn btn-sm btn-primary btn-detail">
                                    <i class="fa fa-eye"></i> Xem chi tiết
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#employeeDelete" data-id="{{ $model->id }}"
                                    data-name="{{ $model->name }}">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Xác nhận Xóa Nhân viên -->
    {{-- <div class="modal fade" id="employeeDelete" tabindex="-1" aria-labelledby="employeeDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="employeeDeleteLabel">Xác nhận xóa nhân viên</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa nhân viên <strong id="employee-name-delete"></strong> không?</p>
                    <small class="text-muted">Hành động này không thể hoàn tác.</small>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form action="{{ route('employee.destroy', 0) }}" id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>

            </div>
        </div>
    </div> --}}

    {{-- Modal edit --}}
    {{-- <div class="modal fade" id="employeeEdit" tabindex="-1" aria-labelledby="employeeEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="employeeEditLabel">Chỉnh sửa Nhân Viên</h5>
                    <button type="button" class="btn-close border-0 bg-secondary font-weight-bold text-white"
                        data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employee.update', 0) }}" id="form-edit" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="form-label">Mã nhân viên:</label>
                            <input type="text" name="id" id="employee-edit-id" class="form-control"
                                placeholder="Nhập họ tên" required readonly>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Họ tên nhân viên:</label>
                                <input type="text" name="name" id="employee-edit-name" class="form-control"
                                    placeholder="Nhập họ tên" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Địa chỉ:</label>
                                <input type="text" name="address" id="employee-edit-address" class="form-control"
                                    placeholder="Nhập địa chỉ" required>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại:</label>
                                <input type="text" name="phone" id="employee-edit-phone" class="form-control"
                                    placeholder="Nhập số điện thoại" required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email:</label>
                                <input type="email" name="email" id="employee-edit-email" class="form-control"
                                    placeholder="Nhập email" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Giới tính:</label>
                                <select name="gender" class="form-control" id="employee-edit-gender" required>
                                    <option value="0">Nam</option>
                                    <option value="1">Nữ</option>
                                </select>
                                @error('gender')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Chức vụ:</label>
                                <select name="position" id="employee-edit-position" class="form-control" required>
                                    <option value="Nhân viên xưởng">Nhân viên xưởng</option>
                                    <option value="Nhân viên quản lý">Nhân viên quản lý</option>
                                    <option value="Nhân viên quản lý">Nhân viên sản xuất</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phòng ban:</label>
                                <select name="department_id" id="employee-edit-department" class="form-control" required>
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <!-- Input chọn ảnh -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ảnh đại diện:</label>
                                <input type="file" name="avatar" id="employee-edit-avatar" class="form-control"
                                    accept="image/*" required id="avatar-input">
                                @error('avatar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Ảnh xem trước -->
                            <div class="col-md-3 preview-img-item">
                                <label class="form-label fw-semibold">Xem trước:</label>
                                <div class="border rounded shadow-sm p-2 bg-light text-center">
                                    <img id="avatar-preview" src="{{ asset('default-avatar.png') }}"
                                        class="img-preview rounded" width="150" height="150">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <input type="submit" class="btn btn-primary px-4" value="Cập nhật">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Modal Detail --}}
    {{-- <div class="modal fade" id="employeeDetail" tabindex="-1" aria-labelledby="employeeDetailLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="employeeDetailLabel">Thông tin nhân viên: <span
                            id="employee-info"></span></h5>
                    <button type="button" class="btn-close border-0 bg-secondary font-weight-bold text-white"
                        data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Mã nhân viên:</td>
                                    <td style="width: 70%;"><span id="employee-id"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Avatar:</td>
                                    <td style="width: 70%;"><img src="" id="employee-avatar" width="50px"
                                            alt=""></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Họ tên:</td>
                                    <td style="width: 70%;"><span id="employee-name"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Email</td>
                                    <td style="width: 70%;"><span id="employee-email"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Số điện thoại:</td>
                                    <td style="width: 70%;"><span id="employee-phone"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Địa chỉ:</td>
                                    <td style="width: 70%;"><span id="employee-address"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Giới tính:</td>
                                    <td style="width: 70%;"><span id="employee-gender"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Chức vụ:</td>
                                    <td style="width: 70%;"><span id="employee-position"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Nơi làm việc:</td>
                                    <td style="width: 70%;"><span id="department-name"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Ngày tạo:</td>
                                    <td style="width: 70%;"><span id="employee-created"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start" style="width: 30%;">Ngày sửa:</td>
                                    <td style="width: 70%;"><span id="employee-updated"></span></td>
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
    </div> --}}

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
                            <label for="time_in" class="col-sm-3 control-label">Giờ bắt đầu</label>
                            <div class="bootstrap-timepicker">
                                <input type="time" class="form-control timepicker" id="time_in" name="time_in"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="time_out" class="col-sm-3 control-label">Giờ kết thúc</label>
                            <div class="bootstrap-timepicker">
                                <input type="time" class="form-control timepicker" id="time_out" name="time_out"
                                    required>
                            </div>
                        </div>
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
    @if (Session::has('success'))
        <script src="{{ asset('js/message.js') }}"></script>
    @endif

    <script>
        $(document).ready(function() {
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

@endsection
@else
{{ abort(403, 'Bạn không có quyền truy cập trang này!') }}
@endcan
