@extends('layouts.app')

@section('title', 'Tạo bộ thẻ mới')

@section('content')

<div class="max-w-3xl mx-auto px-4 animate-fade-in pb-20">
    <div class="mb-10 flex flex-col items-center text-center">
        <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center text-4xl mb-6 shadow-2xl shadow-indigo-600/30">✨</div>
        <h1 class="text-3xl font-black text-white mb-2 leading-snug tracking-tighter">Thêm bộ sưu tập mới</h1>
        <p class="text-slate-500 font-medium">Tạo bộ học tập mới và phân loại chúng để dễ dàng theo dõi.</p>
    </div>

    <form action="{{ route('decks.store') }}" method="POST" class="bg-slate-900 shadow-2xl border border-slate-800 p-8 md:p-12 rounded-3xl space-y-8">
        @csrf

        {{-- Title --}}
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Tên bộ thẻ <span class="text-rose-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required autofocus
                   class="w-full bg-slate-800 border-2 border-slate-800 text-white p-5 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-700 font-black text-lg"
                   placeholder="Ví dụ: Từ vựng IELTS, Kanji N2...">
            @error('title') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Language --}}
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Ngôn ngữ <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="language_id" required
                            class="w-full bg-slate-800 border-2 border-slate-800 text-white p-5 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer font-bold">
                        <option value="" disabled selected>Chọn ngôn ngữ...</option>
                        @foreach($languages as $lang)
                            <option value="{{ $lang->id }}" {{ old('language_id') == $lang->id ? 'selected' : '' }}>
                                {{ $lang->flag_emoji }} {{ $lang->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('language_id') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            {{-- Color --}}
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Màu sắc bộ thẻ</label>
                <div class="flex flex-wrap gap-3">
                    @foreach(['#4F46E5', '#8B5CF6', '#EC4899', '#EF4444', '#F59E0B', '#10B981', '#06B6D4', '#6366f1'] as $color)
                        <label class="cursor-pointer">
                            <input type="radio" name="color" value="{{ $color }}" class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-xl border-4 border-transparent peer-checked:border-white transition-all transform peer-checked:scale-110 active:scale-90" style="background: {{ $color }}"></div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Mô tả (Tùy chọn)</label>
            <textarea name="description" rows="4" 
                      class="w-full bg-slate-800 border-2 border-slate-800 text-white p-5 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-600 resize-none"
                      placeholder="Ghi chú ngắn ngọn về bộ thẻ của bạn...">{{ old('description') }}</textarea>
            @error('description') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
            <button type="submit" class="w-full sm:flex-1 py-5 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl shadow-xl shadow-indigo-600/20 transition transform active:scale-95 leading-none">
                Tạo bộ thẻ mới ✨
            </button>
            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-10 py-5 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white font-bold rounded-2xl transition text-center">
                Hủy bỏ
            </a>
        </div>
    </form>
</div>

@endsection
