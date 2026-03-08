<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora - Luxury Resort & Restaurant</title>
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts for Luxury Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Custom skeuomorphic styles - refined, elegant, less 3D */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5efe8;  /* Soft cream background */
            font-family: 'Montserrat', sans-serif;
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
            flex: 2;  /* Increased from 1 to 2 for more space */
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
        }
    </style>
</head>
<body class="min-h-screen" style="background: #f5efe8;">

<!-- Header/Navbar Component -->
<header class="w-full">
    <!-- Top Bar - very subtle, elegant -->
    <div class="top-bar hidden md:block">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <span class="flex items-center"><i class="fas fa-map-pin mr-2 text-[#b09b88] text-xs"></i> 123 Ocean Drive, Maldives</span>
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
                <img src="logo1.png" alt="Aora Resort" class="h-12 md:h-14 w-auto" onerror="this.src='https://placehold.co/180x70/f5efe8/8a735b?text=AORA'">
                <div class="ml-3">
                    <h1 class="font-['Playfair_Display'] text-2xl md:text-3xl font-medium text-[#4a3f37] tracking-wide">AORA</h1>
                    <div class="gold-accent"></div>
                    <p class="text-[0.6rem] tracking-[0.25em] text-[#9a8a78] font-light mt-0.5">RESORT & RESTAURANT</p>
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
                        <span><i class="fas fa-phone-alt mr-2 text-[#b09b88]"></i>+960 123-4567</span>
                        <span><i class="fas fa-envelope mr-2 text-[#b09b88]"></i>info@aora.com</span>
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

<!-- Simple script for toggler animation -->
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

<!-- Demo content to show spacing -->
<div class="container mx-auto px-6 py-16">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="font-['Playfair_Display'] text-4xl md:text-5xl font-light text-[#3f352e] mb-4">Elegance Redefined</h2>
        <div class="w-20 h-px bg-[#d4b48c] mx-auto mb-6"></div>
        <p class="text-[#6b5d51] text-lg leading-relaxed">Experience the perfect harmony of luxury and tranquility. Our refined aesthetic speaks to the discerning traveler.</p>
    </div>
</div>

<!-- Space for footer -->
<div class="h-32"></div>

</body>
</html>