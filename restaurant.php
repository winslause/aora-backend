<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora - The Dining Experience</title>
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
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-8px) scale(1.02); }
        }
        
        @keyframes pulse-soft {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.6; }
        }
        
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        @keyframes rotateSlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes drawLine {
            0% { width: 0; }
            100% { width: 100px; }
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
        
        /* Dish item styles - no cards */
        .dish-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .dish-item img {
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .dish-item:hover img {
            transform: scale(1.08);
        }
        
        .dish-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent 60%);
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .dish-item:hover .dish-overlay {
            opacity: 1;
        }
        
        .dish-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem 1.5rem;
            transform: translateY(20px);
            transition: transform 0.5s ease;
        }
        
        .dish-item:hover .dish-content {
            transform: translateY(0);
        }
        
        /* Menu card alternative - minimal lines */
        .menu-item {
            border-bottom: 1px dashed rgba(212, 180, 140, 0.3);
            padding: 1rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .menu-item:last-child {
            border-bottom: none;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
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
            background: #fcf8f3;
            max-width: 1000px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 0;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            box-shadow: 0 30px 60px -30px rgba(0,0,0,0.5);
        }
        
        .modal.show .modal-content {
            transform: scale(1);
        }
        
        /* Form styles */
        .reservation-form input,
        .reservation-form select,
        .reservation-form textarea {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(212, 180, 140, 0.4);
            padding: 0.75rem 0;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .reservation-form input:focus,
        .reservation-form select:focus,
        .reservation-form textarea:focus {
            outline: none;
            border-bottom-color: #b89a78;
        }
        
        .reservation-form label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #8a735b;
        }
        
        .reserve-button {
            background: #b89a78;
            color: white;
            padding: 1rem 2rem;
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .reserve-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .reserve-button:hover::before {
            left: 100%;
        }
        
        .reserve-button:hover {
            background: #a07e5c;
        }
        
        /* Sample menu blocks - not cards */
        .sample-menu-block {
            background: #f8f0e7;
            padding: 2rem;
            border-left: 4px solid #b89a78;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .modal-content {
                width: 98%;
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#fcf8f3]">
    <main class="relative">
        <!-- ===== HERO SECTION ===== -->
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <!-- Background Image - Elegant Restaurant Ambiance -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Elegant Restaurant" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>
            </div>
            
            <!-- Floating Orbs - Subtle -->
            <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-[#b89a78]/20 rounded-full blur-3xl animate-pulse-soft"></div>
            <div class="absolute bottom-1/3 right-1/4 w-96 h-96 bg-[#8a735b]/20 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 2s;"></div>
            
            <!-- Content -->
            <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
                <!-- Floating Gold Line Animation -->
                <div class="flex justify-center mb-8">
                    <div class="w-24 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent animate-pulse"></div>
                </div>
                
                <!-- Main Heading with Split Reveal -->
                <h1 class="font-['DM_Serif_Display'] text-6xl md:text-7xl lg:text-8xl text-white mb-6 drop-shadow-2xl tracking-wide">
                    <span class="block reveal-left" style="transition-delay: 0.2s;">The Aora</span>
                    <span class="block reveal-right text-[#b89a78]" style="transition-delay: 0.4s;">Dining Experience</span>
                </h1>
                
                <!-- Decorative Element -->
                <div class="relative flex justify-center items-center gap-4 mb-12">
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                    <i class="fas fa-utensils text-[#b89a78] text-xl"></i>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                </div>
                
                <!-- Subheading -->
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 max-w-2xl mx-auto italic leading-relaxed reveal" style="transition-delay: 0.6s;">
                    "Where Kenyan flavors meet culinary artistry"
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

        <!-- ===== RESTAURANT OVERVIEW ===== -->
        <section class="relative py-28 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background - No Icons -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    
                    <!-- Left Column - Ambiance Description -->
                    <div class="reveal-left">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-px bg-[#b89a78]"></div>
                            <span class="text-[#8a735b] text-xs uppercase tracking-widest">The Ambiance</span>
                        </div>
                        
                        <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mb-8 leading-tight">
                            A Symphony of <span class="italic text-[#b89a78]">Senses</span>
                        </h2>
                        
                        <p class="text-[#5c524a] text-lg leading-relaxed mb-8">
                            Step into a world where warm earth tones meet contemporary elegance. Our restaurant is designed to be an extension of Kenya's soul—intimate, welcoming, and utterly unforgettable.
                        </p>
                        
                        <p class="text-[#5c524a] mb-10">
                            We specialize in <span class="font-semibold text-[#b89a78]">modern Kenyan cuisine</span>, blending traditional Swahili spices with international techniques. Every dish tells a story of our land, our people, and our passion.
                        </p>
                        
                        <!-- Cuisine Type Tags - No Cards -->
                        <div class="flex flex-wrap gap-3">
                            <span class="px-5 py-2 border border-[#b89a78]/30 text-[#5c524a] text-sm rounded-full hover:bg-[#b89a78] hover:text-white transition-colors cursor-default">Swahili Coast</span>
                            <span class="px-5 py-2 border border-[#b89a78]/30 text-[#5c524a] text-sm rounded-full hover:bg-[#b89a78] hover:text-white transition-colors cursor-default">Farm-to-Table</span>
                            <span class="px-5 py-2 border border-[#b89a78]/30 text-[#5c524a] text-sm rounded-full hover:bg-[#b89a78] hover:text-white transition-colors cursor-default">Grill Specialties</span>
                            <span class="px-5 py-2 border border-[#b89a78]/30 text-[#5c524a] text-sm rounded-full hover:bg-[#b89a78] hover:text-white transition-colors cursor-default">Plant-Based</span>
                        </div>
                    </div>
                    
                    <!-- Right Column - Opening Hours (Minimal Design) -->
                    <div class="reveal-right">
                        <div class="relative">
                            <!-- Decorative Circle -->
                            <div class="absolute -top-10 -right-10 w-40 h-40 border border-[#b89a78]/20 rounded-full animate-float-slow"></div>
                            
                            <div class="bg-[#f4ede5] p-10 border border-[#b89a78]/10">
                                <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-8">Opening Hours</h3>
                                
                                <!-- Hours List - Minimal Lines -->
                                <div class="space-y-6">
                                    <div class="flex justify-between items-center pb-3 border-b border-[#b89a78]/20">
                                        <span class="text-[#5c524a] font-medium">Breakfast</span>
                                        <span class="text-[#b89a78]">7:00 AM - 10:30 AM</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-[#b89a78]/20">
                                        <span class="text-[#5c524a] font-medium">Lunch</span>
                                        <span class="text-[#b89a78]">12:30 PM - 3:00 PM</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-[#b89a78]/20">
                                        <span class="text-[#5c524a] font-medium">Dinner</span>
                                        <span class="text-[#b89a78]">6:30 PM - 10:30 PM</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#5c524a] font-medium">Sunday Brunch</span>
                                        <span class="text-[#b89a78]">11:00 AM - 3:00 PM</span>
                                    </div>
                                </div>
                                
                                <!-- Note -->
                                <p class="text-[#8a735b] text-sm mt-8 italic">Last orders 30 minutes before closing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== SIGNATURE DISHES ===== -->
        <section class="relative py-28 px-6 bg-[#2c3e4a] overflow-hidden">
            <!-- Simple Background - Deep Teal -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <!-- Floating Elements - Very Subtle -->
            <div class="absolute top-20 left-[5%] w-64 h-64 border border-[#b89a78]/10 rounded-full animate-rotate-slow"></div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header - Light Text -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#b89a78] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">SIGNATURE CREATIONS</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-white mt-4 mb-6 font-light">Our Signature Dishes</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Dishes Grid - NO CARDS -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Dish 1 -->
                    <div class="dish-item group h-[400px] relative reveal" style="transition-delay: 0.1s;" onclick="openDishModal('nyamaChoma')">
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" 
                             alt="Nyama Choma" 
                             class="w-full h-full object-cover">
                        <div class="dish-overlay"></div>
                        <div class="dish-content">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-2">Nyama Choma</h3>
                            <p class="text-white/80 text-sm mb-3">Grilled premium beef with kachumbari</p>
                            <div class="flex items-center gap-2 text-[#b89a78] text-sm">
                                <span>View details</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dish 2 -->
                    <div class="dish-item group h-[400px] relative reveal" style="transition-delay: 0.2s;" onclick="openDishModal('pilau')">
                        <img src="https://images.unsplash.com/photo-1633945274405-b6c8069047b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Swahili Pilau" 
                             class="w-full h-full object-cover">
                        <div class="dish-overlay"></div>
                        <div class="dish-content">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-2">Swahili Pilau</h3>
                            <p class="text-white/80 text-sm mb-3">Spiced rice with tender meat and caramelized onions</p>
                            <div class="flex items-center gap-2 text-[#b89a78] text-sm">
                                <span>View details</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dish 3 -->
                    <div class="dish-item group h-[400px] relative reveal" style="transition-delay: 0.3s;" onclick="openDishModal('seafood')">
                        <img src="https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Coastal Seafood Platter" 
                             class="w-full h-full object-cover">
                        <div class="dish-overlay"></div>
                        <div class="dish-content">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-2">Coastal Seafood</h3>
                            <p class="text-white/80 text-sm mb-3">Fresh catch with coconut curry and chapati</p>
                            <div class="flex items-center gap-2 text-[#b89a78] text-sm">
                                <span>View details</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dish 4 -->
                    <div class="dish-item group h-[400px] relative reveal" style="transition-delay: 0.4s;" onclick="openDishModal('samaki')">
                        <img src="https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Samaki wa Kupaka" 
                             class="w-full h-full object-cover">
                        <div class="dish-overlay"></div>
                        <div class="dish-content">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-2">Samaki wa Kupaka</h3>
                            <p class="text-white/80 text-sm mb-3">Grilled fish in coconut and tamarind sauce</p>
                            <div class="flex items-center gap-2 text-[#b89a78] text-sm">
                                <span>View details</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dish 5 -->
                    <div class="dish-item group h-[400px] relative reveal" style="transition-delay: 0.5s;" onclick="openDishModal('mandazi')">
                        <img src="https://ca-times.brightspotcdn.com/dims4/default/2a10669/2147483647/strip/false/crop/6000x4000+0+0/resize/1486x991!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2F91%2F68%2F749190444099bbb5d78da123e922%2F666808-la-fo-kiano-moju-christmas-sr0836.jpg" 
                             alt="Mandazi with Masala Chai" 
                             class="w-full h-full object-cover">
                        <div class="dish-overlay"></div>
                        <div class="dish-content">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-2">Mandazi & Chai</h3>
                            <p class="text-white/80 text-sm mb-3">East African donuts with spiced masala chai</p>
                            <div class="flex items-center gap-2 text-[#b89a78] text-sm">
                                <span>View details</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dish 6 -->
                    <div class="dish-item group h-[400px] relative reveal" style="transition-delay: 0.6s;" onclick="openDishModal('fruit')">
                        <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2127&q=80" 
                             alt="Tropical Fruit Platter" 
                             class="w-full h-full object-cover">
                        <div class="dish-overlay"></div>
                        <div class="dish-content">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-2">Tropical Fruits</h3>
                            <p class="text-white/80 text-sm mb-3">Fresh mango, pineapple, and passion fruit</p>
                            <div class="flex items-center gap-2 text-[#b89a78] text-sm">
                                <span>View details</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== SAMPLE MENU CARDS (NO CARDS) ===== -->
        <section class="relative py-28 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Culinary Offerings</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Sample Menus</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Menu Blocks - Not Cards -->
                <div class="grid md:grid-cols-3 gap-8">
                    
                    <!-- Tasting Menu -->
                    <div class="sample-menu-block reveal-left" style="transition-delay: 0.1s;">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#2c3e4a]">Tasting Menu</h3>
                            <span class="text-[#b89a78] text-sm">7 courses</span>
                        </div>
                        
                        <div class="space-y-3 mb-8">
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Amuse-bouche</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 1,200</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Coastal Ceviche</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 2,500</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Nyama Choma</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 3,800</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Palate Cleanser</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 800</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Swahili Pilau</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 2,800</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Dessert Trio</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 2,200</span>
                            </div>
                        </div>
                        
                        <a href="#" class="inline-flex items-center gap-2 text-[#b89a78] hover:text-[#8a735b] transition-colors text-sm">
                            <i class="fas fa-file-pdf"></i>
                            <span>Download Menu (PDF)</span>
                        </a>
                    </div>
                    
                    <!-- A La Carte -->
                    <div class="sample-menu-block reveal" style="transition-delay: 0.2s;">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#2c3e4a]">À La Carte</h3>
                            <span class="text-[#b89a78] text-sm">Seasonal</span>
                        </div>
                        
                        <div class="space-y-3 mb-8">
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Starters</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 1,800 - 2,500</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Main Courses</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 2,800 - 4,500</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Grill Specialties</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 3,200 - 4,800</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Vegetarian</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 2,200 - 3,000</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Sides</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 650 - 1,200</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Desserts</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 1,200 - 1,800</span>
                            </div>
                        </div>
                        
                        <a href="#" class="inline-flex items-center gap-2 text-[#b89a78] hover:text-[#8a735b] transition-colors text-sm">
                            <i class="fas fa-file-pdf"></i>
                            <span>Download Menu (PDF)</span>
                        </a>
                    </div>
                    
                    <!-- Dessert Menu -->
                    <div class="sample-menu-block reveal-right" style="transition-delay: 0.3s;">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#2c3e4a]">Dessert Menu</h3>
                            <span class="text-[#b89a78] text-sm">Sweet endings</span>
                        </div>
                        
                        <div class="space-y-3 mb-8">
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Chocolate Fondant</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 1,500</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Passion Fruit Panna Cotta</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 1,400</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Coconut & Mango Tart</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 1,400</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Masala Chai Crème Brûlée</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 1,500</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Fresh Fruit Platter</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 1,200</span>
                            </div>
                            <div class="menu-item">
                                <span class="text-[#5c524a]">Artisan Ice Cream</span>
                                <span class="text-[#8a735b] text-sm font-medium">KSh 950</span>
                            </div>
                        </div>
                        
                        <a href="#" class="inline-flex items-center gap-2 text-[#b89a78] hover:text-[#8a735b] transition-colors text-sm">
                            <i class="fas fa-file-pdf"></i>
                            <span>Download Menu (PDF)</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== SPECIAL DINING EXPERIENCES ===== -->
        <section class="relative py-28 px-6 bg-[#f4ede5] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Beyond the Ordinary</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Special Dining Experiences</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Experiences Grid - No Cards, Just Text and Images -->
                <div class="space-y-20">
                    
                    <!-- Experience 1 - Chef's Table -->
                    <div class="grid lg:grid-cols-2 gap-12 items-center reveal-left">
                        <div>
                            <div class="relative h-[400px] overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80" 
                                     alt="Chef's Table" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                        <div>
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-4">The Chef's Table</h3>
                            <div class="w-16 h-px bg-[#b89a78] mb-6"></div>
                            <p class="text-[#5c524a] text-lg leading-relaxed mb-6">
                                An intimate 8-course journey seated at the kitchen pass. Watch our culinary team create magic while the chef personally explains each dish's inspiration and technique.
                            </p>
                            <p class="text-[#8a735b] text-sm">Available Thursday-Sunday | Max 6 guests</p>
                        </div>
                    </div>
                    
                    <!-- Experience 2 - Private Dining -->
                    <div class="grid lg:grid-cols-2 gap-12 items-center reveal-right">
                        <div class="lg:order-2">
                            <div class="relative h-[400px] overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                     alt="Private Dining" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                        <div class="lg:order-1">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-4">Private Dining Room</h3>
                            <div class="w-16 h-px bg-[#b89a78] mb-6"></div>
                            <p class="text-[#5c524a] text-lg leading-relaxed mb-6">
                                Host up to 16 guests in our elegant private dining room. Featuring a dedicated menu, personal waiter, and wine pairing options.
                            </p>
                            <p class="text-[#8a735b] text-sm">Available daily | Ideal for celebrations</p>
                        </div>
                    </div>
                    
                    <!-- Experience 3 - Garden Terrace -->
                    <div class="grid lg:grid-cols-2 gap-12 items-center reveal-left">
                        <div>
                            <div class="relative h-[400px] overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                                     alt="Garden Terrace" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                        <div>
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-4">Garden Terrace</h3>
                            <div class="w-16 h-px bg-[#b89a78] mb-6"></div>
                            <p class="text-[#5c524a] text-lg leading-relaxed mb-6">
                                Al fresco dining under the stars. Surrounded by lush gardens and ambient lighting, enjoy our signature menu in Nairobi's most romantic setting.
                            </p>
                            <p class="text-[#8a735b] text-sm">Weather permitting | Evenings only</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== RESERVATION FORM SECTION ===== -->
        <section class="relative py-28 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-4xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-12 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Reserve Your Table</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Join Us for Dinner</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Reservation Form - Minimal Design -->
                <div class="bg-[#f4ede5] p-8 md:p-12 reveal">
                    <form class="reservation-form space-y-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Date -->
                            <div>
                                <label class="block mb-2">Date</label>
                                <input type="date" value="2025-04-15" required>
                            </div>
                            
                            <!-- Time -->
                            <div>
                                <label class="block mb-2">Time</label>
                                <select required>
                                    <option value="">Select time</option>
                                    <option>12:30 PM</option>
                                    <option>1:00 PM</option>
                                    <option>1:30 PM</option>
                                    <option>7:00 PM</option>
                                    <option>7:30 PM</option>
                                    <option>8:00 PM</option>
                                    <option>8:30 PM</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Guests -->
                            <div>
                                <label class="block mb-2">Number of Guests</label>
                                <select required>
                                    <option value="">Select</option>
                                    <option>1 Guest</option>
                                    <option>2 Guests</option>
                                    <option>3 Guests</option>
                                    <option>4 Guests</option>
                                    <option>5 Guests</option>
                                    <option>6 Guests</option>
                                    <option>7 Guests</option>
                                    <option>8 Guests</option>
                                </select>
                            </div>
                            
                            <!-- Occasion -->
                            <div>
                                <label class="block mb-2">Occasion (Optional)</label>
                                <select>
                                    <option value="">Select</option>
                                    <option>Birthday</option>
                                    <option>Anniversary</option>
                                    <option>Business</option>
                                    <option>Date Night</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Name -->
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label class="block mb-2">First Name</label>
                                <input type="text" placeholder="John" required>
                            </div>
                            <div>
                                <label class="block mb-2">Last Name</label>
                                <input type="text" placeholder="Kim" required>
                            </div>
                        </div>
                        
                        <!-- Contact -->
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label class="block mb-2">Email</label>
                                <input type="email" placeholder="john@example.com" required>
                            </div>
                            <div>
                                <label class="block mb-2">Phone</label>
                                <input type="tel" placeholder="+254 XXX XXX" required>
                            </div>
                        </div>
                        
                        <!-- Special Requests -->
                        <div>
                            <label class="block mb-2">Special Requests</label>
                            <textarea rows="3" placeholder="Dietary restrictions, allergies, or special notes..."></textarea>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center pt-4">
                            <button type="submit" class="reserve-button px-12 py-4 text-white uppercase tracking-wider text-sm">
                                Reserve Now
                            </button>
                        </div>
                    </form>
                    
                    <!-- Note -->
                    <p class="text-center text-[#8a735b] text-xs mt-6">
                        We'll confirm your reservation within 2 hours via email or SMS.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- ===== DISH MODAL ===== -->
    <div id="dishModal" class="modal">
        <div class="modal-content mx-auto my-8 p-8 relative">
            <!-- Close Button -->
            <button onclick="closeDishModal()" class="absolute top-4 right-4 w-10 h-10 bg-[#b89a78] text-white rounded-full flex items-center justify-center hover:bg-[#8a735b] transition-all z-10">
                <i class="fas fa-times"></i>
            </button>
            
            <!-- Modal Content will be dynamically loaded -->
            <div id="dishModalContent"></div>
        </div>
    </div>

    <!-- Dish Data and Functions -->
    <script>
        const dishData = {
            nyamaChoma: {
                name: 'Nyama Choma',
                description: 'Kenya\'s most beloved dish. Premium beef slow-grilled over open flames until perfectly charred and tender.',
                longDescription: 'Served with traditional kachumbari (fresh tomato and onion salsa), ugali, and our signature chili sauce. The meat is sourced from local grass-fed cattle and marinated for 24 hours in a secret blend of Swahili spices.',
                price: 'KSh 3,800',
                image: 'https://beehiverl.com/wp-content/uploads/2024/09/Nyama-Choma-2.jpg',
                ingredients: ['Premium beef', 'Garlic', 'Ginger', 'Swahili spice blend', 'Lime', 'Fresh tomatoes', 'Onions', 'Cilantro'],
                spiceLevel: 'Medium',
                dietary: 'Gluten-free option available'
            },
            pilau: {
                name: 'Swahili Pilau',
                description: 'Aromatic spiced rice dish that tells the story of the Swahili coast.',
                longDescription: 'Fragrant basmati rice cooked in a rich broth of beef, cardamom, cinnamon, cloves, and cumin. Topped with caramelized onions and served with kachumbari and a side of tangy tamarind sauce.',
                price: 'KSh 2,200',
                image: 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                ingredients: ['Basmati rice', 'Beef', 'Cardamom', 'Cinnamon', 'Cloves', 'Cumin', 'Onions', 'Garlic'],
                spiceLevel: 'Mild',
                dietary: 'Contains gluten'
            },
            seafood: {
                name: 'Coastal Seafood Platter',
                description: 'Fresh catch from the Kenyan coast prepared in rich coconut curry.',
                longDescription: 'A generous platter of prawns, calamari, and fish simmered in a fragrant coconut curry with tamarind and Swahili spices. Served with fluffy chapati and coconut rice.',
                price: 'KSh 4,500',
                image: 'https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                ingredients: ['Prawns', 'Calamari', 'Fish', 'Coconut milk', 'Tamarind', 'Curry leaves', 'Lemongrass', 'Chilies'],
                spiceLevel: 'Medium-Hot',
                dietary: 'Contains seafood'
            },
            samaki: {
                name: 'Samaki wa Kupaka',
                description: 'Grilled fish in a rich coconut and tamarind sauce.',
                longDescription: 'Whole tilapia or red snapper marinated in lime and spices, grilled to perfection, then bathed in a creamy coconut-tamarind sauce. Served with mchicha (sautéed greens) and ugali.',
                price: 'KSh 3,200',
                image: 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                ingredients: ['Whole tilapia', 'Coconut milk', 'Tamarind', 'Lime', 'Garlic', 'Ginger', 'Chilies', 'Cilantro'],
                spiceLevel: 'Medium',
                dietary: 'Gluten-free'
            },
            mandazi: {
                name: 'Mandazi & Masala Chai',
                description: 'East African donuts served with spiced tea.',
                longDescription: 'Light, fluffy, lightly sweetened donuts with hints of cardamom and coconut. Served with a steaming pot of masala chai—black tea infused with ginger, cardamom, cinnamon, and cloves.',
                price: 'KSh 850',
                image: 'https://ca-times.brightspotcdn.com/dims4/default/2a10669/2147483647/strip/false/crop/6000x4000+0+0/resize/1486x991!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2F91%2F68%2F749190444099bbb5d78da123e922%2F666808-la-fo-kiano-moju-christmas-sr0836.jpg',
                ingredients: ['Flour', 'Coconut milk', 'Cardamom', 'Sugar', 'Yeast', 'Black tea', 'Ginger', 'Cinnamon'],
                spiceLevel: 'None',
                dietary: 'Vegetarian'
            },
            fruit: {
                name: 'Tropical Fruit Platter',
                description: 'Fresh seasonal fruits from Kenyan farms.',
                longDescription: 'A vibrant selection of Kenya\'s finest tropical fruits: sweet mangoes, juicy pineapples, passion fruit, papaya, and watermelon. Served with a drizzle of honey and lime.',
                price: 'KSh 1,200',
                image: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2127&q=80',
                ingredients: ['Mango', 'Pineapple', 'Passion fruit', 'Papaya', 'Watermelon', 'Honey', 'Lime', 'Mint'],
                spiceLevel: 'None',
                dietary: 'Vegan, Gluten-free'
            }
        };

        function openDishModal(dishKey) {
            const dish = dishData[dishKey];
            if (!dish) return;
            
            const modal = document.getElementById('dishModal');
            const modalContent = document.getElementById('dishModalContent');
            
            modalContent.innerHTML = `
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Left Column - Image -->
                    <div>
                        <img src="${dish.image}" alt="${dish.name}" class="w-full h-[400px] object-cover">
                    </div>
                    
                    <!-- Right Column - Details -->
                    <div>
                        <h2 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-2">${dish.name}</h2>
                        <div class="w-12 h-px bg-[#b89a78] mb-4"></div>
                        
                        <p class="text-[#5c524a] text-lg mb-4">${dish.description}</p>
                        <p class="text-[#8a735b] text-sm mb-6 leading-relaxed">${dish.longDescription}</p>
                        
                        <div class="mb-6">
                            <span class="text-[#b89a78] font-['DM_Serif_Display'] text-2xl">${dish.price}</span>
                        </div>
                        
                        <!-- Key Info -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-[#8a735b] text-xs uppercase">Spice Level</p>
                                <p class="text-[#5c524a]">${dish.spiceLevel}</p>
                            </div>
                            <div>
                                <p class="text-[#8a735b] text-xs uppercase">Dietary</p>
                                <p class="text-[#5c524a]">${dish.dietary}</p>
                            </div>
                        </div>
                        
                        <!-- Ingredients -->
                        <div class="mb-8">
                            <p class="text-[#8a735b] text-xs uppercase mb-2">Ingredients</p>
                            <div class="flex flex-wrap gap-2">
                                ${dish.ingredients.map(ing => `
                                    <span class="px-3 py-1 border border-[#b89a78]/30 text-sm">${ing}</span>
                                `).join('')}
                            </div>
                        </div>
                        
                        <!-- Reserve Button -->
                        <button onclick="openReservationFromDish('${dish.name}')" class="reserve-button w-full py-4 text-white uppercase tracking-wider">
                            Reserve a Table for This Dish
                        </button>
                    </div>
                </div>
            `;
            
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeDishModal() {
            const modal = document.getElementById('dishModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
        
        function openReservationFromDish(dishName) {
            closeDishModal();
            
            // Scroll to reservation form
            document.querySelector('.reservation-form').scrollIntoView({ behavior: 'smooth' });
            
            // Optionally pre-fill special requests
            const specialRequests = document.querySelector('.reservation-form textarea');
            if (specialRequests) {
                specialRequests.value = `I'd like to order the ${dishName}`;
            }
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDishModal();
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('dishModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDishModal();
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
        
        // Form submission
        document.querySelector('.reservation-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you! Your reservation request has been sent. We\'ll confirm within 2 hours.');
        });
    </script>
</body>
</html>