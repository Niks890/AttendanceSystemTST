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
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> In</a>
        </div>

        <div class="card shadow">
            <div class="card-sub p-3">
                <form method="GET" action="{{ route('employee.search') }}">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-10">
                            <div class="input-group shadow-sm" style="position: relative;">
                                <input name="query" type="text" class="form-control border-0" placeholder="Nhập tên nhân viên..." />
                                <span class="input-group-text bg-primary text-white" style="position: absolute; top: 0; right: -3px;padding: 11px;z-index: 100;">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <a href="{{ route('employee.create') }}" class="btn btn-success w-100">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container">
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
                    <tr>
                        <td>1</td>
                        <td>none</td>
                        <td>Nguyễn Văn A</td>
                        <td>Hậu Giang</td>
                        <td>09123455</td>
                        <td>Nam</td>
                        <td>Lao công</td>
                        <td class="text-center">
                            <a class="btn btn-secondary">Sửa</a>
                            <a class="btn btn-primary">Xem</a>
                        </td>
                    </tr>
                </table>
            </div>            
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/message.css') }}" />
@endsection

@section('js')
    @if (Session::has('success'))
        <script src="{{ asset('js/message.js') }}"></script>
    @endif
@endsection