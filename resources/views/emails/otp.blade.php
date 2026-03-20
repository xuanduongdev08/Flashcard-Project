<!DOCTYPE html>
<html>
<head>
    <title>Mã OTP khôi phục mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f5;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        h2 {
            color: #4f46e5;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .otp {
            font-size: 28px;
            font-weight: bold;
            color: #ec4899;
            text-align: center;
            letter-spacing: 5px;
            padding: 15px;
            background-color: #fdf2f8;
            border: 1px dashed #fbcfe8;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Yêu cầu khôi phục mật khẩu</h2>
        <p>Chào bạn,</p>
        <p>Chúng tôi nhận được yêu cầu cài đặt lại mật khẩu cho tài khoản liên kết với địa chỉ email này.</p>
        <p>Mã xác nhận (OTP) của bạn là:</p>
        <div class="otp">{{ $otp }}</div>
        <p>Mã này có hiệu lực trong <strong>5 phút</strong>. Vui lòng không chia sẻ mã này cho bất kỳ ai. Nếu bạn không yêu cầu mã này, xin hãy bỏ qua email này.</p>
        <div class="footer">
            <p>Trân trọng,<br>Đội ngũ <strong>Flashcar</strong></p>
        </div>
    </div>
</body>
</html>
