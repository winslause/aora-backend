<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora45 - Hero Section</title>
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts for Luxury Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@200;300;400;500&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
            background: #0a0a0a;
        }

        /* Elegant, subtle skeuomorphic effects */
        .navbar-skeu {
            background: #ffffff;
            border-bottom: 1px solid #e0d6cc;
            box-shadow: 0 4px 20px -8px rgba(90, 60, 40, 0.15);
        }

        .nav-link {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            color: #5c524a;
            letter-spacing: 0.3px;
            position: relative;
            transition: all 0.2s ease;
            padding: 0.5rem 0;
            margin: 0 0.75rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            opacity: 0.85;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 70%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #b8a084, #8a735b, #b8a084, transparent);
            transition: transform 0.25s ease;
        }

        .nav-link:hover {
            color: #3f352e;
            opacity: 1;
        }

        .nav-link:hover::after {
            transform: translateX(-50%) scaleX(1);
        }

        /* Active nav link */
        .nav-link.active {
            color: #3f352e;
            opacity: 1;
            font-weight: 600;
        }
        .nav-link.active::after {
            transform: translateX(-50%) scaleX(1);
        }

        /* Unique Toggler Animation - refined */
        .toggler-skeu {
            width: 44px;
            height: 44px;
            background: #ffffff;
            border: 1px solid #d6cbbc;
            border-radius: 50%;
            box-shadow: 0 4px 10px -3px rgba(100, 70, 40, 0.1);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
            position: relative;
            z-index: 100;
        }

        .toggler-skeu:hover {
            background: #faf7f2;
            border-color: #c4b2a0;
            box-shadow: 0 6px 14px -4px rgba(100, 70, 40, 0.15);
        }

        .toggler-bar {
            width: 20px;
            height: 2px;
            background: #8a7a6a;
            border-radius: 2px;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .toggler-skeu.open .toggler-bar:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
            width: 22px;
            background: #6b5b4b;
        }

        .toggler-skeu.open .toggler-bar:nth-child(2) {
            opacity: 0;
            transform: scale(0);
        }

        .toggler-skeu.open .toggler-bar:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
            width: 22px;
            background: #6b5b4b;
        }

        /* Mobile menu - elegant */
        .mobile-menu-skeu {
            background: #ffffff;
            border: 1px solid #e2d7cd;
            border-radius: 12px;
            box-shadow: 0 20px 30px -12px rgba(70, 50, 30, 0.2);
            padding: 1rem 0.5rem;
            margin-top: 1rem;
        }

        .mobile-nav-link {
            font-family: 'Montserrat', sans-serif;
            color: #5c524a;
            padding: 0.875rem 1.25rem;
            border-bottom: 1px solid #eee7e0;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
            letter-spacing: 0.3px;
            font-size: 0.95rem;
            text-transform: uppercase;
        }

        .mobile-nav-link i {
            color: #b09b88;
            width: 24px;
            font-size: 1rem;
            margin-right: 12px;
        }

        .mobile-nav-link:hover {
            background: #faf5ef;
            color: #3f352e;
            padding-left: 1.75rem;
        }

        .mobile-nav-link:hover i {
            color: #8a735b;
        }

        .mobile-nav-link:last-child {
            border-bottom: none;
        }

        /* Logo styling */
        .logo-container {
            filter: drop-shadow(0 2px 4px rgba(100, 70, 40, 0.1));
        }

        /* Gold accent line */
        .gold-accent {
            background: linear-gradient(90deg, transparent, #d4b48c, #b89a78, #d4b48c, transparent);
            height: 1px;
            width: 60px;
            margin: 4px 0 2px;
        }

        /* Desktop spacing container */
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1440px;
            margin: 0 auto;
            padding: 0.75rem 2rem;
        }

        /* Large space between logo and nav items */
        .nav-spacer {
            flex: 2;
            min-width: 100px;
        }

        /* For desktop, create even spacing */
        .desktop-nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex: 1;
        }

        /* Reduced number of nav items - consolidated */
        .desktop-nav {
            display: flex;
            align-items: center;
        }

        /* Responsive adjustments */
        @media (min-width: 1024px) {
            .nav-container {
                padding: 0.75rem 3rem;
            }
        }

        @media (min-width: 1280px) {
            .nav-container {
                padding: 1rem 5rem;
            }
        }

        /* Elegant top bar */
        .top-bar {
            background: #f8f3ed;
            border-bottom: 1px solid #e8dfd5;
            color: #7a6b5e;
            font-size: 0.8rem;
            padding: 0.5rem 0;
            transition: height 0.3s ease, padding 0.3s ease, opacity 0.3s ease, border-bottom 0.3s ease;
            height: auto;
            overflow: visible;
        }

        /* Hero Section - Full Viewport */
        .hero-section {
            height: calc(100vh - 150px);
            min-height: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
            margin-top: 150px;
            box-sizing: border-box;
        }
        
        @media (max-width: 1023px) {
            .hero-section {
                margin-top: 80px;
                height: calc(100vh - 80px);
            }
        }

        /* Container for the cinematic photo experience */
        .cinema-showcase {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Individual image frame */
        .cinema-frame {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            animation: cinemaCycle 60s infinite; /* Slower cycle - 60 seconds total */
            overflow: hidden;
        }

        .cinema-frame:nth-child(1) {
            animation-delay: 0s;
        }
        .cinema-frame:nth-child(2) {
            animation-delay: 10s;
        }
        .cinema-frame:nth-child(3) {
            animation-delay: 20s;
        }
        .cinema-frame:nth-child(4) {
            animation-delay: 30s;
        }
        .cinema-frame:nth-child(5) {
            animation-delay: 40s;
        }
        .cinema-frame:nth-child(6) {
            animation-delay: 50s;
        }

        /* Image styling with cinematic pan and zoom */
        .cinema-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: cinematicMove 60s infinite;
            filter: brightness(0.75) saturate(1.1);
            transform-origin: center center;
        }

        .cinema-frame:nth-child(1) .cinema-image {
            animation-delay: 0s;
        }
        .cinema-frame:nth-child(2) .cinema-image {
            animation-delay: 10s;
        }
        .cinema-frame:nth-child(3) .cinema-image {
            animation-delay: 20s;
        }
        .cinema-frame:nth-child(4) .cinema-image {
            animation-delay: 30s;
        }
        .cinema-frame:nth-child(5) .cinema-image {
            animation-delay: 40s;
        }
        .cinema-frame:nth-child(6) .cinema-image {
            animation-delay: 50s;
        }

        /* Frame transition - longer display time */
        @keyframes cinemaCycle {
            0% {
                opacity: 0;
            }
            2% {
                opacity: 1;
            }
            16% {
                opacity: 1; /* Shows for about 14% of cycle */
            }
            18% {
                opacity: 0;
            }
            100% {
                opacity: 0;
            }
        }

        /* Cinematic pan and zoom effect - like a showroom */
        @keyframes cinematicMove {
            0% {
                transform: scale(1) translate(0, 0);
            }
            10% {
                transform: scale(1.08) translate(-2%, -1%);
            }
            20% {
                transform: scale(1.12) translate(3%, 2%);
            }
            30% {
                transform: scale(1.05) translate(-1%, 3%);
            }
            40% {
                transform: scale(1.15) translate(2%, -2%);
            }
            50% {
                transform: scale(1.1) translate(-3%, -1%);
            }
            60% {
                transform: scale(1.18) translate(1%, 2%);
            }
            70% {
                transform: scale(1.08) translate(3%, -2%);
            }
            80% {
                transform: scale(1.13) translate(-2%, 1%);
            }
            90% {
                transform: scale(1.07) translate(1%, -1%);
            }
            100% {
                transform: scale(1) translate(0, 0);
            }
        }

        /* Light Blue Overlay - very subtle */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, rgba(135, 206, 235, 0.12) 0%, rgba(173, 216, 230, 0.08) 100%);
            z-index: 2;
            pointer-events: none;
        }

        /* Content Container */
        .hero-content {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 2rem;
        }

        /* Main Card Container - transparent */
        .experience-card {
            position: relative;
            width: min(800px, 90%);
            min-height: 350px;
            background: transparent;
            border: none;
            border-radius: 0;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: none;
        }

        /* Arrow Container - Directional Pad Layout - wider spacing */
        .card-arrows {
            display: grid;
            grid-template-columns: auto 1fr auto;
            grid-template-rows: auto 1fr auto;
            gap: 1.5rem 4rem;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Arrow items - no background, just icon */
        .arrow-item {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s ease;
            padding: 1rem;
        }

        .arrow-item i {
            font-size: 2.5rem;
            color: #d4af37;
            transition: all 0.4s ease;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
        }

        /* Hover effects */
        .arrow-item:hover i {
            color: #f4d03f;
            transform: scale(1.15);
            text-shadow: 0 0 30px rgba(244, 208, 63, 0.6);
        }

        /* Individual arrow positions */
        .arrow-item.up {
            grid-column: 2;
            grid-row: 1;
        }
        .arrow-item.up:hover i {
            transform: translateY(-3px) scale(1.15);
        }

        .arrow-item.left {
            grid-column: 1;
            grid-row: 2;
        }
        .arrow-item.left:hover i {
            transform: translateX(-3px) scale(1.15);
        }

        .arrow-item.right {
            grid-column: 3;
            grid-row: 2;
        }
        .arrow-item.right:hover i {
            transform: translateX(3px) scale(1.15);
        }

        .arrow-item.down {
            grid-column: 2;
            grid-row: 3;
        }
        .arrow-item.down:hover i {
            transform: translateY(3px) scale(1.15);
        }

        /* Center text container */
        .arrow-center-text {
            grid-column: 2;
            grid-row: 2;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 1rem 0;
        }

        /* Center title - Unearth Timeless Luxury at Aora45 */
        .center-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 400;
            letter-spacing: 0.08em;
            color: #fff;
            text-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .center-title .brand {
            display: block;
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2.5rem, 7vw, 5rem);
            color: #d4af37;
            margin-top: 0.5rem;
            letter-spacing: 0.15em;
            text-shadow: 0 0 40px rgba(212, 175, 55, 0.3);
        }

        /* Subtitle below */
        .center-subtitle {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(0.7rem, 1.5vw, 1rem);
            font-weight: 300;
            letter-spacing: 0.35em;
            color: rgba(255, 255, 255, 0.85);
            text-transform: uppercase;
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .experience-card {
                min-height: 280px;
                padding: 1.5rem;
                width: 100%;
            }
            
            .card-arrows {
                gap: 1rem 2.5rem;
            }
            
            .arrow-item i {
                font-size: 2rem;
            }
            
            /* Center hero content on mobile */
            .hero-content {
                padding: 1rem;
                text-align: center;
                align-items: center;
            }
            
            .arrow-center-text {
                text-align: center;
                grid-column: 2;
            }
        }

        @media (max-width: 480px) {
            .experience-card {
                min-height: 220px;
                padding: 1rem;
            }
            
            .card-arrows {
                gap: 0.75rem 2rem;
            }
            
            .arrow-item i {
                font-size: 1.5rem;
            }
            
            .center-subtitle {
                font-size: 0.6rem;
                letter-spacing: 0.2em;
            }
        }

        /* Subtle gradient overlay at bottom */
        .hero-gradient {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
            z-index: 5;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <!-- Header/Navbar Component -->
    <header class="w-full fixed top-0 left-0 right-0 z-50">
        <!-- Top Bar - very subtle, elegant -->
        <div class="top-bar hidden md:block">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <span class="flex items-center"><i class="fas fa-map-pin mr-2 text-[#b09b88] text-xs"></i> Nairobi, Kenya 00100</span>
                    <span class="flex items-center"><i class="far fa-clock mr-2 text-[#b09b88] text-xs"></i> Check-in: 2PM | Check-out: 12PM</span>
                </div>
                <div class="flex items-center space-x-5">
                    <a href="#" class="hover:text-[#5c4a38] transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-[#5c4a38] transition-colors"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-[#5c4a38] transition-colors"><i class="fab fa-pinterest-p"></i></a>
                    <span class="text-[#b09b88]">|</span>
                    <span class="flex items-center"><i class="fas fa-phone-alt mr-2 text-[#b09b88] text-xs"></i> +960 123-4567</span>
                </div>
            </div>
        </div>

        <!-- Main Navbar -->
        <nav class="navbar-skeu w-full py-2 md:py-3 relative z-50">
            <div class="nav-container">
                
                <!-- Logo with resort name - left side -->
                <div class="logo-container flex items-center">
                    <img src="logo1.png" alt="Aora45 Resort" class="h-20 md:h-24 w-auto" onerror="this.src='https://placehold.co/180x70/f5efe8/8a735b?text=AORA'">
                    <div class="ml-3">
                        <h1 class="font-['Playfair_Display'] text-3xl md:text-4xl font-medium text-[#4a3f37] tracking-wide">Aora45</h1>
                        <div class="gold-accent"></div>
                        <p class="text-xs tracking-[0.25em] text-[#9a8a78] font-light mt-0.5">RESORT & RESTAURANT</p>
                    </div>
                </div>

                <!-- LARGE BLANK SPACE between logo and HOME (as requested) -->
                <div class="nav-spacer"></div>

                <!-- Desktop Navigation - right side with consolidated items -->
                <div class="hidden lg:flex desktop-nav-wrapper">
                    <div class="desktop-nav">
                        <a href="index.php" class="nav-link active">Home</a>
                        <a href="rooms.php" class="nav-link">Rooms</a>
                        <a href="restaurant.php" class="nav-link">Restaurant</a>
                        <a href="events.php" class="nav-link">Events</a>
                        <a href="contact.php" class="nav-link">Contact</a>
                    </div>
                </div>

                <!-- Right side - ONLY toggler (no search, no language) -->
                <div class="flex items-center">
                    <!-- Mobile: Only the toggler (no extra icons) -->
                    <button id="menuToggler" class="toggler-skeu lg:hidden" aria-label="Menu">
                        <span class="toggler-bar"></span>
                        <span class="toggler-bar"></span>
                        <span class="toggler-bar"></span>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu (hidden by default) -->
            <div id="mobileMenu" class="mobile-menu-skeu lg:hidden mx-4 mt-2 hidden">
                <div class="flex flex-col">
                    <a href="index.php" class="mobile-nav-link"><i class="fas fa-home"></i>Home</a>
                    <a href="rooms.php" class="mobile-nav-link"><i class="fas fa-bed"></i>Rooms & Suites</a>
                    <a href="restaurant.php" class="mobile-nav-link"><i class="fas fa-utensils"></i>Restaurant</a>
                    <a href="amenities.php" class="mobile-nav-link"><i class="fas fa-spa"></i>Amenities</a>
                    <a href="gallery.php" class="mobile-nav-link"><i class="fas fa-images"></i>Gallery</a>
                    <a href="events.php" class="mobile-nav-link"><i class="fas fa-glass-cheers"></i>Events</a>
                    <a href="offers.php" class="mobile-nav-link"><i class="fas fa-tag"></i>Offers</a>
                    <a href="about.php" class="mobile-nav-link"><i class="fas fa-info-circle"></i>About</a>
                    <a href="contact.php" class="mobile-nav-link"><i class="fas fa-envelope"></i>Contact</a>
                    
                    <!-- Mobile menu extras -->
                    <div class="mt-4 pt-4 border-t border-[#eee7e0] px-4">
                        <div class="flex items-center justify-between text-sm text-[#7a6b5e] mb-3">
                            <span><i class="fas fa-phone-alt mr-2 text-[#b09b88]"></i>+254 123-4567</span>
                            <span><i class="fas fa-envelope mr-2 text-[#b09b88]"></i>info@Aora45.com</span>
                        </div>
                        <div class="flex justify-center space-x-5 py-2 text-[#b09b88]">
                            <a href="#" class="hover:text-[#5c4a38]"><i class="fab fa-instagram fa-lg"></i></a>
                            <a href="#" class="hover:text-[#5c4a38]"><i class="fab fa-facebook-f fa-lg"></i></a>
                            <a href="#" class="hover:text-[#5c4a38]"><i class="fab fa-pinterest fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Simple script for toggler animation and scroll behavior -->
    <script>
        (function() {
            const toggler = document.getElementById('menuToggler');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (toggler && mobileMenu) {
                toggler.addEventListener('click', function() {
                    this.classList.toggle('open');
                    
                    if (mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.remove('hidden');
                        mobileMenu.style.animation = 'slideDown 0.25s ease-out';
                    } else {
                        mobileMenu.style.animation = 'slideUp 0.2s ease-out';
                        setTimeout(() => {
                            mobileMenu.classList.add('hidden');
                        }, 200);
                    }
                });
            }
            
            // Scroll behavior: Hide top-bar on desktop when scrolling
            const topBar = document.querySelector('.top-bar');
            const mainNav = document.querySelector('.navbar-skeu');
            
            if (topBar && mainNav) {
                let lastScrollY = window.scrollY;
                let ticking = false;
                
                function updateTopBarOnScroll() {
                    // Only apply on desktop (lg and above - 1024px)
                    if (window.innerWidth >= 1024) {
                        const currentScrollY = window.scrollY;
                        
                        // When scrolling down past 10px, hide the top-bar
                        if (currentScrollY > 10) {
                            topBar.style.height = '0';
                            topBar.style.padding = '0';
                            topBar.style.borderBottom = '0';
                            topBar.style.overflow = 'hidden';
                            topBar.style.opacity = '0';
                        } else {
                            // When at top, show the top-bar
                            topBar.style.height = '';
                            topBar.style.padding = '';
                            topBar.style.borderBottom = '';
                            topBar.style.overflow = '';
                            topBar.style.opacity = '1';
                        }
                        
                        lastScrollY = currentScrollY;
                    } else {
                        // On mobile/tablet, reset to default state
                        topBar.style.height = '';
                        topBar.style.padding = '';
                        topBar.style.borderBottom = '';
                        topBar.style.overflow = '';
                        topBar.style.opacity = '1';
                    }
                    
                    ticking = false;
                }
                
                window.addEventListener('scroll', function() {
                    if (!ticking) {
                        window.requestAnimationFrame(updateTopBarOnScroll);
                        ticking = true;
                    }
                });
                
                // Also check on resize
                window.addEventListener('resize', function() {
                    updateTopBarOnScroll();
                });
            }
        })();
    </script>

    <!-- Animations -->
    <style>
        @keyframes slideDown {
            0% { opacity: 0; transform: translateY(-8px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            0% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-8px); }
        }
        
        .container {
            max-width: 1440px;
            margin: 0 auto;
        }

        /* Very subtle texture overlay - barely visible */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><filter id="noise"><feTurbulence type="fractalNoise" baseFrequency="0.45" numOctaves="1" stitchTiles="stitch"/><feColorMatrix type="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 0.03 0"/></filter><rect width="100" height="100" filter="url(%23noise)" opacity="0.2"/></svg>');
            pointer-events: none;
            z-index: 9999;
            opacity: 0.25;
        }
    </style>
