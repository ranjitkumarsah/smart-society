<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Smart Society - Welcome</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- ✅ Bootstrap 5 CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: #0a0a0a;
            }
            .login-card {
                transition: 0.3s ease-in-out;
            }
            .login-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            }
            .icon-box {
                font-size: 40px;
            }
        </style>
    </head>
    <body class="">

        
    <div class="container py-5 d-flex justify-content-center flex-column " style="min-height: 100vh;">
        <h1 class="text-center mb-5 fw-bold text-white">Welcome to Smart Society</h1>

        <div class="row g-4 justify-content-center">

            <!-- Admin Panel -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ url('/admin/login') }}" class="text-decoration-none text-dark">
                    <div class="card login-card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="icon-box text-warning mb-3">
                                <i class="bi bi-gear-fill"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Admin Panel</h5>
                            <p class="card-text small">Society Admin login</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Resident Panel -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ url('/resident/login') }}" class="text-decoration-none text-dark">
                    <div class="card login-card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="icon-box text-primary mb-3">
                                <i class="bi bi-house-fill"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Resident Panel</h5>
                            <p class="card-text small">Login for flat owners</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Guard Panel -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ url('/guard/login') }}" class="text-decoration-none text-dark">
                    <div class="card login-card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="icon-box text-success mb-3">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Guard Panel</h5>
                            <p class="card-text small">Security team login</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Staff Panel -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ url('/staff/login') }}" class="text-decoration-none text-dark">
                    <div class="card login-card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="icon-box text-info mb-3">
                                <i class="bi bi-clipboard-check-fill"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Staff Panel</h5>
                            <p class="card-text small">Maintenance & support login</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- ✅ Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
