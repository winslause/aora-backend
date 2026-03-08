<?php 
// Include database connection
require_once 'database.php';

// Get amenity categories with their amenities from database
$amenityCategories = getAllAmenityCategories($pdo);

// Convert to JavaScript object for modal functionality
$amenitiesJS = [];
foreach ($amenityCategories as $category) {
    foreach ($category['amenities'] as $amenity) {
        $features = json_decode($amenity['features'], true);
        $gallery = json_decode($amenity['gallery'], true);
        $amenitiesJS[$amenity['slug']] = [
            'name' => $amenity['name'],
            'description' => $amenity['description'],
            'longDescription' => $amenity['long_description'],
            'features' => $features,
            'hours' => $amenity['hours'],
            'phone' => $amenity['phone'],
            'image' => $amenity['image'],
            'gallery' => $gallery
        ];
    }
}
?>

<?php include 'header.php'; ?>

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

        <!-- ===== AMENITY CATEGORIES FROM DATABASE ===== -->
        <?php 
        $bgClasses = ['bg-[#fcf8f3]', 'bg-[#f4ede5]', 'bg-[#fcf8f3]', 'bg-[#f4ede5]'];
        $i = 0;
        
        foreach ($amenityCategories as $category): 
            $bgClass = $bgClasses[$i % count($bgClasses)];
            $i++;
        ?>
        <section class="relative py-24 px-6 <?php echo $bgClass; ?> overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Category Title -->
                <div class="mb-12 reveal-left">
                    <h2 class="category-title"><?php echo htmlspecialchars($category['name']); ?></h2>
                    <p class="text-[#8a735b] text-sm max-w-2xl"><?php echo htmlspecialchars($category['description']); ?></p>
                </div>
                
                <!-- Amenities Grid -->
                <?php 
                $colClass = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4';
                if ($category['name'] === 'Business & Events') {
                    $colClass = 'grid-cols-1 md:grid-cols-3';
                }
                ?>
                <div class="grid <?php echo $colClass; ?> gap-6">
                    <?php 
                    $delay = 0.1;
                    foreach ($category['amenities'] as $amenity): 
                    ?>
                    <div class="amenity-item reveal" style="transition-delay: <?php echo $delay; ?>s;" onclick="openModal('<?php echo htmlspecialchars($amenity['slug']); ?>')">
                        <img src="<?php echo htmlspecialchars($amenity['image']); ?>" 
                             alt="<?php echo htmlspecialchars($amenity['name']); ?>" 
                             class="amenity-image">
                        <div class="amenity-overlay"></div>
                        <div class="amenity-content">
                            <div class="amenity-icon">
                                <i class="fas <?php echo htmlspecialchars($amenity['icon']); ?>"></i>
                            </div>
                            <h3 class="amenity-title"><?php echo htmlspecialchars($amenity['name']); ?></h3>
                            <p class="amenity-brief"><?php echo htmlspecialchars($amenity['description']); ?></p>
                        </div>
                    </div>
                    <?php 
                    $delay += 0.1;
                    endforeach; 
                    ?>
                </div>
            </div>
        </section>
        <?php endforeach; ?>

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

    <!-- Amenity Data from Database -->
    <script>
        const amenityData = <?php echo json_encode($amenitiesJS); ?>;

        function openModal(amenityKey) {
            const amenity = amenityData[amenityKey];
            if (!amenity) return;
            
            const modal = document.getElementById('amenityModal');
            const modalContent = document.getElementById('modalContent');
            
            // Generate gallery HTML
            const galleryHTML = amenity.gallery.map(img => `
                <img src="${img}" alt="${amenity.name}" onclick="this.parentNode.previousElementSibling.src = this.src">
            `).join('');
            
            // Generate features HTML
            const featuresHTML = amenity.features.map(feature => `
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-[#5c524a] text-sm">${feature}</span>
                </div>
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
                            ${featuresHTML}
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
<?php include 'footer.php'; ?>
