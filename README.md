<div align="center">

# 📚 FLASHCAR — Hệ Thống Học Tập Qua Thẻ Ghi Nhớ

**Ứng dụng Flashcard hiện đại xây dựng bằng Laravel 11 + Blade Template**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Blade](https://img.shields.io/badge/Blade-Template-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/docs/blade)

*Tạo bởi **Nguyễn Xuân Dương** — Mini Project Laravel*

</div>

---

## 📋 MỤC LỤC

1. [Giới thiệu dự án](#-giới-thiệu-dự-án)
2. [Công nghệ sử dụng](#️-công-nghệ-sử-dụng)
3. [Tính năng chính](#-tính-năng-chính)
4. [Cấu trúc dự án (MVC)](#-cấu-trúc-dự-án-mvc)
5. [Thiết kế Database](#️-thiết-kế-database)
6. [Luồng hoạt động](#-luồng-hoạt-động)
7. [Hướng dẫn cài đặt](#-hướng-dẫn-cài-đặt)
8. [Hướng dẫn sử dụng](#-hướng-dẫn-sử-dụng)

---

## 🎯 Giới Thiệu Dự Án

**Flashcar** là một ứng dụng học tập qua thẻ ghi nhớ (Flashcard) được xây dựng hoàn toàn bằng **Laravel 11** theo đúng kiến trúc **MVC** (Model – View – Controller) chuẩn. Ứng dụng giúp người dùng tạo và quản lý bộ từ vựng, sau đó học bằng hệ thống thẻ lật (flip card) tương tác hỗ trợ nhiều ngôn ngữ.

### Mục tiêu thiết kế:
- ✅ Code rõ ràng, đúng chuẩn Laravel MVC
- ✅ Giao diện hiện đại (GenZ Aesthetic — Dark Mode + Glassmorphism)
- ✅ Đầy đủ chức năng: Xác thực, CRUD, Học tập, Gamification
- ✅ Mọi thành phần đều bằng **PHP + Blade Template** (không dùng framework JS riêng)

---

## 🛠️ Công Nghệ Sử Dụng

| Thành phần | Công nghệ | Phiên bản |
|---|---|---|
| **Backend Framework** | Laravel | 11.x |
| **Ngôn ngữ** | PHP | 8.2+ |
| **Templating Engine** | Blade Templates (built-in Laravel) | — |
| **Cơ sở dữ liệu** | MySQL | 8.0 |
| **Authentication** | Laravel Auth + Google OAuth (Socialite) | — |
| **CSS Framework** | Tailwind CSS | CDN |
| **Font chữ** | Be Vietnam Pro | Google Fonts |
| **Email** | Laravel Mail (SMTP) | — |
| **Async Jobs** | Laravel Queue | — |
| **Local Server** | Laragon | — |

> **Lý do chọn công nghệ:** Toàn bộ tầng View được xây dựng bằng **Blade Template** — công cụ templating chính thức của Laravel, cho phép nhúng logic PHP trực tiếp vào HTML một cách sạch sẽ, hỗ trợ template inheritance với `@extends` / `@section` / `@yield`.

---

## ✨ Tính Năng Chính

| # | Tính năng | Mô tả |
|---|---|---|
| 1 | 🔐 **Xác thực đầy đủ** | Đăng ký, đăng nhập, đăng xuất, Google OAuth |
| 2 | 📧 **Quên mật khẩu OTP** | Gửi mã OTP 6 số qua email, hiệu lực 5 phút |
| 3 | 📊 **Dashboard thông minh** | Bộ lọc ngôn ngữ, thanh tìm kiếm, gợi ý AI |
| 4 | 🗂️ **Quản lý Bộ thẻ (Deck)** | Tạo, xem, sửa, xóa, **Clone** bộ thẻ |
| 5 | 🃏 **Quản lý Thẻ (Card)** | Thêm, sửa, xóa thẻ; tự động tạo audio TTS |
| 6 | 📖 **Chế độ học tập** | Lật thẻ 3D, phím tắt, thanh tiến độ |
| 7 | 🎮 **Gamification** | Hệ thống XP Points + Streak học liên tiếp |
| 8 | 🌍 **Đa ngôn ngữ** | 8 ngôn ngữ: Anh, Việt, Nhật, Hàn, Pháp, Hoa, Tây, Đức |
| 9 | 🔊 **Text-to-Speech** | Tự động tạo file âm thanh phát âm cho mỗi thẻ |

---

## 🏗️ Cấu Trúc Dự Án (MVC)

### Sơ đồ kiến trúc tổng quan

```
┌─────────────────────────────────────────────────────────────────┐
│                        NGƯỜI DÙNG (Browser)                     │
└───────────────────────────────┬─────────────────────────────────┘
                                │ HTTP Request
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                      routes/web.php                             │
│              (Định tuyến tất cả URL của ứng dụng)               │
└───────────────────────────────┬─────────────────────────────────┘
                                │ Gọi đúng Controller
                                ▼
┌───────────────────────────────────────────────────────────────┐
│                   CONTROLLER (app/Http/Controllers/)           │
│  Nhận Request → Xử lý logic nghiệp vụ → Trả về Response      │
│                                                               │
│  AuthController  │  DeckController  │  CardController        │
│  DashboardCtrl   │  StudyController │                        │
└────────┬──────────────────────┬──────────────────────────────┘
         │ Đọc/Ghi dữ liệu     │ Trả view + data
         ▼                      ▼
┌─────────────────┐   ┌─────────────────────────────────────────┐
│  MODEL          │   │  VIEW (resources/views/ *.blade.php)    │
│ (app/Models/)   │   │  Nhận data từ Controller, render HTML   │
│                 │   │                                         │
│  User.php       │   │  dashboard.blade.php                    │
│  Deck.php       │   │  decks/ create, edit, show, index       │
│  Card.php       │   │  cards/ create, edit                    │
│  Language.php   │   │  study/ session.blade.php               │
│                 │   │  auth/ forgot-password, reset-password  │
└────────┬────────┘   └─────────────────────────────────────────┘
         │ Eloquent ORM
         ▼
┌─────────────────────────────────────────────────────────────────┐
│                       MySQL Database                            │
│         users │ languages │ decks │ cards                       │
└─────────────────────────────────────────────────────────────────┘
```

### Cây thư mục đầy đủ

```
Flashcar/
│
├── app/
│   ├── Http/
│   │   └── Controllers/           ← CONTROLLER LAYER
│   │       ├── AuthController.php      (Xác thực, Google OAuth, OTP)
│   │       ├── DashboardController.php (Trang chính)
│   │       ├── DeckController.php      (CRUD bộ thẻ + Clone)
│   │       ├── CardController.php      (CRUD thẻ + dispatch TTS Job)
│   │       └── StudyController.php     (Phiên học + Gamification)
│   │
│   ├── Models/                    ← MODEL LAYER
│   │   ├── User.php                    (Người dùng, XP, Streak)
│   │   ├── Deck.php                    (Bộ thẻ)
│   │   ├── Card.php                    (Thẻ ghi nhớ + TTS)
│   │   └── Language.php                (Ngôn ngữ)
│   │
│   ├── Jobs/
│   │   └── GenerateCardAudio.php  ← Queue Job: tạo file âm thanh TTS
│   │
│   ├── Services/
│   │   └── TTSService.php         ← Service: logic Text-to-Speech
│   │
│   └── Mail/
│       ├── WelcomeMail.php        ← Email chào mừng
│       └── OtpMail.php            ← Email gửi mã OTP
│
├── database/
│   ├── migrations/                ← Lịch sử tạo bảng CSDL
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_languages_table.php
│   │   ├── ..._create_decks_table.php
│   │   ├── ..._create_cards_table.php
│   │   └── ..._update_users_table_for_gamification.php
│   ├── seeders/                   ← Dữ liệu mẫu
│   ├── flashcar_database.sql      ← Export SQL đầy đủ (data)
│   └── flashcar_full_schema.sql   ← Export SQL schema + seed
│
├── resources/
│   └── views/                     ← VIEW LAYER (Blade Templates)
│       ├── layouts/
│       │   └── app.blade.php          (Layout chính – header, nav)
│       ├── welcome.blade.php          (Landing page)
│       ├── dashboard.blade.php        (Trang chủ sau đăng nhập)
│       ├── auth/
│       │   ├── forgot-password.blade.php
│       │   └── reset-password.blade.php
│       ├── decks/
│       │   ├── index.blade.php        (Danh sách bộ thẻ)
│       │   ├── create.blade.php       (Form tạo mới)
│       │   ├── edit.blade.php         (Form chỉnh sửa)
│       │   └── show.blade.php         (Chi tiết + danh sách thẻ)
│       ├── cards/
│       │   ├── create.blade.php       (Form thêm thẻ)
│       │   └── edit.blade.php         (Form sửa thẻ)
│       ├── study/
│       │   └── session.blade.php      (Chế độ học tập – lật thẻ)
│       └── emails/
│           ├── welcome.blade.php
│           └── otp.blade.php
│
└── routes/
    └── web.php                    ← Toàn bộ định tuyến ứng dụng
```

---

## 🗄️ Thiết Kế Database

### Sơ đồ quan hệ thực thể (ERD)

```
┌──────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│    ┌─────────────────────┐          ┌──────────────────────────────┐     │
│    │       users         │          │          languages           │     │
│    ├─────────────────────┤          ├──────────────────────────────┤     │
│    │ PK id               │          │ PK id                        │     │
│    │    name             │          │    name      (VD: "English") │     │
│    │    email (UNIQUE)   │          │    code      (VD: "en")      │     │
│    │    password (hashed)│          │    flag_emoji(VD: "🇺🇸")     │     │
│    │    avatar           │          │    created_at                │     │
│    │    provider_id      │          │    updated_at                │     │
│    │    learning_goal    │          └──────────────┬───────────────┘     │
│    │    xp_points        │                         │ 1                   │
│    │    streak_count     │                         │                     │
│    │    last_study_at    │                         │ hasMany             │
│    │    created_at       │                         │                     │
│    │    updated_at       │                         │ ∞                   │
│    └──────────┬──────────┘          ┌──────────────▼───────────────┐     │
│               │ 1                   │            decks             │     │
│               │                     ├──────────────────────────────┤     │
│               │ hasMany             │ PK id                        │     │
│               │                     │ FK user_id  → users.id       │     │
│               │ ∞                   │ FK language_id → languages.id│     │
│               └─────────────────────►    title                     │     │
│                                     │    description               │     │
│                                     │    color  (VD: "#4F46E5")    │     │
│                                     │    created_at                │     │
│                                     │    updated_at                │     │
│                                     └──────────────┬───────────────┘     │
│                                                    │ 1                   │
│                                                    │                     │
│                                                    │ hasMany             │
│                                                    │                     │
│                                                    │ ∞                   │
│                                     ┌──────────────▼───────────────┐     │
│                                     │            cards             │     │
│                                     ├──────────────────────────────┤     │
│                                     │ PK id                        │     │
│                                     │ FK deck_id  → decks.id       │     │
│                                     │    front  (mặt trước thẻ)   │     │
│                                     │    back   (mặt sau thẻ)      │     │
│                                     │    order  (thứ tự hiển thị)  │     │
│                                     │    audio_path (file TTS)     │     │
│                                     │    created_at                │     │
│                                     │    updated_at                │     │
│                                     └──────────────────────────────┘     │
│                                                                          │
└──────────────────────────────────────────────────────────────────────────┘
```

### Chi tiết từng bảng

#### Bảng `users` — Người dùng hệ thống

| Cột | Kiểu | Ràng buộc | Mô tả |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Khóa chính |
| `name` | VARCHAR(255) | NOT NULL | Họ tên |
| `email` | VARCHAR(255) | NOT NULL, UNIQUE | Email đăng nhập |
| `password` | VARCHAR(255) | NOT NULL | Mật khẩu đã hash (bcrypt) |
| `avatar` | VARCHAR(255) | NULL | Ảnh đại diện (từ Google OAuth) |
| `provider_id` | VARCHAR(255) | NULL | ID tài khoản Google |
| `learning_goal` | VARCHAR(255) | NULL | Mục tiêu học (VD: "English") |
| `xp_points` | INT | DEFAULT 0 | Tổng điểm kinh nghiệm |
| `streak_count` | INT | DEFAULT 0 | Số ngày học liên tiếp |
| `last_study_at` | TIMESTAMP | NULL | Lần học gần nhất |

#### Bảng `languages` — Ngôn ngữ được hỗ trợ

| Cột | Kiểu | Ràng buộc | Mô tả |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PRIMARY KEY | Khóa chính |
| `name` | VARCHAR(255) | NOT NULL | Tên ngôn ngữ (VD: "English") |
| `code` | VARCHAR(10) | NOT NULL | Mã ngôn ngữ (VD: "en") |
| `flag_emoji` | VARCHAR(10) | NULL | Biểu tượng cờ (VD: "🇺🇸") |

#### Bảng `decks` — Bộ thẻ ghi nhớ

| Cột | Kiểu | Ràng buộc | Mô tả |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PRIMARY KEY | Khóa chính |
| `user_id` | BIGINT UNSIGNED | FK → users.id, CASCADE DELETE | Chủ sở hữu |
| `language_id` | BIGINT UNSIGNED | FK → languages.id, CASCADE DELETE | Ngôn ngữ học |
| `title` | VARCHAR(255) | NOT NULL | Tên bộ thẻ |
| `description` | TEXT | NULL | Mô tả |
| `color` | VARCHAR(7) | DEFAULT '#4F46E5' | Màu sắc thẻ (mã HEX) |

#### Bảng `cards` — Thẻ ghi nhớ

| Cột | Kiểu | Ràng buộc | Mô tả |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PRIMARY KEY | Khóa chính |
| `deck_id` | BIGINT UNSIGNED | FK → decks.id, CASCADE DELETE | Thuộc bộ thẻ nào |
| `front` | VARCHAR(255) | NOT NULL | Mặt trước (từ vựng/câu hỏi) |
| `back` | TEXT | NOT NULL | Mặt sau (nghĩa/giải thích) |
| `order` | INT | DEFAULT 0 | Thứ tự hiển thị |
| `audio_path` | VARCHAR(255) | NULL | Đường dẫn file âm thanh TTS |

### Quan hệ giữa các bảng (Eloquent Relationships)

```
User          ──hasMany──►  Deck          ──hasMany──►  Card
                │                              │
              (belongsTo)                  (belongsTo)
                │                              │
              User                            Deck

Language      ──hasMany──►  Deck
                │
              (belongsTo)
                │
               Deck
```

| Quan hệ | Loại | Ý nghĩa |
|---|---|---|
| `User → Decks` | **One-to-Many** | 1 người dùng tạo nhiều bộ thẻ |
| `User ← Deck` | **Belongs To** | Mỗi bộ thẻ có 1 chủ sở hữu |
| `Language → Decks` | **One-to-Many** | 1 ngôn ngữ có nhiều bộ thẻ |
| `Deck → Cards` | **One-to-Many** | 1 bộ thẻ chứa nhiều thẻ |
| `Card ← Deck` | **Belongs To** | Mỗi thẻ thuộc về 1 bộ thẻ |

> **CASCADE DELETE:** Khi xóa `User` → tự động xóa toàn bộ `Deck` của user đó. Khi xóa `Deck` → tự động xóa toàn bộ `Card` trong deck đó. Điều này đảm bảo tính nhất quán dữ liệu.

### Dữ liệu Seed mặc định

Hệ thống được seed sẵn **8 ngôn ngữ** để người dùng chọn khi tạo bộ thẻ:

| Tên | Mã | Cờ |
|---|---|---|
| English | `en` | 🇺🇸 |
| Vietnamese | `vi` | 🇻🇳 |
| Japanese | `ja` | 🇯🇵 |
| Korean | `ko` | 🇰🇷 |
| French | `fr` | 🇫🇷 |
| Chinese | `zh` | 🇨🇳 |
| Spanish | `es` | 🇪🇸 |
| German | `de` | 🇩🇪 |

---

## 🔄 Luồng Hoạt Động

### Luồng xác thực người dùng

```
[Trang chủ /]
      │
      ├── Chưa đăng nhập → Xem Landing Page → Đăng ký / Đăng nhập
      │       │
      │       ├── Đăng ký thường:  POST /register
      │       │       → Tạo user → Gửi Welcome Email → Vào Dashboard
      │       │
      │       ├── Đăng nhập thường: POST /login (AJAX)
      │       │       → Kiểm tra credentials → Session → Vào Dashboard
      │       │
      │       ├── Google OAuth:  GET /auth/google
      │       │       → Redirect Google → Callback → updateOrCreate User
      │       │       → Vào Dashboard
      │       │
      │       └── Quên mật khẩu: GET /forgot-password
      │               → Nhập email → Gửi OTP → Xác thực OTP (5 phút)
      │               → Đặt mật khẩu mới → Đăng nhập lại
      │
      └── Đã đăng nhập → Tự động chuyển đến /dashboard
```

### Luồng học tập (Study Mode)

```
[Dashboard] → Chọn bộ thẻ → Nhấn "Học ngay"
      │
      ▼
[GET /decks/{id}/study]
      │ StudyController::session()
      │ Load deck + cards (orderBy 'order')
      ▼
[Giao diện học tập - study/session.blade.php]
      │
      ├── Hiển thị thẻ 1: mặt TRƯỚC (từ vựng)
      │         │
      │         ▼ [Click / Spacebar]
      │   Lật thẻ 3D → mặt SAU (nghĩa)
      │         │
      │         ▼ [Nhấn A hoặc D]
      │   ┌─────┴─────┐
      │   │           │
      │  [A]         [D]
      │  Cần ôn lại  Đã thuộc
      │   └─────┬─────┘
      │         ▼
      │   Sang thẻ tiếp theo...
      │
      └── Hết thẻ → [POST /decks/{id}/study/finish]
              │ StudyController::finish()
              │ Tính XP = 10 + (số thẻ × 5)
              │ Cập nhật Streak (chuỗi ngày học)
              ▼
         Màn hình kết quả: +XP 🔥 Streak
```

---

## 🎮 Hệ Thống Gamification

Để tăng động lực học tập, ứng dụng tích hợp hệ thống điểm thưởng:

| Tính năng | Cơ chế |
|---|---|
| **XP Points** | Mỗi phiên học hoàn thành → `10 + (số thẻ × 5)` XP |
| **Streak** | Học ngày hôm qua → +1 ngày liên tiếp. Bỏ ngày → Reset về 1 |
| **last_study_at** | Ghi lại thời gian học để tính toán streak chính xác |

---

## 🔒 Bảo Mật

| Cơ chế | Mô tả |
|---|---|
| **Middleware `auth`** | Bảo vệ toàn bộ route cần đăng nhập; redirect về trang chủ nếu chưa xác thực |
| **Authorization Check** | Controller kiểm tra `deck->user_id === Auth::id()` để ngăn người dùng khác sửa/xóa dữ liệu |
| **Password Hashing** | Mật khẩu được hash bằng `bcrypt` qua `Hash::make()`, không lưu thô |
| **CSRF Protection** | Laravel tự động bảo vệ mọi form POST bằng `@csrf` token |
| **OTP Hashing** | Mã OTP được `Hash::make()` trước khi lưu database |
| **Server-side Validation** | Mọi input đều qua `$request->validate()` phía server |

---

## ⌨️ Phím Tắt Khi Học Thẻ

| Phím | Chức năng |
|---|---|
| `Space` | Lật thẻ (xem mặt sau) |
| `A` | Đánh dấu "Cần ôn lại" 👎 |
| `D` | Đánh dấu "Đã thuộc" 👍 |

---

## 🚀 Hướng Dẫn Cài Đặt

### Yêu cầu hệ thống

- **PHP** >= 8.2
- **Composer** >= 2.x
- **MySQL** >= 8.0
- **Laragon** (Windows) hoặc XAMPP / Laravel Herd

### Bước 1: Clone dự án

```bash
git clone https://github.com/xuanduongdev08/Flashcard-Project.git
cd Flashcard-Project
```

### Bước 2: Cài đặt dependencies

```bash
composer install
```

### Bước 3: Cấu hình môi trường

```bash
# Sao chép file cấu hình mẫu
cp .env.example .env

# Tạo application key
php artisan key:generate
```

Mở file `.env` và cấu hình kết nối database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flashcar_db
DB_USERNAME=root
DB_PASSWORD=
```

### Bước 4: Khởi tạo Database

**Cách 1 — Dùng Migration (Khuyến nghị):**
```bash
php artisan migrate:fresh --seed
```

**Cách 2 — Import SQL trực tiếp:**
> Mở **phpMyAdmin** → Tạo database `flashcar_db` → Import file `database/flashcar_full_schema.sql`

### Bước 5: Tạo symbolic link cho Storage

```bash
php artisan storage:link
```

### Bước 6: Chạy ứng dụng

```bash
# Dùng Laragon: truy cập http://flashcar.test (nếu đã cấu hình Virtual Host)

# Hoặc dùng artisan serve:
php artisan serve
```

> Truy cập: **http://127.0.0.1:8000**

### Tài khoản demo (sau khi seed)

| Thông tin | Giá trị |
|---|---|
| **Email** | `duong@example.com` |
| **Mật khẩu** | `password` |

---

## 📖 Hướng Dẫn Sử Dụng

### 1. Đăng ký / Đăng nhập
- Truy cập trang chủ → Nhấn **"Đăng ký"** để tạo tài khoản mới.
- Hoặc nhấn **"Tiếp tục với Google"** để đăng nhập nhanh bằng Google Account.
- Sau khi đăng ký, hệ thống sẽ gửi **email chào mừng** và hiển thị popup chọn mục tiêu học.

### 2. Tạo bộ thẻ mới
1. Tại Dashboard, nhấn **"+ Tạo bộ thẻ mới"**.
2. Nhập tiêu đề, mô tả, chọn **ngôn ngữ** và **màu sắc**.
3. Nhấn **"Tạo bộ thẻ"** để lưu.

### 3. Thêm thẻ vào bộ thẻ
1. Click vào bộ thẻ vừa tạo để xem chi tiết.
2. Nhấn **"+ Thêm thẻ"**.
3. Nhập **mặt trước** (từ/câu hỏi) và **mặt sau** (nghĩa/đáp án).
4. Lưu → Hệ thống tự động tạo file âm thanh phát âm.

### 4. Học tập
1. Mở bộ thẻ → nhấn **"Học ngay 🚀"**.
2. Click vào thẻ (hoặc nhấn `Space`) để lật thẻ xem nghĩa.
3. Đánh giá bản thân: `D` = Đã thuộc / `A` = Cần ôn lại.
4. Hoàn thành → Nhận **XP Points** và cập nhật **Streak** 🔥.

### 5. Sao chép bộ thẻ (Clone)
- Trên trang chi tiết bộ thẻ → nhấn **"Sao chép bộ thẻ"**.
- Toàn bộ thẻ trong deck sẽ được nhân bản về tài khoản của bạn.

### 6. Quên mật khẩu
1. Nhấn **"Quên mật khẩu"** trên trang đăng nhập.
2. Nhập email → Nhận mã OTP 6 số qua email.
3. Nhập OTP (hiệu lực **5 phút**) → Đặt mật khẩu mới.

---

## 📁 Cấu Trúc Database Schema

```sql
-- Xem file: database/flashcar_full_schema.sql
-- Hoặc chạy lệnh để xem migration:
-- php artisan migrate:status
```

| File | Mô tả |
|---|---|
| `database/flashcar_full_schema.sql` | Schema đầy đủ + dữ liệu seed |
| `database/flashcar_database.sql` | Export database thực tế |
| `database/migrations/` | Lịch sử migration theo thứ tự |

---

<div align="center">

---

Tạo với ❤️ bởi **Nguyễn Xuân Dương**

*Laravel 11 · PHP · Blade Template · MySQL*

</div>
