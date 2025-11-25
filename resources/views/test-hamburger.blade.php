<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hamburger Menu Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="p-8">
        <h1 class="text-3xl font-bold mb-8">Hamburger Menu Debug</h1>
        
        <div class="mb-6">
            <h2 class="text-xl mb-4">Screen Size Test</h2>
            <div class="p-4 bg-gray-100 rounded">
                <div class="block sm:hidden">📱 XS: Mobile (< 640px)</div>
                <div class="hidden sm:block md:hidden">📱 SM: Mobile Large (640px - 768px)</div>
                <div class="hidden md:block lg:hidden">📱 MD: Tablet (768px - 1024px)</div>
                <div class="hidden lg:block xl:hidden">💻 LG: Desktop (1024px - 1280px)</div>
                <div class="hidden xl:block">💻 XL: Large Desktop (> 1280px)</div>
            </div>
        </div>
        
        <div class="mb-6">
            <h2 class="text-xl mb-4">Button Tests</h2>
            <div class="space-x-4 mb-4">
                <button onclick="testAlert()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Test Alert
                </button>
                <button onclick="testConsole()" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Test Console Log
                </button>
            </div>
        </div>
        
        <div class="mb-6">
            <h2 class="text-xl mb-4">Hamburger Button (Always Visible)</h2>
            <button onclick="testHamburger()" 
                    class="p-3 border-2 border-red-500 bg-white rounded-lg hover:bg-gray-50 transition-colors duration-200" 
                    style="display: block !important;">
                <svg class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        
        <div class="mb-6">
            <h2 class="text-xl mb-4">Responsive Hamburger (md:hidden)</h2>
            <button onclick="testHamburger()" 
                    class="p-3 border-2 border-blue-500 bg-white rounded-lg hover:bg-gray-50 transition-colors duration-200 md:hidden">
                <svg class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="hidden md:block p-3 border-2 border-gray-300 rounded text-gray-500">
                Hamburger hidden on desktop (>= 768px)
            </div>
        </div>
        
        <div id="debug-output" class="p-4 bg-yellow-50 border border-yellow-200 rounded">
            <h3 class="font-bold mb-2">Debug Output:</h3>
            <div id="output-content">Click buttons to see debug info...</div>
        </div>
    </div>
    
    <!-- Simple Nav Drawer for Testing -->
    <div id="nav-drawer-overlay" class="fixed inset-0 bg-black/40 opacity-0 invisible transition-opacity duration-200 z-40" onclick="closeDrawer()"></div>
    <div id="nav-drawer" class="fixed left-0 top-0 h-full w-80 max-w-[85vw] -translate-x-full bg-white z-50 shadow-xl transition-transform duration-300">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Test Navigation</h2>
                <button onclick="closeDrawer()" class="p-2 hover:bg-gray-100 rounded">✕</button>
            </div>
            <div class="space-y-2">
                <a href="#" class="block px-3 py-2 hover:bg-gray-100 rounded">Test Category 1</a>
                <a href="#" class="block px-3 py-2 hover:bg-gray-100 rounded">Test Category 2</a>
                <a href="#" class="block px-3 py-2 hover:bg-gray-100 rounded">Test Category 3</a>
            </div>
        </div>
    </div>

    <script>
        function addOutput(message) {
            const output = document.getElementById('output-content');
            const time = new Date().toLocaleTimeString();
            output.innerHTML += `<div class="mb-1"><span class="text-xs text-gray-500">${time}</span> - ${message}</div>`;
            output.scrollTop = output.scrollHeight;
            console.log(message);
        }
        
        function testAlert() {
            addOutput('✅ Alert test clicked');
            alert('Alert working!');
        }
        
        function testConsole() {
            addOutput('✅ Console test clicked');
            console.log('Console log working!');
        }
        
        function testHamburger() {
            addOutput('🍔 Hamburger clicked!');
            openDrawer();
        }
        
        function openDrawer() {
            addOutput('🚪 Opening drawer...');
            const drawer = document.getElementById('nav-drawer');
            const overlay = document.getElementById('nav-drawer-overlay');
            
            if (drawer && overlay) {
                addOutput('✅ Elements found, showing drawer');
                drawer.style.transform = 'translateX(0)';
                overlay.classList.remove('invisible');
                requestAnimationFrame(() => overlay.classList.add('opacity-100'));
            } else {
                addOutput('❌ Drawer elements not found');
            }
        }
        
        function closeDrawer() {
            addOutput('🚪 Closing drawer...');
            const drawer = document.getElementById('nav-drawer');
            const overlay = document.getElementById('nav-drawer-overlay');
            
            if (drawer && overlay) {
                drawer.style.transform = 'translateX(-100%)';
                overlay.classList.remove('opacity-100');
                setTimeout(() => overlay.classList.add('invisible'), 200);
            }
        }
        
        // Test screen size detection
        window.addEventListener('resize', function() {
            addOutput(`📏 Screen resized: ${window.innerWidth}px x ${window.innerHeight}px`);
        });
        
        addOutput(`📏 Initial screen size: ${window.innerWidth}px x ${window.innerHeight}px`);
        addOutput('🚀 Test page loaded');
    </script>
</body>
</html>