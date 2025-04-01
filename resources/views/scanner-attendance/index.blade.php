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
            <form id="uploadJsonForm" class="d-flex align-items-center justify-content-center"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" id="jsonFile" name="json_file" class="form-control-file"
                        accept="application/json" required>
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
                            <input type="text" name="ip" class="form-control" id="scannerIp" required
                                pattern="^((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.|$)){4}$" placeholder="Ví dụ: 192.168.1.201">
                            <small class="form-text text-muted">Nhập đúng định dạng IPv4 (VD: 192.168.1.201)</small>
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

    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nạp Dữ Liệu Thành Công</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="employeeList" class="list-group"></ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>
    <script>
        lottie.loadAnimation({
            container: document.getElementById('uploadAnimation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('img/scanner-animation.json') }}'
        });

        document.getElementById('openScannerModal').addEventListener('click', function() {
            $('#scannerModal').modal('show');
        });
    </script>
    <script>
        document.getElementById('scannerForm').addEventListener('submit', function(e) {
            const ip = document.getElementById('scannerIp').value;
            const regex = /^((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.){3}(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)$/;
            if (!regex.test(ip)) {
                e.preventDefault();
                alert('Vui lòng nhập đúng định dạng IPv4!');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#uploadJsonForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('scanner-attendance.upload-json') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#employeeList').empty();
                            response.employees.forEach(emp => {
                                $('#employeeList').append(
                                    `<li class="list-group-item d-flex justify-content-between align-items-center">
                                        Nhân viên ID: ${emp.employee_id} - ${emp.time}
                                        <span class="text-success font-weight-bold">✔</span>
                                    </li>`
                                );
                            });

                            $('#successModal').modal('show');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert("Lỗi khi nạp dữ liệu!");
                    }
                });
            });
        });
    </script>
@endsection
