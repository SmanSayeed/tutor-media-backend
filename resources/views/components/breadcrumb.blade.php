@props(['items' => []])

<!-- Breadcrumb -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <nav class="text-sm text-gray-600">
            @foreach($items as $index => $item)
                @if($index > 0)
                    <span class="mx-2">/</span>
                @endif

                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-gray-900">{{ $item['label'] }}</a>
                @else
                    <span class="text-gray-900">{{ $item['label'] }}</span>
                @endif
            @endforeach
        </nav>
    </div>
</div>
