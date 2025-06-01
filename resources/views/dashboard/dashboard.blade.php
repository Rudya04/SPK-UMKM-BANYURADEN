@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Dashboard</h1>

        <!-- Dashboard Stats -->
        <div class="row mb-4">
            <div class="col-md-6 col-xl-3 mb-4 fade-in">
                <div class="card dashboard-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Total Perhitungan Ranking</h6>
                                <h3 class="card-text mb-0">{{ $data['totalRanking'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4 fade-in" style="animation-delay: 0.1s">
                <div class="card dashboard-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Jumlah Perhitungan Hari Ini</h6>
                                <h3 class="card-text mb-0">{{ $data['totalRankingToday'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4 fade-in" style="animation-delay: 0.2s">
                <div class="card dashboard-card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Jumlah UMKM</h6>
                                <h3 class="card-text mb-0">{{ $data['totalUmkm'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4 fade-in" style="animation-delay: 0.3s">
                <div class="card dashboard-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Total Pengguna</h6>
                                <h3 class="card-text mb-0">{{ $data['totalUser'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-xl-8 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="myPie"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Activity -->
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card fade-in" style="animation-delay: 0.6s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Ranking dengan score terbesar</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Title</th>
                                    <th>Ranking</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['rankingMaxs'] as $ranking)
                                    <tr>
                                        <td>{{ $ranking->created_at }}</td>
                                        <td>{{ $ranking->title }}</td>
                                        <td>{{ $ranking->max_rating }}</td>
                                        <td>
                                            <a href="{{ route('ranking.show', ['reference_code' => $ranking->reference_code]) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($data['responseYear']['years']),
                datasets: [
                    {
                        label: 'Sangat Layak',
                        data: @json($data['responseYear']['sangat_layak']),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)'
                    },
                    {
                        label: 'Layak',
                        data: @json($data['responseYear']['layak']),
                        backgroundColor: 'rgba(255, 99, 132, 0.7)'
                    },
                    {
                        label: 'Cukup Layak',
                        data: @json($data['responseYear']['cukup_layak']),
                        backgroundColor: 'rgba(255, 206, 86, 0.7)'
                    },
                    {
                        label: 'Tidak Layak',
                        data: @json($data['responseYear']['tidak_layak']),
                        backgroundColor: 'rgba(92,86,255,0.7)'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Perbandingan Jumlah Kelayakan Per Tahun'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
    <script>
        const pieCtx = document.getElementById('myPie');

        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: @json($data['responseCriteria']['criteria']),
                datasets: [{
                    label: 'Status Kelayakan',
                    data: @json($data['responseCriteria']['total']),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(99,255,242,0.7)',
                        'rgba(120,99,255,0.7)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(99,255,242,0.7)',
                        'rgba(120,99,255,0.7)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Keseluruhan Status Kelayakan UMKM'
                    }
                }
            }
        });
    </script>
@endsection
