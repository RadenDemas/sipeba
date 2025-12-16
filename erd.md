User Table:
- id (Primary Key)
- name
- email
- password
- role
- created_at
- updated_at

Pengajuan Table:
- id_pengajuan (Primary Key)
- id_user
- id_barang
- id_petugas (berdasarkan user dengan role petugas)
- date_start
- date_end
- jumlah
- status
- approved_at
- canceled_at
- keterangan
- created_at
- updated_at

Pengembalian Table:
- id_pengembalian (Primary Key)
- id_pengajuan
- id_petugas (berdasarkan dari id user)
- tanggal_pengembalian
- keterangan
- created_at
- updated_at
