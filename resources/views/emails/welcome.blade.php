<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chào mừng bạn đến với Flashcar!</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #f8fafc; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: #1e293b; padding: 40px; border-radius: 24px; border: 1px solid #334155; }
        .logo { font-size: 32px; font-weight: 900; color: #6366f1; margin-bottom: 24px; text-transform: uppercase; letter-spacing: -1px; }
        h1 { font-size: 28px; font-weight: 800; color: #ffffff; margin-bottom: 16px; }
        p { font-size: 16px; line-height: 1.6; color: #94a3b8; margin-bottom: 24px; }
        .btn { display: inline-block; padding: 16px 32px; background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3); }
        .footer { margin-top: 40px; font-size: 12px; color: #475569; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">Flashcar</div>
        <h1>Chào mừng, {{ $user->name }}! 🚀</h1>
        <p>Chúc mừng bạn đã gia nhập cộng đồng Flashcar! Chúng tôi rất vui mừng khi đồng hành cùng bạn trên hành trình chinh phục những kiến thức mới.</p>
        <p>Mục tiêu hiện tại của bạn: <strong>{{ $user->learning_goal ?? 'Khám phá thế giới' }}</strong>. Hãy bắt đầu tạo những bộ thẻ đầu tiên hoặc khám phá kho tàng kiến thức từ cộng đồng nhé!</p>
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}/dashboard" class="btn">Bắt đầu học ngay</a>
        </div>
        <div class="footer">
            © {{ date('Y') }} Flashcar Team. Đam mê học tập không giới hạn.
        </div>
    </div>
</body>
</html>
