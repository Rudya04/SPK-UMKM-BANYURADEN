@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Dashboard Overview</h1>

        <!-- Dashboard Stats -->
        <div class="row mb-4">
            <div class="col-md-6 col-xl-3 mb-4 fade-in">
                <div class="card dashboard-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Total Penjualan</h6>
                                <h3 class="card-text mb-0">Rp 45.8M</h3>
                                <small class="opacity-75"><i class="fas fa-arrow-up"></i> +12% dari bulan lalu</small>
                            </div>
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4 fade-in" style="animation-delay: 0.1s">
                <div class="card dashboard-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Pesanan Hari Ini</h6>
                                <h3 class="card-text mb-0">156</h3>
                                <small class="opacity-75"><i class="fas fa-arrow-up"></i> +8% dari kemarin</small>
                            </div>
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4 fade-in" style="animation-delay: 0.2s">
                <div class="card dashboard-card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Produk Terjual</h6>
                                <h3 class="card-text mb-0">1,234</h3>
                                <small class="opacity-75"><i class="fas fa-arrow-up"></i> +15% dari bulan lalu</small>
                            </div>
                            <i class="fas fa-box-open"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4 fade-in" style="animation-delay: 0.3s">
                <div class="card dashboard-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Pelanggan Baru</h6>
                                <h3 class="card-text mb-0">48</h3>
                                <small class="opacity-75"><i class="fas fa-arrow-up"></i> +20% dari bulan lalu</small>
                            </div>
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-xl-8 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Analisis Penjualan</h5>
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateChart('daily')">Harian</button>
                            <button class="btn btn-outline-secondary btn-sm active" onclick="updateChart('weekly')">Mingguan</button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateChart('monthly')">Bulanan</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mb-4">
                <div class="card fade-in" style="animation-delay: 0.5s">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">Produk Terlaris</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Activity -->
        <div class="row">
            <div class="col-xl-8 mb-4">
                <div class="card fade-in" style="animation-delay: 0.6s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Tambah Pesanan
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>No. Faktur</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>#INV-2541</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://cdnjs.cloudflare.com/ajax/libs/placeholder.com/32x32/e74c3c/ffffff&text=DS"
                                                 class="rounded-circle me-2" width="32" height="32" alt="DS">
                                            <div>
                                                <div class="fw-bold">Dewi Sartika</div>
                                                <small class="text-muted">dewi.s@email.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>17 Apr 2025, 10:24</td>
                                    <td>Rp 1.250.000</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#INV-2540</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://cdnjs.cloudflare.com/ajax/libs/placeholder.com/32x32/f39c12/ffffff&text=AP"
                                                 class="rounded-circle me-2" width="32" height="32" alt="AP">
                                            <div>
                                                <div class="fw-bold">Andi Pratama</div>
                                                <small class="text-muted">andi.p@email.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>17 Apr 2025, 09:15</td>
                                    <td>Rp 875.000</td>
                                    <td><span class="badge bg-warning">Proses</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#INV-2539</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://cdnjs.cloudflare.com/ajax/libs/placeholder.com/32x32/2ecc71/ffffff&text=RS"
                                                 class="rounded-circle me-2" width="32" height="32" alt="RS">
                                            <div>
                                                <div class="fw-bold">Rini Setiawati</div>
                                                <small class="text-muted">rini.s@email.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>16 Apr 2025, 16:47</td>
                                    <td>Rp 2.150.000</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mb-4">
                <div class="card fade-in" style="animation-delay: 0.7s">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">Aktivitas Terkini</h5>
                    </div>
                    <div class="card-body">
                        <ul class="activity-feed">
                            <li class="activity-item">
                                <div class="activity-icon success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Pesanan Selesai</div>
                                    <small class="text-muted">Pesanan #INV-2541 telah diselesaikan</small>
                                    <div class="small text-muted mt-1">5 menit yang lalu</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon warning">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Stok Menipis</div>
                                    <small class="text-muted">Laptop Gaming X450 tinggal 3 unit</small>
                                    <div class="small text-muted mt-1">15 menit yang lalu</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon primary">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Pelanggan Baru</div>
                                    <small class="text-muted">Eva Andriani bergabung sebagai pelanggan</small>
                                    <div class="small text-muted mt-1">1 jam yang lalu</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon danger">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Pesanan Dibatalkan</div>
                                    <small class="text-muted">Pesanan #INV-2537 dibatalkan oleh pelanggan</small>
                                    <div class="small text-muted mt-1">2 jam yang lalu</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
