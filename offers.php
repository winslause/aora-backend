<?php 
require_once 'database.php';

// Get all offers from database
$allOffers = getAllOffers($pdo);

include 'header.php'; ?>

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
    <title>Exclusive Hotel Offers & Packages | AORA 45 Siaya County - Special Packages</title>
    <meta name="description" content="Book exclusive hotel offers and packages at AORA 45 Siaya County. Special deals on romantic getaways, riverfront retreats, honeymoon retreats, family adventures, and wellness escapes.">
    <meta name="keywords" content="hotel offers Siaya County, exclusive packages Kenya, riverfront packages, honeymoon packages Siaya County, romantic getaway Kenya, family getaway deals, wellness retreat Siaya County, AORA 45 special offers, hotel promotions">
    <!-- Open Graph -->
    <meta property="og:title" content="Exclusive Hotel Offers & Packages at AORA 45">
    <meta property="og:description" content="Book exclusive hotel offers and packages at AORA 45 Siaya County. Special deals on romantic getaways, safari packages, and more.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://AORA 45.com/offers.php">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Exclusive Hotel Offers & Packages at AORA 45">
    <meta name="twitter:description" content="Book exclusive hotel offers and packages at AORA 45 Siaya County.">
    <!-- Schema.org Offer -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "OfferCatalog",
        "name": "AORA 45 Special Offers",
        "description": "Exclusive hotel packages and special offers",
        "itemListElement": [
            {"@type": "Offer", "name": "Romance in the Wild", "price": "KSh 85,000", "priceCurrency": "KES"},
            {"@type": "Offer", "name": "Weekend Wilderness", "price": "KSh 65,000", "priceCurrency": "KES"},
            {"@type": "Offer", "name": "Family Safari Adventure", "price": "KSh 120,000", "priceCurrency": "KES"},
            {"@type": "Offer", "name": "Honeymoon Paradise", "price": "KSh 95,000", "priceCurrency": "KES"}
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
        
        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes ribbonGlow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2); }
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
        
        .animate-ribbon {
            animation: ribbonGlow 3s ease-in-out infinite;
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
            background: #2d5a4a;
            border-radius: 4px;
        }
        
        /* Offer Card Unique Design - Folded Corner Effect */
        .offer-card {
            position: relative;
            background: white;
            transition: all 0.5s ease;
            overflow: hidden;
            border: 1px solid rgba(184, 154, 120, 0.2);
        }
        
        .offer-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, transparent 50%, rgba(184, 154, 120, 0.1) 50%);
            z-index: 5;
            transition: all 0.4s ease;
        }
        
        .offer-card:hover::before {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, transparent 50%, rgba(184, 154, 120, 0.2) 50%);
        }
        
        .offer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 50px -20px rgba(0,0,0,0.3);
            border-color: rgba(184, 154, 120, 0.4);
        }
        
        .offer-card .card-image {
            position: relative;
            overflow: hidden;
            height: 280px;
        }
        
        .offer-card .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }
        
        .offer-card:hover .card-image img {
            transform: scale(1.08);
        }
        
        .offer-card .offer-ribbon {
            position: absolute;
            top: 20px;
            left: -5px;
            background: #2d5a4a;
            color: white;
            padding: 8px 20px;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            z-index: 10;
            animation: ribbonGlow 3s ease-in-out infinite;
        }
        
        .offer-card .offer-ribbon::before {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #1e4d40;
            transform: rotate(45deg);
        }
        
        .offer-card .offer-ribbon::after {
            content: '';
            position: absolute;
            top: 0;
            right: -10px;
            width: 0;
            height: 0;
            border-left: 10px solid #2d5a4a;
            border-right: 10px solid transparent;
            border-bottom: 15px solid transparent;
        }
        
        .offer-card .price-tag {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(4px);
            padding: 10px 20px;
            border-radius: 40px;
            border: 1px solid rgba(184, 154, 120, 0.3);
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        .offer-card:hover .price-tag {
            background: #2d5a4a;
            color: white;
            border-color: #2d5a4a;
        }
        
        .offer-card .price-tag .price {
            font-family: 'DM Serif Display', serif;
            font-size: 1.5rem;
            color: #2d5a4a;
            transition: all 0.3s ease;
        }
        
        .offer-card:hover .price-tag .price {
            color: white;
        }
        
        .offer-card .card-content {
            padding: 2rem 1.5rem;
            position: relative;
        }
        
        .offer-card .card-content::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: #2d5a4a;
            transition: width 0.5s ease;
        }
        
        .offer-card:hover .card-content::after {
            width: 80%;
        }
        
        .offer-card .inclusions {
            background: rgba(184, 154, 120, 0.05);
            padding: 1rem;
            margin: 1.5rem 0;
            border-left: 3px solid #2d5a4a;
        }
        
        .offer-card .inclusions-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #5c524a;
            margin-bottom: 0.5rem;
        }
        
        .offer-card .inclusions-item i {
            color: #2d5a4a;
            width: 20px;
        }
        
        .offer-card .validity {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.85rem;
            color: #1e4d40;
            margin-bottom: 1.5rem;
        }
        
        .offer-card .validity i {
            color: #2d5a4a;
        }
        
        /* Button Styles */
        .btn-offer {
            position: relative;
            width: 100%;
            padding: 1rem;
            background: transparent;
            border: 1px solid #2d5a4a;
            color: #2d5a4a;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-offer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #2d5a4a;
            transition: left 0.4s ease;
            z-index: -1;
        }
        
        .btn-offer:hover {
            color: white;
        }
        
        .btn-offer:hover::before {
            left: 0;
        }
        
        .btn-offer i {
            transition: transform 0.3s ease;
        }
        
        .btn-offer:hover i {
            transform: translateX(5px);
        }
        
        /* Modal Styles */
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
            max-width: 1000px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.95) translateY(20px);
            transition: all 0.4s ease;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.6);
            position: relative;
        }
        
        .modal.show .modal-content {
            transform: scale(1) translateY(0);
        }
        
        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: #2d5a4a;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 20;
        }
        
        .modal-close:hover {
            transform: rotate(90deg);
            background: #1e4d40;
        }
        
        .modal-gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 1.5rem;
        }
        
        .modal-gallery img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .modal-gallery img:hover {
            transform: scale(1.05);
            border-color: #2d5a4a;
        }
        
        .modal-gallery img.active {
            border-color: #2d5a4a;
        }
        
        .modal-feature-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .modal-feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            background: rgba(184, 154, 120, 0.05);
            border-left: 3px solid #2d5a4a;
        }
        
        .modal-feature-item i {
            color: #2d5a4a;
            font-size: 1.2rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .offer-card .card-image {
                height: 220px;
            }
            
            .modal-gallery {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .modal-feature-list {
                grid-template-columns: 1fr;
            }
            
            .offer-card .price-tag .price {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#fcf8f3]">
    <main class="relative">
        <!-- ===== HERO SECTION ===== -->
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <!-- Background Image - Luxury Offer -->
            <div class="absolute inset-0 z-0">
                <img src="https://png.pngtree.com/thumb_back/fh260/back_our/20190621/ourmid/pngtree-western-restaurant-promotion-orange-simple-creative-banner-image_194021.jpg" 
                     alt="Luxury Offer" 
                     class="w-full h-full object-cover animate-drift">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/70"></div>
            </div>
            
            <!-- Floating Orbs -->
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-[#2d5a4a]/20 rounded-full blur-3xl animate-pulse-soft"></div>
            <div class="absolute bottom-1/3 right-1/4 w-96 h-96 bg-[#1e4d40]/20 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 2s;"></div>
            
            <!-- Content -->
            <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
                <!-- Decorative Line -->
                <div class="flex justify-center mb-8">
                    <div class="w-24 h-px bg-gradient-to-r from-transparent via-[#2d5a4a] to-transparent animate-pulse"></div>
                </div>
                
                <!-- Main Heading -->
                <h1 class="font-['DM_Serif_Display'] text-6xl md:text-7xl lg:text-8xl text-white mb-6 drop-shadow-2xl tracking-wide">
                    <span class="block reveal-left" style="transition-delay: 0.2s;">Exclusive</span>
                    <span class="block reveal-right text-[#2d5a4a]" style="transition-delay: 0.4s;">Offers</span>
                </h1>
                
                <!-- Decorative Element -->
                <div class="relative flex justify-center items-center gap-4 mb-12">
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                    <i class="fas fa-tag text-[#2d5a4a] text-xl"></i>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                </div>
                
                <!-- Subheading -->
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 max-w-2xl mx-auto italic leading-relaxed reveal" style="transition-delay: 0.6s;">
                    "Unforgettable experiences, curated just for you"
                </p>
                
                <!-- Scroll Indicator -->
                <!-- <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex flex-col items-center gap-2">
                    <span class="text-white/60 text-xs uppercase tracking-widest">Discover</span>
                    <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                        <div class="w-1 h-2 bg-white/60 rounded-full mt-2 animate-bounce"></div>
                    </div>
                </div> -->
            </div>
        </section>

        <!-- ===== OFFERS GRID ===== -->
        <section class="relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#2d5a4a]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#1e4d40] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Limited Time</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Signature Packages</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#2d5a4a] to-transparent mx-auto"></div>
                    <p class="text-[#1e4d40] text-sm max-w-2xl mx-auto mt-6">
                        Curated escapes designed to create unforgettable memories in the heart of Kenya.
                    </p>
                </div>
                
                <!-- Offers Grid -->
                <div id="offersGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php if (empty($allOffers)): ?>
                    <div class="col-span-full text-center py-8">
                        <p class="text-[#5c524a]">No offers available at the moment. Please check back later.</p>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Note about custom packages -->
                <!-- <div class="text-center mt-16 reveal">
                    <p class="text-[#1e4d40] text-sm italic">
                        Looking for something unique? <button onclick="openCustomModal()" class="text-[#2d5a4a] underline hover:no-underline">Create your own package</button>
                    </p>
                </div> -->
            </div>
        </section>

        <!-- ===== CLOSING NOTE ===== -->
        <section class="relative py-20 px-6 bg-[#2c3e4a] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#2d5a4a]/20"></div>
            </div>
            
            <div class="max-w-3xl mx-auto relative z-10 text-center">
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#2d5a4a] to-transparent mx-auto mb-8"></div>
                
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 italic leading-relaxed">
                    "Experience the extraordinary. Book your exclusive offer today."
                </p>
                
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#2d5a4a] to-transparent mx-auto mt-8"></div>
            </div>
        </section>
    </main>

    <!-- ===== OFFER MODAL ===== -->
    <div id="offerModal" class="modal">
        <div class="modal-content mx-auto my-8 p-8 relative">
            <div class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </div>
            
            <!-- Modal Content will be dynamically loaded -->
            <div id="modalContent"></div>
        </div>
    </div>

    
    <!-- Offer Data - Loaded from Database -->
    <script>
        // Database offers loaded from PHP
        const dbOffers = <?php echo json_encode($allOffers); ?>;
        
        console.log('Offers loaded:', dbOffers);
        console.log('Number of offers:', dbOffers.length);
        
        const offerData = {};
        
        function formatDateRange(startDate, endDate) {
            if (!startDate && !endDate) return 'Contact for details';
            if (!startDate) return 'Until ' + endDate;
            if (!endDate) return 'From ' + startDate;
            return startDate + ' to ' + endDate;
        }
        
        function getRibbon(index) {
            const ribbons = ['coming soon', 'Popular', 'Family Fun', 'Romance', 'Rejuvenate', 'Special'];
            return ribbons[index % ribbons.length];
        }
        
        function renderInclusions(inclusions) {
            if (!inclusions || inclusions.length === 0) return '<p class="text-sm text-gray-500">Contact for details</p>';
            let html = '';
            const items = inclusions.slice(0, 4);
            items.forEach(function(item) {
                html += '<div class="inclusions-item"><i class="fas fa-check-circle"></i><span>' + item + '</span></div>';
            });
            if (inclusions.length > 4) {
                html += '<div class="inclusions-item"><i class="fas fa-ellipsis-h"></i><span>+' + (inclusions.length - 4) + ' more</span></div>';
            }
            return html;
        }
        
        // Convert database offers to JavaScript object
        dbOffers.forEach(function(offer, index) {
            // Parse inclusions if it's a JSON string
            let inclusions = offer.inclusions;
            if (typeof inclusions === 'string') {
                try {
                    inclusions = JSON.parse(inclusions);
                } catch (e) {
                    inclusions = [];
                }
            }
            if (!Array.isArray(inclusions)) {
                inclusions = [];
            }
            
            offerData[offer.slug] = {
                title: offer.title,
                price: 'KSh ' + (offer.price || '0'),
                description: offer.description,
                longDescription: offer.description || 'Contact for details',
                validity: formatDateRange(offer.start_date, offer.end_date),
                duration: 'Contact for details',
                occupancy: 'Varies by package',
                inclusions: inclusions,
                exclusions: [],
                finePrint: 'Subject to availability. Contact us for booking.',
                image: offer.image1 || 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                gallery: [
                    offer.image1 || 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    offer.image2 || 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    offer.image3 || 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    offer.image4 || 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    offer.image5 || 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            };
        });
        
        // Generate dynamic offer cards on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, offers:', dbOffers.length);
            const offersGrid = document.getElementById('offersGrid');
            
            if (!offersGrid) {
                console.error('offersGrid element not found!');
                return;
            }
            
            if (!dbOffers || dbOffers.length === 0) {
                console.log('No offers to display');
                offersGrid.innerHTML = '<div class="col-span-full text-center py-8"><p class="text-[#5c524a]">No offers available at the moment. Please check back later.</p></div>';
                return;
            }
            
            try {
                let html = '';
                const defaultImg = 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80';
                dbOffers.forEach(function(offer, index) {
                    console.log('Rendering offer:', offer.title);
                    html += '<div class="offer-card rounded-2xl reveal" style="transition-delay: ' + (0.1 + index * 0.1) + 's;">' +
                        '<div class="card-image">' +
                            '<img src="' + (offer.image1 || defaultImg) + '" alt="' + offer.title + '">' +
                            '<div class="offer-ribbon animate-ribbon">' + getRibbon(index) + '</div>' +
                            '<div class="price-tag">' +
                                '<span class="text-xs uppercase tracking-wider">from</span>' +
                                '<span class="price">KSh ' + (offer.price || '0') + '</span>' +
                            '</div>' +
                        '</div>' +
                        '<div class="card-content">' +
                            '<h3 class="font-["Cormorant_Garamond"] text-2xl text-[#2c3e4a] mb-3">' + offer.title + '</h3>' +
                            '<p class="text-[#5c524a] text-sm leading-relaxed mb-4">' + (offer.subtitle || (offer.description ? offer.description.substring(0, 100) + '...' : 'Contact for details')) + '</p>' +
                            '<div class="inclusions">' + renderInclusions(offerData[offer.slug] ? offerData[offer.slug].inclusions : []) + '</div>' +
                            '<div class="validity">' +
                                '<i class="far fa-calendar-alt"></i>' +
                                '<span>Valid: ' + formatDateRange(offer.start_date, offer.end_date) + '</span>' +
                            '</div>' +
                            '<button onclick="openOfferModal(\'' + offer.slug + '\')" class="btn-offer flex items-center justify-center gap-2">' +
                                '<span>View Details & Book</span>' +
                                '<i class="fas fa-arrow-right"></i>' +
                            '</button>' +
                        '</div>' +
                    '</div>';
                });
                offersGrid.innerHTML = html;
                console.log('Offers rendered successfully');
                setTimeout(reveal, 300);
            } catch (e) {
                console.error('Error rendering offers:', e);
                offersGrid.innerHTML = '<div class="col-span-full text-center py-8"><p class="text-[#5c524a]">Error loading offers. Please try again later.</p></div>';
            }
        });
        
        // Current main image for modal gallery
        let currentMainImage = '';

        function openOfferModal(offerKey) {
            const offer = offerData[offerKey];
            if (!offer) return;
            
            const modal = document.getElementById('offerModal');
            const modalContent = document.getElementById('modalContent');
            
            currentMainImage = offer.image;
            
            // Generate gallery thumbnails
            const galleryHTML = offer.gallery.map((img, index) => `
                <img src="${img}" alt="Gallery ${index + 1}" class="${index === 0 ? 'active' : ''}" onclick="changeMainImage(this, '${img}')">
            `).join('');
            
            // Generate inclusions list
            const inclusionsHTML = offer.inclusions.map(item => `
                <div class="modal-feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>${item}</span>
                </div>
            `).join('');
            
            // Generate exclusions list
            const exclusionsHTML = offer.exclusions.map(item => `
                <div class="flex items-center gap-3 text-[#1e4d40]">
                    <i class="fas fa-times-circle text-sm"></i>
                    <span class="text-sm">${item}</span>
                </div>
            `).join('');
            
            modalContent.innerHTML = `
                <div>
                    <h2 class="font-['Cormorant_Garamond'] text-3xl text-[#2c3e4a] mb-2">${offer.title}</h2>
                    <div class="flex items-center gap-4 mb-6">
                        <span class="text-[#2d5a4a] font-['DM_Serif_Display'] text-3xl">${offer.price}</span>
                        <span class="text-[#1e4d40] text-xs">per package</span>
                    </div>
                    
                    <!-- Main Image -->
                    <div class="relative mb-4">
                        <img id="modalMainImage" src="${offer.image}" alt="${offer.title}" class="w-full h-[400px] object-cover">
                    </div>
                    
                    <!-- Gallery Thumbnails -->
                    <div class="modal-gallery">
                        ${galleryHTML}
                    </div>
                    
                    <!-- Description -->
                    <p class="text-[#5c524a] mt-6 mb-4">${offer.longDescription}</p>
                    
                    <!-- Quick Details -->
                    <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-[#f4ede5]">
                        <div class="text-center">
                            <i class="fas fa-calendar-alt text-[#2d5a4a] mb-2"></i>
                            <p class="text-xs text-[#1e4d40]">Validity</p>
                            <p class="text-sm text-[#2c3e4a] font-medium">${offer.validity}</p>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-clock text-[#2d5a4a] mb-2"></i>
                            <p class="text-xs text-[#1e4d40]">Duration</p>
                            <p class="text-sm text-[#2c3e4a] font-medium">${offer.duration}</p>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-users text-[#2d5a4a] mb-2"></i>
                            <p class="text-xs text-[#1e4d40]">Occupancy</p>
                            <p class="text-sm text-[#2c3e4a] font-medium">${offer.occupancy}</p>
                        </div>
                    </div>
                    
                    <!-- Inclusions & Exclusions -->
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a] mb-3">Inclusions</h3>
                            <div class="modal-feature-list">
                                ${inclusionsHTML}
                            </div>
                        </div>
                        <div>
                            <h3 class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a] mb-3">Exclusions</h3>
                            <div class="space-y-2">
                                ${exclusionsHTML}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fine Print -->
                    <div class="mb-6 p-4 bg-[#f4ede5] border-l-4 border-[#2d5a4a]">
                        <p class="text-sm text-[#1e4d40] italic">
                            <i class="fas fa-info-circle mr-2 text-[#2d5a4a]"></i>
                            ${offer.finePrint}
                        </p>
                    </div>
                    
                    <!-- Book Button -->
                    <button onclick="bookOffer('${offer.title}')" class="w-full py-4 bg-[#2d5a4a] text-white hover:bg-[#1e4d40] transition-colors flex items-center justify-center gap-2">
                        <span>Book This Offer</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            `;
            
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function changeMainImage(thumbnail, src) {
            document.getElementById('modalMainImage').src = src;
            currentMainImage = src;
            
            // Update active thumbnail
            document.querySelectorAll('.modal-gallery img').forEach(img => {
                img.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
        
        function bookOffer(offerTitle) {
            // Close modal first
            closeModal();
            
            // Create WhatsApp message with offer details
            const phoneNumber = '254769525570';
            const message = `Hello AORA 45, I'm interested in booking the "${offerTitle}" package. Please provide more information about availability and how to proceed with the booking.`;
            const encodedMessage = encodeURIComponent(message);
            
            // Redirect to WhatsApp
            window.open(`https://wa.me/${phoneNumber}?text=${encodedMessage}`, '_blank');
        }
        
        function openCustomModal() {
            showToast('Please contact our concierge team to create your custom package. Call +254 769 525 570 or email concierge@AORA.kenya', 'info');
        }
        
        function closeModal() {
            const modal = document.getElementById('offerModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('offerModal').addEventListener('click', function(e) {
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
<?php include 'footer.php'; ?>

