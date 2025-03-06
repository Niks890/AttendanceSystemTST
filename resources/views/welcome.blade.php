<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống chấm công</title>
    <link rel="stylesheet" href="css/welcome.css">
</head>
<body>
    <a href="{{route('login')}}" class="login-link">Đăng nhập</a>
    
    <div class="logo">SAMSUNG</div>
    
    <div class="title">Hệ thống chấm công</div>
    <div class="clock" id="clock"></div>
    
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
