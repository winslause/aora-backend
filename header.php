<?php
// Get base path if not defined - works for both localhost and live domain
if (!defined('BASE_PATH')) {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
        $base_path = '/aora-backend/';
    } else {
        $base_path = '/';
    }
    define('BASE_PATH', $base_path);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'AORA45 - Premium Riverfront Destination in Siaya, Kenya'; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'AORA45 - Experience premium riverfront destination in Siaya County, Kenya. Featuring elegant rooms, fine dining restaurant, spa, events venue, and world-class amenities. Book your stay today.'; ?>"">
    <meta name="keywords" content="luxury hotel Siaya, resort Kenya, accommodation Siaya, hotel booking Kenya, pool bar Siaya, wedding venue Kenya, fine dining Siaya, luxury stay, AORA45 resort, best hotels Siaya, riverside hotel Kenya, events venue Siaya, restaurant Siaya, hotel near me Kenya, Kenya resort, luxury accommodation Kenya, hotel with pool Siaya, riverside retreat Kenya, family resort Kenya">
    <meta name="author" content="AORA45 Resort">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://AORA45.com/">
    <meta property="og:title" content="AORA45 - Premium Riverfront Destination in Siaya, Kenya">
    <meta property="og:description" content="Experience luxury at our premium riverfront destination in Siaya County, Kenya. Featuring elegant cottages, pool bar, gazebo lounges, fire pits, and world-class hospitality.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
    <meta property="og:site_name" content="AORA45 Resort">
    <meta property="og:locale" content="en_KE">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="AORA45 - Premium Riverfront Destination in Siaya, Kenya">
    <meta name="twitter:description" content="Experience luxury at our premium riverfront destination in Siaya County, Kenya. Featuring elegant cottages, pool bar, gazebo lounges, fire pits, and world-class hospitality.">
    <meta name="twitter:image" content="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://AORA45.com/">
    <!-- Preconnect to external domains for faster connections -->
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts for Luxury Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&family=Cormorant+Garamond:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Hotel",
        "name": "AORA45 Resort",
        "description": "Experience luxury at our premium riverfront destination in Siaya County, Kenya. Featuring elegant cottages, pool bar, gazebo lounges, fire pits, and world-class hospitality.",
        "url": "https://AORA45.com",
        "telephone": "+254700450450",
        "email": "info@AORA45.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Along River Nyandera",
            "addressLocality": "Siaya",
            "addressRegion": "Siaya County",
            "addressCountry": "KE",
            "postalCode": "40600"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "0.0612",
            "longitude": "34.2881"
        },
        "priceRange": "$$",
        "starRating": {
            "@type": "Rating",
            "ratingValue": "5"
        },
        "reviewRating": {
            "@type": "Rating",
            "ratingValue": "4.9",
            "bestRating": "5",
            "reviewCount": "256"
        },
        "amenityFeature": [
            {"@type": "LocationFeatureSpecification", "name": "Free WiFi", "value": true},
            {"@type": "LocationFeatureSpecification", "name": "Parking", "value": true},
            {"@type": "LocationFeatureSpecification", "name": "Pool", "value": true},
            {"@type": "LocationFeatureSpecification", "name": "Spa", "value": true},
            {"@type": "LocationFeatureSpecification", "name": "Restaurant", "value": true},
            {"@type": "LocationFeatureSpecification", "name": "Room Service", "value": true},
            {"@type": "LocationFeatureSpecification", "name": "Fitness Center", "value": true},
            {"@type": "LocationFeatureSpecification", "name": "24-Hour Front Desk", "value": true},
            {"@type": "LocationFeatureSpecification", "name": "Airport Shuttle", "value": true}
        ],
        "checkinTime": "14:00",
        "checkoutTime": "12:00",
        "paymentAccepted": ["Cash", "Credit Card", "Debit Card", "M-Pesa"],
        "currenciesAccepted": ["KES", "USD"],
        "yearBuilt": "2020",
        "numberOfRooms": 45,
        "numberOfSuites": 15,
        "numberOfFloors": 5,
        "logo": "https://AORA45.com/logo1.jpeg",
        "image": ["https://images.unsplash.com/photo-1542314831-068cd1dbfeeb"],
        "sameAs": [
           "https://www.facebook.com/share/1L93DDaZXR/",
"https://www.instagram.com/aora45resortandrestaurant?igsh=MTV4YXMwN2V1bm9nOQ==",
"https://x.com/m45resort",
"https://www.tiktok.com/@aora45resort?_r=1&_t=ZS-95xdYaYI9n2"
        ]
    }
    </script>
    
    <!-- LocalBusiness JSON-LD for Kenya -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "@id": "https://AORA45.com/#business",
        "name": "AORA45 Resort",
        "image": "https://AORA45.com/logo1.jpeg",
        "url": "https://AORA45.com",
        "telephone": "+254700450450",
        "email": "info@AORA45.com",
        "priceRange": "$",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Siaya",
            "addressRegion": "Siaya County",
            "addressCountry": "KE"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "0.0612",
            "longitude": "34.2881"
        },
        "openingHours": ["Mo-Su 00:00-24:00"],
        "paymentAccepted": ["Cash", "Credit Card", "M-Pesa"],
        "currenciesAccepted": ["KES", "USD"]
    }
    </script>
    
    <!-- Favicon with size -->
    <link rel="icon" type="image/png" href="logo1.jpeg" sizes="32x32">
    <link rel="apple-touch-icon" href="logo1.jpeg">
    
    <!-- Preload critical assets -->
    <link rel="preload" as="image" href="logo1.jpeg">
    
    <!-- Tailwind via CDN - loaded asynchronously -->
    <script src="https://cdn.tailwindcss.com" defer></script>
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
            background: linear-gradient(90deg, transparent, #b8a084, #1e4d40, #b8a084, transparent);
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

        /* Dropdown Menu */
        .nav-dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .nav-dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            min-width: 180px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 8px;
            overflow: hidden;
            z-index: 1000;
            margin-top: 0.5rem;
            border: 1px solid #e8dfd5;
        }

        .nav-dropdown:hover .nav-dropdown-content {
            display: block;
            animation: dropdownFadeIn 0.2s ease-out;
        }

        /* Keep dropdown visible when hovering the content */
        .nav-dropdown::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -15px;
            height: 15px;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        .nav-dropdown-content a {
            color: #5c524a;
            padding: 12px 20px;
            text-decoration: none;
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0.3px;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f5f0eb;
        }

        .nav-dropdown-content a:last-child {
            border-bottom: none;
        }

        .nav-dropdown-content a:hover {
            background: #f8f5f0;
            color: #1e4d40;
            padding-left: 24px;
        }

        .nav-dropdown-content a i {
            margin-right: 10px;
            width: 16px;
            text-align: center;
            color: #b09b88;
        }

        .nav-dropdown-content a:hover i {
            color: #1e4d40;
        }

        .nav-dropdown > .nav-link::after {
            content: '';
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
            color: #1e4d40;
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
            background: linear-gradient(90deg, transparent, #4a90a0, #2d5a4a, #4a90a0, transparent);
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

        /* Center title - Unearth Timeless Luxury at AORA45 */
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
    <!-- Site Preloader -->
    <div id="site-preloader" style="opacity: 1; visibility: visible; display: flex;">
        <div class="preloader-content" style="opacity: 1; visibility: visible; display: flex;">
            <div class="preloader-logo">
                <img src="logo1.jpeg" alt="AORA45" onerror="this.style.display='none'">
            </div>
            <div class="preloader-text">AORA45</div>
            <div class="preloader-subtext">Luxury Resort & Restaurant</div>
            <div class="preloader-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
            <div class="preloader-progress">
                <div class="progress-bar"></div>
            </div>
        </div>
    </div>

    <style>
        /* Preloader Styles - Ocean blue, Earth tones, Warm lighting, Natural greens */
        #site-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0d2b36 0%, #1a3d4d 50%, #1a3d4d 100%);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }

        #site-preloader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .preloader-content {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
        }

        .preloader-logo {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .preloader-logo img {
            height: 80px;
            width: auto;
            filter: drop-shadow(0 4px 20px rgba(232, 168, 73, 0.3));
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .preloader-text {
            font-family: Georgia, serif;
            font-size: 2.5rem;
            color: #e8a849;
            letter-spacing: 0.3em;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 40px rgba(232, 168, 73, 0.4);
        }

        .preloader-subtext {
            font-family: Arial, sans-serif;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.4em;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
        }

        .preloader-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
        }

        .spinner-ring {
            width: 12px;
            height: 12px;
            border: 2px solid rgba(232, 168, 73, 0.2);
            border-top-color: #e8a849;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .spinner-ring:nth-child(2) {
            animation-delay: 0.15s;
        }

        .spinner-ring:nth-child(3) {
            animation-delay: 0.3s;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .preloader-progress {
            width: 200px;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: #e8a849;
            border-radius: 2px;
            width: 0%;
            transition: width 0.3s ease;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hide preloader immediately on mobile for better UX */
        @media (max-width: 768px) {
            .preloader-text {
                font-size: 1.8rem;
                letter-spacing: 0.2em;
            }
            
            .preloader-logo img {
                height: 60px;
            }
        }
    </style>

    <!-- Welcome Popup Modal -->
    <div id="welcomePopup" class="fixed inset-0 z-[99990] hidden">
        <!-- Backdrop -->
        <div class="popup-backdrop absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
            <div class="popup-container bg-gradient-to-br from-[#0d2b36] to-[#1a3d4d] rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-500" style="background: linear-gradient(135deg, #0d2b36 0%, #1a3d4d 50%, #2d4a3e 100%);">
                
                <!-- Header with close button -->
                <div class="flex justify-between items-center p-6 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#e8a849] to-[#c47d2e] flex items-center justify-center" style="background: linear-gradient(135deg, #e8a849 0%, #c47d2e 100%);">
                            <i class="fas fa-spa text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-['Playfair_Display']" style="color: #e8a849;">Welcome to AORA45</h2>
                            <p class="text-white/60 text-sm">Your Luxury Riverfront Destination</p>
                        </div>
                    </div>
                    <button id="popupCloseBtn" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 transition-colors flex items-center justify-center">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>
                
                <!-- Main Content -->
                <div class="p-6">
                    <p class="text-white/80 text-center text-lg mb-8">Experience the epitome of luxury along the serene River Nyandera in Siaya, Kenya.</p>
                    
                    <!-- Feature Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Card 1: Rooms & Suites -->
                        <div class="popup-card group bg-white/5 rounded-xl p-5 border border-white/10 hover:border-[#e8a849]/50 transition-all duration-300 hover:transform hover:-translate-y-1" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #e8a84933 0%, #e8a84911 100%);">
                                    <i class="fas fa-bed text-xl" style="color: #e8a849;"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg mb-1">Elegant Accommodations</h3>
                                    <p class="text-white/60 text-sm">Luxurious rooms and cottages designed for your comfort</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card 2: Fine Dining -->
                        <div class="popup-card group bg-white/5 rounded-xl p-5 border border-white/10 hover:border-[#e8a849]/50 transition-all duration-300 hover:transform hover:-translate-y-1" style="animation-delay: 100ms; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #e8a84933 0%, #e8a84911 100%);">
                                    <i class="fas fa-utensils text-xl" style="color: #e8a849;"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg mb-1">Fine Dining</h3>
                                    <p class="text-white/60 text-sm">Exquisite local and international cuisine</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card 3: Pool & Recreation -->
                        <div class="popup-card group bg-white/5 rounded-xl p-5 border border-white/10 hover:border-[#e8a849]/50 transition-all duration-300 hover:transform hover:-translate-y-1" style="animation-delay: 200ms; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #e8a84933 0%, #e8a84911 100%);">
                                    <i class="fas fa-swimming-pool text-xl" style="color: #e8a849;"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg mb-1">Pool & Pool Bar</h3>
                                    <p class="text-white/60 text-sm">Refreshing dips and tropical cocktails</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card 4: Events -->
                        <div class="popup-card group bg-white/5 rounded-xl p-5 border border-white/10 hover:border-[#e8a849]/50 transition-all duration-300 hover:transform hover:-translate-y-1" style="animation-delay: 300ms; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #e8a84933 0%, #e8a84911 100%);">
                                    <i class="fas fa-glass-cheers text-xl" style="color: #e8a849;"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg mb-1">Events & Celebrations</h3>
                                    <p class="text-white/60 text-sm">Perfect venue for weddings & corporate events</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card 5: Spa & Wellness -->
                        <div class="popup-card group bg-white/5 rounded-xl p-5 border border-white/10 hover:border-[#e8a849]/50 transition-all duration-300 hover:transform hover:-translate-y-1" style="animation-delay: 400ms; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #e8a84933 0%, #e8a84911 100%);">
                                    <i class="fas fa-spa text-xl" style="color: #e8a849;"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg mb-1">Spa & Wellness</h3>
                                    <p class="text-white/60 text-sm">Rejuvenate your body and mind</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card 6: Unique Experiences -->
                        <div class="popup-card group bg-white/5 rounded-xl p-5 border border-white/10 hover:border-[#e8a849]/50 transition-all duration-300 hover:transform hover:-translate-y-1" style="animation-delay: 500ms; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #e8a84933 0%, #e8a84911 100%);">
                                    <i class="fas fa-fire text-xl" style="color: #e8a849;"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg mb-1">Unique Experiences</h3>
                                    <p class="text-white/60 text-sm">Gazebos, fire pits & riverfront views</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center">
                        <a href="<?php echo BASE_PATH; ?>rooms" class="popup-cta inline-flex items-center justify-center gap-2 text-white px-8 py-3 rounded-full font-semibold hover:shadow-lg transition-all transform hover:scale-105" style="background: linear-gradient(135deg, #1e5f74 0%, #145a6e 100%); box-shadow: 0 4px 15px rgba(30, 95, 116, 0.4);">
                            <i class="fas fa-calendar-check"></i>
                            <span>Book Your Stay</span>
                        </a>
                        <a href="<?php echo BASE_PATH; ?>contact" class="popup-cta inline-flex items-center justify-center gap-2 bg-white/10 text-white px-8 py-3 rounded-full font-semibold border border-white/20 hover:bg-white/20 transition-all">
                            <i class="fas fa-phone-alt"></i>
                            <span>Contact Us</span>
                        </a>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="px-6 pb-6 text-center">
                    <p class="text-white/40 text-sm">Follow us on <a href="#" class="hover:underline" style="color: #e8a849;">Instagram</a> & <a href="#" class="hover:underline" style="color: #e8a849;">Facebook</a></p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Popup Styles */
        #welcomePopup {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        #welcomePopup.show {
            opacity: 1;
        }
        
        #welcomePopup.show .popup-container {
            transform: scale(1);
            opacity: 1;
        }
        
        .popup-card {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }
        
        #welcomePopup.show .popup-card {
            opacity: 1;
            transform: translateY(0);
        }
        
        #welcomePopup.show .popup-card:nth-child(1) { transition-delay: 0.1s; }
        #welcomePopup.show .popup-card:nth-child(2) { transition-delay: 0.2s; }
        #welcomePopup.show .popup-card:nth-child(3) { transition-delay: 0.3s; }
        #welcomePopup.show .popup-card:nth-child(4) { transition-delay: 0.4s; }
        #welcomePopup.show .popup-card:nth-child(5) { transition-delay: 0.5s; }
        #welcomePopup.show .popup-card:nth-child(6) { transition-delay: 0.6s; }
        
        .popup-cta {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s ease;
        }
        
        #welcomePopup.show .popup-cta {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.7s;
        }
        
        #welcomePopup.show .popup-cta:nth-child(2) {
            transition-delay: 0.8s;
        }
        
        .popup-backdrop {
            transition: background-color 0.3s ease;
        }
        
        /* Hide popup on mobile if needed */
        @media (max-width: 480px) {
            #welcomePopup .popup-container {
                margin: 1rem;
                max-height: calc(100vh - 2rem);
            }
        }
    </style>

    <script>
        // Popup functionality - Only show on home page
        (function() {
            const popup = document.getElementById('welcomePopup');
            const closeBtn = document.getElementById('popupCloseBtn');
            
            if (!popup || !closeBtn) return;
            
            // Check if this is the home page - simplified logic
            const searchParams = new URLSearchParams(window.location.search);
            const page = searchParams.get('page');
            
            // Show popup only on home page (no page param or page=home)
            const shouldShow = !page || page === 'home' || page === '';
            
            // Check if popup was already shown (localStorage)
            const popupShown = localStorage.getItem('aora45_popup_shown');
            
            // Function to show popup
            function showPopup() {
                popup.classList.remove('hidden');
                // Small delay to allow display:block to apply before adding show class for animation
                setTimeout(function() {
                    popup.classList.add('show');
                }, 10);
            }
            
            // Function to hide popup
            function hidePopup() {
                popup.classList.remove('show');
                setTimeout(function() {
                    popup.classList.add('hidden');
                }, 300);
            }
            
            // Close button click
            closeBtn.addEventListener('click', function() {
                hidePopup();
                // Remember that popup was shown
                localStorage.setItem('aora45_popup_shown', 'true');
            });
            
            // Click outside to close
            popup.addEventListener('click', function(e) {
                if (e.target === popup.querySelector('.popup-backdrop') || e.target === popup.querySelector('.popup-container').parentElement) {
                    hidePopup();
                    localStorage.setItem('aora45_popup_shown', 'true');
                }
            });
            
            // DEBUG: Log popup conditions to console
            console.log('=== Popup Debug Info ===');
            console.log('shouldShow:', shouldShow);
            console.log('popupShown (localStorage):', popupShown);
            console.log('page param:', page);
            console.log('href:', window.location.href);
            
            // Add global function to reset popup for testing
            window.resetPopup = function() {
                localStorage.removeItem('aora45_popup_shown');
                console.log('Popup reset! Refresh the page to see it again.');
                // Show a toast notification instead of alert
                showToast('Popup has been reset! Refresh the page to see it.');
            };
            
            // Toast notification function
            function showToast(message) {
                // Remove existing toast if any
                const existingToast = document.getElementById('toast-notification');
                if (existingToast) existingToast.remove();
                
                const toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.className = 'fixed bottom-4 right-4 z-[99999] bg-[#1e4d40] text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-20 opacity-0 transition-all duration-300';
                toast.innerHTML = '<i class="fas fa-check-circle mr-2 text-[#e8a849]"></i>' + message;
                document.body.appendChild(toast);
                
                // Animate in
                setTimeout(() => {
                    toast.classList.remove('translate-y-20', 'opacity-0');
                }, 10);
                
                // Auto remove after 3 seconds
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
            
            console.log('To reset popup: Run resetPopup() in console or clear localStorage');
            
            // Show popup after preloader hides (only if on home page and not shown before)
            if (shouldShow && !popupShown) {
                // Wait for preloader to hide
                const preloader = document.getElementById('site-preloader');
                
                function checkAndShowPopup() {
                    if (preloader && !preloader.classList.contains('hidden')) {
                        // Preloader still showing, check again soon
                        setTimeout(checkAndShowPopup, 200);
                    } else {
                        // Preloader hidden, show popup after a short delay
                        setTimeout(showPopup, 500);
                    }
                }
                
                // Start checking
                setTimeout(checkAndShowPopup, 500);
            } else if (shouldShow && popupShown) {
                console.log('Popup already shown before. Run resetPopup() to see it again.');
            } else {
                console.log('Popup should NOT show on this page (not home page)');
            }
        })();
    </script>

    <!-- Preloader Script - waits for hero image to load -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('site-preloader');
            const progressBar = document.querySelector('.progress-bar');
            const preloaderContent = document.querySelector('.preloader-content');
            
            if (!preloader) return;

            // Force show preloader content immediately
            if (preloaderContent) {
                preloaderContent.style.opacity = '1';
                preloaderContent.style.visibility = 'visible';
            }

            // Simulate progress while waiting for hero image
            let progress = 0;
            const loadingInterval = setInterval(function() {
                progress += Math.random() * 30 + 10;
                if (progress > 85) progress = 85;
                if (progressBar) {
                    progressBar.style.width = progress + '%';
                }
            }, 100);

            // Hide preloader when hero image loads
            function hidePreloader() {
                clearInterval(loadingInterval);
                if (progressBar) {
                    progressBar.style.width = '100%';
                }
                
                // Short delay to show full progress
                setTimeout(function() {
                    preloader.classList.add('hidden');
                    // Remove from DOM after transition
                    setTimeout(function() {
                        preloader.style.display = 'none';
                    }, 600);
                }, 200);
            }

            // Find hero image and wait for it to load
            // Use setTimeout to ensure body is fully parsed
            setTimeout(function() {
                const heroImages = document.querySelectorAll('.hero-section img, .cinema-image, section:first-of-type img');
                
                if (heroImages.length > 0) {
                    let loadedCount = 0;
                    heroImages.forEach(function(img) {
                        if (img.complete) {
                            loadedCount++;
                        } else {
                            img.addEventListener('load', function() {
                                loadedCount++;
                                if (loadedCount === heroImages.length) {
                                    hidePreloader();
                                }
                            });
                            img.addEventListener('error', function() {
                                // If image fails, count as loaded to prevent stuck preloader
                                loadedCount++;
                                if (loadedCount === heroImages.length) {
                                    hidePreloader();
                                }
                            });
                        }
                    });
                    // If all already loaded
                    if (loadedCount === heroImages.length) {
                        hidePreloader();
                    }
                } else {
                    // Fallback: wait for DOMContentLoaded if no hero image found
                    if (document.readyState === 'complete') {
                        hidePreloader();
                    } else {
                        window.addEventListener('load', hidePreloader);
                    }
                }
                
                // Safety fallback: hide after 3 seconds max
                setTimeout(hidePreloader, 3000);
            }, 100);
        });
    </script>
</head>
<body>
    <!-- Header/Navbar Component -->
    <header class="w-full fixed top-0 left-0 right-0 z-50">
        <!-- Top Bar - very subtle, elegant -->
        <div class="top-bar hidden md:block">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <span class="flex items-center"><i class="fas fa-map-pin mr-2 text-[#b09b88] text-xs"></i> Siaya County, Kenya</span>
                    <span class="flex items-center"><i class="far fa-clock mr-2 text-[#b09b88] text-xs"></i> Check-in: 2PM | Check-out: 12PM</span>
                </div>
                <div class="flex items-center space-x-5">
                    <a href="https://www.instagram.com/aora45resortandrestaurant?igsh=MTV4YXMwN2V1bm9nOQ==" class="hover:text-[#5c4a38] transition-colors" target="_blank">
    <i class="fab fa-instagram"></i>
</a>
<a href="https://www.facebook.com/share/1L93DDaZXR/" class="hover:text-[#5c4a38] transition-colors" target="_blank">
    <i class="fab fa-facebook-f"></i>
</a>
<a href="https://x.com/m45resort" class="hover:text-[#5c4a38] transition-colors" target="_blank">
    <i class="fab fa-x-twitter"></i>
</a>
<a href="https://www.tiktok.com/@aora45resort?_r=1&_t=ZS-95xdYaYI9n2" class="hover:text-[#5c4a38] transition-colors" target="_blank">
    <i class="fab fa-tiktok"></i>
</a>
                    <span class="text-[#b09b88]">|</span>
                    <span class="flex items-center"><i class="fas fa-phone-alt mr-2 text-[#b09b88] text-xs"></i> +254 700 450 450</span>
                </div>
            </div>
        </div>

        <!-- Main Navbar -->
        <nav class="navbar-skeu w-full py-2 md:py-3 relative z-50">
            <div class="nav-container">
                
                <!-- Logo with resort name - left side -->
                <div class="logo-container flex items-center">
                    <img src="logo1.jpeg" alt="AORA45 - Premium Riverfront Destination in Siaya County Kenya" class="h-20 md:h-24 w-auto" loading="eager" decoding="async" width="180" height="96" onerror="this.src='https://placehold.co/180x70/f5efe8/8a735b?text=AORA'">
                    <div class="ml-3">
                        <h1 class="font-['Playfair_Display'] text-3xl md:text-4xl font-medium text-[#4a3f37] tracking-wide">AORA45</h1>
                        <div class="gold-accent"></div>
                        <p class="text-xs tracking-[0.25em] text-[#9a8a78] font-light mt-0.5">RIVERFRONT DESTINATION</p>
                    </div>
                </div>

                <!-- LARGE BLANK SPACE between logo and HOME (as requested) -->
                <div class="nav-spacer"></div>

                <!-- Desktop Navigation - right side with consolidated items -->
                <div class="hidden lg:flex desktop-nav-wrapper">
                    <div class="desktop-nav">
                        <a href="<?php echo BASE_PATH; ?>" class="nav-link active">Home</a>
                        <div class="nav-dropdown">
                            <a href="<?php echo BASE_PATH; ?>rooms" class="nav-link">Accommodation</a>
                            <div class="nav-dropdown-content">
                                <a href="<?php echo BASE_PATH; ?>rooms"><i class="fas fa-bed"></i>Rooms</a>
                            </div>
                        </div>
                        <div class="nav-dropdown">
                            <a href="<?php echo BASE_PATH; ?>restaurant" class="nav-link">Restaurant</a>
                            <div class="nav-dropdown-content">
                                <a href="<?php echo BASE_PATH; ?>restaurant"><i class="fas fa-utensils"></i>Our Menu</a>
                                <a href="<?php echo BASE_PATH; ?>amenities"><i class="fas fa-spa"></i>Amenities</a>
                                <a href="<?php echo BASE_PATH; ?>offers"><i class="fas fa-tag"></i>Offers</a>
                                <a href="<?php echo BASE_PATH; ?>gallery"><i class="fas fa-images"></i>Gallery</a>
                            </div>
                        </div>
                        <a href="<?php echo BASE_PATH; ?>events" class="nav-link">Events</a>
                        <div class="nav-dropdown">
                            <a href="<?php echo BASE_PATH; ?>contact" class="nav-link">Contact</a>
                            <div class="nav-dropdown-content">
                                <a href="<?php echo BASE_PATH; ?>contact"><i class="fas fa-envelope"></i>Contact Us</a>
                                <a href="<?php echo BASE_PATH; ?>about"><i class="fas fa-info-circle"></i>About Us</a>
                            </div>
                        </div>
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
                    <a href="<?php echo BASE_PATH; ?>" class="mobile-nav-link"><i class="fas fa-home"></i>Home</a>
                    <a href="<?php echo BASE_PATH; ?>rooms" class="mobile-nav-link"><i class="fas fa-bed"></i>Rooms & Suites</a>
                    <a href="<?php echo BASE_PATH; ?>restaurant" class="mobile-nav-link"><i class="fas fa-utensils"></i>Restaurant</a>
                    <a href="<?php echo BASE_PATH; ?>amenities" class="mobile-nav-link"><i class="fas fa-spa"></i>Amenities</a>
                    <a href="<?php echo BASE_PATH; ?>gallery" class="mobile-nav-link"><i class="fas fa-images"></i>Gallery</a>
                    <a href="<?php echo BASE_PATH; ?>events" class="mobile-nav-link"><i class="fas fa-glass-cheers"></i>Events</a>
                    <a href="<?php echo BASE_PATH; ?>offers" class="mobile-nav-link"><i class="fas fa-tag"></i>Offers</a>
                    <a href="<?php echo BASE_PATH; ?>about" class="mobile-nav-link"><i class="fas fa-info-circle"></i>About</a>
                    <a href="<?php echo BASE_PATH; ?>contact" class="mobile-nav-link"><i class="fas fa-envelope"></i>Contact</a>
                    
                    <!-- Mobile menu extras -->
                    <div class="mt-4 pt-4 border-t border-[#eee7e0] px-4">
                        <div class="flex items-center justify-between text-sm text-[#7a6b5e] mb-3">
                            <span><i class="fas fa-phone-alt mr-2 text-[#b09b88]"></i>+254 700 450 450</span>
                            <span><i class="fas fa-envelope mr-2 text-[#b09b88]"></i>info@AORA45.com</span>
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




