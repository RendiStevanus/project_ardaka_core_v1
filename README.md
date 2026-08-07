<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Sistem

# Laravel 12 Base Project

Base Project ini merupakan template aplikasi berbasis **Laravel 12** yang dirancang sebagai fondasi untuk membangun aplikasi dengan sistem **Role-Based Access Control (RBAC)** menggunakan **Spatie Laravel Permission**, **Livewire 3**, serta pengelolaan **Master Data Program Studi**.

Project ini bertujuan untuk mempercepat proses pengembangan aplikasi dengan menyediakan struktur autentikasi, manajemen pengguna, hak akses, dan data master yang sudah terintegrasi.

## 🚀 Tech Stack

- Laravel 12
- Livewire 3
- Spatie Laravel Permission
- Bootstrap 5 - Mazer Template Admin
- MySQL

## ✨ Fitur

### Authentication

- Login
- Logout
- Session Authentication

### User Management

- CRUD User
- Assign Role kepada User
- Soft Delete (opsional)

### Role Management

- CRUD Role
- Assign Permission ke Role
- Sinkronisasi Permission secara otomatis

### Permission Management

- CRUD Permission
- Mendukung konsep Role-Based Access Control (RBAC)
- Integrasi penuh dengan Spatie Laravel Permission

### Master Data Program Studi

- CRUD Program Studi
- Kode Program Studi
- Nama Program Studi
- Jenjang
- Akreditasi

## 🔐 Role & Permission

Project menggunakan package **Spatie Laravel Permission** sebagai sistem otorisasi.

### Role

Role dapat dibuat sesuai kebutuhan, misalnya:

- Super Admin
- Admin
- User

### Permission

Permission bersifat fleksibel dan dapat ditambahkan sesuai kebutuhan aplikasi.

Contoh permission:

```
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

read_program_studi
create_program_studi
update_program_studi
delete_program_studi
```

Setiap Role dapat memiliki satu atau lebih Permission.

## 📁 Struktur Modul

```
Authentication
├── Login

Master Data
└── Program Studi
```

User Management
├── Users
├── Roles
└── Permissions

## 📌 Tujuan Project

Base Project ini dibuat agar pengembang tidak perlu membangun kembali fitur-fitur dasar pada setiap project baru. Dengan struktur yang sudah tersedia, pengembangan aplikasi dapat lebih cepat, konsisten, dan mudah dikembangkan.

Project ini sangat cocok digunakan sebagai fondasi untuk:

- Sistem Informasi Akademik
- Sistem PMB
- Sistem Inventaris
- Sistem Kepegawaian
- Sistem Manajemen Organisasi
- Aplikasi Internal Perusahaan
- Dashboard Administrasi

## 📄 License

Open Source.
Silakan digunakan, dimodifikasi, dan dikembangkan sesuai kebutuhan.