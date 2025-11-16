<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">Fintrack</h3>
                <p class="text-gray-400">Platform pengelolaan keuangan terbaik untuk UMKM dan individu.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('features') }}" class="hover:text-white transition">Fitur</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Dukungan</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Kontak</a></li>
                    <li><a href="#" class="hover:text-white transition">Bantuan</a></li>
                    <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Kontak</h4>
                <div class="text-gray-400 space-y-2">
                    <p>Email: info@fintrack.com</p>
                    <p>Phone: +62 812 3456 7890</p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2024 Fintrack. All rights reserved.</p>
        </div>
    </div>
</footer>
