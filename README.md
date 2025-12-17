# 🎓 Sistem Manajemen Sertifikasi

Aplikasi web untuk mengelola dan membuat sertifikat pelatihan atau kursus. Dibuat untuk keperluan sertifikasi dengan antarmuka yang mudah digunakan dan fitur lengkap.

## ✨ Fitur

- **Buat Sertifikat Baru**: Form interaktif untuk membuat sertifikat dengan validasi
- **Daftar Sertifikat**: Tampilkan semua sertifikat yang telah dibuat
- **Pencarian**: Cari sertifikat berdasarkan nama peserta, kursus, instruktur, atau ID
- **Preview Sertifikat**: Lihat preview sertifikat dengan desain profesional
- **Cetak/Simpan PDF**: Cetak atau simpan sertifikat sebagai PDF
- **Penyimpanan Lokal**: Semua data tersimpan di browser menggunakan localStorage
- **Responsive Design**: Tampil sempurna di desktop dan mobile

## 🚀 Cara Menggunakan

1. **Buka Aplikasi**: Buka file `index.html` di browser Anda
2. **Buat Sertifikat**:
   - Isi form dengan data peserta, kursus, dan instruktur
   - Klik tombol "Buat Sertifikat"
3. **Kelola Sertifikat**:
   - Beralih ke tab "Daftar Sertifikat" untuk melihat semua sertifikat
   - Gunakan kotak pencarian untuk menemukan sertifikat tertentu
   - Klik "Lihat" untuk preview dan cetak sertifikat
   - Klik "Hapus" untuk menghapus sertifikat

## 📋 Persyaratan

- Browser modern (Chrome, Firefox, Safari, Edge)
- JavaScript harus diaktifkan
- Tidak memerlukan instalasi atau server

## 🛠️ Teknologi

- HTML5
- CSS3 (dengan CSS Grid dan Flexbox)
- JavaScript (ES6+)
- LocalStorage API

## 📁 Struktur File

```
crispy-octo-engine/
├── index.html      # Halaman utama aplikasi
├── styles.css      # Styling dan desain
├── app.js          # Logika aplikasi dan manajemen data
└── README.md       # Dokumentasi
```

## 💾 Penyimpanan Data

Aplikasi ini menggunakan LocalStorage browser untuk menyimpan data sertifikat. Data akan tetap tersimpan meskipun browser ditutup, namun akan hilang jika:
- Cache browser dibersihkan
- LocalStorage dihapus secara manual
- Menggunakan mode incognito/private

## 🎨 Fitur Sertifikat

Setiap sertifikat mencakup:
- Nama peserta
- Nama kursus/pelatihan
- Nama instruktur
- Tanggal penerbitan
- Durasi pelatihan (dalam jam)
- Deskripsi (opsional)
- ID unik untuk setiap sertifikat

## 📱 Responsive Design

Aplikasi dirancang untuk bekerja dengan baik di berbagai ukuran layar:
- Desktop (>768px)
- Tablet (768px - 1024px)
- Mobile (<768px)

## 🖨️ Cetak Sertifikat

Untuk mencetak atau menyimpan sertifikat sebagai PDF:
1. Klik tombol "Lihat" pada sertifikat yang diinginkan
2. Klik tombol "Cetak/Simpan PDF"
3. Pilih printer atau "Save as PDF" di dialog cetak browser

## 📄 Lisensi

Dibuat untuk keperluan sertifikasi dan pembelajaran.

## 👨‍💻 Pengembangan

Aplikasi ini dibuat sebagai bagian dari proyek sertifikasi dengan fokus pada:
- Clean code dan best practices
- User experience yang baik
- Responsive design
- Aksesibilitas
- Manajemen state yang efisien

## 🤝 Kontribusi

Untuk meningkatkan aplikasi ini, Anda dapat:
- Menambahkan fitur ekspor ke format lain (JSON, CSV)
- Menambahkan template sertifikat yang berbeda
- Menambahkan fitur upload logo/gambar
- Implementasi dark mode
- Menambahkan fitur berbagi sertifikat