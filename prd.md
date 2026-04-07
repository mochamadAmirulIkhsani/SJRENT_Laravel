Berikut adalah **PRD Lengkap** untuk **SJRent** – Sistem Manajemen Rental Motor Internal (tanpa pemesanan online) menggunakan **Laravel** dan **Filament** untuk dashboard, serta dilengkapi fitur **Kalender Ketersediaan Motor**.

---

# PRODUCT REQUIREMENTS DOCUMENT (PRD)  
## SJRent – Sistem Rental Motor Internal

| **Versi** | 1.0 Internal |
|-----------|---------------|
| **Platform** | Web (Laravel + Filament) |
| **Target User** | Admin, Pegawai, Kasir (internal rental) |
| **Tanggal** | 2026 |

---

## 1. Overview

**SJRent Internal** adalah sistem manajemen rental motor yang digunakan sepenuhnya oleh **tim internal rental** (pemilik, admin, kasir). Tidak ada halaman publik untuk customer melakukan pemesanan sendiri. Semua proses mulai dari input data pelanggan, pembuatan transaksi sewa, pencatatan pengembalian, pengecekan ketersediaan motor melalui kalender, hingga laporan keuangan dilakukan melalui dashboard admin yang dibangun dengan **Laravel + Filament**.

Tujuan:  
- Mencatat setiap transaksi penyewaan motor secara digital  
- Mengelola stok/ketersediaan motor secara real-time dengan tampilan kalender  
- Memantau pendapatan dan performa rental  
- Menghindari double booking dan kesalahan pencatatan manual  

---

## 2. Requirements

### 2.1 Fungsional

**Dashboard Filament (Single Panel untuk Internal Team)**  
- Autentikasi untuk admin/pegawai (role: super_admin, admin, cashier)  
- **Manajemen Motor**  
  - CRUD motor (nama, plat nomor, kategori, harga per hari, denda per hari, foto, status: tersedia/disewa/maintenance)  
  - Lihat daftar motor dan status terkini  
- **Manajemen Pelanggan**  
  - CRUD pelanggan (nama, no KTP, SIM, no telepon, alamat)  
  - Pelanggan dapat dihapus hanya jika tidak memiliki transaksi aktif  
- **Manajemen Transaksi Sewa** (core)  
  - Buat transaksi baru: pilih pelanggan, pilih motor, tentukan tanggal mulai dan rencana tanggal kembali  
  - Hitung otomatis total biaya (harga per hari x jumlah hari)  
  - Status transaksi: **Berlangsung**, **Selesai**, **Dibatalkan**  
  - Fitur pengembalian motor: hitung denda jika terlambat, catat biaya tambahan  
- **Kalender Ketersediaan Motor** (fitur tambahan)  
  - Tampilan kalender bulanan dengan filter pilih motor atau semua motor  
  - Setiap hari menampilkan status: **Tersedia**, **Dirental** (ongoing), atau **Maintenance**  
  - Klik pada tanggal → lihat daftar motor yang tersedia pada tanggal tersebut  
  - Warna berbeda untuk tiap status (hijau=tersedia, merah=disewa, abu=maintenance)  
  - Dari pop-up daftar motor, bisa langsung klik "Sewa" untuk membuat transaksi baru  
- **Manajemen Pembayaran**  
  - Catat pembayaran di awal sewa (DP/lunas)  
  - Catat pembayaran denda / kekurangan saat pengembalian  
  - Generate struk/invoice (print atau PDF)  
- **Laporan & Statistik**  
  - Laporan transaksi per periode (harian, mingguan, bulanan)  
  - Rekap pendapatan kotor, denda, pendapatan bersih  
  - Laporan motor paling sering disewa  
  - Export ke Excel/PDF  

### 2.2 Non-fungsional

- Performa: halaman dashboard & kalender harus <2 detik untuk 1000 transaksi  
- Keamanan: proteksi SQL injection, XSS, CSRF (Laravel default)  
- Responsif: dashboard dapat diakses dari tablet/HP internal  
- Skalabilitas: siap digunakan untuk 500+ transaksi per bulan  

---

## 3. Core Features (Tabel Ringkasan)

| Modul                     | Fitur Utama                                                                 |
|---------------------------|-----------------------------------------------------------------------------|
| **Manajemen Motor**       | Upload gambar, set status (tersedia/disewa/maintenance), harga, denda       |
| **Manajemen Pelanggan**   | Input data KTP/SIM, riwayat transaksi pelanggan                            |
| **Transaksi Rental**      | Buat sewa baru, cek ketersediaan, proses kembali dengan hitung denda       |
| **Kalender Ketersediaan** | Tampilan bulanan, filter motor, status per hari, klik tanggal untuk lihat motor tersedia, langsung akses buat sewa |
| **Pembayaran**            | Catat pembayaran sewa & denda, cetak invoice                               |
| **Laporan**               | Grafik pendapatan, rekap transaksi, export Excel/PDF                       |
| **Pengaturan**            | Kelola user internal (admin, kasir), pengaturan harga denda default        |

---

## 4. User Flow (Internal)

### 4.1 Alur Transaksi Rental oleh Pegawai

1. Pegawai login ke dashboard `/admin`  
2. Klik menu **Transaksi** → **Tambah Transaksi Baru**  
3. Cari/pilih pelanggan (jika belum ada, klik tombol "Tambah Pelanggan Baru")  
4. Pilih motor dari daftar yang **statusnya tersedia** (bisa juga dari kalender)  
5. Isi form:  
   - Tanggal mulai sewa (default hari ini)  
   - Perkiraan tanggal kembali  
   - (Otomatis hitung total hari & biaya sewa)  
   - Input jumlah pembayaran yang diterima (DP/lunas)  
6. Simpan → status transaksi menjadi **Berlangsung**  
7. Secara otomatis status motor berubah menjadi **Disewa**  
8. Cetak invoice untuk diberikan ke customer  

### 4.2 Alur Pengembalian Motor

1. Pegawai buka menu **Transaksi** → cari transaksi yang sedang berlangsung  
2. Klik tombol **Kembalikan Motor**  
3. Sistem hitung denda jika tanggal kembali melebihi perkiraan:  
   - Denda = (hari telat) x (denda per hari motor)  
4. Input biaya tambahan (opsional, misal: kerusakan ringan)  
5. Catat pembayaran denda / kekurangan  
6. Simpan → status transaksi menjadi **Selesai**  
7. Status motor kembali menjadi **Tersedia**  

### 4.3 Alur Cek Ketersediaan via Kalender

1. Pegawai buka menu **Kalender**  
2. Pilih bulan dan tahun (default bulan berjalan)  
3. Pilih filter:  
   - **Semua motor** → tampilkan agregat jumlah motor tersedia/disewa per hari  
   - **Motor tertentu** → tampilkan status motor tersebut setiap hari  
4. Hari dengan latar merah → motor tertentu sedang dirental (atau ada motor yang disewa jika filter semua)  
5. Klik tanggal tertentu → muncul modal daftar motor yang **tersedia** pada tanggal itu  
6. Dari modal, klik tombol "Sewa" pada motor yang dipilih → langsung diarahkan ke form transaksi dengan tanggal mulai otomatis terisi  

### 4.4 Alur Manajemen Lainnya

- **Tambah motor baru** oleh admin  
- **Lihat laporan pendapatan** dengan filter tanggal  

---

## 5. Arsitektur

```
[ Browser Admin/Kasir ]
         │
         ▼
[ Filament Panel (Laravel) ]
  - Resources: MotorResource, CustomerResource, RentalResource, PaymentResource
  - Custom Livewire Component untuk Kalender (FullCalendar.js)
  - Models & Controllers (Eloquent)
         │
         ▼
[ MySQL Database ]
  - tables: users, motorcycles, categories, customers, rentals, rental_payments
```

- Tidak ada front-end publik. Semua route dilindungi middleware `auth` dan `role` (Spatie Permission).  
- Filament menjadi satu-satunya antarmuka.

---

## 6. Database Schema

### 6.1 `users` (untuk internal staff)
| Kolom         | Tipe                     | Keterangan                          |
|---------------|--------------------------|-------------------------------------|
| id            | bigIncrements            |                                     |
| name          | string                   |                                     |
| email         | string, unique           |                                     |
| password      | string                   |                                     |
| role          | enum / foreign (Spatie)  | super_admin, admin, cashier         |
| timestamps    |                          |                                     |

### 6.2 `motorcycles`
| Kolom               | Tipe                     | Keterangan                                |
|---------------------|--------------------------|-------------------------------------------|
| id                  | bigIncrements            |                                           |
| name                | string                   |                                           |
| category_id         | foreign → categories     |                                           |
| plate_number        | string, unique           |                                           |
| price_per_day       | decimal                  |                                           |
| late_fee_per_day    | decimal                  | denda per hari terlambat                  |
| image               | string, nullable         | path foto                                 |
| status              | enum                     | available, rented, maintenance            |
| timestamps          |                          |                                           |

### 6.3 `categories`
| Kolom         | Tipe          | Keterangan                     |
|---------------|---------------|--------------------------------|
| id            | bigIncrements |                                |
| name          | string        | Matic, Sport, Bebek, Listrik   |
| description   | text, nullable|                                |

### 6.4 `customers`
| Kolom                 | Tipe          | Keterangan                     |
|-----------------------|---------------|--------------------------------|
| id                    | bigIncrements |                                |
| name                  | string        |                                |
| id_card_number        | string, unique| No KTP                         |
| driver_license_number | string, unique| No SIM                         |
| phone                 | string        |                                |
| address               | text, nullable|                                |
| timestamps            |               |                                |

### 6.5 `rentals` (transaksi sewa)
| Kolom                  | Tipe                     | Keterangan                                   |
|------------------------|--------------------------|----------------------------------------------|
| id                     | bigIncrements            |                                              |
| customer_id            | foreign → customers      |                                              |
| motorcycle_id          | foreign → motorcycles    |                                              |
| start_date             | date                     |                                              |
| estimated_return_date  | date                     | perkiraan kembali                            |
| actual_return_date     | date, nullable           |                                              |
| total_rent_days        | integer                  | dihitung dari start ke estimated             |
| total_rent_price       | decimal                  |                                              |
| late_days              | integer, nullable        |                                              |
| late_fee               | decimal, nullable        |                                              |
| additional_fee         | decimal, default 0       | biaya tambahan (kerusakan dll)               |
| grand_total            | decimal                  | total_rent_price + late_fee + additional_fee |
| status                 | enum                     | ongoing, completed, cancelled                |
| created_by             | foreign → users          | siapa yang buat transaksi                    |
| timestamps             |                          |                                              |

**Index untuk performa kalender:**  
`INDEX(start_date, estimated_return_date, motorcycle_id, status)`

### 6.6 `rental_payments`
| Kolom          | Tipe                     | Keterangan                                      |
|----------------|--------------------------|-------------------------------------------------|
| id             | bigIncrements            |                                                 |
| rental_id      | foreign → rentals        |                                                 |
| amount         | decimal                  |                                                 |
| payment_type   | enum                     | rent_down_payment, rent_full, late_fee, additional_fee |
| payment_date   | datetime                 |                                                 |
| notes          | text, nullable           |                                                 |
| created_by     | foreign → users          |                                                 |

### 6.7 (Opsional) `motor_availability_overrides` untuk maintenance terjadwal
| Kolom          | Tipe          | Keterangan                              |
|----------------|---------------|-----------------------------------------|
| id             | bigIncrements |                                         |
| motorcycle_id  | foreign       |                                         |
| date           | date          |                                         |
| status         | enum          | available, maintenance (atau booked)    |
| reason         | string, nullable |                                       |
| created_by     | foreign → users |                                       |

**Relasi:**  
- `rentals` → `customers` (many-to-one)  
- `rentals` → `motorcycles` (many-to-one)  
- `rental_payments` → `rentals` (many-to-one)  

---

## 7. Design & UI Guidelines

### 7.1 Dashboard Filament
- Menggunakan tema default Filament (dark/light mode)  
- **Sidebar:** menu utama (Dashboard, Motor, Pelanggan, Transaksi, Kalender, Laporan, Pengaturan)  
- **Form:** menggunakan komponen Filament: TextInput, Select, DatePicker, FileUpload, dll.  
- **Widget Dashboard:**  
  - Jumlah motor tersedia vs disewa  
  - Pendapatan hari ini  
  - Daftar transaksi yang harus dikembalikan hari ini  

### 7.2 Halaman Kalender (Custom Livewire + FullCalendar.js)
- Tampilan bulan dengan grid  
- **Filter:** dropdown pilih motor (semua atau spesifik)  
- Setiap sel tanggal menampilkan:  
  - Jika filter "semua motor": angka motor tersedia / total motor, dengan warna latar hijau (100% tersedia), kuning (campuran), merah (semua disewa/maintenance)  
  - Jika filter motor tertentu: warna solid hijau (tersedia), merah (disewa), abu (maintenance)  
- Tooltip: daftar motor yang sedang disewa pada hari itu  
- Klik tanggal → modal berisi daftar motor yang tersedia, lengkap dengan tombol "Sewa"  

### 7.3 Invoice & Laporan
- PDF menggunakan `barryvdh/laravel-dompdf`  
- Export Excel menggunakan `Laravel Excel`  

---

## 8. Technical Constraints

| Komponen          | Teknologi / Batasan                                                               |
|-------------------|-----------------------------------------------------------------------------------|
| Backend Framework | Laravel 10 atau 11 (PHP 8.1+)                                                    |
| Admin Panel       | FilamentPHP v3 (dengan Livewire v3)                                              |
| Database          | MySQL 5.7+ / MariaDB 10.2+ (disarankan InnoDB, dengan foreign key)              |
| Front-end (dashboard) | Filament bawaan (Tailwind CSS), custom Livewire untuk kalender                |
| Kalender Library  | FullCalendar.js (integrase via Laravel Mix atau Vite)                            |
| Authentication    | Laravel Breeze (hanya login admin) + Spatie Laravel Permission                   |
| PDF Export        | barryvdh/laravel-dompdf                                                          |
| Excel Export      | Laravel Excel (Maatwebsite)                                                      |
| Deployment        | Shared hosting dengan PHP 8.1+ / VPS (disarankan)                                |
| File Storage      | Local storage (public disk) untuk development, bisa S3 untuk production         |

**Batasan teknis khusus:**  
- Validasi ketersediaan motor: tidak boleh ada dua rental dengan status `ongoing` yang memiliki overlap tanggal untuk motor yang sama.  
- Pengembalian hanya bisa dilakukan jika status rental = `ongoing`.  
- Hanya super admin yang bisa menghapus data pelanggan atau motor (soft delete disarankan).  
- Query kalender harus dioptimasi dengan index dan cache (misal: cache hasil query per bulan selama 1 jam).  

---

## 9. Kesimpulan

Dokumen PRD ini merangkum semua kebutuhan **SJRent versi internal** menggunakan **Laravel + Filament** dengan fitur unggulan **Kalender Ketersediaan Motor**. Sistem ini dirancang untuk memudahkan operasional rental motor sehari-hari, mulai dari pencatatan transaksi, pengembalian, hingga laporan keuangan, tanpa melibatkan customer secara online.

**Langkah implementasi yang disarankan:**  
1. Setup Laravel + Filament + Spatie Permission  
2. Buat migration dan model sesuai skema di atas  
3. Implementasi Filament Resources:  
   - MotorResource  
   - CustomerResource  
   - RentalResource (dengan form dan action return)  
   - PaymentResource (inline atau terpisah)  
4. Buat custom Livewire component untuk kalender (gunakan FullCalendar.js)  
5. Tambahkan validasi overlap tanggal di model Rental  
6. Buat widget laporan dan export PDF/Excel  
7. Testing dan deployment  

Dengan mengikuti PRD ini, tim pengembang dapat membangun sistem yang tepat guna, mudah digunakan, dan siap untuk dikembangkan lebih lanjut (misalnya menambahkan notifikasi atau integrasi pembayaran digital) di masa depan.