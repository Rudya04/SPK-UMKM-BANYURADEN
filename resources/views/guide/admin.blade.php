@extends("base-admin")

@section("title", "Dashboard")

@section('content')
    <div class="container">
         <div class="card p-4">
      <h5 class="card-title fw-bold text-primary">
        Panduan Penggunaan Aplikasi SPK SMART untuk UMKM Banyuraden
      </h5>
      <div class="card-body">

        <h6 class="section-title">A. Panduan untuk Admin</h6>

        <p class="sub-title">1. Login</p>
        <ul>
          <li>Buka aplikasi dan masukkan <strong>username/email</strong> dan <strong>password</strong> yang telah dibuatkan oleh admin.</li>
          <li>Jika berhasil, akan diarahkan ke <strong>Dashboard Admin</strong>.</li>
        </ul>

        <p class="sub-title">2. Menambah Akun Admin/User</p>
        <ul>
          <li>Pilih menu <strong>Manajemen Pengguna</strong>.</li>
          <li>Isi nama pemilik usaha, email, dan buatkan password.</li>
          <li>Setelah akun ditambahkan, user dapat login ke sistem.</li>
        </ul>

        <p class="sub-title">3. Mengelola Kriteria</p>
        <ul>
          <li>Pilih menu <strong>Kriteria</strong>.</li>
          <li>Klik <strong>Tambah Kriteria</strong>, total nilai seluruh kriteria harus 100.</li>
          <li>Contoh kriteria:
            <ul>
              <li>Legalitas Usaha</li>
              <li>Return on Investment (ROI)</li>
              <li>Pengalaman</li>
              <li>Persaingan</li>
              <li>Permintaan Pasar</li>
              <li>Modal Usaha</li>
            </ul>
          </li>
          <li>Gunakan tombol Edit/Hapus di tabel untuk mengubah data.</li>
        </ul>

        <p class="sub-title">4. Mengelola Sub Kriteria</p>
        <ul>
          <li>Pilih menu <strong>Sub Kriteria</strong>.</li>
          <li>Klik Tambah, lalu isi nama sub, nilai bobot (misal 1–5).</li>
          <li>Admin dapat mengedit/hapus sesuai kebutuhan.</li>
        </ul>

        <p class="sub-title">5. Mengelola Alternatif</p>
        <ul>
          <li>Pilih menu <strong>Alternatif</strong>.</li>
          <li>Klik Tambah Alternatif, masukkan nama pemilik UMKM.</li>
          <li>Klik Simpan.</li>
        </ul>

        <p class="sub-title">6. Melakukan Perhitungan SMART</p>
        <ul>
          <li>Pilih menu <strong>Perangkingan</strong>.</li>
          <li>Klik <strong>Buat Rangking</strong>.</li>
          <li>Atur perangkingan yang hendak dibuat, lalu hitung.</li>
          <li>Sistem akan memproses semua alternatif menggunakan metode SMART.</li>
          <li>Hasil berupa skor akhir dan peringkat kelayakan.</li>
          <li>Dapat disimpan atau dicetak sebagai laporan.</li>
        </ul>

        <p class="sub-title">7. Menu Tambahan</p>
        <ul>
          <li><strong>Panduan:</strong> Menampilkan petunjuk penggunaan aplikasi.</li>
          <li><strong>Alur Perangkingan:</strong> Menjelaskan alur penilaian SMART.</li>
          <li><strong>Perizinan:</strong> Mengatur peran dan hak akses antara Admin dan User.</li>
        </ul>
        <div class="note">
          💡 <strong>Catatan:</strong> Setiap perubahan data akan langsung memengaruhi hasil perhitungan SMART.
        </div>
      </div>
    </div>

    </div>
@endsection
