<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora - A Visual Journey</title>
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@200;300;400;500&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <!-- Lightbox2 for gallery modal (optional but adds nice modal) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
            background: #fcf8f3;
        }
        
        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        
        @keyframes pulse-soft {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.05); }
        }
        
        @keyframes drift {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, 1%) rotate(1deg); }
            66% { transform: translate(-1%, 2%) rotate(-1deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        @keyframes rotateSlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes scaleIn {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
        
        .animate-pulse-soft {
            animation: pulse-soft 6s ease-in-out infinite;
        }
        
        .animate-drift {
            animation: drift 15s ease-in-out infinite;
        }
        
        .animate-rotate-slow {
            animation: rotateSlow 30s linear infinite;
        }
        
        .shimmer-text {
            background: linear-gradient(90deg, transparent, rgba(212, 180, 140, 0.2), transparent);
            background-size: 200% 100%;
            animation: shimmer 4s infinite;
        }
        
        /* Reveal animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        .reveal-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }
        
        .reveal-right {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f0e7dd;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #b89a78;
            border-radius: 4px;
        }
        
        /* Filter Button Styles */
        .filter-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .filter-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(184, 154, 120, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }
        
        .filter-btn:hover::before {
            width: 200px;
            height: 200px;
        }
        
        .filter-btn.active {
            background: #b89a78;
            color: white;
            border-color: #b89a78;
        }
        
        /* Masonry Grid */
        .masonry-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .masonry-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.5s ease;
            opacity: 1;
            transform: scale(1);
            animation: scaleIn 0.5s ease forwards;
        }
        
        .masonry-item.hide {
            opacity: 0;
            transform: scale(0.8);
            pointer-events: none;
            position: absolute;
        }
        
        .masonry-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .masonry-item:hover img {
            transform: scale(1.08);
        }
        
        /* Unique Card Design - Floating Film Strip Style */
        .gallery-card {
            position: relative;
            background: white;
            padding: 12px;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            border: 1px solid rgba(184, 154, 120, 0.2);
        }
        
        .gallery-card::before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 1px dashed rgba(184, 154, 120, 0.3);
            pointer-events: none;
            transition: all 0.3s ease;
        }
        
        .gallery-card:hover {
            transform: translateY(-8px) rotate(0.5deg);
            box-shadow: 0 30px 50px -15px rgba(0,0,0,0.3);
        }
        
        .gallery-card:hover::before {
            border-color: rgba(184, 154, 120, 0.6);
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
        }
        
        .gallery-card .card-image {
            position: relative;
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .gallery-card .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }
        
        .gallery-card:hover .card-overlay {
            opacity: 1;
        }
        
        .gallery-card .card-title {
            font-family: 'Cormorant Garamond', serif;
            color: white;
            font-size: 1.2rem;
            transform: translateY(10px);
            transition: transform 0.4s ease;
        }
        
        .gallery-card:hover .card-title {
            transform: translateY(0);
        }
        
        .gallery-card .film-perforation {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 8px;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 5px,
                rgba(184, 154, 120, 0.2) 5px,
                rgba(184, 154, 120, 0.2) 10px
            );
        }
        
        .gallery-card .film-perforation.left {
            left: 0;
        }
        
        .gallery-card .film-perforation.right {
            right: 0;
        }
        
        /* Album Cover - Unique Design */
        .album-cover {
            position: relative;
            height: 300px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.5s ease;
        }
        
        .album-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }
        
        .album-cover:hover img {
            transform: scale(1.1);
        }
        
        .album-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(44,62,74,0.9) 0%, rgba(44,62,74,0.7) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0.9;
            transition: opacity 0.4s ease;
        }
        
        .album-cover:hover .album-overlay {
            opacity: 1;
        }
        
        .album-icon {
            width: 70px;
            height: 70px;
            border: 2px solid rgba(184, 154, 120, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            transition: all 0.4s ease;
        }
        
        .album-cover:hover .album-icon {
            border-color: #b89a78;
            transform: scale(1.1);
        }
        
        .album-icon i {
            color: #b89a78;
            font-size: 1.8rem;
        }
        
        .album-title {
            font-family: 'Cormorant Garamond', serif;
            color: white;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .album-count {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            letter-spacing: 0.1em;
        }
        
        /* Video Section */
        .video-container {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(184, 154, 120, 0.3);
        }
        
        .video-container::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 1px dashed rgba(184, 154, 120, 0.3);
            pointer-events: none;
            z-index: 10;
        }
        
        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: rgba(184, 154, 120, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s ease;
            z-index: 20;
        }
        
        .play-button:hover {
            transform: translate(-50%, -50%) scale(1.1);
            background: #b89a78;
        }
        
        .play-button i {
            color: white;
            font-size: 2rem;
            margin-left: 5px;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .modal.show {
            display: flex;
            opacity: 1;
        }
        
        .modal-content {
            background: #fcf8f3;
            max-width: 1200px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.95) translateY(20px);
            transition: all 0.4s ease;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.6);
        }
        
        .modal.show .modal-content {
            transform: scale(1) translateY(0);
        }
        
        /* Album Modal Gallery */
        .album-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 1rem;
        }
        
        .album-gallery-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            border: 1px solid rgba(184, 154, 120, 0.2);
            transition: all 0.3s ease;
        }
        
        .album-gallery-item:hover {
            transform: scale(1.03);
            border-color: #b89a78;
        }
        
        .album-gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .album-gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .album-gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            padding: 1rem;
            transform: translateY(100%);
            transition: transform 0.4s ease;
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.9rem;
        }
        
        .album-gallery-item:hover .album-gallery-caption {
            transform: translateY(0);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .masonry-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .masonry-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            
            .album-gallery {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .album-title {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .masonry-grid {
                grid-template-columns: 1fr;
            }
            
            .album-gallery {
                grid-template-columns: 1fr;
            }
            
            .play-button {
                width: 60px;
                height: 60px;
            }
            
            .play-button i {
                font-size: 1.5rem;
            }
        }
        
        /* Masonry item size variations */
        .masonry-item.wide {
            grid-column: span 2;
        }
        
        .masonry-item.tall {
            grid-row: span 2;
        }
        
        .masonry-item.large {
            grid-column: span 2;
            grid-row: span 2;
        }
    </style>
</head>
<body class="min-h-screen bg-[#fcf8f3]">
    <main class="relative">
        <!-- ===== HERO SECTION ===== -->
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <!-- Background Image - Stunning Resort Aerial -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Aora Resort Aerial View" 
                     class="w-full h-full object-cover animate-drift">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/70"></div>
            </div>
            
            <!-- Floating Orbs -->
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-[#b89a78]/20 rounded-full blur-3xl animate-pulse-soft"></div>
            <div class="absolute bottom-1/3 right-1/4 w-96 h-96 bg-[#8a735b]/20 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 2s;"></div>
            
            <!-- Content -->
            <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
                <!-- Decorative Line -->
                <div class="flex justify-center mb-8">
                    <div class="w-24 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent animate-pulse"></div>
                </div>
                
                <!-- Main Heading -->
                <h1 class="font-['DM_Serif_Display'] text-6xl md:text-7xl lg:text-8xl text-white mb-6 drop-shadow-2xl tracking-wide">
                    <span class="block reveal-left" style="transition-delay: 0.2s;">A Visual</span>
                    <span class="block reveal-right text-[#b89a78]" style="transition-delay: 0.4s;">Journey</span>
                </h1>
                
                <!-- Decorative Element -->
                <div class="relative flex justify-center items-center gap-4 mb-12">
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                    <i class="fas fa-camera text-[#b89a78] text-xl"></i>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                </div>
                
                <!-- Subheading -->
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 max-w-2xl mx-auto italic leading-relaxed reveal" style="transition-delay: 0.6s;">
                    "Moments captured. Memories that last forever."
                </p>
                
                <!-- Scroll Indicator -->
                <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex flex-col items-center gap-2">
                    <span class="text-white/60 text-xs uppercase tracking-widest">Explore</span>
                    <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                        <div class="w-1 h-2 bg-white/60 rounded-full mt-2 animate-bounce"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== ALBUMS SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Collections</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Our Albums</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Albums Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Album 1 - Rooms -->
                    <div class="album-cover reveal" style="transition-delay: 0.1s;" onclick="openAlbum('rooms')">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Rooms Album">
                        <div class="album-overlay">
                            <div class="album-icon">
                                <i class="fas fa-bed"></i>
                            </div>
                            <h3 class="album-title">Rooms & Suites</h3>
                            <p class="album-count">12 photos</p>
                        </div>
                    </div>
                    
                    <!-- Album 2 - Restaurant -->
                    <div class="album-cover reveal" style="transition-delay: 0.2s;" onclick="openAlbum('restaurant')">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Restaurant Album">
                        <div class="album-overlay">
                            <div class="album-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <h3 class="album-title">Restaurant</h3>
                            <p class="album-count">10 photos</p>
                        </div>
                    </div>
                    
                    <!-- Album 3 - Amenities -->
                    <div class="album-cover reveal" style="transition-delay: 0.3s;" onclick="openAlbum('amenities')">
                        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Amenities Album">
                        <div class="album-overlay">
                            <div class="album-icon">
                                <i class="fas fa-spa"></i>
                            </div>
                            <h3 class="album-title">Amenities</h3>
                            <p class="album-count">14 photos</p>
                        </div>
                    </div>
                    
                    <!-- Album 4 - Surroundings -->
                    <div class="album-cover reveal" style="transition-delay: 0.4s;" onclick="openAlbum('surroundings')">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Surroundings Album">
                        <div class="album-overlay">
                            <div class="album-icon">
                                <i class="fas fa-mountain"></i>
                            </div>
                            <h3 class="album-title">Surroundings</h3>
                            <p class="album-count">8 photos</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FILTER BUTTONS ===== -->
        <section class="py-12 px-6 bg-[#f4ede5] overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-wrap justify-center gap-3 reveal">
                    <button class="filter-btn active px-6 py-3 border border-[#b89a78] text-sm uppercase tracking-wider rounded-full" data-filter="all">All</button>
                    <button class="filter-btn px-6 py-3 border border-[#b89a78]/30 text-sm uppercase tracking-wider rounded-full hover:bg-[#b89a78] hover:text-white transition-all" data-filter="rooms">Rooms</button>
                    <button class="filter-btn px-6 py-3 border border-[#b89a78]/30 text-sm uppercase tracking-wider rounded-full hover:bg-[#b89a78] hover:text-white transition-all" data-filter="restaurant">Restaurant</button>
                    <button class="filter-btn px-6 py-3 border border-[#b89a78]/30 text-sm uppercase tracking-wider rounded-full hover:bg-[#b89a78] hover:text-white transition-all" data-filter="amenities">Amenities</button>
                    <button class="filter-btn px-6 py-3 border border-[#b89a78]/30 text-sm uppercase tracking-wider rounded-full hover:bg-[#b89a78] hover:text-white transition-all" data-filter="surroundings">Surroundings</button>
                </div>
            </div>
        </section>

        <!-- ===== MASONRY IMAGE GRID ===== -->
        <section class="relative py-16 px-6 bg-[#fcf8f3] overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <!-- Masonry Grid -->
                <div class="masonry-grid" id="galleryGrid">
                    
                    <!-- Rooms Category Images (with unique card design) -->
                    <div class="masonry-item gallery-card" data-category="rooms">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Deluxe Room" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Deluxe Room with King Bed')">
                            <div class="card-overlay">
                                <h4 class="card-title">Deluxe Room</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Room 101 • King Bed</p>
                    </div>
                    
                    <div class="masonry-item gallery-card wide" data-category="rooms">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Executive Suite" 
                                 class="w-full h-80 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Executive Suite Living Area')">
                            <div class="card-overlay">
                                <h4 class="card-title">Executive Suite</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Suite 205 • Separate Living Area</p>
                    </div>
                    
                    <div class="masonry-item gallery-card tall" data-category="rooms">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Presidential Villa" 
                                 class="w-full h-96 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Presidential Villa Bedroom')">
                            <div class="card-overlay">
                                <h4 class="card-title">Presidential Villa</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Villa 1 • Private Terrace</p>
                    </div>
                    
                    <div class="masonry-item gallery-card" data-category="rooms">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80" 
                                 alt="Family Villa" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80', 'Family Villa Living Room')">
                            <div class="card-overlay">
                                <h4 class="card-title">Family Villa</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Villa 3 • Garden View</p>
                    </div>
                    
                    <!-- Restaurant Category Images -->
                    <div class="masonry-item gallery-card" data-category="restaurant">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Main Dining Room" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Main Dining Room')">
                            <div class="card-overlay">
                                <h4 class="card-title">Main Dining Room</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Fine Dining • 80 Seats</p>
                    </div>
                    
                    <div class="masonry-item gallery-card wide" data-category="restaurant">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80" 
                                 alt="Chef's Table" 
                                 class="w-full h-80 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80', 'Chef\'s Table Experience')">
                            <div class="card-overlay">
                                <h4 class="card-title">Chef's Table</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Intimate Dining • 6 Guests</p>
                    </div>
                    
                    <div class="masonry-item gallery-card tall" data-category="restaurant">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" 
                                 alt="Nyama Choma" 
                                 class="w-full h-96 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'Nyama Choma - Signature Dish')">
                            <div class="card-overlay">
                                <h4 class="card-title">Nyama Choma</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Signature Dish • Grilled Perfection</p>
                    </div>
                    
                    <div class="masonry-item gallery-card" data-category="restaurant">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Private Dining" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Private Dining Room')">
                            <div class="card-overlay">
                                <h4 class="card-title">Private Dining</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Exclusive • 16 Guests</p>
                    </div>
                    
                    <!-- Amenities Category Images -->
                    <div class="masonry-item gallery-card" data-category="amenities">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Spa" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'The Sanctuary Spa')">
                            <div class="card-overlay">
                                <h4 class="card-title">Sanctuary Spa</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Wellness • Treatment Rooms</p>
                    </div>
                    
                    <div class="masonry-item gallery-card wide" data-category="amenities">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Infinity Pool" 
                                 class="w-full h-80 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Infinity Pool')">
                            <div class="card-overlay">
                                <h4 class="card-title">Infinity Pool</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Leisure • City Views</p>
                    </div>
                    
                    <div class="masonry-item gallery-card" data-category="amenities">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Fitness Pavilion" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Fitness Pavilion')">
                            <div class="card-overlay">
                                <h4 class="card-title">Fitness Pavilion</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">24/7 • State-of-the-art</p>
                    </div>
                    
                    <div class="masonry-item gallery-card tall" data-category="amenities">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Yoga Pavilion" 
                                 class="w-full h-96 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Yoga Pavilion')">
                            <div class="card-overlay">
                                <h4 class="card-title">Yoga Pavilion</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Daily Classes • Garden Views</p>
                    </div>
                    
                    <!-- Surroundings Category Images -->
                    <div class="masonry-item gallery-card" data-category="surroundings">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Sunset" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Sunset Over Nairobi')">
                            <div class="card-overlay">
                                <h4 class="card-title">Nairobi Sunset</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Evening Views</p>
                    </div>
                    
                    <div class="masonry-item gallery-card" data-category="surroundings">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Landscape" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Kenyan Landscape')">
                            <div class="card-overlay">
                                <h4 class="card-title">Kenyan Landscape</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Surrounding Beauty</p>
                    </div>
                    
                    <div class="masonry-item gallery-card wide" data-category="surroundings">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Wildlife" 
                                 class="w-full h-80 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Local Wildlife')">
                            <div class="card-overlay">
                                <h4 class="card-title">Local Wildlife</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Giraffes in the Wild</p>
                    </div>
                    
                    <div class="masonry-item gallery-card" data-category="surroundings">
                        <div class="film-perforation left"></div>
                        <div class="film-perforation right"></div>
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Sunset Ocean" 
                                 class="w-full h-64 object-cover"
                                 onclick="openLightbox('https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'Ocean Sunset')">
                            <div class="card-overlay">
                                <h4 class="card-title">Indian Ocean</h4>
                            </div>
                        </div>
                        <p class="text-[#8a735b] text-xs px-2 pb-2">Coastal Views</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FEATURED VIDEO SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#f4ede5] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-5xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-12 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Featured</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">The Aora Experience</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Video Container -->
                <div class="video-container relative aspect-video w-full reveal">
                    <!-- Thumbnail Image (will be replaced by iframe on play) -->
                    <img id="videoThumbnail" src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                         alt="Video Thumbnail" 
                         class="w-full h-full object-cover">
                    
                    <!-- Play Button -->
                    <div class="play-button" onclick="playVideo()">
                        <i class="fas fa-play"></i>
                    </div>
                    
                    <!-- Video iframe (hidden initially) -->
                    <iframe id="videoPlayer" class="absolute inset-0 w-full h-full hidden" 
                            src="" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                
                <!-- Video Caption -->
                <p class="text-center text-[#8a735b] text-sm mt-4 italic reveal" style="transition-delay: 0.2s;">
                    Experience the magic of Aora—where luxury meets the wild heart of Kenya.
                </p>
            </div>
        </section>

        <!-- ===== CLOSING NOTE ===== -->
        <section class="relative py-20 px-6 bg-[#2c3e4a] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-3xl mx-auto relative z-10 text-center">
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto mb-8"></div>
                
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 italic leading-relaxed">
                    "Every image tells a story. Every moment becomes a memory."
                </p>
                
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto mt-8"></div>
            </div>
        </section>
    </main>

    <!-- ===== ALBUM MODAL ===== -->
    <div id="albumModal" class="modal">
        <div class="modal-content mx-auto my-8 p-8 relative">
            <!-- Close Button -->
            <button onclick="closeAlbumModal()" class="absolute top-4 right-4 w-10 h-10 bg-[#b89a78] text-white rounded-full flex items-center justify-center hover:bg-[#8a735b] transition-all z-10">
                <i class="fas fa-times"></i>
            </button>
            
            <!-- Modal Content will be dynamically loaded -->
            <div id="albumModalContent"></div>
        </div>
    </div>

    <!-- Lightbox script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    
    <script>
        // Album data
        const albumData = {
            rooms: {
                title: 'Rooms & Suites',
                description: 'Experience luxury and comfort in our carefully designed accommodations.',
                photos: [
                    { src: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Deluxe Room with King Bed' },
                    { src: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Executive Suite Living Area' },
                    { src: 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Presidential Villa Bedroom' },
                    { src: 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80', caption: 'Family Villa Living Room' },
                    { src: 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Garden View Room' },
                    { src: 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Honeymoon Suite' },
                    { src: 'https://images.unsplash.com/photo-1522778526097-ce0a22ceb253?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Business Suite' },
                    { src: 'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', caption: 'Sky Penthouse' },
                    { src: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Suite Bathroom' },
                    { src: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Room Details' },
                    { src: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Suite View' },
                    { src: 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Villa Terrace' }
                ]
            },
            restaurant: {
                title: 'Restaurant',
                description: 'Culinary artistry in an elegant setting.',
                photos: [
                    { src: 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Main Dining Room' },
                    { src: 'https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80', caption: "Chef's Table" },
                    { src: 'https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', caption: 'Nyama Choma' },
                    { src: 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Private Dining' },
                    { src: 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Swahili Pilau' },
                    { src: 'https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Coastal Seafood' },
                    { src: 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Samaki wa Kupaka' },
                    { src: 'https://images.unsplash.com/photo-1604411245846-3a7035a6b2e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Mandazi & Chai' },
                    { src: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2127&q=80', caption: 'Tropical Fruits' },
                    { src: 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', caption: 'Garden Terrace' }
                ]
            },
            amenities: {
                title: 'Amenities',
                description: 'World-class facilities for your relaxation and enjoyment.',
                photos: [
                    { src: 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Sanctuary Spa' },
                    { src: 'https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Infinity Pool' },
                    { src: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Fitness Pavilion' },
                    { src: 'https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Yoga Pavilion' },
                    { src: 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Sauna' },
                    { src: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2073&q=80', caption: 'Private Beach' },
                    { src: 'https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', caption: 'Game Room' },
                    { src: 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Library' },
                    { src: 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', caption: 'Conference Hall' },
                    { src: 'https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', caption: 'Business Center' },
                    { src: 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Banquet Space' },
                    { src: 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Concierge' },
                    { src: 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Airport Transfer' },
                    { src: 'https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', caption: 'Laundry Service' }
                ]
            },
            surroundings: {
                title: 'Surroundings',
                description: 'The natural beauty that surrounds Aora.',
                photos: [
                    { src: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Sunset Over Nairobi' },
                    { src: 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Kenyan Landscape' },
                    { src: 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Local Wildlife' },
                    { src: 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Ocean Sunset' },
                    { src: 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', caption: 'Safari Adventure' },
                    { src: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2068&q=80', caption: 'Traditional Village' },
                    { src: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Forest Trail' },
                    { src: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', caption: 'Mountain View' }
                ]
            }
        };

        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                const filter = this.dataset.filter;
                
                // Filter masonry items
                document.querySelectorAll('.masonry-item').forEach(item => {
                    if (filter === 'all' || item.dataset.category === filter) {
                        item.classList.remove('hide');
                    } else {
                        item.classList.add('hide');
                    }
                });
                
                // Re-layout masonry grid (simple refresh)
                const grid = document.getElementById('galleryGrid');
                grid.style.opacity = '0';
                setTimeout(() => {
                    grid.style.opacity = '1';
                }, 100);
            });
        });

        // Open lightbox function (for gallery images)
        function openLightbox(src, caption) {
            // You can implement a custom lightbox or use the existing one
            // For simplicity, we'll use Lightbox2 if available
            if (window.lightbox) {
                window.lightbox.open({
                    href: src,
                    title: caption
                });
            } else {
                // Fallback - open in new tab
                window.open(src, '_blank');
            }
        }

        // Open album modal
        function openAlbum(albumKey) {
            const album = albumData[albumKey];
            if (!album) return;
            
            const modal = document.getElementById('albumModal');
            const modalContent = document.getElementById('albumModalContent');
            
            // Generate gallery HTML
            const galleryHTML = album.photos.map(photo => `
                <div class="album-gallery-item" onclick="openLightbox('${photo.src}', '${photo.caption}')">
                    <img src="${photo.src}" alt="${photo.caption}">
                    <div class="album-gallery-caption">${photo.caption}</div>
                </div>
            `).join('');
            
            modalContent.innerHTML = `
                <div>
                    <h2 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-2">${album.title}</h2>
                    <div class="w-12 h-px bg-[#b89a78] mb-4"></div>
                    <p class="text-[#5c524a] text-sm mb-8">${album.description}</p>
                    
                    <div class="album-gallery">
                        ${galleryHTML}
                    </div>
                </div>
            `;
            
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeAlbumModal() {
            const modal = document.getElementById('albumModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Video play function
        function playVideo() {
            const thumbnail = document.getElementById('videoThumbnail');
            const player = document.getElementById('videoPlayer');
            const playBtn = document.querySelector('.play-button');
            
            // Hide thumbnail and play button
            thumbnail.style.display = 'none';
            playBtn.style.display = 'none';
            
            // Show and play video (using YouTube embed as example)
            player.classList.remove('hidden');
            player.src = 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1'; // Replace with actual resort video
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAlbumModal();
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('albumModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAlbumModal();
            }
        });

        // Reveal on scroll
        function reveal() {
            const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
            
            for (let i = 0; i < reveals.length; i++) {
                const windowHeight = window.innerHeight;
                const elementTop = reveals[i].getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add('active');
                }
            }
        }
        
        window.addEventListener('scroll', reveal);
        window.addEventListener('load', reveal);
    </script>
</body>
</html>