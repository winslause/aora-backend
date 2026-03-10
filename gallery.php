<?php 
include 'database.php';

// Get gallery data from database
$galleryAlbums = getAllGalleryAlbums($pdo);
$galleryImages = getAllGalleryImages($pdo);
$galleryVideo = getGalleryVideo($pdo);

// Organize images by album for modal
$albumImages = [];
foreach ($galleryAlbums as $album) {
    $albumImages[$album['slug']] = getGalleryImagesByAlbumSlug($pdo, $album['slug']);
}

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
        
        /* Gallery Item Entrance Animation */
        .masonry-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.5s ease;
            border-radius: 1rem;
            box-shadow: 0 15px 30px -10px rgba(0,0,0,0.2);
            opacity: 0;
            animation: galleryFadeIn 0.8s ease-out forwards;
        }
        
        @keyframes galleryFadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Staggered animation delays */
        .masonry-item:nth-child(1) { animation-delay: 0.1s; }
        .masonry-item:nth-child(2) { animation-delay: 0.15s; }
        .masonry-item:nth-child(3) { animation-delay: 0.2s; }
        .masonry-item:nth-child(4) { animation-delay: 0.25s; }
        .masonry-item:nth-child(5) { animation-delay: 0.3s; }
        .masonry-item:nth-child(6) { animation-delay: 0.35s; }
        .masonry-item:nth-child(7) { animation-delay: 0.4s; }
        .masonry-item:nth-child(8) { animation-delay: 0.45s; }
        .masonry-item:nth-child(9) { animation-delay: 0.5s; }
        .masonry-item:nth-child(10) { animation-delay: 0.55s; }
        .masonry-item:nth-child(11) { animation-delay: 0.6s; }
        .masonry-item:nth-child(12) { animation-delay: 0.65s; }
        
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
        
        /* Gallery Grid - Mobile: 1-2-1-2 pattern, Desktop: 4 columns */
        .masonry-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        /* Full width items span entire row (2 columns on mobile) */
        .masonry-item.mobile-full-width {
            grid-column: span 2;
        }
        
        /* Half width items span 1 column each */
        .masonry-item.mobile-half-width {
            grid-column: span 1;
        }
        
        /* Image styling */
        .masonry-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .masonry-item:hover img {
            transform: scale(1.1);
        }
        
        /* Mobile: 2 columns */
        @media (max-width: 767px) {
            .masonry-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .masonry-item img { height: 180px; }
            .album-gallery { grid-template-columns: repeat(2, 1fr); }
        }
        
        /* Desktop: 4 columns with large/wide/tall sizing */
        @media (min-width: 768px) {
            .masonry-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 16px;
            }
            
            /* Reset mobile classes on desktop */
            .masonry-item.mobile-full-width,
            .masonry-item.mobile-half-width {
                grid-column: auto;
            }
            
            /* Desktop sizing */
            .masonry-item.large,
            .masonry-item:first-child {
                grid-column: span 2;
                grid-row: span 2;
            }
            
            .masonry-item.wide,
            .masonry-item:nth-child(4n) {
                grid-column: span 2;
            }
            
            .masonry-item.tall,
            .masonry-item:nth-child(3n) {
                grid-row: span 2;
            }
            
            .masonry-item img {
                height: 100%;
            }
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .album-gallery { grid-template-columns: 1fr; }
            .play-button { width: 60px; height: 60px; }
            .play-button i { font-size: 1.5rem; }
        }
        
        /* Gallery Item - Floating Style with Hover Effects */
        .gallery-item {
            position: relative;
            overflow: hidden;
            transition: all 0.5s ease;
        }
        
        .gallery-item .item-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(63, 53, 46, 0.6), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }
        
        .gallery-item:hover .item-overlay {
            opacity: 1;
        }
        
        .gallery-item .item-title {
            font-family: 'Cormorant Garamond', serif;
            color: white;
            font-size: 1.2rem;
            transform: translateY(10px);
            transition: transform 0.4s ease;
        }
        
        .gallery-item:hover .item-title {
            transform: translateY(0);
        }
        
        /* Decorative Corner Accents */
        .gallery-item::before {
            content: '';
            position: absolute;
            top: 16px;
            right: 16px;
            width: 48px;
            height: 48px;
            border-top: 2px solid rgba(255,255,255,0);
            border-right: 2px solid rgba(255,255,255,0);
            transition: all 0.5s ease 0.15s;
            z-index: 10;
        }
        
        .gallery-item::after {
            content: '';
            position: absolute;
            bottom: 16px;
            left: 16px;
            width: 48px;
            height: 48px;
            border-bottom: 2px solid rgba(255,255,255,0);
            border-left: 2px solid rgba(255,255,255,0);
            transition: all 0.5s ease 0.15s;
            z-index: 10;
        }
        
        .gallery-item:hover::before {
            border-color: rgba(255,255,255,0.6);
        }
        
        .gallery-item:hover::after {
            border-color: rgba(255,255,255,0.6);
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
        @media (max-width: 480px) {
            .album-gallery { grid-template-columns: 1fr; }
            .play-button { width: 60px; height: 60px; }
            .play-button i { font-size: 1.5rem; }
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
                    <?php foreach($galleryAlbums as $index => $album): ?>
                    <!-- Album - <?php echo htmlspecialchars($album['title']); ?> -->
                    <div class="album-cover reveal" style="transition-delay: <?php echo $index * 0.1; ?>s;" onclick="openAlbum('<?php echo htmlspecialchars($album['slug']); ?>')">
                        <img src="<?php echo htmlspecialchars($album['cover_image']); ?>" 
                             alt="<?php echo htmlspecialchars($album['title']); ?>">
                        <div class="album-overlay">
                            <div class="album-icon">
                                <i class="fas <?php echo htmlspecialchars($album['icon']); ?>"></i>
                            </div>
                            <h3 class="album-title"><?php echo htmlspecialchars($album['title']); ?></h3>
                            <p class="album-count"><?php echo $album['photo_count']; ?> photos</p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ===== GALLERY LABELS ===== -->
        <section class="py-8 px-6 bg-[#f4ede5] overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-wrap justify-center gap-6 reveal">
                    <span onclick="openAlbum('all')" class="font-['Cormorant_Garamond'] text-lg text-[#b89a78] border-b-2 border-[#b89a78] pb-1 cursor-pointer hover:text-[#8a735b] transition-colors">All Moments</span>
                    <?php foreach($galleryAlbums as $album): ?>
                    <span onclick="openAlbum('<?php echo htmlspecialchars($album['slug']); ?>')" class="font-['Cormorant_Garamond'] text-lg text-[#8a735b] hover:text-[#b89a78] transition-colors cursor-pointer"><?php switch($album['slug']) { case 'rooms': echo 'Luxury Stays'; break; case 'restaurant': echo 'Culinary Art'; break; case 'amenities': echo 'World-Class'; break; case 'surroundings': echo 'Natural Beauty'; break; default: echo htmlspecialchars($album['title']); } ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ===== MASONRY IMAGE GRID ===== -->
        <section class="relative py-16 px-6 bg-[#fcf8f3] overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <!-- Gallery Grid - Mobile: 1,2,1,2 pattern - Desktop: 4 columns -->
                <div class="masonry-grid" id="galleryGrid">
                    <?php 
                    // Pattern for mobile: 1 full width, 2 half width, 1 full width, 2 half width...
                    // Using 3-item groups: [full], [half, half], [full], [half, half]...
                    foreach($galleryImages as $index => $image): 
                        // Pattern: index % 3 = 0 (full), 1 (half), 2 (half)
                        $isFullWidth = ($index % 3 === 0);
                        
                        // Desktop: use large/wide/tall classes
                        $gridClass = '';
                        $roundedClass = 'rounded-2xl';
                        
                        if ($index === 0 || $image['grid_size'] === 'large') {
                            $gridClass = 'large';
                            $roundedClass = 'rounded-3xl';
                        } elseif (($index + 1) % 4 === 0 || $image['grid_size'] === 'wide') {
                            $gridClass = 'wide';
                        } elseif (($index + 1) % 3 === 0 || $image['grid_size'] === 'tall') {
                            $gridClass = 'tall';
                        }
                        
                        // Mobile wrapper class
                        $wrapperClass = $isFullWidth ? 'mobile-full-width' : 'mobile-half-width';
                    ?>
                    <div class="masonry-item gallery-item <?php echo $gridClass; ?> <?php echo $roundedClass; ?> <?php echo $wrapperClass; ?>" 
                         data-category="<?php echo htmlspecialchars($image['category']); ?>"
                         data-src="<?php echo htmlspecialchars($image['src']); ?>"
                         data-caption="<?php echo htmlspecialchars($image['caption']); ?>"
                         onclick="openLightbox(this.dataset.src, this.dataset.caption)">
                        <img src="<?php echo htmlspecialchars($image['src']); ?>" 
                             alt="<?php echo htmlspecialchars($image['caption']); ?>" 
                             class="w-full h-full object-cover">
                        <div class="item-overlay">
                            <span class="item-title"><?php echo htmlspecialchars($image['caption']); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
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
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light"><?php echo $galleryVideo ? htmlspecialchars($galleryVideo['title']) : 'The Aora Experience'; ?></h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Video Container -->
                <div class="video-container relative aspect-video w-full reveal">
                    <!-- Thumbnail Image (will be replaced by iframe on play) -->
                    <img id="videoThumbnail" src="<?php echo $galleryVideo ? htmlspecialchars($galleryVideo['thumbnail']) : 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'; ?>" 
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
                    <?php echo $galleryVideo ? htmlspecialchars($galleryVideo['description']) : 'Experience the magic of Aora—where luxury meets the wild heart of Kenya.'; ?>
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

    <!-- ===== IMAGE LIGHTBOX MODAL ===== -->
    <div id="imageModal" class="fixed inset-0 z-[2000] hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-black/95" onclick="closeImageModal()"></div>
        <button onclick="closeImageModal()" class="absolute top-4 right-4 z-[2001] w-12 h-12 bg-white/10 hover:bg-white/20 border border-white/20 rounded-full flex items-center justify-center transition-all">
            <i class="fas fa-times text-white text-xl"></i>
        </button>
        <div class="relative z-[2001] max-w-[90vw] max-h-[90vh] flex items-center justify-center">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[85vh] object-contain">
        </div>
        <div id="modalCaption" class="absolute bottom-8 left-0 right-0 z-[2001] text-center px-4">
            <p class="text-white/90 font-['Cormorant_Garamond'] text-xl"></p>
        </div>
    </div>

    <!-- Lightbox script (for reference only, we use custom modal now) -->
    
    <script>
        // Album data from database
        const albumData = <?php echo json_encode(array_combine(array_column($galleryAlbums, 'slug'), array_map(function($album) use ($albumImages) {
            return [
                'title' => $album['title'],
                'description' => $album['description'],
                'photos' => array_map(function($img) {
                    return [
                        'src' => $img['src'],
                        'caption' => $img['caption']
                    ];
                }, $albumImages[$album['slug']])
            ];
        }, $galleryAlbums))); ?>;

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
        
        // Add click handlers for masonry items - backup for onclick
        document.querySelectorAll('.masonry-item').forEach(item => {
            item.addEventListener('click', function(e) {
                const src = this.dataset.src;
                const caption = this.dataset.caption;
                if (src) {
                    openLightbox(src, caption);
                }
            });
        });

        // Open image in custom modal (for gallery images and album images)
        function openLightbox(src, caption) {
            // Don't close album modal - let both modals coexist with image on top
            
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const modalCaption = document.getElementById('modalCaption');
            
            if (!modal || !modalImg) return;
            
            modalImg.src = src;
            modalCaption.querySelector('p').textContent = caption || '';
            
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Close image modal
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            if (!modal) return;
            
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
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
            
            // Show and play video (using YouTube embed from database)
            player.classList.remove('hidden');
            player.src = '<?php echo $galleryVideo ? htmlspecialchars($galleryVideo['video_url']) : 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1'; ?>';
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAlbumModal();
                closeImageModal();
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('albumModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAlbumModal();
            }
        });
        
        // Close image modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
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