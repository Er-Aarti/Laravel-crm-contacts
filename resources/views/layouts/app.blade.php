<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM') | Contact Management</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #eef2ff;
            --secondary: #64748b;
            --background: #f8fafc;
            --card-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--background);
            color: #1e293b;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .main-container {
            max-width: 1200px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }

        /* Unified Tab System */
        .nav-tabs-custom {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 2rem;
            display: flex;
            gap: 2rem;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            background: none;
            padding: 0.75rem 0;
            color: var(--secondary);
            font-weight: 500;
            position: relative;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-tabs-custom .nav-link:hover {
            color: var(--primary);
        }

        .nav-tabs-custom .nav-link.active {
            color: var(--primary);
        }

        .nav-tabs-custom .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--primary);
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            background: #ffffff;
            overflow: hidden;
        }

        /* Accessibility improvements */
        button, a, input, select {
            outline-offset: 4px;
        }
        
        button:focus-visible, a:focus-visible {
            outline: 2px solid var(--primary);
        }

        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
        }

        /* Table */
        .table thead th {
            background: #f1f5f9;
            padding: 1.25rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            color: #475569;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
        }

        .badge-pill {
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 1.5rem auto;
            }
            .nav-tabs-custom {
                gap: 1rem;
                overflow-x: auto;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Navigation -->
    <nav class="navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-shield-check fs-2"></i>
                <span>ContactPortal</span>
            </a>
            
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-block text-end">
                    <div class="fw-bold small">Admin Dashboard</div>
                    <div class="text-muted" style="font-size: 0.7rem;">Version 2.0.1</div>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                    A
                </div>
            </div>
        </div>
    </nav>

    <main class="main-container">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

</body>
</html>
