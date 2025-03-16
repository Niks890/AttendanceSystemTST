<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/login-form.css')}}">
</head>
<body>
    <div class="login-card">
        <h3>Đăng nhập</h3>
        <form action="{{route('post.login')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ghi nhớ</label>
                </div>
                <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
            </div>
            <input type="submit" class="btn btn-primary w-100 mt-3" value="Đăng nhập">
            <a href="{{url('/')}}" class="d-flex justify-content-center align-items-center mt-2 text-center">Về trang chủ</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
