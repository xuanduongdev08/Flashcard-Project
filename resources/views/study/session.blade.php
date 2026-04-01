@extends('layouts.app')

@section('title', 'Đang học: ' . $deck->title)

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

@section('content')

<div class="max-w-4xl mx-auto px-4 mt-10 animate-fade-in" x-data="studySession()" @keydown.window="handleKeydown($event)">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('decks.show', $deck) }}"
           class="text-slate-500 dark:text-slate-500 hover:text-slate-900 dark:hover:text-white transition flex items-center gap-2 text-sm font-bold">
            ✕ <span>Thoát và Lưu</span>
        </a>
        <div class="flex flex-col items-center">
            <h1 class="text-slate-900 dark:text-white font-black tracking-tighter leading-none mb-1 text-2xl">{{ $deck->title }}</h1>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-[0.2em]">Tiến độ: <span x-text="Math.min(index + 1, cards.length)" class="text-indigo-600 dark:text-indigo-400"></span> / <span x-text="cards.length"></span></p>
        </div>
        <div class="w-20"></div> {{-- Spacer --}}
    </div>

    {{-- Progress Bar --}}
    <div class="w-full h-1.5
                bg-slate-200 dark:bg-slate-900
                rounded-full mb-12 overflow-hidden
                border border-slate-300 dark:border-slate-800">
        <div class="h-full bg-indigo-500 shadow-[0_0_15px_rgba(99,102,241,0.5)] transition-all duration-500"
             :style="`width: ${((index + (completed ? 1 : 0)) / cards.length) * 100}%`"></div>
    </div>

    {{-- Card Display --}}
    <div x-show="!completed" x-cloak>
        <div class="relative min-h-[350px] md:min-h-[450px]">
            <div class="flip-card aspect-[4/3] sm:aspect-[4/2.5] w-full group cursor-pointer" @click="flipped = !flipped">
                <div class="flip-card-inner relative w-full h-full shadow-2xl transition-all duration-700 rounded-[40px]" :class="{ 'flipped': flipped }">
                    {{-- Front --}}
                    <div class="flip-card-front absolute inset-0 glass border-2 rounded-[32px] md:rounded-[40px] flex flex-col items-center justify-center p-6 md:p-12 text-center"
                         style="border-color: {{ $deck->color }}44">
                        {{-- Badge --}}
                        <div class="absolute top-6 left-6 md:top-10 md:left-10
                                    px-3 md:px-4 py-1 md:py-1.5
                                    bg-slate-100 dark:bg-slate-800
                                    rounded-full text-[9px] md:text-[10px] font-black
                                    text-slate-500 uppercase tracking-widest
                                    border border-slate-200 dark:border-slate-700">Mặt trước</div>

                        {{-- AI Play Button --}}
                        <div class="mb-6 md:mb-10">
                            <button @click.stop="playAudio()"
                                    class="w-16 h-16 md:w-24 md:h-24
                                           bg-violet-600 hover:bg-violet-500
                                           dark:bg-indigo-600 dark:hover:bg-indigo-500
                                           rounded-2xl md:rounded-[32px] flex items-center justify-center
                                           shadow-2xl shadow-violet-600/30 dark:shadow-indigo-600/30
                                           transition-all transform hover:scale-110 active:scale-90"
                                    title="Phát âm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-12 md:w-12 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H3a1 1 0 01-1-1V8a1 1 0 011-1h1.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-3.071 7.071 1 1 0 11-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.983 5.983 0 01-1.757 4.243 1 1 0 11-1.415-1.415A3.984 3.984 0 0013 10a3.984 3.984 0 00-1.172-2.828a1 1 0 010-1.415z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        {{-- Front word --}}
                        <p class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white leading-tight tracking-tighter"
                           x-text="currentCard.front"></p>
                        <audio x-ref="audioPlayer" :src="currentCard.audio_url"></audio>
                        <div class="absolute bottom-12 text-[10px]
                                    text-slate-400 dark:text-slate-500
                                    font-bold uppercase tracking-[0.3em] animate-pulse">Nhấn Cách để lật thẻ</div>
                    </div>

                    {{-- Back --}}
                    <div class="flip-card-back absolute inset-0
                                bg-white dark:bg-slate-900
                                border-2 rounded-[32px] md:rounded-[40px]
                                flex flex-col items-center justify-center p-6 md:p-12 text-center
                                shadow-inner"
                         style="border-color: {{ $deck->color }}88">
                        <div class="absolute top-6 left-6 md:top-10 md:left-10
                                    px-3 md:px-4 py-1 md:py-1.5
                                    bg-indigo-50 dark:bg-indigo-500/10
                                    rounded-full text-[9px] md:text-[10px] font-black
                                    text-indigo-600 dark:text-indigo-400
                                    uppercase tracking-widest
                                    border border-indigo-200 dark:border-indigo-500/20">Mặt sau</div>
                        <p class="text-xl sm:text-2xl md:text-3xl text-slate-800 dark:text-slate-200 leading-relaxed font-semibold max-w-lg"
                           x-text="currentCard.back"></p>
                    </div>
                </div>
            </div>

            {{-- Study Actions --}}
            <div class="flex items-center justify-center gap-6 md:gap-10 mt-8 md:mt-16 transition-all duration-300"
                 :class="flipped ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                <button @click="next(false)" class="group flex flex-col items-center gap-3 md:gap-4">
                    <div class="w-12 h-12 md:w-16 md:h-16
                                bg-slate-100 dark:bg-slate-800
                                hover:bg-rose-50 dark:hover:bg-rose-500/20
                                border border-slate-200 dark:border-slate-700
                                hover:border-rose-400 dark:hover:border-rose-500
                                rounded-2xl md:rounded-3xl flex items-center justify-center text-2xl md:text-3xl
                                transition-all group-active:scale-90">👎</div>
                    <span class="text-[8px] md:text-[10px] font-black
                                text-slate-400 dark:text-slate-500
                                uppercase tracking-widest
                                group-hover:text-rose-500 transition">Cần ôn (A)</span>
                </button>
                <div class="w-px h-12 md:h-16 bg-slate-200 dark:bg-slate-800"></div>
                <button @click="next(true)" class="group flex flex-col items-center gap-3 md:gap-4">
                    <div class="w-16 h-16 md:w-24 md:h-24 bg-indigo-600 hover:bg-indigo-500 rounded-2xl md:rounded-[32px] flex items-center justify-center text-3xl md:text-5xl shadow-2xl shadow-indigo-600/30 transition-all group-active:scale-95">👍</div>
                    <span class="text-[8px] md:text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest group-hover:text-indigo-500 dark:group-hover:text-indigo-300 transition">Thuộc (D)</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Completion Screen --}}
    <div x-show="completed" x-cloak class="text-center py-10 animate-fade-in">
        <div class="relative inline-block mb-10">
            <div class="w-40 h-40 bg-gradient-to-tr from-indigo-600 to-violet-600 rounded-[48px] flex items-center justify-center text-7xl shadow-3xl transform rotate-6 animate-bounce">🏆</div>
            <div class="absolute -top-4 -right-4 bg-emerald-500 text-white w-14 h-14 rounded-full flex items-center justify-center font-black text-xl
                        border-4 border-slate-50 dark:border-slate-900 shadow-xl"
                 x-text="`+${earnedXp}`"></div>
        </div>

        <h2 class="text-5xl font-black text-slate-900 dark:text-white mb-4 tracking-tighter">Tuyệt vời!</h2>
        <p class="text-slate-500 dark:text-slate-400 text-lg mb-12 leading-relaxed">
            Bạn đã chinh phục <strong class="text-slate-900 dark:text-white">{{ $deck->title }}</strong>.<br>
            Bạn nhận được <span class="text-indigo-600 dark:text-indigo-400 font-black" x-text="earnedXp"></span> XP.
            Streak hiện tại: <span class="text-orange-500 font-bold" x-text="currentStreak">🔥</span>
        </p>

        <div class="grid grid-cols-2 gap-6 max-w-md mx-auto mb-16">
            <div class="bg-indigo-50 dark:bg-indigo-500/5 border border-indigo-200 dark:border-indigo-500/10 p-8 rounded-[32px] transition hover:bg-indigo-100 dark:hover:bg-indigo-500/10 active:scale-95 cursor-default">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-3 tracking-widest">Đã thuộc</p>
                <p class="text-5xl font-black text-indigo-600 dark:text-indigo-400" x-text="knownCount"></p>
            </div>
            <div class="bg-rose-50 dark:bg-rose-500/5 border border-rose-200 dark:border-rose-500/10 p-8 rounded-[32px] transition hover:bg-rose-100 dark:hover:bg-rose-500/10 active:scale-95 cursor-default">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-3 tracking-widest">Cần ôn lại</p>
                <p class="text-5xl font-black text-rose-500 dark:text-rose-400" x-text="reviewCount"></p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <button @click="resetSession()"
                    class="w-full sm:w-auto px-12 py-5 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-3xl transition shadow-2xl shadow-indigo-600/30 active:scale-95 text-lg">
                Học lại lần nữa 🔄
            </button>
            <a href="{{ route('dashboard') }}"
               class="w-full sm:w-auto px-12 py-5
                      bg-slate-100 dark:bg-slate-800
                      hover:bg-slate-200 dark:hover:bg-slate-700
                      text-slate-700 dark:text-white
                      font-black rounded-3xl transition
                      border border-slate-200 dark:border-slate-700
                      active:scale-95 text-lg">
                Về Trang chủ 🏠
            </a>
        </div>
    </div>

    {{-- Shortcuts --}}
    <div class="mt-20 flex flex-wrap justify-center gap-8
                text-[10px] font-black text-slate-400 dark:text-slate-600
                uppercase tracking-widest
                border-t border-slate-200 dark:border-slate-800/50 pt-10"
         x-show="!completed">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1
                         bg-slate-100 dark:bg-slate-800
                         rounded-lg border border-slate-200 dark:border-slate-700
                         text-slate-600 dark:text-slate-300
                         font-mono">Space</span> Lật thẻ
        </div>
        <template x-if="flipped">
            <div class="flex gap-8">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1
                                 bg-slate-100 dark:bg-slate-800
                                 rounded-lg border border-slate-200 dark:border-slate-700
                                 text-rose-500 font-mono">A</span> Sai / Quên
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1
                                 bg-slate-100 dark:bg-slate-800
                                 rounded-lg border border-slate-200 dark:border-slate-700
                                 text-emerald-500 font-mono">D</span> Đúng / Thuộc
                </div>
            </div>
        </template>
    </div>
</div>

@push('scripts')
<script>
    function studySession() {
        return {
            cards: @json($cards),
            langCode: '{{ $deck->language->tts_code ?: $deck->language->code }}',
            index: 0,
            flipped: false,
            completed: false,
            knownCount: 0,
            reviewCount: 0,
            earnedXp: 0,
            currentStreak: 0,
            
            get currentCard() {
                return this.cards[this.index];
            },

            playAudio() {
                if (this.currentCard.audio_url) {
                    this.$refs.audioPlayer.play();
                } else {
                    const speakWithVoice = () => {
                        let msg = new SpeechSynthesisUtterance();
                        msg.text = this.currentCard.front;
                        
                        // 1. Chuẩn hóa mã ngôn ngữ để bắt đúng giọng bản địa
                        let code = this.langCode || 'en-US';
                        if (code === 'ja') code = 'ja-JP';
                        if (code === 'zh') code = 'zh-CN';
                        if (code === 'ko') code = 'ko-KR';
                        if (code === 'vi') code = 'vi-VN';
                        
                        msg.lang = code;
                        msg.rate = 0.88;
                        msg.pitch = 1.0;

                        let voices = window.speechSynthesis.getVoices();
                        let langPrefix = code.split('-')[0];

                        // Ưu tiên: Giọng Neural/Natural Nữ -> Google Nữ -> Bất kỳ giọng của ngôn ngữ đó
                        let selected = 
                            voices.find(v => v.lang.startsWith(langPrefix) && (v.name.includes('Natural') || v.name.includes('Neural')) && /female|woman|xiaoxiao|nanami|kyoko/i.test(v.name)) ||
                            voices.find(v => v.name.includes('Google') && v.lang.startsWith(langPrefix)) ||
                            voices.find(v => v.lang.startsWith(langPrefix) && /kyoko|nanami|shiori|haruka|xiaoxiao|huihui|kiana|linlin/i.test(v.name)) ||
                            voices.find(v => v.lang.startsWith(langPrefix) && !v.name.toLowerCase().includes('male')) ||
                            voices.find(v => v.lang.startsWith(langPrefix));

                        if (selected) msg.voice = selected;

                        window.speechSynthesis.cancel();
                        window.speechSynthesis.speak(msg);
                    };

                    let voices = window.speechSynthesis.getVoices();
                    if (voices.length > 0) {
                        speakWithVoice();
                    } else {
                        window.speechSynthesis.onvoiceschanged = () => {
                            window.speechSynthesis.onvoiceschanged = null;
                            speakWithVoice();
                        };
                    }
                }
            },

            async next(known) {
                if (known) this.knownCount++;
                else this.reviewCount++;

                if (this.index < this.cards.length - 1) {
                    this.flipped = false;
                    setTimeout(() => {
                        this.index++;
                    }, 150);
                } else {
                    await this.finishSession();
                }
            },

            async finishSession() {
                try {
                    const res = await fetch("{{ route('study.finish', $deck) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.earnedXp = data.earned_xp;
                        this.currentStreak = data.streak;
                        this.completed = true;
                    }
                } catch (e) {
                    this.completed = true; 
                }
            },

            resetSession() {
                this.index = 0;
                this.flipped = false;
                this.completed = false;
                this.knownCount = 0;
                this.reviewCount = 0;
            },

            handleKeydown(e) {
                if (this.completed) return;
                
                if (e.code === 'Space' || e.key === ' ') { 
                    e.preventDefault(); 
                    this.flipped = !this.flipped; 
                } else if (this.flipped) {
                    if (e.key.toLowerCase() === 'a') this.next(false);
                    if (e.key.toLowerCase() === 'd') this.next(true);
                }
            }
        }
    }
</script>
@endpush

@endsection
