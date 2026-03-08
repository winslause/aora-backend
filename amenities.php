<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora - Unparalleled Amenities</title>
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: #fcf8f3;
        }
        
        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.02); }
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
        
        @keyframes expandWidth {
            0% { width: 0; }
            100% { width: 60px; }
        }
        
        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
        
        .animate-float-slow {
            animation: float-slow 12s ease-in-out infinite;
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
        
        /* Amenity item styles - no cards */
        .amenity-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            height: 280px;
            border: 1px solid transparent;
            transition: all 0.5s ease;
        }
        
        .amenity-item:hover {
            border-color: rgba(184, 154, 120, 0.3);
        }
        
        .amenity-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            filter: brightness(0.8);
        }
        
        .amenity-item:hover .amenity-image {
            transform: scale(1.08);
            filter: brightness(1);
        }
        
        .amenity-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent 70%);
            opacity: 0.8;
            transition: opacity 0.5s ease;
        }
        
        .amenity-item:hover .amenity-overlay {
            opacity: 0.95;
        }
        
        .amenity-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem 1.5rem;
            transform: translateY(20px);
            transition: transform 0.5s ease;
            z-index: 10;
        }
        
        .amenity-item:hover .amenity-content {
            transform: translateY(0);
        }
        
        .amenity-icon {
            width: 50px;
            height: 50px;
            background: rgba(184, 154, 120, 0.2);
            border: 1px solid rgba(184, 154, 120, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .amenity-item:hover .amenity-icon {
            background: rgba(184, 154, 120, 0.4);
            border-color: #b89a78;
        }
        
        .amenity-icon i {
            color: #b89a78;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .amenity-item:hover .amenity-icon i {
            color: #fff;
            transform: scale(1.1);
        }
        
        .amenity-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 0.25rem;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }
        
        .amenity-brief {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            line-height: 1.5;
            max-height: 0;
            opacity: 0;
            transition: all 0.5s ease;
            overflow: hidden;
        }
        
        .amenity-item:hover .amenity-brief {
            max-height: 60px;
            opacity: 1;
            margin-top: 0.5rem;
        }
        
        /* Category title with line animation */
        .category-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            color: #2c3e4a;
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }
        
        .category-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 0;
            height: 2px;
            background: #b89a78;
            transition: width 0.8s ease;
        }
        
        .category-title:hover::after {
            width: 100%;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
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
            max-width: 1100px;
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
        
        /* Gallery styles for modal */
        .modal-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 1rem;
        }
        
        .modal-gallery img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.8;
        }
        
        .modal-gallery img:hover {
            opacity: 1;
            transform: scale(1.05);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.3);
        }
        
        /* Feature list */
        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px dashed rgba(184, 154, 120, 0.2);
        }
        
        .feature-item:last-child {
            border-bottom: none;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(184, 154, 120, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .feature-icon i {
            color: #b89a78;
            font-size: 1.2rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .amenity-item {
                height: 220px;
            }
            
            .amenity-title {
                font-size: 1.5rem;
            }
            
            .category-title {
                font-size: 2rem;
            }
            
            .modal-gallery {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#fcf8f3]">
    <main class="relative">
        <!-- ===== HERO SECTION ===== -->
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <!-- Background Image - Luxury Resort Amenities -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2080&q=80" 
                     alt="Luxury Resort Amenities" 
                     class="w-full h-full object-cover animate-drift">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/70"></div>
            </div>
            
            <!-- Floating Orbs - Subtle -->
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
                    <span class="block reveal-left" style="transition-delay: 0.2s;">Unparalleled</span>
                    <span class="block reveal-right text-[#b89a78]" style="transition-delay: 0.4s;">Amenities</span>
                </h1>
                
                <!-- Decorative Element -->
                <div class="relative flex justify-center items-center gap-4 mb-12">
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                    <i class="fas fa-spa text-[#b89a78] text-xl"></i>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                </div>
                
                <!-- Subheading -->
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 max-w-2xl mx-auto italic leading-relaxed reveal" style="transition-delay: 0.6s;">
                    "Every desire anticipated. Every moment elevated."
                </p>
                
                <!-- Scroll Indicator -->
                <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex flex-col items-center gap-2">
                    <span class="text-white/60 text-xs uppercase tracking-widest">Discover</span>
                    <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                        <div class="w-1 h-2 bg-white/60 rounded-full mt-2 animate-bounce"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== WELLNESS SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Category Title -->
                <div class="mb-12 reveal-left">
                    <h2 class="category-title">Wellness</h2>
                    <p class="text-[#8a735b] text-sm max-w-2xl">Rejuvenate your body and soul in our sanctuary of wellbeing.</p>
                </div>
                
                <!-- Amenities Grid - No Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Spa -->
                    <div class="amenity-item reveal" style="transition-delay: 0.1s;" onclick="openModal('spa')">
                        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Spa" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-spa"></i>
                            </div>
                            <h3 class="amenity-title">The Sanctuary Spa</h3>
                            <p class="amenity-brief">Traditional Kenyan treatments, steam rooms, and relaxation areas</p>
                        </div>
                    </div>
                    
                    <!-- Fitness Pavilion -->
                    <div class="amenity-item reveal" style="transition-delay: 0.2s;" onclick="openModal('fitness')">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Fitness Pavilion" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-dumbbell"></i>
                            </div>
                            <h3 class="amenity-title">Fitness Pavilion</h3>
                            <p class="amenity-brief">State-of-the-art equipment with personal training available</p>
                        </div>
                    </div>
                    
                    <!-- Sauna -->
                    <div class="amenity-item reveal" style="transition-delay: 0.3s;" onclick="openModal('sauna')">
                        <img src="https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Sauna" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-hot-tub"></i>
                            </div>
                            <h3 class="amenity-title">Finnish Sauna</h3>
                            <p class="amenity-brief">Traditional dry sauna with cold plunge pool</p>
                        </div>
                    </div>
                    
                    <!-- Yoga Pavilion -->
                    <div class="amenity-item reveal" style="transition-delay: 0.4s;" onclick="openModal('yoga')">
                        <img src="https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Yoga Pavilion" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-om"></i>
                            </div>
                            <h3 class="amenity-title">Yoga Pavilion</h3>
                            <p class="amenity-brief">Daily classes overlooking the gardens</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== LEISURE SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#f4ede5] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Category Title -->
                <div class="mb-12 reveal-left">
                    <h2 class="category-title">Leisure</h2>
                    <p class="text-[#8a735b] text-sm max-w-2xl">Where relaxation meets recreation in breathtaking settings.</p>
                </div>
                
                <!-- Amenities Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Infinity Pool -->
                    <div class="amenity-item reveal" style="transition-delay: 0.1s;" onclick="openModal('pool')">
                        <img src="https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Infinity Pool" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-water"></i>
                            </div>
                            <h3 class="amenity-title">Infinity Pool</h3>
                            <p class="amenity-brief">Overlooking Nairobi's skyline with poolside service</p>
                        </div>
                    </div>
                    
                    <!-- Private Beach -->
                    <div class="amenity-item reveal" style="transition-delay: 0.2s;" onclick="openModal('beach')">
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2073&q=80" 
                             alt="Private Beach" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-umbrella-beach"></i>
                            </div>
                            <h3 class="amenity-title">Private Beach</h3>
                            <p class="amenity-brief">Exclusive lakefront access with cabanas</p>
                        </div>
                    </div>
                    
                    <!-- Game Room -->
                    <div class="amenity-item reveal" style="transition-delay: 0.3s;" onclick="openModal('game')">
                        <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                             alt="Game Room" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-gamepad"></i>
                            </div>
                            <h3 class="amenity-title">The Game Room</h3>
                            <p class="amenity-brief">Billiards, table tennis, and classic arcade games</p>
                        </div>
                    </div>
                    
                    <!-- Library -->
                    <div class="amenity-item reveal" style="transition-delay: 0.4s;" onclick="openModal('library')">
                        <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Library" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h3 class="amenity-title">The Reading Room</h3>
                            <p class="amenity-brief">Curated collection of African literature and art books</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== BUSINESS & EVENTS SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Category Title -->
                <div class="mb-12 reveal-left">
                    <h2 class="category-title">Business & Events</h2>
                    <p class="text-[#8a735b] text-sm max-w-2xl">Exceptional spaces for productive meetings and memorable celebrations.</p>
                </div>
                
                <!-- Amenities Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Conference Halls -->
                    <div class="amenity-item reveal" style="transition-delay: 0.1s;" onclick="openModal('conference')">
                        <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" 
                             alt="Conference Halls" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3 class="amenity-title">Conference Halls</h3>
                            <p class="amenity-brief">Multiple venues with capacity up to 200 guests</p>
                        </div>
                    </div>
                    
                    <!-- Business Center -->
                    <div class="amenity-item reveal" style="transition-delay: 0.2s;" onclick="openModal('business-center')">
                        <img src="https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" 
                             alt="Business Center" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h3 class="amenity-title">Business Center</h3>
                            <p class="amenity-brief">Private workstations, printing, and high-speed internet</p>
                        </div>
                    </div>
                    
                    <!-- Banquet Spaces -->
                    <div class="amenity-item reveal" style="transition-delay: 0.3s;" onclick="openModal('banquet')">
                        <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Banquet Spaces" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-glass-cheers"></i>
                            </div>
                            <h3 class="amenity-title">Banquet Spaces</h3>
                            <p class="amenity-brief">Elegant venues for weddings and galas</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== SERVICES SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#f4ede5] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Category Title -->
                <div class="mb-12 reveal-left">
                    <h2 class="category-title">Services</h2>
                    <p class="text-[#8a735b] text-sm max-w-2xl">Thoughtful touches that make your stay effortless.</p>
                </div>
                
                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- 24/7 Concierge -->
                    <div class="amenity-item reveal" style="transition-delay: 0.1s;" onclick="openModal('concierge')">
                        <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Concierge" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                            <h3 class="amenity-title">24/7 Concierge</h3>
                            <p class="amenity-brief">Your wishes, our command, anytime day or night</p>
                        </div>
                    </div>
                    
                    <!-- Airport Transfers -->
                    <div class="amenity-item reveal" style="transition-delay: 0.2s;" onclick="openModal('airport')">
                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Airport Transfers" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <h3 class="amenity-title">Airport Transfers</h3>
                            <p class="amenity-brief">Luxury vehicles with professional drivers</p>
                        </div>
                    </div>
                    
                    <!-- Laundry -->
                    <div class="amenity-item reveal" style="transition-delay: 0.3s;" onclick="openModal('laundry')">
                        <img src="https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                             alt="Laundry" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <h3 class="amenity-title">Laundry Service</h3>
                            <p class="amenity-brief">Same-day service with eco-friendly products</p>
                        </div>
                    </div>
                    
                    <!-- Free WiFi -->
                    <div class="amenity-item reveal" style="transition-delay: 0.4s;" onclick="openModal('wifi')">
                        <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Free WiFi" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas fa-wifi"></i>
                            </div>
                            <h3 class="amenity-title">Free WiFi</h3>
                            <p class="amenity-brief">High-speed internet throughout the property</p>
                        </div>
                    </div>
                </div>
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
                    "At Aora, every amenity is thoughtfully designed to elevate your stay—because true luxury is in the details."
                </p>
                
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto mt-8"></div>
            </div>
        </section>
    </main>

    <!-- ===== MODAL ===== -->
    <div id="amenityModal" class="modal">
        <div class="modal-content mx-auto my-8 p-8 relative">
            <!-- Close Button -->
            <button onclick="closeModal()" class="absolute top-4 right-4 w-10 h-10 bg-[#b89a78] text-white rounded-full flex items-center justify-center hover:bg-[#8a735b] transition-all z-10">
                <i class="fas fa-times"></i>
            </button>
            
            <!-- Modal Content will be dynamically loaded -->
            <div id="modalContent"></div>
        </div>
    </div>

    <!-- Amenity Data -->
    <script>
        const amenityData = {
            spa: {
                name: 'The Sanctuary Spa',
                description: 'A haven of tranquility inspired by ancient Kenyan healing traditions.',
                longDescription: 'Our award-winning spa offers a journey of sensory renewal. Drawing from traditional Swahili and Maasai wellness practices, each treatment is designed to restore balance and harmony.',
                features: [
                    '6 treatment rooms including couples suite',
                    'Traditional Kenyan massage techniques',
                    'Organic, locally-sourced products',
                    'Steam room and sauna',
                    'Relaxation lounge with herbal teas',
                    'Private outdoor meditation garden'
                ],
                hours: 'Daily 9:00 AM - 9:00 PM',
                phone: 'Extension 7301',
                image: 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1600334129128-685c5582fd35?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1540555700478-4be289fbe518?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1600334109169-5f31d8289c2a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1600334089842-5b3a9d4f8f8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1600334129128-685c5582fd35?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            fitness: {
                name: 'Fitness Pavilion',
                description: 'State-of-the-art fitness center with panoramic views.',
                longDescription: 'Our spacious fitness pavilion features the latest equipment from Technogym, offering everything from cardio to strength training. Personal trainers are available for customized workout plans.',
                features: [
                    'Cardio cinema with personal screens',
                    'Strength training area',
                    'Free weights up to 50kg',
                    'Yoga mats and accessories',
                    'Personal training available',
                    'Complimentary towels and water'
                ],
                hours: 'Open 24/7',
                phone: 'Extension 7302',
                image: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1540496905036-5937c10647cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1570829460005-c840387bb1ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1532384748853-8f54a8f476e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            sauna: {
                name: 'Finnish Sauna',
                description: 'Traditional dry sauna experience.',
                longDescription: 'Experience the authentic Finnish sauna tradition. Our cedar-lined sauna reaches the perfect temperature for deep relaxation, followed by a refreshing plunge in the cold pool.',
                features: [
                    'Traditional dry sauna (80-100°C)',
                    'Cold plunge pool',
                    'Relaxation lounge',
                    'Herbal tea station',
                    'Outdoor cooling area',
                    'Private changing rooms'
                ],
                hours: 'Daily 7:00 AM - 10:00 PM',
                phone: 'Extension 7303',
                image: 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1600334129128-685c5582fd35?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            yoga: {
                name: 'Yoga Pavilion',
                description: 'Find your balance in nature.',
                longDescription: 'Our open-air yoga pavilion overlooks the lush gardens, providing the perfect setting for morning sun salutations or evening restorative practice. Join our daily classes or book a private session.',
                features: [
                    'Daily group classes',
                    'Private sessions available',
                    'All mats and props provided',
                    'Meditation cushions',
                    'Outdoor deck with garden views',
                    'Workshops with guest teachers'
                ],
                hours: 'Classes: 7:30 AM & 5:30 PM',
                phone: 'Extension 7304',
                image: 'https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1593811167562-9cef47bfc4d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80',
                    'https://images.unsplash.com/photo-1575052814086-f385e2e2ad1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            pool: {
                name: 'Infinity Pool',
                description: 'Skyline views meet serene waters.',
                longDescription: 'Perched overlooking Nairobi\'s skyline, our infinity pool offers a breathtaking setting for relaxation. Lounge on sunbeds, enjoy poolside service, or take a refreshing dip at sunset.',
                features: [
                    'Heated infinity edge pool',
                    'Sun loungers and cabanas',
                    'Poolside food and beverage service',
                    'Towels and sunscreen provided',
                    'Adult-only hours 4-6 PM',
                    'Evening swim-up events'
                ],
                hours: 'Daily 7:00 AM - 9:00 PM',
                phone: 'Extension 7305',
                image: 'https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2080&q=80'
                ]
            },
            beach: {
                name: 'Private Beach',
                description: 'Exclusive lakefront paradise.',
                longDescription: 'Escape to our private beach, a tranquil oasis away from the city. With powdery sand, clear waters, and attentive service, it\'s the perfect spot for a day of relaxation.',
                features: [
                    'Private cabanas with waiter service',
                    'Water sports equipment available',
                    'Beach bar serving cocktails',
                    'Fresh towel service',
                    'Sunset bonfires on request',
                    'Complimentary sunscreen'
                ],
                hours: 'Daily 8:00 AM - 6:00 PM',
                phone: 'Extension 7306',
                image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2073&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2073&q=80',
                    'https://images.unsplash.com/photo-1590523278191-995cbcda646b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            game: {
                name: 'The Game Room',
                description: 'Fun and games for all ages.',
                longDescription: 'Our game room is the perfect place to unwind and have fun. Challenge friends to billiards, test your skills at table tennis, or enjoy classic arcade games.',
                features: [
                    'Professional billiards table',
                    'Table tennis',
                    'Classic arcade machines',
                    'Board games collection',
                    'Large screen for sports',
                    'Snack and beverage bar'
                ],
                hours: 'Daily 10:00 AM - 11:00 PM',
                phone: 'Extension 7307',
                image: 'https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                    'https://images.unsplash.com/photo-1522252234503-e356532cafd5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2025&q=80',
                    'https://images.unsplash.com/photo-1589578527966-3895e6e46b9f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            library: {
                name: 'The Reading Room',
                description: 'A quiet sanctuary for book lovers.',
                longDescription: 'Our curated library offers a peaceful retreat with a focus on African literature, art, and culture. Comfortable seating, natural light, and a selection of teas create the perfect reading environment.',
                features: [
                    'Curated collection of 2,000+ books',
                    'Focus on African authors',
                    'Art and photography volumes',
                    'Daily newspapers',
                    'Comfortable reading chairs',
                    'Complimentary tea and coffee'
                ],
                hours: 'Daily 8:00 AM - 10:00 PM',
                phone: 'Extension 7308',
                image: 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            conference: {
                name: 'Conference Halls',
                description: 'Professional spaces for productive meetings.',
                longDescription: 'Our versatile conference halls are equipped with the latest technology and can accommodate events from intimate board meetings to large conferences. Our dedicated events team ensures every detail is perfect.',
                features: [
                    'Multiple venues (20-200 capacity)',
                    'High-speed WiFi',
                    'Built-in AV equipment',
                    'Natural light in all rooms',
                    'Customizable layouts',
                    'Catering available'
                ],
                hours: 'By arrangement',
                phone: 'Extension 7309',
                image: 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80',
                    'https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80',
                    'https://images.unsplash.com/photo-1431540015161-0bf86838fb31?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            'business-center': {
                name: 'Business Center',
                description: 'Everything you need to stay productive.',
                longDescription: 'Our fully equipped business center provides a professional environment for getting work done. From private workstations to printing services, we have you covered.',
                features: [
                    'Private workstations',
                    'High-speed printing and scanning',
                    'Conference call facilities',
                    'Secretarial services available',
                    'Complimentary coffee and tea',
                    'Office supplies available'
                ],
                hours: 'Open 24/7',
                phone: 'Extension 7310',
                image: 'https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80',
                    'https://images.unsplash.com/photo-1497215842964-222b430dc094?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1504384764586-bb4cdc1707b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            banquet: {
                name: 'Banquet Spaces',
                description: 'Celebrate in style.',
                longDescription: 'From intimate gatherings to grand celebrations, our elegant banquet spaces provide the perfect backdrop. Our culinary team creates custom menus, and our event planners handle every detail.',
                features: [
                    'Multiple venues with various capacities',
                    'Custom catering menus',
                    'Dedicated event coordinator',
                    'Built-in sound and lighting',
                    'Dance floor available',
                    'Valet parking for guests'
                ],
                hours: 'By arrangement',
                phone: 'Extension 7311',
                image: 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1555244162-803834f70033?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            concierge: {
                name: '24/7 Concierge',
                description: 'Your personal assistant, always available.',
                longDescription: 'Our dedicated concierge team is available around the clock to fulfill your requests—whether arranging dinner reservations, booking excursions, or securing hard-to-get tickets.',
                features: [
                    'Restaurant reservations',
                    'Excursion and tour bookings',
                    'Transportation arrangements',
                    'Special occasion planning',
                    'Spa appointment scheduling',
                    'Local recommendations'
                ],
                hours: '24 hours, 7 days a week',
                phone: 'Extension 0 or 7312',
                image: 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            airport: {
                name: 'Airport Transfers',
                description: 'Luxury transportation to and from the airport.',
                longDescription: 'Begin and end your journey in comfort with our professional airport transfer service. Our fleet of luxury vehicles and experienced drivers ensure a seamless experience.',
                features: [
                    'Luxury sedan and SUV options',
                    'Professional, uniformed drivers',
                    'Meet and greet service',
                    'Complimentary bottled water',
                    'Real-time flight tracking',
                    'Child seats available'
                ],
                hours: 'Available 24/7 (advance booking required)',
                phone: 'Extension 7313',
                image: 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1568605117036-5fe5e7fa0ce2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1556189250-72ba954cfc2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            laundry: {
                name: 'Laundry Service',
                description: 'Impeccable care for your garments.',
                longDescription: 'Our professional laundry and dry cleaning service ensures your clothes receive the same attention to detail as every other aspect of your stay. Same-day service available.',
                features: [
                    'Same-day service (request before 10 AM)',
                    'Dry cleaning available',
                    'Pressing service',
                    'Eco-friendly products',
                    'Garment bags provided',
                    'Delicate item specialists'
                ],
                hours: 'Daily 7:00 AM - 7:00 PM',
                phone: 'Extension 7314',
                image: 'https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                    'https://images.unsplash.com/photo-1582735689369-4fe89db7114c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582735689369-4fe89db7114c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            wifi: {
                name: 'Complimentary WiFi',
                description: 'Stay connected throughout your stay.',
                longDescription: 'High-speed wireless internet is available throughout the property, from your room to the pool deck. Perfect for streaming, video calls, or catching up on work.',
                features: [
                    'High-speed fiber connection',
                    'Coverage throughout property',
                    'Multiple device connections',
                    'Secure network',
                    'No data caps',
                    'Technical support available'
                ],
                hours: '24/7',
                phone: 'Extension 7315 for assistance',
                image: 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1573164713988-2485fc5648d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80',
                    'https://images.unsplash.com/photo-1573164713988-2485fc5648d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80'
                ]
            }
        };

        function openModal(amenityKey) {
            const amenity = amenityData[amenityKey];
            if (!amenity) return;
            
            const modal = document.getElementById('amenityModal');
            const modalContent = document.getElementById('modalContent');
            
            // Generate gallery HTML
            const galleryHTML = amenity.gallery.map(img => `
                <img src="${img}" alt="${amenity.name}" onclick="this.parentNode.previousElementSibling.src = this.src">
            `).join('');
            
            modalContent.innerHTML = `
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Left Column - Gallery -->
                    <div>
                        <img id="modalMainImage" src="${amenity.image}" alt="${amenity.name}" class="w-full h-[300px] object-cover mb-4">
                        <div class="modal-gallery">
                            ${galleryHTML}
                        </div>
                    </div>
                    
                    <!-- Right Column - Details -->
                    <div>
                        <h2 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-2">${amenity.name}</h2>
                        <div class="w-12 h-px bg-[#b89a78] mb-4"></div>
                        
                        <p class="text-[#5c524a] text-lg mb-4">${amenity.description}</p>
                        <p class="text-[#8a735b] text-sm mb-6 leading-relaxed">${amenity.longDescription}</p>
                        
                        <!-- Key Info -->
                        <div class="mb-6 p-4 bg-[#f4ede5]">
                            <div class="flex items-center gap-3 mb-3">
                                <i class="fas fa-clock text-[#b89a78]"></i>
                                <span class="text-[#5c524a] text-sm">${amenity.hours}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-phone-alt text-[#b89a78]"></i>
                                <span class="text-[#5c524a] text-sm">${amenity.phone}</span>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <h3 class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a] mb-3">Features</h3>
                        <div class="space-y-1 mb-6">
                            ${amenity.features.map(feature => `
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span class="text-[#5c524a] text-sm">${feature}</span>
                                </div>
                            `).join('')}
                        </div>
                        
                        <!-- Reserve/Inquiry Button -->
                        <button onclick="inquireAmenity('${amenity.name}')" class="w-full py-4 bg-[#b89a78] text-white hover:bg-[#8a735b] transition-colors">
                            Inquire About This Amenity
                        </button>
                    </div>
                </div>
            `;
            
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            const modal = document.getElementById('amenityModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
        
        function inquireAmenity(amenityName) {
            alert(`Thank you for your interest in ${amenityName}. A member of our concierge team will contact you shortly.`);
            closeModal();
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('amenityModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
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