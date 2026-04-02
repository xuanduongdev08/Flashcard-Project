@extends('layouts.app')

@section('title', 'Thông tin tài khoản')

@section('content')
<div class="max-w-5xl mx-auto px-4 pb-20 animate-fade-in">
    {{-- Breadcrumbs / Header --}}
    <div class="mb-10">
        <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tighter mb-4">Thông tin cá nhân</h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium max-w-xl">Quản lý các thông tin cơ bản, ảnh đại diện và địa chỉ của bạn để cá nhân hóa trải nghiệm trên Flashcar.</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" 
          class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        @csrf

        {{-- Left: Profile Card --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[40px] p-8 text-center shadow-xl shadow-black/5 flex flex-col items-center">
                <div class="relative group mb-6">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-[40px] overflow-hidden border-4 border-white dark:border-slate-800 shadow-2xl relative">
                        <img id="avatar-preview" src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=6366f1&color=fff&size=256' }}" 
                             class="w-full h-full object-cover" alt="Avatar">
                        
                        {{-- Overlay --}}
                        <label for="avatar_file" class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all cursor-pointer backdrop-blur-sm">
                            <span class="text-2xl mb-1">📸</span>
                            <span class="text-[10px] font-black text-white uppercase tracking-widest">Thay đổi ảnh</span>
                        </label>
                    </div>
                    <input type="file" name="avatar_file" id="avatar_file" class="hidden" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="space-y-1 mb-8">
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ $user->name }}</h2>
                    <p class="text-xs font-black text-indigo-500 dark:text-indigo-400 uppercase tracking-widest">{{ $user->email }}</p>
                </div>

                <div class="w-full grid grid-cols-2 gap-4 py-6 border-t border-slate-100 dark:border-slate-800/50">
                    <div class="flex flex-col">
                        <span class="text-lg font-black text-slate-900 dark:text-white">🔥 {{ $user->streak_count }}</span>
                        <span class="text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Chuỗi học</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">⭐ {{ number_format($user->xp_points) }}</span>
                        <span class="text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kinh nghiệm</span>
                    </div>
                </div>
            </div>

            {{-- Helper Note --}}
            <div class="bg-indigo-600 rounded-[32px] p-8 text-white relative overflow-hidden group shadow-2xl shadow-indigo-600/30">
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <h3 class="text-lg font-black mb-2 tracking-tight">Cập nhật hồ sơ</h3>
                    <p class="text-indigo-100 text-xs font-medium leading-relaxed opacity-80">Hoàn thiện hồ sơ giúp Flashcar đề xuất nội dung học tập phù hợp hơn với mục tiêu và địa điểm của bạn.</p>
                </div>
            </div>
        </div>

        {{-- Right: Settings Form --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Basic Info Section --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[40px] p-8 md:p-10 shadow-sm dark:shadow-2xl">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-xl">👤</div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Thông tin cơ bản</h3>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-3 ml-2">Họ và tên của bạn</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-800 text-slate-900 dark:text-white px-6 py-4 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-bold text-lg shadow-sm">
                        @error('name') <p class="text-rose-500 text-[10px] mt-2 font-bold px-2 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-3 ml-2">Địa chỉ Email</label>
                        <input type="email" value="{{ $user->email }}" disabled
                               class="w-full bg-slate-100 dark:bg-slate-800/80 border-2 border-slate-100 dark:border-slate-800 text-slate-400 dark:text-slate-500 px-6 py-4 rounded-2xl outline-none font-bold text-lg opacity-70 cursor-not-allowed">
                        <p class="text-[9px] font-bold text-slate-400 mt-2 ml-2 italic">* Email không thể thay đổi vì lý do bảo mật.</p>
                    </div>
                </div>
            </div>

            {{-- Address Section --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[40px] p-8 md:p-10 shadow-sm dark:shadow-2xl">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-xl">📍</div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Nơi ở hiện tại</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-3 ml-2">Tỉnh / Thành phố</label>
                        <div class="relative">
                            <select name="province" id="province-select" 
                                    class="w-full appearance-none bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-800 text-slate-900 dark:text-white px-6 py-4 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-bold shadow-sm">
                                <option value="" disabled {{ !$user->province ? 'selected' : '' }}>Chọn tỉnh...</option>
                                {{-- We'll populate this with JS --}}
                            </select>
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-3 ml-2">Quận / Huyện</label>
                        <div class="relative">
                            <select name="district" id="district-select" 
                                    class="w-full appearance-none bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-800 text-slate-900 dark:text-white px-6 py-4 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-bold shadow-sm">
                                <option value="" disabled {{ !$user->district ? 'selected' : '' }}>Chọn huyện...</option>
                            </select>
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-3 ml-2">Phường / Xã</label>
                        <div class="relative">
                            <select name="ward" id="ward-select" 
                                    class="w-full appearance-none bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-800 text-slate-900 dark:text-white px-6 py-4 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-bold shadow-sm">
                                <option value="" disabled {{ !$user->ward ? 'selected' : '' }}>Chọn xã...</option>
                            </select>
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-3 ml-2">Địa chỉ chi tiết (Thôn/Xóm/Số nhà...)</label>
                    <textarea name="address_detail" rows="3" 
                              class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-800 text-slate-900 dark:text-white px-6 py-4 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 outline-none transition-all font-medium shadow-sm resize-none"
                              placeholder="Nhập địa chỉ cụ thể của bạn...">{{ old('address_detail', $user->address_detail) }}</textarea>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="flex justify-end pt-4 pb-12">
                <button type="submit" 
                        class="px-12 py-5 btn-gradient text-white font-black rounded-[24px] shadow-2xl shadow-indigo-600/30 transition transform hover:-translate-y-2 active:scale-95 flex items-center gap-3">
                    <span>Lưu thay đổi hồ sơ</span>
                    <span class="text-xl">✨</span>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Preview Avatar Image
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Static Location Data for premium experience
    const locationData = {
        'Hà Nội': {
            'Quận Ba Đình': ['Trúc Bạch', 'Tràng Tiền', 'Điện Biên'],
            'Quận Tây Hồ': ['Bưởi', 'Yên Phụ', 'Thụy Khuê'],
            'Quận Hoàn Kiếm': ['Cửa Đông', 'Cửa Nam', 'Đồng Xuân']
        },
        'TP. Hồ Chí Minh': {
            'Quận 1': ['Bến Nghé', 'Bến Thành', 'Đa Kao'],
            'Quận 3': ['Võ Thị Sáu', 'Phường 1', 'Phường 2'],
            'Quận Tân Bình': ['Phường 1', 'Phường 2', 'Phường 15']
        },
        'Đà Nẵng': {
            'Quận Hải Châu': ['Hòa Cường Bắc', 'Hòa Cường Nam', 'Hòa Thuận Đông'],
            'Quận Thanh Khê': ['An Khê', 'Chính Gián', 'Hòa Khê']
        },
        'Hải Phòng': {
            'Quận Hồng Bàng': ['Hạ Lý', 'Quán Toan', 'Thượng Lý'],
            'Quận Lê Chân': ['An Dương', 'Lam Sơn', 'Cát Dài']
        }
    };

    const provinceSelect = document.getElementById('province-select');
    const districtSelect = document.getElementById('district-select');
    const wardSelect = document.getElementById('ward-select');

    // Initial populate
    Object.keys(locationData).forEach(p => {
        const opt = document.createElement('option');
        opt.value = p;
        opt.textContent = p;
        if (p === '{{ $user->province }}') opt.selected = true;
        provinceSelect.appendChild(opt);
    });

    function updateDistricts() {
        const p = provinceSelect.value;
        districtSelect.innerHTML = '<option value="" disabled selected>Chọn huyện...</option>';
        wardSelect.innerHTML = '<option value="" disabled selected>Chọn xã...</option>';
        
        if (locationData[p]) {
            Object.keys(locationData[p]).forEach(d => {
                const opt = document.createElement('option');
                opt.value = d;
                opt.textContent = d;
                if (d === '{{ $user->district }}') opt.selected = true;
                districtSelect.appendChild(opt);
            });
        }
        if (districtSelect.value) updateWards();
    }

    function updateWards() {
        const p = provinceSelect.value;
        const d = districtSelect.value;
        wardSelect.innerHTML = '<option value="" disabled selected>Chọn xã...</option>';
        
        if (locationData[p] && locationData[p][d]) {
            locationData[p][d].forEach(w => {
                const opt = document.createElement('option');
                opt.value = w;
                opt.textContent = w;
                if (w === '{{ $user->ward }}') opt.selected = true;
                wardSelect.appendChild(opt);
            });
        }
    }

    provinceSelect.addEventListener('change', updateDistricts);
    districtSelect.addEventListener('change', updateWards);

    // Initial triggers for current data
    if (provinceSelect.value) updateDistricts();
    if (districtSelect.value) updateWards();

</script>
@endpush
@endsection
