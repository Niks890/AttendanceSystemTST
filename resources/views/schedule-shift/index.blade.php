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
                            <a href="{{ route('schedule-shift.create') }}" class="btn btn-success me-2">
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
                                <input type="hidden" name="emp_id" value="{{ $model->emp_id }}">
                                <a href="javascript:void(0);" class="text-primary show-emp-list">Xem danh sách</a>
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
    <div class="modal fade" id="employeeDelete" tabindex="-1" aria-labelledby="employeeDeleteLabel" aria-hidden="true">
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
    </div>

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
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/message.css') }}" />
@endsection

@section('js')
    @if (Session::has('success'))
        <script src="{{ asset('js/message.js') }}"></script>
    @endif

    <script>
        $(document).ready(function() {
            $('.show-emp-list').click(function(e) {
                e.preventDefault();
                let empIds = $(this).closest('tr').find('input[name="emp_id"]').val();
                let scheduleId = $(this).closest('tr').find('td').eq(0).text();
                window.location.href = '/schedule-shift?ids=' + empIds + "&schedule_id=" + scheduleId;
            });
        });
    </script>

@endsection
@else
{{ abort(403, 'Bạn không có quyền truy cập trang này!') }}
@endcan
