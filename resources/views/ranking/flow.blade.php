@extends("base-admin")

@section("title", "Dashboard")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <b>Proses Perhitungan Perankingan & Perbandingan Bobot Berbeda</b>
            </div>
            <div class="card-body">
                <p>Berikut penjelasan singkat mengenai alur perankingan algoritma <b>SMART (Simple Multi-Attribute
                        Rating
                        Technique)</b> dan bagaimana bobot memengaruhi hasil:</p>
                <div class="alert alert-light" role="alert">
                    <div class="bobot-disiplin">
                        <b>Kriteria</b>
                        <ul>
                            @foreach($bobots as $bobot)
                                <li>{{ $bobot['name'] }}</li>
                            @endforeach
                        </ul>

                        <div class="row">
                            <div class="col-12">
                                <div class="flow-perankingan">
                                    <h6>A. Proses Perankingan</h6>
                                    <b>1. Normalisasi Bobot</b>
                                    <p>Sistem akan melakukan normalisasi dan pembulatan 2 desimal terhadap kriteria yang
                                        telah diberikan</p>
                                    <div class="alert alert-warning" role="alert">
                                        <p>Rumus : </p>
                                        Bobot Normal = Nilai Bobot / Total Bobot
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Bobot</th>
                                            <th scope="col">Bobot Normal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=0; $i < count($bobots); $i++)
                                            <tr>
                                                <th scope="row">{{ $i+1 }}</th>
                                                <td>{{ $bobots[$i]['name'] }}</td>
                                                <td>{{ $bobots[$i]['value'] }}</td>
                                                <td>{{ $bobots[$i]['value'] }} / {{ $totalBobot }} =
                                                    <b>{{ $bobots[$i]['bobot_normal'] }}</b></td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flow-normalisasi">
                                    <b>2. Normalisasi Value(Kriteria)</b>
                                    <p>Alternatif Awal : </p>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Alternative</th>
                                            <th scope="col">Omset(juta)</th>
                                            <th scope="col">Pengalaman (tahun)</th>
                                            <th scope="col">Kualitas Produk (skor)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=0; $i < count($results); $i++)
                                            <tr>
                                                <th scope="row">{{ $i+1 }}</th>
                                                <td>{{ $results[$i]['alternative'] }}</td>
                                                @foreach($results[$i]['results'] as $result)
                                                    <td>{{ $result['sub_criteria_value'] }}</td>
                                                @endforeach
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                    <p>Alternatif Normal : </p>
                                    <div class="alert alert-warning" role="alert">
                                        <p>Rumus : </p>
                                        Normalisasi Value = Nilai Value / Nilai Value Maximal
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Alternative</th>
                                            <th scope="col">Omset(juta)</th>
                                            <th scope="col">Pengalaman (tahun)</th>
                                            <th scope="col">Kualitas Produk (skor)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=0; $i < count($results); $i++)
                                            <tr>
                                                <th scope="row">{{ $i+1 }}</th>
                                                <td>{{ $results[$i]['alternative'] }}</td>
                                                @php $j = 0; @endphp
                                                @foreach($results[$i]['results'] as $result)
                                                    <td>{{ $result['sub_criteria_value'] }}
                                                        / {{$maxValues[$j]['value_max']}} =
                                                        <b>{{$result['value_normal']}}</b></td>
                                                    @php $j++; @endphp
                                                @endforeach
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>

                                    <p>Alternatif Score : </p>
                                    <div class="alert alert-warning" role="alert">
                                        <p>Rumus : </p>
                                        Score = Normalisasi Value * Bobot Normal
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Alternative</th>
                                            <th scope="col">Omset(juta)</th>
                                            <th scope="col">Pengalaman (tahun)</th>
                                            <th scope="col">Kualitas Produk (skor)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=0; $i < count($results); $i++)
                                            <tr>
                                                <th scope="row">{{ $i+1 }}</th>
                                                <td>{{ $results[$i]['alternative'] }}</td>
                                                @foreach($results[$i]['results'] as $result)
                                                    <td>{{$result['value_normal']}} * {{$result['bobot_normal']}} =
                                                        <b>{{ $result['score'] }}</b></td>
                                                @endforeach
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                    <div class="scoring">
                                        <b>3. Pengambilan Score</b>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Alternative</th>
                                                <th scope="col">Score Akhir</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @for($i=0; $i < count($results); $i++)
                                                <tr>
                                                    <th scope="row">{{ $i+1 }}</th>
                                                    <td>{{ $results[$i]['alternative'] }}</td>
                                                    <td>
                                                        @php
                                                            $output = "";
                                                            $total = 0;
                                                            $j = 0;
                                                        @endphp
                                                        @foreach($results[$i]['results'] as $result)
                                                            @php
                                                                $total+= $result['score'];
                                                                $output.= $result['score'];
                                                                if ($j < count($results[$i]['results']) - 1) {
                                                                    $output.= " + ";
                                                                }else{
                                                                    $output.= " = " . $total;
                                                                }
                                                                $j++;
                                                            @endphp
                                                        @endforeach
                                                        {{ $output }}
                                                    </td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>
                                        <div class="alert alert-info" role="alert">
                                            <p>Dari perhitungan score diatas dapat diambil susunan score seperti berikut : </p>
                                            <b>Hasil : B > A > C</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
