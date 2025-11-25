<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Brand;

class Brands extends Component
{
    public $brands;
    public $processedBrands;

    public function __construct()
    {
        // Get brands
        $this->brands = $this->getBrands();
        
        // Process brands with calculated values
        $this->processedBrands = $this->getProcessedBrands();
    }

    /**
     * Get brands
     */
    private function getBrands()
    {
        return Brand::where('is_active', true)
            ->orderBy('name', 'asc')
            ->limit(6)
            ->get();
    }

    /**
     * Get processed brands with calculated values
     */
    private function getProcessedBrands()
    {
        return $this->brands->map(function($brand) {
            return [
                'brand' => $brand,
                'logoUrl' => $this->getBrandLogo($brand),
                'altText' => $brand->name . ' logo',
            ];
        });
    }

    /**
     * Get brand logo URL
     */
    private function getBrandLogo($brand)
    {
        // You can add logo field to brands table later
        // For now, use placeholder logos
        $placeholderLogos = [
            'nike' => 'https://dummyimage.com/120x24/000/fff&text=Nike',
            'adidas' => 'https://dummyimage.com/120x24/000/fff&text=Adidas',
            'puma' => 'https://dummyimage.com/120x24/000/fff&text=Puma',
            'reebok' => 'https://dummyimage.com/120x24/000/fff&text=Reebok',
            'new balance' => 'https://dummyimage.com/120x24/000/fff&text=New+Balance',
            'converse' => 'https://dummyimage.com/120x24/000/fff&text=Converse',
            'vans' => 'https://dummyimage.com/120x24/000/fff&text=Vans',
            'dr. martens' => 'https://dummyimage.com/120x24/000/fff&text=Dr+Martens',
            'timberland' => 'https://dummyimage.com/120x24/000/fff&text=Timberland',
            'clarks' => 'https://dummyimage.com/120x24/000/fff&text=Clarks',
        ];

        $brandName = strtolower($brand->name);
        foreach ($placeholderLogos as $key => $logo) {
            if (str_contains($brandName, $key)) {
                return $logo;
            }
        }

        // Default fallback
        return 'https://dummyimage.com/120x24/ddd/000&text=' . urlencode($brand->name);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.brands');
    }
}
