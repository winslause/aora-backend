<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora - About Us</title>
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
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.02); }
        }
        
        @keyframes pulse-soft {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.05); }
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
        
        @keyframes slideIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes rotateY {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }
        
        @keyframes scalePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
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
        
        .animate-drift-reverse {
            animation: drift 18s ease-in-out infinite reverse;
        }
        
        .animate-rotate-y {
            animation: rotateY 20s linear infinite;
        }
        
        .animate-scale-pulse {
            animation: scalePulse 3s ease-in-out infinite;
        }
        
        .shimmer-text {
            background: linear-gradient(90deg, transparent, rgba(212, 180, 140, 0.3), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        
        /* Reveal animations on scroll */
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
        
        /* Parallax effect */
        .parallax {
            transform: translateZ(0);
            transition: transform 0.1s ease-out;
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
        
        /* 3D Tilt Effect */
        .tilt-card {
            transition: transform 0.3s ease;
            transform-style: preserve-3d;
        }
        
        .tilt-card:hover {
            transform: rotateX(5deg) rotateY(5deg);
        }
        
        /* Ken Burns Effect */
        .ken-burns {
            animation: kenBurns 20s ease infinite;
        }
        
        @keyframes kenBurns {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="min-h-screen bg-[#f5efe8]">
    <!-- Main Content - No Header, No Footer -->
    <main class="relative">
        
        <!-- ===== HERO SECTION ===== -->
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <!-- Background Image with Parallax -->
            <div class="absolute inset-0 z-0 parallax" id="parallaxBg">
                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="African Landscape" 
                     class="w-full h-full object-cover scale-110 animate-drift">
                <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-black/20 to-transparent"></div>
            </div>
            
            <!-- Floating Orbs -->
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-[#d4b48c]/20 rounded-full blur-3xl animate-pulse-soft"></div>
            <div class="absolute bottom-1/3 right-1/4 w-96 h-96 bg-[#b89a78]/20 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 2s;"></div>
            
            <!-- Content -->
            <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
                <!-- Floating Gold Line -->
                <div class="flex justify-center mb-8">
                    <div class="w-24 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent animate-pulse"></div>
                </div>
                
                <!-- Main Heading with Split Reveal -->
                <h1 class="font-['DM_Serif_Display'] text-7xl md:text-8xl lg:text-9xl text-white mb-6 drop-shadow-2xl tracking-wide reveal" style="text-shadow: 2px 2px 20px rgba(0,0,0,0.3);">
                    <span class="block reveal-left" style="transition-delay: 0.2s;">The Story</span>
                    <span class="block reveal-right text-[#d4b48c]" style="transition-delay: 0.4s;">of Aora</span>
                </h1>
                
                <!-- Decorative Element -->
                <div class="relative flex justify-center items-center gap-4 mb-12">
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                    <i class="fas fa-gem text-[#d4b48c] text-xl animate-pulse"></i>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                </div>
                
                <!-- Subheading with Typing Effect -->
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 max-w-2xl mx-auto italic leading-relaxed reveal" style="transition-delay: 0.6s;">
                    "Where the earth meets the sky, and every sunrise tells a new story."
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

        <!-- ===== ELEGANT DIVIDER ===== -->
        <div class="relative h-24 bg-gradient-to-b from-transparent to-[#f5efe8] -mt-1"></div>

        <!-- ===== MISSION & VISION SECTION ===== -->
        <section class="relative py-28 px-6 bg-[#f5efe8] overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#d4b48c]/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#d4b48c]/30 to-transparent"></div>
                
                <!-- Floating Circles -->
                <div class="absolute top-20 left-[5%] w-40 h-40 border border-[#d4b48c]/20 rounded-full animate-float-slow"></div>
                <div class="absolute bottom-20 right-[8%] w-60 h-60 border border-[#8a735b]/10 rounded-full animate-float" style="animation-duration: 15s;"></div>
                
                <!-- Subtle Pattern -->
                <div class="absolute inset-0 opacity-[0.02]" style="background-image: repeating-linear-gradient(45deg, #8a735b 0px, #8a735b 2px, transparent 2px, transparent 20px);"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-20 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Our Essence</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#3f352e] mt-4 mb-6 font-light">Mission & Vision</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
                </div>
                
                <!-- Grid Layout -->
                <div class="grid md:grid-cols-2 gap-12 lg:gap-20">
                    
                    <!-- Mission Column -->
                    <div class="relative group reveal-left">
                        <!-- Background Image -->
                        <div class="absolute -inset-4 bg-gradient-to-br from-[#d4b48c]/20 to-transparent rounded-3xl blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <div class="relative bg-white/40 backdrop-blur-sm p-8 md:p-10 rounded-3xl border border-white/60 shadow-xl">
                            <!-- Icon -->
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center mb-8 shadow-lg group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-compass text-3xl text-white"></i>
                            </div>
                            
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#3f352e] mb-4">Our Mission</h3>
                            
                            <div class="w-12 h-1 bg-gradient-to-r from-[#d4b48c] to-transparent mb-6"></div>
                            
                            <p class="text-[#5c524a] text-lg leading-relaxed mb-6">
                                To curate unforgettable experiences that honor Kenyan heritage while delivering world-class luxury.
                            </p>
                            
                            <!-- Key Points -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-leaf text-[#d4b48c]"></i>
                                    <span class="text-[#5c524a]">Sustainable luxury</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-hands text-[#d4b48c]"></i>
                                    <span class="text-[#5c524a]">Authentic hospitality</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-star text-[#d4b48c]"></i>
                                    <span class="text-[#5c524a]">Uncompromising quality</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Vision Column -->
                    <div class="relative group reveal-right">
                        <!-- Background Image -->
                        <div class="absolute -inset-4 bg-gradient-to-br from-[#b89a78]/20 to-transparent rounded-3xl blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <div class="relative bg-white/40 backdrop-blur-sm p-8 md:p-10 rounded-3xl border border-white/60 shadow-xl">
                            <!-- Icon -->
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#b89a78] to-[#8a735b] flex items-center justify-center mb-8 shadow-lg group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-eye text-3xl text-white"></i>
                            </div>
                            
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#3f352e] mb-4">Our Vision</h3>
                            
                            <div class="w-12 h-1 bg-gradient-to-r from-[#b89a78] to-transparent mb-6"></div>
                            
                            <p class="text-[#5c524a] text-lg leading-relaxed mb-6">
                                To be Africa's most cherished sanctuary where stories begin and memories never end.
                            </p>
                            
                            <!-- Key Points -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-globe-africa text-[#b89a78]"></i>
                                    <span class="text-[#5c524a]">Pan-African excellence</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-heart text-[#b89a78]"></i>
                                    <span class="text-[#5c524a]">Heartfelt connections</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-infinity text-[#b89a78]"></i>
                                    <span class="text-[#5c524a]">Timeless legacy</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== ELEGANT DIVIDER ===== -->
        <div class="relative h-16 bg-gradient-to-b from-[#f5efe8] via-[#f5efe8] to-[#e8d9c5]"></div>

        <!-- ===== RESORT STORY SECTION ===== -->
        <section class="relative py-28 px-6 bg-[#e8d9c5] overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Luxury Resort" 
                     class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-r from-[#e8d9c5] via-transparent to-[#e8d9c5]"></div>
            </div>
            
            <!-- Floating Elements -->
            <div class="absolute top-20 right-20 w-40 h-40 border border-[#d4b48c]/20 rounded-full animate-float"></div>
            <div class="absolute bottom-20 left-20 w-60 h-60 border border-[#d4b48c]/10 rounded-full animate-float-slow"></div>
            
            <div class="max-w-6xl mx-auto relative z-10">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    
                    <!-- Left Column - Story Text -->
                    <div class="reveal-left">
                        <!-- Decorative Line -->
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-px bg-[#d4b48c]"></div>
                            <span class="text-[#8a735b] text-xs uppercase tracking-widest">Since 2010</span>
                        </div>
                        
                        <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl lg:text-6xl text-[#3f352e] mb-8 leading-tight">
                            Born from a <span class="italic text-[#b89a78]">dream</span><br>to share Kenya's soul
                        </h2>
                        
                        <div class="space-y-6 text-[#5c524a]">
                            <p class="text-lg leading-relaxed">
                                What began as a family's vision to create a haven where travelers could experience the true warmth of Kenyan hospitality has blossomed into one of Nairobi's most beloved retreats.
                            </p>
                            <p class="text-base leading-relaxed">
                                Nestled in the lush greenery of Gigiri, Aora stands as a testament to the belief that luxury need not be detached from nature—that the finest experiences are those that connect us to the land, the culture, and the people.
                            </p>
                            
                            <!-- Signature -->
                            <div class="flex items-center gap-4 pt-6">
                                <div class="w-16 h-px bg-[#d4b48c]"></div>
                                <div class="font-['DM_Serif_Display'] text-xl text-[#b89a78]">The Founders</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Image Collage -->
                    <div class="relative h-[500px] reveal-right">
                        <!-- Main Image -->
                        <div class="absolute top-0 right-0 w-4/5 h-80 rounded-2xl overflow-hidden shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-700">
                            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Sunset at Aora" 
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Secondary Image -->
                        <div class="absolute bottom-0 left-0 w-4/5 h-64 rounded-2xl overflow-hidden shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform duration-700">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Restaurant at Aora" 
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Floating Badge -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white/90 backdrop-blur-md px-6 py-3 rounded-full shadow-xl border border-white flex items-center gap-2 animate-float-slow">
                            <i class="fas fa-heart text-[#d4b48c]"></i>
                            <span class="text-[#3f352e] font-medium">15 years of excellence</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== WHY CHOOSE US SECTION ===== -->
        <section class="relative py-28 px-6 bg-[#f5efe8] overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: repeating-linear-gradient(45deg, #8a735b 0px, #8a735b 4px, transparent 4px, transparent 24px);"></div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Why Choose Us</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#3f352e] mt-4 mb-6 font-light">The Aora Difference</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
                </div>
                
                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Feature 1 -->
                    <div class="group relative p-8 bg-white/30 backdrop-blur-sm rounded-3xl border border-white/60 hover:bg-white/40 transition-all duration-500 hover:-translate-y-2 reveal" style="transition-delay: 0.1s;">
                        <div class="absolute -inset-0.5 bg-gradient-to-br from-[#d4b48c]/20 to-transparent rounded-3xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-map-pin text-2xl text-white"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e] mb-3">Prime Location</h3>
                            <p class="text-[#5c524a]">Nestled in Gigiri, moments from Karura Forest and Nairobi's finest attractions.</p>
                        </div>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="group relative p-8 bg-white/30 backdrop-blur-sm rounded-3xl border border-white/60 hover:bg-white/40 transition-all duration-500 hover:-translate-y-2 reveal" style="transition-delay: 0.2s;">
                        <div class="absolute -inset-0.5 bg-gradient-to-br from-[#d4b48c]/20 to-transparent rounded-3xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-utensils text-2xl text-white"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e] mb-3">Culinary Excellence</h3>
                            <p class="text-[#5c524a]">Award-winning cuisine blending Swahili flavors with international techniques.</p>
                        </div>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="group relative p-8 bg-white/30 backdrop-blur-sm rounded-3xl border border-white/60 hover:bg-white/40 transition-all duration-500 hover:-translate-y-2 reveal" style="transition-delay: 0.3s;">
                        <div class="absolute -inset-0.5 bg-gradient-to-br from-[#d4b48c]/20 to-transparent rounded-3xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-spa text-2xl text-white"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e] mb-3">Holistic Wellness</h3>
                            <p class="text-[#5c524a]">Spa treatments inspired by ancient Kenyan healing traditions.</p>
                        </div>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="group relative p-8 bg-white/30 backdrop-blur-sm rounded-3xl border border-white/60 hover:bg-white/40 transition-all duration-500 hover:-translate-y-2 reveal" style="transition-delay: 0.4s;">
                        <div class="absolute -inset-0.5 bg-gradient-to-br from-[#d4b48c]/20 to-transparent rounded-3xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-leaf text-2xl text-white"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e] mb-3">Sustainable Luxury</h3>
                            <p class="text-[#5c524a]">Committed to eco-friendly practices that protect our environment.</p>
                        </div>
                    </div>
                    
                    <!-- Feature 5 -->
                    <div class="group relative p-8 bg-white/30 backdrop-blur-sm rounded-3xl border border-white/60 hover:bg-white/40 transition-all duration-500 hover:-translate-y-2 reveal" style="transition-delay: 0.5s;">
                        <div class="absolute -inset-0.5 bg-gradient-to-br from-[#d4b48c]/20 to-transparent rounded-3xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-hand-holding-heart text-2xl text-white"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e] mb-3">Warm Hospitality</h3>
                            <p class="text-[#5c524a]">Where every guest is family, and every stay feels like home.</p>
                        </div>
                    </div>
                    
                    <!-- Feature 6 -->
                    <div class="group relative p-8 bg-white/30 backdrop-blur-sm rounded-3xl border border-white/60 hover:bg-white/40 transition-all duration-500 hover:-translate-y-2 reveal" style="transition-delay: 0.6s;">
                        <div class="absolute -inset-0.5 bg-gradient-to-br from-[#d4b48c]/20 to-transparent rounded-3xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#d4b48c] to-[#b89a78] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-calendar-check text-2xl text-white"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e] mb-3">Exclusive Experiences</h3>
                            <p class="text-[#5c524a]">Curated safaris, cultural tours, and bespoke events.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== AWARDS SECTION ===== -->
        <section class="relative py-20 px-6 bg-gradient-to-br from-[#1e2f3a] to-[#2a3f4a] overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 20% 30%, white 1px, transparent 1px), radial-gradient(circle at 80% 70%, white 1px, transparent 1px); background-size: 40px 40px;"></div>
            
            <div class="max-w-6xl mx-auto relative z-10">
                <!-- Section Header - Light Text -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#d4b48c] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Recognition</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-white mt-4 mb-6 font-light">Awards & Accolades</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
                </div>
                
                <!-- Awards Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    
                    <!-- Award 1 -->
                    <div class="text-center group reveal" style="transition-delay: 0.1s;">
                        <div class="w-24 h-24 mx-auto bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-500 border border-white/20">
                            <i class="fas fa-trophy text-4xl text-[#d4b48c]"></i>
                        </div>
                        <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Africa's Leading Resort</h3>
                        <p class="text-[#d4b48c] text-xs mt-1">2024</p>
                    </div>
                    
                    <!-- Award 2 -->
                    <div class="text-center group reveal" style="transition-delay: 0.2s;">
                        <div class="w-24 h-24 mx-auto bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-500 border border-white/20">
                            <i class="fas fa-star text-4xl text-[#d4b48c]"></i>
                        </div>
                        <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Forbes Travel Guide</h3>
                        <p class="text-[#d4b48c] text-xs mt-1">5-Star Rating</p>
                    </div>
                    
                    <!-- Award 3 -->
                    <div class="text-center group reveal" style="transition-delay: 0.3s;">
                        <div class="w-24 h-24 mx-auto bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-500 border border-white/20">
                            <i class="fas fa-utensils text-4xl text-[#d4b48c]"></i>
                        </div>
                        <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Best Restaurant Nairobi</h3>
                        <p class="text-[#d4b48c] text-xs mt-1">2023, 2024</p>
                    </div>
                    
                    <!-- Award 4 -->
                    <div class="text-center group reveal" style="transition-delay: 0.4s;">
                        <div class="w-24 h-24 mx-auto bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-500 border border-white/20">
                            <i class="fas fa-leaf text-4xl text-[#d4b48c]"></i>
                        </div>
                        <h3 class="font-['Cormorant_Garamond'] text-lg text-white">Green Key Award</h3>
                        <p class="text-[#d4b48c] text-xs mt-1">Sustainable Tourism</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CULTURAL HERITAGE SECTION (NEW) ===== -->
        <section class="relative py-28 px-6 overflow-hidden">
            <!-- Background Image - Full Width -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Kenyan Heritage" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-2 md:inset-8 bg-gradient-to-br from-[#e8a5a5]/70 via-[#f5d5d5]/60 to-[#e8a5a5]/70 rounded-3xl"></div>
            </div>
            
            <!-- Floating Elements - Shield and Spears Motif -->
            <div class="absolute top-20 left-[5%] w-24 h-24 border-2 border-[#f5efe8]/20 rounded-full animate-float-slow"></div>
            <div class="absolute bottom-20 right-[8%] w-32 h-32 border-2 border-[#f5efe8]/10 rotate-45 animate-float" style="animation-duration: 14s;"></div>
            
            <div class="max-w-6xl mx-auto relative z-10">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                    
                    <!-- Left Column - Visual Storytelling -->
                    <div class="relative reveal-left order-2 md:order-1">
                        <!-- Circular Image Grid -->
                        <div class="relative h-[300px] md:h-[500px] flex items-center justify-center">
                            <!-- Main Circular Frame -->
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 md:w-72 md:h-72 rounded-full border-8 border-[#d4b48c]/30 overflow-hidden shadow-2xl animate-scale-pulse">
                                <img src="https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                     alt="Maasai Warrior" 
                                     class="w-full h-full object-cover">
                            </div>
                            
                            <!-- Orbiting Images -->
                            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-16 md:w-32 md:h-32 rounded-full border-4 border-[#d4b48c] overflow-hidden shadow-xl animate-float">
                                <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                                     alt="Wildlife" 
                                     class="w-full h-full object-cover">
                            </div>
                            
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-16 h-16 md:w-32 md:h-32 rounded-full border-4 border-[#d4b48c] overflow-hidden shadow-xl animate-float" style="animation-delay: 2s;">
                                <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2068&q=80" 
                                     alt="Traditional Beads" 
                                     class="w-full h-full object-cover">
                            </div>
                            
                            <div class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-1/2 w-16 h-16 md:w-32 md:h-32 rounded-full border-4 border-[#d4b48c] overflow-hidden shadow-xl animate-float" style="animation-delay: 3s;">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                     alt="Safari" 
                                     class="w-full h-full object-cover">
                            </div>
                            
                            <div class="absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-1/2 w-16 h-16 md:w-32 md:h-32 rounded-full border-4 border-[#d4b48c] overflow-hidden shadow-xl animate-float" style="animation-delay: 1s;">
                                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                     alt="Sunset" 
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Heritage Text -->
                    <div class="reveal-right order-1 md:order-2">
                        <!-- Cultural Badge -->
                        <div class="inline-flex items-center gap-3 bg-white/20 backdrop-blur-sm px-5 py-2 rounded-full border border-white/30 mb-8">
                            <i class="fas fa-spa text-[#3f352e]"></i>
                            <span class="text-xs uppercase tracking-wider text-[#3f352e]">A Sanctuary for the Senses</span>
                        </div>
                        
                        <h2 class="font-['Cormorant_Garamond_Italic'] text-4xl md:text-5xl lg:text-6xl text-[#3f352e] mb-6 leading-tight italic">
                            Where <span class="text-[#5c4a3a]">Timeless elegance</span><br>embraces modern luxury
                        </h2>
                        
                        <div class="space-y-6 text-[#4a3f38] mb-10">
                            <p class="text-lg leading-relaxed italic">
                                Every corner of Aora whispers stories of refinement and grace—from the handcrafted details in our suites to the warm welcomes that greet each guest.
                            </p>
                            <p class="text-base leading-relaxed italic">
                                We craft authentic experiences that celebrate the spirit of Kenya: sunset safaris, culinary journeys through local flavors, and moments of pure tranquility in nature's embrace.
                            </p>
                        </div>
                        
                        <!-- Cultural Elements Grid -->
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="group">
                                <div class="w-16 h-16 mx-auto bg-[#5c4a3a]/20 rounded-full flex items-center justify-center mb-2 group-hover:bg-[#5c4a3a]/40 transition-all duration-300">
                                    <i class="fas fa-music text-2xl text-[#5c4a3a]"></i>
                                </div>
                                <p class="text-[#3f352e] text-sm">Rhythms of Kenya</p>
                            </div>
                            <div class="group">
                                <div class="w-16 h-16 mx-auto bg-[#5c4a3a]/20 rounded-full flex items-center justify-center mb-2 group-hover:bg-[#5c4a3a]/40 transition-all duration-300">
                                    <i class="fas fa-palette text-2xl text-[#5c4a3a]"></i>
                                </div>
                                <p class="text-[#3f352e] text-sm">Artisan Crafts</p>
                            </div>
                            <div class="group">
                                <div class="w-16 h-16 mx-auto bg-[#5c4a3a]/20 rounded-full flex items-center justify-center mb-2 group-hover:bg-[#5c4a3a]/40 transition-all duration-300">
                                    <i class="fas fa-sun text-2xl text-[#5c4a3a]"></i>
                                </div>
                                <p class="text-[#3f352e] text-sm">Golden Moments</p>
                            </div>
                        </div>
                        
                        <!-- Cultural Quote -->
                        <div class="mt-10 pt-6 border-t border-[#5c4a3a]/20">
                            <p class="font-['Cormorant_Garamond'] text-xl italic text-[#5c4a3a]">
                                "Aora is where every moment becomes a cherished memory."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== EXPERIENCE HIGHLIGHTS SECTION (NEW) ===== -->
        <section class="relative py-28 px-6 bg-[#1a3a4a] overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Kenyan Safari" 
                     class="w-full h-full object-cover opacity-10">
                <div class="absolute inset-0 bg-gradient-to-br from-[#1a3a4a]/95 via-[#1a3a4a]/90 to-[#1a3a4a]/95"></div>
            </div>
            
            <div class="max-w-6xl mx-auto relative z-10">
                <!-- Section Header - Light Text -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#d4b48c] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Curated For You</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-white mt-4 mb-6 font-light">Signature Experiences</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#d4b48c] to-transparent mx-auto"></div>
                </div>
                
                <!-- Experience Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Experience 1 -->
                    <div class="group relative h-96 rounded-3xl overflow-hidden shadow-2xl reveal" style="transition-delay: 0.1s;">
                        <!-- Background Image -->
                        <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                             alt="Safari" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1a3a4a] via-[#1a3a4a]/40 to-transparent opacity-90"></div>
                        
                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-0 group-hover:-translate-y-2 transition-transform duration-500">
                            <div class="w-12 h-12 rounded-full bg-[#d4b48c] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-paw text-white text-xl"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2">Safari Adventures</h3>
                            <p class="text-white/80 text-sm mb-3">Private game drives with expert Maasai guides</p>
                            <div class="flex items-center gap-2 text-[#d4b48c] text-xs uppercase tracking-wider cursor-pointer" onclick="openModal('safari')">
                                <span>Learn more</span>
                                <i class="fas fa-arrow-right transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Experience 2 -->
                    <div class="group relative h-96 rounded-3xl overflow-hidden shadow-2xl reveal" style="transition-delay: 0.2s;">
                        <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Sunset Dining" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1a3a4a] via-[#1a3a4a]/40 to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-0 group-hover:-translate-y-2 transition-transform duration-500">
                            <div class="w-12 h-12 rounded-full bg-[#d4b48c] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-utensils text-white text-xl"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2">Bush Dinners</h3>
                            <p class="text-white/80 text-sm mb-3">Candlelit feasts under the African stars</p>
                            <div class="flex items-center gap-2 text-[#d4b48c] text-xs uppercase tracking-wider cursor-pointer" onclick="openModal('bush')">
                                <span>Learn more</span>
                                <i class="fas fa-arrow-right transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Experience 3 -->
                    <div class="group relative h-96 rounded-3xl overflow-hidden shadow-2xl reveal" style="transition-delay: 0.3s;">
                        <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2068&q=80" 
                             alt="Cultural Tour" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1a3a4a] via-[#1a3a4a]/40 to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-0 group-hover:-translate-y-2 transition-transform duration-500">
                            <div class="w-12 h-12 rounded-full bg-[#d4b48c] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-hands text-white text-xl"></i>
                            </div>
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-white mb-2">Cultural Immersion</h3>
                            <p class="text-white/80 text-sm mb-3">Visit local villages and learn ancient traditions</p>
                            <div class="flex items-center gap-2 text-[#d4b48c] text-xs uppercase tracking-wider cursor-pointer" onclick="openModal('cultural')">
                                <span>Learn more</span>
                                <i class="fas fa-arrow-right transition-transform"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Call to Action -->
                <div class="text-center mt-12 reveal" style="transition-delay: 0.4s;">
                    <a href="#" class="group inline-flex items-center gap-3 px-8 py-4 bg-transparent border border-white/30 text-white rounded-full hover:bg-white/10 transition-all duration-300">
                        <span class="text-sm uppercase tracking-wider">Discover All Experiences</span>
                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Templates -->
    <div id="modal-safari" class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="closeModal('safari')"></div>
        <!-- Modal Content -->
        <div class="relative top-4 left-1/2 transform -translate-x-1/2 md:translate-y-0 md:top-20 w-full max-w-2xl mx-auto px-4 mb-4 md:mb-20">
            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
                <!-- Close Button -->
                <button class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/80 rounded-full flex items-center justify-center hover:bg-white transition-colors" onclick="closeModal('safari')">
                    <i class="fas fa-times text-gray-600 text-lg"></i>
                </button>
                <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" 
                     alt="Safari Adventures" 
                     class="w-full h-64 object-cover">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-[#d4b48c] flex items-center justify-center">
                            <i class="fas fa-paw text-white text-xl"></i>
                        </div>
                        <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#3f352e]">Safari Adventures</h3>
                    </div>
                    <p class="text-[#5c524a] leading-relaxed mb-6">
                        Experience the thrill of a lifetime with our exclusive private game drives through Kenya's most spectacular reserves. 
                        Led by expert guides with decades of experience tracking wildlife, you'll witness the Big Five in their natural habitat 
                        while learning about the delicate ecosystem that sustains them.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Private 4x4 safari vehicle with expert guide</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Full-day and half-day options available</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Breakfast or sunset picnic included</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Visit to authentic Maasai villages</span>
                        </li>
                    </ul>
                    <p class="text-lg italic text-[#8a735b]">
                        "The safari of a lifetime awaits at Aora."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-bush" class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="closeModal('bush')"></div>
        <!-- Modal Content -->
        <div class="relative top-4 left-1/2 transform -translate-x-1/2 md:translate-y-0 md:top-20 w-full max-w-2xl mx-auto px-4 mb-4 md:mb-20">
            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
                <!-- Close Button -->
                <button class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/80 rounded-full flex items-center justify-center hover:bg-white transition-colors" onclick="closeModal('bush')">
                    <i class="fas fa-times text-gray-600 text-lg"></i>
                </button>
                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Bush Dinners" 
                     class="w-full h-64 object-cover">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-[#d4b48c] flex items-center justify-center">
                            <i class="fas fa-utensils text-white text-xl"></i>
                        </div>
                        <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#3f352e]">Bush Dinners</h3>
                    </div>
                    <p class="text-[#5c524a] leading-relaxed mb-6">
                        Indulge in an unforgettable dining experience beneath the African sky. Our bush dinners combine exquisite 
                        cuisine with the magic of the wilderness, featuring candlelit settings in secluded locations surrounded 
                        by nature's symphony.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Multi-course gourmet menu by our award-winning chefs</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Premium wine and cocktail selection</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Private butler service</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Traditional entertainment on request</span>
                        </li>
                    </ul>
                    <p class="text-lg italic text-[#8a735b]">
                        "Dining under the stars, where memories are made."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-cultural" class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="closeModal('cultural')"></div>
        <!-- Modal Content -->
        <div class="relative top-4 left-1/2 transform -translate-x-1/2 md:translate-y-0 md:top-20 w-full max-w-2xl mx-auto px-4 mb-4 md:mb-20">
            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
                <!-- Close Button -->
                <button class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/80 rounded-full flex items-center justify-center hover:bg-white transition-colors" onclick="closeModal('cultural')">
                    <i class="fas fa-times text-gray-600 text-lg"></i>
                </button>
                <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2068&q=80" 
                     alt="Cultural Immersion" 
                     class="w-full h-64 object-cover">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-[#d4b48c] flex items-center justify-center">
                            <i class="fas fa-hands text-white text-xl"></i>
                        </div>
                        <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#3f352e]">Cultural Immersion</h3>
                    </div>
                    <p class="text-[#5c524a] leading-relaxed mb-6">
                        Connect with Kenya's rich heritage through authentic cultural experiences. From traditional village visits 
                        to hands-on craft workshops, discover the stories, traditions, and warm hospitality that make this region unique.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Guided visits to local communities</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Traditional beadwork and craft workshops</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Storytelling evenings with local elders</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#5c524a]">
                            <i class="fas fa-check-circle text-[#d4b48c]"></i>
                            <span>Traditional dance performances</span>
                        </li>
                    </ul>
                    <p class="text-lg italic text-[#8a735b]">
                        "Touch the heart of Kenya through its people."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Reveal Script -->
    <script>
        (function() {
            // Reveal elements on scroll
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
            
            // Simple parallax effect for hero
            window.addEventListener('scroll', function() {
                const scrolled = window.scrollY;
                const parallax = document.getElementById('parallaxBg');
                if (parallax) {
                    parallax.style.transform = `translateY(${scrolled * 0.3}px)`;
                }
            });
        })();
        
        // Global Modal functions
        function openModal(modalId) {
            const modal = document.getElementById('modal-' + modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeModal(modalId) {
            const modal = document.getElementById('modal-' + modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-"]').forEach(modal => {
                    modal.classList.add('hidden');
                });
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>
</html>