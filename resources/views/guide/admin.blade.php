@extends("base-admin")

@section("title", "Dashboard")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <b>Panduan Penggunaan Aplikasi SPK SMART untuk UMKM Banyuraden</b>
            </div>
            <div class="card-body">
                <h5 class="card-title">Dashboard</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <h5 class="card-title">Kriteria</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            </div>
        </div>
{{--        <h1 style="text-align:center; margin-bottom: 1.5rem; font-size: 1.8rem; color:#0d47a1;">--}}
{{--            📘 Panduan Penggunaan Aplikasi SPK SMART untuk UMKM Banyuraden--}}
{{--        </h1>--}}
{{--        <div class="section">--}}
{{--            <p>Panduan ini membantu pengguna(Admin) dalam mengoperasikan aplikasi SPK metode--}}
{{--                SMART untuk menentukan kelayakan usaha UMKM berdasarkan kriteria yang telah ditentukan.</p>--}}
{{--        </div>--}}
{{--        <div class="section">--}}
{{--            <h3>1. Login</h3>--}}
{{--            <ul>--}}
{{--                <li>Buka aplikasi dan masukkan <strong>username/email</strong> dan <strong>password</strong> yang telah--}}
{{--                    dibuatkan oleh programmer.--}}
{{--                </li>--}}
{{--                <li>Jika berhasil, akan diarahkan ke <strong>Dashboard Admin</strong>.</li>--}}
{{--            </ul>--}}

{{--            <h3>2. Menambah Akun Admin/User</h3>--}}
{{--            <ul>--}}
{{--                <li>Pilih menu <strong>Manajemen Pengguna</strong> (jika tersedia).</li>--}}
{{--                <li>Isi nama pemilik usaha, email, dan buatkan password.</li>--}}
{{--                <li>Setelah akun ditambahkan, user dapat login ke sistem.</li>--}}
{{--            </ul>--}}

{{--            <h3>3. Mengelola Kriteria</h3>--}}
{{--            <ul>--}}
{{--                <li>Pilih menu <strong>Kriteria</strong>.</li>--}}
{{--                <li>Klik <strong>Tambah Kriteria</strong>, total seluruh nilai kriteria harus 100.</li>--}}
{{--                <li>Contoh kriteria:--}}
{{--                    <ul>--}}
{{--                        <li>Modal Usaha</li>--}}
{{--                        <li>Permintaan Pasar</li>--}}
{{--                        <li>Persaingan</li>--}}
{{--                        <li>Keahlian Pemilik</li>--}}
{{--                        <li>Return On Investment (ROI)</li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li>Gunakan tombol <em>Edit/Hapus</em> di tabel untuk mengubah data.</li>--}}
{{--            </ul>--}}

{{--            <h3>4. Mengelola Sub Kriteria</h3>--}}
{{--            <ul>--}}
{{--                <li>Pilih menu <strong>Sub Kriteria</strong>.</li>--}}
{{--                <li>Klik <strong>Tambah</strong>, lalu isi nama sub, nilai bobot (misal 1–5), dan deskripsi (jika--}}
{{--                    perlu).--}}
{{--                </li>--}}
{{--                <li>Admin dapat mengedit/hapus sesuai kebutuhan.</li>--}}
{{--            </ul>--}}

{{--            <h3>5. Mengelola Alternatif</h3>--}}
{{--            <ul>--}}
{{--                <li>Pilih menu <strong>Alternatif</strong>.</li>--}}
{{--                <li>Klik <strong>Tambah Alternatif</strong>, masukkan nama UMKM dan kategori usaha.</li>--}}
{{--                <li>Klik <strong>Simpan</strong>.</li>--}}
{{--            </ul>--}}

{{--            <h3>6. Mengisi Nilai Bobot Alternatif</h3>--}}
{{--            <ul>--}}
{{--                <li>Pilih menu <strong>Nilai Bobot Alternatif</strong>.</li>--}}
{{--                <li>Pilih nama UMKM dan kriteria.</li>--}}
{{--                <li>Masukkan nilai sesuai kondisi aktual, lalu klik <strong>Simpan</strong>.</li>--}}
{{--            </ul>--}}

{{--            <h3>7. Melakukan Perhitungan SMART</h3>--}}
{{--            <ul>--}}
{{--                <li>Pilih menu <strong>Perhitungan SMART</strong>.</li>--}}
{{--                <li>Sistem memproses semua alternatif menggunakan metode SMART.</li>--}}
{{--                <li>Hasil berupa <strong>skor akhir</strong> dan <strong>peringkat kelayakan</strong>.</li>--}}
{{--                <li>Dapat disimpan atau dicetak sebagai laporan.</li>--}}
{{--            </ul>--}}

{{--            <h3>8. Edit Profil</h3>--}}
{{--            <ul>--}}
{{--                <li>Admin bisa mengganti <strong>password</strong> atau info akun dari menu Profil.</li>--}}
{{--            </ul>--}}
{{--        </div>--}}

{{--        <div class="section">--}}
{{--            <h2>B. Panduan untuk User (Pemilik UMKM)</h2>--}}

{{--            <h3>1. Login</h3>--}}
{{--            <ul>--}}
{{--                <li>Masukkan username/email dan password yang telah dibuat oleh Admin.</li>--}}
{{--                <li>Setelah login, masuk ke Dashboard User.</li>--}}
{{--            </ul>--}}

{{--            <h3>2. Melihat Hasil Perhitungan</h3>--}}
{{--            <ul>--}}
{{--                <li>Masuk ke menu <strong>Perhitungan SMART</strong>.</li>--}}
{{--                <li>Klik <strong>Proses</strong> untuk melihat skor kelayakan usaha.</li>--}}
{{--                <li>Hasil dapat dilihat dan <strong>diunduh dalam bentuk Excel</strong>.</li>--}}
{{--            </ul>--}}

{{--            <div class="note">--}}
{{--                💡 <strong>Catatan:</strong> Setiap perubahan data akan langsung berpengaruh terhadap hasil perhitungan--}}
{{--                SMART.--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
