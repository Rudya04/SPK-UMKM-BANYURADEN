<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Kelayakan Usaha UMKM - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
        }

        /* Dark Mode Variables */
        .dark-mode {
            --bs-body-bg: #1a1a1a;
            --bs-body-color: #ffffff;
            --bs-light: #2d2d2d;
            --bs-border-color: #3d3d3d;
            --card-bg: #2d2d2d;
            --text-color: #ffffff;
            --primary-color: #2980b9;
        }

        body {
            background: #3498db;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .logo {
            display: block;
            margin: 0 auto 20px; /* Tengah dan beri jarak ke bawah */
            max-width: 100px; /* Atur ukuran logo */
        }

        .background {
            background: var(--primary-color);
        }

        .btn-blue {
            background: var(--primary-color);
        }
        .btn-blue:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4">
                <div class="card-body text-center">
                    <img src="umkmbny.png" alt="Logo" class="logo"> <!-- Ganti 'logo.png' dengan link/logo kamu -->
                    <h3 class="mb-4">Sistem Pendukung Keputusan</h3>
                    <h5 class="mb-4">Kelayakan Usaha UMKM BANYURADEN<br> <small class="text-muted">Metode SMART</small></h5>
                    @error("email")
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                    <form action="#" method="post">
                        @csrf
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-blue text-white">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center text-white mt-3">&copy; 2025 UMKM Banyuraden</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
