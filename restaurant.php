<?php 
include 'header.php';

// Get table types for special dining experiences
include 'database.php';
$diningExperiences = getAllTableTypes($pdo);

// Get signature dishes from database
$signatureDishes = getSignatureDishes($pdo);

// Get sample menus from database
$sampleMenus = getAllSampleMenus($pdo);
?>

<style>
@media (min-width: 1024px) {
    section.relative.h-screen { margin-top: 150px; }
}
@media (max-width: 1023px) {
    section.relative.h-screen { margin-top: 80px; }
}
</style>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant & Fine Dining at Aora45 | Best Restaurant Nairobi</title>
    <meta name="description" content="Experience exquisite dining at Aora45 restaurant in Nairobi. Our award-winning chefs serve Swahili-inspired cuisine with international techniques. Book a table for lunch, dinner, or special events.">
    <meta name="keywords" content="restaurant Nairobi, fine dining Kenya, Swahili cuisine, Aora45 restaurant, best restaurants Nairobi, dining experience, hotel restaurant, breakfast lunch dinner Nairobi, special events catering">
    <!-- Open Graph -->
    <meta property="og:title" content="Restaurant & Fine Dining at Aora45">
    <meta property="og:description" content="Experience exquisite dining at Aora45 restaurant in Nairobi. Our award-winning chefs serve Swahili-inspired cuisine.">
    <meta property="og:type" content="restaurant.restaurant">
    <meta property="og:url" content="https://aora45.com/restaurant.php">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Restaurant & Fine Dining at Aora45">
    <meta name="twitter:description" content="Experience exquisite dining at Aora45 restaurant in Nairobi.">
    <!-- Schema.org Restaurant -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Restaurant",
        "name": "Aora45 Restaurant",
        "description": "Fine dining restaurant serving modern Kenyan cuisine",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Nairobi",
            "addressCountry": "KE"
        },
        "telephone": "+254700000000",
        "priceRange": "KSh 1,200 - KSh 4,800",
        "servesCuisine": ["Kenyan", "Swahili", "International"],
        "openingHoursSpecification": [
            {"@type": "OpeningHoursSpecification", "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"], "opens": "07:00", "closes": "22:30"},
            {"@type": "OpeningHoursSpecification", "dayOfWeek": "Sunday", "opens": "11:00", "closes": "15:00"}
        ]
    }
    </script>
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
                    <?php 
                    $delay = 0.1;
                    foreach ($signatureDishes as $index => $dish): 
                        $dishKey = strtolower(str_replace(' ', '', $dish['name']));
                    ?>
                    <div class="dish-item group h-[400px] relative reveal" style="transition-delay: <?php echo $delay; ?>s;" onclick="openDishModal('<?php echo $dishKey; ?>')">
                        <img src="<?php echo htmlspecialchars($dish['image']); ?>" 
                             alt="<?php echo htmlspecialchars($dish['name']); ?>" 
                             class="w-full h-full object-cover">
                        <div class="dish-overlay"></div>
                        <div class="dish-content">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-white mb-2"><?php echo htmlspecialchars($dish['name']); ?></h3>
                            <p class="text-white/80 text-sm mb-3"><?php echo htmlspecialchars($dish['description']); ?></p>
                            <div class="flex items-center gap-2 text-[#b89a78] text-sm">
                                <span>View details</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $delay += 0.1;
                    endforeach; 
                    ?>
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
                    <?php 
                    $delay = 0.1;
                    foreach ($sampleMenus as $index => $menu): 
                        $isEven = $index % 2 === 0;
                    ?>
                    <div class="sample-menu-block <?php echo $index === 0 ? 'reveal-left' : ($index === 2 ? 'reveal-right' : 'reveal'); ?>" style="transition-delay: <?php echo $delay; ?>s;">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#2c3e4a]"><?php echo htmlspecialchars($menu['title']); ?></h3>
                            <span class="text-[#b89a78] text-sm"><?php echo htmlspecialchars($menu['subtitle']); ?></span>
                        </div>
                        
                        <div class="space-y-3 mb-8">
                            <?php foreach ($menu['items'] as $item): ?>
                            <div class="menu-item">
                                <span class="text-[#5c524a]"><?php echo htmlspecialchars($item['name']); ?></span>
                                <span class="text-[#8a735b] text-sm font-medium"><?php echo htmlspecialchars($item['price']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <a href="#" class="inline-flex items-center gap-2 text-[#b89a78] hover:text-[#8a735b] transition-colors text-sm">
                            <i class="fas fa-file-pdf"></i>
                            <span>Download Menu (PDF)</span>
                        </a>
                    </div>
                    <?php 
                        $delay += 0.1;
                    endforeach; 
                    ?>
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
                
                <!-- Experiences Grid - Loaded from Database -->
                <div class="space-y-20">
                    <?php 
                    $delay = 0.1;
                    foreach ($diningExperiences as $index => $experience): 
                        $isEven = $index % 2 === 0;
                    ?>
                    <div class="grid lg:grid-cols-2 gap-12 items-center <?php echo $isEven ? 'reveal-left' : 'reveal-right'; ?>" style="transition-delay: <?php echo $delay; ?>s;">
                        <?php if ($isEven): ?>
                        <div>
                            <div class="relative h-[400px] overflow-hidden">
                                <img src="<?php echo htmlspecialchars($experience['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($experience['name']); ?>" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                        <div>
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-4"><?php echo htmlspecialchars($experience['name']); ?></h3>
                            <div class="w-16 h-px bg-[#b89a78] mb-6"></div>
                            <p class="text-[#5c524a] text-lg leading-relaxed mb-6">
                                <?php echo htmlspecialchars($experience['description']); ?>
                            </p>
                            <p class="text-[#8a735b] text-sm mb-6"><i class="fas fa-users mr-2"></i>Maximum <?php echo intval($experience['max_people']); ?> guests per table</p>
                            <button style="display: none;" onclick="reserveExperience('<?php echo htmlspecialchars($experience['name']); ?>')" class="reserve-button px-6 py-3 text-white uppercase tracking-wider text-sm">
                                Reserve This Experience
                            </button>
                        </div>
                        <?php else: ?>
                        <div class="lg:order-2">
                            <div class="relative h-[400px] overflow-hidden">
                                <img src="<?php echo htmlspecialchars($experience['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($experience['name']); ?>" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                        <div class="lg:order-1">
                            <h3 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-4"><?php echo htmlspecialchars($experience['name']); ?></h3>
                            <div class="w-16 h-px bg-[#b89a78] mb-6"></div>
                            <p class="text-[#5c524a] text-lg leading-relaxed mb-6">
                                <?php echo htmlspecialchars($experience['description']); ?>
                            </p>
                            <p class="text-[#8a735b] text-sm mb-6"><i class="fas fa-users mr-2"></i>Maximum <?php echo intval($experience['max_people']); ?> guests per table</p>
                            <button style="display: none;" onclick="reserveExperience('<?php echo htmlspecialchars($experience['name']); ?>')" class="reserve-button px-6 py-3 text-white uppercase tracking-wider text-sm">
                                Reserve This Experience
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php 
                        $delay += 0.1;
                    endforeach; 
                    ?>
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
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Join Us for Our Meals</h2>
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
                                <input type="time" id="reservationTime" required>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Guests -->
                            <div>
                                <label class="block mb-2">Number of Guests</label>
                                <select id="numGuests" required>
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
                            
                            <!-- Table Type -->
                            <div>
                                <label class="block mb-2">Table Type</label>
                                <select id="tableType" required>
                                    <option value="">Select table preference</option>
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
                        
                        <!-- Occasion -->
                        <div>
                            <label class="block mb-2">Occasion (Optional)</label>
                            <select id="occasion">
                                <option value="">Select</option>
                                <option>Birthday</option>
                                <option>Anniversary</option>
                                <option>Business</option>
                                <option>Date Night</option>
                                <option>Normal Meal</option>
                                <option>Other</option>
                            </select>
                        </div>
                        
                        <!-- Special Requests -->
                        <div>
                            <label class="block mb-2">Special Requests</label>
                            <textarea rows="3" placeholder="Dietary restrictions, allergies, or special notes..."></textarea>
                        </div>
                        
                        <!-- Pre-order Menu Items -->
                        <div>
                            <label class="block mb-2">Pre-order Menu Items (Optional)</label>
                            <p class="text-[#8a735b] text-xs mb-4">Select items you'd like to pre-order for your visit</p>
                            <div id="menuItemsCheckboxes" class="max-h-64 overflow-y-auto border border-[#b89a78]/20 rounded-lg p-4 bg-white/50">
                                <p class="text-[#8a735b] text-sm text-center py-4">Loading menu items...</p>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center pt-4">
                            <button type="button" onclick="submitReservation()" class="reserve-button px-12 py-4 text-white uppercase tracking-wider text-sm">
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
        // Dynamic dish data from PHP database
        const dishData = {};
        <?php foreach ($signatureDishes as $dish): ?>
        dishData['<?php echo strtolower(str_replace(' ', '', $dish['name'])); ?>'] = {
            name: '<?php echo addslashes($dish['name']); ?>',
            description: '<?php echo addslashes($dish['description']); ?>',
            longDescription: '<?php echo addslashes($dish['description']); ?>',
            price: 'KSh <?php echo number_format($dish['price']); ?>',
            image: '<?php echo addslashes($dish['image']); ?>',
            ingredients: '<?php echo addslashes($dish['ingredients'] ?? ''); ?>'.split(',').filter(i => i.trim()),
            spiceLevel: '<?php echo addslashes($dish['spice_level'] ?? 'Medium'); ?>',
            dietary: '<?php echo addslashes($dish['dietary_info'] ?? ''); ?>'
        };
        <?php endforeach; ?>

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
        
        // Load menu items on page load
        loadMenuItemsForCheckboxes();
        loadTableTypes();
        
        // Form submission function
        function submitReservation() {
            const form = document.querySelector('.reservation-form');
            if (!form) {
                showMessage('Form not found!', 'error');
                return;
            }
            
            // Get form values with proper selectors
            const date = form.querySelector('input[type="date"]')?.value || '';
            const time = form.querySelector('input[type="time"]')?.value || '';
            const guests = form.querySelector('#numGuests')?.value || '';
            const tableTypeId = form.querySelector('#tableType')?.value || '';
            const firstName = form.querySelector('input[type="text"]')?.value || '';
            const lastName = form.querySelector('input[type="text"]')?.value || '';
            const email = form.querySelector('input[type="email"]')?.value || '';
            const phone = form.querySelector('input[type="tel"]')?.value || '';
            const occasion = form.querySelector('#occasion')?.value || '';
            const specialRequests = form.querySelector('textarea')?.value || '';
            
            // Debug: Log values
            console.log('Form values:', { date, time, guests, tableTypeId, firstName, lastName, email, phone });
            
            // Validation - check all required fields
            if (!date) {
                showMessage('Please select a date', 'error');
                return;
            }
            if (!time) {
                showMessage('Please select a time', 'error');
                return;
            }
            if (!guests) {
                showMessage('Please select number of guests', 'error');
                return;
            }
            if (!tableTypeId) {
                showMessage('Please select a table type', 'error');
                return;
            }
            if (!firstName) {
                showMessage('Please enter your first name', 'error');
                return;
            }
            if (!lastName) {
                showMessage('Please enter your last name', 'error');
                return;
            }
            if (!email) {
                showMessage('Please enter your email', 'error');
                return;
            }
            if (!phone) {
                showMessage('Please enter your phone number', 'error');
                return;
            }
            
            // Get selected menu items
            const selectedItems = [];
            document.querySelectorAll('.menu-item-checkbox:checked').forEach(checkbox => {
                selectedItems.push(checkbox.value);
            });
            
            const formData = new FormData();
            formData.append('action', 'create_restaurant_reservation');
            formData.append('table_type_id', tableTypeId);
            formData.append('reservation_date', date);
            formData.append('reservation_time', time);
            formData.append('num_guests', guests);
            formData.append('first_name', firstName);
            formData.append('last_name', lastName);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('occasion', occasion);
            formData.append('selected_items', selectedItems.join(', '));
            formData.append('special_requests', specialRequests);
            
            // Show loader
            showLoader();
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoader();
                
                if (data.success) {
                    showMessage('Thank you! Your reservation has been confirmed. Check your email for confirmation details.', 'success');
                    form.reset();
                    // Uncheck all checkboxes
                    document.querySelectorAll('.menu-item-checkbox').forEach(cb => cb.checked = false);
                } else {
                    showMessage('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                hideLoader();
                console.error('Error:', error);
                showMessage('An error occurred. Please try again.', 'error');
            });
        }
        
        // Show message function (replaces alert)
        function showMessage(message, type) {
            // Remove existing message if any
            const existingMsg = document.getElementById('formMessage');
            if (existingMsg) existingMsg.remove();
            
            const msgDiv = document.createElement('div');
            msgDiv.id = 'formMessage';
            msgDiv.style.cssText = 'position:fixed;top:20px;left:50%;transform:translateX(-50%);z-index:10000;padding:15px 30px;border-radius:8px;font-weight:500;max-width:90%;word-wrap:break-word;';
            
            if (type === 'success') {
                msgDiv.style.background = '#10b981';
                msgDiv.style.color = 'white';
            } else {
                msgDiv.style.background = '#ef4444';
                msgDiv.style.color = 'white';
            }
            
            msgDiv.innerHTML = message;
            document.body.appendChild(msgDiv);
            
            // Auto remove after 5 seconds
            setTimeout(() => msgDiv.remove(), 5000);
        }
        
        // Show loader function
        function showLoader() {
            // Remove existing loader if any
            const existingLoader = document.getElementById('formLoader');
            if (existingLoader) return;
            
            const loader = document.createElement('div');
            loader.id = 'formLoader';
            loader.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:9999;display:flex;justify-content:center;align-items:center;flex-direction:column;';
            loader.innerHTML = `
                <div style="text-align:center;">
                    <div style="width:60px;height:60px;border:4px solid #f3f3f3;border-top:4px solid #b89a78;border-radius:50%;animation:spin 1s linear infinite;"></div>
                    <p style="color:white;margin-top:20px;font-size:18px;">Submitting your reservation...</p>
                </div>
                <style>@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}</style>
            `;
            document.body.appendChild(loader);
        }
        
        // Hide loader function
        function hideLoader() {
            const loader = document.getElementById('formLoader');
            if (loader) loader.remove();
        }
        
        // Also keep the form submit handler as backup
        document.querySelector('.reservation-form').addEventListener('submit', function(e) {
            e.preventDefault();
            submitReservation();
        });
        
        // Load menu items for checkboxes on page load
        function loadMenuItemsForCheckboxes() {
            const formData = new FormData();
            formData.append('action', 'get_menu_items');
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderMenuItemCheckboxes(data.items);
                }
            })
            .catch(error => console.error('Error loading menu items:', error));
        }
        
        function renderMenuItemCheckboxes(items) {
            const container = document.getElementById('menuItemsCheckboxes');
            if (!container) return;
            
            // Group items by category
            const groupedItems = {};
            items.forEach(item => {
                const category = item.category_name || 'Other';
                if (!groupedItems[category]) {
                    groupedItems[category] = [];
                }
                groupedItems[category].push(item);
            });
            
            let html = '';
            for (const [category, categoryItems] of Object.entries(groupedItems)) {
                html += `<div class="mb-4">`;
                html += `<h4 class="text-[#8a735b] text-xs uppercase mb-2 font-semibold">${category}</h4>`;
                html += `<div class="grid grid-cols-1 md:grid-cols-2 gap-2">`;
                
                categoryItems.forEach(item => {
                    const price = parseFloat(item.price).toLocaleString();
                    html += `
                        <label class="flex items-center gap-2 p-2 border border-[#b89a78]/20 rounded-lg hover:bg-[#f4ede5] cursor-pointer transition-colors">
                            <input type="checkbox" class="menu-item-checkbox" value="${item.name} - KSh ${price}">
                            <span class="text-[#5c524a] text-sm">${item.name}</span>
                            <span class="text-[#b89a78] text-xs ml-auto">KSh ${price}</span>
                        </label>
                    `;
                });
                
                html += `</div>`;
                html += `</div>`;
            }
            
            container.innerHTML = html;
        }
        
        // Function to reserve dining experience
        function reserveExperience(experienceTitle) {
            document.querySelector('.reservation-form').scrollIntoView({ behavior: 'smooth' });
            // Pre-fill occasion with experience name
            const occasionSelect = document.querySelector('#occasion');
            if (occasionSelect) {
                occasionSelect.value = experienceTitle;
            }
        }
        
        // Load table types on page load
        function loadTableTypes() {
            const formData = new FormData();
            formData.append('action', 'get_table_types');
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderTableTypeSelect(data.table_types);
                } else {
                    // Fallback to default options if API fails
                    renderTableTypeSelectFallback();
                }
            })
            .catch(error => {
                console.error('Error loading table types:', error);
                // Fallback to default options
                renderTableTypeSelectFallback();
            });
        }
        
        function renderTableTypeSelectFallback() {
            const select = document.getElementById('tableType');
            if (!select) return;
            
            // Clear existing options except the first one
            while (select.options.length > 1) {
                select.remove(1);
            }
            
            // Default fallback options
            const fallbackOptions = [
                { id: 1, name: "The Chef's Table", max_people: 6 },
                { id: 2, name: 'Private Dining Room', max_people: 16 },
                { id: 3, name: 'Garden Terrace', max_people: 12 },
                { id: 4, name: 'Main Dining', max_people: 8 },
                { id: 5, name: 'Window Seat', max_people: 4 },
                { id: 6, name: 'Bar Area', max_people: 4 }
            ];
            
            fallbackOptions.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = `${type.name} (Max ${type.max_people} guests)`;
                select.appendChild(option);
            });
        }
        
        function renderTableTypeSelect(tableTypes) {
            const select = document.getElementById('tableType');
            if (!select) return;
            
            // Clear existing options except the first one
            while (select.options.length > 1) {
                select.remove(1);
            }
            
            tableTypes.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = `${type.name} (Max ${type.max_people} guests)`;
                select.appendChild(option);
            });
        }
    </script>
<?php include 'footer.php'; ?>