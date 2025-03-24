@extends('master')
@section('title', 'Hồ sơ cá nhân')
@section('content')
    @if (Session::has('success'))
        <div class="shadow-lg p-2 move-from-top js-div-dissappear" style="width: 18rem; display:flex; text-align:center">
            <i class="fas fa-check p-2 bg-success text-white rounded-circle pe-2 mx-2"></i>{{ Session::get('success') }}
        </div>
    @endif
    <div class="container rounded bg-white">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="{{ asset('uploads/' . $employee->avatar) }}">
                    <span class="font-weight-bold">{{ $employee->name }}</span>
                    <span class="text-black-50">{{ $employee->email }}</span>
                </div>
            </div>
            <div class="col-md-9 border-right">
                <form action="{{ route('employee.update_profile', $employee->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- @method('PUT') --}}
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $employee->name) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Email</label>
                                <input type="text" class="form-control" name="email"
                                    value="{{ old('email', $employee->email) }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Mobile Number</label>
                                <input type="text" class="form-control" name="phone"
                                    value="{{ old('phone', $employee->phone) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Address</label>
                                <input type="text" class="form-control" name="address"
                                    value="{{ old('address', $employee->address) }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ảnh đại diện:</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*"
                                    id="avatar-input">
                                @error('avatar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 preview-img-item">
                                <label class="form-label fw-semibold">Xem trước:</label>
                                <div class="border rounded shadow-sm p-2 bg-light text-center">
                                    <img id="avatar-preview" src="{{ asset('uploads/' . $employee->avatar) }}"
                                        class="img-preview rounded" width="200" height="200">
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <input class="btn btn-primary profile-button" type="submit" value="Save Profile">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('input[name="avatar"]').addEventListener('change', function(e) {
            const [file] = e.target.files
            if (file) {
                document.querySelector('.img-preview').src = URL.createObjectURL(file)
            }
        })
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/message.css') }}" />
@endsection

@section('js')
    @if (Session::has('success'))
        <script src="{{ asset('assets/js/message.js') }}"></script>
    @endif
@endsection
