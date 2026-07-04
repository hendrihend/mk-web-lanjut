# User Sales Module Documentation

## Deskripsi Modul
Modul User Sales adalah sistem manajemen data sales di project problem-solving-composer. Modul ini memungkinkan pengguna untuk mengelola data sales personnel termasuk quota, achievement, dan commission.

## File-file yang Dibuat

### 1. Model (`app/Models/UserSales.php`)
- Menggunakan trait `HasFactory` untuk mendukung factory testing
- Fields yang tersedia:
  - `user_id`: Foreign key ke tabel users (nullable)
  - `sales_name`: Nama sales personnel
  - `email`: Email (unique)
  - `phone`: Nomor telepon (nullable)
  - `region`: Region/Area
  - `quota`: Target penjualan (decimal)
  - `achievement`: Pencapaian penjualan (decimal)
  - `commission_rate`: Tingkat komisi dalam persen (decimal)
  - `status`: Status (active/inactive)
  - `notes`: Catatan tambahan

**Methods & Scopes:**
- `scopeActive()`: Filter status aktif
- `scopeByRegion()`: Filter berdasarkan region
- `scopeSearch()`: Pencarian berdasarkan nama atau email
- `getAchievementPercentageAttribute()`: Hitung persentase pencapaian
- `getCommissionAttribute()`: Hitung komisi berdasarkan achievement dan commission_rate

### 2. Migration (`database/migrations/2026_04_25_000001_create_user_sales_table.php`)
- Membuat tabel `user_sales` dengan struktur lengkap
- Menambahkan indexes untuk performa query

### 3. Factory (`database/factories/UserSalesFactory.php`)
- Factory untuk membuat dummy data dalam testing
- Menggunakan Faker untuk generate data realista
- Relasi dengan User factory

### 4. Seeder (`database/seeders/UserSalesSeeder.php`)
- Seeder untuk mengisi database dengan 15 data dummy
- Sudah diintegrasikan ke DatabaseSeeder

### 5. Controller (`app/Http/Controllers/UserSalesController.php`)
- Resource controller dengan CRUD operations:
  - `index()`: List semua user sales dengan fitur filter dan search
  - `create()`: Tampilkan form create
  - `store()`: Simpan data baru
  - `show()`: Tampilkan detail user sales
  - `edit()`: Tampilkan form edit
  - `update()`: Update data
  - `destroy()`: Hapus data

**Fitur:**
- Filter berdasarkan search (nama/email) dan region
- Pagination
- Validasi form yang lengkap

### 6. Views
#### index.blade.php
- List semua user sales dalam tabel
- Filter section dengan search dan region
- Menampilkan quota, achievement, persentase pencapaian, dan komisi
- Action buttons (view, edit, delete)
- Pagination

#### create.blade.php
- Form untuk membuat user sales baru
- Validasi client-side
- Fields: sales_name, email, phone, region, quota, achievement, commission_rate, status, notes

#### edit.blade.php
- Form untuk mengedit data user sales
- Pre-filled dengan data existing
- Struktur sama dengan create form

#### show.blade.php
- Tampilkan detail lengkap user sales
- Menampilkan info tambahan seperti created_at dan updated_at
- Action buttons (edit, delete, kembali)

### 7. Routes (`routes/web.php`)
- Menambahkan resource route: `Route::resource('user-sales', UserSalesController::class);`
- Routes yang tersedia:
  - GET `/user-sales` → index
  - GET `/user-sales/create` → create
  - POST `/user-sales` → store
  - GET `/user-sales/{id}` → show
  - GET `/user-sales/{id}/edit` → edit
  - PUT `/user-sales/{id}` → update
  - DELETE `/user-sales/{id}` → destroy

### 8. DatabaseSeeder (`database/seeders/DatabaseSeeder.php`)
- Sudah diupdate untuk memanggil UserSalesSeeder

## Cara Menggunakan

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Seed Data (Optional)
```bash
php artisan db:seed --class=UserSalesSeeder
```
atau seed semua data:
```bash
php artisan db:seed
```

### 3. Akses Module
- Navigate ke `/user-sales` untuk melihat list user sales
- Gunakan "Tambah User Sales" button untuk create
- Click view/edit untuk melihat/edit detail
- Click delete untuk menghapus data

## Fitur-Fitur Unggulan

1. **Achievement Tracking**: Otomatis hitung persentase pencapaian
2. **Commission Calculation**: Otomatis hitung komisi berdasarkan achievement dan rate
3. **Filter & Search**: Filter berdasarkan region dan search berdasarkan nama/email
4. **Responsive Design**: Menggunakan Bootstrap 5 dan AdminLTE
5. **Pagination**: Data ditampilkan dengan pagination 10 items per page
6. **Status Badge**: Visual indicator untuk status (aktif/tidak aktif) dan pencapaian

## Validasi Input

- `sales_name`: Required, string, max 255 chars
- `email`: Required, email, unique
- `phone`: Optional, string, max 20 chars
- `region`: Required, string, max 100 chars
- `quota`: Required, numeric, min 0
- `achievement`: Required, numeric, min 0
- `commission_rate`: Required, numeric, 0-100
- `status`: Required, enum (active/inactive)
- `notes`: Optional, string

## Database Relationships

- UserSales `belongsTo` User (foreign key: user_id)
- User `hasMany` UserSales (inverse)

## Table Structure
```
user_sales:
  - id (Primary Key)
  - user_id (Foreign Key, nullable)
  - sales_name
  - email (unique)
  - phone
  - region
  - quota
  - achievement
  - commission_rate
  - status (enum: active, inactive)
  - notes
  - created_at
  - updated_at
  - Indexes: region, status, email
```

---
**Created**: April 25, 2026
**Framework**: Laravel 11
**Template**: Bootstrap 5 + AdminLTE
