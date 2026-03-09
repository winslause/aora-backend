<?php
// Admin Dashboard with full functionality
// Check if session is already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'database.php';

// Get current tab
$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora Admin Dashboard - Luxury Resort & Restaurant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #b89a78; border-radius: 4px; }
        .admin-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02); transition: all 0.2s ease; border: 1px solid rgba(184, 154, 120, 0.1); }
        .admin-card:hover { box-shadow: 0 8px 30px rgba(184, 154, 120, 0.12); border-color: rgba(184, 154, 120, 0.2); }
        .stat-card { background: linear-gradient(145deg, #ffffff, #faf9f8); border-left: 4px solid #b89a78; }
        .sidebar-link { display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #4b5563; transition: all 0.2s ease; border-left: 3px solid transparent; font-weight: 500; }
        .sidebar-link:hover { background: #fef7f0; color: #b89a78; border-left-color: #b89a78; }
        .sidebar-link.active { background: #fef7f0; color: #b89a78; border-left-color: #b89a78; font-weight: 600; }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
        .status-badge.confirmed { background: #d1fae5; color: #065f46; }
        .status-badge.pending { background: #fff3cd; color: #856404; }
        .status-badge.cancelled { background: #fee2e2; color: #991b1b; }
        .status-badge.contacted { background: #dbeafe; color: #1e40af; }
        .admin-input { width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 8px; transition: all 0.2s ease; font-size: 0.95rem; }
        .admin-input:focus { outline: none; border-color: #b89a78; box-shadow: 0 0 0 3px rgba(184, 154, 120, 0.1); }
        .admin-btn-primary { background: #b89a78; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; transition: all 0.2s ease; border: 1px solid #b89a78; cursor: pointer; }
        .admin-btn-primary:hover { background: #8a735b; border-color: #8a735b; }
        .admin-btn-secondary { background: white; color: #4b5563; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; transition: all 0.2s ease; border: 1px solid #e5e7eb; cursor: pointer; }
        .admin-btn-secondary:hover { background: #f9fafb; border-color: #d1d5db; }
        .admin-btn-danger { background: #ef4444; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; transition: all 0.2s ease; border: 1px solid #ef4444; cursor: pointer; }
        .admin-btn-danger:hover { background: #dc2626; border-color: #dc2626; }
        .admin-tab { padding: 0.75rem 1.5rem; font-weight: 500; color: #6b7280; border-bottom: 2px solid transparent; transition: all 0.2s ease; cursor: pointer; }
        .admin-tab:hover { color: #b89a78; }
        .admin-tab.active { color: #b89a78; border-bottom-color: #b89a78; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { text-align: left; padding: 1rem; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; background: #f9fafb; border-bottom: 2px solid #e5e7eb; }
        .data-table td { padding: 1rem; border-bottom: 1px solid #e5e7eb; color: #374151; font-size: 0.9rem; }
        .data-table tbody tr:hover { background: #fef7f0; }
        .mobile-menu { position: fixed; top: 0; left: -280px; width: 280px; height: 100vh; background: white; z-index: 1000; transition: left 0.3s ease; box-shadow: 2px 0 20px rgba(0,0,0,0.1); }
        .mobile-menu.open { left: 0; }
        .mobile-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; display: none; }
        .mobile-overlay.open { display: block; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal.open { display: flex; }
        .modal-content { background: white; border-radius: 16px; padding: 2rem; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; }
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
            <a href="?tab=dashboard" class="sidebar-link <?php echo $current_tab == 'dashboard' ? 'active' : ''; ?>"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="?tab=rooms" class="sidebar-link <?php echo $current_tab == 'rooms' ? 'active' : ''; ?>"><i class="fas fa-bed"></i> Room Management</a>
            <a href="?tab=amenities" class="sidebar-link <?php echo $current_tab == 'amenities' ? 'active' : ''; ?>"><i class="fas fa-concierge-bell"></i> Amenities</a>
            <a href="?tab=bookings" class="sidebar-link <?php echo $current_tab == 'bookings' ? 'active' : ''; ?>"><i class="fas fa-calendar-check"></i> Bookings</a>
            <a href="?tab=events" class="sidebar-link <?php echo $current_tab == 'events' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i> Events</a>
            <a href="admin_login.php?logout=1" class="sidebar-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                <a href="?tab=dashboard" class="sidebar-link <?php echo $current_tab == 'dashboard' ? 'active' : ''; ?>"><i class="fas fa-chart-pie"></i> Dashboard</a>
                <a href="?tab=rooms" class="sidebar-link <?php echo $current_tab == 'rooms' ? 'active' : ''; ?>"><i class="fas fa-bed"></i> Room Management</a>
                <a href="?tab=amenities" class="sidebar-link <?php echo $current_tab == 'amenities' ? 'active' : ''; ?>"><i class="fas fa-concierge-bell"></i> Amenities</a>
                <a href="?tab=bookings" class="sidebar-link <?php echo $current_tab == 'bookings' ? 'active' : ''; ?>"><i class="fas fa-calendar-check"></i> Bookings</a>
                <a href="?tab=events" class="sidebar-link <?php echo $current_tab == 'events' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i> Events</a>
                
                <div class="px-4 mt-6 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Account</p>
                </div>
                <a href="admin_login.php?logout=1" class="sidebar-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>

            <div class="p-6 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=b89a78&color=fff" alt="Admin" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-medium text-sm"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></p>
                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($_SESSION['admin_email']); ?></p>
                    </div>
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
                        <h2 class="text-lg font-semibold text-gray-800">
                            <?php 
                            switch($current_tab) {
                                case 'dashboard': echo 'Dashboard Overview'; break;
                                case 'rooms': echo 'Room Management'; break;
                                case 'amenities': echo 'Amenities Management'; break;
                                case 'bookings': echo 'Bookings Management'; break;
                                case 'events': echo 'Events Management'; break;
                                default: echo 'Dashboard Overview';
                            }
                            ?>
                        </h2>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="hidden lg:flex items-center gap-2 text-sm text-gray-600">
                            <i class="far fa-calendar-alt"></i>
                            <span><?php echo date('F j, Y'); ?></span>
                        </div>
                        <a href="admin_login.php?logout=1" class="text-gray-600 hover:text-red-500">
                            <i class="fas fa-sign-out-alt text-xl"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="p-6">
                <?php include 'admin_content.php'; ?>
            </div>
        </main>
    </div>

    <!-- Email Modal -->
    <div id="emailModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Send Message to Guest</h3>
                <button onclick="closeEmailModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="emailForm">
                <input type="hidden" id="emailBookingId">
                <input type="hidden" id="emailInquiryId">
                <input type="hidden" id="emailType">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <input type="text" id="emailSubject" class="admin-input" placeholder="Enter email subject" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="emailMessage" class="admin-input" rows="6" placeholder="Enter your message" required></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeEmailModal()" class="admin-btn-secondary flex-1">Cancel</button>
                    <button type="submit" class="admin-btn-primary flex-1">
                        <i class="fas fa-paper-plane mr-2"></i>Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Room Modal -->
    <div id="roomModal" class="modal">
        <div class="modal-content" style="max-width: 800px;">
            <div class="flex justify-between items-center mb-4">
                <h3 id="roomModalTitle" class="text-xl font-semibold">Add New Room</h3>
                <button onclick="closeRoomModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="roomForm">
                <input type="hidden" id="roomId">
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Room Type</label>
                        <select id="roomType" class="admin-input" required>
                            <option value="">Select Room Type</option>
                        </select>
                        <button type="button" onclick="openRoomTypeModal()" class="text-xs text-[#b89a78] hover:text-[#8a735b] mt-1">+ Add New Room Type</button>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Room Name</label>
                        <input type="text" id="roomName" class="admin-input" placeholder="e.g., Deluxe Room" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price (KSh)</label>
                        <input type="number" id="roomPrice" class="admin-input" placeholder="35000" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                        <input type="text" id="roomSize" class="admin-input" placeholder="e.g., 45 m²">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Occupancy</label>
                        <input type="text" id="roomOccupancy" class="admin-input" placeholder="e.g., 2 Adults">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bed Type</label>
                        <div class="flex gap-2">
                            <select id="roomBedType" class="admin-input flex-1">
                                <option value="">Select Bed Type</option>
                            </select>
                            <button type="button" onclick="openManageBedTypesModal()" class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 text-gray-600" title="Manage Bed Types">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">View</label>
                        <div class="flex gap-2">
                            <select id="roomView" class="admin-input flex-1">
                                <option value="">Select View</option>
                            </select>
                            <button type="button" onclick="openManageViewsModal()" class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 text-gray-600" title="Manage Views">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Badge</label>
                        <input type="text" id="roomBadge" class="admin-input" placeholder="e.g., Best Seller">
                    </div>
                </div>
                
                <!-- Image Upload Section -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Room Images (6 images required)</label>
                    <div class="grid grid-cols-3 gap-3" id="imagePreviewContainer">
                        <!-- Image slots will be generated by JavaScript -->
                    </div>
                </div>
                
                <!-- Amenities Section -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amenities</label>
                    <div id="amenitiesContainer" class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3">
                        <!-- Amenity checkboxes will be loaded from database -->
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="roomDescription" class="admin-input" rows="3"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeRoomModal()" class="admin-btn-secondary flex-1">Cancel</button>
                    <button type="submit" class="admin-btn-primary flex-1">
                        <i class="fas fa-save mr-2"></i>Save Room
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Amenity Modal -->
    <div id="amenityModal" class="modal">
        <div class="modal-content" style="max-width: 700px;">
            <div class="flex justify-between items-center mb-4">
                <h3 id="amenityModalTitle" class="text-xl font-semibold">Add New Amenity</h3>
                <button onclick="closeAmenityModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="amenityForm">
                <input type="hidden" id="amenityId">
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <div class="flex gap-2">
                            <select id="amenityCategory" class="admin-input flex-1" required>
                                <option value="">Select Category</option>
                                <?php
                                $categories = $pdo->query("SELECT * FROM amenity_categories WHERE is_active = 1 ORDER BY display_order");
                                while ($cat = $categories->fetch()) {
                                    echo '<option value="' . $cat['id'] . '">' . htmlspecialchars($cat['name']) . '</option>';
                                }
                                ?>
                            </select>
                            <button type="button" onclick="openAmenityCategoryModal()" class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 text-gray-600" title="Manage Categories">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" id="amenityName" class="admin-input" placeholder="e.g., The Sanctuary Spa" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                        <div class="flex items-center gap-2 p-2 bg-gray-50 border border-gray-200 rounded-lg">
                            <i class="fas fa-spa text-[#b89a78]"></i>
                            <span class="text-sm text-gray-500">fa-spa (automatic)</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hours</label>
                        <input type="text" id="amenityHours" class="admin-input" placeholder="e.g., Daily 9:00 AM - 9:00 PM">
                    </div>
                </div>
                <div class="mb-3 col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Images (Upload or URL - 3 images)</label>
                    <div class="grid grid-cols-3 gap-4">
                        <!-- Image 1 -->
                        <div class="border border-gray-200 rounded-lg p-3">
                            <p class="text-xs text-gray-500 mb-2">Image 1 (Main)</p>
                            <input type="file" id="amenityImage1" class="amenity-image-upload w-full text-xs" accept="image/*" data-index="1">
                            <input type="url" id="amenityImageUrl1" class="admin-input mt-2 text-sm" placeholder="Or paste URL...">
                            <div id="previewAmenityImage1" class="mt-2 preview-container"></div>
                        </div>
                        <!-- Image 2 -->
                        <div class="border border-gray-200 rounded-lg p-3">
                            <p class="text-xs text-gray-500 mb-2">Image 2</p>
                            <input type="file" id="amenityImage2" class="amenity-image-upload w-full text-xs" accept="image/*" data-index="2">
                            <input type="url" id="amenityImageUrl2" class="admin-input mt-2 text-sm" placeholder="Or paste URL...">
                            <div id="previewAmenityImage2" class="mt-2 preview-container"></div>
                        </div>
                        <!-- Image 3 -->
                        <div class="border border-gray-200 rounded-lg p-3">
                            <p class="text-xs text-gray-500 mb-2">Image 3</p>
                            <input type="file" id="amenityImage3" class="amenity-image-upload w-full text-xs" accept="image/*" data-index="3">
                            <input type="url" id="amenityImageUrl3" class="admin-input mt-2 text-sm" placeholder="Or paste URL...">
                            <div id="previewAmenityImage3" class="mt-2 preview-container"></div>
                        </div>
                    </div>
                    <!-- Hidden field to store existing images for update -->
                    <input type="hidden" id="existingAmenityImages" value="[]">
                </div>
                <div class="mb-3 col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Features
                        <button type="button" onclick="openAmenityFeatureModal()" class="ml-2 text-xs text-[#b89a78] hover:text-[#8a735b]">+ Manage Features</button>
                    </label>
                    <div class="border border-gray-200 rounded-lg max-h-48 overflow-y-auto p-3">
                        <div id="featuresCheckboxes" class="grid grid-cols-2 gap-2">
                            <!-- Features will be loaded dynamically -->
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                    <input type="text" id="amenityDescription" class="admin-input">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Long Description</label>
                    <textarea id="amenityLongDescription" class="admin-input" rows="3"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeAmenityModal()" class="admin-btn-secondary flex-1">Cancel</button>
                    <button type="submit" class="admin-btn-primary flex-1">
                        <i class="fas fa-save mr-2"></i>Save Amenity
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Room Type Modal -->
    <div id="roomTypeModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="flex justify-between items-center mb-4">
                <h3 id="roomTypeModalTitle" class="text-xl font-semibold">Add New Room Type</h3>
                <button onclick="closeRoomTypeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="roomTypeForm">
                <input type="hidden" id="roomTypeId">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Room Type Name</label>
                    <input type="text" id="roomTypeName" class="admin-input" placeholder="e.g., Deluxe Suite" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="roomTypeDescription" class="admin-input" rows="2" placeholder="Brief description..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                    <input type="number" id="roomTypeOrder" class="admin-input" value="0">
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeRoomTypeModal()" class="admin-btn-secondary flex-1">Cancel</button>
                    <button type="submit" class="admin-btn-primary flex-1">
                        <i class="fas fa-save mr-2"></i>Save Room Type
                    </button>
                </div>
            </form>
            
            <!-- Existing Room Types List -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Existing Room Types</h4>
                <div id="roomTypesList" class="max-h-40 overflow-y-auto">
                    <!-- Room types will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bed Types Management Modal -->
    <div id="bedTypesModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Manage Bed Types</h3>
                <button onclick="closeBedTypesModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="bedTypeForm">
                <div class="flex gap-2 mb-4">
                    <input type="text" id="bedTypeName" class="admin-input flex-1" placeholder="e.g., King, Queen, Twin">
                    <input type="number" id="bedTypeOrder" class="admin-input w-24" placeholder="Order" value="0">
                    <button type="submit" class="admin-btn-primary px-4">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
            <div id="bedTypesList" class="max-h-60 overflow-y-auto border-t border-gray-200 pt-4">
                <!-- Bed types will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Views Management Modal -->
    <div id="viewsModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Manage Views</h3>
                <button onclick="closeViewsModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="viewForm">
                <div class="flex gap-2 mb-4">
                    <input type="text" id="viewName" class="admin-input flex-1" placeholder="e.g., Garden, Pool, City">
                    <input type="number" id="viewOrder" class="admin-input w-24" placeholder="Order" value="0">
                    <button type="submit" class="admin-btn-primary px-4">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
            <div id="viewsList" class="max-h-60 overflow-y-auto border-t border-gray-200 pt-4">
                <!-- Views will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Amenity Category Management Modal -->
    <div id="amenityCategoryModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Manage Amenity Categories</h3>
                <button onclick="closeAmenityCategoryModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="amenityCategoryForm">
                <div class="flex gap-2 mb-4">
                    <input type="text" id="amenityCategoryName" class="admin-input flex-1" placeholder="Category name">
                    <input type="number" id="amenityCategoryOrder" class="admin-input w-24" placeholder="Order" value="0">
                    <button type="submit" class="admin-btn-primary px-4">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
            <div id="amenityCategoriesList" class="max-h-60 overflow-y-auto border-t border-gray-200 pt-4">
                <!-- Categories will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Amenity Feature Management Modal -->
    <div id="amenityFeatureModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Manage Amenity Features</h3>
                <button onclick="closeAmenityFeatureModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="amenityFeatureForm">
                <div class="flex gap-2 mb-4">
                    <input type="text" id="amenityFeatureName" class="admin-input flex-1" placeholder="Feature name">
                    <button type="submit" class="admin-btn-primary px-4">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
            <div id="amenityFeaturesList" class="max-h-60 overflow-y-auto border-t border-gray-200 pt-4">
                <!-- Features will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Event Venue Modal -->
    <div id="eventVenueModal" class="modal">
        <div class="modal-content" style="max-width: 700px;">
            <div class="flex justify-between items-center mb-4">
                <h3 id="eventVenueModalTitle" class="text-xl font-semibold">Add New Venue</h3>
                <button onclick="closeEventVenueModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="eventVenueForm">
                <input type="hidden" id="eventVenueId">
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-3 col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Venue Name</label>
                        <input type="text" id="eventVenueName" class="admin-input" placeholder="e.g., Grand Ballroom" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                        <input type="text" id="eventVenueCapacity" class="admin-input" placeholder="e.g., 200 guests">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                        <input type="text" id="eventVenueSize" class="admin-input" placeholder="e.g., 450 m²">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                    <input type="file" id="eventVenueImage" class="admin-input" accept="image/*">
                    <input type="hidden" id="eventVenueImageUrl" class="admin-input" placeholder="Or paste image URL">
                    <div id="previewEventVenueImage" class="mt-2 preview-container"></div>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                    <textarea id="eventVenueDescription" class="admin-input" rows="2"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Long Description</label>
                    <textarea id="eventVenueLongDescription" class="admin-input" rows="3"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeEventVenueModal()" class="admin-btn-secondary flex-1">Cancel</button>
                    <button type="submit" class="admin-btn-primary flex-1">
                        <i class="fas fa-save mr-2"></i>Save Venue
                    </button>
                </div>
            </form>
        </div>
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

        // Email Modal Functions
        function openEmailModal(bookingId, inquiryId, type) {
            document.getElementById('emailBookingId').value = bookingId || '';
            document.getElementById('emailInquiryId').value = inquiryId || '';
            document.getElementById('emailType').value = type;
            document.getElementById('emailSubject').value = '';
            document.getElementById('emailMessage').value = '';
            document.getElementById('emailModal').classList.add('open');
        }

        function closeEmailModal() {
            document.getElementById('emailModal').classList.remove('open');
        }

        // Load room types from database
        function loadRoomTypesForRoom() {
            const formData = new FormData();
            formData.append('action', 'get_all_room_types');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('roomType');
                    select.innerHTML = data.room_types.map(type => 
                        `<option value="${type.slug}">${type.name}</option>`
                    ).join('');
                }
            });
        }
        
        // Load bed types for room form
        function loadBedTypesForRoom() {
            const formData = new FormData();
            formData.append('action', 'get_bed_types');
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('roomBedType');
                    select.innerHTML = '<option value="">Select Bed Type</option>' + 
                        data.bed_types.map(type => 
                            `<option value="${type.name}">${type.name}</option>`
                        ).join('');
                }
            });
        }
        
        // Load views for room form
        function loadViewsForRoom() {
            const formData = new FormData();
            formData.append('action', 'get_room_views');
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('roomView');
                    select.innerHTML = '<option value="">Select View</option>' + 
                        data.views.map(view => 
                            `<option value="${view.name}">${view.name}</option>`
                        ).join('');
                }
            });
        }
        
        // Bed Types Management
        function openManageBedTypesModal() {
            document.getElementById('bedTypesModal').classList.add('open');
            loadBedTypesList();
        }
        
        function closeBedTypesModal() {
            document.getElementById('bedTypesModal').classList.remove('open');
            document.getElementById('bedTypeForm').reset();
            loadBedTypesForRoom();
        }
        
        function loadBedTypesList() {
            const formData = new FormData();
            formData.append('action', 'get_bed_types');
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('bedTypesList');
                    container.innerHTML = data.bed_types.map(type => `
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <span class="font-medium text-sm">${type.name}</span>
                            <button onclick="deleteBedType(${type.id})" class="text-gray-400 hover:text-red-500">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    `).join('');
                }
            });
        }
        
        document.getElementById('bedTypeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('bedTypeName').value.trim();
            const display_order = document.getElementById('bedTypeOrder').value;
            
            if (!name) {
                alert('Please enter a bed type name');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'add_bed_type');
            formData.append('name', name);
            formData.append('display_order', display_order);
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    document.getElementById('bedTypeForm').reset();
                    document.getElementById('bedTypeOrder').value = '0';
                    loadBedTypesList();
                }
            });
        });
        
        function deleteBedType(id) {
            if (confirm('Are you sure you want to delete this bed type?')) {
                const formData = new FormData();
                formData.append('action', 'delete_bed_type');
                formData.append('id', id);
                
                fetch('api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    loadBedTypesList();
                });
            }
        }
        
        // Views Management
        function openManageViewsModal() {
            document.getElementById('viewsModal').classList.add('open');
            loadViewsList();
        }
        
        function closeViewsModal() {
            document.getElementById('viewsModal').classList.remove('open');
            document.getElementById('viewForm').reset();
            loadViewsForRoom();
        }
        
        function loadViewsList() {
            const formData = new FormData();
            formData.append('action', 'get_room_views');
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('viewsList');
                    container.innerHTML = data.views.map(view => `
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <span class="font-medium text-sm">${view.name}</span>
                            <button onclick="deleteView(${view.id})" class="text-gray-400 hover:text-red-500">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    `).join('');
                }
            });
        }
        
        document.getElementById('viewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('viewName').value.trim();
            const display_order = document.getElementById('viewOrder').value;
            
            if (!name) {
                alert('Please enter a view name');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'add_room_view');
            formData.append('name', name);
            formData.append('display_order', display_order);
            
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    document.getElementById('viewForm').reset();
                    document.getElementById('viewOrder').value = '0';
                    loadViewsList();
                }
            });
        });
        
        function deleteView(id) {
            if (confirm('Are you sure you want to delete this view?')) {
                const formData = new FormData();
                formData.append('action', 'delete_room_view');
                formData.append('id', id);
                
                fetch('api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    loadViewsList();
                });
            }
        }
        
        // Amenity Category Management
        function openAmenityCategoryModal() {
            document.getElementById('amenityCategoryModal').classList.add('open');
            loadAmenityCategoriesList();
        }
        
        function closeAmenityCategoryModal() {
            document.getElementById('amenityCategoryModal').classList.remove('open');
            document.getElementById('amenityCategoryForm').reset();
            // Refresh category dropdown
            loadAmenityCategoriesForForm();
        }
        
        function loadAmenityCategoriesList() {
            const formData = new FormData();
            formData.append('action', 'get_all_amenity_categories');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('amenityCategoriesList');
                    container.innerHTML = data.categories.map(cat => `
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <span class="font-medium text-sm">${cat.name}</span>
                            <button onclick="deleteAmenityCategory(${cat.id})" class="text-gray-400 hover:text-red-500">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    `).join('');
                }
            });
        }
        
        document.getElementById('amenityCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('amenityCategoryName').value.trim();
            const display_order = document.getElementById('amenityCategoryOrder').value;
            
            if (!name) {
                alert('Please enter a category name');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'add_amenity_category');
            formData.append('name', name);
            formData.append('display_order', display_order);
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    document.getElementById('amenityCategoryForm').reset();
                    document.getElementById('amenityCategoryOrder').value = '0';
                    loadAmenityCategoriesList();
                }
            });
        });
        
        function deleteAmenityCategory(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                const formData = new FormData();
                formData.append('action', 'delete_amenity_category');
                formData.append('id', id);
                
                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    loadAmenityCategoriesList();
                });
            }
        }
        
        function loadAmenityCategoriesForForm() {
            const formData = new FormData();
            formData.append('action', 'get_all_amenity_categories');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('amenityCategory');
                    select.innerHTML = '<option value="">Select Category</option>' + 
                        data.categories.map(cat => 
                            `<option value="${cat.id}">${cat.name}</option>`
                        ).join('');
                }
            });
        }
        
        // Amenity Feature Management
        let allAmenityFeatures = [];
        
        function openAmenityFeatureModal() {
            document.getElementById('amenityFeatureModal').classList.add('open');
            loadAmenityFeaturesList();
        }
        
        function closeAmenityFeatureModal() {
            document.getElementById('amenityFeatureModal').classList.remove('open');
            document.getElementById('amenityFeatureForm').reset();
        }
        
        function loadAmenityFeaturesList() {
            const formData = new FormData();
            formData.append('action', 'get_all_amenity_features');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    allAmenityFeatures = data.features || [];
                    const container = document.getElementById('amenityFeaturesList');
                    if (allAmenityFeatures.length === 0) {
                        container.innerHTML = '<p class="text-gray-500 text-sm">No features yet. Add some!</p>';
                    } else {
                        container.innerHTML = allAmenityFeatures.map((feature, index) => `
                            <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                                <span class="font-medium text-sm">${feature}</span>
                                <button onclick="deleteAmenityFeature('${feature}')" class="text-gray-400 hover:text-red-500" title="Delete Feature">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        `).join('');
                    }
                }
            });
        }
        
        function deleteAmenityFeature(feature) {
            if (confirm(`Are you sure you want to delete the feature "${feature}"? This will remove it from all amenities.`)) {
                const formData = new FormData();
                formData.append('action', 'delete_amenity_feature');
                formData.append('feature', feature);
                
                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    loadAmenityFeaturesList();
                    loadAmenityFeaturesForForm(); // Refresh checkboxes too
                });
            }
        }
        
        // ==================== EVENT VENUES MANAGEMENT ====================
        
        function openEventVenueModal(venue = null) {
            if (venue) {
                document.getElementById('eventVenueModalTitle').textContent = 'Edit Venue';
                document.getElementById('eventVenueId').value = venue.id;
                document.getElementById('eventVenueName').value = venue.name || '';
                document.getElementById('eventVenueCapacity').value = venue.capacity || '';
                document.getElementById('eventVenueSize').value = venue.size || '';
                document.getElementById('eventVenueDescription').value = venue.description || '';
                document.getElementById('eventVenueLongDescription').value = venue.long_description || '';
                
                // Show existing image preview
                if (venue.image) {
                    document.getElementById('previewEventVenueImage').innerHTML = `
                        <div class="relative inline-block">
                            <img src="${venue.image}" class="w-32 h-20 object-cover rounded">
                        </div>
                    `;
                }
            } else {
                document.getElementById('eventVenueModalTitle').textContent = 'Add New Venue';
                document.getElementById('eventVenueForm').reset();
                document.getElementById('eventVenueId').value = '';
                document.getElementById('previewEventVenueImage').innerHTML = '';
            }
            document.getElementById('eventVenueModal').classList.add('open');
        }
        
        function closeEventVenueModal() {
            document.getElementById('eventVenueModal').classList.remove('open');
            document.getElementById('eventVenueForm').reset();
        }
        
        // Event Venue Form Submit
        document.getElementById('eventVenueForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            const id = document.getElementById('eventVenueId').value;
            formData.append('action', id ? 'update_event_venue' : 'add_event_venue');
            
            if (id) {
                formData.append('id', id);
            }
            
            formData.append('name', document.getElementById('eventVenueName').value);
            formData.append('capacity', document.getElementById('eventVenueCapacity').value);
            formData.append('size', document.getElementById('eventVenueSize').value);
            formData.append('description', document.getElementById('eventVenueDescription').value);
            formData.append('long_description', document.getElementById('eventVenueLongDescription').value);
            formData.append('image', document.getElementById('eventVenueImageUrl').value);
            
            // Add file if selected
            const imageFile = document.getElementById('eventVenueImage').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    closeEventVenueModal();
                    loadEventVenues();
                }
            });
        });
        
        function loadEventVenues() {
            const formData = new FormData();
            formData.append('action', 'get_all_event_venues');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.getElementById('eventVenuesTableBody');
                    if (tbody) {
                        tbody.innerHTML = data.venues.map(venue => `
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <img src="${venue.image || 'https://via.placeholder.com/50x50'}" class="w-12 h-12 object-cover rounded">
                                        <span class="font-medium">${venue.name}</span>
                                    </div>
                                </td>
                                <td>${venue.capacity || '-'}</td>
                                <td>${venue.size || '-'}</td>
                                <td>${venue.display_order || 0}</td>
                                <td>
                                    <button onclick='openEventVenueModal(${JSON.stringify(venue).replace(/'/g, "'")})' class="text-[#b89a78] hover:text-[#8a735b] mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteEventVenue(${venue.id})" class="text-gray-400 hover:text-red-500">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('');
                    }
                }
            });
        }
        
        function deleteEventVenue(id) {
            if (confirm('Are you sure you want to delete this venue?')) {
                const formData = new FormData();
                formData.append('action', 'delete_event_venue');
                formData.append('id', id);
                
                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    loadEventVenues();
                });
            }
        }
        
        document.getElementById('amenityFeatureForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // For features, we don't add them to database - we just add to the list for selection
            // The features are stored in each amenity's JSON array
            alert('Feature added to the list! You can now select it when adding/editing amenities.');
            document.getElementById('amenityFeatureForm').reset();
            loadAmenityFeaturesList();
        });
        
        function loadAmenityFeaturesForForm(selectedFeatures = []) {
            const formData = new FormData();
            formData.append('action', 'get_all_amenity_features');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    allAmenityFeatures = data.features || [];
                    const container = document.getElementById('featuresCheckboxes');
                    container.innerHTML = allAmenityFeatures.map(feature => `
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                            <input type="checkbox" name="amenityFeatures" value="${feature}" class="w-4 h-4 rounded accent-[#b89a78]" ${selectedFeatures.includes(feature) ? 'checked' : ''}>
                            <span class="text-sm text-gray-700">${feature}</span>
                        </label>
                    `).join('');
                }
            });
        }
        
        // Alias functions for the buttons
        function openManageBedTypes() { openManageBedTypesModal(); }
        function openManageViews() { openManageViewsModal(); }
        
        // Room Modal Functions
        let roomImages = ['', '', '', '', '', ''];
        let uploadedFiles = [null, null, null, null, null, null];
        
        function initImageSlots() {
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = '';
            
            for (let i = 0; i < 6; i++) {
                const slot = document.createElement('div');
                slot.className = 'relative aspect-video bg-gray-100 rounded-lg overflow-hidden border-2 border-dashed border-gray-300 hover:border-[#b89a78] transition-colors cursor-pointer';
                
                if (roomImages[i]) {
                    // Show existing image (URL)
                    slot.innerHTML = `
                        <img src="${roomImages[i]}" class="w-full h-full object-cover">
                        <button type="button" onclick="event.stopPropagation(); removeImage(${i})" class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                } else {
                    // Show upload placeholder
                    slot.innerHTML = `
                        <div class="absolute inset-0 flex flex-col items-center justify-center" id="imageSlot${i}">
                            <i class="fas fa-plus text-gray-400 text-2xl mb-1"></i>
                            <span class="text-xs text-gray-400">Image ${i + 1}</span>
                        </div>
                    `;
                }
                
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.id = `roomImage${i}`;
                fileInput.className = 'hidden';
                fileInput.accept = 'image/*';
                fileInput.onchange = function(event) { handleImageSelect(i, event); };
                slot.appendChild(fileInput);
                slot.onclick = () => document.getElementById(`roomImage${i}`).click();
                container.appendChild(slot);
            }
        }
        
        function handleImageSelect(index, event) {
            const file = event.target.files[0];
            if (file) {
                // Store the file for upload
                uploadedFiles[index] = file;
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    roomImages[index] = e.target.result;
                    initImageSlots();
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeImage(index) {
            roomImages[index] = '';
            uploadedFiles[index] = null;
            initImageSlots();
        }
        
        // Load amenities from database
        function loadAmenitiesForRoom() {
            const formData = new FormData();
            formData.append('action', 'get_all_amenities');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('amenitiesContainer');
                    container.innerHTML = data.amenities.map(amenity => `
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="checkbox" name="roomAmenities" value="${amenity.name}" class="w-4 h-4 rounded accent-[#b89a78]">
                            <span class="text-sm text-gray-700">${amenity.name}</span>
                        </label>
                    `).join('');
                }
            });
        }
        
        function openRoomModal(room = null) {
            // Initialize image slots
            roomImages = ['', '', '', '', '', ''];
            uploadedFiles = [null, null, null, null, null, null];
            initImageSlots();
            
            // Load amenities
            loadAmenitiesForRoom();
            
            // Load room types
            loadRoomTypesForRoom();
            
            // Load bed types and views
            loadBedTypesForRoom();
            loadViewsForRoom();
            
            if (room) {
                document.getElementById('roomModalTitle').textContent = 'Edit Room';
                document.getElementById('roomId').value = room.id;
                document.getElementById('roomType').value = room.room_type || '';
                document.getElementById('roomName').value = room.name || '';
                document.getElementById('roomPrice').value = room.price || '';
                document.getElementById('roomSize').value = room.size || '';
                document.getElementById('roomOccupancy').value = room.occupancy || '';
                document.getElementById('roomBedType').value = room.bed_type || '';
                document.getElementById('roomView').value = room.view || '';
                document.getElementById('roomBadge').value = room.badge || '';
                document.getElementById('roomDescription').value = room.description || '';
                
                // Load amenities as checked
                let amenities = [];
                if (room.amenities) {
                    amenities = typeof room.amenities === 'string' ? JSON.parse(room.amenities) : room.amenities;
                }
                setTimeout(() => {
                    document.querySelectorAll('input[name="roomAmenities"]').forEach(cb => {
                        cb.checked = amenities.includes(cb.value);
                    });
                }, 100);
                
                // Load images
                let images = [];
                if (room.images) {
                    images = typeof room.images === 'string' ? JSON.parse(room.images) : room.images;
                }
                images.forEach((img, idx) => {
                    if (idx < 6 && img) {
                        roomImages[idx] = img;
                        const slot = document.getElementById(`imageSlot${idx}`);
                        if (slot) {
                            slot.innerHTML = `
                                <img src="${img}" class="w-full h-full object-cover">
                                <button type="button" onclick="event.stopPropagation(); removeImage(${idx})" class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            `;
                        }
                    }
                });
                
                // Set selected room type after loading
                setTimeout(() => {
                    const roomTypeSelect = document.getElementById('roomType');
                    if (roomTypeSelect) {
                        roomTypeSelect.value = room.room_type;
                    }
                }, 100);
            } else {
                document.getElementById('roomModalTitle').textContent = 'Add New Room';
                document.getElementById('roomForm').reset();
                document.getElementById('roomId').value = '';
            }
            document.getElementById('roomModal').classList.add('open');
        }

        function closeRoomModal() {
            document.getElementById('roomModal').classList.remove('open');
        }

        // Amenity Modal Functions
        let amenityImages = ['', '', ''];
        let amenityUploadedFiles = [null, null, null];
        
        function initAmenityImagePreviews() {
            for (let i = 1; i <= 3; i++) {
                const fileInput = document.getElementById('amenityImage' + i);
                if (fileInput) {
                    fileInput.onchange = function(event) { handleAmenityImageSelect(i, event); };
                }
                
                const urlInput = document.getElementById('amenityImageUrl' + i);
                if (urlInput) {
                    urlInput.onchange = function() { handleAmenityUrlChange(i); };
                }
            }
        }
        
        function handleAmenityImageSelect(index, event) {
            const file = event.target.files[0];
            if (file) {
                // Store the file for upload
                amenityUploadedFiles[index - 1] = file;
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    amenityImages[index - 1] = e.target.result;
                    showAmenityPreview(index, e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }
        
        function handleAmenityUrlChange(index) {
            const url = document.getElementById('amenityImageUrl' + index).value;
            if (url) {
                amenityImages[index - 1] = url;
                showAmenityPreview(index, url);
            }
        }
        
        function showAmenityPreview(index, src) {
            const container = document.getElementById('previewAmenityImage' + index);
            if (container) {
                container.innerHTML = `
                    <div class="relative">
                        <img src="${src}" class="w-full h-20 object-cover rounded">
                        <button type="button" onclick="removeAmenityImage(${index})" class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            }
        }
        
        function removeAmenityImage(index) {
            amenityImages[index - 1] = '';
            amenityUploadedFiles[index - 1] = null;
            document.getElementById('amenityImage' + index).value = '';
            document.getElementById('amenityImageUrl' + index).value = '';
            document.getElementById('previewAmenityImage' + index).innerHTML = '';
        }
        
        function openAmenityModal(amenity = null) {
            // Reset image arrays
            amenityImages = ['', '', ''];
            amenityUploadedFiles = [null, null, null];
            
            // Clear previews
            for (let i = 1; i <= 3; i++) {
                document.getElementById('previewAmenityImage' + i).innerHTML = '';
            }
            
            // Initialize image preview handlers
            initAmenityImagePreviews();
            
            if (amenity) {
                document.getElementById('amenityModalTitle').textContent = 'Edit Amenity';
                document.getElementById('amenityId').value = amenity.id;
                document.getElementById('amenityCategory').value = amenity.category_id || '';
                document.getElementById('amenityName').value = amenity.name || '';
                document.getElementById('amenityHours').value = amenity.hours || '';
                document.getElementById('amenityDescription').value = amenity.description || '';
                document.getElementById('amenityLongDescription').value = amenity.long_description || '';
                
                // Load features as checked checkboxes
                let features = [];
                if (amenity.features) {
                    features = typeof amenity.features === 'string' ? JSON.parse(amenity.features) : amenity.features;
                }
                loadAmenityFeaturesForForm(features);
                
                // Load gallery images
                let gallery = [];
                if (amenity.gallery) {
                    gallery = typeof amenity.gallery === 'string' ? JSON.parse(amenity.gallery) : amenity.gallery;
                }
                
                // Store existing images for update
                document.getElementById('existingAmenityImages').value = JSON.stringify(gallery);
                
                // Display existing images in previews
                gallery.forEach((img, idx) => {
                    if (idx < 3 && img) {
                        amenityImages[idx] = img;
                        showAmenityPreview(idx + 1, img);
                    }
                });
            } else {
                document.getElementById('amenityModalTitle').textContent = 'Add New Amenity';
                document.getElementById('amenityForm').reset();
                document.getElementById('amenityId').value = '';
                document.getElementById('existingAmenityImages').value = '[]';
                
                // Load empty features checkboxes
                loadAmenityFeaturesForForm([]);
            }
            document.getElementById('amenityModal').classList.add('open');
        }

        function closeAmenityModal() {
            document.getElementById('amenityModal').classList.remove('open');
        }
        
        // Room Type Modal Functions
        function openRoomTypeModal() {
            document.getElementById('roomTypeModal').classList.add('open');
            loadRoomTypesList();
        }
        
        function closeRoomTypeModal() {
            document.getElementById('roomTypeModal').classList.remove('open');
            document.getElementById('roomTypeForm').reset();
            document.getElementById('roomTypeId').value = '';
            document.getElementById('roomTypeModalTitle').textContent = 'Add New Room Type';
        }
        
        function loadRoomTypesList() {
            const formData = new FormData();
            formData.append('action', 'get_all_room_types');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('roomTypesList');
                    container.innerHTML = data.room_types.map(type => `
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <div>
                                <span class="font-medium text-sm">${type.name}</span>
                                <span class="text-xs text-gray-500 ml-2">${type.description || ''}</span>
                            </div>
                            <div>
                                <button onclick="editRoomType(${type.id}, '${type.name}', '${type.description || ''}', ${type.display_order})" class="text-[#b89a78] hover:text-[#8a735b] mr-2">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button onclick="deleteRoomType(${type.id})" class="text-gray-400 hover:text-red-500">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>
                    `).join('');
                }
            });
        }
        
        function editRoomType(id, name, description, displayOrder) {
            document.getElementById('roomTypeId').value = id;
            document.getElementById('roomTypeName').value = name;
            document.getElementById('roomTypeDescription').value = description;
            document.getElementById('roomTypeOrder').value = displayOrder;
            document.getElementById('roomTypeModalTitle').textContent = 'Edit Room Type';
        }
        
        function deleteRoomType(id) {
            if (confirm('Are you sure you want to delete this room type?')) {
                const formData = new FormData();
                formData.append('action', 'delete_room_type');
                formData.append('id', id);
                
                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        loadRoomTypesList();
                        loadRoomTypesForRoom();
                    }
                });
            }
        }
        
        // Room Type Form Submit
        document.getElementById('roomTypeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            const id = document.getElementById('roomTypeId').value;
            formData.append('action', id ? 'update_room_type' : 'add_room_type');
            if (id) {
                formData.append('id', id);
            }
            formData.append('name', document.getElementById('roomTypeName').value);
            formData.append('description', document.getElementById('roomTypeDescription').value);
            formData.append('display_order', document.getElementById('roomTypeOrder').value);

            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    document.getElementById('roomTypeForm').reset();
                    document.getElementById('roomTypeId').value = '';
                    document.getElementById('roomTypeModalTitle').textContent = 'Add New Room Type';
                    loadRoomTypesList();
                    loadRoomTypesForRoom();
                }
            });
        });

        // Room Form Submit
        document.getElementById('roomForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get selected amenities
            const selectedAmenities = [];
            document.querySelectorAll('input[name="roomAmenities"]:checked').forEach(cb => {
                selectedAmenities.push(cb.value);
            });
            
            // Get existing URL images (not base64)
            const urlImages = roomImages.filter(img => img !== '' && (img.startsWith('http') || img.startsWith('uploads/')));
            
            const formData = new FormData();
            formData.append('action', document.getElementById('roomId').value ? 'update_room' : 'add_room');
            if (document.getElementById('roomId').value) {
                formData.append('id', document.getElementById('roomId').value);
            }
            formData.append('room_type', document.getElementById('roomType').value);
            formData.append('name', document.getElementById('roomName').value);
            formData.append('price', document.getElementById('roomPrice').value);
            formData.append('size', document.getElementById('roomSize').value);
            formData.append('occupancy', document.getElementById('roomOccupancy').value);
            formData.append('bed_type', document.getElementById('roomBedType').value);
            formData.append('view', document.getElementById('roomView').value);
            formData.append('badge', document.getElementById('roomBadge').value);
            formData.append('amenities', JSON.stringify(selectedAmenities));
            formData.append('images', JSON.stringify(urlImages));
            formData.append('description', document.getElementById('roomDescription').value);
            
            // Add file uploads
            for (let i = 0; i < uploadedFiles.length; i++) {
                if (uploadedFiles[i]) {
                    formData.append('roomImages[]', uploadedFiles[i]);
                }
            }

            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    closeRoomModal();
                    loadRooms();
                }
            });
        });

        // Amenity Form Submit
        document.getElementById('amenityForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get selected features from checkboxes
            const selectedFeatures = [];
            document.querySelectorAll('input[name="amenityFeatures"]:checked').forEach(cb => {
                selectedFeatures.push(cb.value);
            });
            
            // Get existing URL images
            const existingImages = JSON.parse(document.getElementById('existingAmenityImages').value || '[]');
            const urlImages = [];
            for (let i = 1; i <= 3; i++) {
                const url = document.getElementById('amenityImageUrl' + i).value;
                if (url && !amenityImages[i-1].startsWith('data:')) {
                    urlImages.push(url);
                }
            }
            
            // Filter out base64 images from amenityImages (those are previews, not URLs)
            const finalImages = [];
            for (let i = 0; i < 3; i++) {
                if (amenityImages[i] && amenityImages[i].startsWith('http')) {
                    finalImages.push(amenityImages[i]);
                }
            }
            
            const formData = new FormData();
            formData.append('action', document.getElementById('amenityId').value ? 'update_amenity' : 'add_amenity');
            if (document.getElementById('amenityId').value) {
                formData.append('id', document.getElementById('amenityId').value);
                formData.append('existingImages', JSON.stringify(existingImages));
            }
            formData.append('category_id', document.getElementById('amenityCategory').value);
            formData.append('name', document.getElementById('amenityName').value);
            formData.append('icon', 'fa-spa'); // Automatically set icon to fa-spa
            formData.append('hours', document.getElementById('amenityHours').value);
            formData.append('description', document.getElementById('amenityDescription').value);
            formData.append('long_description', document.getElementById('amenityLongDescription').value);
            formData.append('features', JSON.stringify(selectedFeatures));
            
            // Add URL inputs
            for (let i = 1; i <= 3; i++) {
                formData.append('amenityImageUrl' + i, document.getElementById('amenityImageUrl' + i).value);
            }
            
            // Add file uploads
            for (let i = 1; i <= 3; i++) {
                if (amenityUploadedFiles[i-1]) {
                    formData.append('amenityImage' + i, amenityUploadedFiles[i-1]);
                }
            }

            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    closeAmenityModal();
                    loadAmenities();
                }
            });
        });

        // Email Form Submit
        document.getElementById('emailForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData();
            const type = document.getElementById('emailType').value;
            
            if (type === 'booking') {
                formData.append('action', 'send_booking_email');
                formData.append('booking_id', document.getElementById('emailBookingId').value);
            } else {
                formData.append('action', 'send_inquiry_email');
                formData.append('inquiry_id', document.getElementById('emailInquiryId').value);
            }
            
            formData.append('subject', document.getElementById('emailSubject').value);
            formData.append('message', document.getElementById('emailMessage').value);

            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    closeEmailModal();
                }
            });
        });

        // Load Rooms
        function loadRooms() {
            const formData = new FormData();
            formData.append('action', 'get_all_rooms');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.getElementById('roomsTableBody');
                    if (tbody) {
                        tbody.innerHTML = data.rooms.map(room => `
                            <tr>
                                <td class="font-medium">${room.name}</td>
                                <td>${room.room_type}</td>
                                <td>KSh ${parseInt(room.price).toLocaleString()}</td>
                                <td>${room.size || '-'}</td>
                                <td>${room.occupancy || '-'}</td>
                                <td>${room.view || '-'}</td>
                                <td>
                                    <button onclick='openRoomModal(${JSON.stringify(room)})' class="text-[#b89a78] hover:text-[#8a735b] mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteRoom(${room.id})" class="text-gray-400 hover:text-red-500">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('');
                    }
                }
            });
        }

        // Load Amenities
        function loadAmenities() {
            const formData = new FormData();
            formData.append('action', 'get_all_amenities');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.getElementById('amenitiesTableBody');
                    if (tbody) {
                        tbody.innerHTML = data.amenities.map(amenity => `
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                                            <i class="fas ${amenity.icon || 'fa-concierge-bell'} text-[#b89a78]"></i>
                                        </div>
                                        <span class="font-medium">${amenity.name}</span>
                                    </div>
                                </td>
                                <td>${amenity.category_name || '-'}</td>
                                <td>${amenity.hours || '-'}</td>
                                <td>${amenity.phone || '-'}</td>
                                <td>
                                    <button onclick='openAmenityModal(${JSON.stringify(amenity).replace(/'/g, "'")})' class="text-[#b89a78] hover:text-[#8a735b] mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteAmenity(${amenity.id})" class="text-gray-400 hover:text-red-500">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('');
                    }
                }
            });
        }

        // Load Bookings
        function loadBookings() {
            const formData = new FormData();
            formData.append('action', 'get_all_bookings');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.getElementById('bookingsTableBody');
                    if (tbody) {
                        tbody.innerHTML = data.bookings.map(booking => `
                            <tr>
                                <td class="font-medium">#BK-${String(booking.id).padStart(4, '0')}</td>
                                <td>${booking.guest_name}</td>
                                <td>${booking.guest_email}</td>
                                <td>${booking.room_name || 'N/A'}</td>
                                <td>${booking.check_in}</td>
                                <td>${booking.check_out}</td>
                                <td>
                                    <span class="status-badge ${booking.status}">${booking.status}</span>
                                </td>
                                <td>
                                    <button onclick="updateBookingStatus(${booking.id}, 'confirmed')" class="text-green-600 hover:text-green-800 mr-2" title="Confirm">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="updateBookingStatus(${booking.id}, 'cancelled')" class="text-red-600 hover:text-red-800 mr-2" title="Cancel">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button onclick="openEmailModal(${booking.id}, null, 'booking')" class="text-[#b89a78] hover:text-[#8a735b] mr-2" title="Send Email">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                    <button onclick="deleteBooking(${booking.id})" class="text-gray-400 hover:text-red-500" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('');
                    }
                }
            });
        }

        // Load Event Inquiries
        function loadEventInquiries() {
            const formData = new FormData();
            formData.append('action', 'get_all_event_inquiries');
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.getElementById('inquiriesTableBody');
                    if (tbody) {
                        tbody.innerHTML = data.inquiries.map(inquiry => `
                            <tr>
                                <td class="font-medium">#INQ-${String(inquiry.id).padStart(4, '0')}</td>
                                <td>${inquiry.guest_name}</td>
                                <td>${inquiry.guest_email}</td>
                                <td>${inquiry.event_type}</td>
                                <td>${inquiry.venue_name || 'Not specified'}</td>
                                <td>${inquiry.event_date}</td>
                                <td>${inquiry.guest_count || '-'}</td>
                                <td>
                                    <span class="status-badge ${inquiry.status}">${inquiry.status}</span>
                                </td>
                                <td>
                                    <button onclick="updateInquiryStatus(${inquiry.id}, 'contacted')" class="text-blue-600 hover:text-blue-800 mr-2" title="Mark Contacted">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="updateInquiryStatus(${inquiry.id}, 'confirmed')" class="text-green-600 hover:text-green-800 mr-2" title="Confirm">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <button onclick="openEmailModal(null, ${inquiry.id}, 'inquiry')" class="text-[#b89a78] hover:text-[#8a735b] mr-2" title="Send Email">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                    <button onclick="deleteInquiry(${inquiry.id})" class="text-gray-400 hover:text-red-500" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('');
                    }
                }
            });
        }

        // Delete Room
        function deleteRoom(id) {
            if (confirm('Are you sure you want to delete this room?')) {
                const formData = new FormData();
                formData.append('action', 'delete_room');
                formData.append('id', id);
                
                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) loadRooms();
                });
            }
        }

        // Delete Amenity
        function deleteAmenity(id) {
            if (confirm('Are you sure you want to delete this amenity?')) {
                const formData = new FormData();
                formData.append('action', 'delete_amenity');
                formData.append('id', id);
                
                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) loadAmenities();
                });
            }
        }

        // Update Booking Status
        function updateBookingStatus(id, status) {
            const formData = new FormData();
            formData.append('action', 'update_booking_status');
            formData.append('id', id);
            formData.append('status', status);
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) loadBookings();
            });
        }

        // Delete Booking
        function deleteBooking(id) {
            if (confirm('Are you sure you want to delete this booking?')) {
                const formData = new FormData();
                formData.append('action', 'delete_booking');
                formData.append('id', id);
                
                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) loadBookings();
                });
            }
        }

        // Update Inquiry Status
        function updateInquiryStatus(id, status) {
            const formData = new FormData();
            formData.append('action', 'update_inquiry_status');
            formData.append('id', id);
            formData.append('status', status);
            
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) loadEventInquiries();
            });
        }

        // Delete Inquiry
        function deleteInquiry(id) {
            if (confirm('Are you sure you want to delete this inquiry?')) {
                const formData = new FormData();
                formData.append('action', 'delete_inquiry');
                formData.append('id', id);
                
                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) loadEventInquiries();
                });
            }
        }

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            const currentTab = '<?php echo $current_tab; ?>';
            if (currentTab === 'rooms') loadRooms();
            if (currentTab === 'amenities') loadAmenities();
            if (currentTab === 'bookings') loadBookings();
            if (currentTab === 'events') {
                loadEventVenues();
                loadEventInquiries();
            }
        });
    </script>
</body>
</html>
