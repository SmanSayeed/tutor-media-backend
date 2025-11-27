<?php

use Illuminate\Support\Facades\File;
use Spatie\ImageOptimizer\OptimizerChainFactory;

if (! function_exists('optimizeImage')) {
    function optimizeImage($image)
    {
        $fileType = File::mimeType($image);
        if ($fileType === 'image/jpeg' || $fileType === 'image/png' || $fileType === 'image/jpg') {
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($image);
        }
    }
}
