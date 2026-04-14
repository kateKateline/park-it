<x-layouts.guest :title="'Park-It'">
    {{-- AOS Library --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    {{-- Menambahkan flex col dan min-h-screen agar footer bisa nempel di bawah --}}
    <div class="relative min-h-screen flex flex-col overflow-hidden">
        
        {{-- Background Blobs --}}
        <x-landing.background />

        <div class="relative flex flex-col flex-1">
            {{-- Header --}}
            <x-landing.header />

            {{-- Main Content: flex-1 memastikan bagian ini mengambil ruang sisa --}}
            <x-landing.main />

            {{-- Footer: Dikeluarkan dari <main> agar lebarnya full --}}
            <x-landing.footer />
        </div>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                easing: 'ease-out-quart'
            });
        });
    </script>

    <style>
        @keyframes floatSlow { 0%,100% { transform: translate3d(0,0,0); } 50% { transform: translate3d(0,14px,0); } }
        @keyframes fadeUp { 0% { opacity: 0; transform: translate3d(0,12px,0); } 100% { opacity: 1; transform: translate3d(0,0,0); } }
        .animate-float-slow { animation: floatSlow 10s ease-in-out infinite; }
        .animate-float-slower { animation: floatSlow 14s ease-in-out infinite; }
        .animate-float-slowest { animation: floatSlow 18s ease-in-out infinite; }
        .animate-fade-up { animation: fadeUp 700ms ease-out both; }
    </style>
</x-layouts.guest>
