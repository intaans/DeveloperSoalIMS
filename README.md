**Kalkulator Kredit IMS Finance - Junior IT Developer Test**

Project ini adalah penyelesaian tes teknis untuk posisi Junior IT Developer di PT Inovasi Mitra Sejati. Aplikasi ini dibangun menggunakan framework Laravel dan database MySQL untuk mensimulasikan kalkulasi angsuran kendaraan serta perhitungan denda keterlambatan.

**Fitur Utama**
Soal 1: Simulasi kalkulasi kredit dengan input OTR, DP, dan Tenor secara dinamis.
Soal 2: Query untuk menampilkan total angsuran yang jatuh tempo hingga 14 Agustus 2024.
Soal 3: Query kalkulasi denda keterlambatan berdasarkan selisih hari (`DATEDIFF`).

**Teknologi yang Digunakan**
Backend: Laravel (PHP).
Frontend: Tailwind CSS.
Database: MySQL.

**Cara Instalasi dan Menjalankan Project**

Jika Anda ingin mencoba menjalankan project ini secara lokal, ikuti langkah berikut:

**1. Clone Repository**

```bash
git clone https://github.com/intaans/DeveloperSoalIMS.git
cd DeveloperSoalIMS

```

**2. Install Dependencies**

```bash
composer install
npm install && npm run build

```

**3. Konfigurasi Environment**

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env

```

Lalu atur koneksi database Anda di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=

```

**4. Generate App Key & Jalankan Migrasi**

```bash
php artisan key:generate
php artisan migrate

```

** 5. Jalankan Aplikasi**

```bash
php artisan serve

```

**Dibuat oleh: Intan Sanu **
