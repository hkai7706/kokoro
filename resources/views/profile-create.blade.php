@extends('layouts.app')
@section('title', 'Complete Your Profile - KOKORO')

@section('content')
<div class="max-w-lg mx-auto">
    {{-- Progress indicator --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center text-[10px] font-bold">1</div>
            <div class="flex-1 h-px bg-rose-500"></div>
            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-600 text-gray-400 rounded-full flex items-center justify-center text-[10px] font-bold">2</div>
        </div>
        <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100" data-en="Set up your profile" data-jp="プロフィールを設定">Set up your profile</h1>
        <p class="text-xs text-gray-400 mt-0.5" data-en="This takes about 2 minutes. You can edit everything later." data-jp="約2分で完了。後から編集もできます。">This takes about 2 minutes. You can edit everything later.</p>
    </div>

    <div class="card p-5 animate-in">
        <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Photo --}}
            <div class="flex items-center gap-4 mb-5 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div class="relative shrink-0">
                    <div id="photo-preview" class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600">
                        <svg class="w-10 h-10 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <label class="absolute -bottom-1 -right-1 bg-rose-500 text-white rounded-full w-7 h-7 flex items-center justify-center cursor-pointer shadow-sm hover:bg-rose-600 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="file" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                    </label>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200" data-en="Add a photo" data-jp="写真を追加">Add a photo</p>
                    <p class="text-[11px] text-gray-400" data-en="Profiles with photos get 5x more likes" data-jp="写真付きプロフは5倍いいねされます">Profiles with photos get 5x more likes</p>
                </div>
                @error('profile_photo') <p class="text-red-500 text-[11px]">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-4">
                {{-- Name --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Display Name" data-jp="表示名">Display Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition"
                        placeholder="How others will see you" data-placeholder-en="How others will see you" data-placeholder-jp="他のユーザーに表示される名前">
                    @error('name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Age / Gender --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Age" data-jp="年齢">Age</label>
                        <input type="number" name="age" value="{{ old('age') }}" min="18" max="99" required
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                        @error('age') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Gender" data-jp="性別">Gender</label>
                        <select name="gender" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                            <option value="" data-en="Select" data-jp="選択">Select</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }} data-en="Male" data-jp="男性">Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }} data-en="Female" data-jp="女性">Female</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }} data-en="Other" data-jp="その他">Other</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Prefecture / City --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Prefecture" data-jp="都道府県">Prefecture</label>
                        <select name="prefecture" id="prefecture-select" required onchange="updateCityDropdown()" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                            <option value="" data-en="Select prefecture" data-jp="都道府県を選択">Select prefecture</option>
                            @foreach($prefectures as $pref)
                                <option value="{{ $pref }}" {{ old('prefecture') === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                            @endforeach
                        </select>
                        @error('prefecture') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="City" data-jp="市区町村">City</label>
                        <select name="location" id="city-select" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                            <option value="" data-en="Select prefecture first" data-jp="先に都道府県を選択">Select prefecture first</option>
                        </select>
                        <p id="city-hint" class="text-amber-500 text-[11px] mt-1 hidden" data-en="Please select a prefecture first" data-jp="先に都道府県を選択してください">Please select a prefecture first</p>
                        @error('location') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Hobbies --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Hobbies" data-jp="趣味">Hobbies</label>
                    <input type="text" name="hobbies" value="{{ old('hobbies') }}"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition"
                        placeholder="e.g. Hiking, Cooking, Photography" data-placeholder-en="e.g. Hiking, Cooking, Photography" data-placeholder-jp="例: ハイキング、料理、写真">
                    <p class="text-[11px] text-gray-300 dark:text-gray-500 mt-1" data-en="Comma separated. Helps find compatible matches." data-jp="カンマ区切り。相性の良い相手を見つけるのに役立ちます。">Comma separated. Helps find compatible matches.</p>
                </div>

                {{-- Interests --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Interests" data-jp="興味">Interests</label>
                    <input type="text" name="interests" value="{{ old('interests') }}"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition"
                        placeholder="e.g. Music, Travel, Anime" data-placeholder-en="e.g. Music, Travel, Anime" data-placeholder-jp="例: 音楽、旅行、アニメ">
                </div>

                {{-- Bio --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="About you" data-jp="自己紹介">About you</label>
                    <textarea name="bio" rows="3"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition resize-none"
                        placeholder="What are you looking for? What makes you interesting?" data-placeholder-en="What are you looking for? What makes you interesting?" data-placeholder-jp="何を探していますか？あなたの魅力は？">{{ old('bio') }}</textarea>
                </div>

                <button type="submit" class="w-full btn btn-rose py-2.5" data-en="Complete profile" data-jp="プロフィールを完成">
                    Complete profile
                </button>
                <p class="text-[11px] text-gray-300 dark:text-gray-500 text-center" data-en="You can always update this later from your profile page" data-jp="後からプロフィールページでいつでも変更できます">You can always update this later from your profile page</p>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photo-preview').innerHTML =
                '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Prefecture → City mapping
const prefectureCities = {
    'Hokkaido': ['Sapporo','Hakodate','Asahikawa','Obihiro','Kushiro','Kitami','Otaru','Tomakomai'],
    'Aomori': ['Aomori','Hirosaki','Hachinohe','Misawa','Towada'],
    'Iwate': ['Morioka','Ichinoseki','Oshu','Kitakami','Kamaishi'],
    'Miyagi': ['Sendai','Ishinomaki','Shiogama','Natori','Tagajo'],
    'Akita': ['Akita','Yokote','Daisen','Noshiro','Yuzawa'],
    'Yamagata': ['Yamagata','Tsuruoka','Sakata','Yonezawa','Tendo'],
    'Fukushima': ['Fukushima','Koriyama','Iwaki','Aizuwakamatsu','Sukagawa'],
    'Ibaraki': ['Mito','Tsukuba','Hitachi','Tsuchiura','Kashima'],
    'Tochigi': ['Utsunomiya','Oyama','Tochigi','Sano','Ashikaga'],
    'Gunma': ['Maebashi','Takasaki','Ota','Isesaki','Kiryu'],
    'Saitama': ['Saitama','Kawaguchi','Kawagoe','Tokorozawa','Koshigaya','Urawa'],
    'Chiba': ['Chiba','Funabashi','Kashiwa','Matsudo','Ichikawa','Urayasu'],
    'Tokyo': ['Shinjuku','Shibuya','Minato','Chiyoda','Setagaya','Meguro','Shinagawa','Ikebukuro','Akihabara','Roppongi','Ginza','Asakusa','Harajuku','Nakano','Machida'],
    'Kanagawa': ['Yokohama','Kawasaki','Sagamihara','Fujisawa','Kamakura','Yokosuka'],
    'Niigata': ['Niigata','Nagaoka','Joetsu','Sanjo','Kashiwazaki'],
    'Toyama': ['Toyama','Takaoka','Imizu','Tonami','Namerikawa'],
    'Ishikawa': ['Kanazawa','Hakusan','Komatsu','Kaga','Nanao'],
    'Fukui': ['Fukui','Sabae','Echizen','Tsuruga','Obama'],
    'Yamanashi': ['Kofu','Fujiyoshida','Minami-Alps','Kai','Fuefuki'],
    'Nagano': ['Nagano','Matsumoto','Ueda','Iida','Suwa'],
    'Gifu': ['Gifu','Ogaki','Kakamigahara','Tajimi','Takayama'],
    'Shizuoka': ['Shizuoka','Hamamatsu','Numazu','Fuji','Shimizu'],
    'Aichi': ['Nagoya','Toyohashi','Okazaki','Toyota','Ichinomiya','Kasugai'],
    'Mie': ['Tsu','Yokkaichi','Suzuka','Matsusaka','Ise'],
    'Shiga': ['Otsu','Kusatsu','Nagahama','Hikone','Moriyama'],
    'Kyoto': ['Kyoto','Uji','Kameoka','Maizuru','Fukuchiyama','Gion'],
    'Osaka': ['Osaka','Sakai','Takatsuki','Toyonaka','Suita','Namba','Umeda','Tennoji'],
    'Hyogo': ['Kobe','Himeji','Nishinomiya','Amagasaki','Akashi','Takarazuka'],
    'Nara': ['Nara','Kashihara','Ikoma','Yamatotakada','Tenri'],
    'Wakayama': ['Wakayama','Tanabe','Hashimoto','Kinokawa','Kainan'],
    'Tottori': ['Tottori','Yonago','Kurayoshi','Sakaiminato'],
    'Shimane': ['Matsue','Izumo','Hamada','Masuda','Oda'],
    'Okayama': ['Okayama','Kurashiki','Tsuyama','Soja','Tamano'],
    'Hiroshima': ['Hiroshima','Fukuyama','Kure','Onomichi','Higashihiroshima'],
    'Yamaguchi': ['Yamaguchi','Shimonoseki','Ube','Iwakuni','Shunan'],
    'Tokushima': ['Tokushima','Naruto','Anan','Komatsushima','Yoshinogawa'],
    'Kagawa': ['Takamatsu','Marugame','Sakaide','Sanuki','Zentsuji'],
    'Ehime': ['Matsuyama','Imabari','Niihama','Saijo','Uwajima'],
    'Kochi': ['Kochi','Nankoku','Shimanto','Tosa','Susaki'],
    'Fukuoka': ['Fukuoka','Kitakyushu','Kurume','Omuta','Iizuka','Hakata','Tenjin'],
    'Saga': ['Saga','Karatsu','Tosu','Imari','Takeo'],
    'Nagasaki': ['Nagasaki','Sasebo','Isahaya','Omura','Shimabara'],
    'Kumamoto': ['Kumamoto','Yatsushiro','Tamana','Arao','Uto'],
    'Oita': ['Oita','Beppu','Nakatsu','Saiki','Usuki'],
    'Miyazaki': ['Miyazaki','Miyakonojo','Nobeoka','Hyuga','Nichinan'],
    'Kagoshima': ['Kagoshima','Kirishima','Kanoya','Satsumasendai','Ibusuki'],
    'Okinawa': ['Naha','Okinawa','Urasoe','Ginowan','Chatan','Nago']
};

function updateCityDropdown() {
    const pref = document.getElementById('prefecture-select').value;
    const citySelect = document.getElementById('city-select');
    const hint = document.getElementById('city-hint');
    const lang = localStorage.getItem('kokoro-lang') || 'en';

    citySelect.innerHTML = '';

    if (!pref) {
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = lang === 'en' ? 'Select prefecture first' : '先に都道府県を選択';
        citySelect.appendChild(opt);
        hint.classList.remove('hidden');
        return;
    }

    hint.classList.add('hidden');
    const cities = prefectureCities[pref] || [];

    const defaultOpt = document.createElement('option');
    defaultOpt.value = '';
    defaultOpt.textContent = lang === 'en' ? 'Select city' : '市区町村を選択';
    citySelect.appendChild(defaultOpt);

    cities.forEach(city => {
        const opt = document.createElement('option');
        opt.value = city;
        opt.textContent = city;
        if ('{{ old("location") }}' === city) opt.selected = true;
        citySelect.appendChild(opt);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const prefSelect = document.getElementById('prefecture-select');
    if (prefSelect && prefSelect.value) {
        updateCityDropdown();
    }
});
</script>
@endsection
