<?php

// 1. Data Alternatif
$alternatif = [
    'A' => ['Disiplin' => 80, 'Produktivitas' => 75, 'Kreativitas' => 70],
    'B' => ['Disiplin' => 90, 'Produktivitas' => 65, 'Kreativitas' => 80],
    'C' => ['Disiplin' => 85, 'Produktivitas' => 80, 'Kreativitas' => 60],
];

// 2. Bobot Kriteria (harus total 1.0)
$bobot = [
    'Disiplin' => 0.4,
    'Produktivitas' => 0.3,
    'Kreativitas' => 0.3,
];

// 3. Cari nilai maksimum tiap kriteria
$maxNilai = [];
foreach ($bobot as $kriteria => $bobotKriteria) {
    $max = max(array_column($alternatif, $kriteria));
    $maxNilai[$kriteria] = $max;
}

// 4. Hitung Normalisasi dan Skor Akhir
$hasil = [];

foreach ($alternatif as $nama => $nilaiKriteria) {
    $totalSkor = 0;
    foreach ($nilaiKriteria as $kriteria => $nilai) {
        $normalisasi = $nilai / $maxNilai[$kriteria];
        $skor = $normalisasi * $bobot[$kriteria];
        echo $skor . '<br>';
        $totalSkor += $skor;
    }
    $hasil[$nama] = $totalSkor;
}

// 5. Urutkan dari skor tertinggi ke terendah
arsort($hasil);

// 6. Tampilkan Hasil
echo "Hasil Perhitungan SMART:\n";
foreach ($hasil as $nama => $skor) {
    echo "Alternatif {$nama}: Skor Akhir = " . round($skor, 4) . "\n";
}

?>
