# 🏪 Sistem Manajemen Kantin

Aplikasi web untuk mengelola transaksi keuangan kantin dengan interface admin yang modern menggunakan Laravel dan Filament.

## 📋 Daftar Isi

- [Tentang Project](#tentang-project)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Fitur](#fitur)
- [Instalasi](#instalasi)
- [Penggunaan](#penggunaan)
- [Struktur Database](#struktur-database)
- [Struktur Project](#struktur-project)
- [Kelengkapan](#kelengkapan)
- [Kekurangan & Perbaikan](#kekurangan--perbaikan)
- [Kontribusi](#kontribusi)

## 🎯 Tentang Project

Sistem Manajemen Kantin adalah aplikasi web yang dirancang untuk membantu pengelolaan transaksi keuangan kantin. Aplikasi ini menyediakan dashboard admin untuk mencatat pemasukan dan pengeluaran dengan kategorisasi yang jelas.

## 🛠️ Teknologi yang Digunakan

- **Framework Backend**: Laravel 12.x
- **PHP Version**: ^8.2
- **Admin Panel**: Filament 4.0
- **Database**: MySQL
- **Frontend Build Tool**: Vite 7.x
- **CSS Framework**: TailwindCSS 4.x
- **Package Manager**: Composer & NPM

### Dependencies Utama
```json
{
  "filament/filament": "4.0",
  "flowframe/laravel-trend": "^0.4.0",
  "laravel/framework": "^12.0"
}
```

## ✨ Fitur

### 🔧 Fitur yang Sudah Ada

1. **Dashboard Admin**
   - Widget statistik overview (Total Pemasukan, Pengeluaran, Selisih)
   - Filter berdasarkan tanggal

2. **Manajemen Kategori**
   - CRUD kategori produk
   - Toggle jenis kategori (Pemasukan/Pengeluaran)
   - Upload gambar kategori
   - Soft delete

3. **Manajemen Transaksi**
   - CRUD transaksi
   - Relasi dengan kategori
   - Upload bukti gambar
   - Pencatatan tanggal transaksi
   - Catatan/note untuk setiap transaksi

4. **Sistem Autentikasi**
   - Login admin menggunakan Filament Auth

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd kantin
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kantin_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Migrasi Database**
```bash
php artisan migrate
```

6. **Buat Admin User**
```bash
php artisan make:filament-user
```

7. **Build Assets**
```bash
npm run build
```

8. **Jalankan Server**
```bash
php artisan serve
```

Akses admin panel di: `http://localhost:8000/admin`

## 📊 Struktur Database

### Tabel `categories`
```sql
- id (bigint, primary key)
- nama_produk (string)
- is_expense (boolean, default: false)
- image (string)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, nullable)
```

### Tabel `transactions`
```sql
- id (bigint, primary key)
- nama (string)
- category_id (foreign key -> categories.id)
- date (date)
- amount (integer)
- note (string)
- image (string)
- created_at (timestamp)
- updated_at (timestamp)
```

## 🏗️ Struktur Project

```
app/
├── Filament/
│   ├── Resources/
│   │   ├── Categories/
│   │   │   ├── CategoryResource.php
│   │   │   ├── Pages/
│   │   │   ├── Schemas/
│   │   │   └── Tables/
│   │   └── Transactions/
│   │       ├── TransactionResource.php
│   │       ├── Pages/
│   │       ├── Schemas/
│   │       └── Tables/
│   └── Widgets/
│       └── StatsOverview.php
├── Models/
│   ├── Category.php
│   ├── Transaction.php
│   └── User.php
└── ...

database/
├── migrations/
│   ├── create_categories_table.php
│   └── create_transactions_table.php
└── ...
```

## ✅ Kelengkapan

### Yang Sudah Baik
1. **Arsitektur MVC** yang rapi dengan Laravel
2. **Admin Panel Modern** menggunakan Filament 4.0
3. **Relasi Database** yang tepat (Category hasMany Transactions)
4. **Validasi Form** di Filament Resources
5. **File Upload** untuk gambar kategori dan bukti transaksi
6. **Soft Delete** pada kategori
7. **Scope Methods** untuk filter pemasukan/pengeluaran
8. **Widget Dashboard** dengan statistik

### Fitur Lengkap
- ✅ CRUD Categories & Transactions
- ✅ File Upload Management
- ✅ Dashboard Statistics
- ✅ Date Filtering
- ✅ Responsive Design (Filament)
- ✅ Authentication System

## ⚠️ Kekurangan & Perbaikan

### 🚨 Issues yang Perlu Diperbaiki

1. **Naming Convention**
   ```php
   // ❌ Tidak konsisten
   class category extends Model  // lowercase
   class transaction extends Model  // lowercase
   
   // ✅ Seharusnya
   class Category extends Model  // PascalCase
   class Transaction extends Model  // PascalCase
   ```

2. **Database Column Inconsistency**
   ```php
   // Migration menggunakan kolom 'date'
   // Tapi widget menggunakan 'date_transaction'
   // Perlu sinkronisasi nama kolom
   ```

3. **Model Fillable Issues**
   ```php
   // Model Transaction fillable tidak match dengan form
   protected $fillable = ['nama', 'category_id', 'date', 'amount', 'note', 'image'];
   ```

4. **Widget Logic Error**
   ```php
   // Inefficient query di StatsOverview
   ->get()->whereBetween()  // Load all then filter
   
   // Seharusnya:
   ->whereBetween('date', [$start, $end])->sum('amount')
   ```

### 🔄 Perbaikan yang Disarankan

1. **Perbaiki Naming Convention**
2. **Sinkronisasi Database Schema**
3. **Optimisasi Query di Widget**
4. **Tambah Validation Rules**
5. **Implementasi Error Handling**
6. **Tambah Unit Tests**

### 📈 Fitur yang Bisa Ditambahkan

1. **Laporan & Export**
   - Export Excel/PDF
   - Laporan bulanan/tahunan
   - Grafik trend

2. **Multi-user Management**
   - Role-based access
   - User permissions

3. **Advanced Features**
   - Backup otomatis
   - Audit trail
   - Notification system

4. **Mobile Responsiveness**
   - PWA support
   - Mobile-first design

5. **Integration**
   - Payment gateway
   - Inventory management
   - Receipt printer

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Development Notes

### Scripts Tersedia
```bash
# Development
composer run dev        # Start dev servers
composer run setup     # Initial setup
composer run test      # Run tests

# NPM
npm run dev           # Vite dev server
npm run build        # Build assets
```

### Environment
- Versi PHP: 8.4.12
- Versi Laravel: 12.37.0
- Versi Filament: 4.0

---

**Status Project**: 🟡 In Development

**Last Updated**: November 8, 2025

**Maintainer**: [Your Name]

---

> **Catatan**: Project ini masih dalam tahap pengembangan. Beberapa fitur mungkin belum stabil dan memerlukan perbaikan sesuai daftar kekurangan di atas.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
