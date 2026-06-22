-- PostgreSQL Schema and Seed Data for Macha (Supabase)

CREATE SCHEMA IF NOT EXISTS macha;
SET search_path TO macha;

-- Drop tables if they exist
DROP TABLE IF EXISTS sales_detail CASCADE;
DROP TABLE IF EXISTS product_ratings CASCADE;
DROP TABLE IF EXISTS products CASCADE;
DROP TABLE IF EXISTS categories CASCADE;
DROP TABLE IF EXISTS order_types CASCADE;
DROP TABLE IF EXISTS payment_methods CASCADE;
DROP TABLE IF EXISTS sales CASCADE;
DROP TABLE IF EXISTS settings CASCADE;
DROP TABLE IF EXISTS testimonials CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- 1. categories
CREATE TABLE categories (
  id SERIAL PRIMARY KEY,
  category_name VARCHAR(100) NOT NULL
);

INSERT INTO categories (id, category_name) VALUES 
(5, 'Matcha Series'),
(17, 'OG Matcha');

SELECT setval(pg_get_serial_sequence('categories', 'id'), coalesce(max(id), 1)) FROM categories;


-- 2. order_types
CREATE TABLE order_types (
  id SERIAL PRIMARY KEY,
  type_name VARCHAR(50) NOT NULL,
  type_code VARCHAR(20) NOT NULL,
  is_active SMALLINT NOT NULL DEFAULT 1
);

INSERT INTO order_types (id, type_name, type_code, is_active) VALUES 
(1, 'Ambil Sendiri', 'takeaway', 1),
(2, 'Antar ke Rumah', 'delivery', 1);

SELECT setval(pg_get_serial_sequence('order_types', 'id'), coalesce(max(id), 1)) FROM order_types;


-- 3. payment_methods
CREATE TABLE payment_methods (
  id SERIAL PRIMARY KEY,
  method_name VARCHAR(50) NOT NULL,
  method_code VARCHAR(20) NOT NULL,
  description TEXT,
  is_active SMALLINT NOT NULL DEFAULT 1
);

INSERT INTO payment_methods (id, method_name, method_code, description, is_active) VALUES 
(1, ' QRIS', 'QRIS', 'BCA 1234567890 a/n MariMacha', 1),
(2, 'Bayar di Tempat (COD)', 'cod', 'Bayar saat menerima pesanan', 1);

SELECT setval(pg_get_serial_sequence('payment_methods', 'id'), coalesce(max(id), 1)) FROM payment_methods;


-- 4. product_ratings
CREATE TABLE product_ratings (
  id SERIAL PRIMARY KEY,
  product_id INTEGER,
  full_name VARCHAR(100),
  rating INTEGER,
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO product_ratings (id, product_id, full_name, rating, comment, created_at) VALUES 
(1, 5, 'Xepher User', 4, '', '2026-04-06 16:03:22'),
(2, 5, 'Pengolah Data', 5, '', '2026-04-06 16:19:00'),
(3, 0, 'Pengolah Data', 5, '', '2026-04-06 16:36:50'),
(4, 5, 'Fikri Bintang', 5, '', '2026-05-06 12:02:45');

SELECT setval(pg_get_serial_sequence('product_ratings', 'id'), coalesce(max(id), 1)) FROM product_ratings;


-- 5. products
CREATE TABLE products (
  id SERIAL PRIMARY KEY,
  category_id INTEGER REFERENCES categories(id) ON DELETE SET NULL,
  sku VARCHAR(50) UNIQUE,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) DEFAULT 0.00,
  stock INTEGER DEFAULT 0,
  image VARCHAR(255) DEFAULT 'default.jpg',
  is_featured SMALLINT NOT NULL DEFAULT 0,
  highlight_label VARCHAR(255),
  highlight_desc TEXT,
  feature_tag VARCHAR(100)
);

INSERT INTO products (id, category_id, sku, name, description, price, stock, image, is_featured, highlight_label, highlight_desc, feature_tag) VALUES 
(4, 5, NULL, 'Matcha Choco', '', 17000.00, 5, 'macha_1774795285.png', 1, 'Choco yg melimpah', 'Matcha yg premium bercampur dengan choco yg manis.', 'Manis'),
(5, 5, NULL, 'Matcha Strawberry', 'Matcha dengan strawberry yg menyegarkan hari hari mu.', 18000.00, 15, 'macha_1774804063.png', 1, 'Matcha yg ter mixed dengan strawberry', 'Matcha dengan strawberry yg menyegarkan hari hari mu.', 'Manis dan asam strawberry'),
(6, 5, NULL, 'Matcha Cookie', '', 19000.00, 32, 'macha_1775055499.png', 1, 'Cookies yg crunchy beserta matcha yg sweet', '', 'Manis'),
(8, 17, NULL, 'Original Matcha', '', 18000.00, 44, 'macha_1775055523.png', 0, '', '', '');

SELECT setval(pg_get_serial_sequence('products', 'id'), coalesce(max(id), 1)) FROM products;


-- 6. sales
CREATE TABLE sales (
  id SERIAL PRIMARY KEY,
  invoice_no VARCHAR(20) NOT NULL,
  total_price INTEGER NOT NULL,
  customer_name VARCHAR(100),
  phone VARCHAR(20),
  address TEXT,
  google_maps_link TEXT,
  notes TEXT,
  payment_method VARCHAR(50) NOT NULL,
  status VARCHAR(50) DEFAULT 'completed',
  payment_proof VARCHAR(255),
  card_number VARCHAR(4),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  user_id INTEGER,
  order_type VARCHAR(50)
);

INSERT INTO sales (id, invoice_no, total_price, customer_name, phone, address, google_maps_link, notes, payment_method, status, payment_proof, card_number, created_at, user_id, order_type) VALUES 
(1, 'INV20260317153525', 20000, 'meldi', NULL, NULL, NULL, NULL, 'Tunai', 'completed', NULL, NULL, '2026-03-17 22:35:46', 2, NULL),
(2, 'INV20260317155641', 5000, 'meldi', NULL, NULL, NULL, NULL, 'Tunai', 'completed', NULL, NULL, '2026-03-17 22:57:03', 2, NULL),
(3, 'INV20260317160631', 0, 'meldi', NULL, NULL, NULL, NULL, 'Tunai', 'completed', NULL, NULL, '2026-03-17 23:06:47', 2, NULL),
(4, 'INV20260317161310', 0, 'meldi', NULL, NULL, NULL, NULL, 'Tunai', 'completed', NULL, NULL, '2026-03-17 23:13:15', 2, NULL),
(5, 'INV20260317161640', 10000, 'meldi', NULL, NULL, NULL, NULL, 'Tunai', 'completed', NULL, NULL, '2026-03-17 23:17:05', 2, NULL),
(6, 'INV20260320102815', 5000, 'meldi', NULL, NULL, NULL, NULL, 'QRIS', 'completed', NULL, NULL, '2026-03-20 10:28:39', 2, NULL),
(7, 'INV-20260329-836B5', 51000, 'Pelanggan ABC', '081296184614', 'CIKUPA CITRA RAYA', NULL, 'JANGAN TERLALU MANIS', '', 'pending', NULL, NULL, '2026-03-29 14:47:05', 2, NULL),
(8, 'INV-20260329-00678', 17000, 'Pelanggan ABC', '0812947816481', 'Cikupa Citra Raya', NULL, '', '', 'completed', NULL, NULL, '2026-03-29 15:44:58', 2, NULL),
(9, 'INV20260329171359', 18000, 'CEPO', NULL, NULL, NULL, NULL, 'Tunai', 'completed', NULL, NULL, '2026-03-29 17:14:11', 1, NULL),
(10, 'INV-20260329-B9694', 34000, 'Pelanggan ABC', '081296184614', 'idahhdijada', NULL, 'JANGAN TERLALU MANIS', '', 'pending', NULL, NULL, '2026-03-29 17:30:31', 2, NULL),
(11, 'INV-20260329-2C6C6', 86000, 'Pengolah Data', '08772812812', 'sasasa', NULL, '', '', 'pending', NULL, NULL, '2026-03-29 17:45:37', 1, NULL),
(12, 'INV-20260329-81E03', 52000, 'Pengolah Data', '', '', NULL, '', '', 'pending', NULL, NULL, '2026-03-29 17:52:38', 1, NULL),
(13, 'INV-20260329-6EADA', 18000, 'Pengolah Data', '', '', NULL, '', '', 'pending', NULL, NULL, '2026-03-29 17:54:11', 1, NULL),
(14, 'INV-20260329-D21EE', 18000, 'Pelanggan ABC', '', '', NULL, '', '', 'pending', NULL, NULL, '2026-03-29 18:00:05', 2, NULL),
(15, 'INV-20260329-8FA3C', 53000, 'Pelanggan ABC', '', '', NULL, '', '', 'pending', NULL, NULL, '2026-03-29 18:02:51', 2, NULL),
(16, 'INV-20260329-BEB8E', 52000, 'Pelanggan ABC', '', '', NULL, '', '', 'completed', NULL, NULL, '2026-03-29 18:15:32', 2, NULL),
(17, 'INV-20260329-866F5', 55000, 'Pelanggan ABC', '', '', NULL, '[System Auto-Verified: Bank BCA | Nominal Rp 55.000]', '', 'completed', 'PAY-INV-20260329-866F5-1774808588.png', NULL, '2026-03-29 18:22:44', 2, NULL),
(18, 'INV-20260329-38D51', 37000, 'Pelanggan ABC', '087786720942', 'aku di indonesia', NULL, '[System Auto-Verified: Bank GOPAY | Nominal Rp 37.000]', '', 'completed', 'PAY-INV-20260329-38D51-1774809364.png', NULL, '2026-03-29 18:35:41', 2, NULL),
(19, 'INV-20260330-7861D', 35000, 'Xepher User', '08772812812', 'Pasir Gadung, Cikupa, Kabupaten Tangerang, Banten, Jawa', 'https://www.google.com/maps?q=-6.215647,106.52439', 'Extra Strawberry', '', 'pending', NULL, NULL, '2026-03-30 15:18:52', 3, NULL),
(20, 'INV-20260330-EFFC7', 18000, 'Xepher User', '081297841468648', 'Pasir Gadung, Cikupa, Kabupaten Tangerang, Banten, Jawa', 'https://www.google.com/maps?q=-6.215647,106.52439', '', '', 'pending', NULL, NULL, '2026-03-30 15:31:28', 3, NULL),
(21, 'INV-20260401-DF77E', 18000, 'Xepher User', '081297841468648', 'Jalan Gatot Subroto, Manis Jaya, Jatiuwung, Tangerang, Curug', 'https://www.google.com/maps?q=-6.20801704443951,106.566986', '[System Auto-Verified: Bank BCA | Nominal Rp 18.000]', 'QRIS', 'paid', 'PAY-INV-20260401-DF77E-1775012153.png', NULL, '2026-04-01 02:55:30', 3, NULL),
(22, 'INV-20260401-0EE3E', 36000, 'Xepher User', '087786720942', 'Jalan Gatot Subroto, Manis Jaya, Jatiuwung, Tangerang, Curug', 'https://www.google.com/maps?q=-6.208016891990143,106.56698313312229', 'No Ice, Hot Only', 'QRIS', 'pending', NULL, NULL, '2026-04-01 15:31:02', 3, NULL),
(23, 'INV-20260401-4E1D5', 52000, 'Fikri', '0846373737', 'Jalan Gatot Subroto, Manis Jaya, Jatiuwung, Tangerang, Curug', 'https://www.google.com/maps?q=-6.2082198,106.5671221', 'Extra Ice', '', 'pending', NULL, NULL, '2026-04-01 15:33:51', 4, NULL),
(24, 'INV-20260401-59DB6', 17000, 'Fikri', '085747484', 'Jalan Gatot Subroto, Manis Jaya, Jatiuwung, Tangerang, Curug', 'https://www.google.com/maps?q=-6.2082504,106.5671403', 'Less Sugar, Extra Ice
[System Auto-Verified: Bank BCA | Nominal Rp 17.000]', '', 'paid', 'PAY-INV-20260401-59DB6-1775032682.jpg', NULL, '2026-04-01 15:37:32', 4, NULL),
(25, 'INV-20260401-876E2', 20000, 'Fikri', '085748493', 'Jalan Gatot Subroto, Manis Jaya, Jatiuwung, Tangerang, Curug', 'https://www.google.com/maps?q=-6.2082414,106.5671338', 'Extra Ice, No Sugar
[System Auto-Verified: Bank Mandiri | Nominal Rp 20.000]', '', 'paid', 'PAY-INV-20260401-876E2-1775037643.jpg', NULL, '2026-04-01 17:00:26', 4, NULL),
(26, 'INV-20260401-E254E', 18000, 'Aji putra', '085277865267', 'Karawaci Baru, Karawaci, Tangerang, Banten, Jawa', 'https://www.google.com/maps?q=-6.1973351,106.6146368', 'Tanya saja warung madura depan lapangan cuma 1 itu doang warung titip disitu ya', '', 'pending', NULL, NULL, '2026-04-01 19:10:31', 5, NULL),
(27, 'INV-20260401-D6976', 17000, 'someone', '0876517891651', 'bugel', '', '', '', 'pending', NULL, NULL, '2026-04-01 19:25:04', 6, NULL),
(28, 'INV-20260401-856C4', 52000, 'aku purnomo', '+6287786720942', 'Pasir Jaya, Cikupa, Kabupaten Tangerang, Banten, Jawa', 'https://www.google.com/maps?q=-6.2019333,106.5342117', '[System Auto-Verified: Bank GOPAY | Nominal Rp 52.000]', 'QRIS', 'completed', 'PAY-INV-20260401-856C4-1775053593.jpg', NULL, '2026-04-01 21:26:01', 7, NULL),
(29, 'INV-20260401-1F911', 18000, 'Xepher User', '08772812812', '', 'https://www.google.com/maps?q=-6.2154495,106.524502', 'No Sugar', 'QRIS', 'completed', NULL, NULL, '2026-04-01 21:36:48', 3, NULL),
(30, 'INV-20260401-449EE', 17000, 'Xepher User', '08585858', 'Pasir Gadung, Cikupa, Kabupaten Tangerang, Banten, Jawa', 'https://www.google.com/maps?q=-6.2154842,106.5243573', 'Hot Only, Extra Creamy, No Sugar', '', 'completed', NULL, NULL, '2026-04-01 22:44:50', 3, NULL),
(31, 'INV-20260402-85DBE', 19000, 'Xepher User', '081288383738', 'Pasir Gadung, Cikupa, Kabupaten Tangerang, Banten, Jawa', 'https://www.google.com/maps?q=-6.2155042,106.5243697', 'Extra Creamy', 'QRIS', 'completed', NULL, NULL, '2026-04-02 08:12:28', 3, NULL),
(32, 'INV-20260402-4017F', 18000, 'Xepher User', '085881705459', 'Perum Griya Yasa Blok G6 No09, Talagasari, Cikupa , Kab.Tangerang', '', 'No Sugar, Extra Sugar
[System Auto-Verified: Bank GOPAY | Nominal Rp 18.000]', 'QRIS', 'completed', 'PAY-INV-20260402-4017F-1775132155.jpg', NULL, '2026-04-02 19:14:39', 3, NULL),
(33, 'INV-20260404-DE835', 18000, NULL, '089389794334', 'Margasari, Karawaci, Tangerang, Banten, Jawa', NULL, 'buruan', 'Transfer', 'completed', NULL, NULL, '2026-04-04 13:07:38', 9, 'delivery'),
(34, 'INV-20260406-E5E46', 35000, NULL, '081297841468648', 'Jalan Gatot Subroto, Manis Jaya, Jatiuwung, Tangerang, Curug', NULL, 'Less Sugar', '', 'pending', NULL, NULL, '2026-04-06 15:41:07', 3, 'delivery'),
(35, 'INV-20260406-9103F', 17000, NULL, '085881705459', 'Jalan Gatot Subroto, Manis Jaya, Jatiuwung, Tangerang, Curug', NULL, 'No Ice', '', 'pending', NULL, NULL, '2026-04-06 16:11:05', 3, 'delivery'),
(36, 'INV-20260406-7F1D7', 18000, NULL, '08772812812', '', NULL, 'Less Sugar', '', 'pending', NULL, NULL, '2026-04-06 16:31:24', 1, 'takeaway'),
(37, 'INV-20260410-87B7D', 18000, NULL, '08999999', 'Margasari, Karawaci, Tangerang, Banten, Jawa', NULL, 'Less Sugar', '', 'pending', NULL, NULL, '2026-04-10 19:00:49', 10, 'delivery'),
(38, 'INV-20260413-D5AC8', 18000, NULL, '087786720942', '', NULL, '', '', 'pending', NULL, NULL, '2026-04-13 09:49:54', 3, 'takeaway'),
(39, 'INV-20260421-72F73', 37000, NULL, '08772812812', '', NULL, '', '', 'pending', NULL, NULL, '2026-04-21 15:25:02', 3, 'takeaway'),
(40, 'INV-20260428-2CD4B', 34000, 'Binbin', '085881705459', '', '', 'No Ice
[User Uploaded Proof: Bank QRIS | Nominal Rp 34.000]', '', 'paid', 'PAY-INV-20260428-2CD4B-1777364983.jpeg', NULL, '2026-04-28 15:29:15', 11, 'takeaway'),
(41, 'INV-20260603-DB162', 17000, 'Fikri Bintang Purnomo', '085881705459', 'Perum Griya Yasa Blok G6 No09, Talagasari, Cikupa , Kab.Tangerang', '', 'Pisah Es
[User Uploaded Proof: Bank QRIS | Nominal Rp 17.000]', '', 'paid', 'PAY-INV-20260603-DB162-1780456711.png', NULL, '2026-06-03 10:18:17', 0, 'delivery'),
(42, 'INV-20260603-BDBE0', 17000, 'Fikri bintang P', '081292870932', '', '', 'Less Ice', '', 'pending', NULL, NULL, '2026-06-03 04:08:24', 13, 'takeaway'),
(43, 'INV-20260603-20DCE', 17000, 'Fikri bintang P', '081292870932', '', '', '', '', 'pending', NULL, NULL, '2026-06-03 04:16:42', 13, 'takeaway');

SELECT setval(pg_get_serial_sequence('sales', 'id'), coalesce(max(id), 1)) FROM sales;


-- 7. sales_detail
CREATE TABLE sales_detail (
  id SERIAL PRIMARY KEY,
  sales_id INTEGER,
  product_id INTEGER,
  qty INTEGER,
  price INTEGER,
  subtotal INTEGER,
  item_notes TEXT
);

INSERT INTO sales_detail (id, sales_id, product_id, qty, price, subtotal, item_notes) VALUES 
(1, 1, 1, 4, 5000, 20000, NULL),
(2, 2, 1, 1, 5000, 5000, NULL),
(3, 3, 1, 1, 0, 0, NULL),
(4, 4, 1, 1, 0, 0, NULL),
(5, 5, 1, 2, 5000, 10000, NULL),
(6, 6, 2, 1, 5000, 5000, NULL),
(7, 7, 4, 3, 17000, 51000, NULL),
(8, 8, 4, 1, 17000, 17000, NULL),
(9, 9, 8, 1, 18000, 18000, NULL),
(10, 10, 4, 2, 17000, 34000, NULL),
(11, 11, 9, 4, 17000, 68000, NULL),
(12, 11, 5, 1, 18000, 18000, NULL),
(13, 12, 4, 2, 17000, 34000, NULL),
(14, 12, 5, 1, 18000, 18000, NULL),
(15, 13, 5, 1, 18000, 18000, NULL),
(16, 14, 5, 1, 18000, 18000, NULL),
(17, 15, 5, 2, 18000, 36000, NULL),
(18, 15, 4, 1, 17000, 17000, NULL),
(19, 16, 4, 2, 17000, 34000, NULL),
(20, 16, 5, 1, 18000, 18000, NULL),
(21, 17, 5, 2, 18000, 36000, NULL),
(22, 17, 6, 1, 19000, 19000, NULL),
(23, 18, 4, 1, 17000, 17000, NULL),
(24, 18, 11, 1, 20000, 20000, NULL),
(25, 19, 4, 1, 17000, 17000, NULL),
(26, 19, 5, 1, 18000, 18000, NULL),
(27, 20, 5, 1, 18000, 18000, NULL),
(28, 21, 5, 1, 18000, 18000, NULL),
(29, 22, 5, 2, 18000, 36000, NULL),
(30, 23, 4, 2, 17000, 34000, NULL),
(31, 23, 5, 1, 18000, 18000, NULL),
(32, 24, 4, 1, 17000, 17000, NULL),
(33, 25, 7, 1, 20000, 20000, NULL),
(34, 26, 5, 1, 18000, 18000, NULL),
(35, 27, 4, 1, 17000, 17000, NULL),
(36, 28, 4, 2, 17000, 34000, NULL),
(37, 28, 5, 1, 18000, 18000, NULL),
(38, 29, 5, 1, 18000, 18000, NULL),
(39, 30, 4, 1, 17000, 17000, NULL),
(40, 31, 6, 1, 19000, 19000, NULL),
(41, 32, 5, 1, 18000, 18000, NULL),
(42, 33, 5, 1, 18000, 18000, 'Less Ice, Less Sugar, Less Creamy'),
(43, 34, 4, 1, 17000, 17000, 'Extra Ice, Extra Creamy'),
(44, 34, 5, 1, 18000, 18000, 'Extra Sugar, Less Creamy'),
(45, 35, 4, 1, 17000, 17000, 'Extra Creamy, Extra Sugar'),
(46, 36, 5, 1, 18000, 18000, 'No Sugar, Less Creamy'),
(47, 37, 5, 1, 18000, 18000, ''),
(48, 38, 5, 1, 18000, 18000, 'Less Sugar, Extra Sugar'),
(49, 39, 5, 1, 18000, 18000, 'Extra Sugar, Less Creamy, Pisah Es'),
(50, 39, 6, 1, 19000, 19000, 'Extra Sugar, No Sugar'),
(51, 40, 4, 2, 17000, 34000, 'Less Creamy'),
(52, 41, 4, 1, 17000, 17000, 'No Sugar'),
(53, 42, 4, 1, 17000, 17000, ''),
(54, 43, 4, 1, 17000, 17000, '');

SELECT setval(pg_get_serial_sequence('sales_detail', 'id'), coalesce(max(id), 1)) FROM sales_detail;


-- 8. settings
CREATE TABLE settings (
  id SERIAL PRIMARY KEY,
  setting_key VARCHAR(255) UNIQUE NOT NULL,
  setting_value TEXT
);

INSERT INTO settings (id, setting_key, setting_value) VALUES 
(1, 'shop_address', 'Outlet Marimacha
Citra Raya, Kel. Citra Raya, Kec. Citra Raya,
Kab. Tangerang, Banten '),
(2, 'shop_logo', 'ChatGPT_Image_Mar_30,_2026,_12_23_48_AM.png'),
(3, 'whatsapp_number', ''),
(4, 'shop_status', 'open'),
(5, 'qris_barcode', 'WhatsApp_Image_2026-04-13_at_10_02_02.jpeg'),
(6, 'shop_open_hour', '09:00'),
(7, 'shop_close_hour', '18:00'),
(8, 'shop_close_reason', ''),
(9, 'shop_pause_until', '');

SELECT setval(pg_get_serial_sequence('settings', 'id'), coalesce(max(id), 1)) FROM settings;


-- 9. testimonials
CREATE TABLE testimonials (
  id SERIAL PRIMARY KEY,
  user_id INTEGER,
  name VARCHAR(100) NOT NULL,
  location VARCHAR(100),
  stars INTEGER DEFAULT 5,
  quote TEXT NOT NULL,
  is_visible SMALLINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO testimonials (id, user_id, name, location, stars, quote, is_visible, created_at) VALUES 
(1, NULL, 'Rina Kusuma', 'Jakarta Selatan', 5, 'Matchanya enak banget! Seger, nggak terlalu manis. Udah langganan setiap minggu. Recommended banget buat matcha lovers!!', 1, '2026-04-02 02:11:49'),
(2, NULL, 'Dimas Prasetyo', 'Bekasi', 5, 'Pelayanan ramah, pengiriman cepat. Packaging juga rapi dan tebal, jadi aman di jalan. Puas banget belanja di MariMacha!', 1, '2026-04-02 02:11:49'),
(3, NULL, 'Sari Dewi', 'Tangerang', 5, 'Udah coba beberapa varian dan semuanya juara. Signature iced matcha jadi favorit di kantor sekarang. Makasih ya!', 1, '2026-04-02 02:11:49'),
(4, NULL, 'Ilyas Dermawan', 'Bugel', 4, 'Matcha lovers ni bos', 1, '2026-04-02 02:19:44'),
(5, NULL, 'Mas Ilyas', 'Margasari', 5, 'We kenzi', 1, '2026-04-02 07:49:26');

SELECT setval(pg_get_serial_sequence('testimonials', 'id'), coalesce(max(id), 1)) FROM testimonials;


-- 10. users
CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(100),
  email VARCHAR(150),
  phone VARCHAR(20),
  address TEXT,
  profile_image VARCHAR(255) DEFAULT 'default_user.png',
  oauth_provider VARCHAR(50),
  oauth_uid VARCHAR(100),
  role VARCHAR(50) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (id, username, password, full_name, email, phone, address, profile_image, oauth_provider, oauth_uid, role, created_at) VALUES 
(1, 'admin', 'admin123', 'Pengolah Data', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'admin', '2026-03-25 17:44:56'),
(2, 'abc', '$2y$10$5oEFIJLC84AeXptkwBaOW.DfZ3PvNrlXTapnrP.dDzbNBoF1AuPG.', 'xepher', NULL, '087786720942', 'aku di indonesia', 'default_user.png', NULL, NULL, 'user', '2026-03-25 17:44:56'),
(3, 'xepher', '$2y$10$RhbVdoUTPNOSRDdI67rrDuFlrtrpFsIgXS8S5B7s.5Y6NQwuNayHW', 'Fikri Bintang', NULL, '08772812812', 'depok sonoan lagi', 'user_3_1775468523.png', NULL, NULL, 'user', '2026-03-30 06:40:12'),
(4, 'fikribn123@gmail.com', 'Ifik0102@', 'Fikri', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-04-01 08:32:29'),
(5, 'aji', 'Aj123456', 'Aji putra', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-04-01 12:05:44'),
(6, 'kcelyaz@gmail.com', '123456', 'someone', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-04-01 12:20:54'),
(7, 'purnomoganteng', 'Purnomo123', 'aku purnomo', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-04-01 14:24:46'),
(8, 'abi', '123456', 'abi', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-04-02 15:20:50'),
(9, 'firlo', '111111', 'firlo raja iblis', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-04-04 06:05:01'),
(10, 'bija', '12345678abc', 'Nabila Jahat', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-04-10 11:58:59'),
(11, 'binbin', 'Ifik0102', 'Binbin', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-04-28 08:28:28'),
(12, 'isagi', 'isagi123', 'Fikri Bintang', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-05-06 04:28:06'),
(13, 'fikribn123290', '$2y$10$2WIrWaqB6.TCzSQuR0flzuUQfUXKLof3R376qKyjzabKSOtcFUyRy', 'Fikri bintang P', 'fikribn123@gmail.com', '', '', 'user_13_1780459144.png', 'google', '6MEkAkJiJnRmMbNghxxJCkSllDb2', 'user', '2026-06-02 20:58:33'),
(14, 'ANJAYANI', 'manager123', 'ANJAY', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-06-02 23:13:40'),
(15, 'ISAGIAMBA', 'ISAGIAMBA', 'XEPHERR', NULL, NULL, NULL, 'default_user.png', NULL, NULL, 'user', '2026-06-02 23:18:51'),
(16, 'test652', '$2y$10$chBi2.YZlIjF4Ozn3gjdhu9pemx6JjrDOorIdmBkwxaRBGuT0IXjG', 'Test', 'test@example.com', NULL, NULL, 'test.jpg', 'google', '123', 'user', '2026-06-03 00:10:41'),
(17, 'starchiatto719', '$2y$10$104AULqJ4NC9ioVdrITwJOIXQVtiPll.U3/fOskdlr30UCSrTqIOK', 'Star Chiatto', 'starchiatto@gmail.com', NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocLc6e7x_3oVrd80FAnWuXIkAyF4uZnOq-eJ564YgIfaYJji8w=s96-c', 'google', '9iuIH9ib68f46FBM5LGrAe8tXxH2', 'user', '2026-06-11 12:09:42');

SELECT setval(pg_get_serial_sequence('users', 'id'), coalesce(max(id), 1)) FROM users;
