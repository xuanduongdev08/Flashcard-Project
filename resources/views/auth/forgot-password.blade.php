@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="relative min-h-[80vh] flex justify-center items-center px-4" x-data="forgotPasswordSystem()">
    <div class="w-full max-w-md glass rounded-[32px] border border-white/5 overflow-hidden shadow-2xl animate-slide-up">
        
        <div class="bg-slate-900 p-8 text-center relative border-b border-slate-800">
            <h2 class="text-3xl font-black text-white tracking-tighter mb-2" x-text="step === 1 ? 'Quên mật khẩu?' : 'Xác thực OTP'"></h2>
            <p class="text-slate-400 text-sm font-medium" x-text="step === 1 ? 'Đừng lo, chúng tôi sẽ giúp bạn khôi phục lại' : 'Nhập mã 6 số được gửi đến email của bạn'"></p>
        </div>

        <div class="p-8">
            <!-- Step 1: Nhập Email -->
            <form @submit.prevent="submitEmail" x-show="step === 1" x-transition.opacity>
                <div class="space-y-5">
                    <div class="flex flex-col gap-3">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.25em] ml-2">Email của bạn</label>
                        <input type="email" x-model="email" required placeholder="name@email.com" class="bg-slate-800/40 border border-slate-700 text-white rounded-[24px] px-8 py-0 text-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500/50 outline-none transition-all placeholder:text-slate-600 font-bold h-[72px] w-full shadow-inner">
                    </div>

                    <button type="submit" :disabled="loading" class="w-full btn-gradient py-5 rounded-2xl text-white font-black text-base transition-all transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-indigo-500/40 active:scale-95 disabled:opacity-70 flex items-center justify-center gap-3">
                        <span x-show="!loading">Gửi mã xác nhận</span>
                        <div x-show="loading" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    </button>

                    <p class="text-center text-xs font-bold text-slate-500 mt-6">
                        Nhớ mật khẩu rồi? <a href="{{ url('/') }}" class="text-indigo-400 hover:text-indigo-300 transition underline underline-offset-4">Quay lại đăng nhập</a>
                    </p>
                </div>
            </form>

            <!-- Step 2: Nhập OTP -->
            <form @submit.prevent="submitOtp" x-show="step === 2" x-cloak x-transition.opacity>
                <div class="space-y-5">
                    <div class="flex flex-col gap-3">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.25em] ml-2">Mã OTP (6 số)</label>
                        <input type="text" x-model="otp" required placeholder="123456" maxlength="6" class="bg-slate-800/40 border border-slate-700 text-white rounded-[24px] px-8 py-0 text-3xl font-black focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500/50 outline-none transition-all placeholder:text-slate-600 text-center h-[72px] w-full shadow-inner tracking-[0.5em]">
                    </div>

                    <p class="text-center text-xs text-slate-400 px-4">
                        OTP sẽ hết hạn sau <strong class="text-white">5 phút</strong>. Chưa nhận được? 
                        <button type="button" @click="submitEmail" :disabled="loading" class="text-indigo-400 hover:text-indigo-300 transition font-bold disabled:opacity-50">Gửi lại</button>
                    </p>

                    <button type="submit" :disabled="loading" class="w-full btn-gradient py-5 rounded-2xl text-white font-black text-base transition-all transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-indigo-500/40 active:scale-95 disabled:opacity-70 flex items-center justify-center gap-3 mt-4">
                        <span x-show="!loading">Xác nhận</span>
                        <div x-show="loading" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('forgotPasswordSystem', () => ({
            step: 1,
            email: '',
            otp: '',
            loading: false,

            notify(message, type) {
                window.dispatchEvent(new CustomEvent('notify', { detail: { message, type } }));
            },

            async submitEmail() {
                this.loading = true;
                try {
                    const res = await fetch("{{ route('password.email') }}", {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ email: this.email })
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.notify(data.message, 'success');
                        this.step = 2;
                    } else {
                        this.notify(data.message, 'error');
                    }
                } catch (e) {
                    this.notify("Có lỗi xảy ra, vui lòng thử lại.", 'error');
                }
                this.loading = false;
            },

            async submitOtp() {
                this.loading = true;
                try {
                    const res = await fetch("{{ route('password.verify') }}", {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ email: this.email, otp: this.otp })
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.notify("Xác thực thành công", 'success');
                        window.location.href = data.redirect;
                    } else {
                        this.notify(data.message, 'error');
                    }
                } catch (e) {
                    this.notify("Có lỗi xảy ra, vui lòng thử lại.", 'error');
                }
                this.loading = false;
            }
        }));
    });
</script>
@endpush
@endsection
