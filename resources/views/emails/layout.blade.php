<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }
        .card {
            background: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
        }
        .header {
            font-size: 20px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #6c757d;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #0d6efd;
            color: #fff;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="card">
        @yield('content')

        <div class="footer">
            © {{ date('Y') }} MDA Partner · Recruitment System
        </div>
    </div>
</body>
</html>
