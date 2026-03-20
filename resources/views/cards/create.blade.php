@extends('layouts.app')

@section('title', 'Thêm thẻ mới')

@section('content')

@push('styles')
<style>
    .flip-card { perspective: 1500px; }
    .flip-card-inner { transform-style: preserve-3d; }
    .flip-card-front, .flip-card-back {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }
    .flip-card-back { transform: rotateY(180deg); }
    .flip-card-inner.flipped { transform: rotateY(180deg); }
</style>
@endpush

<div class="px-4 animate-fade-in pb-20">
    <div class="mb-10">
        <h1 class="text-3xl font-black text-white mb-2 leading-snug tracking-tighter">Thêm thẻ mới</h1>
        <p class="text-slate-500 font-medium">Đang thêm vào bộ thẻ: <strong class="text-white">{{ $deck->title }}</strong></p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        {{-- Form Side --}}
        <form action="{{ route('decks.cards.store', $deck) }}" method="POST" class="bg-slate-900 shadow-2xl border border-slate-800 p-8 md:p-10 rounded-3xl space-y-8">
            @csrf
            
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Mặt trước (Từ/Câu hỏi) <span class="text-rose-500">*</span></label>
                <input type="text" name="front" id="frontInput" value="{{ old('front') }}" required autofocus
                       class="w-full bg-slate-800 border-2 border-slate-800 text-white p-5 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-600 font-bold text-lg"
                       placeholder="Ví dụ: Ubiquitous, Hello, Xin chào...">
                @error('front') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Mặt sau (Nghĩa/Đáp án) <span class="text-rose-500">*</span></label>
                <textarea name="back" id="backInput" rows="5" required
                          class="w-full bg-slate-800 border-2 border-slate-800 text-white p-5 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-600 resize-none leading-relaxed"
                          placeholder="Nhập nghĩa, ví dụ hoặc đáp án chi tiết cho thẻ này...">{{ old('back') }}</textarea>
                @error('back') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 pt-4 border-t border-slate-800/50">
                <button type="submit" class="w-full sm:flex-1 py-5 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl shadow-xl shadow-indigo-600/20 transition transform active:scale-95">
                    Thêm thẻ mới ✅
                </button>
                <a href="{{ route('decks.show', $deck) }}" class="w-full sm:w-auto px-10 py-5 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white font-bold rounded-2xl transition text-center">
                    Bỏ qua
                </a>
            </div>
        </form>

        {{-- Preview Side --}}
        <div class="sticky top-28">
            <h3 class="text-sm font-black text-slate-500 mb-6 uppercase tracking-widest text-center lg:text-left">Xem trước thẻ (Live Preview)</h3>
            
            <div class="flip-card aspect-[4/2.5] max-w-lg mx-auto lg:mx-0 w-full group cursor-pointer" onclick="this.querySelector('.flip-card-inner').classList.toggle('flipped')">
                <div class="flip-card-inner relative w-full h-full shadow-2xl transition-all duration-700 rounded-3xl">
                    {{-- Front --}}
                    <div class="flip-card-front absolute inset-0 glass border-2 border-slate-800 rounded-3xl flex flex-col items-center justify-center p-12 text-center"
                         style="border-color: {{ $deck->color }}33">
                        <div class="absolute top-6 left-6 px-3 py-1 bg-slate-800/50 rounded-full text-[8px] font-black text-slate-500 uppercase tracking-widest">Mặt trước</div>
                        <p class="text-3xl font-black text-white leading-tight" id="frontPreview">Nội dung sẽ hiển thị ở đây...</p>
                        <p class="mt-8 text-[10px] text-slate-600 font-bold uppercase tracking-widest animate-pulse italic">Click để lật thẻ</p>
                    </div>

                    {{-- Back --}}
                    <div class="flip-card-back absolute inset-0 bg-slate-900 border-2 border-indigo-500/50 rounded-3xl flex flex-col items-center justify-center p-12 text-center"
                         style="border-color: {{ $deck->color }}66">
                        <div class="absolute top-6 left-6 px-3 py-1 bg-indigo-500/10 rounded-full text-[8px] font-black text-indigo-400 uppercase tracking-widest">Mặt sau</div>
                        <p class="text-lg text-slate-300 leading-relaxed font-medium" id="backPreview">Đáp án hoặc lời giải thích sẽ nằm ở đây.</p>
                    </div>
                </div>
            </div>
            
            <p class="mt-6 text-slate-600 text-xs text-center lg:text-left italic">
                * Đây là cách thẻ của bạn sẽ hiển thị trong lúc học. Hãy đảm bảo nội dung dễ đọc bạn nhé!
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const frontInput = document.getElementById('frontInput');
    const backInput = document.getElementById('backInput');
    const frontPreview = document.getElementById('frontPreview');
    const backPreview = document.getElementById('backPreview');

    frontInput.addEventListener('input', () => {
        frontPreview.innerText = frontInput.value || 'Nội dung sẽ hiển thị ở đây...';
    });

    backInput.addEventListener('input', () => {
        backPreview.innerText = backInput.value || 'Đáp án hoặc lời giải thích sẽ nằm ở đây.';
    });
</script>
@endpush

@endsection
