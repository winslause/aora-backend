<!-- Footer Section - Unique Framed Design with Background Image -->
<footer class="relative py-16 px-6 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="African sunset landscape" 
             class="w-full h-full object-cover">
        <!-- Very light overlay to soften but not hide -->
        <div class="absolute inset-0 bg-black/10"></div>
    </div>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Light Green Shading Container - Wraps all content with equal empty space around -->
        <!-- Using very light green with low opacity to let background show through -->
        <div class="bg-[#e8f3e9]/70 backdrop-blur-[2px] p-8 md:p-12 lg:p-16 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.3)] border border-white/50">
            
            <!-- Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
                
                <!-- Column 1 - Logo & About -->
                <div class="space-y-5">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="logo1.png" alt="Aora45 Resort" class="h-16 w-auto" onerror="this.src='https://placehold.co/200x80/e8f3e9/1e2f3a?text=Aora45'">
                        <div class="ml-3">
                            <h2 class="font-['Playfair_Display'] text-2xl font-bold text-[#1e3a2f]">Aora45</h2>
                            <div class="w-10 h-0.5 bg-gradient-to-r from-[#8fb89a] to-transparent"></div>
                            <p class="text-[#1e3a2f]/80 text-[0.6rem] tracking-wider mt-0.5">RESORT & RESTAURANT</p>
                        </div>
                    </div>
                    
                    <p class="text-[#1e3a2f] text-sm leading-relaxed">
                        Where Kenyan hospitality meets timeless elegance in the heart of Nairobi.
                    </p>
                    
                    <!-- Awards Badge - Minimal -->
                    <div class="flex items-center gap-2">
                        <i class="fas fa-award text-[#8fb89a]"></i>
                        <span class="text-xs text-[#1e3a2f]">Africa's Leading Resort 2026</span>
                    </div>
                    
                    <!-- Admin Login Link -->
                    <button onclick="openLoginModal()" class="mt-4 flex items-center gap-2 text-xs text-[#1e3a2f] hover:text-[#8fb89a] transition-colors">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin Login</span>
                    </button>
                </div>

                <!-- Column 2 - Contact Information -->
                <div class="space-y-5">
                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#1e3a2f] border-b border-[#8fb89a]/30 pb-2">Reach Us</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#8fb89a]/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-pin text-[#1e3a2f] text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[#1e3a2f] text-xs font-medium uppercase tracking-wider">Visit</p>
                                <p class="text-[#1e3a2f] text-sm">109 Karura Road, Gigiri<br>Nairobi, Kenya 00100</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#8fb89a]/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt text-[#1e3a2f] text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[#1e3a2f] text-xs font-medium uppercase tracking-wider">Call</p>
                                <p class="text-[#1e3a2f] text-sm">+254 (0) 20 123 4567</p>
                                <p class="text-[#1e3a2f] text-sm">+254 (0) 722 123 456</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#8fb89a]/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-[#1e3a2f] text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[#1e3a2f] text-xs font-medium uppercase tracking-wider">Email</p>
                                <p class="text-[#1e3a2f] text-sm">info@aora45.com</p>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3 - Quick Links -->
                <div class="space-y-5">
                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#1e3a2f] border-b border-[#8fb89a]/30 pb-2">Explore</h3>
                    
                    <ul class="space-y-3">
                        <li>
                            <a href="about.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>About Aora45</span>
                            </a>
                        </li>
                        <li>
                            <a href="rooms.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Rooms & Suites</span>
                            </a>
                        </li>
                        <li>
                            <a href="restaurant.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Dining Experiences</span>
                            </a>
                        </li>
                        <li>
                            <a href="amenities.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Spa & Wellness</span>
                            </a>
                        </li>
                        <li>
                            <a href="events.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Events & Weddings</span>
                            </a>
                        </li>
                        <li>
                            <a href="gallery.php" class="group flex items-center gap-2 text-[#1e3a2f] hover:text-[#8fb89a] transition-colors duration-300">
                                <i class="fas fa-chevron-right text-xs text-[#8fb89a] group-hover:translate-x-1 transition-transform"></i>
                                <span>Gallery</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4 - Newsletter & Social -->
                <div class="space-y-5">
                    <h3 class="font-['Cormorant_Garamond'] text-xl text-[#1e3a2f] border-b border-[#8fb89a]/30 pb-2">Stay Connected</h3>
                    
                    <!-- Newsletter Form -->
                    <div class="space-y-3">
                        <p class="text-[#1e3a2f] text-sm">Subscribe to receive exclusive offers and stories.</p>
                        
                        <form class="relative">
                            <input type="email" 
                                   placeholder="Your email address" 
                                   class="w-full px-5 py-3 pr-24 bg-white/70 border border-[#8fb89a]/30 rounded-full text-[#1e3a2f] placeholder:text-[#1e3a2f]/50 focus:outline-none focus:ring-2 focus:ring-[#8fb89a]/50 text-sm backdrop-blur-sm">
                            <button type="submit" 
                                    class="absolute right-1 top-1 bottom-1 px-5 bg-gradient-to-r from-[#8fb89a] to-[#6f9a7a] text-white text-xs uppercase tracking-wider rounded-full hover:from-[#7fa88a] hover:to-[#5f8a6a] transition-all duration-300">
                                Join
                            </button>
                        </form>
                        
                        <p class="text-[10px] text-[#1e3a2f]/70">
                            By subscribing, you agree to our Privacy Policy.
                        </p>
                    </div>
                    
                    <!-- Social Media Icons -->
                    <div class="pt-4">
                        <h4 class="text-xs uppercase tracking-wider text-[#1e3a2f] mb-3">Follow Us</h4>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 rounded-full bg-[#8fb89a]/20 hover:bg-[#8fb89a] flex items-center justify-center transition-all duration-300 group backdrop-blur-sm">
                                <i class="fab fa-instagram text-[#1e3a2f] group-hover:text-white transition-colors"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-[#8fb89a]/20 hover:bg-[#8fb89a] flex items-center justify-center transition-all duration-300 group backdrop-blur-sm">
                                <i class="fab fa-facebook-f text-[#1e3a2f] group-hover:text-white transition-colors"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-[#8fb89a]/20 hover:bg-[#8fb89a] flex items-center justify-center transition-all duration-300 group backdrop-blur-sm">
                                <i class="fab fa-x-twitter text-[#1e3a2f] group-hover:text-white transition-colors"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-[#8fb89a]/20 hover:bg-[#8fb89a] flex items-center justify-center transition-all duration-300 group backdrop-blur-sm">
                                <i class="fab fa-pinterest-p text-[#1e3a2f] group-hover:text-white transition-colors"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer - Legal & Credits -->
            <div class="mt-12 pt-6 border-t border-[#8fb89a]/30 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex flex-wrap gap-5 text-xs text-[#1e3a2f]">
                    <a href="#" class="hover:text-[#8fb89a] transition-colors">Privacy Policy</a>
                    <span class="text-[#8fb89a]/30">|</span>
                    <a href="#" class="hover:text-[#8fb89a] transition-colors">Terms of Service</a>
                    <span class="text-[#8fb89a]/30">|</span>
                    <a href="#" class="hover:text-[#8fb89a] transition-colors">Careers</a>
                    <span class="text-[#8fb89a]/30">|</span>
                    <a href="#" class="hover:text-[#8fb89a] transition-colors">Sitemap</a>
                </div>
                
                <p class="text-xs text-[#1e3a2f]">
                    © 2025 Aora45 Resort & Restaurant. All rights reserved.
                </p>
            </div>
        </div>
        
        <!-- Equal empty space around is created by padding on the light green container -->
        <!-- The container has p-8 md:p-12 lg:p-16 which creates equal space on all sides -->
        
        <!-- Decorative Element - Floating Accent -->
        <div class="absolute -bottom-6 -right-6 w-32 h-32 border border-white/20 rounded-full pointer-events-none"></div>
        <div class="absolute -top-6 -left-6 w-32 h-32 border border-white/20 rounded-full pointer-events-none"></div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 z-[100] hidden">
        <!-- Modal Overlay -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeLoginModal()"></div>
        
        <!-- Modal Content -->
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="auth-modal bg-white rounded-3xl shadow-2xl w-full max-w-md relative overflow-hidden" style="animation: modalSlideIn 0.3s ease;">
                <!-- Close Button -->
                <button onclick="closeLoginModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-[#e8f3e9] hover:bg-[#d0e8d5] flex items-center justify-center transition-colors z-10">
                    <i class="fas fa-times text-[#1e3a2f]"></i>
                </button>
                
                <!-- Logo Area -->
                <div class="text-center pt-8 pb-4 px-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#8fb89a] to-[#6f9a7a] rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                        <span class="font-['Playfair_Display'] text-2xl font-bold text-white">A</span>
                    </div>
                    <h2 class="font-['Playfair_Display'] text-2xl text-[#1e3a2f]">Aora Admin</h2>
                    <p class="text-xs text-[#1e3a2f]/60 tracking-wider">LUXURY RESORT</p>
                </div>
                
                <!-- Login Section -->
                <div id="loginSection" class="px-6 pb-6">
                    <!-- Error message -->
                    <div id="loginError" class="hidden bg-red-50 border border-red-200 rounded-xl p-3 mb-4 text-red-700 text-sm flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Invalid email or password.</span>
                    </div>
                    
                    <form id="loginForm" onsubmit="handleLogin(event)">
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-[#1e3a2f] mb-2">Email Address</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#8fb89a]"></i>
                                <input type="email" id="loginEmail" placeholder="admin@aora.com" 
                                    class="w-full pl-11 pr-4 py-3 bg-[#e8f3e9]/50 border border-[#8fb89a]/30 rounded-xl text-[#1e3a2f] placeholder:text-[#1e3a2f]/40 focus:outline-none focus:ring-2 focus:ring-[#8fb89a]/50 transition-all" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-[#1e3a2f] mb-2">Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#8fb89a]"></i>
                                <input type="password" id="loginPassword" placeholder="••••••••" 
                                    class="w-full pl-11 pr-12 py-3 bg-[#e8f3e9]/50 border border-[#8fb89a]/30 rounded-xl text-[#1e3a2f] placeholder:text-[#1e3a2f]/40 focus:outline-none focus:ring-2 focus:ring-[#8fb89a]/50 transition-all" required>
                                <i class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-[#8fb89a]/60 cursor-pointer hover:text-[#8fb89a]" onclick="toggleLoginPassword()"></i>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mb-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 rounded accent-[#8fb89a]">
                                <span class="text-xs text-[#1e3a2f]/70">Remember me</span>
                            </label>
                            <button type="button" onclick="showResetSection()" class="text-xs text-[#8fb89a] hover:text-[#6f9a7a] font-medium">Forgot password?</button>
                        </div>
                        
                        <button type="submit" id="loginBtn" class="w-full py-3 bg-gradient-to-r from-[#8fb89a] to-[#6f9a7a] text-white font-semibold rounded-xl hover:from-[#7fa88a] hover:to-[#5f8a6a] transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </button>
                    </form>
                    
                    <p class="text-center text-xs text-[#1e3a2f]/50 mt-4">
                        Demo: admin@aora.com / admin123
                    </p>
                </div>
                
                <!-- Reset Password Section (hidden by default) -->
                <div id="resetSection" class="hidden px-6 pb-6">
                    <!-- Success message -->
                    <div id="resetSuccess" class="hidden bg-green-50 border border-green-200 rounded-xl p-3 mb-4 text-green-700 text-sm flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>Reset link sent to your email.</span>
                    </div>
                    
                    <!-- Error message -->
                    <div id="resetError" class="hidden bg-red-50 border border-red-200 rounded-xl p-3 mb-4 text-red-700 text-sm flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Email not found.</span>
                    </div>
                    
                    <form id="resetForm" onsubmit="handleReset(event)">
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-[#1e3a2f] mb-2">Email Address</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#8fb89a]"></i>
                                <input type="email" id="resetEmail" placeholder="admin@aora.com" 
                                    class="w-full pl-11 pr-4 py-3 bg-[#e8f3e9]/50 border border-[#8fb89a]/30 rounded-xl text-[#1e3a2f] placeholder:text-[#1e3a2f]/40 focus:outline-none focus:ring-2 focus:ring-[#8fb89a]/50 transition-all" required>
                            </div>
                        </div>
                        
                        <button type="submit" id="resetBtn" class="w-full py-3 bg-gradient-to-r from-[#8fb89a] to-[#6f9a7a] text-white font-semibold rounded-xl hover:from-[#7fa88a] hover:to-[#5f8a6a] transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
                        </button>
                    </form>
                    
                    <button onclick="showLoginSection()" class="w-full mt-4 py-2 text-sm text-[#1e3a2f]/60 hover:text-[#8fb89a] transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Sign In
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles for Footer -->
    <style>
        /* Light green container with very low opacity to let background show through */
        .bg-\[\#e8f3e9\]\/70 {
            background-color: rgba(232, 243, 233, 0.7);
            backdrop-filter: blur(2px);
        }
        
        /* Smooth hover effects */
        .group:hover i.fa-chevron-right {
            transform: translateX(4px);
        }
        
        /* Newsletter button hover */
        button:hover {
            filter: brightness(1.05);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .grid {
                gap: 2rem;
            }
            
            .bg-\[\#e8f3e9\]\/70 {
                padding: 1.5rem;
            }
        }
        
        /* Ensure text is readable against light background */
        .text-\[\#1e3a2f\] {
            color: #1e3a2f;
        }
        
        /* Custom border color */
        .border-\[\#8fb89a\]\/30 {
            border-color: rgba(143, 184, 154, 0.3);
        }
        
        /* Background image visibility */
        .absolute.inset-0.z-0 img {
            filter: brightness(1.1) saturate(1.05);
        }
        
        /* Modal Animations */
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        .auth-modal {
            max-height: 90vh;
            overflow-y: auto;
        }
        
        /* Loading state for buttons */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 16px;
            height: 16px;
            margin: -8px 0 0 -8px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Shake animation for errors */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.5s ease;
        }
    </style>
    
    <!-- Login Modal JavaScript -->
    <script>
        // Open Login Modal
        function openLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Focus on email field
            setTimeout(() => {
                document.getElementById('loginEmail').focus();
            }, 100);
        }
        
        // Close Login Modal
        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
            document.body.style.overflow = '';
            // Reset forms
            resetModal();
        }
        
        // Reset modal to initial state
        function resetModal() {
            document.getElementById('loginSection').classList.remove('hidden');
            document.getElementById('resetSection').classList.add('hidden');
            document.getElementById('loginError').classList.add('hidden');
            document.getElementById('resetSuccess').classList.add('hidden');
            document.getElementById('resetError').classList.add('hidden');
            document.getElementById('loginEmail').value = '';
            document.getElementById('loginPassword').value = '';
            document.getElementById('resetEmail').value = '';
        }
        
        // Toggle password visibility
        function toggleLoginPassword() {
            const passwordInput = document.getElementById('loginPassword');
            const toggleIcon = document.querySelector('#loginPassword + i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Show Reset Password Section
        function showResetSection() {
            document.getElementById('loginSection').classList.add('hidden');
            document.getElementById('resetSection').classList.remove('hidden');
            document.getElementById('resetSuccess').classList.add('hidden');
            document.getElementById('resetError').classList.add('hidden');
            document.getElementById('resetEmail').value = '';
        }
        
        // Show Login Section
        function showLoginSection() {
            document.getElementById('loginSection').classList.remove('hidden');
            document.getElementById('resetSection').classList.add('hidden');
            document.getElementById('resetSuccess').classList.add('hidden');
            document.getElementById('resetError').classList.add('hidden');
        }
        
        // Handle Login
        function handleLogin(event) {
            event.preventDefault();
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const loginBtn = document.getElementById('loginBtn');
            const errorMsg = document.getElementById('loginError');
            const modal = document.querySelector('.auth-modal');
            
            // Demo validation
            if (email === 'admin@aora.com' && password === 'admin123') {
                // Show loading state
                loginBtn.classList.add('btn-loading');
                
                // Simulate API call
                setTimeout(() => {
                    loginBtn.classList.remove('btn-loading');
                    // Redirect to admin dashboard
                    window.location.href = 'admin.php';
                }, 1000);
            } else {
                // Show error message
                errorMsg.classList.remove('hidden');
                
                // Shake animation
                modal.classList.add('shake');
                setTimeout(() => {
                    modal.classList.remove('shake');
                }, 500);
            }
        }
        
        // Handle Reset Password
        function handleReset(event) {
            event.preventDefault();
            
            const email = document.getElementById('resetEmail').value;
            const resetBtn = document.getElementById('resetBtn');
            const successMsg = document.getElementById('resetSuccess');
            const errorMsg = document.getElementById('resetError');
            
            // Hide both messages initially
            successMsg.classList.add('hidden');
            errorMsg.classList.add('hidden');
            
            // Show loading state
            resetBtn.classList.add('btn-loading');
            
            // Simulate API call
            setTimeout(() => {
                resetBtn.classList.remove('btn-loading');
                
                // Demo validation
                if (email === 'admin@aora.com') {
                    successMsg.classList.remove('hidden');
                    document.getElementById('resetEmail').value = '';
                    
                    // Auto hide success after 5 seconds
                    setTimeout(() => {
                        successMsg.classList.add('hidden');
                    }, 5000);
                } else {
                    errorMsg.classList.remove('hidden');
                }
            }, 1000);
        }
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLoginModal();
            }
        });
        
        // Handle Enter key in forms
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (!document.getElementById('resetSection').classList.contains('hidden')) {
                    handleReset(e);
                } else if (!document.getElementById('loginSection').classList.contains('hidden')) {
                    handleLogin(e);
                }
            }
        });
    </script>
</footer>
</body>
</html>
