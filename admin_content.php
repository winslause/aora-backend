<?php
// Get dashboard stats
$stmt = $pdo->query("SELECT 
    (SELECT COUNT(*) FROM bookings) as total_bookings,
    (SELECT COUNT(*) FROM bookings WHERE status = 'pending') as pending_bookings,
    (SELECT COUNT(*) FROM bookings WHERE status = 'confirmed') as confirmed_bookings,
    (SELECT COALESCE(SUM(total_price), 0) FROM bookings WHERE status = 'confirmed') as total_revenue,
    (SELECT COUNT(*) FROM rooms) as total_rooms,
    (SELECT COUNT(*) FROM amenities) as total_amenities,
    (SELECT COUNT(*) FROM event_inquiries) as total_inquiries,
    (SELECT COUNT(*) FROM event_inquiries WHERE status = 'pending') as pending_inquiries
");
$stats = $stmt->fetch();

// Get popular menu items (from menu_items table or simulated)
try {
    $popularMenu = $pdo->query("SELECT mi.*, mc.name as category_name 
        FROM menu_items mi 
        LEFT JOIN menu_categories mc ON mi.category_id = mc.id 
        ORDER BY mi.display_order ASC LIMIT 5")->fetchAll();
} catch (Exception $e) {
    $popularMenu = [];
}

// Get recent bookings
$recentBookings = $pdo->query("SELECT b.*, r.name as room_name FROM bookings b 
    LEFT JOIN rooms r ON b.room_id = r.id 
    ORDER BY b.created_at DESC LIMIT 5")->fetchAll();

// Get recent inquiries
$recentInquiries = $pdo->query("SELECT e.*, v.name as venue_name FROM event_inquiries e 
    LEFT JOIN event_venues v ON e.venue_id = v.id 
    ORDER BY e.created_at DESC LIMIT 5")->fetchAll();

// Get all rooms
$rooms = $pdo->query("SELECT * FROM rooms ORDER BY price ASC")->fetchAll();

// Get all amenities
$amenities = $pdo->query("SELECT a.*, ac.name as category_name FROM amenities a 
    LEFT JOIN amenity_categories ac ON a.category_id = ac.id 
    ORDER BY ac.display_order ASC, a.display_order ASC")->fetchAll();

// Get all bookings
$bookings = $pdo->query("SELECT b.*, r.name as room_name, r.id as room_id, r.room_type, r.price as room_price FROM bookings b 
    LEFT JOIN rooms r ON b.room_id = r.id 
    ORDER BY b.created_at DESC")->fetchAll();

// Get all event inquiries
$inquiries = $pdo->query("SELECT e.*, v.name as venue_name FROM event_inquiries e 
    LEFT JOIN event_venues v ON e.venue_id = v.id 
    ORDER BY e.created_at DESC")->fetchAll();

// Get all contact messages
try {
    $contactMessages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
} catch (Exception $e) {
    $contactMessages = [];
}
?>

<?php if ($current_tab == 'dashboard'): ?>
<!-- Dashboard Content -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card admin-card p-6">
        <div class="flex items-center justify-between mb-2">
            <div class="w-12 h-12 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-check text-2xl text-[#b89a78]"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['total_bookings']; ?></h3>
        <p class="text-sm text-gray-500">Total Bookings</p>
    </div>

    <div class="stat-card admin-card p-6">
        <div class="flex items-center justify-between mb-2">
            <div class="w-12 h-12 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                <i class="fas fa-utensils text-2xl text-[#b89a78]"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">Popular Menu Items</h3>
        <div class="mt-2 text-sm text-gray-600">
            <?php if (empty($popularMenu)): ?>
                <p class="text-gray-500">No menu items yet</p>
            <?php else: ?>
                <ul class="space-y-1">
                    <?php foreach ($popularMenu as $item): ?>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-[#b89a78] text-xs"></i>
                            <?php echo htmlspecialchars($item['name']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div class="stat-card admin-card p-6">
        <div class="flex items-center justify-between mb-2">
            <div class="w-12 h-12 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                <i class="fas fa-bed text-2xl text-[#b89a78]"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['total_rooms']; ?></h3>
        <p class="text-sm text-gray-500">Total Rooms</p>
    </div>

    <div class="stat-card admin-card p-6">
        <div class="flex items-center justify-between mb-2">
            <div class="w-12 h-12 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                <i class="fas fa-envelope text-2xl text-[#b89a78]"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['pending_inquiries']; ?></h3>
        <p class="text-sm text-gray-500">Pending Inquiries</p>
    </div>
</div>

<!-- Recent Bookings & Inquiries -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">Recent Bookings</h3>
            <a href="?tab=bookings" class="text-sm text-[#b89a78] hover:underline">View all</a>
        </div>
        <div class="space-y-4">
            <?php if (empty($recentBookings)): ?>
                <p class="text-gray-500 text-sm">No bookings yet</p>
            <?php else: ?>
                <?php foreach ($recentBookings as $booking): ?>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($booking['guest_name']); ?>&background=b89a78&color=fff" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-medium text-sm"><?php echo htmlspecialchars($booking['guest_name']); ?></p>
                            <p class="text-xs text-gray-500"><?php echo htmlspecialchars($booking['room_name'] ?? $booking['room_id'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <span class="status-badge <?php echo $booking['status']; ?>"><?php echo ucfirst($booking['status']); ?></span>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">Recent Event Inquiries</h3>
            <a href="?tab=events" class="text-sm text-[#b89a78] hover:underline">View all</a>
        </div>
        <div class="space-y-4">
            <?php if (empty($recentInquiries)): ?>
                <p class="text-gray-500 text-sm">No inquiries yet</p>
            <?php else: ?>
                <?php foreach ($recentInquiries as $inquiry): ?>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#b89a78]/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-[#b89a78]"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm"><?php echo htmlspecialchars($inquiry['guest_name']); ?></p>
                            <p class="text-xs text-gray-500"><?php echo htmlspecialchars($inquiry['event_type']); ?></p>
                        </div>
                    </div>
                    <span class="status-badge <?php echo $inquiry['status']; ?>"><?php echo ucfirst($inquiry['status']); ?></span>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="admin-card p-6">
    <h3 class="font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="?tab=rooms" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:border-[#b89a78] transition-colors">
            <i class="fas fa-plus-circle text-2xl text-[#b89a78] mb-2"></i>
            <span class="text-sm font-medium">Add Room</span>
        </a>
        <a href="?tab=amenities" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:border-[#b89a78] transition-colors">
            <i class="fas fa-plus-circle text-2xl text-[#b89a78] mb-2"></i>
            <span class="text-sm font-medium">Add Amenity</span>
        </a>
        <a href="?tab=bookings" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:border-[#b89a78] transition-colors">
            <i class="fas fa-calendar-check text-2xl text-[#b89a78] mb-2"></i>
            <span class="text-sm font-medium">View Bookings</span>
        </a>
        <a href="?tab=events" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:border-[#b89a78] transition-colors">
            <i class="fas fa-envelope text-2xl text-[#b89a78] mb-2"></i>
            <span class="text-sm font-medium">View Inquiries</span>
        </a>
    </div>
</div>

<?php elseif ($current_tab == 'rooms'): ?>
<!-- Room Management Content -->
<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Room Management</h3>
        <button onclick="openRoomModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Room
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Occupancy</th>
                    <th>View</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="roomsTableBody">
                <?php foreach ($rooms as $room): 
                    $amenities_arr = json_decode($room['amenities'], true);
                ?>
                <tr>
                    <td class="font-medium"><?php echo htmlspecialchars($room['name']); ?></td>
                    <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                    <td>KSh <?php echo number_format($room['price']); ?></td>
                    <td><?php echo htmlspecialchars($room['size'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($room['occupancy'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($room['view'] ?? '-'); ?></td>
                    <td>
                        <button onclick='openRoomModal(<?php echo json_encode($room); ?>)' class="text-[#b89a78] hover:text-[#8a735b] mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteRoom(<?php echo $room['id']; ?>)" class="text-gray-400 hover:text-red-500">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="roomsPagination"></div>
    </div>
</div>

<?php elseif ($current_tab == 'amenities'): ?>
<!-- Amenities Management Content -->
<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Amenities Management</h3>
        <button onclick="openAmenityModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Amenity
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Amenity</th>
                    <th>Category</th>
                    <th>Hours</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="amenitiesTableBody">
                <?php foreach ($amenities as $amenity): 
                    $features = json_decode($amenity['features'], true);
                ?>
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#fef7f0] rounded-lg flex items-center justify-center">
                                <i class="fas <?php echo htmlspecialchars($amenity['icon'] ?? 'fa-concierge-bell'); ?> text-[#b89a78]"></i>
                            </div>
                            <span class="font-medium"><?php echo htmlspecialchars($amenity['name']); ?></span>
                        </div>
                    </td>
                    <td><?php echo htmlspecialchars($amenity['category_name'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($amenity['hours'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($amenity['phone'] ?? '-'); ?></td>
                    <td>
                        <button onclick='openAmenityModal(<?php echo htmlspecialchars(json_encode($amenity)); ?>)' class="text-[#b89a78] hover:text-[#8a735b] mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteAmenity(<?php echo $amenity['id']; ?>)" class="text-gray-400 hover:text-red-500">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="amenitiesPagination"></div>
    </div>
</div>

<?php elseif ($current_tab == 'bookings'): ?>
<!-- Bookings Management Content -->
<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Bookings Management</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Guest Name</th>
                    <th>Email</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="bookingsTableBody">
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td class="font-medium">#BK-<?php echo str_pad($booking['id'], 4, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo htmlspecialchars($booking['guest_name']); ?></td>
                    <td><?php echo htmlspecialchars($booking['guest_email']); ?></td>
                    <td><?php echo htmlspecialchars(($booking['room_name'] ?? '') && trim($booking['room_name']) ? $booking['room_name'] : (isset($booking['room_id']) ? 'Room ' . $booking['room_id'] : 'N/A')); ?></td>
                    <td><?php echo $booking['check_in']; ?></td>
                    <td><?php echo $booking['check_out']; ?></td>
                    <td><?php 
                        $totalCost = 0;
                        if (!empty($booking['check_in']) && !empty($booking['check_out'])) {
                            $checkIn = new DateTime($booking['check_in']);
                            $checkOut = new DateTime($booking['check_out']);
                            $nights = $checkOut->diff($checkIn)->days;
                            $nights = max($nights, 1);
                            $roomPrice = $booking['room_price'] ?? 0;
                            $totalCost = ($booking['total_price'] ?? 0) > 0 ? $booking['total_price'] : ($roomPrice * $nights);
                        }
                        echo 'KSh ' . number_format($totalCost);
                    ?></td>
                    <td>
                        <span class="status-badge <?php echo $booking['status']; ?>"><?php echo ucfirst($booking['status']); ?></span>
                    </td>
                    <td>
                        <button onclick="updateBookingStatus(<?php echo $booking['id']; ?>, 'confirmed')" class="text-green-600 hover:text-green-800 mr-2" title="Confirm">
                            <i class="fas fa-check"></i>
                        </button>
                        <button onclick="updateBookingStatus(<?php echo $booking['id']; ?>, 'cancelled')" class="text-red-600 hover:text-red-800 mr-2" title="Cancel">
                            <i class="fas fa-times"></i>
                        </button>
                        <button onclick="openEmailModal(<?php echo $booking['id']; ?>, null, 'booking')" class="text-[#b89a78] hover:text-[#8a735b] mr-2" title="Send Email">
                            <i class="fas fa-envelope"></i>
                        </button>
                        <button onclick="deleteBooking(<?php echo $booking['id']; ?>)" class="text-gray-400 hover:text-red-500" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="bookingsPagination"></div>
    </div>
</div>

<?php elseif ($current_tab == 'events'): ?>
<!-- Event Management Content -->

<!-- Event Venues Section -->
<div class="admin-card p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Event Venues</h3>
        <button onclick="openEventVenueModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Venue
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Venue</th>
                    <th>Capacity</th>
                    <th>Size</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="eventVenuesTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Event Enquiries Section -->
<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Event Enquiries</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Inquiry ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Event Type</th>
                    <th>Venue</th>
                    <th>Date</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="inquiriesTableBody">
                <?php foreach ($inquiries as $inquiry): ?>
                <tr>
                    <td class="font-medium">#INQ-<?php echo str_pad($inquiry['id'], 4, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo htmlspecialchars($inquiry['guest_name']); ?></td>
                    <td><?php echo htmlspecialchars($inquiry['guest_email']); ?></td>
                    <td><?php echo htmlspecialchars($inquiry['event_type']); ?></td>
                    <td><?php echo htmlspecialchars($inquiry['venue_name'] ?? 'Not specified'); ?></td>
                    <td><?php echo $inquiry['event_date']; ?></td>
                    <td><?php echo htmlspecialchars($inquiry['guest_count'] ?? '-'); ?></td>
                    <td>
                        <span class="status-badge <?php echo $inquiry['status']; ?>"><?php echo ucfirst($inquiry['status']); ?></span>
                    </td>
                    <td>
                        <button onclick="updateInquiryStatus(<?php echo $inquiry['id']; ?>, 'contacted')" class="text-blue-600 hover:text-blue-800 mr-2" title="Mark Contacted">
                            <i class="fas fa-check"></i>
                        </button>
                        <button onclick="updateInquiryStatus(<?php echo $inquiry['id']; ?>, 'confirmed')" class="text-green-600 hover:text-green-800 mr-2" title="Confirm">
                            <i class="fas fa-check-circle"></i>
                        </button>
                        <button onclick="openEmailModal(null, <?php echo $inquiry['id']; ?>, 'inquiry')" class="text-[#b89a78] hover:text-[#8a735b] mr-2" title="Send Email">
                            <i class="fas fa-envelope"></i>
                        </button>
                        <button onclick="deleteInquiry(<?php echo $inquiry['id']; ?>)" class="text-gray-400 hover:text-red-500" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="inquiriesPagination"></div>
    </div>
</div>

<?php elseif ($current_tab == 'gallery'): ?>
<!-- Gallery Management Content -->
<div class="admin-card p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Manage Albums</h3>
        <button onclick="openGalleryAlbumModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Album
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Album</th>
                    <th>Photos</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="galleryAlbumsTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Gallery Images Section -->
<div class="admin-card p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Manage Images</h3>
        <button onclick="openGalleryImageModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Image
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Album</th>
                    <th>Caption</th>
                    <th>Category</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="galleryImagesTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
        <div id="galleryImagesPagination"></div>
    </div>
</div>

<!-- Gallery Video Section -->
<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Manage Video</h3>
        <button onclick="openGalleryVideoModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Video
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Video</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="galleryVideosTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<?php elseif ($current_tab == 'offers'): ?>
<!-- Offers Management Content -->
<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Special Offers</h3>
        <button onclick="openOfferModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Offer
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Offer</th>
                    <th>Subtitle</th>
                    <th>Price</th>
                    <th>Images</th>
                    <th>Inclusions</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="offersTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
        <div id="offersPagination"></div>
    </div>
</div>

<?php elseif ($current_tab == 'menu'): ?>
<!-- Menu Management Content -->
<div class="admin-card p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Menu Categories</h3>
        <button onclick="openMenuCategoryModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Category
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="menuCategoriesTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
        <div id="menuCategoriesPagination"></div>
    </div>
</div>

<!-- Our Signature Dishes Section -->
<div class="admin-card p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Our Signature Dishes</h3>
        <button onclick="openMenuItemModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Signature Dish
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="signatureDishesTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
        <div id="signatureDishesPagination"></div>
    </div>
</div>

<!-- Culinary Offerings - Sample Menus Section -->
<div class="admin-card p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Culinary Offerings - Sample Menus</h3>
        <button onclick="openSampleMenuModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Sample Menu
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="sampleMenusTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
        <div id="sampleMenusPagination"></div>
    </div>
</div>

<!-- Table Types (Special Dining Experiences) Section -->
<div class="admin-card p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Special Dining Experiences (Table Types)</h3>
        <button onclick="openTableTypeModal()" class="admin-btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Dining Experience
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Max People</th>
                    <th>Price</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableTypesTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
        <div id="tableTypesPagination"></div>
    </div>
</div>

<!-- Table Reservations Section -->
<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Table Reservations</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Guest Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Guests</th>
                    <th>Table</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="restaurantReservationsTableBody">
                <!-- Loaded via JavaScript -->
            </tbody>
        </table>
        <div id="restaurantReservationsPagination"></div>
    </div>
</div>

<?php elseif ($current_tab == 'contact'): ?>
<!-- Contact Messages Management Content -->
<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Contact Us Messages</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contactMessages)): ?>
                <tr>
                    <td colspan="9" class="text-center py-8 text-gray-500">No contact messages yet</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($contactMessages as $message): ?>
                <tr>
                    <td class="font-medium">#MSG-<?php echo str_pad($message['id'], 4, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                    <td><?php echo htmlspecialchars($message['phone'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($message['subject']); ?></td>
                    <td class="max-w-xs">
                        <div class="truncate" title="<?php echo htmlspecialchars($message['message']); ?>">
                            <?php echo htmlspecialchars(substr($message['message'], 0, 50)); ?>...
                        </div>
                    </td>
                    <td>
                        <span class="status-badge <?php echo $message['status']; ?>"><?php echo ucfirst($message['status']); ?></span>
                    </td>
                    <td><?php echo date('M j, Y', strtotime($message['created_at'])); ?></td>
                    <td>
                        <button onclick='viewMessage(<?php echo json_encode($message); ?>)' class="text-[#b89a78] hover:text-[#8a735b] mr-2" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="updateMessageStatus(<?php echo $message['id']; ?>, 'read')" class="text-blue-600 hover:text-blue-800 mr-2" title="Mark as Read">
                            <i class="fas fa-check"></i>
                        </button>
                        <button onclick="replyToMessage(<?php echo $message['id']; ?>, '<?php echo htmlspecialchars($message['email']); ?>')" class="text-green-600 hover:text-green-800 mr-2" title="Reply">
                            <i class="fas fa-reply"></i>
                        </button>
                        <button onclick="deleteMessage(<?php echo $message['id']; ?>)" class="text-gray-400 hover:text-red-500" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Message View Modal -->
<div id="viewMessageModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Message Details</h3>
            <button onclick="closeViewMessageModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="messageDetails">
            <!-- Message details will be loaded here -->
        </div>
    </div>
</div>

<?php elseif ($current_tab == 'settings'): ?>
<!-- Settings Content -->
<div class="admin-card p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">Change Password</h3>
    </div>
    <form id="passwordForm" class="max-w-md">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
            <input type="password" id="currentPassword" class="admin-input" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
            <input type="password" id="newPassword" class="admin-input" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
            <input type="password" id="confirmPassword" class="admin-input" required>
        </div>
        <button type="submit" class="admin-btn-primary">
            <i class="fas fa-save mr-2"></i>Update Password
        </button>
    </form>
</div>

<div class="admin-card p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-800">General Settings</h3>
    </div>
    <form id="settingsForm" class="max-w-md">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
            <input type="text" id="siteName" class="admin-input" value="Aora">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
            <input type="email" id="contactEmail" class="admin-input" value="info@aora.com">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
            <input type="text" id="contactPhone" class="admin-input" value="+254 700 000 000">
        </div>
        <button type="submit" class="admin-btn-primary">
            <i class="fas fa-save mr-2"></i>Save Settings
        </button>
    </form>
</div>

<?php endif; ?>
