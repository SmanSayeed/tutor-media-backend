// SSB Leather Style Image Gallery with Mobile Slider
class SSBImageGallery {
    constructor() {
        this.modal = document.getElementById('image-modal');
        this.modalImage = document.getElementById('modal-image');
        this.closeModalBtn = document.getElementById('close-modal');
        this.slideItems = document.querySelectorAll('.slide-item');
        
        // Mobile slider elements
        this.mobileTrack = document.getElementById('mobile-slider-track');
        this.mobilePrevBtn = document.getElementById('mobile-prev');
        this.mobileNextBtn = document.getElementById('mobile-next');
        this.mobileDots = document.querySelectorAll('.mobile-dot');
        
        this.currentSlide = 0;
        this.totalSlides = 5; // Total number of images
        this.visibleSlides = 2; // Number of slides visible at once on mobile
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.setupHoverEffects();
        this.setupMobileSlider();
    }
    
    setupEventListeners() {
        // Click to open modal (for both desktop and mobile)
        this.slideItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                const img = item.querySelector('img');
                this.openModal(img.src, img.alt);
            });
        });
        
        // Close modal events
        if (this.closeModalBtn) {
            this.closeModalBtn.addEventListener('click', () => this.closeModal());
        }
        
        if (this.modal) {
            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) {
                    this.closeModal();
                }
            });
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal && !this.modal.classList.contains('hidden')) {
                this.closeModal();
            }
        });
    }
    
    setupMobileSlider() {
        if (!this.mobileTrack) return;
        
        // Mobile navigation buttons
        if (this.mobilePrevBtn) {
            this.mobilePrevBtn.addEventListener('click', () => this.prevSlide());
        }
        
        if (this.mobileNextBtn) {
            this.mobileNextBtn.addEventListener('click', () => this.nextSlide());
        }
        
        // Mobile dots navigation
        this.mobileDots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });
        
        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;
        
        this.mobileTrack.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        this.mobileTrack.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            this.handleSwipe(startX, endX);
        });
        
        // Initialize mobile slider
        this.updateMobileSlider();
    }
    
    setupHoverEffects() {
        // Only apply hover effects on desktop
        if (window.innerWidth >= 1024) {
            this.slideItems.forEach((item, index) => {
                const img = item.querySelector('img');
                const overlay = item.querySelector('.absolute.inset-0');
                
                item.addEventListener('mouseenter', () => {
                    img.classList.remove('brightness-75');
                    img.classList.add('brightness-100', 'scale-105');
                    
                    if (overlay) {
                        overlay.classList.add('bg-opacity-0');
                        overlay.classList.remove('bg-opacity-20');
                    }
                    
                    // Dim other images
                    this.slideItems.forEach((otherItem, otherIndex) => {
                        if (otherIndex !== index) {
                            const otherImg = otherItem.querySelector('img');
                            const otherOverlay = otherItem.querySelector('.absolute.inset-0');
                            otherImg.classList.remove('brightness-75');
                            otherImg.classList.add('brightness-50');
                            if (otherOverlay) {
                                otherOverlay.classList.add('bg-opacity-40');
                                otherOverlay.classList.remove('bg-opacity-20');
                            }
                        }
                    });
                });
                
                item.addEventListener('mouseleave', () => {
                    // Reset all images to default state
                    this.slideItems.forEach((allItem) => {
                        const allImg = allItem.querySelector('img');
                        const allOverlay = allItem.querySelector('.absolute.inset-0');
                        allImg.classList.remove('brightness-50', 'brightness-100', 'scale-105');
                        allImg.classList.add('brightness-75');
                        if (allOverlay) {
                            allOverlay.classList.remove('bg-opacity-0', 'bg-opacity-40');
                            allOverlay.classList.add('bg-opacity-20');
                        }
                    });
                });
            });
        }
    }
    
    handleSwipe(startX, endX) {
        const threshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                this.nextSlide();
            } else {
                this.prevSlide();
            }
        }
    }
    
    updateMobileSlider() {
        if (!this.mobileTrack) return;
        
        // Calculate slide width (50% minus half the gap)
        const slideWidth = 50; // 50% for 2 slides visible
        const translateX = -this.currentSlide * slideWidth;
        this.mobileTrack.style.transform = `translateX(${translateX}%)`;
        
        // Update dots
        this.mobileDots.forEach((dot, index) => {
            if (index === this.currentSlide) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-gray-800');
            } else {
                dot.classList.remove('bg-gray-800');
                dot.classList.add('bg-gray-300');
            }
        });
        
        // Update button states
        if (this.mobilePrevBtn) {
            this.mobilePrevBtn.style.opacity = this.currentSlide === 0 ? '0.5' : '1';
            this.mobilePrevBtn.style.pointerEvents = this.currentSlide === 0 ? 'none' : 'auto';
        }
        
        if (this.mobileNextBtn) {
            const maxSlide = this.totalSlides - this.visibleSlides;
            this.mobileNextBtn.style.opacity = this.currentSlide >= maxSlide ? '0.5' : '1';
            this.mobileNextBtn.style.pointerEvents = this.currentSlide >= maxSlide ? 'none' : 'auto';
        }
    }
    
    goToSlide(slideIndex) {
        const maxSlide = this.totalSlides - this.visibleSlides;
        if (slideIndex >= 0 && slideIndex <= maxSlide) {
            this.currentSlide = slideIndex;
            this.updateMobileSlider();
        }
    }
    
    nextSlide() {
        const maxSlide = this.totalSlides - this.visibleSlides;
        if (this.currentSlide < maxSlide) {
            this.currentSlide++;
            this.updateMobileSlider();
        }
    }
    
    prevSlide() {
        if (this.currentSlide > 0) {
            this.currentSlide--;
            this.updateMobileSlider();
        }
    }
    
    openModal(imageSrc, imageAlt) {
        if (this.modal && this.modalImage) {
            this.modalImage.src = imageSrc;
            this.modalImage.alt = imageAlt;
            this.modal.classList.remove('hidden');
            this.modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }
    
    closeModal() {
        if (this.modal) {
            this.modal.classList.add('hidden');
            this.modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }
    
    // Public method to update images dynamically
    updateGallery(images) {
        this.slideItems.forEach((item, index) => {
            if (images[index]) {
                const img = item.querySelector('img');
                const label = item.querySelector('.bg-white.bg-opacity-90');
                
                if (img) {
                    img.src = images[index].src;
                    img.alt = images[index].alt || `Product Image ${index + 1}`;
                }
                
                if (label && images[index].label) {
                    label.textContent = images[index].label;
                }
            }
        });
    }
    
    // Method to add loading states
    setLoading(isLoading) {
        this.slideItems.forEach(item => {
            const img = item.querySelector('img');
            if (isLoading) {
                item.classList.add('animate-pulse');
                img.classList.add('opacity-50');
            } else {
                item.classList.remove('animate-pulse');
                img.classList.remove('opacity-50');
            }
        });
    }
}

// Initialize gallery when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const galleryElement = document.querySelector('#product-slider');
    if (galleryElement) {
        window.ssbImageGallery = new SSBImageGallery();
    }
});

// Export for use in other scripts
window.SSBImageGallery = SSBImageGallery;