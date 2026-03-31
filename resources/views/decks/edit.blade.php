@extends('layouts.app')

@section('title', 'Chỉnh sửa bộ thẻ')

@section('content')

<div class="max-w-3xl mx-auto px-4 animate-fade-in pb-20">
    <div class="mb-10 flex flex-col items-center text-center">
        <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center text-4xl mb-6 shadow-2xl shadow-indigo-600/30">✏️</div>
        <h1 class="text-3xl font-black text-slate-900 dark:text-white mb-2 leading-snug tracking-tighter">Cập nhật thông tin bộ thẻ</h1>
        <p class="text-slate-500 font-medium">Chỉnh sửa tên, ngôn ngữ hoặc mô tả cho bộ sưu tập của bạn.</p>
    </div>

    <form action="{{ route('decks.update', $deck) }}" method="POST"
          class="bg-white dark:bg-slate-900 shadow-sm dark:shadow-2xl border border-slate-200 dark:border-slate-800 p-8 md:p-12 rounded-3xl space-y-8">
        @csrf @method('PUT')

        {{-- Title --}}
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Tên bộ thẻ <span class="text-rose-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $deck->title) }}" required autofocus
                   class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white p-5 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700 font-black text-lg"
                   placeholder="Ví dụ: Từ vựng IELTS, Kanji N2...">
            @error('title') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Language --}}
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Ngôn ngữ <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="language_id" required
                            class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white p-5 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer font-bold">
                        @foreach($languages as $lang)
                            <option value="{{ $lang->id }}" {{ old('language_id', $deck->language_id) == $lang->id ? 'selected' : '' }}>
                                {{ $lang->flag_emoji }} {{ $lang->name }}
                            </option>
                        @endforeach
                    </select>
                    {{-- Dropdown arrow --}}
                    <div class="pointer-events-none absolute inset-y-0 right-5 flex items-center">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                @error('language_id') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            {{-- Color --}}
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Màu sắc bộ thẻ</label>
                <div class="flex flex-wrap gap-3">
                    @foreach(['#4F46E5', '#8B5CF6', '#EC4899', '#EF4444', '#F59E0B', '#10B981', '#06B6D4', '#6366f1'] as $color)
                        <label class="cursor-pointer">
                            <input type="radio" name="color" value="{{ $color }}" class="hidden peer" {{ old('color', $deck->color) == $color ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-xl
                                        border-4 border-transparent
                                        peer-checked:border-slate-900 dark:peer-checked:border-white
                                        peer-checked:scale-110
                                        transition-all transform active:scale-90"
                                 style="background: {{ $color }}"></div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Mô tả (Tùy chọn)</label>
            <textarea name="description" rows="4"
                      class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white p-5 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 resize-none"
                      placeholder="Ghi chú ngắn ngọn về bộ thẻ của bạn...">{{ old('description', $deck->description) }}</textarea>
            @error('description') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4 border-t border-slate-100 dark:border-slate-800/50">
            <button type="submit" class="w-full sm:flex-1 py-5 btn-gradient font-black rounded-2xl shadow-xl shadow-indigo-600/20 transition transform active:scale-95 leading-none text-white">
                Lưu thay đổi ✅
            </button>
            <a href="{{ route('decks.show', $deck) }}" class="w-full sm:w-auto px-10 py-5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-2xl transition text-center border border-slate-200 dark:border-transparent hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white">
                Hủy bỏ
            </a>
        </div>
    </form>
</div>

@endsection
