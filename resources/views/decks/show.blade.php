@extends('layouts.app')

@section('title', $deck->title)

@section('content')

<div class="px-4 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-10 border-b border-slate-200 dark:border-slate-800/50">
        <div class="flex-grow">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-4 py-1.5 bg-indigo-50 dark:bg-indigo-600/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-100 dark:border-indigo-500/20">
                    {{ $deck->language->flag_emoji }} {{ $deck->language->name }}
                </span>
                <span class="text-slate-500 dark:text-slate-500 font-bold text-xs uppercase tracking-wider">{{ $deck->cards_count }} Thẻ học</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-2 leading-snug tracking-tighter">{{ $deck->title }}</h1>
            <p class="text-slate-500 dark:text-slate-400 max-w-2xl leading-relaxed font-normal">{{ $deck->description ?? 'Không có mô tả cho bộ thẻ này.' }}</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            @if($deck->cards_count > 0)
                <a href="{{ route('study.session', $deck) }}" 
                   class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl shadow-xl shadow-indigo-600/30 transition transform hover:-translate-y-1 active:scale-95 flex items-center gap-2">
                    ▶ <span>Học tập ngay</span>
                </a>
            @endif
            @if($deck->user_id === Auth::id())
                <a href="{{ route('decks.edit', $deck) }}" 
                   class="p-4 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl transition border border-slate-200 dark:border-slate-700" title="Chỉnh sửa bộ thẻ">
                    ✏️
                </a>
                <form action="{{ route('decks.destroy', $deck) }}" method="POST" onsubmit="return confirm('⚠️ Chú ý: Toàn bộ {{ $deck->cards_count }} thẻ bên trong sẽ bị xóa vĩnh viễn cùng bộ thẻ này. Bạn chắc chắn chứ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-4 bg-slate-100 dark:bg-slate-800 hover:bg-rose-50 dark:hover:bg-rose-600/20 hover:text-rose-600 dark:hover:text-rose-500 text-slate-600 dark:text-slate-300 rounded-2xl transition border border-slate-200 dark:border-slate-700" title="Xóa bộ thẻ">
                        🗑
                    </button>
                </form>
            @else
                <form action="{{ route('decks.clone', $deck) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-8 py-4 bg-indigo-50 dark:bg-indigo-600/10 hover:bg-indigo-600 text-indigo-600 dark:text-indigo-400 hover:text-white font-bold rounded-2xl shadow-xl transition transform hover:-translate-y-1 active:scale-95 flex items-center gap-2 border border-indigo-100 dark:border-indigo-500/20">
                        <span>📥 Lưu vào thư viện của tôi</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Cards Management --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter">Danh sách thẻ học</h2>
        @if($deck->user_id === Auth::id())
            <a href="{{ route('decks.cards.create', $deck) }}" 
               class="px-6 py-3 bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 text-slate-700 dark:text-white hover:text-white font-bold rounded-xl transition-all flex items-center gap-2 shadow-sm dark:shadow-lg border border-slate-200 dark:border-slate-700">
                <span class="text-xl">+</span> <span>Thêm thẻ mới</span>
            </a>
        @endif
    </div>

    @if($deck->cards->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-slate-50 dark:bg-slate-900 shadow-inner rounded-3xl border border-dashed border-slate-200 dark:border-slate-800">
            <div class="text-5xl mb-4 opacity-30">✨</div>
            <p class="text-slate-400 dark:text-slate-500 font-bold mb-6">Chưa có thẻ nào trong bộ sưu tập này.</p>
            @if($deck->user_id === Auth::id())
                <a href="{{ route('decks.cards.create', $deck) }}" class="text-indigo-600 dark:text-indigo-400 font-black hover:text-indigo-500 dark:hover:text-indigo-300 underline underline-offset-8 decoration-2 flex items-center gap-2 transition">
                    Tạo thẻ đầu tiên của bạn 🚀
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($deck->cards as $card)
                <div class="group relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-3xl hover:border-indigo-300 dark:hover:border-slate-600 transition-all duration-300 flex flex-col min-h-[160px] shadow-sm">
                    <div class="flex items-center justify-between mb-4 border-b border-slate-100 dark:border-slate-800/50 pb-3">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none">Thẻ #{{ $loop->iteration }}</span>
                        @if($deck->user_id === Auth::id())
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('decks.cards.edit', [$deck, $card]) }}" class="p-2 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg transition" title="Sửa">✏️</a>
                                <form action="{{ route('decks.cards.destroy', [$deck, $card]) }}" method="POST" onsubmit="return confirm('Xóa thẻ này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-rose-50 dark:hover:bg-rose-500/10 text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-500 rounded-lg transition" title="Xóa">🗑</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    
                    <div class="space-y-4 flex-grow">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-2 tracking-widest">Mặt trước</p>
                            <p class="font-black text-slate-900 dark:text-white text-lg leading-snug">{{ $card->front }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-2 tracking-widest">Mặt sau</p>
                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed font-medium">{{ $card->back }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
    <div class="mt-12 flex justify-center">
        <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-slate-300 font-bold flex items-center gap-2 text-sm transition">
            ← Quay lại Bảng điều khiển
        </a>
    </div>
</div>

@endsection
