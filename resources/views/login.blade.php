<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2E86C1, #A3E4D7);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .login-card h3 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
            color: #333;
        }
    </style>
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
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ghi nhớ</label>
                </div>
                <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
            </div>
            <input type="submit" class="btn btn-primary w-100 mt-3" value="Đăng nhập">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>