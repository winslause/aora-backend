<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora - Rooms & Suites</title>
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
            background: #f5efe8;
        }
        
        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }
        
        @keyframes pulse-soft {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.05); }
        }
        
        @keyframes slideIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
        
        .animate-pulse-soft {
            animation: pulse-soft 6s ease-in-out infinite;
        }
        
        .shimmer-text {
            background: linear-gradient(90deg, transparent, rgba(212, 180, 140, 0.3), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
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
            background: #d4b48c;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #b89a78;
        }
        
        /* Filter Button Styles */
        .filter-btn {
            transition: all 0.3s ease;
        }
        
        .filter-btn.active {
            background: #d4b48c;
            color: white;
            border-color: #d4b48c;
        }
        
        /* Room Card Styles - No Box Shadow */
        .room-card {
            transition: all 0.4s ease;
            background: white;
            border: 1px solid rgba(212, 180, 140, 0.2);
        }
        
        .room-card:hover {
            transform: translateY(-8px);
            border-color: rgba(212, 180, 140, 0.4);
        }
        

        .view-button {
            opacity: 0;
            transform: translate(-50%, 10px);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(212, 180, 140, 0.3);
        }
        
        .view-button:hover, .room-card:hover .view-button {
            background: #d4b48c;
            color: white;
            transform: translate(-50%, 0);
            opacity: 1;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modal.show {
            display: flex;
            opacity: 1;
        }
        
        .modal-content {
            background: #f5efe8;
            max-width: 1200px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 24px;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        
        .modal.show .modal-content {
            transform: scale(1);
        }
        
        /* Image Gallery Styles */
        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 16px;
            transition: opacity 0.5s ease;
        }
        
        .thumbnail-container {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding: 12px 0;
            scrollbar-width: thin;
            scrollbar-color: #d4b48c #f0e7dd;
        }
        
        .thumbnail-container::-webkit-scrollbar {
            height: 4px;
        }
        
        .thumbnail-container::-webkit-scrollbar-track {
            background: #f0e7dd;
            border-radius: 4px;
        }
        
        .thumbnail-container::-webkit-scrollbar-thumb {
            background: #d4b48c;
            border-radius: 4px;
        }
        
        .thumbnail {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .thumbnail:hover {
            transform: scale(1.05);
        }
        
        .thumbnail.active {
            border-color: #d4b48c;
            transform: scale(1.05);
        }
        
        /* Auto-carousel animation */
        @keyframes autoSlide {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .carousel-auto {
            animation: autoSlide 5s ease-in-out infinite;
        }
        
        /* Form Styles */
        .availability-form input,
        .availability-form select,
        .availability-form textarea {
            border: 1px solid rgba(212, 180, 140, 0.3);
            transition: all 0.3s ease;
        }
        
        .availability-form input:focus,
        .availability-form select:focus,
        .availability-form textarea:focus {
            border-color: #d4b48c;
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 180, 140, 0.2);
        }
        
        .availability-form button {
            background: #d4b48c;
            transition: all 0.3s ease;
        }
        
        .availability-form button:hover {
            background: #b89a78;
            transform: translateY(-2px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .main-image {
                height: 250px;
            }
            
            .thumbnail {
                width: 70px;
                height: 50px;
            }
            
            .modal-content {
                width: 98%;
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#f5efe8]">
    <main class="relative">
        <!-- ===== HERO SECTION ===== -->
        <section class="relative h-[60vh] md:h-[70vh] flex items-center justify-center overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Luxury Suite" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-transparent"></div>
            </div>
            
            <!-- Floating Orbs -->
            <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-[#d4b48c]/20 rounded-full blur-3xl animate-pulse-soft"></div>
            <div class="absolute bottom-1/3 right-1/4 w-96 h-96 bg-[#b89a78]/20 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 2s;"></div>
            
            <!-- Content -->
            <div class="relative z-10 text-left px-6 max-w-7xl mx-auto w-full">
                <div class="max-w-3xl">
                    <!-- Breadcrumb -->
                    <div class="flex items-center gap-2 text-white/60 text-sm mb-4 reveal-left">
                        <span>Home</span>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="text-[#d4b48c]">Rooms & Suites</span>
                    </div>
                    
                    <!-- Main Heading -->
                    <h1 class="font-['DM_Serif_Display'] text-6xl md:text-7xl lg:text-8xl text-white mb-6 drop-shadow-2xl reveal-left" style="transition-delay: 0.2s;">
                        Rooms &<br>
                        <span class="text-[#d4b48c]">Suites</span>
                    </h1>
                    
                    <!-- Decorative Line -->
                    <div class="w-24 h-1 bg-gradient-to-r from-[#d4b48c] to-transparent mb-6 reveal-left" style="transition-delay: 0.3s;"></div>
                    
                    <!-- Subheading -->
                    <p class="font-['Cormorant_Garamond'] text-xl md:text-2xl text-white/90 max-w-xl leading-relaxed reveal-left" style="transition-delay: 0.4s;">
                        Where every stay becomes a story—discover your perfect sanctuary in the heart of Nairobi.
                    </p>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex flex-col items-center gap-2">
                <span class="text-white/60 text-xs uppercase tracking-widest">Explore</span>
                <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div class="w-1 h-2 bg-white/60 rounded-full mt-2 animate-bounce"></div>
                </div>
            </div>
        </section>

        <!-- ===== FILTER BAR SECTION ===== -->
        <section class="py-12 px-6 bg-[#f5efe8]">
            <div class="max-w-7xl mx-auto">
                <!-- Filter Bar -->
                <div class="flex flex-wrap items-center justify-between gap-6 p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-[#d4b48c]/20 reveal">
                    <!-- Filter by View -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[#8a735b] text-xs uppercase tracking-wider mb-2">View</label>
                        <div class="flex flex-wrap gap-2">
                            <button class="filter-btn active px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all">All</button>
                            <button class="filter-btn px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all">Garden</button>
                            <button class="filter-btn px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all">Pool</button>
                            <button class="filter-btn px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all">City</button>
                        </div>
                    </div>
                    
                    <!-- Filter by Bed Type -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[#8a735b] text-xs uppercase tracking-wider mb-2">Bed Type</label>
                        <div class="flex flex-wrap gap-2">
                            <button class="filter-btn active px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all">All</button>
                            <button class="filter-btn px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all">King</button>
                            <button class="filter-btn px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all">Queen</button>
                            <button class="filter-btn px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all">Twin</button>
                        </div>
                    </div>
                    
                    <!-- Sort by Price -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[#8a735b] text-xs uppercase tracking-wider mb-2">Sort by</label>
                        <select class="w-full px-4 py-2 bg-white border border-[#d4b48c]/30 rounded-full text-sm focus:outline-none focus:border-[#d4b48c]">
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Most Popular</option>
                            <option>Newest</option>
                        </select>
                    </div>
                    
                    <!-- Reset Button -->
                    <button class="px-6 py-2 text-sm text-[#8a735b] hover:text-[#d4b48c] transition-colors">
                        <i class="fas fa-redo-alt mr-2"></i>Reset
                    </button>
                </div>
            </div>
        </section>

        <!-- ===== ROOM CATEGORY LISTINGS ===== -->
        <section class="py-16 px-6 bg-[#f5efe8]">
            <div class="max-w-7xl mx-auto">
                <!-- Room Count -->
                <div class="flex justify-between items-center mb-8 reveal">
                    <p class="text-[#8a735b] text-sm">Showing <span class="font-semibold text-[#d4b48c]">8</span> rooms</p>
                    <div class="flex gap-2">
                        <button class="w-10 h-10 rounded-full border border-[#d4b48c]/30 flex items-center justify-center hover:bg-[#d4b48c] hover:text-white transition-all">
                            <i class="fas fa-grid-2"></i>
                        </button>
                        <button class="w-10 h-10 rounded-full border border-[#d4b48c]/30 flex items-center justify-center hover:bg-[#d4b48c] hover:text-white transition-all">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Rooms Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    <!-- Room 1 - Deluxe Room -->
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: 0.1s;">
                        <!-- Image Container -->
                        <div class="relative h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Deluxe Room" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            
                            <!-- View Button (Glossy) -->
                            <button onclick="openModal('deluxe')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                            
                            <!-- Room Badge -->
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs text-[#3f352e]">
                                <i class="fas fa-star text-[#d4b48c] mr-1"></i> Best Seller
                            </div>
                        </div>
                        
                        <!-- Room Details -->
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">Deluxe Room</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh 35K</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <!-- Quick Specs -->
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> 2 Guests</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> 45 m²</span>
                                <span><i class="fas fa-bed mr-1"></i> King</span>
                            </div>
                            
                            <!-- Amenities Preview -->
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                <i class="fas fa-wifi" title="Free WiFi"></i>
                                <i class="fas fa-snowflake" title="Air Conditioning"></i>
                                <i class="fas fa-tv" title="Smart TV"></i>
                                <i class="fas fa-coffee" title="Coffee Maker"></i>
                                <i class="fas fa-bath" title="Rain Shower"></i>
                            </div>
                            
                            <!-- Book Button -->
                            <button onclick="openModal('deluxe')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                    
                    <!-- Room 2 - Executive Suite -->
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: 0.2s;">
                        <div class="relative h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Executive Suite" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <button onclick="openModal('executive')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">Executive Suite</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh 55K</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> 2 Guests</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> 65 m²</span>
                                <span><i class="fas fa-bed mr-1"></i> King</span>
                            </div>
                            
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                <i class="fas fa-wifi"></i>
                                <i class="fas fa-snowflake"></i>
                                <i class="fas fa-tv"></i>
                                <i class="fas fa-glass-cheers"></i>
                                <i class="fas fa-bath"></i>
                            </div>
                            
                            <button onclick="openModal('executive')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                    
                    <!-- Room 3 - Family Villa -->
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: 0.3s;">
                        <div class="relative h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80" 
                                 alt="Family Villa" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <button onclick="openModal('family')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">Family Villa</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh 75K</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> 4 Guests</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> 95 m²</span>
                                <span><i class="fas fa-bed mr-1"></i> 2 King</span>
                            </div>
                            
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                <i class="fas fa-wifi"></i>
                                <i class="fas fa-snowflake"></i>
                                <i class="fas fa-tv"></i>
                                <i class="fas fa-utensils"></i>
                                <i class="fas fa-bath"></i>
                            </div>
                            
                            <button onclick="openModal('family')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                    
                    <!-- Room 4 - Presidential Villa -->
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: 0.4s;">
                        <div class="relative h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Presidential Villa" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <button onclick="openModal('presidential')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">Presidential Villa</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh 150K</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> 6 Guests</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> 200 m²</span>
                                <span><i class="fas fa-bed mr-1"></i> 3 King</span>
                            </div>
                            
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                <i class="fas fa-wifi"></i>
                                <i class="fas fa-snowflake"></i>
                                <i class="fas fa-tv"></i>
                                <i class="fas fa-champagne-glasses"></i>
                                <i class="fas fa-hot-tub"></i>
                            </div>
                            
                            <button onclick="openModal('presidential')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                    
                    <!-- Room 5 - Garden View Room -->
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: 0.5s;">
                        <div class="relative h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Garden View Room" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <button onclick="openModal('garden')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">Garden View</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh 30K</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> 2 Guests</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> 35 m²</span>
                                <span><i class="fas fa-bed mr-1"></i> Queen</span>
                            </div>
                            
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                <i class="fas fa-wifi"></i>
                                <i class="fas fa-snowflake"></i>
                                <i class="fas fa-tv"></i>
                                <i class="fas fa-leaf"></i>
                                <i class="fas fa-bath"></i>
                            </div>
                            
                            <button onclick="openModal('garden')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                    
                    <!-- Room 6 - Honeymoon Suite -->
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: 0.6s;">
                        <div class="relative h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Honeymoon Suite" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <button onclick="openModal('honeymoon')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">Honeymoon Suite</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh 65K</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> 2 Guests</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> 55 m²</span>
                                <span><i class="fas fa-bed mr-1"></i> King</span>
                            </div>
                            
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                <i class="fas fa-wifi"></i>
                                <i class="fas fa-snowflake"></i>
                                <i class="fas fa-tv"></i>
                                <i class="fas fa-heart"></i>
                                <i class="fas fa-champagne-glasses"></i>
                            </div>
                            
                            <button onclick="openModal('honeymoon')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                    
                    <!-- Room 7 - Business Suite -->
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: 0.7s;">
                        <div class="relative h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1522778526097-ce0a22ceb253?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Business Suite" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <button onclick="openModal('business')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">Business Suite</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh 45K</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> 2 Guests</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> 50 m²</span>
                                <span><i class="fas fa-bed mr-1"></i> King</span>
                            </div>
                            
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                <i class="fas fa-wifi"></i>
                                <i class="fas fa-snowflake"></i>
                                <i class="fas fa-tv"></i>
                                <i class="fas fa-laptop"></i>
                                <i class="fas fa-phone"></i>
                            </div>
                            
                            <button onclick="openModal('business')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                    
                    <!-- Room 8 - Penthouse -->
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: 0.8s;">
                        <div class="relative h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1536376072261-38c75010e6c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                                 alt="Penthouse" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <button onclick="openModal('penthouse')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">Sky Penthouse</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh 200K</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> 4 Guests</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> 150 m²</span>
                                <span><i class="fas fa-bed mr-1"></i> 2 King</span>
                            </div>
                            
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                <i class="fas fa-wifi"></i>
                                <i class="fas fa-snowflake"></i>
                                <i class="fas fa-tv"></i>
                                <i class="fas fa-hot-tub"></i>
                                <i class="fas fa-wine-glass-alt"></i>
                            </div>
                            
                            <button onclick="openModal('penthouse')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Load More -->
                <div class="text-center mt-16 reveal">
                    <button class="group px-10 py-4 border-2 border-[#d4b48c] text-[#d4b48c] rounded-full hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                        <span class="flex items-center gap-2">
                            <span>Load More Rooms</span>
                            <i class="fas fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
                        </span>
                    </button>
                </div>
            </div>
        </section>

        <!-- ===== MODAL ===== -->
        <div id="roomModal" class="modal">
            <div class="modal-content mx-auto my-8 p-6 relative">
                <!-- Close Button -->
                <button onclick="closeModal()" class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-[#d4b48c] hover:text-white transition-all z-10">
                    <i class="fas fa-times"></i>
                </button>
                
                <!-- Modal Content will be dynamically loaded -->
                <div id="modalContent"></div>
            </div>
        </div>
    </main>

    <!-- Room Data -->
    <script>
        const roomData = {
            deluxe: {
                name: 'Deluxe Room',
                price: 'KSh 35,000',
                description: 'Experience elegance in our Deluxe Room, featuring contemporary design with warm earth tones. Perfect for the discerning traveler seeking comfort and style.',
                size: '45 m²',
                occupancy: '2 Adults',
                bedType: 'King',
                view: 'Garden',
                amenities: ['Free WiFi', 'Air Conditioning', 'Smart TV', 'Coffee Maker', 'Rain Shower', 'Mini Bar', 'Room Safe', 'Bathrobe & Slippers'],
                images: [
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            executive: {
                name: 'Executive Suite',
                price: 'KSh 55,000',
                description: 'Our Executive Suite offers spacious luxury with a separate living area, perfect for business travelers or those seeking extra space.',
                size: '65 m²',
                occupancy: '2 Adults',
                bedType: 'King',
                view: 'Pool',
                amenities: ['Separate Living Room', 'Panoramic Views', 'Executive Lounge Access', 'Work Desk', 'Espresso Machine', 'Bathrobe & Slippers', 'Premium Toiletries', 'Evening Turndown'],
                images: [
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            family: {
                name: 'Family Villa',
                price: 'KSh 75,000',
                description: 'Perfect for families, our villa offers two bedrooms, a private garden, and all the comforts of home in a luxurious setting.',
                size: '95 m²',
                occupancy: '4 Adults + 2 Children',
                bedType: '2 King',
                view: 'Garden',
                amenities: ['Two Bedrooms', 'Private Garden', 'Full Kitchen', 'Living Room', 'Children\'s Play Area', 'Outdoor Dining', 'BBQ Facilities', 'Laundry Service'],
                images: [
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            presidential: {
                name: 'Presidential Villa',
                price: 'KSh 150,000',
                description: 'The pinnacle of luxury. Our Presidential Villa offers unmatched elegance with panoramic views, personal butler service, and exquisite furnishings.',
                size: '200 m²',
                occupancy: '6 Adults',
                bedType: '3 King',
                view: 'Ocean',
                amenities: ['Private Terrace', 'Butler Service', 'Jacuzzi', 'Dining Room', 'Wine Cellar', 'Steam Room', 'Home Theater', 'Private Check-in'],
                images: [
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            garden: {
                name: 'Garden View Room',
                price: 'KSh 30,000',
                description: 'Wake up to lush garden views in this serene room, designed for nature lovers seeking tranquility.',
                size: '35 m²',
                occupancy: '2 Adults',
                bedType: 'Queen',
                view: 'Garden',
                amenities: ['Garden View', 'Queen Bed', 'Private Balcony', 'Rain Shower', 'Organic Toiletries', 'Tea/Coffee', 'Ceiling Fan', 'Mosquito Nets'],
                images: [
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            honeymoon: {
                name: 'Honeymoon Suite',
                price: 'KSh 65,000',
                description: 'Designed for romance, this suite features intimate settings, a private balcony with sunset views, and special amenities for couples.',
                size: '55 m²',
                occupancy: '2 Adults',
                bedType: 'King',
                view: 'Sunset',
                amenities: ['King Bed', 'Sunset Balcony', 'Champagne on Arrival', 'Rose Petal Turndown', 'Double Vanity', 'Deep Soaking Tub', 'Candlelit Dining', 'Couples Massage'],
                images: [
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            business: {
                name: 'Business Suite',
                price: 'KSh 45,000',
                description: 'Optimized for the modern professional, featuring a dedicated workspace and all the tech amenities needed for productivity.',
                size: '50 m²',
                occupancy: '2 Adults',
                bedType: 'King',
                view: 'City',
                amenities: ['Work Desk', 'Ergonomic Chair', 'High-speed Internet', 'Printer Access', 'Conference Phone', 'Stationery Set', 'Complimentary Printing', 'Meeting Space'],
                images: [
                    'https://images.unsplash.com/photo-1522778526097-ce0a22ceb253?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            },
            penthouse: {
                name: 'Sky Penthouse',
                price: 'KSh 200,000',
                description: 'The ultimate expression of luxury living, occupying the entire top floor with 360° views and unparalleled amenities.',
                size: '150 m²',
                occupancy: '4 Adults',
                bedType: '2 King',
                view: 'Panoramic',
                amenities: ['Rooftop Terrace', 'Private Pool', 'Hot Tub', 'Outdoor Kitchen', 'Panoramic Views', 'Private Elevator', 'Wine Room', 'Personal Chef'],
                images: [
                    'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            }
        };

        // Modal Functions
        function openModal(roomType) {
            const room = roomData[roomType];
            if (!room) return;
            
            const modal = document.getElementById('roomModal');
            const modalContent = document.getElementById('modalContent');
            
            // Generate gallery HTML
            let galleryHTML = `
                <div class="grid lg:grid-cols-2 gap-8">
                    <!-- Left Column - Gallery -->
                    <div>
                        <!-- Main Image -->
                        <div class="relative">
                            <img id="mainImage" src="${room.images[0]}" alt="${room.name}" class="main-image">
                            <!-- Auto-carousel indicator (subtle) -->
                            <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs text-[#3f352e]">
                                <i class="fas fa-play-circle text-[#d4b48c] mr-1"></i> Auto-rotating
                            </div>
                        </div>
                        
                        <!-- Thumbnails -->
                        <div class="thumbnail-container mt-4">
                            ${room.images.map((img, index) => `
                                <img src="${img}" alt="Thumbnail ${index + 1}" class="thumbnail ${index === 0 ? 'active' : ''}" onclick="changeImage(this, '${img}')">
                            `).join('')}
                        </div>
                    </div>
                    
                    <!-- Right Column - Details -->
                    <div>
                        <h2 class="font-['Cormorant_Garamond'] text-3xl md:text-4xl text-[#3f352e] mb-2">${room.name}</h2>
                        
                        <!-- Price -->
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-3xl">${room.price}</span>
                            <span class="text-[#8a735b] text-xs">per night</span>
                        </div>
                        
                        <!-- Quick Specs -->
                        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-white/60 rounded-xl">
                            <div>
                                <p class="text-[#8a735b] text-xs uppercase">Size</p>
                                <p class="text-[#3f352e] font-medium">${room.size}</p>
                            </div>
                            <div>
                                <p class="text-[#8a735b] text-xs uppercase">Occupancy</p>
                                <p class="text-[#3f352e] font-medium">${room.occupancy}</p>
                            </div>
                            <div>
                                <p class="text-[#8a735b] text-xs uppercase">Bed Type</p>
                                <p class="text-[#3f352e] font-medium">${room.bedType}</p>
                            </div>
                            <div>
                                <p class="text-[#8a735b] text-xs uppercase">View</p>
                                <p class="text-[#3f352e] font-medium">${room.view}</p>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-[#5c524a] mb-6 leading-relaxed">${room.description}</p>
                        
                        <!-- Amenities -->
                        <h3 class="font-['Cormorant_Garamond'] text-xl text-[#3f352e] mb-3">Amenities</h3>
                        <div class="grid grid-cols-2 gap-2 mb-8">
                            ${room.amenities.map(amenity => `
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-[#d4b48c] text-xs"></i>
                                    <span class="text-[#5c524a] text-sm">${amenity}</span>
                                </div>
                            `).join('')}
                        </div>
                        
                        <!-- Check Availability Form -->
                        <h3 class="font-['Cormorant_Garamond'] text-xl text-[#3f352e] mb-3">Check Availability</h3>
                        <form class="availability-form space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[#8a735b] text-xs uppercase mb-1">Check-in</label>
                                    <input type="date" class="w-full px-4 py-2 rounded-lg bg-white">
                                </div>
                                <div>
                                    <label class="block text-[#8a735b] text-xs uppercase mb-1">Check-out</label>
                                    <input type="date" class="w-full px-4 py-2 rounded-lg bg-white">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[#8a735b] text-xs uppercase mb-1">Adults</label>
                                    <select class="w-full px-4 py-2 rounded-lg bg-white">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[#8a735b] text-xs uppercase mb-1">Children</label>
                                    <select class="w-full px-4 py-2 rounded-lg bg-white">
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-[#8a735b] text-xs uppercase mb-1">Special Requests</label>
                                <textarea rows="2" class="w-full px-4 py-2 rounded-lg bg-white" placeholder="Any special requirements..."></textarea>
                            </div>
                            
                            <button type="submit" class="w-full py-3 bg-[#d4b48c] text-white rounded-lg hover:bg-[#b89a78] transition-colors">
                                Check Availability
                            </button>
                        </form>
                    </div>
                </div>
            `;
            
            modalContent.innerHTML = galleryHTML;
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Start auto-carousel
            startAutoCarousel(room.images);
        }
        
        function closeModal() {
            const modal = document.getElementById('roomModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
            
            // Clear interval
            if (window.carouselInterval) {
                clearInterval(window.carouselInterval);
            }
        }
        
        // Change main image when thumbnail clicked
        function changeImage(thumbnail, src) {
            // Update main image
            document.getElementById('mainImage').src = src;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
            
            // Stop auto-carousel when user manually selects
            if (window.carouselInterval) {
                clearInterval(window.carouselInterval);
            }
        }
        
        // Auto-carousel function
        function startAutoCarousel(images) {
            let currentIndex = 0;
            
            // Clear any existing interval
            if (window.carouselInterval) {
                clearInterval(window.carouselInterval);
            }
            
            window.carouselInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % images.length;
                const mainImage = document.getElementById('mainImage');
                if (mainImage) {
                    mainImage.src = images[currentIndex];
                    
                    // Update active thumbnail
                    const thumbnails = document.querySelectorAll('.thumbnail');
                    thumbnails.forEach((thumb, index) => {
                        if (index === currentIndex) {
                            thumb.classList.add('active');
                        } else {
                            thumb.classList.remove('active');
                        }
                    });
                }
            }, 4000); // Change every 4 seconds
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('roomModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Filter button functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from siblings in same group
                const parent = this.parentNode;
                parent.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');
            });
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