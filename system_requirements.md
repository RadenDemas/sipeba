3. System Requirements

System requirements menjelaskan kebutuhan teknis dan non-fungsional sistem.

3.1 Functional Requirements

Sistem menyediakan autentikasi multi-role (Admin, Petugas Gudang, Karyawan).

Sistem menyediakan modul CRUD untuk:

Data barang

Data pengguna

Data peminjaman dan pengembalian

Sistem menyediakan workflow peminjaman dengan status:

Pending

Disetujui

Ditolak

Sistem mencatat siapa petugas yang menyetujui atau menolak peminjaman.

Sistem mengirim notifikasi email otomatis untuk pengingat pengembalian.

Sistem menyimpan dan menampilkan histori peminjaman dan aktivitas pengguna.

3.2 Non-Functional Requirements

Sistem berbasis web responsif (mobile & desktop).

Sistem menggunakan:

Framework: Laravel + Livewire + Tailwind

Database: MySQL

Sistem memiliki performa yang stabil untuk penggunaan internal organisasi.

Sistem memiliki keamanan dasar:

Autentikasi dan otorisasi berbasis role

Validasi input

Sistem mudah dikembangkan untuk kebutuhan komersialisasi di masa depan.

Sistem memiliki dokumentasi teknis dan user manual.

3.3 Deployment & Infrastructure Requirements

Aplikasi dapat dijalankan pada server lokal atau cloud hosting.

Sistem terintegrasi dengan SMTP Email Service.

Sistem menggunakan version control (GitHub).

Sistem mendukung deployment ke environment production.