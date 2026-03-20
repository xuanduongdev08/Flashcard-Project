@extends('layouts.app')

@section('title', 'Chào mừng bạn đến với Flashcar')

@section('content')
<div class="relative overflow-hidden min-h-[80vh] flex items-center px-4">
    {{-- Animated Background Glows --}}
    <div class="absolute top-0 -left-20 w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-0 -right-20 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[150px] animate-pulse-subtle"></div>

    <div class="max-w-4xl mx-auto text-center relative z-10">
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500/10 border border-indigo-500/20 rounded-full text-indigo-400 text-xs font-black tracking-widest uppercase mb-8 animate-fade-in">
            <span>🚀 TRÌNH HỌC TẬP THẾ HỆ MỚI</span>
        </div>

        {{-- Hero Text --}}
        <h1 class="text-6xl md:text-8xl font-black text-white tracking-tighter leading-[0.9] mb-8 animate-slide-up">
            Học tập không giới hạn với <span class="text-gradient">AI Voice.</span>
        </h1>
        
        <p class="text-slate-400 text-lg md:text-xl font-bold max-w-2xl mx-auto mb-12 leading-relaxed animate-fade-in" style="animation-delay: 0.2s">
            Chào mừng bạn đến với <span class="text-white">Flashcar</span> — nền tảng Flashcard hiện đại tích hợp trí tuệ nhân tạo để giúp bạn chinh phục mọi ngôn ngữ dễ dàng hơn bao giờ hết.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6 animate-fade-in" style="animation-delay: 0.4s">
            <button @click="openRegister()" class="w-full sm:w-auto px-10 py-5 btn-gradient text-lg font-black text-white rounded-[28px] shadow-2xl transition hover:scale-105 active:scale-95 flex items-center justify-center gap-3">
                Bắt đầu ngay miễn phí
                <span class="text-2xl">✨</span>
            </button>
            <button @click="openLogin()" class="w-full sm:w-auto px-10 py-5 bg-slate-800/50 hover:bg-slate-800 text-white text-lg font-bold rounded-[28px] border border-slate-700 transition active:scale-95">
                Đã có tài khoản?
            </button>
        </div>

        {{-- Stats / Trust --}}
        <div class="mt-24 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-slate-800/50 pt-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-700 animate-fade-in" style="animation-delay: 0.6s">
            <div class="flex flex-col">
                <span class="text-3xl font-black text-white mb-1">10+</span>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Ngôn ngữ</span>
            </div>
            <div class="flex flex-col">
                <span class="text-3xl font-black text-white mb-1">AI</span>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Wavenet Voice</span>
            </div>
            <div class="flex flex-col">
                <span class="text-3xl font-black text-white mb-1">Flash</span>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Giao diện nhanh</span>
            </div>
            <div class="flex flex-col">
                <span class="text-3xl font-black text-white mb-1">XP</span>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Hệ thống điểm</span>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulseSubtle {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.05); }
    }
    .animate-pulse-subtle { animation: pulseSubtle 10s infinite ease-in-out; }
</style>
@endsection
