# 📚 Hệ thống Học tập Flashcar (Modern Flashcard System)

Chào mừng bạn đến với **Flashcar** - một ứng dụng học tập qua thẻ ghi nhớ hiện đại, được xây dựng bằng Laravel với phong cách thiết kế **GenZ Aesthetic** (Glassmorphism, Dark Mode, Minimalist).

## ✨ Tính năng nổi bật

*   **Bảng điều khiển Bento-grid:** Quản lý bộ thẻ trực quan và hiện đại.
*   **Thiết kế GenZ:** Sử dụng font **Be Vietnam Pro**, hiệu ứng lật thẻ mượt mà, bo góc và bảng màu Dark Slate cao cấp.
*   **Học tập tương tác:** Chế độ học thẻ (Study Mode) với thanh tiến độ, phím tắt và màn hình tổng kết kết quả.
*   **Việt hóa 100%:** Toàn bộ giao diện, thông báo và tin nhắn hệ thống đã được bản địa hóa sang tiếng Việt.
*   **Quản lý đa ngôn ngữ:** Hỗ trợ học nhiều ngôn ngữ khác nhau (Tiếng Anh, Nhật, Hàn, Pháp, v.v.).
*   **Tìm kiếm & Lọc:** Tìm kiếm bộ thẻ nhanh chóng theo tên hoặc ngôn ngữ.

## 🛠 Công nghệ sử dụng

*   **Framework:** Laravel 11.x
*   **Frontend:** Blade Templates + Tailwind CSS
*   **Tương tác:** Alpine.js (cho phần học thẻ)
*   **Cơ sở dữ liệu:** MySQL (Laragon mặc định)
*   **Typography:** Be Vietnam Pro (Google Fonts)

## 📂 Cấu trúc dự án chính

*   `app/Models`: Chứa các Model (`User`, `Language`, `Deck`, `Card`).
*   `app/Http/Controllers`: Logic xử lý Dashboard, Decks, Cards và Study Session.
*   `database/migrations`: Cấu trúc bảng cơ sở dữ liệu.
*   `resources/views`: Toàn bộ giao diện Blade (đã được Việt hóa).
*   `routes/web.php`: Các tuyến đường (routes) của ứng dụng.

## ⌨️ Phím tắt khi học thẻ

Khi đang ở trong chế độ học tập, bạn có thể sử dụng bàn phím để học nhanh hơn:
*   **Phím Cách (Space):** Lật thẻ để xem đáp án.
*   **Phím A:** Đánh dấu là "Cần ôn lại" (👎).
*   **Phím D:** Đánh dấu là "Đã thuộc" (👍).

## 🚀 Hướng dẫn cài đặt nhanh

1.  **Di chuyển vào thư mục dự án:**
    ```bash
    cd Flashcar
    ```
2.  **Cài đặt các thư viện (Composer):**
    ```bash
    composer install
    ```
3.  **Cấu hình môi trường:**
    *   Mở file `.env` và đảm bảo thông tin kết nối Database chính xác (Mặc định là `flashcar_db`).
4.  **Khởi tạo Database và Dữ liệu mẫu:**
    ```bash
    php artisan migrate:fresh --seed
    ```
5.  **Chạy ứng dụng:**
    *   Nếu dùng Laragon, bạn chỉ cần nhấn nút **Web** hoặc truy cập `http://flashcar.test` (nếu đã cấu hình Virtual Host).
    *   Hoặc dùng lệnh: `php artisan serve`.

---
*Tạo bởi ❤️ bởi Nguyen Xuan Duong*
