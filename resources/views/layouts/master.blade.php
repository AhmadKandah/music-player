<!-- resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MelodyMix - مشغل الموسيقى')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #6d28d9;
            --secondary-color: #8b5cf6;
            --dark-color: #1e1b4b;
            --light-color: #f8fafc;
            --gradient: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
            --gradient-hover: linear-gradient(135deg, #5b21b6 0%, #7c3aed 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background: var(--dark-color);
            color: var(--light-color);
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(109, 40, 217, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 20%);
        }
        
        /* Navbar */
        .navbar {
            background: rgba(30, 27, 75, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            transition: all 0.3s;
            padding: 0.5rem 1rem !important;
            border-radius: 10px;
        }
        
        .nav-link:hover {
            background: rgba(109, 40, 217, 0.1);
            color: #ffffff !important;
        }
        
        /* Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(109, 40, 217, 0.3);
            box-shadow: 0 15px 30px rgba(109, 40, 217, 0.2);
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--gradient);
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: var(--gradient-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(109, 40, 217, 0.3);
        }
        
        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
            transition: all 0.3s;
        }
        
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
        }
        
        /* Music Player */
        .music-player-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(30, 27, 75, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1000;
            padding: 15px 0;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .glass-card {
                margin-bottom: 1rem;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-music me-2"></i>MelodyMix
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars text-white"></i>
                </span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('songs.index') }}">
                            <i class="fas fa-home me-1"></i>الأغاني
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('playlists.index') }}">
                            <i class="fas fa-list-music me-1"></i>قوائم التشغيل
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('songs.create') }}">
                            <i class="fas fa-plus-circle me-1"></i>إضافة أغنية
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Global Music Player (سيتم إضافته لاحقاً) -->
    <div id="globalPlayer" style="display: none;">
        <!-- سيتم حقن مشغل الموسيقى هنا عبر JavaScript -->
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (للتسهيل) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom JS -->
    <script>
    // Global music player state
    window.musicPlayer = {
        currentSong: null,
        isPlaying: false,
        currentTime: 0,
        duration: 0,
        repeatMode: 'none', // 'none', 'one', 'all'
        shuffle: false,
        queue: [],
        currentIndex: -1
    };
    </script>
    
    @yield('scripts')
</body>
</html>