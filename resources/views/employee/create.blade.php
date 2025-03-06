@extends('master')
@section('title', 'Thêm Nhân viên')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg p-4">
            <h4 class="text-center text-primary mb-4">Thêm Nhân Viên</h4>
            <form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
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
                            @foreach ($departments as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
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
@endsection