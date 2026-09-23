<x-guest-layout>
    
    <!-- Logo -->
    <div class="flex justify-center mb-4">
        <!-- Mocking the actual image logo for better look -->
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Logo_Universitas_Aisyiyah_Yogyakarta.png" alt="UNISA Logo" class="w-24 h-24 object-contain" onerror="this.outerHTML='<div class=\'w-24 h-24 bg-green-600 rounded-full flex items-center justify-center border-4 border-yellow-400\'><span class=\'text-white text-[10px] font-bold\'>UNISA</span></div>'">
    </div>

    <!-- Titles -->
    <div class="text-center mb-6">
        <h1 class="text-[20px] font-bold text-[#2A3B5C] leading-tight">Universitas 'Aisyiyah Yogyakarta</h1>
        <p class="text-[14px] text-[#4B5563] mt-0.5">Single Sign-On</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                class="block w-full px-3 py-2 bg-[#E8F0FE] border border-[#D1D5DB] rounded focus:outline-none focus:ring-1 focus:ring-[#00875A] focus:border-[#00875A] text-gray-900 placeholder-gray-500 text-sm" 
                placeholder="2211501021">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="block w-full px-3 py-2 bg-[#E8F0FE] border border-[#D1D5DB] rounded focus:outline-none focus:ring-1 focus:ring-[#00875A] focus:border-[#00875A] text-gray-900 placeholder-gray-500 text-sm tracking-widest" 
                placeholder="Masukkan password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Cloudflare Mock Widget -->
        <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between bg-[#F9FAFB]">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-[#00A651] flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-[15px] text-gray-700">Success!</span>
            </div>
            <div class="text-right flex flex-col items-end">
                <!-- Cloudflare logo mock -->
                <div class="flex items-center gap-1 mb-1">
                    <svg class="w-6 h-4 text-[#F38020]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.46 9.61c-0.29-3.23-2.95-5.61-6.15-5.61 -2.71 0-5 1.72-5.83 4.19-0.34-0.12-0.7-0.19-1.07-0.19-1.89 0-3.41 1.54-3.41 3.44 0 0.23 0.02 0.46 0.07 0.67C1.3 12.59 0 14.16 0 16c0 2.21 1.79 4 4 4h15c2.76 0 5-2.24 5-5C24 12.33 22.01 9.87 19.46 9.61z"/>
                    </svg>
                </div>
                <div class="text-[10px] text-gray-800 font-bold tracking-wide">CLOUDFLARE</div>
                <div class="text-[9px] text-gray-500 mt-0.5">
                    <a href="#" class="hover:underline">Privacy</a> • <a href="#" class="hover:underline">Help</a>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-1">
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded shadow-sm text-sm font-bold text-white bg-[#00875A] hover:bg-[#006C48] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00875A] transition-colors">
                Masuk
            </button>
        </div>
    </form>

    <!-- Forgot Password Link -->
    <div class="mt-3">
        <a href="#" class="block w-full text-center py-2.5 px-4 rounded bg-[#EEF2F6] text-[#4B5563] text-sm hover:bg-gray-200 transition-colors">
            Klik di sini untuk mengubah Password.
        </a>
    </div>

    <!-- CSIRT Banner -->
    <div class="mt-4 bg-[#76C2A0] rounded-lg p-3 flex justify-center items-center gap-3">
        <!-- Mock mini logo for CSIRT -->
        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center border border-yellow-400 shrink-0">
            <span class="text-white text-[6px] font-bold leading-none text-center">UNISA<br>YOGYA</span>
        </div>
        <div class="flex items-center text-white">
            <span class="text-xl font-bold tracking-tight text-[#006C48]">unisa</span>
            <div class="flex flex-col justify-center px-2 py-0.5 border-l border-[#006C48] border-opacity-30 ml-2 h-6">
                <span class="text-[4px] font-bold text-[#006C48] leading-[1.2] uppercase">Universitas 'Aisyiyah<br>Yogyakarta</span>
            </div>
            <span class="text-xl font-light ml-1 opacity-90">CSIRT</span>
        </div>
    </div>

</x-guest-layout>
