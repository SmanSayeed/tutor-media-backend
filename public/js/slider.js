// Universal Horizontal Slider for Both Desktop & Mobile
class UniversalImageSlider {
    constructor() {
        this.modal = document.getElementById('image-modal');
        this.modalImage = document.getElementById('modal-image');
        this.closeModalBtn = document.getElementById('close-modal');
        this.slideItems = document.querySelectorAll('.slide-item');
        
        // Universal slider elements
        this.sliderTrack = document.getElementById('slider-track');
        this.prevBtn = document.getElementById('slider-prev');
        this.nextBtn = document.getElementById('slider-next');
        this.dots = document.querySelectorAll('.slider-dot');
        
        this.currentSlide = 0;
        this.totalSlides = 6; // Total number of images
        this.isDesktop = window.innerWidth >= 1024;
        this.visibleSlides = this.isDesktop ? 5 : 1; // Desktop shows 5, mobile shows 1
        this.autoPlayInterval = null;
        this.autoPlayDelay = 4000;
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.setupHoverEffects();
        this.setupSlider();
        this.startAutoPlay();
        this.handleResize();
    }
    
    setupEventListeners() {
        // Click to open modal
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
            if (e.key === 'ArrowLeft') this.prevSlide();
            if (e.key === 'ArrowRight') this.nextSlide();
        });
    }
    
    setupSlider() {
        if (!this.sliderTrack) return;
        
        // Navigation buttons
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => {
                this.prevSlide();
                this.restartAutoPlay();
            });
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => {
                this.nextSlide();
                this.restartAutoPlay();
            });
        }
        
        // Dots navigation
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                this.goToSlide(index);
                this.restartAutoPlay();
            });
        });
        
        // Touch/swipe support
        let startX = 0;
        let endX = 0;
        
        this.sliderTrack.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            this.stopAutoPlay();
        });
        
        this.sliderTrack.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            this.handleSwipe(startX, endX);
            this.restartAutoPlay();
        });
        
        // Mouse drag support for desktop
        let isDragging = false;
        let dragStartX = 0;
        
        this.sliderTrack.addEventListener('mousedown', (e) => {
            isDragging = true;
            dragStartX = e.clientX;
            this.sliderTrack.style.cursor = 'grabbing';
            this.stopAutoPlay();
        });
        
        this.sliderTrack.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
        });
        
        this.sliderTrack.addEventListener('mouseup', (e) => {
            if (!isDragging) return;
            isDragging = false;
            this.sliderTrack.style.cursor = 'grab';
            this.handleSwipe(dragStartX, e.clientX);
            this.restartAutoPlay();
        });
        
        this.sliderTrack.addEventListener('mouseleave', () => {
            isDragging = false;
            this.sliderTrack.style.cursor = 'grab';
        });
        
        // Pause auto-play on hover
        this.sliderTrack.addEventListener('mouseenter', () => this.stopAutoPlay());
        this.sliderTrack.addEventListener('mouseleave', () => this.startAutoPlay());
        
        // Initialize slider
        this.updateSlider();
    }
    
    setupHoverEffects() {
        // Enhanced hover effects
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
                
                // Only dim others on desktop
                if (this.isDesktop) {
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
                }
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
    
    handleResize() {
        window.addEventListener('resize', () => {
            const wasDesktop = this.isDesktop;
            this.isDesktop = window.innerWidth >= 1024;
            this.visibleSlides = this.isDesktop ? 5 : 1;
            
            // Reset slide position if switching between mobile/desktop
            if (wasDesktop !== this.isDesktop) {
                this.currentSlide = 0;
                this.updateSlider();
            }
        });
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
    
    updateSlider() {
        if (!this.sliderTrack) return;
        
        // Calculate slide width based on screen size
        if (this.isDesktop) {
            // Desktop: Use percentage for 5 slides
            const slideWidth = 20; // 20% for 5 slides visible (100% / 5)
            const translateX = -this.currentSlide * slideWidth;
            this.sliderTrack.style.transform = `translateX(${translateX}%)`;
        } else {
            // Mobile: Use pixel calculation to account for gaps properly
            const slideElement = this.slideItems[0];
            if (slideElement) {
                const slideWidth = slideElement.offsetWidth;
                const gap = 12; // 0.75rem = 12px gap
                const translateX = -this.currentSlide * (slideWidth + gap);
                this.sliderTrack.style.transform = `translateX(${translateX}px)`;
            }
        }
        
        // Update dots
        this.dots.forEach((dot, index) => {
            if (index === this.currentSlide) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-gray-800');
            } else {
                dot.classList.remove('bg-gray-800');
                dot.classList.add('bg-gray-300');
            }
        });
        
        // Update button states
        const maxSlide = this.totalSlides - this.visibleSlides;
        
        if (this.prevBtn) {
            this.prevBtn.style.opacity = this.currentSlide === 0 ? '0.5' : '1';
            this.prevBtn.style.pointerEvents = this.currentSlide === 0 ? 'none' : 'auto';
        }
        
        if (this.nextBtn) {
            this.nextBtn.style.opacity = this.currentSlide >= maxSlide ? '0.5' : '1';
            this.nextBtn.style.pointerEvents = this.currentSlide >= maxSlide ? 'none' : 'auto';
        }
    }
    
    goToSlide(slideIndex) {
        const maxSlide = this.totalSlides - this.visibleSlides;
        if (slideIndex >= 0 && slideIndex <= maxSlide) {
            this.currentSlide = slideIndex;
            this.updateSlider();
        }
    }
    
    nextSlide() {
        const maxSlide = this.totalSlides - this.visibleSlides;
        if (this.currentSlide < maxSlide) {
            this.currentSlide++;
        } else {
            this.currentSlide = 0; // Loop back to start
        }
        this.updateSlider();
    }
    
    prevSlide() {
        if (this.currentSlide > 0) {
            this.currentSlide--;
        } else {
            const maxSlide = this.totalSlides - this.visibleSlides;
            this.currentSlide = maxSlide; // Loop to end
        }
        this.updateSlider();
    }
    
    startAutoPlay() {
        if (this.totalSlides <= this.visibleSlides) return;
        
        this.autoPlayInterval = setInterval(() => {
            this.nextSlide();
        }, this.autoPlayDelay);
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    
    restartAutoPlay() {
        this.stopAutoPlay();
        this.startAutoPlay();
    }
    
    openModal(imageSrc, imageAlt) {
        if (this.modal && this.modalImage) {
            this.modalImage.src = imageSrc;
            this.modalImage.alt = imageAlt;
            this.modal.classList.remove('hidden');
            this.modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            this.stopAutoPlay();
        }
    }
    
    closeModal() {
        if (this.modal) {
            this.modal.classList.add('hidden');
            this.modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
            this.startAutoPlay();
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

// Initialize slider when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const galleryElement = document.querySelector('#product-slider');
    if (galleryElement) {
        window.universalSlider = new UniversalImageSlider();
    }
});

// Export for use in other scripts
window.UniversalImageSlider = UniversalImageSlider;