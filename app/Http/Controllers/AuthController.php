<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AuthController extends Controller
{
    /**
     * Handle AJAX Login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'redirect' => route('dashboard'),
                'message' => 'Chào mừng bạn quay trở lại! 👋'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Thông tin đăng nhập không chính xác.'
        ], 422);
    }

    /**
     * Handle AJAX Registration.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:12|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'learning_goal' => $request->learning_goal ?? 'English',
        ]);

        Auth::login($user);

        // Send Welcome Mail (Optional: wrap in try-catch to avoid blocking registration)
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            // Silently fail if mailer is not configured yet
        }

        return response()->json([
            'success' => true,
            'redirect' => route('dashboard'),
            'message' => 'Đăng ký thành công! Hãy bắt đầu học tập nào. ✨',
            'needs_onboarding' => true
        ]);
    }

    /**
     * Handle Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Google OAuth - Redirect.
     */
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Google OAuth - Callback.
     */
    public function googleCallback()
    {
        try {
            // Tắt xác thực SSL để sửa lỗi cURL 60 + bật stateless sửa lỗi Mismatch Session trên Local
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->stateless()
                ->user();
            
            \Illuminate\Support\Facades\Log::info('Google trả về user thành công: ' . $googleUser->email);
            
            // Tự động kiểm tra và thêm cột nếu bạn chưa chạy lệnh migrate đầy đủ
            if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'provider_id')) {
                \Illuminate\Support\Facades\Schema::table('users', function ($table) {
                    $table->string('provider_id')->nullable();
                    $table->string('avatar')->nullable();
                    $table->string('learning_goal')->nullable();
                    $table->integer('xp_points')->default(0);
                    $table->integer('streak_count')->default(0);
                    $table->timestamp('last_study_at')->nullable();
                });
            }

            $user = User::updateOrCreate([
                'email' => $googleUser->email,
            ], [
                'name' => $googleUser->name,
                'avatar' => $googleUser->avatar,
                'provider_id' => $googleUser->id,
                'password' => Hash::make(Str::random(16)), // Dummy password
            ]);

            $isNewUser = !$user->exists || $user->wasRecentlyCreated;
            Auth::login($user);
            
            // Ép buộc Laravel tạo mới và lưu cứng Session này!
            request()->session()->regenerate();

            if ($isNewUser) {
                try {
                    Mail::to($user->email)->send(new WelcomeMail($user));
                } catch (\Exception $e) {}
            }

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Lỗi Google chi tiết: ' . $e->getMessage());
        }
    }

    /**
     * Update Learning Goal (Onboarding).
     */
    public function updateGoal(Request $request)
    {
        $request->validate([
            'learning_goal' => 'required|string'
        ]);

        $user = Auth::user();
        $user->update(['learning_goal' => $request->learning_goal]);

        return response()->json(['success' => true]);
    }

    /**
     * Get Password Reset Table dynamically and auto-create if missing
     */
    protected function getPasswordResetTable()
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('password_reset_tokens')) {
            return 'password_reset_tokens';
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('password_resets')) {
            return 'password_resets';
        }
        
        \Illuminate\Support\Facades\Schema::create('password_reset_tokens', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        
        return 'password_reset_tokens';
    }

    /**
     * Show Forgot Password Form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send OTP to Email
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email không tồn tại trong hệ thống.'], 404);
        }

        $otp = random_int(100000, 999999);
        
        DB::table($this->getPasswordResetTable())->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($otp),
                'created_at' => Carbon::now()
            ]
        );

        try {
            Mail::to($request->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi gửi email. Vui lòng thử lại sau.'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Mã OTP đã được gửi đến email của bạn.']);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric'
        ]);

        $reset = DB::table($this->getPasswordResetTable())->where('email', $request->email)->first();

        if (!$reset) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy yêu cầu đặt lại mật khẩu.'], 400);
        }

        if (Carbon::parse($reset->created_at)->addMinutes(5)->isPast()) {
            return response()->json(['success' => false, 'message' => 'Mã OTP đã hết hạn.'], 400);
        }

        if (!Hash::check($request->otp, $reset->token)) {
            return response()->json(['success' => false, 'message' => 'Mã OTP không chính xác.'], 400);
        }

        // Save session flag for resetting password
        session(['reset_email' => $request->email, 'reset_otp_verified' => true]);

        return response()->json(['success' => true, 'redirect' => route('password.reset')]);
    }

    /**
     * Show Reset Password Form
     */
    public function showResetPassword()
    {
        if (!session('reset_otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    /**
     * Update New Password
     */
    public function resetPassword(Request $request)
    {
        if (!session('reset_otp_verified') || !session('reset_email')) {
            return response()->json(['success' => false, 'message' => 'Phiên đã hết hạn. Vui lòng thử lại.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|max:12|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $email = session('reset_email');
        $user = User::where('email', $email)->first();
        
        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        DB::table($this->getPasswordResetTable())->where('email', $email)->delete();
        session()->forget(['reset_email', 'reset_otp_verified']);

        return response()->json([
            'success' => true, 
            'redirect' => url('/'), 
            'message' => 'Khôi phục mật khẩu thành công! Hãy đăng nhập.'
        ]);
    }
}
