<?php 
// Start session and include database
session_start();
include 'header.php'; 
// Override the header SEO with page-specific SEO
$pageTitle = "Luxury Rooms & Suites in Nairobi, Kenya | Aora45";
$pageDescription = "Discover our elegant rooms and suites at Aora45 resort in Nairobi. From standard rooms to luxury suites, book your stay with amenities like free WiFi, pool, spa, and fine dining.";
?>

<style>
@media (min-width: 1024px) {
    section.relative.h-screen, section.relative.h-\[60vh\], section.relative.h-\[70vh\] { margin-top: 150px; }
}
@media (max-width: 1023px) {
    section.relative.h-screen, section.relative.h-\[60vh\], section.relative.h-\[70vh\] { margin-top: 80px; }
}
</style>
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
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
        
        .animate-spin {
            animation: spin 1s linear infinite;
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
        
        .loader {
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #d4b48c;
            width: 24px;
            height: 24px;
            -webkit-animation: spin 1s linear infinite; /* Safari */
            animation: spin 1s linear infinite;
        }
        
        /* View Toggle Button Styles */
        .view-toggle-btn.active {
            background: #d4b48c;
            color: white;
        }
        
        /* Grid View - 1 Column */
        #roomsGrid.grid-1 {
            display: grid;
            grid-template-columns: 1fr;
        }
        
        /* Grid View - 2 Columns */
        #roomsGrid.grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }
        
        /* Grid View - 4 Columns (Desktop only) */
        #roomsGrid.grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }
        
        @media (max-width: 1279px) {
            #roomsGrid.grid-4 {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 1023px) {
            #roomsGrid.grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 639px) {
            #roomsGrid.grid-4, #roomsGrid.grid-2, #roomsGrid.grid-1 {
                grid-template-columns: 1fr;
            }
        }
        
        /* List View Styles - for all devices */
        #roomsGrid.list-view {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        #roomsGrid.list-view .room-card {
            display: flex;
            flex-direction: row;
        }
        
        #roomsGrid.list-view .room-card > div:first-child {
            width: 40%;
            flex-shrink: 0;
        }
        
        #roomsGrid.list-view .room-card > div:first-child .group-hover\\:scale-110 {
            transform: scale(1);
        }
        
        #roomsGrid.list-view .room-card > div:last-child {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        /* Mobile list view adjustments */
        @media (max-width: 768px) {
            #roomsGrid.list-view .room-card {
                flex-direction: column;
            }
            
            #roomsGrid.list-view .room-card > div:first-child {
                width: 100%;
            }
        }
        .loader {
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #d4b48c;
            width: 24px;
            height: 24px;
            -webkit-animation: spin 1s linear infinite; /* Safari */
            animation: spin 1s linear infinite;
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
            <!-- <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex flex-col items-center gap-2">
                <span class="text-white/60 text-xs uppercase tracking-widest">Explore</span>
                <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div class="w-1 h-2 bg-white/60 rounded-full mt-2 animate-bounce"></div>
                </div>
            </div> -->
        </section>

        <!-- ===== FILTER BAR SECTION ===== -->
        <section class="py-12 px-6 bg-[#f5efe8]">
            <div class="max-w-7xl mx-auto">
                <!-- Filter Bar -->
                <div class="flex flex-wrap items-center justify-between gap-6 p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-[#d4b48c]/20 reveal">
                    <!-- Filter by View -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[#8a735b] text-xs uppercase tracking-wider mb-2">View</label>
                        <div class="flex flex-wrap gap-2" id="viewFilters">
                            <button class="filter-btn active px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all" data-filter="view" data-value="all">All</button>
                        </div>
                    </div>
                    
                    <!-- Filter by Bed Type -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[#8a735b] text-xs uppercase tracking-wider mb-2">Bed Type</label>
                        <div class="flex flex-wrap gap-2" id="bedFilters">
                            <button class="filter-btn active px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all" data-filter="bed" data-value="all">All</button>
                        </div>
                    </div>
                    
                    <!-- Sort by Price -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[#8a735b] text-xs uppercase tracking-wider mb-2">Sort by</label>
                        <select id="sortSelect" class="w-full px-4 py-2 bg-white border border-[#d4b48c]/30 rounded-full text-sm focus:outline-none focus:border-[#d4b48c]">
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="popular">Most Popular</option>
                            <option value="newest">Newest</option>
                        </select>
                    </div>
                    
                    <!-- Reset Button -->
                    <button id="resetFilters" class="px-6 py-2 text-sm text-[#8a735b] hover:text-[#d4b48c] transition-colors">
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
                    <p class="text-[#8a735b] text-sm">Showing <span class="font-semibold text-[#d4b48c]" id="roomCount">0</span> rooms</p>
                    <div class="flex gap-2">
                        <!-- View Toggle Buttons - Desktop: 1, 2, 4 cols + list -->
                        <button onclick="setView('grid-1')" id="grid1Btn" class="view-toggle-btn w-10 h-10 rounded-full border border-[#d4b48c]/30 flex items-center justify-center hover:bg-[#d4b48c] hover:text-white transition-all" title="1 Column">
                            <span class="text-xs font-bold">1</span>
                        </button>
                        <button onclick="setView('grid-2')" id="grid2Btn" class="view-toggle-btn w-10 h-10 rounded-full border border-[#d4b48c]/30 flex items-center justify-center hover:bg-[#d4b48c] hover:text-white transition-all" title="2 Columns">
                            <span class="text-xs font-bold">2</span>
                        </button>
                        <button onclick="setView('grid-4')" id="grid4Btn" class="view-toggle-btn w-10 h-10 rounded-full border border-[#d4b48c]/30 flex items-center justify-center hover:bg-[#d4b48c] hover:text-white transition-all hidden md:flex" title="4 Columns">
                            <span class="text-xs font-bold">4</span>
                        </button>
                        <button onclick="setView('list')" id="listViewBtn" class="view-toggle-btn w-10 h-10 rounded-full border border-[#d4b48c]/30 flex items-center justify-center hover:bg-[#d4b48c] hover:text-white transition-all" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Loading indicator -->
                <div id="loadingIndicator" class="hidden flex justify-center items-center py-20">
                    <div class="loader"></div>
                    <span class="ml-3 text-[#8a735b]">Loading rooms...</span>
                </div>
                
                <!-- Rooms Grid -->
                <div id="roomsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <!-- Rooms will be loaded here dynamically -->
                </div>
                
                <!-- No results message -->
                <div id="noResults" class="hidden text-center py-20">
                    <i class="fas fa-bed text-6xl text-[#d4b48c]/30 mb-4"></i>
                    <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e] mb-2">No rooms found</h3>
                    <p class="text-[#8a735b]">Try adjusting your filters to find available rooms.</p>
                </div>
                
                <!-- Load More -->
                <div class="text-center mt-16 reveal" id="loadMoreContainer">
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

    <!-- JavaScript -->
    <script>
        // Global variables
        let currentViewFilter = 'all';
        let currentBedFilter = 'all';
        let currentSort = 'price_asc';
        let currentViewMode = localStorage.getItem('viewMode') || 'grid-2'; // Default to 2 columns
        
        // Get minimum date (today)
        const today = new Date().toISOString().split('T')[0];
        
        // Load rooms on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadRooms();
            applyViewMode();
            loadFilterOptions();
        });
        
        // Load filter options from database
        function loadFilterOptions() {
            const formData = new FormData();
            formData.append('action', 'get_filter_options');
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Populate view filters
                    const viewFilters = document.getElementById('viewFilters');
                    let viewHTML = '<button class="filter-btn active px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all" data-filter="view" data-value="all">All</button>';
                    data.views.forEach(view => {
                        viewHTML += `<button class="filter-btn px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all" data-filter="view" data-value="${view.name}">${view.name}</button>`;
                    });
                    viewFilters.innerHTML = viewHTML;
                    
                    // Re-attach event listeners to new filter buttons
                    attachFilterListeners();
                    
                    // Populate bed type filters
                    const bedFilters = document.getElementById('bedFilters');
                    let bedHTML = '<button class="filter-btn active px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all" data-filter="bed" data-value="all">All</button>';
                    data.bed_types.forEach(bed => {
                        bedHTML += `<button class="filter-btn px-4 py-2 text-sm border border-[#d4b48c]/30 rounded-full hover:bg-[#d4b48c] hover:text-white transition-all" data-filter="bed" data-value="${bed.name}">${bed.name}</button>`;
                    });
                    bedFilters.innerHTML = bedHTML;
                    
                    // Re-attach event listeners to new filter buttons
                    attachFilterListeners();
                }
            })
            .catch(error => {
                console.error('Error loading filter options:', error);
            });
        }
        
        // Attach filter button listeners
        function attachFilterListeners() {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const filterType = this.dataset.filter;
                    const filterValue = this.dataset.value;
                    
                    // Remove active class from siblings in same group
                    const parent = this.parentNode;
                    parent.querySelectorAll('.filter-btn').forEach(b => {
                        b.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    // Update filter values
                    if (filterType === 'view') {
                        currentViewFilter = filterValue;
                    } else if (filterType === 'bed') {
                        currentBedFilter = filterValue;
                    }
                    
                    // Reload rooms
                    loadRooms();
                });
            });
        }
        
        // Sort select change
        document.getElementById('sortSelect').addEventListener('change', function() {
            currentSort = this.value;
            loadRooms();
        });
        
        // Reset filters
        document.getElementById('resetFilters').addEventListener('click', function() {
            currentViewFilter = 'all';
            currentBedFilter = 'all';
            currentSort = 'price_asc';
            
            // Reset buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.value === 'all') {
                    btn.classList.add('active');
                }
            });
            
            document.getElementById('sortSelect').value = 'price_asc';
            
            loadRooms();
        });
        
        // Load rooms from database via AJAX
        function loadRooms() {
            const loadingIndicator = document.getElementById('loadingIndicator');
            const roomsGrid = document.getElementById('roomsGrid');
            const noResults = document.getElementById('noResults');
            
            loadingIndicator.classList.remove('hidden');
            roomsGrid.innerHTML = '';
            noResults.classList.add('hidden');
            document.getElementById('loadMoreContainer').classList.add('hidden');
            
            const formData = new FormData();
            formData.append('action', 'get_rooms');
            formData.append('view', currentViewFilter);
            formData.append('bed', currentBedFilter);
            formData.append('sort', currentSort);
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                loadingIndicator.classList.add('hidden');
                
                if (data.success && data.rooms.length > 0) {
                    document.getElementById('roomCount').textContent = data.rooms.length;
                    renderRooms(data.rooms);
                    document.getElementById('loadMoreContainer').classList.remove('hidden');
                } else {
                    noResults.classList.remove('hidden');
                    document.getElementById('roomCount').textContent = '0';
                }
            })
            .catch(error => {
                loadingIndicator.classList.add('hidden');
                console.error('Error loading rooms:', error);
                noResults.classList.remove('hidden');
            });
        }
        
        // Render rooms to the grid
        function renderRooms(rooms) {
            const roomsGrid = document.getElementById('roomsGrid');
            roomsGrid.classList.remove('grid-1', 'grid-2', 'grid-4', 'list-view');
            roomsGrid.classList.add(currentViewMode);
            
            rooms.forEach((room, index) => {
                const badge = room.badge ? `<div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs text-[#3f352e]">
                    <i class="fas fa-star text-[#d4b48c] mr-1"></i> ${room.badge}
                </div>` : '';
                
                const roomCard = `
                    <div class="room-card group relative rounded-2xl overflow-hidden reveal" style="transition-delay: ${index * 0.1}s;">
                        <div class="relative h-64 overflow-hidden">
                            <img src="${room.images[0]}" 
                                 alt="${room.name}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            
                            <button onclick="openModal('${room.id}')" class="view-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-8 py-3 rounded-full text-[#3f352e] font-medium text-sm uppercase tracking-wider shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                            
                            ${badge}
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e]">${room.name}</h3>
                                <div class="text-right">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-xl">KSh ${parseInt(room.price).toLocaleString()}</span>
                                    <p class="text-[#8a735b] text-[10px] uppercase">per night</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-xs text-[#8a735b] mb-4 pb-4 border-b border-[#d4b48c]/10">
                                <span><i class="fas fa-user mr-1"></i> ${room.occupancy}</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> ${room.size}</span>
                                <span><i class="fas fa-bed mr-1"></i> ${room.bed_type}</span>
                            </div>
                            
                            <div class="flex gap-3 text-[#8a735b] mb-4">
                                ${room.amenities.slice(0, 5).map(amenity => {
                                    let icon = 'fa-check';
                                    if (amenity.toLowerCase().includes('wifi')) icon = 'fa-wifi';
                                    else if (amenity.toLowerCase().includes('air')) icon = 'fa-snowflake';
                                    else if (amenity.toLowerCase().includes('tv')) icon = 'fa-tv';
                                    else if (amenity.toLowerCase().includes('bath')) icon = 'fa-bath';
                                    else if (amenity.toLowerCase().includes('coffee')) icon = 'fa-coffee';
                                    return `<i class="fas ${icon}" title="${amenity}"></i>`;
                                }).join('')}
                            </div>
                            
                            <button onclick="openModal('${room.id}')" class="w-full py-3 bg-[#d4b48c]/10 border border-[#d4b48c]/30 rounded-xl text-[#3f352e] text-sm uppercase tracking-wider hover:bg-[#d4b48c] hover:text-white transition-all duration-300">
                                Check Availability & Book
                            </button>
                        </div>
                    </div>
                `;
                
                roomsGrid.innerHTML += roomCard;
            });
            
            // Trigger reveal animation
            setTimeout(() => {
                reveal();
            }, 100);
        }
        
        // Modal Functions
        function openModal(roomIdOrType) {
            const modal = document.getElementById('roomModal');
            const modalContent = document.getElementById('modalContent');
            
            // Determine if we're using room_id or room_type
            const isNumeric = /^[0-9]+$/.test(roomIdOrType);
            const roomId = isNumeric ? parseInt(roomIdOrType) : 0;
            const roomType = isNumeric ? '' : roomIdOrType;
            
            // Show loading in modal
            modalContent.innerHTML = `
                <div class="flex justify-center items-center py-20">
                    <div class="loader"></div>
                    <span class="ml-3 text-[#8a735b]">Loading room details...</span>
                </div>
            `;
            
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Fetch room details
            const formData = new FormData();
            formData.append('action', 'get_room');
            if (roomId > 0) {
                formData.append('room_id', roomId);
            } else {
                formData.append('room_type', roomType);
            }
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const room = data.room;
                    
                    // Generate gallery HTML
                    let galleryHTML = `
                        <div class="grid lg:grid-cols-2 gap-8">
                            <!-- Left Column - Gallery -->
                            <div>
                                <div class="relative">
                                    <img id="mainImage" src="${room.images[0]}" alt="${room.name}" class="main-image">
                                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs text-[#3f352e]">
                                        <i class="fas fa-play-circle text-[#d4b48c] mr-1"></i> Auto-rotating
                                    </div>
                                </div>
                                
                                <div class="thumbnail-container mt-4">
                                    ${room.images.map((img, index) => `
                                        <img src="${img}" alt="Thumbnail ${index + 1}" class="thumbnail ${index === 0 ? 'active' : ''}" onclick="changeImage(this, '${img}')">
                                    `).join('')}
                                </div>
                            </div>
                            
                            <!-- Right Column - Details -->
                            <div>
                                <h2 class="font-['Cormorant_Garamond'] text-3xl md:text-4xl text-[#3f352e] mb-2">${room.name}</h2>
                                
                                <div class="flex items-center gap-3 mb-6">
                                    <span class="text-[#d4b48c] font-['DM_Serif_Display'] text-3xl">KSh ${parseInt(room.price).toLocaleString()}</span>
                                    <span class="text-[#8a735b] text-xs">per night</span>
                                </div>
                                
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
                                        <p class="text-[#3f352e] font-medium">${room.bed_type}</p>
                                    </div>
                                    <div>
                                        <p class="text-[#8a735b] text-xs uppercase">View</p>
                                        <p class="text-[#3f352e] font-medium">${room.view}</p>
                                    </div>
                                </div>
                                
                                <p class="text-[#5c524a] mb-6 leading-relaxed">${room.description}</p>
                                
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
                                <form id="availabilityForm" class="availability-form space-y-4" onsubmit="checkAvailability(event, '${room.id}', '${room.room_type}')">
                                    <input type="hidden" id="roomId" value="${room.id}">
                                    <input type="hidden" id="roomType" value="${room.room_type}">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[#8a735b] text-xs uppercase mb-1">Check-in</label>
                                            <input type="date" id="checkIn" class="w-full px-4 py-2 rounded-lg bg-white" min="${today}" required>
                                        </div>
                                        <div>
                                            <label class="block text-[#8a735b] text-xs uppercase mb-1">Check-out</label>
                                            <input type="date" id="checkOut" class="w-full px-4 py-2 rounded-lg bg-white" min="${today}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[#8a735b] text-xs uppercase mb-1">Adults</label>
                                            <select id="adults" class="w-full px-4 py-2 rounded-lg bg-white">
                                                <option value="1">1</option>
                                                <option value="2" selected>2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[#8a735b] text-xs uppercase mb-1">Children</label>
                                            <select id="children" class="w-full px-4 py-2 rounded-lg bg-white">
                                                <option value="0" selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-[#8a735b] text-xs uppercase mb-1">Special Requests</label>
                                        <textarea id="specialRequests" rows="2" class="w-full px-4 py-2 rounded-lg bg-white" placeholder="Any special requirements..."></textarea>
                                    </div>
                                    
                                    <button type="submit" id="checkAvailabilityBtn" class="w-full py-3 bg-[#d4b48c] text-white rounded-lg hover:bg-[#b89a78] transition-colors flex items-center justify-center">
                                        <span>Check Availability</span>
                                    </button>
                                </form>
                                
                                <!-- Availability Result Container -->
                                <div id="availabilityResult" class="mt-4"></div>
                            </div>
                        </div>
                    `;
                    
                    modalContent.innerHTML = galleryHTML;
                    
                    // Start auto-carousel
                    startAutoCarousel(room.images);
                } else {
                    modalContent.innerHTML = `
                        <div class="text-center py-10">
                            <i class="fas fa-exclamation-circle text-4xl text-red-500 mb-4"></i>
                            <p class="text-[#8a735b]">${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading room:', error);
                modalContent.innerHTML = `
                    <div class="text-center py-10">
                        <i class="fas fa-exclamation-circle text-4xl text-red-500 mb-4"></i>
                        <p class="text-[#8a735b]">Error loading room details. Please try again.</p>
                    </div>
                `;
            });
        }
        
        // Check availability function
        function checkAvailability(event, roomId, roomType) {
            event.preventDefault();
            
            // Get room_id from hidden field if not passed as parameter
            const roomIdInput = document.getElementById('roomId');
            const effectiveRoomId = roomIdInput ? roomIdInput.value : roomId;
            const effectiveRoomType = roomType;
            
            const checkIn = document.getElementById('checkIn').value;
            const checkOut = document.getElementById('checkOut').value;
            const adults = document.getElementById('adults').value;
            const children = document.getElementById('children').value;
            const specialRequests = document.getElementById('specialRequests').value;
            const resultContainer = document.getElementById('availabilityResult');
            const btn = document.getElementById('checkAvailabilityBtn');
            
            // Validate dates
            if (!checkIn || !checkOut) {
                resultContainer.innerHTML = `
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>Please select check-in and check-out dates.</p>
                    </div>
                `;
                return;
            }
            
            // Show loader
            btn.disabled = true;
            btn.innerHTML = `
                <div class="loader mr-2"></div>
                <span>Checking availability...</span>
            `;
            
            const formData = new FormData();
            formData.append('action', 'check_availability');
            if (effectiveRoomId) {
                formData.append('room_id', effectiveRoomId);
            }
            formData.append('room_type', effectiveRoomType);
            formData.append('check_in', checkIn);
            formData.append('check_out', checkOut);
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = `<span>Check Availability</span>`;
                
                if (data.booked) {
                    // Room is booked, show alternatives
                    let alternativesHTML = `
                        <div class="p-4 bg-orange-50 border border-orange-200 rounded-lg mb-4">
                            <p class="text-orange-700 text-sm"><i class="fas fa-calendar-times mr-2"></i>${data.message}</p>
                        </div>
                        <h4 class="font-['Cormorant_Garamond'] text-lg text-[#3f352e] mb-3">Available Alternatives</h4>
                        <div class="space-y-3">
                    `;
                    
                    if (data.alternatives && data.alternatives.length > 0) {
                        data.alternatives.forEach(alt => {
                            alternativesHTML += `
                                <div class="flex items-center gap-4 p-3 bg-white rounded-lg border border-[#d4b48c]/20 cursor-pointer hover:border-[#d4b48c] transition-all" onclick="openModal('${alt.id}')">
                                    <img src="${alt.images[0]}" alt="${alt.name}" class="w-16 h-16 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h5 class="text-[#3f352e] font-medium">${alt.name}</h5>
                                        <p class="text-[#d4b48c] font-['DM_Serif_Display']">KSh ${parseInt(alt.price).toLocaleString()}/night</p>
                                    </div>
                                    <button class="px-3 py-1 bg-[#d4b48c] text-white text-xs rounded-full">Book</button>
                                </div>
                            `;
                        });
                    } else {
                        alternativesHTML += `
                            <p class="text-[#8a735b] text-sm">No alternative rooms available for these dates. Please try different dates.</p>
                        `;
                    }
                    
                    alternativesHTML += `</div>`;
                    resultContainer.innerHTML = alternativesHTML;
                } else if (data.available) {
                    // Room is available, show booking option
                    const room = data.room;
                    const totalPrice = data.total_price;
                    const nights = data.nights;
                    
                    resultContainer.innerHTML = `
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg mb-4">
                            <p class="text-green-700 text-sm"><i class="fas fa-check-circle mr-2"></i>This room is available for your selected dates! Please proceed with your booking</p>
                            <p class="text-[#8a735b] text-xs mt-1">${nights} night${nights > 1 ? 's' : ''} - KSh ${totalPrice.toLocaleString()}</p>
                        </div>
                        
                        <!-- Guest Details for Booking -->
                        <div class="bg-white p-4 rounded-lg border border-[#d4b48c]/20">
                            <h4 class="font-['Cormorant_Garamond'] text-lg text-[#3f352e] mb-3">Complete Your Booking</h4>
                            <form id="bookingForm" onsubmit="confirmBooking(event, '${room.id}', '${room.room_type}')">
                                <input type="hidden" id="bookingRoomId" value="${room.id}">
                                <input type="hidden" id="bookingRoomType" value="${room.room_type}">
                                <input type="hidden" id="bookingCheckIn" value="${checkIn}">
                                <input type="hidden" id="bookingCheckOut" value="${checkOut}">
                                <input type="hidden" id="bookingAdults" value="${adults}">
                                <input type="hidden" id="bookingChildren" value="${children}">
                                <input type="hidden" id="bookingSpecialRequests" value="${specialRequests}">
                                
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-[#8a735b] text-xs uppercase mb-1">Full Name *</label>
                                        <input type="text" id="guestName" class="w-full px-4 py-2 rounded-lg bg-white border border-[#d4b48c]/30" placeholder="Enter your full name" required>
                                    </div>
                                    <div>
                                        <label class="block text-[#8a735b] text-xs uppercase mb-1">Email Address *</label>
                                        <input type="email" id="guestEmail" class="w-full px-4 py-2 rounded-lg bg-white border border-[#d4b48c]/30" placeholder="Enter your email" required>
                                    </div>
                                    <div>
                                        <label class="block text-[#8a735b] text-xs uppercase mb-1">Phone Number</label>
                                        <input type="tel" id="guestPhone" class="w-full px-4 py-2 rounded-lg bg-white border border-[#d4b48c]/30" placeholder="Enter your phone number">
                                    </div>
                                </div>
                                
                                <div class="mt-4 p-3 bg-[#f5efe8] rounded-lg">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-[#8a735b]">Room (${nights} night${nights > 1 ? 's' : ''})</span>
                                        <span class="text-[#3f352e]">KSh ${totalPrice.toLocaleString()}</span>
                                    </div>
                                </div>
                                
                                <button type="submit" id="confirmBookingBtn" class="w-full mt-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
                                    <i class="fas fa-check mr-2"></i>
                                    <span>Confirm Booking</span>
                                </button>
                            </form>
                        </div>
                    `;
                } else {
                    resultContainer.innerHTML = `
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = `<span>Check Availability</span>`;
                console.error('Error checking availability:', error);
                resultContainer.innerHTML = `
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>Error checking availability. Please try again.</p>
                    </div>
                `;
            });
        }
        
        // Confirm booking function
        function confirmBooking(event, roomId, roomType) {
            event.preventDefault();
            
            // Get room_id from hidden field if not passed as parameter
            const roomIdInput = document.getElementById('bookingRoomId');
            const effectiveRoomId = roomIdInput ? roomIdInput.value : roomId;
            const effectiveRoomType = roomType;
            
            const guestName = document.getElementById('guestName').value;
            const guestEmail = document.getElementById('guestEmail').value;
            const guestPhone = document.getElementById('guestPhone').value;
            const checkIn = document.getElementById('bookingCheckIn').value;
            const checkOut = document.getElementById('bookingCheckOut').value;
            const adults = document.getElementById('bookingAdults').value;
            const children = document.getElementById('bookingChildren').value;
            const specialRequests = document.getElementById('bookingSpecialRequests').value;
            
            const btn = document.getElementById('confirmBookingBtn');
            const resultContainer = document.getElementById('availabilityResult');
            
            // Show loader
            btn.disabled = true;
            btn.innerHTML = `
                <div class="loader mr-2"></div>
                <span>Processing booking...</span>
            `;
            
            const formData = new FormData();
            formData.append('action', 'create_booking');
            if (effectiveRoomId) {
                formData.append('room_id', effectiveRoomId);
            }
            formData.append('room_type', effectiveRoomType);
            formData.append('guest_name', guestName);
            formData.append('guest_email', guestEmail);
            formData.append('guest_phone', guestPhone);
            formData.append('check_in', checkIn);
            formData.append('check_out', checkOut);
            formData.append('adults', adults);
            formData.append('children', children);
            formData.append('special_requests', specialRequests);
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-check mr-2"></i><span>Confirm Booking</span>`;
                
                if (data.success) {
                    // Show success message
                    resultContainer.innerHTML = `
                        <div class="text-center py-6">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check text-3xl text-green-600"></i>
                            </div>
                            <h4 class="font-['Cormorant_Garamond'] text-2xl text-[#3f352e] mb-2">Booking Confirmed!</h4>
                            <p class="text-[#8a735b] mb-4">Your booking has been successfully confirmed.</p>
                            <div class="bg-white p-4 rounded-lg border border-[#d4b48c]/20 text-left mb-4">
                                <p class="text-sm text-[#8a735b]"><strong>Booking ID:</strong> #${data.booking.booking_id}</p>
                                <p class="text-sm text-[#8a735b]"><strong>Room:</strong> ${data.room.name}</p>
                                <p class="text-sm text-[#8a735b]"><strong>Check-in:</strong> ${checkIn}</p>
                                <p class="text-sm text-[#8a735b]"><strong>Check-out:</strong> ${checkOut}</p>
                                <p class="text-sm text-[#8a735b]"><strong>Total:</strong> KSh ${data.booking.total_price.toLocaleString()}</p>
                            </div>
                            <p class="text-sm text-[#8a735b]">A confirmation email has been sent to ${guestEmail}</p>
                            <button onclick="closeModal()" class="mt-4 px-6 py-2 bg-[#d4b48c] text-white rounded-full hover:bg-[#b89a78] transition-colors">
                                Close
                            </button>
                        </div>
                    `;
                } else {
                    resultContainer.innerHTML = `
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-check mr-2"></i><span>Confirm Booking</span>`;
                console.error('Error creating booking:', error);
                resultContainer.innerHTML = `
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>Error creating booking. Please try again.</p>
                    </div>
                `;
            });
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
            document.getElementById('mainImage').src = src;
            
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
            
            if (window.carouselInterval) {
                clearInterval(window.carouselInterval);
            }
        }
        
        // Auto-carousel function
        function startAutoCarousel(images) {
            let currentIndex = 0;
            
            if (window.carouselInterval) {
                clearInterval(window.carouselInterval);
            }
            
            window.carouselInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % images.length;
                const mainImage = document.getElementById('mainImage');
                if (mainImage) {
                    mainImage.src = images[currentIndex];
                    
                    const thumbnails = document.querySelectorAll('.thumbnail');
                    thumbnails.forEach((thumb, index) => {
                        if (index === currentIndex) {
                            thumb.classList.add('active');
                        } else {
                            thumb.classList.remove('active');
                        }
                    });
                }
            }, 4000);
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
        
        // View toggle functions
        function setView(viewMode) {
            currentViewMode = viewMode;
            localStorage.setItem('viewMode', viewMode);
            
            // Update all button states
            document.getElementById('grid1Btn').classList.remove('active');
            document.getElementById('grid2Btn').classList.remove('active');
            document.getElementById('grid4Btn').classList.remove('active');
            document.getElementById('listViewBtn').classList.remove('active');
            
            // Add active class to selected button
            if (viewMode === 'grid-1') {
                document.getElementById('grid1Btn').classList.add('active');
            } else if (viewMode === 'grid-2') {
                document.getElementById('grid2Btn').classList.add('active');
            } else if (viewMode === 'grid-4') {
                document.getElementById('grid4Btn').classList.add('active');
            } else if (viewMode === 'list') {
                document.getElementById('listViewBtn').classList.add('active');
            }
            
            // Apply view mode to grid
            const roomsGrid = document.getElementById('roomsGrid');
            roomsGrid.classList.remove('grid-1', 'grid-2', 'grid-4', 'list-view');
            roomsGrid.classList.add(viewMode);
        }
        
        function applyViewMode() {
            // Check if we're on mobile
            const isMobile = window.innerWidth < 768;
            const isTablet = window.innerWidth < 1024;
            
            // If saved view is grid-4 but we're on tablet/mobile, default to grid-2
            if (currentViewMode === 'grid-4' && isTablet) {
                currentViewMode = 'grid-2';
            }
            
            setView(currentViewMode);
        }
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
<?php include 'footer.php'; ?>
