<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    {{-- ⚡ Anti-flicker theme script: MUST be the very first thing in <head> --}}
    <script>
        (function() {
            var saved = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Flashcar - Modern Flashcard Learning System for multiple languages">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'Flashcar') — Modern Flashcard Learning</title>

    {{-- Google Fonts: Be Vietnam Pro (Optimized for Vietnamese) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['"Be Vietnam Pro"', 'sans-serif'],
                    },
                    colors: {
                        dark: '#0f172a',
                        primary: '#6366f1',
                        accent: {
                            purple: '#a855f7',
                            indigo: '#6366f1'
                        }
                    },
                    animation: {
                        'fade-in':   'fadeIn 0.4s ease-out forwards',
                        'slide-up':  'slideUp 0.4s ease-out forwards',
                        'pulse-subtle': 'pulseSubtle 2s infinite',
                    },
                    keyframes: {
                        fadeIn:  { from: { opacity: 0, transform: 'translateY(10px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
                        slideUp: { from: { opacity: 0, transform: 'translateY(20px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
                        pulseSubtle: { '0%, 100%': { opacity: 1 }, '50%': { opacity: 0.8 } }
                    }
                }
            }
        }
    </script>

    {{-- Alpine.js --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }

        /* === Theme Transition === */
        html { transition: background-color 0.3s ease, color 0.3s ease; }
        *, *::before, *::after { transition: background-color 0.2s ease, border-color 0.2s ease; }
        /* Don't animate transforms/opacity with the wildcard — keep those snappy */
        *:not([class*='transition']):not([class*='animate']):not([class*='duration']) {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        /* === Dark Mode (default) === */
        body {
            background-color: #0f172a;
            color: #f8fafc;
            -webkit-font-smoothing: antialiased;
            line-height: 1.6;
        }

        /* === Light Mode override === */
        html:not(.dark) body {
            background-color: #f8fafc;  /* slate-50 */
            color: #0f172a;             /* slate-900 */
        }

        /* ─── Light Mode: Text Hierarchy ─── */
        /* Catch any rogue "text-white" that slipped through in light mode */
        html:not(.dark) .text-white:not(.btn-gradient *):not([class*='btn-gradient']) {
            color: #0f172a !important;  /* slate-900 */
        }
        html:not(.dark) .text-slate-400 { color: #64748b; }  /* keep readable */
        html:not(.dark) .text-slate-500 { color: #64748b; }

        /* ─── Glass morphism ─── */
        .glass {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }
        html:not(.dark) .glass {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.07);
            box-shadow: 0 4px 32px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0,0,0,0.04);
        }

        /* ─── Navbar bottom border in light mode ─── */
        html:not(.dark) nav {
            border-bottom: 1px solid #e2e8f0 !important; /* slate-200 */
        }

        /* ─── Flashcard glass in light mode ─── */
        html:not(.dark) .flip-card-front.glass {
            background: rgba(255, 255, 255, 0.97);
            border-color: rgba(0,0,0,0.08);
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        }

        /* ─── Gradient button — unchanged in both modes ─── */
        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.3);
            color: #ffffff !important;
        }
        /* Keep btn-gradient text white regardless of light-mode override */
        html:not(.dark) .btn-gradient,
        html:not(.dark) .btn-gradient * { color: #ffffff !important; }

        /* ─── Text gradient ─── */
        .text-gradient {
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ─── Subtle card depth in light mode ─── */
        html:not(.dark) .card-light {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
        }

        /* ─── Input fields in light mode ─── */
        html:not(.dark) input,
        html:not(.dark) select,
        html:not(.dark) textarea {
            color: #0f172a;
        }
        html:not(.dark) input::placeholder,
        html:not(.dark) textarea::placeholder {
            color: #94a3b8; /* slate-400 */
        }

        /* ─── Scrollbar ─── */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        html:not(.dark) ::-webkit-scrollbar { width: 6px; }
        html:not(.dark) ::-webkit-scrollbar-track { background: #f1f5f9; }
        html:not(.dark) ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
    </style>

    @stack('styles')
</head>

<body x-data="authSystem()" @notify.window="addToast($event.detail.message, $event.detail.type)" class="selection:bg-indigo-500/30 font-sans overflow-x-hidden transition-colors duration-200">

    {{-- Navigation --}}
    <nav class="relative z-40 glass border-b border-slate-700/50 dark:border-slate-700/50 mb-8 mt-4 mx-4 rounded-3xl shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 md:gap-3 group transition flex-shrink-0">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl overflow-hidden shadow-lg group-hover:rotate-6 transition-transform">
                    <img src="{{ asset('favicon.png') }}" class="w-full h-full object-cover" alt="FC">
                </div>
                <div class="flex flex-col leading-none">
                    <span class="text-lg md:text-xl font-black tracking-tighter text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">Flashcar</span>
                    <span class="text-[8px] md:text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-0.5 md:mt-1">AI Powered</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-8">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="text-sm font-bold transition
                              {{ request()->routeIs('dashboard')
                                 ? 'text-indigo-600 dark:text-indigo-400'
                                 : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Bảng điều khiển</a>
                    <a href="{{ route('decks.create') }}"
                       class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">Tạo bộ thẻ</a>
                @else
                    <a href="#" class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">Hỗ trợ</a>
                    <a href="#" class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">Khám phá</a>
                @endauth
            </div>

            <div class="flex items-center gap-2 md:gap-3">
                {{-- Theme Toggle Button --}}
                <x-theme-toggle />

                @auth
                    {{-- Gamification Stats (Visible on MD and LG) --}}
                    <div class="hidden md:flex items-center gap-3 lg:gap-4 px-3 lg:px-4 py-2
                                bg-slate-100 dark:bg-slate-800/50
                                rounded-2xl border border-slate-200 dark:border-slate-700/50 mr-1 lg:mr-2 shadow-sm dark:shadow-none transition-all">
                        <div class="flex items-center gap-2" title="Streak">
                            <span class="text-lg">🔥</span>
                            <span class="text-xs lg:text-sm font-black text-slate-900 dark:text-white">{{ Auth::user()->streak_count }}</span>
                        </div>
                        <div class="w-px h-3 lg:h-4 bg-slate-300 dark:bg-slate-700"></div>
                        <div class="flex items-center gap-2" title="XP Points">
                            <span class="text-lg">⭐</span>
                            <span class="text-xs lg:text-sm font-black text-indigo-600 dark:text-indigo-400">{{ number_format(Auth::user()->xp_points) }}</span>
                        </div>
                    </div>

                    {{-- User Profile --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 p-1 rounded-2xl
                                hover:bg-slate-200 dark:hover:bg-slate-800 transition">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-xl object-cover border border-slate-300 dark:border-slate-700 shadow-lg" alt="Avatar">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700 flex items-center justify-center
                                            border border-slate-300 dark:border-slate-600 font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="hidden sm:flex flex-col items-start pr-2">
                                <span class="text-xs font-black text-slate-900 dark:text-white leading-none mb-1">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ Auth::user()->learning_goal ?? 'Học tập' }}</span>
                            </div>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 top-full mt-3 w-48 glass rounded-2xl
                                    border border-slate-200 dark:border-slate-700 shadow-2xl p-2 animate-fade-in">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold
                                                           text-slate-600 dark:text-slate-400
                                                           hover:text-slate-900 dark:hover:text-white
                                                           hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                                    🚪 <span>Đăng xuất</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-2">
                        <button @click="openLogin()" class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white px-4 transition">Đăng nhập</button>
                        <button @click="openRegister()" class="text-sm font-bold btn-gradient text-white px-6 py-3 rounded-2xl transition hover:scale-105 active:scale-95 shadow-indigo-600/20">Bắt đầu</button>
                    </div>
                    <button @click="openLogin()" class="sm:hidden p-3 bg-slate-100 dark:bg-slate-800 rounded-xl text-indigo-600 dark:text-indigo-400 transition shadow-sm border border-slate-200 dark:border-slate-700" title="Đăng nhập">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    </button>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="max-w-7xl mx-auto px-6 py-16 mt-20
                    border-t border-slate-200 dark:border-slate-800/50
                    flex flex-col md:flex-row justify-between items-center gap-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl overflow-hidden shadow-lg">
                <img src="{{ asset('favicon.png') }}" class="w-full h-full object-cover" alt="FC">
            </div>
            <span class="text-xl font-black tracking-tighter text-slate-900 dark:text-white">XDFLCAR</span>
        </div>
        <p class="text-slate-500 text-sm font-medium">
            © {{ date('Y') }} Flashcar. Bản quyền thuộc về <span class="text-indigo-600 dark:text-indigo-400">XDFLCAR</span>. Đam mê học tập.
        </p>
        <div class="flex gap-6">
            <a href="#" class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition text-xl">🌐</a>
            <a href="#" class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition text-xl">💬</a>
            <a href="#" class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition text-xl">📧</a>
        </div>
    </footer>

    {{-- --- Authentication Modals --- --}}
    
    {{-- Login Modal --}}
    <div x-show="showLogin" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" x-cloak x-transition.opacity>
        <div @click.away="showLogin = false" class="w-full max-w-md bg-white dark:glass rounded-[32px] border border-slate-200 dark:border-white/5 overflow-y-auto max-h-[90dvh] animate-slide-up scrollbar-hide shadow-[0_32px_64px_-16px_rgba(0,0,0,0.2)]">
            <div class="px-8 py-10 text-center relative shrink-0 bg-gradient-to-br from-indigo-50 to-white dark:from-indigo-600 dark:to-indigo-800">
                <button @click="showLogin = false" class="absolute top-6 right-6 text-slate-400 dark:text-white/50 hover:text-slate-900 dark:hover:text-white transition text-2xl">✕</button>
                <div class="w-16 h-16 bg-white dark:bg-white/10 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6 shadow-xl shadow-indigo-200 dark:shadow-none">👋</div>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter mb-2">Chào mừng trở lại!</h2>
                <p class="text-slate-500 dark:text-indigo-100/70 text-sm font-medium">Hôm nay bạn muốn học thêm điều gì mới?</p>
            </div>
            <div class="p-8 bg-white dark:bg-transparent">
                <form @submit.prevent="submitLogin">
                    <div class="space-y-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em] ml-2">Email của bạn</label>
                            <input type="email" x-model="loginForm.email" required placeholder="name@email.com" 
                                   class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-[24px] px-8 py-4 md:py-6 text-lg focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 font-bold w-full shadow-sm leading-none">
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between items-center px-2">
                                <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em]">Mật khẩu</label>
                                <button type="button" @click="showPass = !showPass" class="text-[11px] font-black text-indigo-500 dark:text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 tracking-[0.25em] transition-all px-2 py-1 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-lg border border-indigo-500/10 dark:border-indigo-500/20" x-text="showPass ? 'BẢO MẬT' : 'HIỂN THỊ'"></button>
                            </div>
                            <input :type="showPass ? 'text' : 'password'" x-model="loginForm.password" required placeholder="••••••••" 
                                   class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-[24px] px-8 py-4 md:py-6 text-lg focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 font-bold w-full shadow-sm leading-none">
                        </div>
                        <div class="flex items-center justify-between px-1">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" x-model="loginForm.remember" class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-indigo-600 focus:ring-0">
                                <span class="text-xs font-bold text-slate-500 group-hover:text-slate-300 transition">Duy trì đăng nhập</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 transition">Quên mật khẩu?</a>
                        </div>
                        <button type="submit" :disabled="loading" class="w-full btn-gradient py-5 rounded-2xl text-white font-black text-base tracking-wide transition-all transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-indigo-500/40 active:scale-95 disabled:opacity-70 disabled:scale-100 mt-4 flex items-center justify-center gap-3">
                            <span x-show="!loading">Đăng nhập ngay</span>
                            <div x-show="loading" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        </button>
                        
                        <div class="relative py-2 flex items-center gap-4">
                            <div class="flex-grow h-px bg-slate-100 dark:bg-slate-800"></div>
                            <span class="text-[10px] font-black text-slate-300 dark:text-slate-600">HOẶC</span>
                            <div class="flex-grow h-px bg-slate-100 dark:bg-slate-800"></div>
                        </div>

                        <a href="{{ route('google.login') }}" class="w-full bg-white dark:bg-slate-800 text-slate-900 dark:text-white py-5 rounded-2xl font-black text-base border border-slate-200 dark:border-slate-700 transition-all flex items-center justify-center gap-3 hover:bg-slate-50 dark:hover:bg-slate-700 hover:scale-[1.02] active:scale-95 shadow-lg shadow-black/5">
                            <svg class="w-6 h-6" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24s.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/><path fill="none" d="M0 0h48v48H0z"/></svg>
                            Tiếp tục với Google
                        </a>

                        <p class="text-center text-xs font-bold text-slate-400 dark:text-slate-500 mt-4">
                            Chưa có tài khoản? <button type="button" @click="openRegister()" class="text-indigo-600 dark:text-indigo-400 hover:underline transition underline-offset-4">Gia nhập ngay</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Register Modal --}}
    <div x-show="showRegister" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" x-cloak x-transition.opacity>
        <div @click.away="showRegister = false" class="w-full max-w-md bg-white dark:glass rounded-[32px] border border-slate-200 dark:border-white/5 overflow-y-auto max-h-[90dvh] animate-slide-up scrollbar-hide shadow-[0_32px_64px_-16px_rgba(0,0,0,0.2)]">
            <div class="px-8 py-10 text-center relative shrink-0 bg-gradient-to-br from-indigo-50 to-white dark:from-slate-900 dark:to-slate-950 border-b border-slate-100 dark:border-slate-800">
                <button @click="showRegister = false" class="absolute top-6 right-6 text-slate-400 dark:text-slate-600 hover:text-slate-900 dark:hover:text-white transition text-2xl">✕</button>
                <div class="inline-flex w-16 h-16 btn-gradient rounded-2xl items-center justify-center text-3xl mb-4 animate-bounce shadow-xl">✨</div>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter mb-2">Tạo tài khoản mới</h2>
                <p class="text-slate-500 dark:text-slate-500 text-sm font-medium">Bắt đầu hành trình chinh phục ngôn ngữ</p>
            </div>
            <div class="p-8 bg-white dark:bg-transparent">
                <form @submit.prevent="submitRegister">
                    <div class="space-y-5">
                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em] ml-2">Tên của bạn</label>
                        <input type="text" x-model="registerForm.name" required placeholder="Nguyen Xuan Duong" 
                               class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-[24px] px-8 py-4 md:py-6 text-lg focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-bold placeholder:text-slate-400 dark:placeholder:text-slate-600 w-full leading-none shadow-sm">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em] ml-2">Địa chỉ Email</label>
                        <input type="email" x-model="registerForm.email" required placeholder="name@email.com" 
                               class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-[24px] px-8 py-4 md:py-6 text-lg focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-bold placeholder:text-slate-400 dark:placeholder:text-slate-600 w-full leading-none shadow-sm">
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center px-2">
                            <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em]">Mật khẩu</label>
                            <div class="flex items-center gap-3">
                                <span class="text-[9px] font-black px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded uppercase tracking-tighter" :class="passStrengthClass" x-text="passStrengthText"></span>
                                <button type="button" @click="showPass = !showPass" class="text-[11px] font-black text-indigo-500 dark:text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 tracking-[0.25em] transition-all px-2 py-1 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-lg border border-indigo-500/10 dark:border-indigo-500/20" x-text="showPass ? 'ẨN' : 'HIỆN'"></button>
                            </div>
                        </div>
                        <input :type="showPass ? 'text' : 'password'" x-model="registerForm.password" required placeholder="Min 6 ký tự" 
                               class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-[24px] px-8 py-4 md:py-6 text-lg focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-bold w-full leading-none placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-sm">
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center px-2">
                            <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em]">Xác nhận mật khẩu</label>
                            <button type="button" @click="showConfirmPass = !showConfirmPass" class="text-[11px] font-black text-indigo-500 dark:text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 tracking-[0.25em] transition-all px-2 py-1 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-lg border border-indigo-500/10 dark:border-indigo-500/20" x-text="showConfirmPass ? 'ẨN' : 'HIỆN'"></button>
                        </div>
                        <input :type="showConfirmPass ? 'text' : 'password'" x-model="registerForm.password_confirmation" required placeholder="Nhập lại mật khẩu" 
                               class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-[24px] px-8 py-4 md:py-6 text-lg focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-bold w-full leading-none placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-sm">
                    </div>
                        
                        <div class="pt-4">
                            <button type="submit" :disabled="loading" class="w-full btn-gradient py-5 rounded-2xl text-white font-black text-base transition-all transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-indigo-500/40 active:scale-95 disabled:opacity-70 mt-4 flex items-center justify-center gap-3">
                                <span x-show="!loading">Tạo tài khoản & Bắt đầu học</span>
                                <div x-show="loading" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                            </button>
                        </div>

                        <p class="text-center text-xs font-bold text-slate-400 dark:text-slate-500 mt-4">
                            Đã có tài khoản? <button type="button" @click="openLogin()" class="text-indigo-600 dark:text-indigo-400 hover:underline transition underline-offset-4">Đăng nhập</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Onboarding Modal --}}
    <div x-show="showOnboarding" class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-black/90 backdrop-blur-md" x-cloak x-transition.opacity>
        <div class="w-full max-w-xl glass rounded-[40px] border border-white/10 p-6 md:p-10 text-center overflow-y-auto max-h-[90dvh] animate-slide-up scrollbar-hide">
            <h2 class="text-4xl font-black text-white tracking-tighter mb-4 capitalize">Chào mừng, <span class="text-gradient" x-text="userName"></span>!</h2>
            <p class="text-slate-400 font-bold mb-10 max-w-sm mx-auto">Hãy cho chúng tôi biết mục tiêu học tập chính của bạn để Flashcar cá nhân hóa trải nghiệm cho bạn.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <template x-for="goal in goals">
                    <button @click="selectedGoal = goal.id" 
                            class="p-6 rounded-3xl border-2 transition-all group flex flex-col items-center gap-3"
                            :class="selectedGoal === goal.id ? 'bg-indigo-600/20 border-indigo-500 shadow-lg shadow-indigo-600/10' : 'bg-slate-800/50 border-slate-700 hover:border-slate-600'">
                        <img :src="goal.icon" class="w-16 h-10 object-cover rounded-xl shadow-lg group-hover:scale-110 transition-transform" :alt="goal.name" x-show="goal.icon.startsWith('http')">
                        <span class="text-4xl group-hover:scale-110 transition-transform" x-text="goal.icon" x-show="!goal.icon.startsWith('http')"></span>
                        <span class="font-black text-sm tracking-tight" :class="selectedGoal === goal.id ? 'text-white' : 'text-slate-400'" x-text="goal.name"></span>
                    </button>
                </template>
            </div>

            <button @click="finishOnboarding" class="w-full btn-gradient py-5 rounded-[24px] text-white font-black text-lg shadow-2xl transition hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-4">
                <span>Khám phá Dashboard của tôi</span>
                <span class="text-2xl">🚀</span>
            </button>
        </div>
    </div>

    {{-- Toasts --}}
    <div class="fixed top-24 right-8 z-[100] flex flex-col gap-3">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 border"
                 :class="toast.type === 'success' ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400' : 'bg-rose-500/10 border-rose-500/30 text-rose-400'">
                <span class="text-xl" x-text="toast.type === 'success' ? '✅' : '⚠️'"></span>
                <p class="text-sm font-bold" x-text="toast.message"></p>
                <button @click="removeToast(toast.id)" class="ml-4 opacity-50 hover:opacity-100 transition">✕</button>
            </div>
        </template>
    </div>

    {{-- Scroll to Top Button --}}
    <button x-data="{ show: false }" 
            @scroll.window="show = window.pageYOffset > 300" 
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
            x-show="show" 
            x-transition.opacity.duration.300ms
            class="fixed bottom-8 right-8 z-50 p-4 btn-gradient text-white rounded-full shadow-2xl shadow-indigo-500/30 hover:scale-110 active:scale-95 transition-all outline-none"
            title="Lên đầu trang">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    {{-- System Core Scripts --}}
    <script>
        function authSystem() {
            return {
                showLogin: false,
                showRegister: false,
                showOnboarding: false,
                showPass: false,
                showConfirmPass: false,
                loading: false,
                userName: '',
                selectedGoal: 'English',
                toasts: [],
                loginForm: { email: '', password: '', remember: false },
                registerForm: { name: '', email: '', password: '', password_confirmation: '' },
                goals: [
                    { id: 'English', name: 'Tiếng Anh', icon: 'https://flagcdn.com/w160/us.png' },
                    { id: 'Japanese', name: 'Tiếng Nhật', icon: 'https://flagcdn.com/w160/jp.png' },
                    { id: 'German', name: 'Tiếng Đức', icon: 'https://flagcdn.com/w160/de.png' },
                    { id: 'Programming', name: 'Lập trình', icon: '💻' }
                ],

                init() {
                    this.$nextTick(() => {
                        @if(session('success')) setTimeout(() => this.addToast({{ \Illuminate\Support\Js::from(session('success')) }}, 'success'), 100); @endif
                        @if(session('error')) setTimeout(() => this.addToast({{ \Illuminate\Support\Js::from(session('error')) }}, 'error'), 100); @endif
                    });
                },

                openLogin() {
                    this.showRegister = false;
                    this.showLogin = true;
                },

                openRegister() {
                    this.showLogin = false;
                    this.showRegister = true;
                },

                async submitLogin() {
                    this.loading = true;
                    try {
                        const response = await fetch("{{ route('login.post') }}", {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.loginForm)
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.addToast(data.message, 'success');
                            window.location.href = data.redirect;
                        } else {
                            this.addToast(data.message, 'error');
                        }
                    } catch (e) {
                        this.addToast("Có lỗi xảy ra, vui lòng thử lại.", 'error');
                    }
                    this.loading = false;
                },

                async submitRegister() {
                    this.loading = true;
                    try {
                        const response = await fetch("{{ route('register.post') }}", {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.registerForm)
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.addToast(data.message, 'success');
                            this.userName = this.registerForm.name;
                            this.showRegister = false;
                            this.showOnboarding = true;
                        } else {
                            const errors = Object.values(data.errors).flat().join(' ');
                            this.addToast(errors, 'error');
                        }
                    } catch (e) {
                        this.addToast("Có lỗi xảy ra, vui lòng thử lại.", 'error');
                    }
                    this.loading = false;
                },

                async finishOnboarding() {
                    try {
                        await fetch("{{ route('user.update-goal') }}", {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ learning_goal: this.selectedGoal })
                        });
                        window.location.href = "{{ route('dashboard') }}";
                    } catch (e) {
                        window.location.href = "{{ route('dashboard') }}";
                    }
                },

                get passStrengthText() {
                    const p = this.registerForm.password;
                    if (!p) return '';
                    if (p.length < 6) return 'QUÁ NGẮN';
                    if (p.length < 10) return 'TRUNG BÌNH';
                    return 'MẠNH';
                },

                get passStrengthClass() {
                    const p = this.registerForm.password;
                    if (!p) return '';
                    if (p.length < 6) return 'text-rose-500';
                    if (p.length < 10) return 'text-amber-500';
                    return 'text-emerald-500';
                },

                addToast(message, type) {
                    const id = Date.now();
                    this.toasts.push({ id, message, type });
                    setTimeout(() => this.removeToast(id), 5000);
                },

                removeToast(id) {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
