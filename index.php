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

    <!-- Hero Section Only -->
    <section class="hero-section">
        <!-- Cinema Showcase - Like a photo film with slow pan and zoom -->
        <div class="cinema-showcase">
            <!-- Frame 1 - Resort Pool -->
            <div class="cinema-frame">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Infinity Pool at Sunset" class="cinema-image">
            </div>
            <!-- Frame 2 - Beach -->
            <div class="cinema-frame">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Private Beach Paradise" class="cinema-image">
            </div>
            <!-- Frame 3 - Luxury Suite -->
            <div class="cinema-frame">
                <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2080&q=80" alt="Oceanfront Suite" class="cinema-image">
            </div>
            <!-- Frame 4 - Restaurant -->
            <div class="cinema-frame">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Fine Dining Restaurant" class="cinema-image">
            </div>
            <!-- Frame 5 - Spa -->
            <div class="cinema-frame">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Luxury Spa Treatment" class="cinema-image">
            </div>
            <!-- Frame 6 - Sunset -->
            <div class="cinema-frame">
                <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Sunset Over Ocean" class="cinema-image">
            </div>
        </div>

        <!-- Light Blue Overlay -->
        <div class="hero-overlay"></div>

        <!-- Bottom Gradient -->
        <div class="hero-gradient"></div>

        <!-- Content -->
        <div class="hero-content">
            <!-- Main Card with Arrows surrounding text -->
            <div class="experience-card">
                
                <!-- Arrows container - directional pad layout -->
                <div class="card-arrows">
                    <!-- Up Arrow -->
                    <div class="arrow-item up">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    
                    <!-- Center text - Main tagline -->
                    <div class="arrow-center-text">
                        <div class="center-title">
                            Unearth Timeless Luxury
                            <span class="brand">Aora45</span>
                        </div>
                        <div class="center-subtitle">Begin Your Journey</div>
                    </div>
                    
                    <!-- Left Arrow -->
                    <div class="arrow-item left">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    
                    <!-- Right Arrow -->
                    <div class="arrow-item right">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    
                    <!-- Down Arrow -->
                    <div class="arrow-item down">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Welcome Intro Section - Evocative, Brief, and Unique -->
<section class="relative py-24 px-6 bg-[#f5efe8] overflow-hidden">
    <!-- Decorative Elements - Subtle Skeuomorphic Details -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-64 h-64 bg-[#e8d9c5] rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#d4b48c] rounded-full blur-3xl opacity-10"></div>
    </div>
    
    <div class="max-w-5xl mx-auto relative">
        <!-- Ornate Divider - Top -->
        <div class="flex justify-center items-center gap-4 mb-8">
            <div class="w-12 h-px bg-gradient-to-r from-transparent via-[#b8a084] to-transparent"></div>
            <i class="fas fa-tree text-[#b89a78] text-sm"></i>
            <div class="w-12 h-px bg-gradient-to-r from-transparent via-[#b8a084] to-transparent"></div>
        </div>
        
        <!-- Main Content - Brief, Evocative Paragraph -->
        <div class="text-center mb-10">
            <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl lg:text-4xl text-[#3f352e] leading-relaxed max-w-3xl mx-auto italic">
                "Where the <span class="font-semibold text-[#8a735b]">highlands' whisper</span> meets 
                <span class="font-semibold text-[#8a735b]">Swahili coast flavors</span>, and every 
                <span class="font-['DM_Serif_Display'] text-[#b89a78]">Nairobi sunset</span> paints a new story."
            </p>
        </div>
        
        <!-- Brief Description with Elegant Typography -->
        <div class="flex flex-col items-center">
            <div class="max-w-2xl text-center mb-8">
                <p class="font-['Montserrat'] text-sm md:text-base text-[#6b5d51] leading-relaxed tracking-wide">
                    In the heart of Nairobi's vibrant landscape, Aora45 offers an urban sanctuary—<br class="hidden sm:block">
                    where Kenyan hospitality meets timeless elegance.
                </p>
            </div>
            
            <!-- Unique Link to About Page - with skeuomorphic button -->
            <a href="about.php" class="group relative inline-flex items-center gap-3 px-8 py-4 bg-[#ffffff] border border-[#d6cbbc] rounded-full shadow-[0_8px_20px_-8px_rgba(100,70,40,0.2)] hover:shadow-[0_12px_25px_-8px_rgba(100,70,40,0.3)] transition-all duration-300">
                <!-- Decorative left line -->
                <span class="w-6 h-px bg-gradient-to-r from-transparent via-[#b8a084] to-transparent group-hover:w-8 transition-all duration-300"></span>
                
                <!-- Text with icon -->
                <span class="font-['Montserrat'] text-sm uppercase tracking-[0.2em] text-[#5c524a] group-hover:text-[#3f352e] transition-colors">
                    DISCOVER MORE ABOUT US
                </span>
                <i class="fas fa-arrow-right text-[#b89a78] text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                
                <!-- Decorative right line -->
                <span class="w-6 h-px bg-gradient-to-r from-transparent via-[#b8a084] to-transparent group-hover:w-8 transition-all duration-300"></span>
                
                <!-- Subtle inner shadow for skeuomorphic effect -->
                <span class="absolute inset-0 rounded-full bg-gradient-to-t from-[#f0e7dd] to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></span>
            </a>
        </div>
        
        <!-- Ornate Divider - Bottom - with Kenyan inspired icon -->
        <div class="flex justify-center items-center gap-4 mt-12">
            <div class="w-12 h-px bg-gradient-to-r from-transparent via-[#b8a084] to-transparent"></div>
            <i class="fas fa-mountain text-[#b89a78] text-xs"></i>
            <div class="w-12 h-px bg-gradient-to-r from-transparent via-[#b8a084] to-transparent"></div>
        </div>
    </div>
</section>




<!-- Accommodation Previews - Glossy Slideshow Section -->
<section class="relative py-24 px-6 bg-gradient-to-br from-[#1a2a32] to-[#2c3e4e] overflow-hidden">
    <!-- Decorative Wave Pattern Overlay -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,170.7C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <!-- Section Header -->
    <div class="relative z-10 max-w-7xl mx-auto text-center mb-12">
        <span class="text-[#d4b48c] font-['Montserrat'] text-sm uppercase tracking-[0.3em]">Luxury Stays</span>
        <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-white mt-4 mb-6">Rooms & Suites</h2>
        <div class="w-24 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
    </div>

    <!-- Slideshow Container -->
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6">
        <!-- Gradient Overlays for fade effect on edges -->
        <div class="absolute left-0 top-0 bottom-0 w-16 md:w-24 bg-gradient-to-r from-[#1a2a32] to-transparent z-20 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-16 md:w-24 bg-gradient-to-l from-[#1a2a32] to-transparent z-20 pointer-events-none"></div>
        
        <!-- Cards Slider - Using CSS animation for seamless uniform movement -->
        <div class="slider-container overflow-hidden py-4" style="mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent); -webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);">
            <div class="slider-track flex gap-0" id="roomSlider">
                <!-- Card 1 - Deluxe Room -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Deluxe Room" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 3K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Deluxe Room</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Elegant room with city views, king-size bed, and modern amenities.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs" title="Free WiFi"></i>
                                <i class="fas fa-snowflake text-xs" title="Air Conditioning"></i>
                                <i class="fas fa-tv text-xs" title="Smart TV"></i>
                                <i class="fas fa-coffee text-xs" title="Coffee Maker"></i>
                            </div>
                            
                            <button onclick="openRoomModal('deluxe')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 - Executive Suite -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Executive Suite" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 5K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Executive Suite</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Spacious suite with separate living area and exclusive lounge access.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs"></i>
                                <i class="fas fa-snowflake text-xs"></i>
                                <i class="fas fa-tv text-xs"></i>
                                <i class="fas fa-glass-cheers text-xs" title="Mini Bar"></i>
                            </div>
                            
                            <button onclick="openRoomModal('executive')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 3 - Family Villa -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80" 
                                 alt="Family Villa" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 7K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Family Villa</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Two-bedroom villa with private garden and family-friendly amenities.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs"></i>
                                <i class="fas fa-snowflake text-xs"></i>
                                <i class="fas fa-tv text-xs"></i>
                                <i class="fas fa-utensils text-xs" title="Kitchen"></i>
                            </div>
                            
                            <button onclick="openRoomModal('family')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 4 - Presidential Suite -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Presidential Suite" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 110K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Presidential Suite</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Ultimate luxury with private terrace and butler service.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs"></i>
                                <i class="fas fa-snowflake text-xs"></i>
                                <i class="fas fa-tv text-xs"></i>
                                <i class="fas fa-champagne-glasses text-xs" title="Champagne"></i>
                            </div>
                            
                            <button onclick="openRoomModal('presidential')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 5 - Garden View Room -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Garden View Room" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 30K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Garden View Room</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="far fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Serene room overlooking lush gardens.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs"></i>
                                <i class="fas fa-snowflake text-xs"></i>
                                <i class="fas fa-tv text-xs"></i>
                                <i class="fas fa-leaf text-xs" title="Garden View"></i>
                            </div>
                            
                            <button onclick="openRoomModal('garden')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 6 - Honeymoon Suite -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Honeymoon Suite" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 5K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Honeymoon Suite</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Romantic retreat with king bed and private balcony.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs"></i>
                                <i class="fas fa-snowflake text-xs"></i>
                                <i class="fas fa-tv text-xs"></i>
                                <i class="fas fa-heart text-xs" title="Romantic Setup"></i>
                            </div>
                            
                            <button onclick="openRoomModal('honeymoon')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 7 - Business Suite -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1522778526097-ce0a22ceb253?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Business Suite" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 4K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Business Suite</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="far fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Designed for professionals with work desk.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs"></i>
                                <i class="fas fa-snowflake text-xs"></i>
                                <i class="fas fa-tv text-xs"></i>
                                <i class="fas fa-laptop text-xs" title="Work Desk"></i>
                            </div>
                            
                            <button onclick="openRoomModal('business')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 8 - Sky Penthouse -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1536376072261-38c75010e6c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                                 alt="Penthouse" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 150K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Sky Penthouse</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Top-floor residence with private rooftop terrace.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs"></i>
                                <i class="fas fa-snowflake text-xs"></i>
                                <i class="fas fa-tv text-xs"></i>
                                <i class="fas fa-hot-tub text-xs" title="Hot Tub"></i>
                            </div>
                            
                            <button onclick="openRoomModal('penthouse')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Duplicate cards for seamless infinite loop effect -->
                <!-- Duplicate: Deluxe Room (for seamless transition back to start) -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Deluxe Room" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 3K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Deluxe Room</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Elegant room with city views, king-size bed, and modern amenities.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs" title="Free WiFi"></i>
                                <i class="fas fa-snowflake text-xs" title="Air Conditioning"></i>
                                <i class="fas fa-tv text-xs" title="Smart TV"></i>
                                <i class="fas fa-coffee text-xs" title="Coffee Maker"></i>
                            </div>
                            
                            <button onclick="openRoomModal('deluxe')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Duplicate: Executive Suite -->
                <div class="slide flex-none w-1/3 px-2">
                    <div class="accommodation-card group relative bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/20 shadow-[0_15px_30px_-12px_rgba(0,0,0,0.5)] hover:shadow-[0_20px_40px_-12px_rgba(0,0,0,0.7)] transition-all duration-500 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Executive Suite" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">
                                <span class="text-white font-['Montserrat'] font-light text-xs">FROM</span>
                                <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-base ml-1">KSh 5K</span>
                                <span class="text-white/80 text-[10px]">/night</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Executive Suite</h3>
                                <div class="flex text-[#d4b48c]">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>
                            
                            <p class="text-white/70 text-xs mb-3 line-clamp-2">Spacious suite with separate living area and exclusive lounge access.</p>
                            
                            <div class="flex gap-2 mb-4 text-white/60">
                                <i class="fas fa-wifi text-xs"></i>
                                <i class="fas fa-snowflake text-xs"></i>
                                <i class="fas fa-tv text-xs"></i>
                                <i class="fas fa-glass-cheers text-xs" title="Mini Bar"></i>
                            </div>
                            
                            <button onclick="openRoomModal('executive')" class="inline-flex items-center gap-2 text-[#d4b48c] hover:text-white transition-colors duration-300 group/link text-xs">
                                <span class="text-[10px] uppercase tracking-wider font-medium">View Details</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Dots - Created dynamically via JavaScript -->
    <div class="relative z-10 flex justify-center gap-2 mt-6" id="dotsContainer">
    </div>

    <!-- View All Rooms Link -->
    <div class="relative z-10 text-center mt-8">
        <a href="rooms.php" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white/10 backdrop-blur-md rounded-full border border-white/20 text-white hover:bg-white/20 transition-all duration-300 group">
            <span class="text-xs uppercase tracking-wider">Explore All Rooms</span>
            <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    <!-- Room Detail Modal -->
    <div id="roomModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="display: none;">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md" onclick="closeRoomModal()"></div>
        
        <div class="relative bg-gradient-to-br from-[#2c3e4e] to-[#1a2a32] rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto border border-white/20 shadow-2xl">
            <button onclick="closeRoomModal()" class="absolute top-4 right-4 text-white/70 hover:text-white z-10">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div id="modalContent" class="p-5 md:p-6">
                <!-- Content loaded via JavaScript -->
            </div>
        </div>
    </div>
</section>

<style>
/* Slideshow styles */
.slider-container {
    width: 100%;
    position: relative;
    overflow: visible;
}

.slider-track {
    transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform;
}

.slide {
    transition: opacity 0.4s ease;
    display: flex;
}

/* Navigation dots */
.dot {
    cursor: pointer;
    transition: all 0.3s ease;
}

.dot.active {
    background-color: #d4b48c;
    transform: scale(1.2);
}

/* Modal styles */
#roomModal {
    transition: opacity 0.3s ease;
}

#roomModal.show {
    display: flex;
    opacity: 1;
}

#roomModal .overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

#roomModal .overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
}

#roomModal .overflow-y-auto::-webkit-scrollbar-thumb {
    background: #d4b48c;
    border-radius: 10px;
}

/* Responsive card sizing - Fixed uniform sizing */
@media (min-width: 768px) {
    .slide {
        width: calc(33.333% - 0px);
        flex: 0 0 calc(33.333% - 0px);
    }
}

@media (max-width: 767px) {
    .slide {
        width: 100%;
        flex: 0 0 100%;
    }
}

/* Ensure all cards have equal height */
.accommodation-card {
    max-width: 100%;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* Image container fixed height for consistency */
.accommodation-card .relative.h-48 {
    height: 200px;
    flex-shrink: 0;
}

/* Card content area - ensure consistent height */
.accommodation-card .p-4 {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Smooth hover effects */
.accommodation-card:hover {
    transform: translateY(-4px);
}

/* Mobile-specific adjustments */
@media (max-width: 767px) {
    .slider-container {
        padding-top: 8px;
        padding-bottom: 8px;
    }
    
    .accommodation-card .relative.h-48 {
        height: 220px;
    }
}

/* Desktop - ensure card height is consistent */
@media (min-width: 768px) {
    .slider-track {
        padding-top: 4px;
        padding-bottom: 4px;
    }
    
    .accommodation-card .relative.h-48 {
        height: 200px;
    }
}
</style>

<script>
// Room data for modal
const roomData = {
    deluxe: {
        name: 'Deluxe Room',
        price: 'KSh 3,000',
        description: 'Experience elegance in our Deluxe Room, featuring contemporary design with warm earth tones. Perfect for the discerning traveler seeking comfort and style.',
        amenities: ['King-size bed', 'City view', 'Smart TV', 'Mini bar', 'Rain shower', 'Free WiFi', 'Coffee maker', 'Room safe'],
        size: '45 m²',
        occupancy: '2 Adults',
        image: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
    },
    executive: {
        name: 'Executive Suite',
        price: 'KSh 5,000',
        description: 'Our Executive Suite offers spacious luxury with a separate living area, perfect for business travelers or those seeking extra space.',
        amenities: ['Separate living room', 'Panoramic views', 'Executive lounge access', 'Work desk', 'Espresso machine', 'Bathrobe & slippers', 'Premium toiletries', 'Evening turndown'],
        size: '65 m²',
        occupancy: '2 Adults',
        image: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
    },
    family: {
        name: 'Family Villa',
        price: 'KSh 7,000',
        description: 'Perfect for families, our villa offers two bedrooms, a private garden, and all the comforts of home in a luxurious setting.',
        amenities: ['Two bedrooms', 'Private garden', 'Full kitchen', 'Living room', 'Children\'s play area', 'Outdoor dining', 'BBQ facilities', 'Laundry service'],
        size: '95 m²',
        occupancy: '4 Adults + 2 Children',
        image: 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80'
    },
    presidential: {
        name: 'Presidential Suite',
        price: 'KSh 10,000',
        description: 'The pinnacle of luxury. Our Presidential Suite offers unmatched elegance with panoramic views, personal butler service, and exquisite furnishings.',
        amenities: ['Private terrace', 'Butler service', 'Jacuzzi', 'Dining room', 'Wine cellar', 'Steam room', 'Home theater', 'Private check-in'],
        size: '150 m²',
        occupancy: '2 Adults',
        image: 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
    },
    garden: {
        name: 'Garden View Room',
        price: 'KSh 3,000',
        description: 'Wake up to lush garden views in this serene room, designed for nature lovers seeking tranquility.',
        amenities: ['Garden view', 'Queen bed', 'Private balcony', 'Rain shower', 'Organic toiletries', 'Tea/coffee', 'Ceiling fan', 'Mosquito nets'],
        size: '35 m²',
        occupancy: '2 Adults',
        image: 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
    },
    honeymoon: {
        name: 'Honeymoon Suite',
        price: 'KSh 6,000',
        description: 'Designed for romance, this suite features intimate settings, a private balcony with sunset views, and special amenities for couples.',
        amenities: ['King bed', 'Sunset balcony', 'Champagne on arrival', 'Rose petal turndown', 'Double vanity', 'Deep soaking tub', 'Candlelit dining', 'Couples massage'],
        size: '55 m²',
        occupancy: '2 Adults',
        image: 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
    },
    business: {
        name: 'Business Suite',
        price: 'KSh 4,000',
        description: 'Optimized for the modern professional, featuring a dedicated workspace and all the tech amenities needed for productivity.',
        amenities: ['Work desk', 'Ergonomic chair', 'High-speed internet', 'Printer access', 'Conference phone', 'Stationery set', 'Complimentary printing', 'Meeting space'],
        size: '50 m²',
        occupancy: '2 Adults',
        image: 'https://images.unsplash.com/photo-1522778526097-ce0a22ceb253?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
    },
    penthouse: {
        name: 'Sky Penthouse',
        price: 'KSh 5,000',
        description: 'The ultimate expression of luxury living, occupying the entire top floor with 360° views and unparalleled amenities.',
        amenities: ['Rooftop terrace', 'Private pool', 'Hot tub', 'Outdoor kitchen', 'Panoramic views', 'Private elevator', 'Wine room', 'Personal chef'],
        size: '200 m²',
        occupancy: '4 Adults',
        image: 'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80'
    }
};

// Slideshow functionality - Seamless infinite loop with duplicate cards for smooth transition
document.addEventListener('DOMContentLoaded', function() {
    const sliderTrack = document.querySelector('.slider-track');
    const slides = document.querySelectorAll('.slide');
    const container = document.querySelector('.slider-container');
    
    // Configuration - check on load and resize
    let isMobile = window.innerWidth < 768;
    let slidesPerView = isMobile ? 1 : 3;
    const totalOriginalCards = 8; // 8 unique cards
    const totalSlides = slides.length; // Total including duplicates
    
    let currentIndex = 0;
    let autoPlayInterval;
    let isAnimating = false;
    
    // Get actual rendered width of a single slide
    function getSlideWidth() {
        if (!slides.length) return 0;
        const firstSlide = slides[0];
        const width = firstSlide.getBoundingClientRect().width;
        return width;
    }
    
    function updateSlider(index, animate = true) {
        if (!slides.length || isAnimating) return;
        
        const slideWidth = getSlideWidth();
        const translateX = -(index * slideWidth);
        
        if (animate) {
            sliderTrack.style.transition = 'transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
        } else {
            sliderTrack.style.transition = 'none';
        }
        
        sliderTrack.style.transform = `translateX(${translateX}px)`;
        
        // Update dots based on current view - based on original cards only
        const currentSet = Math.floor(index / slidesPerView);
        const maxSets = Math.ceil(totalOriginalCards / slidesPerView);
        
        const dotsContainer = document.getElementById('dotsContainer');
        if (!dotsContainer) return;
        const dots = dotsContainer.querySelectorAll('.dot');
        
        dots.forEach((dot, i) => {
            if (i < maxSets) {
                // Calculate which set we're showing (modulo for looping)
                const effectiveSet = currentSet % maxSets;
                if (i === effectiveSet) {
                    dot.classList.add('active', 'bg-[#d4b48c]');
                    dot.classList.remove('bg-white/30');
                } else {
                    dot.classList.remove('active', 'bg-[#d4b48c]');
                    dot.classList.add('bg-white/30');
                }
            }
        });
    }
    
    function nextSlide() {
        if (isAnimating) return;
        
        currentIndex += slidesPerView;
        
        // When we reach the duplicate cards section, seamlessly reset to beginning
        // This creates the illusion of infinite scrolling
        if (currentIndex >= totalOriginalCards) {
            // Just let it continue to show duplicates - they'll animate naturally from right
            // The transition will be smooth like any other slide change
        }
        
        updateSlider(currentIndex);
        
        // After showing duplicates and completing animation, check if we need to reset
        if (currentIndex >= totalOriginalCards) {
            isAnimating = true;
            // Wait for animation to complete, then instantly reset to 0 (but user won't notice because duplicates look same as start)
            setTimeout(() => {
                sliderTrack.style.transition = 'none';
                currentIndex = currentIndex - totalOriginalCards; // Reset to position 0 but visually identical
                sliderTrack.style.transform = `translateX(${-(currentIndex * getSlideWidth())}px)`;
                
                // Force reflow
                sliderTrack.offsetHeight;
                
                // Restore animation
                setTimeout(() => {
                    sliderTrack.style.transition = 'transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                    isAnimating = false;
                }, 50);
            }, 800);
        }
    }
    
    // Start auto-play
    function startAutoPlay() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
        // Faster interval on mobile (3 seconds) for 1 card at a time
        autoPlayInterval = setInterval(nextSlide, isMobile ? 3000 : 5000);
    }
    
    // Create dots dynamically based on device
    function createDots() {
        const dotsContainer = document.getElementById('dotsContainer');
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';
        
        const maxSets = Math.ceil(totalOriginalCards / slidesPerView);
        
        for (let i = 0; i < maxSets; i++) {
            const dot = document.createElement('div');
            dot.className = `w-1.5 h-1.5 rounded-full dot ${i === 0 ? 'bg-[#d4b48c] active' : 'bg-white/30'}`;
            dot.dataset.index = i;
            dot.addEventListener('click', () => {
                clearInterval(autoPlayInterval);
                currentIndex = i * slidesPerView;
                updateSlider(currentIndex);
                startAutoPlay();
            });
            dotsContainer.appendChild(dot);
        }
    }
    
    // Pause on hover (desktop only)
    if (!isMobile) {
        sliderTrack.addEventListener('mouseenter', () => {
            clearInterval(autoPlayInterval);
        });
        
        sliderTrack.addEventListener('mouseleave', () => {
            startAutoPlay();
        });
    }
    
    // Handle resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            const wasMobile = isMobile;
            isMobile = window.innerWidth < 768;
            slidesPerView = isMobile ? 1 : 3;
            
            // Recreate dots if switching between mobile/desktop
            if (wasMobile !== isMobile) {
                createDots();
            }
            
            // Reset to beginning on resize
            currentIndex = 0;
            sliderTrack.style.transform = 'translateX(0)';
            
            // Restart autoplay with new interval
            startAutoPlay();
        }, 150);
    });
    
    // Initialize
    if (slides.length) {
        createDots();
        setTimeout(() => {
            updateSlider(0, false);
            startAutoPlay();
        }, 100);
    }
});

// Modal functions
function openRoomModal(roomType) {
    const room = roomData[roomType];
    if (!room) return;
    
    const modal = document.getElementById('roomModal');
    const modalContent = document.getElementById('modalContent');
    
    modalContent.innerHTML = `
        <div class="grid md:grid-cols-2 gap-4">
            <div class="relative h-56 md:h-full rounded-lg overflow-hidden">
                <img src="${room.image}" alt="${room.name}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
            
            <div class="text-white">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-['Cormorant_Garamond'] text-2xl text-white">${room.name}</h2>
                    <div class="flex text-[#d4b48c]">
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">${room.price}</span>
                    <span class="text-white/60 text-xs">/ night</span>
                    <span class="text-white/40">|</span>
                    <span class="text-white/80 text-xs">${room.size}</span>
                    <span class="text-white/40">|</span>
                    <span class="text-white/80 text-xs">${room.occupancy}</span>
                </div>
                
                <p class="text-white/80 text-sm mb-4 leading-relaxed">${room.description}</p>
                
                <h3 class="font-['Cormorant_Garamond'] text-lg text-white mb-2">Amenities</h3>
                <div class="grid grid-cols-2 gap-2 mb-6">
                    ${room.amenities.map(amenity => `
                        <div class="flex items-center gap-2 text-white/70">
                            <i class="fas fa-check-circle text-[#d4b48c] text-[10px]"></i>
                            <span class="text-xs">${amenity}</span>
                        </div>
                    `).join('')}
                </div>
                
                <div class="flex gap-3">
                    <button onclick="closeRoomModal()" class="flex-1 px-5 py-2.5 bg-[#d4b48c] text-[#1a2a32] rounded-full text-sm font-medium hover:bg-[#c4a47c] transition-colors">
                        Check Availability
                    </button>
                    <button onclick="closeRoomModal()" class="px-5 py-2.5 border border-white/20 rounded-full text-sm hover:bg-white/10 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    `;
    
    modal.style.display = 'flex';
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeRoomModal() {
    const modal = document.getElementById('roomModal');
    modal.style.display = 'none';
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRoomModal();
    }
});
</script>



<!-- Restaurant Teaser Section - Signature Dish Showcase -->
<section class="relative py-28 px-6 bg-[#f5efe8] overflow-hidden">
    <!-- Decorative Elements - Luxury Restaurant Ambiance -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Warm ambient glow -->
        <div class="absolute top-20 right-20 w-96 h-96 bg-[#d4b48c]/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-20 left-20 w-80 h-80 bg-[#8a735b]/20 rounded-full blur-[100px]"></div>
        
        <!-- Subtle pattern overlay - fine dining texture -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: repeating-linear-gradient(45deg, #8a735b 0px, #8a735b 2px, transparent 2px, transparent 8px);"></div>
    </div>

    <div class="max-w-7xl mx-auto relative">
        <!-- Section Header - Minimalist Elegance -->
        <div class="text-center mb-16">
            <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Culinary Excellence</span>
            <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#3f352e] mt-4 mb-6 font-light">The Art of Dining</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
        </div>

        <!-- Main Content Grid - Asymmetric Luxury Layout -->
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            
            <!-- Left Column - Signature Dish with Cinematic Presentation -->
            <div class="relative order-2 lg:order-1">
                <!-- Floating decoration - gold leaf effect -->
                <div class="absolute -top-8 -left-8 w-32 h-32 border border-[#d4b48c]/30 rounded-full"></div>
                <div class="absolute -bottom-6 -right-6 w-40 h-40 border border-[#d4b48c]/20 rounded-full"></div>
                
                <!-- Main Image Container with Unique Frame -->
                <div class="relative group">
                    <!-- Image Frame with Skeuomorphic Shadow -->
                    <div class="relative z-10 rounded-3xl overflow-hidden shadow-[0_30px_40px_-20px_rgba(60,40,20,0.4)]">
                        <!-- Signature Dish Image with Parallax Effect -->
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" 
                             alt="Signature Nyama Choma with Kachumbari" 
                             class="w-full h-[500px] md:h-[600px] object-cover transition-transform duration-7000 ease-out group-hover:scale-105"
                             style="transition-duration: 7000ms;">
                        
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Floating Label - Signature Dish Name -->
                        <div class="absolute bottom-8 left-8 right-8">
                            <div class="inline-block bg-white/10 backdrop-blur-md px-6 py-3 rounded-full border border-white/20">
                                <span class="text-white font-['Cormorant_Garamond'] text-xl tracking-wide">Nyama Choma</span>
                                <span class="text-[#d4b48c] mx-3">•</span>
                                <span class="text-white/80 text-sm font-light">with Kachumbari</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative Plate Shadow Effect -->
                    <div class="absolute -bottom-4 left-10 right-10 h-8 bg-black/20 blur-xl rounded-full"></div>
                    
                    <!-- Animated Accent - Floating Particles -->
                    <div class="absolute -top-4 -right-4 w-20 h-20">
                        <div class="absolute w-2 h-2 bg-[#d4b48c] rounded-full animate-ping" style="animation-duration: 3s;"></div>
                        <div class="absolute top-8 left-8 w-1.5 h-1.5 bg-[#d4b48c]/60 rounded-full animate-ping" style="animation-duration: 4s; animation-delay: 1s;"></div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Chef's Story & Philosophy -->
            <div class="relative order-1 lg:order-2 space-y-8">
                <!-- Chef's Credentials - Elegant Badge -->
                <div class="inline-flex items-center gap-4 bg-white/50 backdrop-blur-sm px-5 py-2 rounded-full border border-[#e0d6cc]">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-[#8a735b] flex items-center justify-center">
                        <img src="https://images.unsplash.com/photo-1583394293214-28ded15ee548?ixlib=rb-4.0.3&auto=format&fit=crop&w=2080&q=80" 
                             alt="Chef" 
                             class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="text-[#8a735b] text-xs uppercase tracking-wider font-medium">Executive Chef</span>
                        <h3 class="font-['Cormorant_Garamond'] text-xl text-[#3f352e]">Chef Michael Mikes</h3>
                    </div>
                </div>

                <!-- Main Headline -->
                <div>
                    <h2 class="font-['Cormorant_Garamond'] text-3xl md:text-4xl lg:text-5xl text-[#3f352e] leading-tight">
                        Where <span class="italic text-[#8a735b]">Swahili spices</span><br>
                        meet <span class="italic text-[#8a735b]">modern artistry</span>
                    </h2>
                </div>

                <!-- Cuisine Philosophy - Evocative Description -->
                <div class="space-y-4">
                    <p class="font-['Cormorant_Garamond'] text-lg text-[#6b5d51] leading-relaxed italic">
                        "Cooking is memory, tradition, and innovation on a single plate."
                    </p>
                    <p class="text-[#6b5d51] text-sm leading-relaxed">
                        Chef Michael brings 20 years of culinary mastery, weaving together Kenya's rich coastal heritage 
                        with contemporary techniques. His philosophy celebrates <span class="text-[#8a735b] font-medium">farm-to-table freshness</span>, 
                        <span class="text-[#8a735b] font-medium">indigenous ingredients</span>, and the vibrant stories of 
                        Kenyan cuisine.
                    </p>
                </div>

                <!-- Signature Philosophy Points - Minimal Icons -->
                <div class="grid grid-cols-2 gap-4 py-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-leaf text-[#d4b48c] text-sm mt-1"></i>
                        <div>
                            <p class="font-['Cormorant_Garamond'] text-sm text-[#3f352e] font-semibold">Farm to Table</p>
                            <p class="text-[10px] text-[#6b5d51] uppercase tracking-wider">Local sourcing</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-fire text-[#d4b48c] text-sm mt-1"></i>
                        <div>
                            <p class="font-['Cormorant_Garamond'] text-sm text-[#3f352e] font-semibold">Open Flame</p>
                            <p class="text-[10px] text-[#6b5d51] uppercase tracking-wider">Traditional techniques</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-seedling text-[#d4b48c] text-sm mt-1"></i>
                        <div>
                            <p class="font-['Cormorant_Garamond'] text-sm text-[#3f352e] font-semibold">Seasonal</p>
                            <p class="text-[10px] text-[#6b5d51] uppercase tracking-wider">Changing menus</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-wine-glass-alt text-[#d4b48c] text-sm mt-1"></i>
                        <div>
                            <p class="font-['Cormorant_Garamond'] text-sm text-[#3f352e] font-semibold">Pairings</p>
                            <p class="text-[10px] text-[#6b5d51] uppercase tracking-wider">African wines</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons - Unique Design -->
                <div class="flex flex-wrap items-center gap-5 pt-6">
                    <!-- Primary Button - View Menu & Reserve -->
                    <a href="restaurant.php" class="group relative inline-flex items-center gap-4 px-8 py-4 bg-[#3f352e] rounded-full overflow-hidden shadow-[0_10px_20px_-8px_rgba(40,30,20,0.3)] hover:shadow-[0_15px_25px_-8px_rgba(40,30,20,0.4)] transition-shadow duration-300">
                        <!-- Background Hover Effect -->
                        <span class="absolute inset-0 bg-gradient-to-r from-[#8a735b] to-[#6b5d51] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                        
                        <!-- Text and Icons -->
                        <span class="relative text-white font-['Montserrat'] text-xs uppercase tracking-[0.25em]">View Menu & Reserve</span>
                        <i class="relative fas fa-arrow-right text-white text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                        
                        <!-- Decorative Line -->
                        <span class="absolute bottom-2 left-8 right-8 h-px bg-white/30 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></span>
                    </a>

                    <!-- Secondary Button - Explore Menu PDF -->
                    <a href="offers.php" class="group inline-flex items-center gap-2 text-[#8a735b] hover:text-[#3f352e] transition-colors duration-300">
                        <i class="fas fa-file-pdf text-sm"></i>
                        <span class="font-['Montserrat'] text-xs uppercase tracking-wider">Sample Menu</span>
                        <i class="fas fa-download text-xs group-hover:translate-y-0.5 transition-transform duration-300"></i>
                    </a>
                </div>

                <!-- Opening Hours - Subtle Display -->
                <div class="flex items-center gap-4 pt-6 border-t border-[#e0d6cc]">
                    <i class="far fa-clock text-[#d4b48c] text-sm"></i>
                    <div class="flex flex-wrap gap-4 text-xs">
                        <span class="text-[#6b5d51]">Lunch <span class="text-[#3f352e] font-medium">12:00 - 15:00</span></span>
                        <span class="text-[#6b5d51]">Dinner <span class="text-[#3f352e] font-medium">18:30 - 23:00</span></span>
                        <span class="text-[#d4b48c]">•</span>
                        <span class="text-[#6b5d51]">Last orders 22:30</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Decorative Element - Wave -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#d4b48c]/30 to-transparent"></div>
    </div>

    <!-- Unique Animations for this Section -->
    <style>
        /* Restaurant teaser specific animations */
        .group:hover .duration-7000 {
            transition-duration: 7000ms;
        }
        
        @keyframes floatGold {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-10px) rotate(5deg); opacity: 0.6; }
        }
        
        .animate-float-slow {
            animation: floatGold 8s ease-in-out infinite;
        }
        
        /* Smooth image zoom on hover */
        .group:hover img {
            transform: scale(1.05);
        }
        
        /* Pulsing dots animation */
        .animate-ping {
            animation: ping 3s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        @keyframes ping {
            75%, 100% {
                transform: scale(2);
                opacity: 0;
            }
        }
        
        /* Custom scroll for modal if needed */
        .restaurant-scroll::-webkit-scrollbar {
            width: 4px;
        }
        
        .restaurant-scroll::-webkit-scrollbar-track {
            background: rgba(139, 115, 85, 0.1);
        }
        
        .restaurant-scroll::-webkit-scrollbar-thumb {
            background: #d4b48c;
            border-radius: 4px;
        }
        
        /* Responsive text adjustments */
        @media (max-width: 768px) {
            .group:hover img {
                transform: scale(1.03);
            }
        }
    </style>
</section>



<!-- Amenities at a Glance Section - Luxurious Icon Grid with Rich Background -->
<section class="relative py-28 px-6 bg-[#1e2b32] overflow-hidden">
    <!-- Decorative Background Elements - Deep Oceanic Feel -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Gradient Orbs for Depth -->
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-[#2c4a5c]/30 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-[#3d5a6c]/20 rounded-full blur-[120px]"></div>
        
        <!-- Wave Pattern Overlay -->
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <pattern id="wavePattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                    <path d="M0 50 Q 25 30, 50 50 T 100 50" stroke="#a5c9e0" fill="none" stroke-width="0.5"/>
                </pattern>
                <rect width="100%" height="100%" fill="url(#wavePattern)"/>
            </svg>
        </div>
        
        <!-- Subtle Light Streaks -->
        <div class="absolute top-1/4 left-1/4 w-40 h-40 bg-[#d4b48c]/5 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-1/3 right-1/3 w-60 h-60 bg-[#5f8a9f]/10 rounded-full blur-3xl animate-pulse-slower"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Section Header - Elegant Light Text -->
        <div class="text-center mb-16">
            <span class="text-[#d4b48c] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Experiences Await</span>
            <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-white mt-4 mb-6 font-light">World-Class Amenities</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
            <p class="text-[#a5b9c4] text-sm max-w-2xl mx-auto mt-6 font-light tracking-wide">
                Indulge in unparalleled luxury with our curated collection of amenities designed for your well-being and pleasure.
            </p>
        </div>

        <!-- Icon Grid - 3x2 Layout with Animation -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            
            <!-- Amenity Card 1 - Spa -->
            <div class="amenity-card group relative bg-white/5 backdrop-blur-sm rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 hover:scale-105 hover:-translate-y-2 hover:shadow-[0_30px_40px_-15px_rgba(0,0,0,0.4)]">
                <!-- Card Glow Effect on Hover -->
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-[#d4b48c]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                
                <!-- Icon Container with Animated Background -->
                <div class="relative mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#d4b48c]/20 to-[#5f8a9f]/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#8a735b] flex items-center justify-center shadow-[0_10px_20px_-5px_rgba(212,180,140,0.3)]">
                            <i class="fas fa-spa text-2xl text-white"></i>
                        </div>
                    </div>
                    
                    <!-- Animated Ring -->
                    <div class="absolute inset-0 rounded-full border-2 border-[#d4b48c]/0 group-hover:border-[#d4b48c]/30 group-hover:scale-150 transition-all duration-700 opacity-0 group-hover:opacity-100"></div>
                </div>
                
                <!-- Content -->
                <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2 group-hover:text-[#d4b48c] transition-colors duration-300">Spa Sanctuary</h3>
                <p class="text-[#a5b9c4] text-sm leading-relaxed mb-4">Traditional Kenyan treatments with modern wellness techniques</p>
                
                <!-- Decorative Line -->
                <div class="w-12 h-px bg-gradient-to-r from-[#d4b48c] to-transparent group-hover:w-20 transition-all duration-500"></div>
                
                <!-- Floating Particles (Spa specific) -->
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <i class="fas fa-leaf text-[#d4b48c]/30 text-xs animate-float"></i>
                </div>
            </div>

            <!-- Amenity Card 2 - Infinity Pool -->
            <div class="amenity-card group relative bg-white/5 backdrop-blur-sm rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 hover:scale-105 hover:-translate-y-2 hover:shadow-[0_30px_40px_-15px_rgba(0,0,0,0.4)]">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-[#d4b48c]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                
                <div class="relative mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#d4b48c]/20 to-[#5f8a9f]/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#4a90a0] to-[#2c5f73] flex items-center justify-center shadow-[0_10px_20px_-5px_rgba(74,144,160,0.3)]">
                            <i class="fas fa-water text-2xl text-white"></i>
                        </div>
                    </div>
                    <div class="absolute inset-0 rounded-full border-2 border-[#4a90a0]/0 group-hover:border-[#4a90a0]/30 group-hover:scale-150 transition-all duration-700 opacity-0 group-hover:opacity-100"></div>
                </div>
                
                <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2 group-hover:text-[#4a90a0] transition-colors duration-300">Infinity Pool</h3>
                <p class="text-[#a5b9c4] text-sm leading-relaxed mb-4">Skyline views overlooking Nairobi's lush landscape</p>
                <div class="w-12 h-px bg-gradient-to-r from-[#4a90a0] to-transparent group-hover:w-20 transition-all duration-500"></div>
                
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <i class="fas fa-water text-[#4a90a0]/30 text-xs animate-float-delay"></i>
                </div>
            </div>

            <!-- Amenity Card 3 - Fitness Pavilion -->
            <div class="amenity-card group relative bg-white/5 backdrop-blur-sm rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 hover:scale-105 hover:-translate-y-2 hover:shadow-[0_30px_40px_-15px_rgba(0,0,0,0.4)]">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-[#d4b48c]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                
                <div class="relative mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#d4b48c]/20 to-[#5f8a9f]/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#b87333] to-[#8b5a2b] flex items-center justify-center shadow-[0_10px_20px_-5px_rgba(184,115,51,0.3)]">
                            <i class="fas fa-dumbbell text-2xl text-white"></i>
                        </div>
                    </div>
                    <div class="absolute inset-0 rounded-full border-2 border-[#b87333]/0 group-hover:border-[#b87333]/30 group-hover:scale-150 transition-all duration-700 opacity-0 group-hover:opacity-100"></div>
                </div>
                
                <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2 group-hover:text-[#b87333] transition-colors duration-300">Fitness Pavilion</h3>
                <p class="text-[#a5b9c4] text-sm leading-relaxed mb-4">State-of-the-art equipment with personal trainers</p>
                <div class="w-12 h-px bg-gradient-to-r from-[#b87333] to-transparent group-hover:w-20 transition-all duration-500"></div>
                
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <i class="fas fa-heartbeat text-[#b87333]/30 text-xs animate-float"></i>
                </div>
            </div>

            <!-- Amenity Card 4 - Private Beach Access -->
            <div class="amenity-card group relative bg-white/5 backdrop-blur-sm rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 hover:scale-105 hover:-translate-y-2 hover:shadow-[0_30px_40px_-15px_rgba(0,0,0,0.4)]">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-[#d4b48c]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                
                <div class="relative mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#d4b48c]/20 to-[#5f8a9f]/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#e6b87e] to-[#c9a87c] flex items-center justify-center shadow-[0_10px_20px_-5px_rgba(230,184,126,0.3)]">
                            <i class="fas fa-umbrella-beach text-2xl text-white"></i>
                        </div>
                    </div>
                    <div class="absolute inset-0 rounded-full border-2 border-[#e6b87e]/0 group-hover:border-[#e6b87e]/30 group-hover:scale-150 transition-all duration-700 opacity-0 group-hover:opacity-100"></div>
                </div>
                
                <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2 group-hover:text-[#e6b87e] transition-colors duration-300">Private Beach Access</h3>
                <p class="text-[#a5b9c4] text-sm leading-relaxed mb-4">Exclusive shuttle to our private lakefront beach</p>
                <div class="w-12 h-px bg-gradient-to-r from-[#e6b87e] to-transparent group-hover:w-20 transition-all duration-500"></div>
                
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <i class="fas fa-sun text-[#e6b87e]/30 text-xs animate-float-delay"></i>
                </div>
            </div>

            <!-- Amenity Card 5 - Business Lounge -->
            <div class="amenity-card group relative bg-white/5 backdrop-blur-sm rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 hover:scale-105 hover:-translate-y-2 hover:shadow-[0_30px_40px_-15px_rgba(0,0,0,0.4)]">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-[#d4b48c]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                
                <div class="relative mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#d4b48c]/20 to-[#5f8a9f]/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#5f6b7a] to-[#3a4452] flex items-center justify-center shadow-[0_10px_20px_-5px_rgba(95,107,122,0.3)]">
                            <i class="fas fa-briefcase text-2xl text-white"></i>
                        </div>
                    </div>
                    <div class="absolute inset-0 rounded-full border-2 border-[#5f6b7a]/0 group-hover:border-[#5f6b7a]/30 group-hover:scale-150 transition-all duration-700 opacity-0 group-hover:opacity-100"></div>
                </div>
                
                <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2 group-hover:text-[#a5b9c4] transition-colors duration-300">Business Lounge</h3>
                <p class="text-[#a5b9c4] text-sm leading-relaxed mb-4">Executive workspace with conference facilities</p>
                <div class="w-12 h-px bg-gradient-to-r from-[#5f6b7a] to-transparent group-hover:w-20 transition-all duration-500"></div>
                
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <i class="fas fa-chart-line text-[#5f6b7a]/30 text-xs animate-float"></i>
                </div>
            </div>

            <!-- Amenity Card 6 - Kids' Club -->
            <div class="amenity-card group relative bg-white/5 backdrop-blur-sm rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 hover:scale-105 hover:-translate-y-2 hover:shadow-[0_30px_40px_-15px_rgba(0,0,0,0.4)]">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-[#d4b48c]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                
                <div class="relative mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#d4b48c]/20 to-[#5f8a9f]/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#e9b56b] to-[#c99a5c] flex items-center justify-center shadow-[0_10px_20px_-5px_rgba(233,181,107,0.3)]">
                            <i class="fas fa-child text-2xl text-white"></i>
                        </div>
                    </div>
                    <div class="absolute inset-0 rounded-full border-2 border-[#e9b56b]/0 group-hover:border-[#e9b56b]/30 group-hover:scale-150 transition-all duration-700 opacity-0 group-hover:opacity-100"></div>
                </div>
                
                <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2 group-hover:text-[#e9b56b] transition-colors duration-300">Kids' Club</h3>
                <p class="text-[#a5b9c4] text-sm leading-relaxed mb-4">Supervised activities with Kenyan cultural experiences</p>
                <div class="w-12 h-px bg-gradient-to-r from-[#e9b56b] to-transparent group-hover:w-20 transition-all duration-500"></div>
                
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <i class="fas fa-puzzle-piece text-[#e9b56b]/30 text-xs animate-float-delay"></i>
                </div>
            </div>
        </div>

        <!-- Bottom Call to Action -->
        <div class="text-center mt-16">
            <a href="amenities.php" class="group inline-flex items-center gap-3 px-8 py-3 bg-transparent border border-white/20 rounded-full text-white hover:bg-white/10 transition-all duration-300">
                <span class="text-xs uppercase tracking-wider">Explore All Amenities</span>
                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                <span class="absolute inset-0 rounded-full bg-gradient-to-r from-[#d4b48c]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
            </a>
        </div>
    </div>

    <!-- Unique Animations for this Section -->
    <style>
        /* Amenities section specific animations */
        
        /* Slow pulse for background orbs */
        @keyframes pulseSlow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.1); }
        }
        
        .animate-pulse-slow {
            animation: pulseSlow 8s ease-in-out infinite;
        }
        
        .animate-pulse-slower {
            animation: pulseSlow 12s ease-in-out infinite reverse;
        }
        
        /* Floating animation for corner icons */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-5px) rotate(5deg); }
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        
        .animate-float-delay {
            animation: float 5s ease-in-out infinite 1s;
        }
        
        /* Card entrance animation on scroll */
        .amenity-card {
            opacity: 0;
            animation: cardFadeIn 0.8s ease-out forwards;
        }
        
        .amenity-card:nth-child(1) { animation-delay: 0.1s; }
        .amenity-card:nth-child(2) { animation-delay: 0.2s; }
        .amenity-card:nth-child(3) { animation-delay: 0.3s; }
        .amenity-card:nth-child(4) { animation-delay: 0.4s; }
        .amenity-card:nth-child(5) { animation-delay: 0.5s; }
        .amenity-card:nth-child(6) { animation-delay: 0.6s; }
        
        @keyframes cardFadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Ripple effect on hover */
        .amenity-card:hover .absolute.inset-0.rounded-full {
            animation: ripple 1s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }
        
        /* Smooth transitions for all interactive elements */
        .amenity-card * {
            transition: all 0.3s ease;
        }
        
        /* Custom scrollbar for any modal */
        .amenity-scroll::-webkit-scrollbar {
            width: 4px;
        }
        
        .amenity-scroll::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        
        .amenity-scroll::-webkit-scrollbar-thumb {
            background: #d4b48c;
            border-radius: 4px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .amenity-card:hover {
                transform: scale(1.02) translateY(-5px);
            }
            
            .amenity-card {
                padding: 1.5rem;
            }
            
            .amenity-card .w-20.h-20 {
                width: 60px;
                height: 60px;
            }
            
            .amenity-card .w-16.h-16 {
                width: 48px;
                height: 48px;
            }
            
            .amenity-card i {
                font-size: 1.25rem;
            }
        }
    </style>
</section>








<!-- Signature Offers Section - Immersive Storytelling Layout -->
<section class="relative py-28 px-6 overflow-hidden">
    <!-- Background Image with Artistic Treatment -->
    <div class="absolute inset-0 z-0">
        <!-- Main Background Image -->
        <img src="https://thumbs.dreamstime.com/b/african-landscape-poster-acacia-tree-giraffe-sunset-background-vector-illustration-51842210.jpg" 
             alt="African Sunset Landscape" 
             class="w-full h-full object-cover">
        
        <!-- Light Gradient Shading - Only on Edges, Not Covering Center -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a]/90 via-transparent to-[#1a1a1a]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#1a1a1a]/60 via-transparent to-[#1a1a1a]/60"></div>
        
        <!-- Warm Color Overlay - Very Subtle -->
        <div class="absolute inset-0 bg-[#b89a78]/20 mix-blend-overlay"></div>
        
        <!-- Textured Noise Overlay -->
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noise\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.65\' numOctaves=\'3\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noise)\' opacity=\'0.4\'/%3E%3C/svg%3E'); background-repeat: repeat;"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Section Header - Light Text on Dark Background -->
        <div class="text-center mb-16">
            <span class="text-[#d4b48c] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light drop-shadow-lg">Exclusive Experiences</span>
            <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-white mt-4 mb-6 font-light drop-shadow-lg">Signature Offers</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
            <p class="text-white/80 text-sm max-w-2xl mx-auto mt-6 font-light tracking-wide drop-shadow">
                Curated escapes designed to create unforgettable memories in the heart of Kenya.
            </p>
        </div>

        <!-- Offers Container - NO CARDS, Unique Layered Design -->
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-0 lg:divide-x lg:divide-white/20">
            
            <!-- Offer 1 - The Honeymoon Escape -->
            <div class="offer-item relative flex-1 px-0 lg:px-8 py-8 lg:py-0 group/offer">
                <div class="relative flex flex-col items-center lg:items-start text-center lg:text-left">
                    
                    <!-- Decorative Element - Floating Ring -->
                    <div class="absolute -top-10 -left-10 w-40 h-40 border border-[#d4b48c]/20 rounded-full group-hover/offer:scale-150 transition-transform duration-1000 opacity-0 group-hover/offer:opacity-100"></div>
                    
                    <!-- Offer Icon/Symbol - Unique Shape (Not a Card) -->
                    <div class="relative mb-6">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#d4b48c]/30 to-[#8a735b]/30 backdrop-blur-sm flex items-center justify-center border border-white/20 group-hover/offer:scale-110 transition-transform duration-500">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center shadow-[0_20px_30px_-10px_rgba(0,0,0,0.3)]">
                                <i class="fas fa-heart text-3xl text-white"></i>
                            </div>
                        </div>
                        
                        <!-- Animated Rings -->
                        <div class="absolute inset-0 rounded-full border-2 border-[#d4b48c] opacity-0 group-hover/offer:opacity-100 animate-ping-slow"></div>
                        <div class="absolute -inset-4 rounded-full border border-[#d4b48c]/40 opacity-0 group-hover/offer:opacity-50 animate-pulse-slower"></div>
                    </div>
                    
                    <!-- Offer Image - Integrated into design, not as card -->
                    <div class="relative w-full h-48 md:h-56 mb-6 overflow-hidden rounded-2xl shadow-[0_20px_30px_-10px_rgba(0,0,0,0.5)]">
                        <img src="https://media-cdn.tripadvisor.com/media/attractions-splice-spp-674x446/17/0a/08/34.jpg" 
                             alt="Honeymoon Escape" 
                             class="w-full h-full object-cover transition-transform duration-7000 group-hover/offer:scale-110">
                        
                        <!-- Gradient Overlay on Image Only -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <!-- Floating Price Tag -->
                        <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
                            <span class="text-white font-['DM_Serif_Display'] text-lg">KSh 85K</span>
                            <span class="text-white/60 text-xs ml-1">/couple</span>
                        </div>
                    </div>
                    
                    <!-- Offer Content - No Card Background -->
                    <div class="relative">
                        <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-3 drop-shadow-lg">
                            The Honeymoon Escape
                        </h3>
                        
                        <!-- Decorative Underline -->
                        <div class="w-16 h-0.5 bg-gradient-to-r from-[#d4b48c] to-transparent mx-auto lg:mx-0 mb-4 group-hover/offer:w-24 transition-all duration-500"></div>
                        
                        <p class="text-white/80 text-sm leading-relaxed mb-6 max-w-xs mx-auto lg:mx-0">
                            Celebrate your love with a romantic 4-day getaway including candlelit dinners, couples' spa treatments, and sunset safari.
                        </p>
                        
                        <!-- Inclusions List - Unique Styling -->
                        <div class="space-y-2 mb-8">
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#d4b48c] text-xs"></i>
                                <span class="text-xs">Private villa with plunge pool</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#d4b48c] text-xs"></i>
                                <span class="text-xs">Sunset champagne safari</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#d4b48c] text-xs"></i>
                                <span class="text-xs">Couples massage & rose petal turndown</span>
                            </div>
                        </div>
                        
                        <!-- Claim Offer Button - Unique Design -->
                        <button class="group/btn relative inline-flex items-center gap-4 px-8 py-3 bg-transparent border border-white/30 text-white rounded-full overflow-hidden hover:border-[#d4b48c] transition-colors duration-300">
                            <!-- Background Slide Animation -->
                            <span class="absolute inset-0 bg-gradient-to-r from-[#d4b48c] to-[#b89a78] translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                            
                            <!-- Button Content -->
                            <span class="relative z-10 text-sm uppercase tracking-wider flex items-center gap-2">
                                Claim Offer
                                <i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                            </span>
                            
                            <!-- Corner Accents -->
                            <span class="absolute top-0 left-0 w-2 h-2 border-t border-l border-[#d4b48c] opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                            <span class="absolute bottom-0 right-0 w-2 h-2 border-b border-r border-[#d4b48c] opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Offer 2 - Weekend Wilderness Getaway -->
            <div class="offer-item relative flex-1 px-0 lg:px-8 py-8 lg:py-0 group/offer">
                <div class="relative flex flex-col items-center lg:items-start text-center lg:text-left">
                    
                    <!-- Decorative Element - Floating Ring -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 border border-[#d4b48c]/20 rounded-full group-hover/offer:scale-150 transition-transform duration-1000 opacity-0 group-hover/offer:opacity-100"></div>
                    
                    <div class="relative mb-6">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#4a90a0]/30 to-[#2c5f73]/30 backdrop-blur-sm flex items-center justify-center border border-white/20 group-hover/offer:scale-110 transition-transform duration-500">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#4a90a0] to-[#2c5f73] flex items-center justify-center shadow-[0_20px_30px_-10px_rgba(0,0,0,0.3)]">
                                <i class="fas fa-tree text-3xl text-white"></i>
                            </div>
                        </div>
                        <div class="absolute inset-0 rounded-full border-2 border-[#4a90a0] opacity-0 group-hover/offer:opacity-100 animate-ping-slow"></div>
                        <div class="absolute -inset-4 rounded-full border border-[#4a90a0]/40 opacity-0 group-hover/offer:opacity-50 animate-pulse-slower"></div>
                    </div>
                    
                    <div class="relative w-full h-48 md:h-56 mb-6 overflow-hidden rounded-2xl shadow-[0_20px_30px_-10px_rgba(0,0,0,0.5)]">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Wilderness Getaway" 
                             class="w-full h-full object-cover transition-transform duration-7000 group-hover/offer:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
                            <span class="text-white font-['DM_Serif_Display'] text-lg">KSh 65K</span>
                            <span class="text-white/60 text-xs ml-1">/person</span>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-3 drop-shadow-lg">
                            Weekend Wilderness
                        </h3>
                        
                        <div class="w-16 h-0.5 bg-gradient-to-r from-[#4a90a0] to-transparent mx-auto lg:mx-0 mb-4 group-hover/offer:w-24 transition-all duration-500"></div>
                        
                        <p class="text-white/80 text-sm leading-relaxed mb-6 max-w-xs mx-auto lg:mx-0">
                            Immerse yourself in the wild with guided game drives, bush dinners, and stargazing under the African sky.
                        </p>
                        
                        <div class="space-y-2 mb-8">
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#4a90a0] text-xs"></i>
                                <span class="text-xs">2 nights in luxury tented camp</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#4a90a0] text-xs"></i>
                                <span class="text-xs">Morning & evening game drives</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#4a90a0] text-xs"></i>
                                <span class="text-xs">Bush breakfast & Maasai guide</span>
                            </div>
                        </div>
                        
                        <button class="group/btn relative inline-flex items-center gap-4 px-8 py-3 bg-transparent border border-white/30 text-white rounded-full overflow-hidden hover:border-[#4a90a0] transition-colors duration-300">
                            <span class="absolute inset-0 bg-gradient-to-r from-[#4a90a0] to-[#2c5f73] translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                            <span class="relative z-10 text-sm uppercase tracking-wider flex items-center gap-2">
                                Claim Offer
                                <i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                            </span>
                            <span class="absolute top-0 left-0 w-2 h-2 border-t border-l border-[#4a90a0] opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                            <span class="absolute bottom-0 right-0 w-2 h-2 border-b border-r border-[#4a90a0] opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Offer 3 - Family Safari Adventure -->
            <div class="offer-item relative flex-1 px-0 lg:px-8 py-8 lg:py-0 group/offer">
                <div class="relative flex flex-col items-center lg:items-start text-center lg:text-left">
                    
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 border border-[#e9b56b]/20 rounded-full group-hover/offer:scale-150 transition-transform duration-1000 opacity-0 group-hover/offer:opacity-100"></div>
                    
                    <div class="relative mb-6">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#e9b56b]/30 to-[#c99a5c]/30 backdrop-blur-sm flex items-center justify-center border border-white/20 group-hover/offer:scale-110 transition-transform duration-500">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#e9b56b] to-[#c99a5c] flex items-center justify-center shadow-[0_20px_30px_-10px_rgba(0,0,0,0.3)]">
                                <i class="fas fa-paw text-3xl text-white"></i>
                            </div>
                        </div>
                        <div class="absolute inset-0 rounded-full border-2 border-[#e9b56b] opacity-0 group-hover/offer:opacity-100 animate-ping-slow"></div>
                        <div class="absolute -inset-4 rounded-full border border-[#e9b56b]/40 opacity-0 group-hover/offer:opacity-50 animate-pulse-slower"></div>
                    </div>
                    
                    <div class="relative w-full h-48 md:h-56 mb-6 overflow-hidden rounded-2xl shadow-[0_20px_30px_-10px_rgba(0,0,0,0.5)]">
                        <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                             alt="Family Safari" 
                             class="w-full h-full object-cover transition-transform duration-7000 group-hover/offer:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
                            <span class="text-white font-['DM_Serif_Display'] text-lg">KSh 120K</span>
                            <span class="text-white/60 text-xs ml-1">/family</span>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-3 drop-shadow-lg">
                            Family Safari Adventure
                        </h3>
                        
                        <div class="w-16 h-0.5 bg-gradient-to-r from-[#e9b56b] to-transparent mx-auto lg:mx-0 mb-4 group-hover/offer:w-24 transition-all duration-500"></div>
                        
                        <p class="text-white/80 text-sm leading-relaxed mb-6 max-w-xs mx-auto lg:mx-0">
                            Create lasting memories with kid-friendly game drives, cultural visits, and interactive wildlife experiences.
                        </p>
                        
                        <div class="space-y-2 mb-8">
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#e9b56b] text-xs"></i>
                                <span class="text-xs">Family suite & kids' activities</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#e9b56b] text-xs"></i>
                                <span class="text-xs">Junior ranger program</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70">
                                <i class="fas fa-check-circle text-[#e9b56b] text-xs"></i>
                                <span class="text-xs">Family game drive & picnic</span>
                            </div>
                        </div>
                        
                        <button class="group/btn relative inline-flex items-center gap-4 px-8 py-3 bg-transparent border border-white/30 text-white rounded-full overflow-hidden hover:border-[#e9b56b] transition-colors duration-300">
                            <span class="absolute inset-0 bg-gradient-to-r from-[#e9b56b] to-[#c99a5c] translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                            <span class="relative z-10 text-sm uppercase tracking-wider flex items-center gap-2">
                                Claim Offer
                                <i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                            </span>
                            <span class="absolute top-0 left-0 w-2 h-2 border-t border-l border-[#e9b56b] opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                            <span class="absolute bottom-0 right-0 w-2 h-2 border-b border-r border-[#e9b56b] opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Decorative Element -->
        <div class="relative mt-20 text-center">
            <div class="inline-flex items-center gap-4 text-white/40 text-xs">
                <i class="fas fa-star"></i>
                <span>All offers include complimentary airport transfers</span>
                <i class="fas fa-star"></i>
            </div>
        </div>

        <!-- View All Offers Link -->
        <div class="relative mt-12 text-center">
            <a href="offers.php" class="group inline-flex items-center gap-3 px-8 py-3 bg-transparent border border-white/30 rounded-full text-white hover:bg-white/10 transition-all duration-300">
                <span class="text-xs uppercase tracking-wider">View All Offers</span>
                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>

    <!-- Unique Animations for this Section -->
    <style>
        /* Signature Offers specific animations */
        
        @keyframes pingSlow {
            0% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.5); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }
        
        .animate-ping-slow {
            animation: pingSlow 3s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        .animate-pulse-slower {
            animation: pulseSlower 4s ease-in-out infinite;
        }
        
        @keyframes pulseSlower {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.6; }
        }
        
        /* Smooth image zoom */
        .group\/offer:hover img {
            transform: scale(1.1);
            transition: transform 7s ease;
        }
        
        /* Offer item entrance animation */
        .offer-item {
            opacity: 0;
            animation: offerFadeIn 0.8s ease-out forwards;
        }
        
        .offer-item:nth-child(1) { animation-delay: 0.2s; }
        .offer-item:nth-child(2) { animation-delay: 0.4s; }
        .offer-item:nth-child(3) { animation-delay: 0.6s; }
        
        @keyframes offerFadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Button slide animation */
        .group\/btn:hover span.absolute.inset-0 {
            transform: translateY(0);
        }
        
        /* Responsive adjustments */
        @media (max-width: 1023px) {
            .lg\:divide-x {
                border-right: none;
            }
            
            .offer-item {
                border-bottom: 1px solid rgba(255,255,255,0.1);
                padding-bottom: 2rem;
                margin-bottom: 1rem;
            }
            
            .offer-item:last-child {
                border-bottom: none;
            }
        }
        
        @media (max-width: 768px) {
            .offer-item .w-24.h-24 {
                width: 80px;
                height: 80px;
            }
            
            .offer-item .w-20.h-20 {
                width: 64px;
                height: 64px;
            }
            
            .offer-item i {
                font-size: 1.75rem;
            }
            
            .offer-item .text-3xl {
                font-size: 2rem;
            }
        }
    </style>
</section>




<!-- Gallery Previews Section - Living Art Collection -->
<section class="relative py-28 px-6 bg-[#f5efe8] overflow-hidden">
    <!-- Decorative Background Elements - Subtle and Artistic -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Floating Geometric Shapes -->
        <div class="absolute top-20 left-[5%] w-64 h-64 border border-[#d4b48c]/20 rounded-full animate-rotate-slow"></div>
        <div class="absolute bottom-40 right-[8%] w-80 h-80 border border-[#8a735b]/10 rounded-full animate-rotate-reverse"></div>
        
        <!-- Scattered Dots Pattern -->
        <div class="absolute inset-0 opacity-[0.15]" style="background-image: radial-gradient(#b89a78 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <!-- Gentle Light Streaks -->
        <div class="absolute top-1/3 left-1/4 w-96 h-96 bg-gradient-to-br from-[#d4b48c]/10 via-transparent to-transparent blur-3xl animate-drift"></div>
        <div class="absolute bottom-1/3 right-1/4 w-96 h-96 bg-gradient-to-tl from-[#b89a78]/10 via-transparent to-transparent blur-3xl animate-drift-slow"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Section Header - Minimal and Elegant -->
        <div class="text-center mb-16">
            <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Visual Stories</span>
            <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#3f352e] mt-4 mb-6 font-light">Moments Captured</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
            <p class="text-[#6b5d51] text-sm max-w-2xl mx-auto mt-6 font-light tracking-wide">
                A glimpse into the world of Aora45—where every corner tells a story, and every moment is a masterpiece.
            </p>
        </div>

        <!-- Gallery Previews - NO CARDS, NO CONTAINERS - Organic Floating Grid -->
        <div class="relative">
            <!-- Main Gallery Grid - Organic Asymmetrical Layout -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 auto-rows-[minmax(180px,auto)]">
                
                <!-- Image 1 - Landscape (spans 2 columns on desktop) -->
                <div class="gallery-item relative col-span-2 row-span-1 md:col-span-2 md:row-span-2 overflow-hidden rounded-3xl shadow-[0_15px_30px_-10px_rgba(0,0,0,0.2)] group/image">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                         alt="Infinity Pool at Sunset" 
                         class="w-full h-full object-cover transition-all duration-700 group-hover/image:scale-110">
                    
                    <!-- Artistic Overlay - Not a card, just a subtle gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#3f352e]/60 via-transparent to-transparent opacity-0 group-hover/image:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Floating Caption - Appears on Hover -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-full group-hover/image:translate-y-0 transition-transform duration-500">
                        <span class="text-white font-['Cormorant_Garamond'] text-xl drop-shadow-lg block">Infinity Edge</span>
                        <span class="text-white/80 text-xs tracking-wider">Sunset over the pool</span>
                    </div>
                    
                    <!-- Decorative Corner Accent -->
                    <div class="absolute top-4 right-4 w-12 h-12 border-t-2 border-r-2 border-white/0 group-hover/image:border-white/60 transition-all duration-500 delay-150"></div>
                    <div class="absolute bottom-4 left-4 w-12 h-12 border-b-2 border-l-2 border-white/0 group-hover/image:border-white/60 transition-all duration-500 delay-150"></div>
                </div>

                <!-- Image 2 - Portrait -->
                <div class="gallery-item relative col-span-1 row-span-1 md:col-span-1 md:row-span-1 overflow-hidden rounded-2xl shadow-[0_10px_20px_-5px_rgba(0,0,0,0.15)] group/image">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                         alt="Private Beach" 
                         class="w-full h-full object-cover transition-all duration-700 group-hover/image:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#3f352e]/60 via-transparent to-transparent opacity-0 group-hover/image:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover/image:translate-y-0 transition-transform duration-500">
                        <span class="text-white font-['Cormorant_Garamond'] text-base drop-shadow-lg">Private Shore</span>
                    </div>
                </div>

                <!-- Image 3 - Square -->
                <div class="gallery-item relative col-span-1 row-span-1 md:col-span-1 md:row-span-1 overflow-hidden rounded-2xl shadow-[0_10px_20px_-5px_rgba(0,0,0,0.15)] group/image">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2080&q=80" 
                         alt="Luxury Suite" 
                         class="w-full h-full object-cover transition-all duration-700 group-hover/image:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#3f352e]/60 via-transparent to-transparent opacity-0 group-hover/image:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover/image:translate-y-0 transition-transform duration-500">
                        <span class="text-white font-['Cormorant_Garamond'] text-base drop-shadow-lg">Ocean Suite</span>
                    </div>
                </div>

                <!-- Image 4 - Landscape -->
                <div class="gallery-item relative col-span-2 row-span-1 md:col-span-2 md:row-span-1 overflow-hidden rounded-3xl shadow-[0_15px_30px_-10px_rgba(0,0,0,0.2)] group/image">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                         alt="Fine Dining" 
                         class="w-full h-full object-cover transition-all duration-700 group-hover/image:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#3f352e]/60 via-transparent to-transparent opacity-0 group-hover/image:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-full group-hover/image:translate-y-0 transition-transform duration-500">
                        <span class="text-white font-['Cormorant_Garamond'] text-xl drop-shadow-lg block">The Dining Room</span>
                        <span class="text-white/80 text-xs tracking-wider">Culinary artistry</span>
                    </div>
                </div>

                <!-- Image 5 - Portrait (appears on desktop only) -->
                <div class="gallery-item relative hidden md:block col-span-1 row-span-1 overflow-hidden rounded-2xl shadow-[0_10px_20px_-5px_rgba(0,0,0,0.15)] group/image">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                         alt="Spa Treatment" 
                         class="w-full h-full object-cover transition-all duration-700 group-hover/image:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#3f352e]/60 via-transparent to-transparent opacity-0 group-hover/image:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover/image:translate-y-0 transition-transform duration-500">
                        <span class="text-white font-['Cormorant_Garamond'] text-base drop-shadow-lg">The Spa</span>
                    </div>
                </div>

                <!-- Image 6 - Square (appears on desktop only) -->
                <div class="gallery-item relative hidden md:block col-span-1 row-span-1 overflow-hidden rounded-2xl shadow-[0_10px_20px_-5px_rgba(0,0,0,0.15)] group/image">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                         alt="Sunset" 
                         class="w-full h-full object-cover transition-all duration-700 group-hover/image:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#3f352e]/60 via-transparent to-transparent opacity-0 group-hover/image:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover/image:translate-y-0 transition-transform duration-500">
                        <span class="text-white font-['Cormorant_Garamond'] text-base drop-shadow-lg">African Sunset</span>
                    </div>
                </div>
            </div>

            <!-- Floating Polaroid-Style Elements - Unique Addition -->
            <div class="absolute -top-8 -right-4 md:-right-8 w-32 h-32 rotate-12 opacity-30 group-hover:opacity-50 transition-opacity pointer-events-none">
                <div class="relative">
                    <div class="absolute inset-0 bg-white shadow-xl rotate-3"></div>
                    <div class="absolute top-2 left-2 right-2 bottom-8 bg-gradient-to-br from-[#d4b48c] to-[#b89a78]"></div>
                </div>
            </div>
            
            <div class="absolute -bottom-6 -left-4 md:-left-8 w-28 h-28 -rotate-6 opacity-20 pointer-events-none">
                <div class="relative">
                    <div class="absolute inset-0 bg-white shadow-xl -rotate-2"></div>
                    <div class="absolute top-2 left-2 right-2 bottom-8 bg-gradient-to-br from-[#8a735b] to-[#6b5d51]"></div>
                </div>
            </div>
        </div>

        <!-- Creative CTA - Film Strip Style -->
        <div class="relative mt-16 flex justify-center">
            <!-- Film Perforations Decoration -->
            <div class="absolute left-1/2 -translate-x-1/2 -top-6 flex gap-2">
                <div class="w-2 h-2 rounded-full bg-[#d4b48c]/30"></div>
                <div class="w-2 h-2 rounded-full bg-[#d4b48c]/30"></div>
                <div class="w-2 h-2 rounded-full bg-[#d4b48c]/30"></div>
                <div class="w-2 h-2 rounded-full bg-[#d4b48c]/50"></div>
                <div class="w-2 h-2 rounded-full bg-[#d4b48c]/30"></div>
                <div class="w-2 h-2 rounded-full bg-[#d4b48c]/30"></div>
                <div class="w-2 h-2 rounded-full bg-[#d4b48c]/30"></div>
            </div>

            <a href="gallery.php" class="group relative inline-flex items-center gap-3 px-10 py-4 bg-[#ffffff] border border-[#d6cbbc] rounded-full shadow-[0_8px_20px_-8px_rgba(100,70,40,0.2)] hover:shadow-[0_12px_25px_-8px_rgba(100,70,40,0.3)] transition-all duration-300">
                <!-- Left Decoration - Film Strip Style -->
                <span class="flex gap-1 mr-2">
                    <span class="w-1 h-2 bg-[#d4b48c] rounded-full group-hover:animate-pulse"></span>
                    <span class="w-1 h-2 bg-[#d4b48c] rounded-full group-hover:animate-pulse animation-delay-200"></span>
                    <span class="w-1 h-2 bg-[#d4b48c] rounded-full group-hover:animate-pulse animation-delay-400"></span>
                </span>

                <!-- Text -->
                <span class="font-['Montserrat'] text-sm uppercase tracking-[0.25em] text-[#5c524a] group-hover:text-[#3f352e] transition-colors">
                    View Full Gallery
                </span>
                <i class="fas fa-arrow-right text-[#b89a78] text-sm group-hover:translate-x-1 transition-transform duration-300"></i>

                <!-- Right Decoration -->
                <span class="flex gap-1 ml-2">
                    <span class="w-1 h-2 bg-[#d4b48c] rounded-full group-hover:animate-pulse animation-delay-600"></span>
                    <span class="w-1 h-2 bg-[#d4b48c] rounded-full group-hover:animate-pulse animation-delay-800"></span>
                    <span class="w-1 h-2 bg-[#d4b48c] rounded-full group-hover:animate-pulse animation-delay-1000"></span>
                </span>

                <!-- Hover Background Effect -->
                <span class="absolute inset-0 rounded-full bg-gradient-to-r from-[#f0e7dd] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"></span>
            </a>
        </div>
    </div>

    <!-- Unique Animations for this Section -->
    <style>
        /* Gallery Previews Specific Animations */
        
        @keyframes rotateSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes rotateReverse {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }
        
        .animate-rotate-slow {
            animation: rotateSlow 60s linear infinite;
        }
        
        .animate-rotate-reverse {
            animation: rotateReverse 80s linear infinite;
        }
        
        @keyframes drift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(5%, 3%) scale(1.05); }
            50% { transform: translate(2%, 8%) scale(1.1); }
            75% { transform: translate(-3%, 4%) scale(1.05); }
        }
        
        .animate-drift {
            animation: drift 30s ease-in-out infinite;
        }
        
        .animate-drift-slow {
            animation: drift 40s ease-in-out infinite reverse;
        }
        
        /* Staggered Entrance Animation for Gallery Items */
        .gallery-item {
            opacity: 0;
            transform: translateY(20px);
            animation: galleryFadeIn 0.8s ease-out forwards;
        }
        
        .gallery-item:nth-child(1) { animation-delay: 0.1s; }
        .gallery-item:nth-child(2) { animation-delay: 0.2s; }
        .gallery-item:nth-child(3) { animation-delay: 0.3s; }
        .gallery-item:nth-child(4) { animation-delay: 0.4s; }
        .gallery-item:nth-child(5) { animation-delay: 0.5s; }
        .gallery-item:nth-child(6) { animation-delay: 0.6s; }
        
        @keyframes galleryFadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Pulse Animation with Delays for CTA */
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.2); }
        }
        
        .group:hover .group-hover\:animate-pulse {
            animation: pulse 1.5s ease-in-out infinite;
        }
        
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-400 { animation-delay: 400ms; }
        .animation-delay-600 { animation-delay: 600ms; }
        .animation-delay-800 { animation-delay: 800ms; }
        .animation-delay-1000 { animation-delay: 1000ms; }
        
        /* Corner Accent Animation */
        .gallery-item:hover .border-white\/0 {
            border-color: rgba(255, 255, 255, 0.6);
            transition: all 0.5s ease 0.15s;
        }
        
        /* Caption Slide Up */
        .gallery-item:hover .translate-y-full {
            transform: translateY(0);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .grid {
                gap: 0.75rem;
            }
            
            .gallery-item {
                border-radius: 1rem;
            }
            
            .gallery-item .text-xl {
                font-size: 1.1rem;
            }
            
            .absolute.top-20.left-\[5\%\] {
                width: 120px;
                height: 120px;
            }
            
            .absolute.bottom-40.right-\[8\%\] {
                width: 150px;
                height: 150px;
            }
        }
        
        /* Custom Rounded Sizes for Variety */
        .rounded-3xl {
            border-radius: 1.5rem;
        }
        
        .rounded-2xl {
            border-radius: 1.25rem;
        }
        
        /* Smooth Image Zoom */
        .gallery-item img {
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
    </style>
</section>





<!-- Guest Testimonials Section - Living Stories Collection with Deep Elegance -->
<section class="relative py-28 px-6 bg-gradient-to-br from-[#1e2f3a] via-[#2a3f4a] to-[#1a2a32] overflow-hidden">
    <!-- Decorative Background Elements - Ethereal and Deep -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Floating Quote Marks Pattern - Subtle and Elegant -->
        <div class="absolute inset-0 opacity-[0.05]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M15 20 L25 20 L20 35 L15 35 Z\' fill=\'%23d4b48c\'/%3E%3Cpath d=\'M35 20 L45 20 L40 35 L35 35 Z\' fill=\'%23d4b48c\'/%3E%3C/svg%3E'); background-size: 80px 80px;"></div>
        
        <!-- Gentle Light Orbs - Warm Glow in Deep Blue -->
        <div class="absolute top-1/4 left-[10%] w-72 h-72 bg-[#d4b48c]/15 rounded-full blur-[100px] animate-float-orb"></div>
        <div class="absolute bottom-1/3 right-[15%] w-96 h-96 bg-[#b89a78]/15 rounded-full blur-[120px] animate-float-orb-slow"></div>
        
        <!-- Scattered Sparkles - Gold on Deep Blue -->
        <div class="absolute top-40 left-[20%] w-1 h-1 bg-[#d4b48c] rounded-full animate-twinkle"></div>
        <div class="absolute top-60 right-[25%] w-1.5 h-1.5 bg-[#d4b48c] rounded-full animate-twinkle-delay"></div>
        <div class="absolute bottom-40 left-[40%] w-1 h-1 bg-[#b89a78] rounded-full animate-twinkle-slow"></div>
        
        <!-- Subtle Noise Texture -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: repeating-linear-gradient(45deg, #d4b48c 0px, #d4b48c 1px, transparent 1px, transparent 8px);"></div>
        
        <!-- Star Field Effect - Tiny Dots -->
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 30%, white 0.5px, transparent 0.5px), radial-gradient(circle at 80% 70%, white 0.5px, transparent 0.5px); background-size: 50px 50px;"></div>
    </div>

    <div class="max-w-6xl mx-auto relative z-10">
        <!-- Section Header - Light Text on Dark Background -->
        <div class="text-center mb-16">
            <span class="text-[#d4b48c] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light drop-shadow-lg">Guest Voices</span>
            <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-white mt-4 mb-6 font-light drop-shadow-lg">Treasured Memories</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
            <p class="text-white/70 text-sm max-w-2xl mx-auto mt-6 font-light tracking-wide drop-shadow">
                Not just stays—stories. Hear from those who've experienced the magic of Aora45.
            </p>
        </div>

        <!-- Testimonials Carousel - NO CARDS, Organic Floating Design -->
        <div class="relative px-4 md:px-12">
            <!-- Main Carousel Container -->
            <div class="overflow-hidden py-8" id="testimonialCarousel">
                <div class="flex transition-transform duration-700 ease-out" id="testimonialTrack" style="transform: translateX(0%);">
                    
                    <!-- Testimonial 1 - Honeymoon Story -->
                    <div class="testimonial-slide flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="relative testimonial-card">
                            <!-- Floating Quote Mark - Gold on Dark -->
                            <div class="absolute -top-6 -left-2 text-8xl text-[#d4b48c]/20 font-['DM_Serif_Display'] leading-none">&ldquo;</div>
                            
                            <!-- Content Container - No Background, No Border, No Shadow -->
                            <div class="relative pt-8">
                                <!-- Stars - Gold on Dark -->
                                <div class="flex gap-1 mb-4">
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-200"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-400"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-600"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-800"></i>
                                </div>
                                
                                <!-- Testimonial Text - White on Dark -->
                                <div class="relative mb-6">
                                    <p class="font-['Cormorant_Garamond'] text-lg md:text-xl text-white/90 leading-relaxed italic drop-shadow-lg">
                                        "Aora45 made our honeymoon feel like a dream. The private dinner under the acacia tree, the sound of the wind through the savanna—we've never felt more connected."
                                    </p>
                                    <!-- Decorative Line - Grows on Hover -->
                                    <div class="w-12 h-0.5 bg-gradient-to-r from-[#d4b48c] to-transparent mt-4 group-hover:w-20 transition-all duration-500"></div>
                                </div>
                                
                                <!-- Guest Info - Floating Avatar Design (No Container) -->
                                <div class="flex items-center gap-4">
                                    <!-- Avatar with Ring Animation -->
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-full overflow-hidden ring-2 ring-[#d4b48c]/40 ring-offset-2 ring-offset-[#1e2f3a]">
                                            <img src="https://indochinatodaytravel.com/wp-content/uploads/2025/12/Honeymoon-in-Halong-Bay-7.jpg" 
                                                 alt="Sarah" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <!-- Animated Ring -->
                                        <div class="absolute inset-0 rounded-full border-2 border-[#d4b48c] opacity-0 hover:opacity-100 animate-ping-slow"></div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-['Cormorant_Garamond'] text-lg text-white">Sarah & David</h4>
                                        <p class="text-[#d4b48c]/80 text-xs tracking-wide">Honeymoon, Nairobi</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Date Badge - No Card -->
                            <div class="absolute top-0 right-0 flex items-center gap-2">
                                <span class="w-8 h-px bg-[#d4b48c]/40"></span>
                                <span class="text-[#d4b48c]/70 text-[10px] uppercase tracking-wider">Feb 2025</span>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 - Family Story -->
                    <div class="testimonial-slide flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="relative testimonial-card">
                            <div class="absolute -top-6 -left-2 text-8xl text-[#d4b48c]/20 font-['DM_Serif_Display'] leading-none">&ldquo;</div>
                            
                            <div class="relative pt-8">
                                <div class="flex gap-1 mb-4">
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-200"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-400"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-600"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-800"></i>
                                </div>
                                
                                <div class="relative mb-6">
                                    <p class="font-['Cormorant_Garamond'] text-lg md:text-xl text-white/90 leading-relaxed italic drop-shadow-lg">
                                        "Our kids still talk about the junior ranger program! The staff treated them like family, and we actually got to relax. That's the real luxury when you're traveling with children."
                                    </p>
                                    <div class="w-12 h-0.5 bg-gradient-to-r from-[#d4b48c] to-transparent mt-4 group-hover:w-20 transition-all duration-500"></div>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-full overflow-hidden ring-2 ring-[#d4b48c]/40 ring-offset-2 ring-offset-[#1e2f3a]">
                                            <img src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                                 alt="Michael" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="absolute inset-0 rounded-full border-2 border-[#d4b48c] opacity-0 hover:opacity-100 animate-ping-slow"></div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-['Cormorant_Garamond'] text-lg text-white">The Johnson Family</h4>
                                        <p class="text-[#d4b48c]/80 text-xs tracking-wide">Family Safari, UK</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute top-0 right-0 flex items-center gap-2">
                                <span class="w-8 h-px bg-[#d4b48c]/40"></span>
                                <span class="text-[#d4b48c]/70 text-[10px] uppercase tracking-wider">Feb 2026</span>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 - Solo Traveler Story -->
                    <div class="testimonial-slide flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="relative testimonial-card">
                            <div class="absolute -top-6 -left-2 text-8xl text-[#d4b48c]/20 font-['DM_Serif_Display'] leading-none">&ldquo;</div>
                            
                            <div class="relative pt-8">
                                <div class="flex gap-1 mb-4">
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-200"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-400"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-600"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-800"></i>
                                </div>
                                
                                <div class="relative mb-6">
                                    <p class="font-['Cormorant_Garamond'] text-lg md:text-xl text-white/90 leading-relaxed italic drop-shadow-lg">
                                        "As a solo traveler, I was nervous. But Aora45 felt like home from the moment I arrived. The staff remembered my name, my coffee order—everything. Pure magic."
                                    </p>
                                    <div class="w-12 h-0.5 bg-gradient-to-r from-[#d4b48c] to-transparent mt-4 group-hover:w-20 transition-all duration-500"></div>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-full overflow-hidden ring-2 ring-[#d4b48c]/40 ring-offset-2 ring-offset-[#1e2f3a]">
                                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1964&q=80" 
                                                 alt="Elena" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="absolute inset-0 rounded-full border-2 border-[#d4b48c] opacity-0 hover:opacity-100 animate-ping-slow"></div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-['Cormorant_Garamond'] text-lg text-white">Elena Rossi</h4>
                                        <p class="text-[#d4b48c]/80 text-xs tracking-wide">Solo Retreat, Italy</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute top-0 right-0 flex items-center gap-2">
                                <span class="w-8 h-px bg-[#d4b48c]/40"></span>
                                <span class="text-[#d4b48c]/70 text-[10px] uppercase tracking-wider">Mar 2025</span>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 4 - Business Traveler Story -->
                    <div class="testimonial-slide flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="relative testimonial-card">
                            <div class="absolute -top-6 -left-2 text-8xl text-[#d4b48c]/20 font-['DM_Serif_Display'] leading-none">&ldquo;</div>
                            
                            <div class="relative pt-8">
                                <div class="flex gap-1 mb-4">
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-200"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-400"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-600"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-sm animate-star-pulse animation-delay-800"></i>
                                </div>
                                
                                <div class="relative mb-6">
                                    <p class="font-['Cormorant_Garamond'] text-lg md:text-xl text-white/90 leading-relaxed italic drop-shadow-lg">
                                        "The business lounge was impeccable—fast WiFi, private meeting rooms, and the most incredible coffee. I closed a deal while watching giraffes from the window. Unreal."
                                    </p>
                                    <div class="w-12 h-0.5 bg-gradient-to-r from-[#d4b48c] to-transparent mt-4 group-hover:w-20 transition-all duration-500"></div>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-full overflow-hidden ring-2 ring-[#d4b48c]/40 ring-offset-2 ring-offset-[#1e2f3a]">
                                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80" 
                                                 alt="James" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="absolute inset-0 rounded-full border-2 border-[#d4b48c] opacity-0 hover:opacity-100 animate-ping-slow"></div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-['Cormorant_Garamond'] text-lg text-white">James Mwangi</h4>
                                        <p class="text-[#d4b48c]/80 text-xs tracking-wide">Business, Nairobi</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute top-0 right-0 flex items-center gap-2">
                                <span class="w-8 h-px bg-[#d4b48c]/40"></span>
                                <span class="text-[#d4b48c]/70 text-[10px] uppercase tracking-wider">Jan 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls - Gold on Dark -->
            <button class="carousel-prev absolute left-0 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full border border-[#d4b48c]/30 text-[#d4b48c] hover:bg-[#d4b48c] hover:text-[#1e2f3a] transition-all duration-300 flex items-center justify-center group" onclick="moveSlide(-1)">
                <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
            </button>
            <button class="carousel-next absolute right-0 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full border border-[#d4b48c]/30 text-[#d4b48c] hover:bg-[#d4b48c] hover:text-[#1e2f3a] transition-all duration-300 flex items-center justify-center group" onclick="moveSlide(1)">
                <i class="fas fa-arrow-right text-sm group-hover:translate-x-0.5 transition-transform"></i>
            </button>

            <!-- Navigation Dots - Gold on Dark -->
            <div class="flex justify-center gap-3 mt-10" id="testimonialDots">
                <button class="dot w-2 h-2 rounded-full bg-[#d4b48c] transition-all duration-300" data-index="0"></button>
                <button class="dot w-2 h-2 rounded-full bg-[#d4b48c]/30 hover:bg-[#d4b48c]/50 transition-all duration-300" data-index="1"></button>
                <button class="dot w-2 h-2 rounded-full bg-[#d4b48c]/30 hover:bg-[#d4b48c]/50 transition-all duration-300" data-index="2"></button>
                <button class="dot w-2 h-2 rounded-full bg-[#d4b48c]/30 hover:bg-[#d4b48c]/50 transition-all duration-300" data-index="3"></button>
            </div>
        </div>

        <!-- Floating Quote Collection Decoration - Gold on Dark -->
        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 flex gap-6 opacity-20 pointer-events-none">
            <i class="fas fa-quote-right text-4xl text-[#d4b48c] rotate-12"></i>
            <i class="fas fa-quote-right text-6xl text-[#b89a78] -rotate-12"></i>
            <i class="fas fa-quote-right text-3xl text-[#8a735b] rotate-45"></i>
        </div>
    </div>

    <!-- Unique Animations for this Section -->
    <style>
        /* Testimonials Specific Animations */
        
        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.15; }
            25% { transform: translate(5%, -5%) scale(1.1); opacity: 0.2; }
            50% { transform: translate(-3%, 7%) scale(0.95); opacity: 0.15; }
            75% { transform: translate(4%, 2%) scale(1.05); opacity: 0.2; }
        }
        
        .animate-float-orb {
            animation: floatOrb 20s ease-in-out infinite;
        }
        
        .animate-float-orb-slow {
            animation: floatOrb 30s ease-in-out infinite reverse;
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.5); }
        }
        
        .animate-twinkle {
            animation: twinkle 4s ease-in-out infinite;
        }
        
        .animate-twinkle-delay {
            animation: twinkle 5s ease-in-out infinite 1s;
        }
        
        .animate-twinkle-slow {
            animation: twinkle 6s ease-in-out infinite 2s;
        }
        
        @keyframes starPulse {
            0%, 100% { transform: scale(1); opacity: 1; color: #d4b48c; }
            50% { transform: scale(1.2); opacity: 0.9; color: #f4d03f; }
        }
        
        .animate-star-pulse {
            animation: starPulse 2s ease-in-out infinite;
        }
        
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-400 { animation-delay: 400ms; }
        .animation-delay-600 { animation-delay: 600ms; }
        .animation-delay-800 { animation-delay: 800ms; }
        
        @keyframes pingSlow {
            0% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.3); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }
        
        .animate-ping-slow {
            animation: pingSlow 2s ease-out infinite;
        }
        
        /* Testimonial Card Hover Effects */
        .testimonial-card {
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover .w-12.h-0\.5 {
            width: 5rem;
        }
        
        .testimonial-card:hover .absolute.-top-6.-left-2 {
            color: rgba(212, 180, 140, 0.3);
            transform: scale(1.1);
            transition: all 0.5s ease;
        }
        
        /* Slide Entrance Animation */
        .testimonial-slide {
            opacity: 0;
            animation: slideFadeIn 0.8s ease-out forwards;
        }
        
        .testimonial-slide:nth-child(1) { animation-delay: 0.2s; }
        .testimonial-slide:nth-child(2) { animation-delay: 0.3s; }
        .testimonial-slide:nth-child(3) { animation-delay: 0.4s; }
        .testimonial-slide:nth-child(4) { animation-delay: 0.5s; }
        
        @keyframes slideFadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Active Dot Styling */
        .dot.active {
            width: 24px;
            background-color: #d4b48c;
            border-radius: 12px;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .testimonial-slide {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            .testimonial-card .text-8xl {
                font-size: 5rem;
            }
            
            .carousel-prev, .carousel-next {
                width: 40px;
                height: 40px;
            }
            
            .absolute.top-1\/4.left-\[10\%\] {
                width: 150px;
                height: 150px;
            }
            
            .absolute.bottom-1\/3.right-\[15\%\] {
                width: 200px;
                height: 200px;
            }
        }
        
        /* Custom Ring Offset Color */
        .ring-offset-\[#1e2f3a\] {
            --tw-ring-offset-color: #1e2f3a;
        }
    </style>

    <!-- Carousel JavaScript -->
    <script>
        (function() {
            const track = document.getElementById('testimonialTrack');
            const slides = document.querySelectorAll('.testimonial-slide');
            const dots = document.querySelectorAll('#testimonialDots .dot');
            
            if (!track || !slides.length) return;
            
            let currentIndex = 0;
            let slidesPerView = 1;
            let totalSlides = slides.length;
            
            function updateSlidesPerView() {
                if (window.innerWidth >= 1024) {
                    slidesPerView = 3;
                } else if (window.innerWidth >= 768) {
                    slidesPerView = 2;
                } else {
                    slidesPerView = 1;
                }
                
                // Update max index
                if (currentIndex > totalSlides - slidesPerView) {
                    currentIndex = Math.max(0, totalSlides - slidesPerView);
                    updateCarousel(false);
                }
                
                updateDots();
            }
            
            function updateCarousel(animate = true) {
                if (!track) return;
                const percentage = (currentIndex * (100 / slidesPerView));
                track.style.transform = `translateX(-${percentage}%)`;
                
                // Update dots
                updateDots();
            }
            
            function updateDots() {
                dots.forEach((dot, index) => {
                    if (index === currentIndex) {
                        dot.classList.add('active');
                        dot.classList.remove('bg-[#d4b48c]/30');
                    } else {
                        dot.classList.remove('active');
                        dot.classList.add('bg-[#d4b48c]/30');
                    }
                });
            }
            
            window.moveSlide = function(direction) {
                const newIndex = currentIndex + direction;
                if (newIndex >= 0 && newIndex <= totalSlides - slidesPerView) {
                    currentIndex = newIndex;
                    updateCarousel();
                }
            };
            
            // Dot click handlers
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    if (index <= totalSlides - slidesPerView) {
                        currentIndex = index;
                        updateCarousel();
                    }
                });
            });
            
            // Initialize
            updateSlidesPerView();
            
            // Handle resize
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    updateSlidesPerView();
                }, 150);
            });
        })();
    </script>
</section>




<!-- Location Snapshot Section - Real Google Map Integration -->
<section class="relative py-20 px-6 bg-[#f5efe8] overflow-hidden">
    <!-- Decorative Background Elements - Subtle and Refined -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Compass Rose Pattern - Very Subtle -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M50 10 L52 20 L50 18 L48 20 L50 10\' fill=\'%238a735b\'/%3E%3Cpath d=\'M50 90 L52 80 L50 82 L48 80 L50 90\' fill=\'%238a735b\'/%3E%3Cpath d=\'M10 50 L20 52 L18 50 L20 48 L10 50\' fill=\'%238a735b\'/%3E%3Cpath d=\'M90 50 L80 52 L82 50 L80 48 L90 50\' fill=\'%238a735b\'/%3E%3Ccircle cx=\'50\' cy=\'50\' r=\'3\' fill=\'%238a735b\'/%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
        
        <!-- Gentle Light Orbs -->
        <div class="absolute top-1/3 left-[5%] w-64 h-64 bg-[#d4b48c]/10 rounded-full blur-[80px]"></div>
        <div class="absolute bottom-1/3 right-[8%] w-72 h-72 bg-[#b89a78]/10 rounded-full blur-[90px]"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Section Header - Minimal -->
        <div class="text-center mb-12">
            <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Find Us</span>
            <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#3f352e] mt-4 mb-6 font-light">Our Location</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
        </div>

        <!-- Location Content - Split Layout -->
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            
            <!-- Left Column - Address Information -->
            <div class="space-y-8 order-2 lg:order-1">
                <!-- Location Badge - Floating Pin -->
                <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm px-5 py-2.5 rounded-full border border-[#e0d6cc] shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center">
                        <i class="fas fa-map-pin text-white text-sm"></i>
                    </div>
                    <span class="font-['Montserrat'] text-xs uppercase tracking-wider text-[#5c524a]">Proudly Nairobi</span>
                </div>

                <!-- Main Address - Elegant Typography -->
                <div class="space-y-4">
                    <h3 class="font-['Cormorant_Garamond'] text-3xl md:text-4xl text-[#3f352e]">Aora45 Resort & Restaurant</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-start gap-4">
                            <i class="fas fa-location-dot text-[#d4b48c] text-lg mt-1"></i>
                            <div>
                                <p class="font-['Montserrat'] text-[#5c524a] text-base leading-relaxed">
                                    109 Karura Road, Gigiri<br>
                                    Nairobi, Kenya 00100
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <i class="fas fa-phone-alt text-[#d4b48c] text-lg"></i>
                            <p class="font-['Montserrat'] text-[#5c524a] text-base">+254 (0) 20 123 4567</p>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <i class="fas fa-envelope text-[#d4b48c] text-lg"></i>
                            <p class="font-['Montserrat'] text-[#5c524a] text-base">info@aora45.com</p>
                        </div>
                    </div>
                </div>

                <!-- Landmark Highlights - Minimal Chips -->
                <div class="flex flex-wrap gap-3 pt-4">
                    <div class="px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full border border-[#e0d6cc] text-xs text-[#5c524a]">
                        <i class="fas fa-tree mr-2 text-[#8a735b]"></i>Karura Forest
                    </div>
                    <div class="px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full border border-[#e0d6cc] text-xs text-[#5c524a]">
                        <i class="fas fa-building mr-2 text-[#8a735b]"></i>UNEP Headquarters
                    </div>
                    <div class="px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full border border-[#e0d6cc] text-xs text-[#5c524a]">
                        <i class="fas fa-landmark mr-2 text-[#8a735b]"></i>Village Market
                    </div>
                </div>

                <!-- View on Map Link - Opens Google Maps -->
                <div class="pt-6">
                    <a href="https://www.google.com/maps/search/?api=1&query=Aora+Resort+Gigiri+Nairobi" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group inline-flex items-center gap-4 px-8 py-4 bg-[#ffffff] border border-[#d6cbbc] rounded-full shadow-[0_8px_20px_-8px_rgba(100,70,40,0.2)] hover:shadow-[0_12px_25px_-8px_rgba(100,70,40,0.3)] transition-all duration-300">
                        <!-- Compass Icon with Animation -->
                        <span class="relative">
                            <i class="fas fa-compass text-[#d4b48c] text-xl group-hover:rotate-45 transition-transform duration-500"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-[#d4b48c] rounded-full animate-ping-slow opacity-75"></span>
                        </span>
                        
                        <!-- Text -->
                        <span class="font-['Montserrat'] text-sm uppercase tracking-[0.25em] text-[#5c524a] group-hover:text-[#3f352e] transition-colors">
                            Open in Google Maps
                        </span>
                        
                        <!-- Arrow -->
                        <i class="fas fa-arrow-up-right-from-square text-[#b89a78] text-sm group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-300"></i>
                        
                        <!-- Hover Background Effect -->
                        <span class="absolute inset-0 rounded-full bg-gradient-to-r from-[#f0e7dd] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"></span>
                    </a>
                </div>

                <!-- Distance Indicator - Minimal -->
                <div class="flex items-center gap-2 text-xs text-[#8a735b] pt-2">
                    <i class="fas fa-plane"></i>
                    <span>45 min from Jomo Kenyatta International Airport</span>
                </div>
            </div>

            <!-- Right Column - Real Google Map -->
            <div class="relative order-1 lg:order-2 group/map">
                <!-- Map Container - No Card, Just Map with Frame Effect -->
                <div class="relative rounded-3xl overflow-hidden shadow-[0_25px_40px_-15px_rgba(0,0,0,0.3)] h-[400px] md:h-[500px]">
                    <!-- Google Maps iframe - Exact Location: Gigiri, Nairobi -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.789123456789!2d36.802847!3d-1.234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMTQnMDQuNCJTIDM2wrA0OCcxMC4yIkU!5e0!3m2!1sen!2ske!4v1234567890123!5m2!1sen!2ske"
                        width="100%" 
                        height="100%" 
                        style="border:0; filter: grayscale(20%) sepia(10%) hue-rotate(350deg) brightness(1.05);" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full object-cover transition-all duration-7000 group-hover/map:scale-105"
                        title="Google Map showing Aora45 Resort location in Gigiri, Nairobi">
                    </iframe>
                    
                    <!-- Artistic Overlay - Subtle Gradient (preserves map visibility) -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1e2f3a]/20 via-transparent to-transparent pointer-events-none"></div>
                    
                    <!-- Location Marker - Pulsing Pin (overlay on map) -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                        <div class="relative">
                            <!-- Pin Shadow -->
                            <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-6 h-2 bg-black/30 blur-md rounded-full"></div>
                            
                            <!-- Main Pin -->
                            <div class="relative w-14 h-14 bg-gradient-to-br from-[#d4b48c] to-[#b89a78] rounded-full flex items-center justify-center shadow-[0_10px_20px_-5px_rgba(0,0,0,0.3)] animate-bounce-slow">
                                <i class="fas fa-map-pin text-white text-2xl"></i>
                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-white rounded-full border-2 border-[#d4b48c]"></div>
                            </div>
                            
                            <!-- Pulse Rings -->
                            <div class="absolute inset-0 rounded-full border-2 border-[#d4b48c] animate-ping-slow opacity-75"></div>
                            <div class="absolute -inset-4 rounded-full border border-[#d4b48c]/40 animate-pulse-slower"></div>
                        </div>
                    </div>

                    <!-- Mini Info Card - Floating Address on Map -->
                    <div class="absolute bottom-6 left-6 right-6 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[#3f352e] font-['Cormorant_Garamond'] text-lg font-medium">Aora45 Resort</p>
                                <p class="text-[#8a735b] text-xs">109 Karura Road, Gigiri, Nairobi</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <i class="fas fa-star text-[#d4b48c] text-[10px]"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-[10px]"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-[10px]"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-[10px]"></i>
                                    <i class="fas fa-star text-[#d4b48c] text-[10px]"></i>
                                    <span class="text-[#8a735b] text-[10px] ml-1">(4.9)</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-br from-[#d4b48c] to-[#b89a78] rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Attribution - Minimal -->
                <p class="text-center text-[#8a735b] text-[10px] uppercase tracking-wider mt-3">
                    Exact location • Google Maps integration
                </p>
            </div>
        </div>

        <!-- Bottom Divider - Decorative -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#d4b48c]/30 to-transparent"></div>
    </div>

    <!-- Unique Animations for this Section -->
    <style>
        /* Location Section Specific Animations */
        
        @keyframes bounceSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        
        .animate-bounce-slow {
            animation: bounceSlow 3s ease-in-out infinite;
        }
        
        @keyframes pingSlow {
            0% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.5); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }
        
        .animate-ping-slow {
            animation: pingSlow 2s ease-out infinite;
        }
        
        .animate-pulse-slower {
            animation: pulseSlower 3s ease-in-out infinite;
        }
        
        @keyframes pulseSlower {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.6; }
        }
        
        /* Map image slow zoom on hover */
        .group\/map:hover iframe {
            transform: scale(1.05);
            transition: transform 7s ease;
        }
        
        /* Compass rotation */
        .group:hover .fa-compass {
            transform: rotate(45deg);
        }
        
        /* Google Maps custom styling via filter */
        iframe {
            transition: all 7s ease;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .relative.w-14.h-14 {
                width: 40px;
                height: 40px;
            }
            
            .relative.w-14.h-14 i {
                font-size: 1.25rem;
            }
            
            .relative.w-14.h-14 .w-4.h-4 {
                width: 12px;
                height: 12px;
            }
            
            .absolute.-inset-4 {
                inset: -0.75rem;
            }
            
            .group\/map .text-lg {
                font-size: 1rem;
            }
            
            .absolute.bottom-6.left-6.right-6 {
                left: 1rem;
                right: 1rem;
                bottom: 1rem;
                padding: 0.75rem;
            }
        }
        
        @media (max-width: 1023px) {
            .grid {
                gap: 2rem;
            }
        }
        
        /* Ensure map is interactive */
        iframe {
            pointer-events: auto;
            position: relative;
            z-index: 5;
        }
        
        /* But keep overlay elements above map */
        .absolute.pointer-events-none {
            z-index: 10;
        }
        
        .absolute.top-1\/2.left-1\/2 {
            z-index: 20;
        }
        
        .absolute.bottom-6 {
            z-index: 15;
        }
    </style>
</section>




<!-- Footer Section - Unique Framed Design with Background Image -->
<footer class="relative py-16 px-6 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="African sunset landscape" 
             class="w-full h-full object-cover">
        <!-- Very light overlay to soften but not hide -->
        <div class="absolute inset-0 bg-black/10"></div>
    </div>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Light Green Shading Container - Wraps all content with equal empty space around -->
        <!-- Using very light green with low opacity to let background show through -->
        <div class="bg-[#e8f3e9]/70 backdrop-blur-[2px] p-8 md:p-12 lg:p-16 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.3)] border border-white/50">
            
            <!-- Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
                
                <!-- Column 1 - Logo & About -->
                <div class="space-y-5">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="logo1.png" alt="Aora45 Resort" class="h-16 w-auto" onerror="this.src='https://placehold.co/200x80/e8f3e9/1e2f3a?text=Aora45'">
                        <div class="ml-3">
                            <h2 class="font-['Playfair_Display'] text-2xl font-bold text-[#1e3a2f]">Aora45</h2>
                            <div class="w-10 h-0.5 bg-gradient-to-r from-[#8fb89a] to-transparent"></div>
                            <p class="text-[#1e3a2f]/80 text-[0.6rem] tracking-wider mt-0.5">RESORT & RESTAURANT</p>
                        </div>
                    </div>
                    
                    <p class="text-[#1e3a2f] text-sm leading-relaxed">
                        Where Kenyan hospitality meets timeless elegance in the heart of Nairobi.
                    </p>
                    
                    <!-- Awards Badge - Minimal -->
                    <div class="flex items-center gap-2">
                        <i class="fas fa-award text-[#8fb89a]"></i>
                        <span class="text-xs text-[#1e3a2f]">Africa's Leading Resort 2026</span>
                    </div>
                </div>

                <!-- Column 2 - Contact Information -->
                <div class="space-y-5">
                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#1e3a2f] border-b border-[#8fb89a]/30 pb-2">Reach Us</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#8fb89a]/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-pin text-[#1e3a2f] text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[#1e3a2f] text-xs font-medium uppercase tracking-wider">Visit</p>
                                <p class="text-[#1e3a2f] text-sm">109 Karura Road, Gigiri<br>Nairobi, Kenya 00100</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#8fb89a]/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt text-[#1e3a2f] text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[#1e3a2f] text-xs font-medium uppercase tracking-wider">Call</p>
                                <p class="text-[#1e3a2f] text-sm">+254 (0) 20 123 4567</p>
                                <p class="text-[#1e3a2f] text-sm">+254 (0) 722 123 456</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#8fb89a]/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-[#1e3a2f] text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[#1e3a2f] text-xs font-medium uppercase tracking-wider">Email</p>
                                <p class="text-[#1e3a2f] text-sm">info@aora45.com</p>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3 - Quick Links -->
                <div class="space-y-5">
                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#1e3a2f] border-b border-[#8fb89a]/30 pb-2">Explore</h3>
                    
                    <ul class="space-y-3">
                        <li>
                            <a href="about.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>About Aora45</span>
                            </a>
                        </li>
                        <li>
                            <a href="rooms.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Rooms & Suites</span>
                            </a>
                        </li>
                        <li>
                            <a href="restaurant.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Dining Experiences</span>
                            </a>
                        </li>
                        <li>
                            <a href="amenities.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Spa & Wellness</span>
                            </a>
                        </li>
                        <li>
                            <a href="events.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Events & Weddings</span>
                            </a>
                        </li>
                        <li>
                            <a href="gallery.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Gallery</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4 - Newsletter & Social -->
                <div class="space-y-5">
                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#1e3a2f] border-b border-[#8fb89a]/30 pb-2">Stay Connected</h3>
                    
                    <!-- Newsletter Form -->
                    <div class="space-y-3">
                        <p class="text-[#1e3a2f] text-sm">Subscribe to receive exclusive offers and stories.</p>
                        
                        <form class="relative">
                            <input type="email" 
                                   placeholder="Your email address" 
                                   class="w-full px-5 py-3 pr-24 bg-white/70 border border-[#8fb89a]/30 rounded-full text-[#1e3a2f] placeholder:text-[#1e3a2f]/50 focus:outline-none focus:ring-2 focus:ring-[#8fb89a]/50 text-sm backdrop-blur-sm">
                            <button type="submit" 
                                    class="absolute right-1 top-1 bottom-1 px-5 bg-gradient-to-r from-[#8fb89a] to-[#6f9a7a] text-white text-xs uppercase tracking-wider rounded-full hover:from-[#7fa88a] hover:to-[#5f8a6a] transition-all duration-300">
                                Join
                            </button>
                        </form>
                        
                        <p class="text-[10px] text-[#1e3a2f]/70">
                            By subscribing, you agree to our Privacy Policy.
                        </p>
                    </div>
                    
                    <!-- Social Media Icons -->
                    <div class="pt-4">
                        <h4 class="text-xs uppercase tracking-wider text-[#1e3a2f] mb-3">Follow Us</h4>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 rounded-full bg-[#8fb89a]/20 hover:bg-[#8fb89a] flex items-center justify-center transition-all duration-300 group backdrop-blur-sm">
                                <i class="fab fa-instagram text-[#1e3a2f] group-hover:text-white transition-colors"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-[#8fb89a]/20 hover:bg-[#8fb89a] flex items-center justify-center transition-all duration-300 group backdrop-blur-sm">
                                <i class="fab fa-facebook-f text-[#1e3a2f] group-hover:text-white transition-colors"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-[#8fb89a]/20 hover:bg-[#8fb89a] flex items-center justify-center transition-all duration-300 group backdrop-blur-sm">
                                <i class="fab fa-x-twitter text-[#1e3a2f] group-hover:text-white transition-colors"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-[#8fb89a]/20 hover:bg-[#8fb89a] flex items-center justify-center transition-all duration-300 group backdrop-blur-sm">
                                <i class="fab fa-pinterest-p text-[#1e3a2f] group-hover:text-white transition-colors"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer - Legal & Credits -->
            <div class="mt-12 pt-6 border-t border-[#8fb89a]/30 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex flex-wrap gap-5 text-xs text-[#1e3a2f]">
                    <a href="#" class="hover:text-[#8fb89a] transition-colors">Privacy Policy</a>
                    <span class="text-[#8fb89a]/30">|</span>
                    <a href="#" class="hover:text-[#8fb89a] transition-colors">Terms of Service</a>
                    <span class="text-[#8fb89a]/30">|</span>
                    <a href="#" class="hover:text-[#8fb89a] transition-colors">Careers</a>
                    <span class="text-[#8fb89a]/30">|</span>
                    <a href="#" class="hover:text-[#8fb89a] transition-colors">Sitemap</a>
                </div>
                
                <p class="text-xs text-[#1e3a2f]">
                    © 2025 Aora45 Resort & Restaurant. All rights reserved.
                </p>
            </div>
        </div>
        
        <!-- Equal empty space around is created by padding on the light green container -->
        <!-- The container has p-8 md:p-12 lg:p-16 which creates equal space on all sides -->
        
        <!-- Decorative Element - Floating Accent -->
        <div class="absolute -bottom-6 -right-6 w-32 h-32 border border-white/20 rounded-full pointer-events-none"></div>
        <div class="absolute -top-6 -left-6 w-32 h-32 border border-white/20 rounded-full pointer-events-none"></div>
    </div>

    <!-- Styles for Footer -->
    <style>
        /* Light green container with very low opacity to let background show through */
        .bg-\[\#e8f3e9\]\/70 {
            background-color: rgba(232, 243, 233, 0.7);
            backdrop-filter: blur(2px);
        }
        
        /* Smooth hover effects */
        .group:hover i.fa-chevron-right {
            transform: translateX(4px);
        }
        
        /* Newsletter button hover */
        button:hover {
            filter: brightness(1.05);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .grid {
                gap: 2rem;
            }
            
            .bg-\[\#e8f3e9\]\/70 {
                padding: 1.5rem;
            }
        }
        
        /* Ensure text is readable against light background */
        .text-\[\#1e3a2f\] {
            color: #1e3a2f;
        }
        
        /* Custom border color */
        .border-\[\#8fb89a\]\/30 {
            border-color: rgba(143, 184, 154, 0.3);
        }
        
        /* Background image visibility */
        .absolute.inset-0.z-0 img {
            filter: brightness(1.1) saturate(1.05);
        }
    </style>
</footer>
</body>
</html>