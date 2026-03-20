-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table flashcar_db.cache: ~0 rows (approximately)

-- Dumping data for table flashcar_db.cache_locks: ~0 rows (approximately)

-- Dumping data for table flashcar_db.cards: ~9 rows (approximately)
INSERT INTO `cards` (`id`, `deck_id`, `front`, `back`, `order`, `audio_path`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Ubiquitous', 'Phổ biển-Present, appearing, or found everywhere.', 1, NULL, '2026-03-19 16:01:42', '2026-03-19 10:01:17'),
	(2, 1, 'Ephemeral', 'Chớm tàn- Lasting for a very short time.', 2, NULL, '2026-03-19 16:01:42', '2026-03-19 10:01:52'),
	(3, 1, 'Pragmatic', 'Thực dụng-Dealing with things sensibly and realistically.', 3, NULL, '2026-03-19 16:01:42', '2026-03-19 10:02:21'),
	(4, 1, 'Eloquent', 'Hùng biện-Fluent or persuasive in speaking or writing.', 4, NULL, '2026-03-19 16:01:42', '2026-03-19 10:02:49'),
	(5, 1, 'Resilient', 'Đàn hồi-Able to recover quickly from difficulties.', 5, NULL, '2026-03-19 16:01:42', '2026-03-19 10:03:29'),
	(6, 2, 'Hạnh phúc', 'Happiness - trạng thái vui vẻ, mãn nguyện', 1, NULL, '2026-03-19 16:01:42', '2026-03-19 09:21:29'),
	(7, 2, 'Kiên trì', 'Perseverance-Không bỏ cuộc trước khó khăn.', 2, NULL, '2026-03-19 16:01:42', '2026-03-19 09:58:43'),
	(8, 2, 'Sáng tạo', 'Creative-Khả năng tạo ra cái mới.', 3, NULL, '2026-03-19 16:01:42', '2026-03-19 09:58:56'),
	(9, 2, 'Tri thức', 'Knowledge- Hiểu biết thu được qua học tập.', 4, NULL, '2026-03-19 16:01:42', '2026-03-19 09:59:13'),
	(10, 2, 'Bình yên', 'Peaceful-yên ổn, thanh bình', 5, NULL, '2026-03-19 09:56:36', '2026-03-19 09:59:25'),
	(11, 1, 'Father', 'Ba, Bố-a male parent of a child or an animal; a person who is acting as the father to a child', 6, NULL, '2026-03-19 10:05:12', '2026-03-19 20:35:07'),
	(12, 3, 'Konnichiwa (こんにちは)', 'Là câu chào phổ biến nhất, có thể dùng chung cho cả ngày.', 1, NULL, '2026-03-19 10:11:19', '2026-03-19 10:11:19'),
	(13, 3, 'Arigatou gozaimasu (ありがとうございます)', 'Cảm ơn (trang trọng).', 2, NULL, '2026-03-19 10:12:05', '2026-03-19 10:12:05'),
	(14, 4, 'Hallo', 'Xin chào', 1, NULL, '2026-03-19 20:56:01', '2026-03-19 20:56:01'),
	(15, 4, 'Entschuldigung', 'Xin lỗi (để làm phiền/ngắt lời)', 2, NULL, '2026-03-19 20:56:28', '2026-03-19 20:56:28'),
	(16, 5, 'Konnichiwa (こんにちは)', 'Là câu chào phổ biến nhất, có thể dùng chung cho cả ngày.', 1, NULL, '2026-03-19 23:48:20', '2026-03-19 23:48:20'),
	(17, 5, 'Arigatou gozaimasu (ありがとうございます)', 'Cảm ơn (trang trọng).', 2, NULL, '2026-03-19 23:48:20', '2026-03-19 23:48:20'),
	(18, 5, 'Sensei (せんせい)', 'Thầy giáo / Cô giáo / Bác sĩ.', 3, NULL, '2026-03-19 23:57:50', '2026-03-19 23:57:50'),
	(19, 6, 'Sashihikaeru (差し控える)', 'Kiềm chế, từ chối làm việc gì đó (lịch sự).', 1, NULL, '2026-03-20 05:27:15', '2026-03-20 05:27:15'),
	(20, 6, 'Saiyousuru (採用する)', 'Tuyển dụng, áp dụng', 2, NULL, '2026-03-20 05:27:55', '2026-03-20 05:27:55'),
	(21, 6, 'Dayori nai (頼りない)', 'Không đáng tin, yếu ớt.', 3, NULL, '2026-03-20 05:32:11', '2026-03-20 05:32:11'),
	(22, 6, 'Aza-yaka (鮮やか)', 'Rực rỡ, chói lọi, nổi bật.', 4, NULL, '2026-03-20 05:32:35', '2026-03-20 05:32:35'),
	(23, 8, 'Bâng khuâng', 'Trạng thái tình cảm mơ hồ, vừa luyến tiếc, vừa nhớ nhung', 1, NULL, '2026-03-20 06:26:28', '2026-03-20 06:26:28'),
	(24, 8, 'Hối hả', 'Trạng thái vội vã, gấp gáp', 2, NULL, '2026-03-20 06:27:10', '2026-03-20 06:27:10'),
	(25, 8, 'Viên mãn', 'Sự đầy đủ, trọn vẹn và tốt đẹp nhất', 3, NULL, '2026-03-20 06:27:41', '2026-03-20 06:27:41');

-- Dumping data for table flashcar_db.decks: ~2 rows (approximately)
INSERT INTO `decks` (`id`, `user_id`, `language_id`, `title`, `description`, `color`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Basic English Vocabulary-With VN meaning', 'Essential English words for everyday communication.', '#10B981', '2026-03-19 16:01:42', '2026-03-19 10:05:39'),
	(2, 1, 2, 'Từ Vựng Tiếng Việt-Anh', 'Các từ vựng tiếng Việt và Tiếng Anh', '#06B6D4', '2026-03-19 16:01:42', '2026-03-19 10:00:10'),
	(3, 1, 3, 'JAPANESE VOCABULARY', 'Learn Japanese easy with XDFLCAR.', '#EC4899', '2026-03-19 10:06:51', '2026-03-19 10:06:51'),
	(4, 1, 8, 'LEARN GERMAN WITH ME', 'Lern Deutsch mit mir!', '#F59E0B', '2026-03-19 20:54:40', '2026-03-19 20:54:40'),
	(5, 2, 3, 'JAPANESE VOCABULARY CỦA ANH BẢY', 'Learn Japanese easy with ANH BẢY', '#EC4899', '2026-03-19 23:48:20', '2026-03-19 23:49:07'),
	(6, 2, 3, 'TIẾNG NHẬT N2 CỦA ANH BẢY', 'LÊN TRÌNH CÙNG ANH BẢY', '#10B981', '2026-03-20 05:26:55', '2026-03-20 05:26:55'),
	(8, 3, 2, 'TIẾNG VIỆT CÙNG MÌNH', 'HỌC TIẾNG VIỆT VỚI TUI NHENG', '#06B6D4', '2026-03-20 06:25:09', '2026-03-20 06:25:09');

-- Dumping data for table flashcar_db.failed_jobs: ~0 rows (approximately)

-- Dumping data for table flashcar_db.jobs: ~1 rows (approximately)
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(1, 'default', '{"uuid":"e001fbee-b81c-4a20-a308-8d94d1c9cd8e","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:11;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1773977884,"delay":null}', 0, NULL, 1773977884, 1773977884),
	(2, 'default', '{"uuid":"541f01c3-4e92-4c23-9e70-bd1758528d84","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:14;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1773978961,"delay":null}', 0, NULL, 1773978961, 1773978961),
	(3, 'default', '{"uuid":"9b42f674-c393-47d6-aa7a-a17e5bf571b5","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:15;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1773978988,"delay":null}', 0, NULL, 1773978988, 1773978988),
	(4, 'default', '{"uuid":"6b4ec6a5-f331-4bb5-830e-8036c683cfc6","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:18;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1773989870,"delay":null}', 0, NULL, 1773989870, 1773989870),
	(5, 'default', '{"uuid":"27ccc731-f8e6-4420-9cd9-3bcc78fc7f66","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:19;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1774009635,"delay":null}', 0, NULL, 1774009635, 1774009635),
	(6, 'default', '{"uuid":"178fb6c5-82aa-49dc-8fa7-a5f2de56a70c","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:20;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1774009675,"delay":null}', 0, NULL, 1774009675, 1774009675),
	(7, 'default', '{"uuid":"ee5f9717-90da-4ae6-90c9-0cfbddcc696d","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:21;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1774009931,"delay":null}', 0, NULL, 1774009931, 1774009931),
	(8, 'default', '{"uuid":"eb3d0991-9403-47d8-8a18-2c9807204ea5","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:22;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1774009955,"delay":null}', 0, NULL, 1774009955, 1774009955),
	(9, 'default', '{"uuid":"31794df2-ae96-4ab5-89bb-e98416633dd3","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:23;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1774013188,"delay":null}', 0, NULL, 1774013188, 1774013188),
	(10, 'default', '{"uuid":"527d90a7-0060-418d-ade8-d33f7bd5d9fc","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:24;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1774013230,"delay":null}', 0, NULL, 1774013230, 1774013230),
	(11, 'default', '{"uuid":"d921dd9e-0b50-4e96-81e5-0803ddf6e1b1","displayName":"App\\\\Jobs\\\\GenerateCardAudio","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"App\\\\Jobs\\\\GenerateCardAudio","command":"O:26:\\"App\\\\Jobs\\\\GenerateCardAudio\\":1:{s:7:\\"\\u0000*\\u0000card\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Card\\";s:2:\\"id\\";i:25;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}","batchId":null},"createdAt":1774013261,"delay":null}', 0, NULL, 1774013261, 1774013261);

-- Dumping data for table flashcar_db.job_batches: ~0 rows (approximately)

-- Dumping data for table flashcar_db.languages: ~8 rows (approximately)
INSERT INTO `languages` (`id`, `name`, `code`, `flag_emoji`, `tts_code`, `created_at`, `updated_at`) VALUES
	(1, 'English', 'en', '🇺🇸', 'en-US', '2026-03-19 16:01:42', '2026-03-19 20:19:44'),
	(2, 'Vietnamese', 'vi', '🇻🇳', 'vi-VN', '2026-03-19 16:01:42', '2026-03-19 20:19:44'),
	(3, 'Japanese', 'ja', '🇯🇵', 'ja-JP', '2026-03-19 16:01:42', '2026-03-19 20:19:44'),
	(4, 'Korean', 'ko', '🇰🇷', 'ko-KR', '2026-03-19 16:01:42', '2026-03-19 20:19:44'),
	(5, 'French', 'fr', '🇫🇷', 'fr-FR', '2026-03-19 16:01:42', '2026-03-19 20:19:44'),
	(6, 'Chinese', 'zh', '🇨🇳', 'zh-CN', '2026-03-19 16:01:42', '2026-03-19 20:19:44'),
	(7, 'Spanish', 'es', '🇪🇸', 'es-ES', '2026-03-19 16:01:42', '2026-03-19 20:19:44'),
	(8, 'German', 'de', '🇩🇪', 'de-DE', '2026-03-19 16:01:42', '2026-03-19 20:19:44');

-- Dumping data for table flashcar_db.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2026_03_20_030910_add_tts_columns_to_tables', 1),
	(2, '0001_01_01_000002_create_jobs_table', 2),
	(3, '2026_03_20_045714_update_users_table_for_gamification', 3);

-- Dumping data for table flashcar_db.password_reset_tokens: ~0 rows (approximately)

-- Dumping data for table flashcar_db.sessions: ~0 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('3XZSqLRJwiYhlqn81G7f68Gw6He1V8jFG6KsUuX2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiJNcWluSFFDNmkzQUE2WkxTYVhkbGk5QU5yQW5GbnltQzl4NXB3aElMIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvTWluaVByb2plY3RfTkdVWUVOWFVBTkRVT05HXC9GbGFzaGNhclwvcHVibGljIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1774005672),
	('5QKcEaIJrtPPhd1zYAwBbzHnmkGA0Q9BOiataubA', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiJpaHNzOE9EZUtsM0hESER6N1JsM0x5WndOU2E4Q3Zob3dQZ2ExRXVDIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0XC9NaW5pUHJvamVjdF9OR1VZRU5YVUFORFVPTkdcL0ZsYXNoY2FyXC9wdWJsaWMiLCJyb3V0ZSI6ImhvbWUifSwic3RhdGUiOiI5Q3FPS1dldkRYWmNWUXBnUkQ4Mk96Q0RMV3RxWE92bmdQdFQ0RFU5In0=', 1774011504),
	('b5oewZZRE44PKSUxcBk2XNNrJpKPrwPYeme7HRLR', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiJsblVDOUhDelZlNHVvWTJUOGxOanlQREYwOE9PTDBpOVNubzlMNk52IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvTWluaVByb2plY3RfTkdVWUVOWFVBTkRVT05HXC9GbGFzaGNhclwvcHVibGljIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1774005672),
	('oNvVfUyEgf24CE4ktXWDlKN6ouki4RISVzUtbUMi', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiI2UkRQV0t4b1ZRSkg4NU1uUlFaeFBoa285N0NLeVBaZjFLbmJldU9GIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvTWluaVByb2plY3RfTkdVWUVOWFVBTkRVT05HXC9GbGFzaGNhclwvcHVibGljXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==', 1773991410);

-- Dumping data for table flashcar_db.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `learning_goal`, `xp_points`, `streak_count`, `last_study_at`, `email_verified_at`, `password`, `provider_id`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Nguyen Xuan Duong', 'duong@example.com', NULL, NULL, 0, 0, NULL, NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2026-03-19 16:01:42', '2026-03-19 16:01:42'),
	(2, 'Anh Bảy thích Tiếng Nhật', 'djxuanduong01@gmail.com', NULL, 'Japanese', 90, 1, '2026-03-20 05:33:25', NULL, '$2y$12$acJXKHNnhhu5LBWOmfXzFeqGIGiEazSxTpgAKIxXyaQzLSJJpXfXm', NULL, 'rXhY30DZyylH38XzOiYiY7A3bpbK6jjO8i44WX355XIsxPO6QHw3y4BrqTod', '2026-03-19 23:21:54', '2026-03-20 14:54:09'),
	(3, 'Devxd Nguyen', 'devxdnguyen@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocKPhPY6z9M_VXD31VsEdHmJmeuziGLe36Qtln97P1LCpI0w2w=s96-c', NULL, 25, 1, '2026-03-20 06:28:16', NULL, '$2y$12$/AAUJeRTyaOARKb7gGj9cuMCcQOeadkZj6N4v3kmZU3psM6LXpmtG', '108227697885068943431', NULL, '2026-03-20 06:21:14', '2026-03-20 06:28:16');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
