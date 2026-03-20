@extends('layouts.app')

@section('title', 'Tạo mật khẩu mới')

@section('content')
<div class="relative min-h-[80vh] flex justify-center items-center px-4" x-data="resetPasswordSystem()">
    <div class="w-full max-w-md glass rounded-[32px] border border-white/5 overflow-hidden shadow-2xl animate-slide-up">
        
        <div class="bg-slate-900 p-8 text-center relative border-b border-slate-800">
            <h2 class="text-3xl font-black text-white tracking-tighter mb-2">Tạo mật khẩu mới</h2>
            <p class="text-slate-400 text-sm font-medium">Bạn nên sử dụng mật khẩu mạnh có chứa chữ và số</p>
        </div>

        <div class="p-8">
            <form @submit.prevent="submitReset">
                <div class="space-y-5">
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between items-center px-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.25em]">Mật khẩu mới</label>
                            <button type="button" @click="showPass = !showPass" class="text-[11px] font-black text-indigo-400 hover:text-indigo-300 tracking-[0.25em] transition-all px-2 py-1 bg-indigo-500/10 rounded-lg border border-indigo-500/20" x-text="showPass ? 'BẢO MẬT' : 'HIỂN THỊ'"></button>
                        </div>
                        <input :type="showPass ? 'text' : 'password'" x-model="password" required placeholder="••••••••" class="bg-slate-800/40 border border-slate-700 text-white rounded-[24px] px-8 py-0 text-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500/50 outline-none transition-all placeholder:text-slate-600 font-bold h-[72px] w-full shadow-inner">
                    </div>

                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between items-center px-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.25em]">Xác nhận mật khẩu</label>
                        </div>
                        <input :type="showPass ? 'text' : 'password'" x-model="password_confirmation" required placeholder="••••••••" class="bg-slate-800/40 border border-slate-700 text-white rounded-[24px] px-8 py-0 text-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500/50 outline-none transition-all placeholder:text-slate-600 font-bold h-[72px] w-full shadow-inner">
                    </div>

                    <button type="submit" :disabled="loading" class="w-full btn-gradient py-5 rounded-2xl text-white font-black text-base transition-all transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-indigo-500/40 active:scale-95 disabled:opacity-70 flex items-center justify-center gap-3">
                        <span x-show="!loading">Khôi phục mật khẩu</span>
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
        Alpine.data('resetPasswordSystem', () => ({
            password: '',
            password_confirmation: '',
            showPass: false,
            loading: false,

            notify(message, type) {
                window.dispatchEvent(new CustomEvent('notify', { detail: { message, type } }));
            },

            async submitReset() {
                if (this.password !== this.password_confirmation) {
                    this.notify("Mật khẩu xác nhận không khớp.", 'error');
                    return;
                }

                this.loading = true;
                try {
                    const res = await fetch("{{ route('password.update') }}", {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ 
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        })
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.notify(data.message, 'success');
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {
                        const errorMsg = data.errors ? Object.values(data.errors).flat().join(' ') : data.message;
                        this.notify(errorMsg, 'error');
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
