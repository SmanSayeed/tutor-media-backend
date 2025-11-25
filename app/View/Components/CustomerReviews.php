<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Review;
use App\Models\Product;

class CustomerReviews extends Component
{
    public $reviews;
    public $processedReviews;

    public function __construct()
    {
        // Get customer reviews
        $this->reviews = $this->getReviews();
        
        // Process reviews with calculated values
        $this->processedReviews = $this->getProcessedReviews();
    }

    /**
     * Get customer reviews
     */
    private function getReviews()
    {
        return Review::with(['user', 'product'])
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
    }

    /**
     * Get processed reviews with calculated values
     */
    private function getProcessedReviews()
    {
        // If we have real reviews, use them
        if ($this->reviews->count() > 0) {
            return $this->reviews->map(function($review) {
                return [
                    'review' => $review,
                    'customerName' => $this->getCustomerName($review),
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'productName' => $review->product ? $review->product->name : 'Product',
                ];
            });
        }

        // Fallback: Generate sample reviews if no real reviews exist
        return $this->getSampleReviews();
    }

    /**
     * Get customer name from review
     */
    private function getCustomerName($review)
    {
        if ($review->user) {
            return $review->user->name;
        }
        
        // If no user, use a generic name
        return 'Customer';
    }

    /**
     * Get sample reviews for demonstration
     */
    private function getSampleReviews()
    {
        $sampleReviews = [
            [
                'customerName' => 'Arafat Rahman',
                'rating' => 5.0,
                'comment' => 'Absolutely love the quality of these leather shoes! The craftsmanship is outstanding and they feel incredibly comfortable. The delivery was super fast too. Highly recommend SSB Leather!',
                'productName' => 'Premium Leather Oxford Shoes'
            ],
            [
                'customerName' => 'Sakib Ahmed',
                'rating' => 4.8,
                'comment' => 'The office bag exceeded my expectations. The leather is genuine and the build quality is exceptional. Perfect for daily use and looks professional. Great value for money!',
                'productName' => 'Executive Leather Briefcase'
            ],
            [
                'customerName' => 'Faruque Hassan',
                'rating' => 5.0,
                'comment' => 'These formal shoes are exactly what I was looking for. Comfortable from day one, elegant design, and the leather quality is top-notch. Will definitely order again!',
                'productName' => 'Classic Formal Dress Shoes'
            ],
            [
                'customerName' => 'Mitu Akter',
                'rating' => 4.9,
                'comment' => 'The leather belt is beautifully crafted with attention to detail. It feels premium and durable. The customer service was also excellent. Very satisfied with my purchase!',
                'productName' => 'Genuine Leather Belt'
            ],
            [
                'customerName' => 'Rashid Khan',
                'rating' => 4.7,
                'comment' => 'Outstanding quality and service! The wallet is made with genuine leather and has a sophisticated design. Perfect for business use. Fast shipping and great packaging.',
                'productName' => 'Business Leather Wallet'
            ],
            [
                'customerName' => 'Fatima Begum',
                'rating' => 5.0,
                'comment' => 'I\'m so impressed with the handbag quality! The leather is soft yet durable, and the design is timeless. It\'s become my go-to bag for all occasions. Thank you SSB Leather!',
                'productName' => 'Elegant Leather Handbag'
            ]
        ];

        return collect($sampleReviews);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.customer-reviews');
    }
}
