@extends("base-admin")

@section("title", "Dashboard")

@section('content')
    <div class="container">
         <div class="card p-4">
      <h5 class="card-title fw-bold text-primary">
        Panduan Penggunaan Aplikasi SPK SMART untuk UMKM Banyuraden
      </h5>
      <div class="card-body">

       
        <h6 class="section-title">A. Panduan untuk User (Pemilik UMKM)</h6>

        <p class="sub-title">1. Login</p>
        <ul>
          <li>Masukkan <strong>username/email</strong> dan <strong>password</strong> yang dibuat oleh Admin.</li>
          <li>Setelah login, pengguna akan diarahkan ke <strong>Dashboard User</strong>.</li>
        </ul>

        <p class="sub-title">2. Melihat Hasil Perhitungan</p>
        <ul>
          <li>Masuk ke menu <strong>Perangkingan</strong>.</li>
          <li>Klik <strong>Proses</strong> untuk melihat skor kelayakan usaha.</li>
          <li>Hasil dapat diunduh dalam bentuk <strong>Excel</strong>.</li>
        </ul>

      </div>
    </div>

    </div>
@endsection
