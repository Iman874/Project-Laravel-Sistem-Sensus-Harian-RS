# 🏥 Sistem Sensus Harian RS

**Sistem Sensus Harian RS** adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola data harian pasien rumah sakit.
Aplikasi ini membantu memantau alur masuk, pindah, dan keluar pasien serta menghitung dan memvisualisasikan indikator kinerja rumah sakit seperti **BOR**, **AvLOS**, dan lainnya.

📌 *Repositori GitHub:* [Project Laravel - Sistem Sensus Harian RS](https://github.com/iman874/project-laravel-sistem-sensus-harian-rs)
🔗 *DeepWiki Reference:* [Ask DeepWiki](https://deepwiki.com/Iman874/Project-Laravel-Sistem-Sensus-Harian-RS/tree/main/app)

---

# 🗂️ Daftar Isi

* [Penjelasan Singkat](#penjelasan-singkat)
* [Fitur Utama](#fitur-utama)
* [Arsitektur Sistem](#arsitektur-sistem)
* [Cara Instalasi dan Menjalankan](#cara-instalasi-dan-menjalankan)
* [Perintah Artisan Khusus](#perintah-artisan-khusus)
* [Lisensi](#lisensi)

---

<a name="penjelasan-singkat"></a>

## 🧾 Penjelasan Singkat

Aplikasi ini mendukung alur kerja rumah sakit dengan pendekatan multi-role:

* 👩‍⚕️ **Perawat**: Mengelola data pasien di bangsal yang ditugaskan.
* 📊 **Petugas Indikator**: Bertanggung jawab atas master data serta validasi laporan.
* 🧑‍💼 **Kepala Instalasi**: Memantau dashboard dan laporan untuk pengambilan keputusan strategis.

---

<a name="fitur-utama"></a>

## 🚀 Fitur Utama

* 🔐 **Login Berbasis Role**

  * Role: *Perawat*, *Petugas Indikator*, *Kepala Instalasi*
  * Akses terbatas sesuai hak masing-masing

* 🏥 **Manajemen Alur Pasien**

  * ✍️ Pendaftaran Pasien Masuk
  * 🔁 Pindah Bangsal/Kelas
  * ✅ Discharge Pasien

* 🛎️ **Manajemen Bangsal & Tempat Tidur**

  * Input bangsal dan kelas
  * Otomatisasi jumlah tempat tidur berdasarkan kelas

* 📊 **Visualisasi & Indikator**

  * Rekapitulasi laporan harian
  * Perhitungan indikator: **BOR**, **AvLOS**, **TOI**, **BTO**
  * Grafik Model RS (Barber-Johnson Chart)

* 📡 **Ketersediaan Tempat Tidur Real-Time**

  * Mencegah overbooking
  * Hitung bed tersedia secara dinamis

---

<a name="arsitektur-sistem"></a>

## 🏗️ Arsitektur Sistem

### 📂 Controller Utama

* `AuthController`: Login, logout, session multi-guard
* `BangsalController`, `KelasBangsalController`: Manajemen struktur fisik RS
* `PasienMasukController`, `PasienPindahController`, `PasienKeluarController`: CRUD alur pasien
* `LaporanController`: Perhitungan indikator
* `ModelRSController`: Grafik efisiensi

### 🧹 Model Eloquent

* `Perawat`, `PetugasIndikator`, `KepalaInstalasi`: Tipe user & autentikasi
* `Bangsal`, `KelasBangsal`: Struktur bangsal dan relasinya
* `PasienMasuk`, `PasienPindah`, `PasienKeluar`: Data perjalanan pasien
* `DataLaporan`: Perhitungan KPI RS
* `JumlahTempatTidur`: Kelas pembantu (non-eloquent)

### 🛡️ Middleware

* `AuthMiddleware`: Cek login
* `CheckRole`: Validasi akses berdasarkan role

---

<a name="cara-instalasi-dan-menjalankan"></a>

## 🛠️ Cara Instalasi dan Menjalankan

<a name="clone"></a>

### 1️⃣ Clone Repository

```bash
git clone https://github.com/iman874/project-laravel-sistem-sensus-harian-rs.git
cd project-laravel-sistem-sensus-harian-rs
```

<a name="install-dependencies"></a>

### 2️⃣ Instalasi Dependensi Laravel

```bash
composer install
```

<a name="env-setup"></a>

### 3️⃣ Setup File `.env`

```bash
cp .env.example .env
php artisan key:generate
```

🛠️ Edit `.env` sesuai konfigurasi database lokal:

```
DB_DATABASE=nama_db
DB_USERNAME=username_db
DB_PASSWORD=password_db
```

<a name="migrate"></a>

### 4️⃣ Jalankan Migrasi Database

```bash
php artisan migrate
```

<a name="run-server"></a>

### 5️⃣ Jalankan Server Laravel

```bash
php artisan serve
```

🌐 Buka aplikasi di: `http://127.0.0.1:8000`

---

<a name="perintah-artisan-khusus"></a>

## ⚙️ Perintah Artisan Khusus

### 🔁 Update Total Tempat Tidur Secara Manual

Untuk sinkronisasi ulang data tempat tidur (jika ada perubahan struktur kelas):

```bash
php artisan update:total_tempat_tidur
```

---

<a name="lisensi"></a>

## 📄 Lisensi

Proyek ini bersifat open-source dan dapat digunakan untuk kebutuhan edukasi dan pengembangan internal.
