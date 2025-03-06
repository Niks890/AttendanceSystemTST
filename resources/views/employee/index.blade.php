@extends('master')

@section('title', 'Thông tin Nhân viên')

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
            <h1 class="h3 mb-0 text-gray-800">Thông tin Nhân viên</h1>
        </div>

        <div class="card shadow">
            <div class="card-sub p-3">
                <form method="GET" action="{{ route('employee.search') }}">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="input-group shadow-sm rounded">
                                <input name="query" type="text" class="form-control border-0 rounded-start" placeholder="Nhập tên nhân viên..." />
                                <button class="btn btn-primary text-white rounded-end">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-around align-items-center">
                            <a href="{{ route('employee.create') }}" class="btn btn-success me-2">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                            <a href="#" class="btn btn-primary">
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
                        <th class="scope">Avatar</th>
                        <th class="scope">Họ Tên</th>
                        <th class="scope">Địa chỉ</th>
                        <th class="scope">SĐT</th>
                        <th class="scope">Giới tính</th>
                        <th class="scope">Chức vụ</th>
                        <th class="scope text-center">Hành động</th>
                    </tr>
                    @foreach ($data as $model)
                        <tr class="text-dark">
                            <td>{{$model->id}}</td>
                            <td><img src="{{ asset('uploads/' . $model->avatar) }}" width="70px" alt=""></td>
                            <td>{{$model->name}}</td>
                            <td>{{$model->address}}</td>
                            <td>{{$model->phone}}</td>
                            <td>{{$model->gender == 0 ? 'Nam' : 'Nữ'}}</td>
                            <td>{{$model->position}}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary btn-edit">
                                    <i class="fa fa-pen"></i> Sửa
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary btn-detail">
                                    <i class="fa fa-pen"></i> Xem chi tiết
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    {{-- Modal Detail --}}
    <div class="modal fade" id="employeeDetail" tabindex="-1" aria-labelledby="employeeDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="employeeDetailLabel">Thông tin nhân viên: <span
                            id="employee-info"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
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
                                    <td style="width: 70%;"><img src="" id="employee-avatar" width="50px" alt=""></td>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>
    </div>




    {{-- Modal Edit --}}
    <div class="modal fade" id="employeeEdit" tabindex="-1" aria-labelledby="employeeEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="employeeEditLabel">Thông tin nhân viên: <span
                            id="employee-info"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="container mt-4">
                        <div class="card shadow-lg p-4">
                            <h4 class="text-center text-primary mb-4">Thêm Nhân Viên</h4>
                            <form action="{{ route('employee.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Họ tên nhân viên:</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập họ tên">
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Địa chỉ:</label>
                                        <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ">
                                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Số điện thoại:</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email:</label>
                                        <input type="email" name="email" class="form-control" placeholder="Nhập email">
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Giới tính:</label>
                                        <select name="gender" class="form-control">
                                            <option value="0">Nam</option>
                                            <option value="1">Nữ</option>
                                        </select>
                                        @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Chức vụ:</label>
                                        <select name="position" class="form-control">
                                            <option value="Nhân viên xưởng">Nhân viên xưởng</option>
                                            <option value="Nhân viên quản lý">Nhân viên quản lý</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Nơi làm việc:</label>
                                        <select name="department_id" class="form-control">
                                            {{-- @foreach ($departments as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Username:</label>
                                        <input type="text" name="username" class="form-control" placeholder="Nhập username" autocomplete="off">
                                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Password:</label>
                                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off">
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="mt-3 d-flex justify-content-between align-content-center">
                                    <div>
                                        <label class="form-label">Ảnh đại diện:</label>
                                        <input type="file" name="avatar" class="form-control">
                                        @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div>
                                        <label class="form-label">Thumpnail</label>
                                        <img src="" alt="áhdahd">
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <input type="submit" class="btn btn-primary px-4" value="Thêm nhân viên">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>

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


    
    <script>
        @if ($errors->any())
            $(document).ready(function() {
                $('#employeeDetail').addClass("open");
            })
        @endif
    </script>

<script>
    @if ($errors->any())
        $(document).ready(function() {
            $('#employeeEdit').addClass("open");
        })
    @endif
</script>

    <script>
        $(document).ready(function() {
            $(".btn-detail").click(function(event) {
                event.preventDefault();
                let row = $(this).closest("tr");
                let epmloyeeId = row.find("td:first").text().trim();
                $.ajax({
                    url: `http://127.0.0.1:8000/api/employee/${epmloyeeId}`, //url, type, datatype, success,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.status_code === 200) {
                            let employeeInfo = response.data;
                            // console.log(employeeInfo);
                            $("#employee-id").text(employeeInfo.id);
                            $("#employee-avatar").attr("src", `uploads/${employeeInfo.avatar}`);
                            $("#employee-name").text(employeeInfo.name);
                            $("#employee-email").text(employeeInfo.email);
                            $("#employee-phone").text(employeeInfo.phone);
                            $("#employee-address").text(employeeInfo.address);
                            $("#employee-position").text(employeeInfo.position);
                            $("#employee-gender").text(parseInt(employeeInfo.gender) == 0 ? "Nam" : "Nữ");
                            $("#department-name").text(employeeInfo.department.name);                         
                            $("#employee-created").text(new Date(employeeInfo.created_at)
                                .toLocaleString(
                                    'vi-VN'));
                            $("#employee-updated").text(new Date(employeeInfo.updated_at)
                                .toLocaleString('vi-VN'));
                            $("#employeeDetail").modal("show");
                        } else {
                            alert("Không thể lấy dữ liệu chi tiết!");
                        }
                    },
                    error: function() {
                        alert("Đã có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
            });
        });
    </script>
@endsection
