# AGENT.md

# Project Overview

Project Name:
Palma - Villa Booking, PMS (Property Management System) & Marketing CMS

Stack:
- Laravel 11
- PostgreSQL
- TailwindCSS
- AlpineJS
- Spatie Permission
- Laravel Fortify (Auth)
- Laravel Socialite (OAuth)
- Yajra Laravel DataTables
- Diglactic Laravel Breadcrumbs
- Spatie Laravel Sluggable
- Intervention Image v3
- Laravel Pint (Linter)

Architecture:
Modular Monolith

---

# Goal

Membangun platform terintegrasi untuk booking villa (frontend & booking engine), Property Management System / PMS (backend pengelolaan operasional, reservasi, housekeeping, dan tarif), serta sistem pemasaran & pembuatan konten artikel/blog (CMS dengan SEO optimasi).

Sistem harus scalable agar dapat digunakan oleh:
- Single Villa / Private Owner
- Multi-Villa / Property Management Group
- Boutique Resort / Multi-Unit Properties

Semua fitur operasional wajib mempertimbangkan konsep Multi-Property (Multi-Tenant).

---

# Multi-Property Concept

Project menggunakan Single Database Multi Tenant.
Bukan satu database per properti/villa.

Semua data operasional properti dipisahkan menggunakan:
```
property_id
```

Setiap query operasional wajib memfilter menggunakan `property_id` aktif untuk menjaga integritas data antar villa/properti, kecuali untuk data global.

---

# Hierarchy

```
Company
│
└── Property (Villa Group / Resort)
    ├── Room Unit (Unit Kamar / Villa Unit)
    ├── Booking & Reservation (Transaksi Sewa & Layanan)
    ├── Housekeeping (Jadwal & Status Kebersihan)
    ├── Inventory Stock (Amenities & Supplies)
    ├── Property Service & Facility (F&B, Transport, Tour)
    └── Property Employee (Staff / Receptionist)
```

---

# Authentication

User login menggunakan email.
Setelah login, user memiliki:
```
User
Role
Permission
Accessible Properties
```

User dapat memiliki akses ke lebih dari satu properti.
Contoh:
```
User A (Manager)
├── Villa Seminyak
└── Villa Ubud
```

Super Admin memiliki akses penuh ke seluruh properti dan manajemen sistem global.

---

# Authorization

Gunakan Role Based Access Control (RBAC).

Role contoh:
- **Super Admin**: Akses seluruh sistem global, setting global, multi-property management.
- **Owner**: Akses ke seluruh properti miliknya, laporan finansial, dan performa bisnis.
- **Villa Manager**: Mengelola operasional properti tertentu, mengatur harga, review artikel pemasaran.
- **Receptionist**: Mengelola booking, check-in/out, melayani tamu, input transaksi tambahan.
- **Housekeeping**: Memantau status kebersihan unit villa, melaporkan kerusakan/kebutuhan unit.
- **Content/Marketing Writer**: Menulis artikel blog, mengelola SEO metadata properti, merilis konten promosi.
- **Guest**: Melakukan booking secara mandiri, melihat riwayat booking, menulis ulasan (jika registrasi aktif).

Permission hanya mengatur tindakan spesifik:
```
create booking
update rate_plan
assign housekeeping
create article
publish article
view financial_report
```

Sedangkan `property_id` menentukan data properti mana yang boleh diakses.

---

# Data Scope

Semua query operasional harus mengikuti properti aktif.
Contoh:
```php
Booking::where('property_id', auth()->user()->current_property_id);
```
Jangan pernah mengambil seluruh data tanpa filter properti kecuali dalam konteks global dashboard oleh Super Admin.

---

# Global Tables
Tidak memiliki `property_id`.
Contoh:
- `companies`
- `roles`
- `permissions`
- `users`
- `article_categories` (Kategori artikel global / blog)
- `articles` (Konten artikel pemasaran global)
- `global_settings`

# Property Tables
Harus memiliki `property_id`.
Contoh:
- `room_units` (Unit spesifik villa)
- `bookings` (Transaksi pemesanan villa)
- `payments` (Pencatatan pembayaran DP / pelunasan)
- `rate_plans` (Paket harga musiman / weekend)
- `housekeepings` (Log & jadwal kebersihan)
- `extra_services` (Layanan F&B, rental motor, spa)
- `property_settings` (Setting lokal properti seperti koordinat, check-in time)

---

# Room & Pricing Strategy

Villa Unit / Room Unit merupakan inventaris utama properti.
Harga sewa bersifat dinamis berdasarkan kalender ketersediaan dan musim (season rates).

Gunakan skema tabel rate plan untuk fleksibilitas harga:
```
rate_plans

id
property_id
name
base_price
weekend_price
season_type (low, high, peak)
start_date
end_date
status
```

Ketersediaan villa (availability calendar) harus dilacak per hari untuk mencegah double booking.

---

# Marketing & Article System

Bagian pemasaran didesain agar mempermudah pembuatan konten promosi villa untuk meningkatkan SEO dan mendatangkan traffic organik (Direct Booking).

### 1. Struktur Artikel SEO-Friendly
Tabel `articles` wajib menampung struktur metadata SEO lengkap:
- `title` & `slug` (menggunakan generator otomatis `Spatie Laravel Sluggable`).
- `content` (isi artikel / blog post promosi).
- `featured_image` (gambar utama artikel yang sudah dikompres dengan `ImageService`).
- `meta_title`, `meta_description`, `meta_keywords` (untuk optimasi pencarian di Google).
- `status` (`draft`, `published`, `scheduled`).
- `published_at` (untuk mendukung penjadwalan konten).

### 2. Fitur Content Assistant (AI Prompt Template)
Sistem CMS artikel harus memiliki integrasi/penyediaan template prompt untuk memudahkan copywriter membuat artikel promosi villa (misal: "Review Wisata Sekitar Villa", "Tips Liburan di Bali").

---

# Developer Guide & Client Code Patterns

Untuk memudahkan pemahaman dan pengembangan kode, ikuti standar / antarmuka "Client Code" berikut:

### 1. Models & UUID
Setiap model utama wajib memiliki kolom `id` (primary key auto-increment internal) dan `uuid` (untuk public exposure / url).
- Gunakan trait `App\Models\Traits\HasUuid` untuk generate UUID otomatis saat record dibuat.
- Override `getRouteKeyName` untuk binding route menggunakan `uuid`.
- Gunakan SoftDeletes jika model tersebut memerlukan pengamanan data dari penghapusan permanen.
```php
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model {
    use HasUuid, SoftDeletes;
    
    public function getRouteKeyName(): string {
        return 'uuid';
    }
}
```

### 2. Yajra DataTables (Server-side Table)
Untuk list data yang kompleks (seperti daftar booking atau daftar artikel), gunakan Yajra DataTables dengan layout custom Tailwind + Remix Icons.
- Definisikan class DataTable di `app/DataTables/` (contoh: `BookingDataTable.php`).
- Atur CSS styling tabel di method `html()` menggunakan class Tailwind agar seragam dengan UI yang ada.
- Gunakan controller untuk merender class DataTable tersebut:
```php
public function index(BookingDataTable $dataTable) {
    return $dataTable->render('booking.index');
}
```

### 3. Controller & Request Validation
- Pastikan controller bersih dari logic bisnis yang berat.
- Gunakan Form Request khusus untuk validasi data input (contoh: `StoreBookingRequest`).
- Kirim data ke view menggunakan structured array `$this->data`.

### 4. Settings System Helper
Untuk mengakses/menyimpan konfigurasi aplikasi global:
- Gunakan helper `settings()` yang mengembalikan array metadata.
- Atau panggil static method pada model `Setting`:
  - `Setting::getValue('key', $default)` (mendukung deserialisasi otomatis jika bertipe array/JSON).
  - `Setting::setValue(['key1' => 'val1', 'key2' => 'val2'])` (mendukung upsert dan auto-serialize).
  - `Setting::deleteOldFile('key')` untuk membersihkan disk dari file lama jika di-overwrite.

### 5. Breadcrumbs
Aplikasi menggunakan `diglactic/laravel-breadcrumbs`. Setiap halaman/route baru wajib didaftarkan breadcrumb-nya di `routes/breadcrumbs.php` agar mempermudah navigasi user.

### 6. Image Resizing & Compression
- Untuk mengunggah gambar villa atau gambar featured artikel blog, gunakan `App\Services\ImageService` yang memanfaatkan `Intervention Image v3` untuk kompresi dan scale aspect-ratio secara otomatis guna menghemat penyimpanan dan mengoptimalkan load time (penting untuk skor SEO).

---


# Coding Rules

- Gunakan Service Layer.
- Jangan letakkan business logic di Controller.
- Gunakan Repository bila query kompleks.
- Validasi menggunakan Form Request.
- Gunakan Policy untuk Authorization.
- Hindari Query Builder di Blade.
- Hindari N+1 Query.

# Naming Convention

Gunakan bahasa Inggris untuk database, file, variable, class, dan function.

Contoh:
- `Property` (Bukan `Properti`)
- `Booking` (Bukan `Pemesanan` / `Reservasi`)
- `Housekeeping` (Bukan `Kebersihan`)
- `Guest` (Bukan `Tamu`)
- `Article` (Bukan `Artikel`)

---

# Migration Rule

Seluruh tabel operasional properti wajib memiliki:
```
property_id
```
Foreign key wajib dibuat dan mengarah ke tabel `properties`. Gunakan cascade sesuai kebutuhan.

---

# Future Features

Platform dikembangkan untuk mudah diintegrasikan dengan fitur masa depan:
- **Channel Manager (OTA Sync)**: Sinkronisasi ketersediaan villa via iCal dengan Airbnb, Agoda, Booking.com.
- **Payment Gateway**: Integrasi pembayaran deposit/DP otomatis (Midtrans/Xendit).
- **AI Content Generator**: Pembuatan draf artikel promosi villa otomatis berbasis AI langsung dari dashboard admin.
- **Dynamic Season Pricing**: Perubahan harga sewa secara otomatis mengikuti musim liburan (peak season).
- **Guest Portal / WhatsApp Notification**: Pengiriman tiket booking digital dan reminder check-in melalui WhatsApp API.

Jangan membuat desain yang menghambat fitur-fitur tersebut.

---

# AI Instruction

Saat menghasilkan kode:
- **Selalu pertimbangkan konsep Multi-Property**: Gunakan scope `property_id` di query, database migration, dan policy.
- **Kelola Status Booking dengan Benar**: Gunakan enum/state status booking yang jelas (`draft`, `pending`, `confirmed`, `checked_in`, `checked_out`, `cancelled`).
- **Maksimalkan SEO untuk Artikel**: Saat membuat modul artikel, pastikan terdapat validasi metadata SEO (meta description minimal 120 karakter, slug unik).
- **Gunakan Laravel Best Practice**: Terapkan Form Request, Service Layer, HasUuid, dan Clean Code.
- **Ikuti struktur project yang sudah ada**: Konsisten dengan penulisan DataTables, Form Request, controller, dan route binding menggunakan UUID.
- **Prioritaskan performance**: Pastikan query ketersediaan villa bebas dari N+1 query.