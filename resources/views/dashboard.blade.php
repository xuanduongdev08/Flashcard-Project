@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')

{{-- Welcome & Stats --}}
<div class="mb-12 animate-fade-in px-4">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div class="flex-grow">

            <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tighter mb-4">Chào {{ Auth::user()->name }}! 👋</h1>
            <p class="text-slate-500 dark:text-slate-400 text-base md:text-lg font-medium max-w-xl">Hôm nay là một ngày tuyệt vời để học thêm <span class="text-slate-900 dark:text-white font-bold">10 từ mới</span> và duy trì chuỗi 🔥 <span class="text-orange-500">{{ Auth::user()->streak_count }} ngày</span> của bạn.</p>
        </div>
        
        <div class="flex gap-4">
            <a href="{{ route('decks.create') }}" 
               class="inline-flex items-center gap-3 px-8 py-5 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-[24px] shadow-2xl shadow-indigo-600/30 transition-all hover:-translate-y-1 active:scale-95 text-sm">
                <span class="text-2xl">+</span> Tạo bộ thẻ mới
            </a>
        </div>
    </div>
</div>

{{-- Recently Studied Section --}}
@if($recentlyStudied->isNotEmpty())
<div class="mb-16 animate-fade-in px-4" style="animation-delay: 0.1s">
    <h2 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
        <span>Đã học gần đây</span>
        <div class="h-px flex-grow bg-slate-200 dark:bg-slate-800/50"></div>
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($recentlyStudied as $deck)
            <a href="{{ route('study.session', $deck) }}" class="group relative p-6
               bg-white dark:bg-slate-900
               border border-slate-200 dark:border-slate-800
               rounded-[32px] overflow-hidden
               hover:border-indigo-400 dark:hover:border-indigo-500/40
               hover:shadow-lg dark:hover:bg-slate-800/50
               transition-all">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                    <span class="text-4xl">📖</span>
                </div>
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 mb-3">
                        <img src="{{ $deck->language->flag_url }}" class="w-6 h-4 object-cover rounded-sm shadow-sm" alt="{{ $deck->language->name }}">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $deck->language->name }}</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">{{ $deck->title }}</h3>
                    <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $deck->cards_count }} Thẻ · Lần cuối: {{ $deck->updated_at->diffForHumans() }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- Main Actions: Search & Filter --}}
<div x-data="languageFilter()" class="mb-12 px-4 animate-fade-in relative z-[60]" style="animation-delay: 0.2s">
    <div class="flex flex-wrap gap-2 mb-6" x-cloak>
        <template x-for="langId in selected" :key="langId">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-full text-xs font-black animate-fade-in group hover:bg-indigo-500/20 transition-all cursor-default">
                <span x-text="getLangName(langId)"></span>
                <button @click="toggleLang(langId)" class="hover:text-white transition-colors p-0.5 rounded-full hover:bg-indigo-500/30">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </template>
        <button x-show="selected.length > 0" @click="clearAll()" class="text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-indigo-400 transition ml-2">Xóa tất cả ✕</button>
    </div>

    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
        <template x-for="langId in selected" :key="'h-'+langId">
            <input type="hidden" name="language[]" :value="langId">
        </template>

        <div class="relative flex-grow group">
            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition text-xl">
                🔍
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm trong bộ sưu tập của bạn..."
                   class="w-full
                          bg-white dark:bg-slate-900
                          border border-slate-200 dark:border-slate-800
                          text-slate-900 dark:text-white
                          pl-14 pr-6 py-5 rounded-[24px]
                          focus:ring-2 focus:ring-indigo-500/50 outline-none
                          transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 font-medium">
        </div>

        <div class="relative min-w-full md:min-w-[240px]" @click.away="open = false">
            <button type="button" @click="open = !open" 
                    class="w-full h-full
                           bg-white dark:bg-slate-900
                           border border-slate-200 dark:border-slate-800
                           text-slate-600 dark:text-slate-400
                           px-6 py-4 md:py-5 rounded-[24px] outline-none
                           focus:ring-2 focus:ring-indigo-500/50 transition
                           flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🌐</span>
                    <span x-text="selected.length === 0 ? 'Lọc ngôn ngữ' : `${selected.length} ngôn ngữ`"
                          class="font-bold text-sm tracking-tight text-slate-900 dark:text-white/90"></span>
                </div>
                <svg class="w-4 h-4 text-slate-400 dark:text-slate-600 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
            </button>

            <div x-show="open" x-cloak class="absolute z-[100] top-[calc(100%+8px)] left-0 w-full md:w-[320px]
                 bg-white dark:bg-slate-900
                 border border-slate-200 dark:border-slate-800
                 rounded-[28px] shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)]
                 p-3 animate-fade-in">
                <div class="relative mb-3">
                    <input type="text" x-model="search" placeholder="Nhập tên ngôn ngữ..." 
                           class="w-full
                                  bg-slate-100 dark:bg-slate-800/50
                                  border-none rounded-2xl px-10 py-3 text-sm outline-none
                                  focus:ring-2 focus:ring-indigo-500/20
                                  text-slate-900 dark:text-white
                                  placeholder:text-slate-400 dark:placeholder:text-slate-500 font-medium">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 text-sm">🔍</div>
                </div>

                <div class="max-h-[250px] overflow-y-auto scrollbar-hide space-y-1">
                    <template x-for="lang in filteredLanguages" :key="lang.id">
                        <button type="button" @click="toggleLang(lang.id)"
                                class="w-full flex items-center justify-between px-4 py-3.5 rounded-2xl
                                       hover:bg-slate-100 dark:hover:bg-slate-800 transition-all group"
                                :class="isSelected(lang.id) ? 'bg-indigo-50 dark:bg-indigo-600/10' : ''">
                            <div class="flex items-center gap-3">
                                <img :src="lang.flag_url" class="w-6 h-4 object-cover rounded-sm shadow-sm" :alt="lang.name">
                                <div class="flex flex-col items-start">
                                    <span class="text-sm font-bold"
                                          :class="isSelected(lang.id) ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-700 dark:text-slate-300'"
                                          x-text="lang.name"></span>
                                    <span class="text-[9px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-widest" x-text="`${lang.decks_count || 0} bộ thẻ`"></span>
                                </div>
                            </div>
                            <div x-show="isSelected(lang.id)" class="text-indigo-500">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-black px-10 py-5 rounded-[24px] transition-all active:scale-95 shadow-2xl shadow-indigo-900/40 text-sm tracking-wide">
            Cập nhật bộ lọc
        </button>
    </form>
</div>

<div class="flex flex-col lg:flex-row gap-10 px-4">
    {{-- Left Column: User Decks --}}
    <div class="flex-grow">
        @if($decks->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center
                        bg-slate-50 dark:bg-slate-900/50
                        border-2 border-dashed border-slate-200 dark:border-slate-800
                        rounded-[40px] animate-fade-in">
                <div class="w-24 h-24 bg-slate-200 dark:bg-slate-800 rounded-[32px] flex items-center justify-center text-5xl mb-6 shadow-inner">📚</div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-2 tracking-tight">Vẫn chưa có bộ thẻ nào</h2>
                <p class="text-slate-500 max-w-xs mb-8 font-medium">Bạn chưa có bộ sưu tập nào ở đây. Hãy bắt đầu ngay nhé!</p>
                <a href="{{ route('decks.create') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition shadow-xl shadow-indigo-600/20 active:scale-95">
                    Tạo ngay bây giờ ✨
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($decks as $deck)
                    <div class="group relative
                                bg-white dark:bg-slate-900
                                border border-slate-200 dark:border-slate-800
                                rounded-[32px] overflow-hidden
                                hover:border-indigo-400 dark:hover:border-indigo-500/50
                                transition-all duration-500 hover:-translate-y-2 animate-fade-in
                                shadow-md dark:shadow-xl dark:shadow-black/20"
                         style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <div class="h-2 w-full" style="background: {{ $deck->color }}"></div>
                        
                        <div class="p-6 md:p-8">
                            <div class="flex items-center justify-between mb-4 md:mb-6">
                                <span class="px-3 md:px-4 py-1 md:py-1.5
                                            bg-slate-100 dark:bg-slate-800
                                            rounded-full text-[9px] md:text-[10px] font-black
                                            text-slate-500 dark:text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                                <img src="{{ $deck->language->flag_url }}" class="w-4 h-2.5 object-cover rounded-sm" alt="{{ $deck->language->name }}">
                                                {{ $deck->language->name }}
                                            </span>
                                <span class="text-[9px] md:text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">{{ $deck->cards_count }} Học phần</span>
                            </div>

                            <h3 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mb-2 md:mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition tracking-tighter">{{ $deck->title }}</h3>
                            <p class="text-slate-500 text-xs md:text-sm mb-6 md:mb-8 line-clamp-2 h-10 font-medium leading-relaxed">{{ $deck->description ?? 'Bắt đầu hành trình chinh phục từ vựng mới ngay.' }}</p>

                            <div class="flex items-center gap-2 md:gap-3">
                                @if($deck->cards_count > 0)
                                    <a href="{{ route('study.session', $deck) }}" class="flex-grow btn-gradient py-3 md:py-4 rounded-xl md:rounded-2xl text-white text-[10px] md:text-xs font-black shadow-lg shadow-indigo-600/20 text-center transition active:scale-95 uppercase tracking-wider">Học ngay</a>
                                @else
                                    <a href="{{ route('decks.cards.create', $deck) }}" class="flex-grow
                                       bg-slate-100 dark:bg-slate-800
                                       hover:bg-slate-200 dark:hover:bg-slate-700
                                       text-slate-600 dark:text-slate-300
                                       py-3 md:py-4 rounded-xl md:rounded-2xl text-[10px] md:text-xs font-black text-center transition active:scale-95 uppercase tracking-wider">+ Thêm thẻ</a>
                                @endif
                                <a href="{{ route('decks.show', $deck) }}"
                                   class="w-12 h-12 md:w-14 md:h-14
                                          bg-slate-100 dark:bg-slate-800
                                          flex items-center justify-center rounded-xl md:rounded-2xl
                                          border border-slate-200 dark:border-slate-700
                                          text-slate-500 dark:text-slate-400
                                          hover:text-slate-900 dark:hover:text-white
                                          transition group-hover:bg-slate-200 dark:group-hover:bg-slate-700"
                                   title="Chi tiết">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Right Column: AI & Stats --}}
    <div class="w-full lg:w-[380px] space-y-8 animate-fade-in" style="animation-delay: 0.3s">
        {{-- AI Recommendation Card --}}
        <div class="bg-gradient-to-br from-indigo-50 to-white dark:from-indigo-900/40 dark:to-slate-900
                    border border-indigo-100 dark:border-indigo-500/20 rounded-[32px] p-6 shadow-sm dark:shadow-2xl relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all duration-700"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-indigo-600/10 dark:bg-white/10 backdrop-blur rounded-xl flex items-center justify-center text-xl">🧠</div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white tracking-tight">Gợi ý từ AI</h3>
                </div>
                
                @if($recommended->isEmpty())
                    <p class="text-slate-400 dark:text-slate-500 text-xs font-medium leading-relaxed mb-5">Chúng tôi đang phân tích lộ trình để gợi ý bộ thẻ phù hợp nhất cho bạn.</p>
                @else
                    <div class="space-y-3 mb-6">
                        @foreach($recommended as $rec)
                            <a href="{{ route('decks.show', $rec) }}" class="block p-3.5 bg-white dark:bg-white/5 border border-slate-100 dark:border-white/5 rounded-xl hover:bg-slate-50 dark:hover:bg-white/10 transition-all hover:translate-x-1 group/item shadow-sm dark:shadow-none">
                                <p class="text-[8px] font-black text-indigo-600 dark:text-indigo-400 uppercase mb-0.5 flex items-center gap-1.5">
                                    <img src="{{ $rec->language->flag_url }}" class="w-3 h-2 object-cover rounded-[1px]" alt="{{ $rec->language->name }}">
                                    {{ $rec->language->name }}
                                </p>
                                <h4 class="text-slate-900 dark:text-white font-bold text-xs mb-0.5 line-clamp-1 group-hover/item:text-indigo-600 dark:group-hover:text-indigo-300 transition-colors">{{ $rec->title }}</h4>
                                <p class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase">{{ $rec->cards_count }} THẺ</p>
                            </a>
                        @endforeach
                    </div>
                @endif
                
                <a href="{{ route('decks.index') }}" class="block w-full py-3.5 bg-indigo-600 dark:bg-white text-white dark:text-indigo-900 font-black text-[10px] rounded-xl transition hover:bg-indigo-500 dark:hover:bg-slate-100 active:scale-95 shadow-xl shadow-indigo-600/20 dark:shadow-black/20 text-center uppercase tracking-widest">
                    Khám phá cộng đồng
                </a>
            </div>
        </div>

        {{-- Goals Card --}}
        <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-[40px] p-8">
            <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6">Thành tích học tập</h3>
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-500/10 rounded-2xl flex items-center justify-center text-xl">🔥</div>
                        <div class="flex flex-col">
                            <span class="text-slate-900 dark:text-white font-black text-lg leading-none mb-1">{{ Auth::user()->streak_count }}</span>
                            <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase">Ngày liên tiếp</span>
                        </div>
                    </div>
                    <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-ping"></div>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-xl">⭐</div>
                    <div class="flex flex-col">
                        <span class="font-black text-lg leading-none mb-1 text-gradient">{{ number_format(Auth::user()->xp_points) }}</span>
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase">Tổng điểm XP</span>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Mục tiêu hằng ngày</span>
                        <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400">80%</span>
                    </div>
                    <div class="w-full h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-600 rounded-full w-[80%] shadow-[0_0_15px_rgba(79,70,229,0.4)]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function languageFilter() {
        return {
            open: false,
            search: '',
            languages: @json($languages),
            selected: @json($selectedLanguage),
            
            get filteredLanguages() {
                if (this.search === '') return this.languages;
                return this.languages.filter(l => 
                    l.name.toLowerCase().includes(this.search.toLowerCase())
                );
            },

            toggleLang(id) {
                const sid = id.toString();
                const idx = this.selected.indexOf(sid);
                if (idx > -1) this.selected.splice(idx, 1);
                else this.selected.push(sid);
            },

            isSelected(id) {
                return this.selected.includes(id.toString());
            },

            getLangName(id) {
                const lang = this.languages.find(l => l.id == id);
                return lang ? `${lang.name}` : '';
            },

            clearAll() { this.selected = []; }
        }
    }
</script>
@endpush

@endsection
