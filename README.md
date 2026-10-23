<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 📖 About Sistem

**ARDAKA CORE** adalah fondasi perangkat lunak yang akan menjadi aset teknologi utama ARDAKA TECHNOLOGIES. Fondasi ini dirancang supaya kita tidak perlu membangun ulang fitur-fitur umum setiap kali membuat produk baru.

Aplikasi menggunakan **Livewire 3** untuk membangun antarmuka yang interaktif serta **Spatie Laravel Permission** untuk mengimplementasikan sistem **Role-Based Access Control (RBAC)** sehingga setiap pengguna dapat diberikan hak akses sesuai dengan peran dan tanggung jawabnya.


## 🚀 Tech Stack

- **Laravel 12**
- **Livewire 3**
- **Spatie Laravel Permission**
- **Bootstrap 5**
- **Mazer Admin Dashboard Template**
- **MySQL**

## ✨ Fitur

### 🔐 Authentication

- Login
- Logout
- Session Authentication
- Proteksi halaman berdasarkan autentikasi pengguna

### 👤 User Management

- CRUD User
- Assign Role kepada User
- Pengelolaan status pengguna
- Soft Delete

### 🛡️ Role Management

- CRUD Role
- Assign Permission ke Role
- Sinkronisasi Permission
- Pengaturan hak akses berdasarkan Role

### 🔑 Permission Management

- CRUD Permission
- Role-Based Access Control (RBAC)
- Integrasi dengan **Spatie Laravel Permission**
- Pembatasan akses berdasarkan Permission

## 🔐 Role & Permission

ARDAKA CORE menggunakan **Spatie Laravel Permission** sebagai sistem otorisasi untuk mengatur hak akses pengguna.

### Role

Role dapat disesuaikan dengan kebutuhan operasional sistem, misalnya:

- **Super Admin** — memiliki akses penuh terhadap sistem
- **Admin** — mengelola data dan proses PMB sesuai hak akses
- **User** — memiliki akses terbatas sesuai Permission yang diberikan

### Permission

Permission digunakan untuk menentukan tindakan yang dapat dilakukan oleh setiap Role.

Contoh Permission:

read_user
create_user
update_user
delete_user

read_role
create_role
update_role
delete_role

read_permission
create_permission
update_permission
delete_permission


Setiap Role dapat memiliki satu atau lebih Permission sesuai kebutuhan.

## 📁 Struktur Modul

ARDAKA CORE
│
├── Authentication
│   ├── Login
│   └── Logout
│
├── User Management
│   ├── Users
│   ├── Roles
│   └── Permissions
│
└── Master Data
    └── 

## 🎯 Tujuan Sistem

ARDAKA CORE dikembangkan sebagai sistem yang dapat menjadi dasar dalam pengelolaan proses **Penerimaan Mahasiswa Baru** secara digital.

Dengan struktur sistem yang modular dan penggunaan Role & Permission, aplikasi dapat dikembangkan lebih lanjut sesuai kebutuhan institusi tanpa harus membangun ulang komponen dasar sistem.

## 🔮 Pengembangan Selanjutnya

Sistem dapat dikembangkan dengan menambahkan berbagai modul PMB, antara lain:

- Tahun Akademik
- Jalur PMB
- Gelombang PMB
- Pendaftaran Calon Mahasiswa
- Data Pribadi Calon Mahasiswa
- Data Keluarga
- Data Pendidikan
- Data Dokumen
- Pembayaran Pendaftaran
- Seleksi PMB
- Jadwal Ujian
- Ruang Ujian
- Pengumuman Hasil Seleksi
- Registrasi Ulang
- Generate Nomor Induk Mahasiswa (NIM)
- Laporan PMB
- Dashboard Statistik PMB
