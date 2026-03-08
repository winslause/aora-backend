<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora Admin Dashboard - Luxury Resort & Restaurant</title>
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js for analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #b89a78;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #8a735b;
        }

        /* Admin specific styles */
        .admin-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
            border: 1px solid rgba(184, 154, 120, 0.1);
        }

        .admin-card:hover {
            box-shadow: 0 8px 30px rgba(184, 154, 120, 0.12);
            border-color: rgba(184, 154, 120, 0.2);
        }

        .stat-card {
            background: linear-gradient(145deg, #ffffff, #faf9f8);
            border-left: 4px solid #b89a78;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #4b5563;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
        }

        .sidebar-link:hover {
            background: #fef7f0;
            color: #b89a78;
            border-left-color: #b89a78;
        }

        .sidebar-link.active {
            background: #fef7f0;
            color: #b89a78;
            border-left-color: #b89a78;
            font-weight: 600;
        }

        .sidebar-link i {
            width: 24px;
            font-size: 1.1rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-badge.confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-badge.checked-in {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Table styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            font-size: 0.9rem;
        }

        .data-table tbody tr:hover {
            background: #fef7f0;
        }

        /* Form elements */
        .admin-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .admin-input:focus {
            outline: none;
            border-color: #b89a78;
            box-shadow: 0 0 0 3px rgba(184, 154, 120, 0.1);
        }

        .admin-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            cursor: pointer;
        }

        .admin-btn-primary {
            background: #b89a78;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #b89a78;
        }

        .admin-btn-primary:hover {
            background: #8a735b;
            border-color: #8a735b;
        }

        .admin-btn-secondary {
            background: white;
            color: #4b5563;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
        }

        .admin-btn-secondary:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        /* Tabs */
        .admin-tab {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            color: #6b7280;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .admin-tab:hover {
            color: #b89a78;
        }

        .admin-tab.active {
            color: #b89a78;
            border-bottom-color: #b89a78;
        }

        /* Calendar */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .calendar-day {
            aspect-ratio: 1;
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        .calendar-day.available {
            background: #f0fdf4;
            border-color: #86efac;
        }

        .calendar-day.booked {
            background: #fee2e2;
            border-color: #fecaca;
        }

        .calendar-day.maintenance {
            background: #fff3cd;
            border-color: #ffe69c;
        }

        /* Mobile menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100vh;
            background: white;
            z-index: 1000;
            transition: left 0.3s ease;
            box-shadow: 2px 0 20px rgba(0,0,0,0.1);
        }

        .mobile-menu.open {
            left: 0;
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }

        .mobile-overlay.open {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="mobile-overlay"></div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu lg:hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#b89a78] rounded-lg flex items-center justify-center">
                    <span class="text-white font-['Playfair_Display'] font-bold text-xl">A</span>
                </div>
                <div>
                    <h2 class="font-['Playfair_Display'] font-bold text-lg">Aora Admin</h2>
                    <p class="text-xs text-gray-500">v2.0.0</p>
                </div>
            </div>
        </div>
        <div class="py-4">
            <a href="#" class="sidebar-link active"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="#" class="sidebar-link"><i class="fas fa-bed"></i> Room Management</a>
            <a href="#" class="sidebar-link"><i class="fas fa-utensils"></i> Restaurant</a>
            <a href="#" class="sidebar-link"><i class="fas fa-calendar-check"></i> Bookings</a>
            <a href="#" class="sidebar-link"><i class="fas fa-users"></i> Guests</a>
            <a href="#" class="sidebar-link"><i class="fas fa-credit-card"></i> Payments</a>
            <a href="#" class="sidebar-link"><i class="fas fa-file-alt"></i> Content</a>
            <a href="#" class="sidebar-link"><i class="fas fa-chart-line"></i> Reports</a>
            <a href="#" class="sidebar-link"><i class="fas fa-cog"></i> Settings</a>
        </div>
        <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-200">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=b89a78&color=fff" alt="Admin" class="w-10 h-10 rounded-full">
                <div>
                    <p class="font-medium text-sm">Admin User</p>
                    <p class="text-xs text-gray-500">admin@aora.com</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - Desktop -->
        <aside class="hidden lg:flex lg:flex-col w-72 bg-white border-r border-gray-200 h-screen fixed left-0 top-0 overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-[#b89a78] rounded-xl flex items-center justify-center">
                        <span class="text-white font-['Playfair_Display'] font-bold text-2xl">A</span>
                    </div>
                    <div>
                        <h1 class="font-['Playfair_Display'] font-bold text-xl text-gray-800">Aora</h1>
                        <p class="text-xs text-gray-500">Admin Dashboard</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 py-6">
                <div class="px-4 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</p>
                </div>
                <a href="#" class="sidebar-link active"><i class="fas fa-chart-pie"></i> Dashboard</a>
                <a href="#" class="sidebar-link"><i class="fas fa-bed"></i> Room Management</a>
                <a href="#" class="sidebar-link"><i class="fas fa-utensils"></i> Restaurant</a>
                <a href="#" class="sidebar-link"><i class="fas fa-calendar-check"></i> Bookings</a>
                <a href="#" class="sidebar-link"><i class="fas fa-users"></i> Guest Management</a>
                
                <div class="px-4 mt-6 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Operations</p>
                </div>
                <a href="#" class="sidebar-link"><i class="fas fa-credit-card"></i> Payments & Invoicing</a>
                <a href="#" class="sidebar-link"><i class="fas fa-file-alt"></i> Content Management</a>
                <a href="#" class="sidebar-link"><i class="fas fa-tags"></i> Offers & Packages</a>
                <a href="#" class="sidebar-link"><i class="fas fa-map-marker-alt"></i> Location & Contact</a>
                <a href="#" class="sidebar-link"><i class="fas fa-user-tie"></i> Staff Management</a>
                
                <div class="px-4 mt-6 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Analytics</p>
                </div>
                <a href="#" class="sidebar-link"><i class="fas fa-chart-line"></i> Reports & Analytics</a>
                <a href="#" class="sidebar-link"><i class="fas fa-chart-bar"></i> Financial Reports</a>
                
                <div class="px-4 mt-6 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p>
                </div>
                <a href="#" class="sidebar-link"><i class="fas fa-cog"></i> Settings</a>
                <a href="#" class="sidebar-link"><i class="fas fa-shield-alt"></i> Security</a>
                <a href="#" class="sidebar-link"><i class="fas fa-tools"></i> Maintenance</a>
            </nav>

            <div class="p-6 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=b89a78&color=fff" alt="Admin" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-medium text-sm">Admin User</p>
                        <p class="text-xs text-gray-500">admin@aora.com</p>
                    </div>
                    <button class="ml-auto text-gray-400 hover:text-gray-600">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 lg:ml-72 h-screen overflow-y-auto">
            <!-- Top Navigation -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button id="mobileMenuBtn" class="lg:hidden text-gray-600 hover:text-[#b89a78] text-xl">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="text-lg font-semibold text-gray-800">Dashboard Overview</h2>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <!-- Search -->
                        <div class="hidden md:block relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm w-64 focus:outline-none focus:border-[#b89a78] focus:ring-1 focus:ring-[#b89a78]">
                        </div>
                        
                        <!-- Notifications -->
                        <button class="relative text-gray-600 hover:text-[#b89a78]">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs flex items-center justify-center rounded-full">3</span>
                        </button>
                        
                        <!-- Date -->
                        <div class="hidden lg:flex items-center gap-2 text-sm text-gray-600">
                            <i class="far fa-calendar-alt"></i>
                            <span>March 8, 2026</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="stat-card admin-card p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-check text-2xl text-[#b89a78]"></i>
                            </div>
                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">+12.5%</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">187</h3>
                        <p class="text-sm text-gray-500">Total Bookings</p>
                        <p class="text-xs text-gray-400 mt-2">↑ 23 from last month</p>
                    </div>

                    <div class="stat-card admin-card p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-2xl text-[#b89a78]"></i>
                            </div>
                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">+8.2%</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">KSh 1,284,500</h3>
                        <p class="text-sm text-gray-500">Revenue (This Month)</p>
                        <p class="text-xs text-gray-400 mt-2">Rooms: KSh 845,000 | Dining: KSh 439,500</p>
                    </div>

                    <div class="stat-card admin-card p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                                <i class="fas fa-bed text-2xl text-[#b89a78]"></i>
                            </div>
                            <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">78%</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">39 / 50</h3>
                        <p class="text-sm text-gray-500">Occupancy Rate</p>
                        <p class="text-xs text-gray-400 mt-2">11 rooms available tonight</p>
                    </div>

                    <div class="stat-card admin-card p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                                <i class="fas fa-smile text-2xl text-[#b89a78]"></i>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">4.8 / 5</h3>
                        <p class="text-sm text-gray-500">Guest Satisfaction</p>
                        <p class="text-xs text-gray-400 mt-2">Based on 156 reviews</p>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Revenue Chart -->
                    <div class="admin-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-800">Revenue Overview</h3>
                            <select class="admin-select text-sm py-1 px-2 w-32">
                                <option>This Week</option>
                                <option>This Month</option>
                                <option selected>This Year</option>
                            </select>
                        </div>
                        <canvas id="revenueChart" height="150"></canvas>
                    </div>

                    <!-- Occupancy Chart -->
                    <div class="admin-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-800">Occupancy Rates</h3>
                            <select class="admin-select text-sm py-1 px-2 w-32">
                                <option>Last 7 days</option>
                                <option selected>Last 30 days</option>
                                <option>Last 90 days</option>
                            </select>
                        </div>
                        <canvas id="occupancyChart" height="150"></canvas>
                    </div>
                </div>

                <!-- Upcoming Bookings & Recent Reservations -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Upcoming Check-ins -->
                    <div class="admin-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-800">Upcoming Check-ins</h3>
                            <a href="#" class="text-sm text-[#b89a78] hover:underline">View all</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=John+Smith&background=b89a78&color=fff" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-medium text-sm">John Smith</p>
                                        <p class="text-xs text-gray-500">Deluxe Suite • 2 guests</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-sm">Today, 2:00 PM</p>
                                    <span class="status-badge confirmed">Confirmed</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=b89a78&color=fff" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-medium text-sm">Sarah Johnson</p>
                                        <p class="text-xs text-gray-500">Executive Suite • 2 guests</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-sm">Tomorrow, 3:00 PM</p>
                                    <span class="status-badge confirmed">Confirmed</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Michael+Chen&background=b89a78&color=fff" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-medium text-sm">Michael Chen</p>
                                        <p class="text-xs text-gray-500">Family Villa • 4 guests</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-sm">Mar 10, 2:00 PM</p>
                                    <span class="status-badge pending">Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Restaurant Reservations -->
                    <div class="admin-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-800">Recent Restaurant Reservations</h3>
                            <a href="#" class="text-sm text-[#b89a78] hover:underline">View all</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#b89a78]/10 rounded-full flex items-center justify-center">
                                        <i class="fas fa-users text-[#b89a78]"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm">Emily Davis</p>
                                        <p class="text-xs text-gray-500">Table 7 • 4 guests • 7:30 PM</p>
                                    </div>
                                </div>
                                <span class="status-badge confirmed">Confirmed</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#b89a78]/10 rounded-full flex items-center justify-center">
                                        <i class="fas fa-heart text-[#b89a78]"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm">James Wilson</p>
                                        <p class="text-xs text-gray-500">Chef's Table • 2 guests • 8:00 PM</p>
                                    </div>
                                </div>
                                <span class="status-badge confirmed">Confirmed</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#b89a78]/10 rounded-full flex items-center justify-center">
                                        <i class="fas fa-birthday-cake text-[#b89a78]"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm">Lisa Mbeki</p>
                                        <p class="text-xs text-gray-500">Table 12 • 6 guests • 6:30 PM</p>
                                    </div>
                                </div>
                                <span class="status-badge pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Management Section -->
                <div class="admin-card p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-semibold text-gray-800">Room Management</h3>
                        <div class="flex gap-2">
                            <button class="admin-btn-primary text-sm py-2"><i class="fas fa-plus mr-2"></i>Add Room</button>
                            <button class="admin-btn-secondary text-sm py-2"><i class="fas fa-filter mr-2"></i>Filter</button>
                        </div>
                    </div>
                    
                    <!-- Room Tabs -->
                    <div class="flex border-b border-gray-200 mb-6">
                        <button class="admin-tab active">All Rooms (50)</button>
                        <button class="admin-tab">Available (11)</button>
                        <button class="admin-tab">Occupied (34)</button>
                        <button class="admin-tab">Maintenance (5)</button>
                    </div>

                    <!-- Room Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-[#b89a78] transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium">Room 101</span>
                                <span class="status-badge checked-in">Occupied</span>
                            </div>
                            <p class="text-sm text-gray-600">Deluxe Suite • King Bed</p>
                            <p class="text-xs text-gray-500 mt-1">Check-out: Today, 12:00 PM</p>
                            <div class="mt-3 flex gap-2">
                                <button class="text-xs text-[#b89a78] hover:underline">View</button>
                                <button class="text-xs text-gray-500 hover:underline">Edit</button>
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-[#b89a78] transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium">Room 205</span>
                                <span class="status-badge available">Available</span>
                            </div>
                            <p class="text-sm text-gray-600">Executive Suite • Ocean View</p>
                            <p class="text-xs text-gray-500 mt-1">KSh 25,000 / night</p>
                            <div class="mt-3 flex gap-2">
                                <button class="text-xs text-[#b89a78] hover:underline">View</button>
                                <button class="text-xs text-gray-500 hover:underline">Edit</button>
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-[#b89a78] transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium">Room 312</span>
                                <span class="status-badge maintenance">Maintenance</span>
                            </div>
                            <p class="text-sm text-gray-600">Family Villa • Garden View</p>
                            <p class="text-xs text-gray-500 mt-1">Until Mar 12, 2026</p>
                            <div class="mt-3 flex gap-2">
                                <button class="text-xs text-[#b89a78] hover:underline">View</button>
                                <button class="text-xs text-gray-500 hover:underline">Edit</button>
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-[#b89a78] transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium">Room 408</span>
                                <span class="status-badge available">Available</span>
                            </div>
                            <p class="text-sm text-gray-600">Presidential Suite</p>
                            <p class="text-xs text-gray-500 mt-1">KSh 45,000 / night</p>
                            <div class="mt-3 flex gap-2">
                                <button class="text-xs text-[#b89a78] hover:underline">View</button>
                                <button class="text-xs text-gray-500 hover:underline">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Restaurant Management Section -->
                <div class="admin-card p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-semibold text-gray-800">Restaurant Management</h3>
                        <div class="flex gap-2">
                            <button class="admin-btn-primary text-sm py-2"><i class="fas fa-plus mr-2"></i>Add Dish</button>
                            <button class="admin-btn-primary text-sm py-2 bg-[#8a735b]"><i class="fas fa-chair mr-2"></i>Manage Tables</button>
                        </div>
                    </div>

                    <!-- Menu Categories Tabs -->
                    <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
                        <button class="px-4 py-2 bg-[#b89a78] text-white rounded-full text-sm whitespace-nowrap">All Items</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm whitespace-nowrap hover:bg-gray-200">Starters</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm whitespace-nowrap hover:bg-gray-200">Main Course</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm whitespace-nowrap hover:bg-gray-200">Desserts</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm whitespace-nowrap hover:bg-gray-200">Beverages</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm whitespace-nowrap hover:bg-gray-200">Specials</button>
                    </div>

                    <!-- Menu Items Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="flex gap-3 p-3 border border-gray-200 rounded-lg">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=150&h=150&fit=crop" alt="Dish" class="w-16 h-16 rounded-lg object-cover">
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="font-medium text-sm">Grilled Lobster</h4>
                                    <span class="text-[#b89a78] font-semibold">KSh 4,500</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Fresh Atlantic lobster with herb butter</p>
                                <div class="flex gap-2 mt-2">
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Signature</span>
                                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">Chef's Pick</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3 p-3 border border-gray-200 rounded-lg">
                            <img src="https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=150&h=150&fit=crop" alt="Dish" class="w-16 h-16 rounded-lg object-cover">
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="font-medium text-sm">Nyama Choma Platter</h4>
                                    <span class="text-[#b89a78] font-semibold">KSh 3,200</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Grilled meats with kachumbari</p>
                                <div class="flex gap-2 mt-2">
                                    <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full">Local Favorite</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3 p-3 border border-gray-200 rounded-lg">
                            <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=150&h=150&fit=crop" alt="Dish" class="w-16 h-16 rounded-lg object-cover">
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="font-medium text-sm">Chocolate Fondant</h4>
                                    <span class="text-[#b89a78] font-semibold">KSh 1,200</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Warm chocolate cake with vanilla ice cream</p>
                                <div class="flex gap-2 mt-2">
                                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full">Vegetarian</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings Table -->
                <div class="admin-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">Recent Bookings</h3>
                        <div class="flex gap-3">
                            <select class="admin-select text-sm py-1 px-3">
                                <option>All Status</option>
                                <option>Confirmed</option>
                                <option>Pending</option>
                                <option>Cancelled</option>
                            </select>
                            <button class="admin-btn-primary text-sm py-2"><i class="fas fa-download mr-2"></i>Export</button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Guest</th>
                                    <th>Room Type</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-medium">#BK-2024-001</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Robert+Brown&background=b89a78&color=fff" class="w-8 h-8 rounded-full">
                                            <span>Robert Brown</span>
                                        </div>
                                    </td>
                                    <td>Deluxe Suite</td>
                                    <td>Mar 8, 2026</td>
                                    <td>Mar 12, 2026</td>
                                    <td><span class="status-badge confirmed">Confirmed</span></td>
                                    <td><span class="text-green-600">Paid</span></td>
                                    <td>
                                        <button class="text-[#b89a78] hover:text-[#8a735b] mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-medium">#BK-2024-002</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Mary+Wambui&background=b89a78&color=fff" class="w-8 h-8 rounded-full">
                                            <span>Mary Wambui</span>
                                        </div>
                                    </td>
                                    <td>Executive Suite</td>
                                    <td>Mar 9, 2026</td>
                                    <td>Mar 11, 2026</td>
                                    <td><span class="status-badge pending">Pending</span></td>
                                    <td><span class="text-yellow-600">Pending</span></td>
                                    <td>
                                        <button class="text-[#b89a78] hover:text-[#8a735b] mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-medium">#BK-2024-003</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=David+Odhiambo&background=b89a78&color=fff" class="w-8 h-8 rounded-full">
                                            <span>David Odhiambo</span>
                                        </div>
                                    </td>
                                    <td>Family Villa</td>
                                    <td>Mar 10, 2026</td>
                                    <td>Mar 15, 2026</td>
                                    <td><span class="status-badge confirmed">Confirmed</span></td>
                                    <td><span class="text-green-600">Paid</span></td>
                                    <td>
                                        <button class="text-[#b89a78] hover:text-[#8a735b] mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('open');
            mobileOverlay.classList.add('open');
        });

        mobileOverlay.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
            mobileOverlay.classList.remove('open');
        });

        // Charts initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue (KSh)',
                        data: [850000, 920000, 1100000, 980000, 1050000, 1284500, 1150000, 1220000, 1180000, 1350000, 1420000, 1580000],
                        borderColor: '#b89a78',
                        backgroundColor: 'rgba(184, 154, 120, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'KSh ' + (value / 1000) + 'k';
                                }
                            }
                        }
                    }
                }
            });

            // Occupancy Chart
            const occupancyCtx = document.getElementById('occupancyChart').getContext('2d');
            new Chart(occupancyCtx, {
                type: 'bar',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [
                        {
                            label: 'Occupied',
                            data: [65, 72, 78, 82],
                            backgroundColor: '#b89a78',
                        },
                        {
                            label: 'Available',
                            data: [35, 28, 22, 18],
                            backgroundColor: '#e5e7eb',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>