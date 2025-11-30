# SiSehat

[![Made with PHP](https://img.shields.io/badge/Made%20with-PHP%20Native-777BB4?style=for-the-badge&logo=php)](https://www.php.net/)
[![Database](https://img.shields.io/badge/Database-MySQL-005C84?style=for-the-badge&logo=mysql)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

## 👨🏻‍💼 Anggota 
1. Wafi Javier Zuhdi - 245150401111036
2. Athaya Akbar Andryansyah - 245150401111034
3. Muhammad Farrel Aria Akbar - 245150400111048
4. Danish Hikham Rubyadi - 245150400111054
5. Muhammad Arrafi Rakka - 245150407111076

## ✨ Tentang Proyek

**SiSehat** adalah sistem informasi berbasis web yang dirancang untuk memudahkan pengguna untuk mengetahui tentang kesehatannya (seperti: BMI, Kalori, DLL). Dibangun menggunakan PHP Native dengan menerapkan pola arsitektur MVC (Model-View-Controller) untuk memisahkan logika bisnis, tampilan, dan data.

## 🚀 Fitur 

| # | Modul | Fungsi Utama |
| :---: | :--- | :--- |
| **1** | **🔐 Otentikasi Pengguna** | Login dan Registrasi aman untuk berbagai peran (e.g., Admin, Ahli Gizi, Pengguna). |
| **2** | **📝 Menghitung BMI** | Perhitungan BMI dan dapat mengetahui klasifikasi status kesehatan. |
| **3** | **📈 Konsultasi** | Melakukan konsultasi dengan ahli gizi dengan memilih ahli gizi sesuai dengan kriteria pengguna. |
| **4** | **📅 Workout** | Fitur untuk menghitung kalori yang terbakar dan mendapatkan rekomendasi workout. |
| **5** | **📊 Kalori Harian** | Menghitung kalori harian agar dapat mengatur makanan sehari-hari. |
| **6** | **📊 Meal Plan** | Perencanaan makanan agar dapat mengatur gizi atau kalori. |


## 🎨 Tumpukan Teknologi (Tech Stack)

Berdasarkan struktur repositori, aplikasi ini dikembangkan dengan:

* **Backend:** PHP Native (Menggunakan Arsitektur MVC).
* **Database:** MySQL / Workbench / PHPMyadmin.
* **Frontend:** HTML, CSS, JavaScript (kemungkinan besar menggunakan framework CSS seperti Bootstrap di folder `/public`).

## ⚙ Prasyarat dan Instalasi

### Prasyarat

* **PHP:** Versi 8.0+
* **Database:** MySQL/Workbench
* **Web Server:** Apache (XAMPP/MAMP direkomendasikan)

### Panduan Instalasi (Asumsi)

1.  **Clone Repositori:**
    ```bash
    git clone [https://github.com/ArrafiRakka/SiSehat.git](https://github.com/ArrafiRakka/SiSehat.git)
    ```
2.  **Database:**
    * Buat database.
    * Impor skema database dari folder `/Databases` (jika tersedia).
3.  **Akses:**
    * Akses proyek melalui *browser* setelah konfigurasi *virtual host* atau letakkan di dalam folder `htdocs` XAMPP.
