@extends('master')

@section('title', 'Nạp dữ liệu chấm công')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-center">Nạp dữ liệu chấm công</h2>
        <div id="calendar"></div>
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center mt-3">
        <div id="uploadAnimation" style="width: 300px; height: 300px;"></div>
        <a href="javascript:void(0)" class="btn btn-primary mt-4" id="openScannerModal">Nạp dữ liệu</a>
        <div class="mt-5">
            <p class="text-dark font-weight-bold">Nếu không có máy quét, hãy thử:</p>
            <h4>Nạp dữ liệu từ file JSON</h4>
            <form class="d-flex align-items-center justify-content-center" action="{{ route('scanner-attendance.upload-json') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" name="json_file" class="form-control-file" required>
                    @error('json_file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Nạp dữ liệu giả (JSON)</button>
            </form>
        </div>
    </div>

    {{-- Modal nhập thông tin máy chấm công --}}
    <div class="modal fade" id="scannerModal" tabindex="-1" role="dialog" aria-labelledby="scannerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="scannerForm" method="POST" action="{{ route('scanner-attendance.upload') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nhập thông tin máy chấm công</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="scannerIp">Địa chỉ IP</label>
                            <input type="text" name="ip" class="form-control" id="scannerIp" required>
                        </div>
                        <div class="form-group">
                            <label for="scannerPort">Port</label>
                            <input type="number" name="port" class="form-control" id="scannerPort" value="4370"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Nạp dữ liệu</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>
    <script>
        // Load animation
        lottie.loadAnimation({
            container: document.getElementById('uploadAnimation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('img/scanner-animation.json') }}'
        });

        // Mở modal khi click "Nạp dữ liệu"
        document.getElementById('openScannerModal').addEventListener('click', function() {
            $('#scannerModal').modal('show');
        });
    </script>
@endsection
