<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora - Contact Us</title>
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
        
        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInUp {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes scaleIn {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
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
        
        .reveal-scale {
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .reveal-scale.active {
            opacity: 1;
            transform: scale(1);
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
        
        /* Contact form styles */
        .contact-input {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(184, 154, 120, 0.3);
            padding: 0.75rem 0;
            transition: all 0.3s ease;
            width: 100%;
            font-family: 'Montserrat', sans-serif;
        }
        
        .contact-input:focus {
            outline: none;
            border-bottom-color: #b89a78;
        }
        
        .contact-input::placeholder {
            color: rgba(139, 115, 85, 0.4);
            font-size: 0.9rem;
            font-weight: 300;
        }
        
        .contact-textarea {
            background: transparent;
            border: 1px solid rgba(184, 154, 120, 0.3);
            padding: 1rem;
            transition: all 0.3s ease;
            width: 100%;
            font-family: 'Montserrat', sans-serif;
        }
        
        .contact-textarea:focus {
            outline: none;
            border-color: #b89a78;
        }
        
        .submit-btn {
            background: #b89a78;
            color: white;
            padding: 1rem 2rem;
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
            letter-spacing: 0.1em;
        }
        
        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .submit-btn:hover::before {
            left: 100%;
        }
        
        .submit-btn:hover {
            background: #8a735b;
        }
        
        /* Contact info items */
        .contact-info-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem 0;
            border-bottom: 1px dashed rgba(184, 154, 120, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-info-item:last-child {
            border-bottom: none;
        }
        
        .contact-info-item:hover {
            transform: translateX(10px);
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(184, 154, 120, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .contact-info-item:hover .contact-icon {
            background: rgba(184, 154, 120, 0.3);
            transform: scale(1.1);
        }
        
        .contact-icon i {
            color: #b89a78;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .contact-info-item:hover .contact-icon i {
            color: #5c4a38;
        }
        
        /* Map container */
        .map-container {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(184, 154, 120, 0.3);
        }
        
        .map-container::before {
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
        
        /* FAQ Accordion */
        .faq-item {
            border-bottom: 1px dashed rgba(184, 154, 120, 0.3);
        }
        
        .faq-question {
            padding: 1.5rem 0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .faq-question:hover {
            padding-left: 10px;
            color: #b89a78;
        }
        
        .faq-question i {
            transition: transform 0.3s ease;
        }
        
        .faq-question.active i {
            transform: rotate(45deg);
        }
        
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
            padding: 0 1rem 0 0;
            color: #6b5d51;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .faq-answer.show {
            max-height: 200px;
            padding-bottom: 1.5rem;
        }
        
        /* Social media icons */
        .social-icon {
            width: 50px;
            height: 50px;
            border: 1px solid rgba(184, 154, 120, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: #b89a78;
            border-color: #b89a78;
            transform: translateY(-5px);
        }
        
        .social-icon:hover i {
            color: white;
        }
        
        .social-icon i {
            color: #b89a78;
            transition: all 0.3s ease;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .contact-info-item {
                padding: 1rem 0;
            }
            
            .faq-answer.show {
                max-height: 300px;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#fcf8f3]">
    <main class="relative">
        <!-- ===== HERO SECTION ===== -->
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <!-- Background Image - Resort Entrance/Welcome Area -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                     alt="Aora Resort Entrance" 
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
                    <span class="block reveal-left" style="transition-delay: 0.2s;">Get in</span>
                    <span class="block reveal-right text-[#b89a78]" style="transition-delay: 0.4s;">Touch</span>
                </h1>
                
                <!-- Decorative Element -->
                <div class="relative flex justify-center items-center gap-4 mb-12">
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                    <i class="fas fa-phone-alt text-[#b89a78] text-xl"></i>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></div>
                </div>
                
                <!-- Subheading -->
                <p class="font-['Cormorant_Garamond'] text-2xl md:text-3xl text-white/90 max-w-2xl mx-auto italic leading-relaxed reveal" style="transition-delay: 0.6s;">
                    "We're here to make your stay unforgettable. Reach out anytime."
                </p>
                
                <!-- Scroll Indicator -->
                <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex flex-col items-center gap-2">
                    <span class="text-white/60 text-xs uppercase tracking-widest">Connect</span>
                    <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                        <div class="w-1 h-2 bg-white/60 rounded-full mt-2 animate-bounce"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CONTACT INFORMATION SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Reach Us</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Contact Information</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- Contact Info Grid -->
                <div class="grid lg:grid-cols-3 gap-12">
                    
                    <!-- Left Column - Address & Phone -->
                    <div class="reveal-left" style="transition-delay: 0.1s;">
                        <div class="space-y-6">
                            <!-- Address -->
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-pin"></i>
                                </div>
                                <div>
                                    <p class="text-[#8a735b] text-xs uppercase tracking-wider mb-1">Visit Us</p>
                                    <p class="text-[#2c3e4a] font-['Cormorant_Garamond'] text-xl">109 Karura Road, Gigiri</p>
                                    <p class="text-[#6b5d51]">Nairobi, Kenya 00100</p>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[#8a735b] text-xs uppercase tracking-wider mb-1">Call Us</p>
                                    <p class="text-[#2c3e4a] font-['Cormorant_Garamond'] text-xl">+254 (0) 20 123 4567</p>
                                    <p class="text-[#6b5d51]">+254 (0) 722 123 456</p>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-[#8a735b] text-xs uppercase tracking-wider mb-1">Email Us</p>
                                    <p class="text-[#2c3e4a] font-['Cormorant_Garamond'] text-xl">concierge@aora.kenya</p>
                                    <p class="text-[#6b5d51]">reservations@aora.kenya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Middle Column - Hours & Social -->
                    <div class="reveal" style="transition-delay: 0.2s;">
                        <div class="space-y-6">
                            <!-- Hours -->
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-[#8a735b] text-xs uppercase tracking-wider mb-1">Front Desk</p>
                                    <p class="text-[#2c3e4a] font-['Cormorant_Garamond'] text-xl">24 hours / 7 days</p>
                                    <p class="text-[#6b5d51]">Always here for you</p>
                                </div>
                            </div>
                            
                            <!-- Check-in/out -->
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <p class="text-[#8a735b] text-xs uppercase tracking-wider mb-1">Check-in / Check-out</p>
                                    <p class="text-[#2c3e4a] font-['Cormorant_Garamond'] text-xl">2:00 PM / 12:00 PM</p>
                                    <p class="text-[#6b5d51]">Early arrival? Ask us about luggage storage</p>
                                </div>
                            </div>
                            
                            <!-- Social Media -->
                            <div class="pt-6">
                                <p class="text-[#8a735b] text-xs uppercase tracking-wider mb-4">Follow Us</p>
                                <div class="flex gap-4">
                                    <a href="#" class="social-icon">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" class="social-icon">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="social-icon">
                                        <i class="fab fa-x-twitter"></i>
                                    </a>
                                    <a href="#" class="social-icon">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Quick Contact Note -->
                    <div class="reveal-right" style="transition-delay: 0.3s;">
                        <div class="bg-[#f4ede5] p-8 h-full flex flex-col justify-center">
                            <i class="fas fa-quote-right text-[#b89a78] text-4xl mb-4 opacity-50"></i>
                            <p class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a] italic mb-4">
                                "We believe the best conversations happen face to face. But a phone call or email is just as welcome."
                            </p>
                            <p class="text-[#8a735b] text-sm">— The Aora Concierge Team</p>
                            
                            <!-- Live Chat / WhatsApp Button -->
                            <div class="mt-8">
                                <a href="#" class="inline-flex items-center gap-3 px-6 py-3 bg-[#b89a78] text-white hover:bg-[#8a735b] transition-all duration-300">
                                    <i class="fab fa-whatsapp"></i>
                                    <span class="text-sm uppercase tracking-wider">WhatsApp Us</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CONTACT FORM & MAP SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#f4ede5] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <div class="grid lg:grid-cols-2 gap-16">
                    
                    <!-- Left Column - Contact Form -->
                    <div class="reveal-left">
                        <h2 class="font-['Cormorant_Garamond'] text-3xl md:text-4xl text-[#2c3e4a] mb-3">Send Us a Message</h2>
                        <div class="w-16 h-px bg-[#b89a78] mb-8"></div>
                        
                        <form id="contactForm" class="space-y-8" onsubmit="handleSubmit(event)">
                            <!-- Name Field -->
                            <div>
                                <input type="text" class="contact-input" placeholder="Your Full Name *" required>
                            </div>
                            
                            <!-- Email Field -->
                            <div>
                                <input type="email" class="contact-input" placeholder="Email Address *" required>
                            </div>
                            
                            <!-- Phone Field -->
                            <div>
                                <input type="tel" class="contact-input" placeholder="Phone Number (optional)">
                            </div>
                            
                            <!-- Subject Field -->
                            <div>
                                <input type="text" class="contact-input" placeholder="Subject *" required>
                            </div>
                            
                            <!-- Message Field -->
                            <div>
                                <textarea rows="5" class="contact-textarea" placeholder="Your Message *" required></textarea>
                            </div>
                            
                            <!-- Submit Button -->
                            <div>
                                <button type="submit" class="submit-btn w-full md:w-auto px-12">
                                    Send Message
                                </button>
                            </div>
                            
                            <!-- Form Note -->
                            <p class="text-[#8a735b] text-xs">
                                * Required fields. We'll respond within 2 hours.
                            </p>
                        </form>
                    </div>
                    
                    <!-- Right Column - Map -->
                    <div class="reveal-right">
                        <h2 class="font-['Cormorant_Garamond'] text-3xl md:text-4xl text-[#2c3e4a] mb-3">Find Us Here</h2>
                        <div class="w-16 h-px bg-[#b89a78] mb-8"></div>
                        
                        <div class="map-container">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.789123456789!2d36.802847!3d-1.234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMTQnMDQuNCJTIDM2wrA0OCcxMC4yIkU!5e0!3m2!1sen!2ske!4v1234567890123!5m2!1sen!2ske"
                                width="100%" 
                                height="400" 
                                style="border:0; filter: grayscale(30%) sepia(10%) hue-rotate(350deg) brightness(1.05);" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>
                        
                        <!-- Map Note -->
                        <p class="text-[#8a735b] text-xs mt-4 text-center">
                            <i class="fas fa-location-dot mr-1"></i> 
                            109 Karura Road, Gigiri, Nairobi, Kenya
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FAQ SECTION ===== -->
        <section class="relative py-24 px-6 bg-[#fcf8f3] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-4xl mx-auto relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16 reveal">
                    <span class="text-[#8a735b] font-['Montserrat'] text-xs uppercase tracking-[0.35em] font-light">Common Questions</span>
                    <h2 class="font-['Cormorant_Garamond'] text-4xl md:text-5xl text-[#2c3e4a] mt-4 mb-6 font-light">Frequently Asked</h2>
                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto"></div>
                </div>
                
                <!-- FAQ Accordion -->
                <div class="space-y-4 reveal-scale">
                    
                    <!-- FAQ 1 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a]">What time is check-in and check-out?</span>
                            <i class="fas fa-plus text-[#b89a78]"></i>
                        </div>
                        <div class="faq-answer">
                            Check-in is from 2:00 PM and check-out is until 12:00 PM. Early check-in and late check-out can be arranged subject to availability. Please contact our front desk in advance.
                        </div>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a]">Do you offer airport transfers?</span>
                            <i class="fas fa-plus text-[#b89a78]"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, we offer luxury airport transfers to and from Jomo Kenyatta International Airport. Please provide your flight details at least 24 hours in advance to arrange pickup.
                        </div>
                    </div>
                    
                    <!-- FAQ 3 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a]">Is there free WiFi throughout the property?</span>
                            <i class="fas fa-plus text-[#b89a78]"></i>
                        </div>
                        <div class="faq-answer">
                            Absolutely! Complimentary high-speed WiFi is available in all guest rooms, public areas, and meeting spaces. You'll receive login details upon check-in.
                        </div>
                    </div>
                    
                    <!-- FAQ 4 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a]">What dining options are available?</span>
                            <i class="fas fa-plus text-[#b89a78]"></i>
                        </div>
                        <div class="faq-answer">
                            Aora features a signature restaurant serving modern Kenyan cuisine, a poolside bar with light meals, and 24-hour in-room dining. Our Chef's Table experience is available by reservation.
                        </div>
                    </div>
                    
                    <!-- FAQ 5 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a]">Do you accommodate dietary restrictions?</span>
                            <i class="fas fa-plus text-[#b89a78]"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, our culinary team is happy to accommodate vegetarian, vegan, gluten-free, and other dietary requirements. Please inform us at least 24 hours in advance.
                        </div>
                    </div>
                    
                    <!-- FAQ 6 -->
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="font-['Cormorant_Garamond'] text-xl text-[#2c3e4a]">What is your cancellation policy?</span>
                            <i class="fas fa-plus text-[#b89a78]"></i>
                        </div>
                        <div class="faq-answer">
                            Cancellations made 48 hours prior to arrival receive a full refund. Within 48 hours, the first night's charge applies. Special packages may have different terms.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CONNECT SECTION ===== -->
        <section class="relative py-20 px-6 bg-[#2c3e4a] overflow-hidden">
            <!-- Simple Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-px bg-[#b89a78]/20"></div>
            </div>
            
            <div class="max-w-4xl mx-auto relative z-10 text-center">
                <!-- Decorative Line -->
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#b89a78] to-transparent mx-auto mb-8"></div>
                
                <h2 class="font-['Cormorant_Garamond'] text-3xl md:text-4xl text-white mb-6">Stay Connected with Aora</h2>
                
                <p class="text-white/70 text-lg mb-10 max-w-2xl mx-auto">
                    Subscribe to our newsletter for exclusive offers, event invitations, and stories from the heart of Kenya.
                </p>
                
                <!-- Newsletter Form -->
                <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto" onsubmit="handleNewsletter(event)">
                    <input type="email" placeholder="Your email address" class="flex-1 px-6 py-4 bg-white/10 border border-white/20 text-white placeholder:text-white/50 focus:outline-none focus:border-[#b89a78] transition-colors" required>
                    <button type="submit" class="px-8 py-4 bg-[#b89a78] text-white hover:bg-[#8a735b] transition-colors uppercase tracking-wider text-sm">
                        Subscribe
                    </button>
                </form>
                
                <p class="text-white/40 text-xs mt-6">
                    We respect your privacy. Unsubscribe at any time.
                </p>
            </div>
        </section>

        <!-- ===== SIMPLE FOOTER (Minimal) ===== -->
        <section class="py-8 px-6 bg-[#1a2a32]">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-white/40 text-xs">
                    © 2025 Aora Resort & Restaurant. All rights reserved.
                </p>
                
                <div class="flex gap-6 text-white/30 text-xs">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Careers</a>
                </div>
            </div>
        </section>
    </main>

    <script>
        // FAQ Toggle Function
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('i');
            
            // Toggle answer visibility
            answer.classList.toggle('show');
            
            // Toggle icon
            if (icon.classList.contains('fa-plus')) {
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-plus');
            }
            
            // Toggle active class
            element.classList.toggle('active');
        }
        
        // Form Submit Handler
        function handleSubmit(event) {
            event.preventDefault();
            alert('Thank you for your message! Our team will respond within 2 hours.');
            event.target.reset();
        }
        
        // Newsletter Submit Handler
        function handleNewsletter(event) {
            event.preventDefault();
            alert('Thank you for subscribing to our newsletter!');
            event.target.reset();
        }
        
        // Reveal on scroll
        function reveal() {
            const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
            
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