@props(['message', 'type' => 'error'])

<!-- Error Message Component -->
<div class="rounded-md p-4 mb-4 text-sm font-medium"
     :class="{
         'bg-red-100 text-red-800 border-red-200': type === 'error',
         'bg-yellow-100 text-yellow-800 border-yellow-200': type === 'warning',
         'bg-green-100 text-green-800 border-green-200': type === 'success',
     }">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2"
             :class="{
                 'text-red-500': type === 'error',
                 'text-yellow-500': type === 'warning',
                 'text-green-500': type === 'success',
             }"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  :d="{
                      'M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z': type === 'error',
                      'M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z': type === 'warning',
                      'M5 13l4 4L19 7': type === 'success',
                  }"/>
        </svg>
        <span>{{ $message }}</span>
    </div>
</div>