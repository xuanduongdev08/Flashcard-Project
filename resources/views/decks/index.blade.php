@extends('layouts.app')

@section('title', 'Quản lý bộ thẻ')

@section('content')

<div class="px-4 animate-fade-in">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter mb-2 leading-snug">Danh sách quản lý</h1>
            <p class="text-slate-500 font-medium">Xem và quản lý tất cả các bộ sưu tập thẻ của bạn.</p>
        </div>
        <a href="{{ route('decks.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition transform active:scale-95">
            + Tạo bộ thẻ mới
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm dark:shadow-2xl shadow-black/5 dark:shadow-black/20">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Bộ thẻ</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest hidden sm:table-cell">Ngôn ngữ</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest text-center">Số thẻ</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest text-right">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($decks as $deck)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-10 rounded-full" style="background: {{ $deck->color }}"></div>
                                <div>
                                    <a href="{{ route('decks.show', $deck) }}" class="font-bold text-slate-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition leading-tight line-clamp-1">
                                        {{ $deck->title }}
                                    </a>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-medium mt-1 uppercase">{{ $deck->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 hidden sm:table-cell">
                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-full text-xs font-semibold text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                {{ $deck->language->flag_emoji }} {{ $deck->language->name }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="font-black text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 px-3 py-1 rounded-lg text-sm border border-indigo-100 dark:border-indigo-500/20">
                                {{ $deck->cards_count }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('study.session', $deck) }}" class="p-2.5 bg-indigo-50 dark:bg-indigo-600/10 text-indigo-600 dark:text-indigo-500 hover:bg-indigo-600 hover:text-white rounded-xl transition shadow-sm" title="Học tập">
                                    ▶
                                </a>
                                <a href="{{ route('decks.edit', $deck) }}" class="p-2.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white rounded-xl transition border border-slate-200 dark:border-slate-700" title="Sửa">
                                    ✏️
                                </a>
                                <form action="{{ route('decks.destroy', $deck) }}" method="POST" onsubmit="return confirm('Xóa bộ thẻ: {{ $deck->title }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-600/20 hover:text-rose-600 dark:hover:text-rose-500 rounded-xl transition border border-slate-200 dark:border-slate-700" title="Xóa">
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="text-4xl filter grayscale opacity-30">📚</span>
                                <p class="text-slate-500 font-bold">Chưa có bộ sưu tập nào.</p>
                                <a href="{{ route('decks.create') }}" class="text-indigo-400 font-bold hover:underline">Bắt đầu tạo ngay thôi!</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-10 flex justify-center">
        <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 font-bold rounded-xl transition text-sm border border-slate-200 dark:border-slate-700">
            ← Quay lại Bảng điều khiển
        </a>
    </div>
</div>

@endsection
