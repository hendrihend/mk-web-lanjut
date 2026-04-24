# Module CRUD Marketing Users - Laravel 13

Module CRUD lengkap untuk mengelola data Marketing Users pada aplikasi Laravel.

## 📋 Fitur

- ✅ **Create** - Tambah marketing user baru
- ✅ **Read** - Lihat daftar dan detail marketing user
- ✅ **Update** - Edit data marketing user
- ✅ **Delete** - Hapus marketing user
- ✅ **Search & Filter** - Cari berdasarkan nama, email, phone, status, department, territory
- ✅ **Pagination** - Tampilan data dengan pagination (15 per halaman)
- ✅ **Validation** - Validasi input data lengkap
- ✅ **Responsive Design** - UI responsive menggunakan Bootstrap 5

## 📁 Struktur File

```
app/
├── Http/Controllers/
│   └── MarketingUserController.php
└── Models/
    └── MarketingUser.php

database/
├── factories/
│   └── MarketingUserFactory.php
├── migrations/
│   └── 2026_04_11_000003_create_marketing_users_table.php
└── seeders/
    └── MarketingUserSeeder.php

resources/views/
└── marketing-users/
    ├── index.blade.php      # Daftar users
    ├── create.blade.php     # Form tambah user
    ├── edit.blade.php       # Form edit user
    └── show.blade.php       # Detail user

routes/
└── web.php                  # Route configuration

layouts/
└── app.blade.php            # Main layout template
```

## 🚀 Cara Setup

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Jalankan Seeder (Opsional - untuk test data)
```bash
php artisan db:seed --class=MarketingUserSeeder
```

Atau jalankan semua seeder:
```bash
php artisan db:seed
```

### 3. Akses Aplikasi
- List Marketing Users: `http://localhost:8000/marketing-users`
- Tambah User Baru: `http://localhost:8000/marketing-users/create`

## 📊 Database Schema

```sql
CREATE TABLE marketing_users (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  phone VARCHAR(20),
  position VARCHAR(100),
  department VARCHAR(100),
  territory VARCHAR(100),
  status ENUM('active', 'inactive') DEFAULT 'active',
  notes TEXT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX (department),
  INDEX (territory),
  INDEX (status)
);
```

## 🔄 API Routes

| Method | URI | Action | Description |
|--------|-----|--------|-------------|
| GET | /marketing-users | index | Tampil daftar users |
| GET | /marketing-users/create | create | Form tambah user |
| POST | /marketing-users | store | Simpan user baru |
| GET | /marketing-users/{id} | show | Tampil detail user |
| GET | /marketing-users/{id}/edit | edit | Form edit user |
| PUT/PATCH | /marketing-users/{id} | update | Update user |
| DELETE | /marketing-users/{id} | destroy | Hapus user |

## 🎨 Field Marketing User

| Field | Type | Validasi | Keterangan |
|-------|------|----------|-----------|
| name | String (255) | Required | Nama marketing user |
| email | String (255) | Required, Unique, Email | Email address |
| phone | String (20) | Optional | Nomor telepon |
| position | String (100) | Optional | Posisi/Jabatan |
| department | String (100) | Optional | Departemen |
| territory | String (100) | Optional | Wilayah |
| status | Enum [active/inactive] | Required | Status user |
| notes | Text | Optional | Catatan tambahan |

## 🔍 Filter & Search

Module mendukung filter berdasarkan:
- **Search** - Cari nama, email, atau phone
- **Status** - Filter aktif/tidak aktif
- **Department** - Filter berdasarkan departemen
- **Territory** - Filter berdasarkan wilayah

## 🛡️ Validasi

### Create/Update Validasi:
```php
'name' => 'required|string|max:255',
'email' => 'required|email|unique:marketing_users',
'phone' => 'nullable|string|max:20',
'position' => 'nullable|string|max:100',
'department' => 'nullable|string|max:100',
'territory' => 'nullable|string|max:100',
'status' => 'required|in:active,inactive',
'notes' => 'nullable|string',
```

## 💡 Contoh Penggunaan Scopes

```php
// Ambil semua marketing users yang aktif
$activeUsers = MarketingUser::active()->get();

// Filter berdasarkan department
$marketingDept = MarketingUser::byDepartment('Marketing')->get();

// Filter berdasarkan territory
$jakartaTeam = MarketingUser::byTerritory('Jakarta')->get();

// Kombinasi scopes
$result = MarketingUser::active()
    ->byDepartment('Marketing')
    ->byTerritory('Jakarta')
    ->get();
```

## 🧪 Testing Data

Menggunakan Factory untuk generate test data:

```php
// Generate 50 marketing users
MarketingUser::factory(50)->create();

// Generate dengan state custom
MarketingUser::factory()
    ->count(10)
    ->create([
        'status' => 'active',
        'department' => 'Marketing'
    ]);
```

## 📝 Catatan

- Email harus unik di seluruh sistem
- Status user adalah `active` atau `inactive`
- Pagination default 15 data per halaman
- Semua field optional kecuali: name, email, status
- Soft delete tidak diimplementasikan (hard delete)

## 🔐 Keamanan

- CSRF Protection di semua form
- Mass Assignment Protection dengan `$fillable`
- Validation di server-side
- SQL Injection protection via Eloquent ORM

## 📚 Lebih Lanjut

Untuk customize lebih lanjut:
- Edit `app/Http/Controllers/MarketingUserController.php` untuk logic
- Edit views di `resources/views/marketing-users/` untuk tampilan
- Edit model di `app/Models/MarketingUser.php` untuk relasi atau scope baru

---

**Versi:** 1.0.0  
**Project:** Marketing Users Management System  
**Framework:** Laravel 12/13  
**Build Date:** April 11, 2026
