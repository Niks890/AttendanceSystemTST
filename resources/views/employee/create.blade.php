@extends('master')

@section('title', 'Thêm Nhân viên')

@section('content')
   
    <!-- Begin Page Content -->
    <h4 class="text-center text-dark">Thêm nhân viên</h4>
    <div class="container-fluid mt-3">
        <form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-4">
                    <label for="">Họ tên nhân viên:</label>
                    <input type="text" name="name" class="form-control" placeholder="">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="">Địa chỉ nhân viên:</label>
                    <input type="text" name="address" class="form-control" placeholder="">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="">Số điện thoại:</label>
                    <input type="text" name="phone" class="form-control" placeholder="">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                    <label for="">Giới tính:</label>
                    <select name="gender" class="form-control">
                        <option value="0">Nam</option>
                        <option value="1">Nữ</option>
                    </select>
                    @error('gender')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="">Chức vụ:</label>
                    <select name="position" class="form-control">
                        <option value="Nhân viên xưởng">Nhân viên xưởng</option>
                        <option value="Nhân viên quản lý">Nhân viên quản lý</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="">
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="">Password</label>
                    <input type="text" name="password" class="form-control" placeholder="">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="">Nơi làm việc: </label>
                    <select name="factory" class="form-control">
                        <option value="1">Phòng Nhân Sự</option>
                        <option value="2">Xưởng Sản Xuất</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label for="">Avatar</label>
                    <input type="file" name="avatar" class="form-control" placeholder="">
                    @error('avatar')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </form>
    </div>
@endsection

