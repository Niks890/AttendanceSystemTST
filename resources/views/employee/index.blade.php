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
            <div class="card-sub">
                <form method="GET" class="form-inline row" action="{{ route('employee.search') }}">
                    @csrf
                    <div
                        class="col-9 navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="submit" class="btn btn-search pe-1">
                                    <i class="fa fa-search search-icon"></i>
                                </button>
                            </div>
                            <input name="query" type="text" placeholder="Nhập vào tên nhân viên..."
                                class="form-control" />
                        </div>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('employee.create') }}" type="submit" class="btn btn-success"><i
                                class="fa fa-plus"></i>Thêm mới</a>
                    </div>
                </form>
            </div>
            <table class="table table-hover">
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