<?php 
include 'header.php';

// Include database connection
include 'database.php';

// Get all event venues from database
$eventVenues = getAllEventVenues($pdo);

// Handle form submission
$inquirySuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inquiry_submitted'])) {
    $inquiryData = [
        'venue_id' => isset($_POST['venue_id']) ? $_POST['venue_id'] : NULL,
        'event_type' => $_POST['event_type'],
        'guest_name' => $_POST['guest_name'],
        'guest_email' => $_POST['guest_email'],
        'guest_phone' => $_POST['guest_phone'],
        'event_date' => $_POST['event_date'],
        'guest_count' => $_POST['guest_count'],
        'message' => $_POST['message']
    ];
    
    $result = createEventInquiry($pdo, $inquiryData);
    $inquirySuccess = true;
}
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
    <title>Aora - Celebrate at Aora</title>
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
        
        @keyframes scaleIn {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        @keyframes borderGlow {
            0%, 100% { border-color: rgba(184, 154, 120, 0.3); }
            50% { border-color: rgba(184, 154, 120, 0.8); }
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
        
        /* Event Section Styles */
        .event-section {
            position: relative;
            overflow: hidden;
        }
        
        .event-image {
            transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .event-section:hover .event-image {
            transform: scale(1.05);
        }
        
        .event-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(44,62,74,0.9), rgba(44,62,74,0.6));
            opacity: 0.8;
            transition: opacity 0.5s ease;
        }
        
        .event-section:hover .event-overlay {
            opacity: 0.9;
        }
        
        .event-content {
            position: relative;
            z-index: 10;
        }
        
        /* Space Card Unique Design */
        .space-card {
            position: relative;
            background: white;
            border: 1px solid rgba(184, 154, 120, 0.2);
            transition: all 0.4s ease;
            overflow: hidden;
        }
        
        .space-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #b89a78, #8a735b, #b89a78);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        
        .space-card:hover::before {
            transform: translateX(0);
        }
        
        .space-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 50px -20px rgba(0,0,0,0.3);
            border-color: rgba(184, 154, 120, 0.4);
        }
        
        .space-card .card-image {
            overflow: hidden;
            position: relative;
        }
        
        .space-card .card-image img {
            transition: transform 0.8s ease;
        }
        
        .space-card:hover .card-image img {
            transform: scale(1.08);
        }
        
        .space-card .capacity-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(4px);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.8rem;
            color: #2c3e4a;
            border: 1px solid rgba(184, 154, 120, 0.3);
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        .space-card:hover .capacity-badge {
            background: #b89a78;
            color: white;
            border-color: #b89a78;
        }
        
        .space-card .feature-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #5c524a;
            border-bottom: 1px dashed rgba(184, 154, 120, 0.2);
            padding: 0.75rem 0;
        }
        
        .space-card .feature-item:last-child {
            border-bottom: none;
        }
        
        .space-card .feature-item i {
            color: #b89a78;
            width: 20px;
        }
        
        /* Button Styles */
        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            z-index: 1;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
            z-index: -1;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(184, 154, 120, 0.4);
        }
        
        /* Form Styles */
        .inquiry-form input,
        .inquiry-form select,
        .inquiry-form textarea {
            width: 100%;
            padding: 0.75rem 0;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(184, 154, 120, 0.3);
            transition: all 0.3s ease;
        }
        
        .inquiry-form input:focus,
        .inquiry-form select:focus,
        .inquiry-form textarea:focus {
            outline: none;
            border-bottom-color: #b89a78;
        }
        
        .inquiry-form label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #8a735b;
            margin-bottom: 0.25rem;
            display: block;
        }
        
        /* Decorative Elements */
        .gold-divider {
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #b89a78, transparent);
            margin: 1rem 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .event-content {
                padding: 2rem;
            }
            
            .space-card .capacity-badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.8rem;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#fcf8f3]">
    <main class="relative">
        <!-- ===== HERO SECTION ===== -->
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <!-- Background Image - Celebration -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Celebration at Aora" 
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
                    <span class="block reveal-left" style="transition-delay: 0.2s;">Celebrate</span>
                    <span class="block reveal-right text-[#b89a78]" style="transition-delay: 0.4s;">at Aora</span>
                </h1>
                
                <!-- Decorative Element -->
                <div class="relative flex justify-center items-center gap-4 mb-12">
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                    <i class="fas fa-glass-cheers text-[#b89a78] text-xl"></i>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                </div>
                
                <!-- Subheading -->
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 max-w-2xl mx-auto italic leading-relaxed reveal" style="transition-delay: 0.6s;">
                    "Where every moment becomes a cherished memory"
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

        <!-- ===== WEDDING SECTION ===== -->
        <section class="event-section relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Left Column - Image -->
                    <div class="relative h-[500px] overflow-hidden reveal-left">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Wedding Setup" 
                             class="event-image w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#2c3e4a]/40 to-transparent"></div>
                        
                        <!-- Floating Decoration -->
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 border border-[#b89a78]/30 rounded-full animate-float-slow"></div>
                        <div class="absolute -top-10 -left-10 w-40 h-40 border border-[#b89a78]/20 rounded-full animate-float"></div>
                    </div>
                    
                    <!-- Right Column - Content -->
                    <div class="reveal-right">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-px bg-[#b89a78]"></div>
                            <span class="text-[#8a735b] text-xs uppercase tracking-widest">Forever Begins Here</span>
                        </div>
                        
                        <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mb-8 leading-tight">
                            Weddings at <span class="text-[#b89a78]">Aora</span>
                        </h2>
                        
                        <p class="text-[#5c524a] text-lg leading-relaxed mb-8">
                            Your dream wedding awaits in our stunning venues. From intimate ceremonies to grand celebrations, 
                            we create moments that last a lifetime.
                        </p>
                        
                        <!-- Packages -->
                        <div class="space-y-6 mb-8">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-[#b89a78]/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check text-[#b89a78]"></i>
                                </div>
                                <div>
                                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a] mb-1">All-Inclusive Package</h3>
                                    <p class="text-[#8a735b] text-sm">Venue, catering, decor, photography, and coordination</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-[#b89a78]/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check text-[#b89a78]"></i>
                                </div>
                                <div>
                                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a] mb-1">Ceremony Only</h3>
                                    <p class="text-[#8a735b] text-sm">Beautiful ceremony spaces with essential arrangements</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-[#b89a78]/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check text-[#b89a78]"></i>
                                </div>
                                <div>
                                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a] mb-1">Reception Only</h3>
                                    <p class="text-[#8a735b] text-sm">Elegant reception spaces with customizable menus</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Button -->
                        <button onclick="openInquiryForm('wedding')" class="btn-primary relative px-8 py-4 bg-[#b89a78] text-white text-sm uppercase tracking-wider overflow-hidden group">
                            <span class="relative z-10 flex items-center gap-2">
                                Inquire About Weddings
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CORPORATE EVENTS SECTION ===== -->
        <section class="event-section relative py-24 px-6 bg-[#f4ede5] overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Left Column - Content -->
                    <div class="reveal-left order-2 lg:order-1">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-px bg-[#b89a78]"></div>
                            <span class="text-[#8a735b] text-xs uppercase tracking-widest">Business Excellence</span>
                        </div>
                        
                        <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mb-8 leading-tight">
                            Corporate <span class="text-[#b89a78]">Events</span>
                        </h2>
                        
                        <p class="text-[#5c524a] text-lg leading-relaxed mb-8">
                            Impress clients and inspire teams in our state-of-the-art venues. Perfect for conferences, 
                            board meetings, and corporate retreats.
                        </p>
                        
                        <!-- Features -->
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-building text-[#b89a78] w-6"></i>
                                <span class="text-[#5c524a]">Multiple meeting halls (20-200 capacity)</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-wifi text-[#b89a78] w-6"></i>
                                <span class="text-[#5c524a]">High-speed WiFi and video conferencing</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-utensils text-[#b89a78] w-6"></i>
                                <span class="text-[#5c524a]">Customizable catering and coffee breaks</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-microphone text-[#b89a78] w-6"></i>
                                <span class="text-[#5c524a]">Professional AV equipment and support</span>
                            </div>
                        </div>
                        
                        <!-- Button -->
                        <button onclick="openInquiryForm('corporate')" class="btn-primary relative px-8 py-4 bg-[#b89a78] text-white text-sm uppercase tracking-wider overflow-hidden group">
                            <span class="relative z-10 flex items-center gap-2">
                                Plan Your Corporate Event
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </button>
                    </div>
                    
                    <!-- Right Column - Image -->
                    <div class="relative h-[500px] overflow-hidden reveal-right order-1 lg:order-2">
                        <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" 
                             alt="Corporate Event" 
                             class="event-image w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#2c3e4a]/40 to-transparent"></div>
                        
                        <!-- Floating Decoration -->
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 border border-[#b89a78]/30 rounded-full animate-float-slow"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== PRIVATE PARTIES SECTION ===== -->
        <section class="event-section relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Left Column - Image -->
                    <div class="relative h-[500px] overflow-hidden reveal-left">
                        <img src="https://images.unsplash.com/photo-1530103862676-de8c9debad1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Private Party" 
                             class="event-image w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#2c3e4a]/40 to-transparent"></div>
                        
                        <!-- Floating Decoration -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 border border-[#b89a78]/30 rounded-full animate-float"></div>
                    </div>
                    
                    <!-- Right Column - Content -->
                    <div class="reveal-right">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-px bg-[#b89a78]"></div>
                            <span class="text-[#8a735b] text-xs uppercase tracking-widest">Celebrate Life</span>
                        </div>
                        
                        <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mb-8 leading-tight">
                            Private <span class="text-[#b89a78]">Parties</span>
                        </h2>
                        
                        <p class="text-[#5c524a] text-lg leading-relaxed mb-8">
                            Birthdays, anniversaries, reunions—whatever the occasion, we create unforgettable 
                            celebrations tailored to your vision.
                        </p>
                        
                        <!-- Options -->
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div class="text-center p-4 border border-[#b89a78]/20 hover:border-[#b89a78] transition-all">
                                <i class="fas fa-birthday-cake text-3xl text-[#b89a78] mb-2"></i>
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-[#2c3e4a]">Birthdays</h3>
                            </div>
                            <div class="text-center p-4 border border-[#b89a78]/20 hover:border-[#b89a78] transition-all">
                                <i class="fas fa-heart text-3xl text-[#b89a78] mb-2"></i>
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-[#2c3e4a]">Anniversaries</h3>
                            </div>
                            <div class="text-center p-4 border border-[#b89a78]/20 hover:border-[#b89a78] transition-all">
                                <i class="fas fa-users text-3xl text-[#b89a78] mb-2"></i>
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-[#2c3e4a]">Reunions</h3>
                            </div>
                            <div class="text-center p-4 border border-[#b89a78]/20 hover:border-[#b89a78] transition-all">
                                <i class="fas fa-gift text-3xl text-[#b89a78] mb-2"></i>
                                <h3 class="font-['Cormorant_Garamond'] text-lg text-[#2c3e4a]">Milestones</h3>
                            </div>
                        </div>
                        
                        <!-- Note -->
                        <p class="text-[#8a735b] text-sm italic">
                            Fully customizable menus, decor, and entertainment options available.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== EVENT SPACES OVERVIEW ===== -->
        <section class="relative py-24 px-6 bg-[#f4ede5] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Our Venues</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Event Spaces</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Spaces Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php if (!empty($eventVenues)): ?>
                        <?php foreach ($eventVenues as $index => $venue): ?>
                        <?php $features = json_decode($venue['features'], true); ?>
                        <div class="space-card rounded-2xl overflow-hidden reveal" style="transition-delay: <?php echo $index * 0.1; ?>s;">
                            <div class="card-image relative h-64">
                                <img src="<?php echo htmlspecialchars($venue['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($venue['name']); ?>" 
                                     class="w-full h-full object-cover">
                                <div class="capacity-badge">
                                    <i class="fas fa-users mr-2"></i><?php echo htmlspecialchars($venue['capacity']); ?>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#2c3e4a] mb-3"><?php echo htmlspecialchars($venue['name']); ?></h3>
                                
                                <div class="space-y-2 mb-4">
                                    <?php if (!empty($venue['size'])): ?>
                                    <div class="feature-item">
                                        <i class="fas fa-ruler-combined"></i>
                                        <span><?php echo htmlspecialchars($venue['size']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($features) && is_array($features)): ?>
                                        <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                                        <div class="feature-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span><?php echo htmlspecialchars($feature); ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                
                                <p class="text-[#8a735b] text-sm mb-4">
                                    <?php echo htmlspecialchars($venue['description']); ?>
                                </p>
                                
                                <button onclick="openInquiryForm('<?php echo htmlspecialchars($venue['slug']); ?>')" class="text-[#b89a78] hover:text-[#8a735b] transition-colors text-sm flex items-center gap-2 group">
                                    <span>Send Inquiry</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback if no venues in database -->
                        <div class="space-card rounded-2xl overflow-hidden reveal">
                            <div class="card-image relative h-64">
                                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                                     alt="Grand Ballroom" 
                                     class="w-full h-full object-cover">
                                <div class="capacity-badge">
                                    <i class="fas fa-users mr-2"></i>Up to 200 guests
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#2c3e4a] mb-3">The Grand Ballroom</h3>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="feature-item">
                                        <i class="fas fa-ruler-combined"></i>
                                        <span>450 m² • Column-free</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-chandelier"></i>
                                        <span>Crystal chandeliers</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-music"></i>
                                        <span>Built-in sound system</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-glass-cheers"></i>
                                        <span>Private bar and lounge</span>
                                    </div>
                                </div>
                                
                                <p class="text-[#8a735b] text-sm mb-4">
                                    Our most elegant space, perfect for grand weddings and galas.
                                </p>
                                
                                <button onclick="openInquiryForm('ballroom')" class="text-[#b89a78] hover:text-[#8a735b] transition-colors text-sm flex items-center gap-2 group">
                                    <span>Send Inquiry</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- ===== EVENT BOOKING INQUIRY FORM ===== -->
        <section class="relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-4xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-12 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Plan Your Event</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Send Inquiry</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                    <p class="text-[#8a735b] text-sm max-w-2xl mx-auto mt-6">
                        Tell us about your vision, and we'll create a customized proposal.
                    </p>
                </div>
                
                <!-- Success Message -->
                <?php if ($inquirySuccess): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8 text-center">
                    <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                    <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#2c3e4a] mb-2">Thank You for Your Inquiry!</h3>
                    <p class="text-[#8a735b]">Our events team will contact you within 24 hours.</p>
                </div>
                <?php endif; ?>
                
                <!-- Form -->
                <div class="bg-[#f4ede5] p-8 md:p-12 reveal">
                    <form class="inquiry-form space-y-8" id="eventInquiryForm" method="POST" action="#inquiry">
                        <input type="hidden" name="inquiry_submitted" value="1">
                        <input type="hidden" id="venueId" name="venue_id" value="">
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Name -->
                            <div>
                                <label>Your Name</label>
                                <input type="text" name="guest_name" placeholder="John Kim" required>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label>Email Address</label>
                                <input type="email" name="guest_email" placeholder="john@example.com" required>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Event Type -->
                            <div>
                                <label>Event Type</label>
                                <select id="eventTypeSelect" name="event_type" required>
                                    <option value="" disabled selected>Select event type</option>
                                    <option value="wedding">Wedding</option>
                                    <option value="corporate">Corporate Event</option>
                                    <option value="private">Private Party</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <!-- Date -->
                            <div>
                                <label>Preferred Date</label>
                                <input type="date" name="event_date" required>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Guest Count -->
                            <div>
                                <label>Expected Guests</label>
                                <select name="guest_count" required>
                                    <option value="" disabled selected>Select range</option>
                                    <option>1-20 guests</option>
                                    <option>21-50 guests</option>
                                    <option>51-100 guests</option>
                                    <option>101-150 guests</option>
                                    <option>151-200 guests</option>
                                    <option>200+ guests</option>
                                </select>
                            </div>
                            
                            <!-- Phone -->
                            <div>
                                <label>Phone Number</label>
                                <input type="tel" name="guest_phone" placeholder="+254 XXX XXX" required>
                            </div>
                        </div>
                        
                        <!-- Message -->
                        <div>
                            <label>Tell us about your event</label>
                            <textarea name="message" rows="4" placeholder="Share your vision, special requirements, and any questions..."></textarea>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center pt-4">
                            <button type="submit" class="btn-primary px-12 py-4 bg-[#b89a78] text-white text-sm uppercase tracking-wider">
                                Submit Inquiry
                            </button>
                        </div>
                    </form>
                    
                    <!-- Note -->
                    <p class="text-center text-[#8a735b] text-xs mt-6">
                        We'll respond within 24 hours with availability and pricing.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Map venue slugs to IDs
        const venueSlugToId = {
            'grand-ballroom': 1,
            'beachfront': 2,
            'boardroom': 3,
            'garden-pavilion': 4,
            'rooftop': 5,
            'conference': 6,
            'wedding': null,
            'corporate': null,
            'ballroom': 1,
            'beachfront-lawn': 2
        };
        
        // Function to open inquiry form with pre-selected event type
        function openInquiryForm(eventType) {
            // Set the venue_id if it's a venue slug
            const venueIdInput = document.getElementById('venueId');
            if (venueSlugToId.hasOwnProperty(eventType)) {
                venueIdInput.value = venueSlugToId[eventType] || '';
            }
            
            const formSection = document.getElementById('eventInquiryForm');
            formSection.scrollIntoView({ behavior: 'smooth' });
            
            // Pre-select the event type in dropdown
            const eventSelect = document.getElementById('eventTypeSelect');
            if (eventSelect) {
                // Map venue types to event types
                const venueToEventType = {
                    'grand-ballroom': 'wedding',
                    'beachfront': 'wedding',
                    'boardroom': 'corporate',
                    'garden-pavilion': 'private',
                    'rooftop': 'private',
                    'conference': 'corporate'
                };
                
                if (venueToEventType[eventType]) {
                    eventSelect.value = venueToEventType[eventType];
                } else if (eventType === 'wedding' || eventType === 'corporate' || eventType === 'private' || eventType === 'other') {
                    eventSelect.value = eventType;
                }
            }
        }
        
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
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Handle URL hash for inquiry section
        if (window.location.hash === '#inquiry' || window.location.hash === '#eventInquiryForm') {
            setTimeout(() => {
                const form = document.getElementById('eventInquiryForm');
                if (form) {
                    form.scrollIntoView({ behavior: 'smooth' });
                }
            }, 100);
        }
    </script>
<?php include 'footer.php'; ?>