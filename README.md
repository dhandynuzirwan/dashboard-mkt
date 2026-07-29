<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  
  <h1>📊 Dashboard Marketing & HR Management System</h1>
  <p>
    Sistem Informasi Komprehensif untuk Manajemen Prospek (CRM), Operasional, Absensi, dan Penggajian terintegrasi.
  </p>
  
  <p>
    <a href="#fitur-utama"><strong>Jelajahi Fitur</strong></a> ·
    <a href="#teknologi"><strong>Teknologi</strong></a> ·
    <a href="#instalasi"><strong>Instalasi</strong></a>
  </p>

  <p>
    <img src="https://img.shields.io/badge/ERP-System-28a745?style=for-the-badge" alt="ERP">
    <img src="https://img.shields.io/badge/CRM-Marketing-007bff?style=for-the-badge" alt="CRM">
    <img src="https://img.shields.io/badge/HRIS-Human_Resources-dc3545?style=for-the-badge" alt="HRIS">
  </p>

  <p>
    <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2">
    <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  </p>
</div>

---

## 🚀 Tentang Proyek

Proyek **Dashboard Marketing & HR** ini adalah sebuah ekosistem *Enterprise Resource Planning* (**ERP**) terpadu yang menggabungkan kekuatan *Customer Relationship Management* (**CRM**) dan *Human Resources Information System* (**HRIS**) dalam satu platform terpusat. Aplikasi ini dirancang untuk mendigitalisasi dan mengotomatisasi seluruh alur kerja perusahaan, mulai dari hulu (akuisisi pelanggan & prospek) hingga hilir (manajemen SDM, absensi, & penggajian).

Aplikasi ini dikembangkan menggunakan **Laravel 12** dan sangat cocok digunakan sebagai bahan portofolio pengembangan perangkat lunak (SaaS/B2B System).

---

## ✨ Fitur Utama

### 📈 Manajemen Marketing & Prospek (CRM)
- **Kanban Pipeline**: Visualisasi data prospek dan pergerakan status *deal* (Call to Action/CTA).
- **Manajemen Data Masuk (Leads)**: Sinkronisasi otomatis data prospek dari berbagai sumber.
- **Master Data**: Kelola instruktur, proposal, modul pelatihan, dan artikel.
- **Efek Konfeti**: Animasi *confetti* interaktif saat prospek berhasil mencapai tahap *deal*! 🎉

### 👥 Manajemen HR & Operasional
- **Absensi Terintegrasi**: Log absensi, *geo-location*, dan sinkronisasi kamera (Fingerspot).
- **Sistem Penggajian Lengkap (Payroll)**: Kalkulasi gaji pokok, tunjangan, potongan BPJS, hingga pajak.
- **Pengajuan Izin & Lembur**: Alur *approval* (persetujuan) berjenjang oleh HRD dan Atasan.
- **Aset & Inventaris**: Manajemen stok barang, peminjaman, dan mutasi antar divisi.

### 🔒 Keamanan & Hak Akses (Role-based)
- **Multi-Role System**: Sistem akses berbeda untuk `superadmin`, `marketing`, `hrd`, `operasional`, `finance`, dll.
- **Guest Mode & Data Masking**: Mode Tamu (*Guest*) yang memungkinkan eksplorasi UI tanpa melihat data sensitif. Data penting (misal: nominal gaji, nomor kontak) otomatis **disensor/diburamkan** secara *server-side*.

---

## 🛠️ Teknologi yang Digunakan

* **Backend**: Laravel 12.x, PHP 8.2+
* **Database**: MySQL / MariaDB
* **Frontend**: Bootstrap 5, Kaiadmin Template, jQuery
* **Interaktivitas**: SweetAlert2, Canvas Confetti
* **Package Pendukung**: Maatwebsite Excel (Eksport/Import), Laravel Sanctum

---

## 📸 Tampilan Antarmuka (Screenshots)

> 💡 *Catatan: Silakan tambahkan screenshot aplikasi Anda di sini.*

| Dashboard Utama | Kanban Pipeline |
| :---: | :---: |
| <img src="https://via.placeholder.com/400x250.png?text=Dashboard+Utama" alt="Dashboard Utama"> | <img src="https://via.placeholder.com/400x250.png?text=Pipeline+Kanban" alt="Kanban"> |

| Slip Gaji (Payroll) | Guest Mode (Data Sensor) |
| :---: | :---: |
| <img src="https://via.placeholder.com/400x250.png?text=Payroll+System" alt="Payroll"> | <img src="https://via.placeholder.com/400x250.png?text=Guest+Mode" alt="Guest Mode"> |

---

## 💻 Panduan Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal Anda:

1. **Clone repositori ini:**
   ```bash
   git clone https://github.com/username-anda/dashboard-mkt.git
   cd dashboard-mkt
   ```

2. **Install dependensi PHP & Node:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Konfigurasi Environment:**
   Salin file konfigurasi bawaan dan sesuaikan nama *database* Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Jalankan Migrasi & Seeder Database:**
   *(Pastikan MySQL server sudah berjalan)*
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses di `http://127.0.0.1:8000`.

---

## 👨‍💻 Penulis (Author)

Proyek ini dikembangkan oleh **[Nama Anda]**.  
Terbuka untuk kolaborasi atau peluang karir! Anda bisa menghubungi saya melalui:

- 💼 **LinkedIn**: [linkedin.com/in/username-anda](https://linkedin.com/)
- 🌐 **Portfolio**: [website-portfolio-anda.com](https://website-portfolio-anda.com)
- 📧 **Email**: email.anda@gmail.com

---

<div align="center">
  <sub>Dibuat dengan ❤️ menggunakan Laravel</sub>
</div>
