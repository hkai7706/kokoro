@extends('layouts.app')
@section('title', 'My Profile - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100" data-en="My Profile" data-jp="マイプロフィール">My Profile</h1>
        <p class="text-xs text-gray-400 mt-0.5" data-en="Keep your profile up to date to get better matches" data-jp="プロフィールを最新にしてより良いマッチを">Keep your profile up to date to get better matches</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/15 border border-emerald-100 dark:border-emerald-800/30 text-emerald-600 text-xs">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-5 animate-in">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Photo --}}
            <div class="flex items-center gap-4 mb-6 pb-5 border-b border-gray-100 dark:border-gray-700">
                <div class="relative shrink-0">
                    <div id="photo-preview" class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600">
                        @if($user->profile && $user->profile->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl font-bold text-gray-300 dark:text-gray-500">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <label class="absolute -bottom-1 -right-1 bg-rose-500 text-white rounded-full w-7 h-7 flex items-center justify-center cursor-pointer shadow-sm hover:bg-rose-600 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="file" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                    </label>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200" data-en="Profile photo" data-jp="プロフィール写真">Profile photo</p>
                    <p class="text-[11px] text-gray-400 mt-0.5" data-en="JPG or PNG, max 5MB" data-jp="JPGまたはPNG、最大5MB">JPG or PNG, max 5MB</p>
                </div>
            </div>

            <div class="space-y-4">
                {{-- Name --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Display Name" data-jp="表示名">Display Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                    @error('name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Age / Gender --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Age" data-jp="年齢">Age</label>
                        <input type="number" name="age" value="{{ old('age', $user->profile->age ?? '') }}" min="18" max="99" required
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Gender" data-jp="性別">Gender</label>
                        <select name="gender" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                            <option value="male" {{ old('gender', $user->profile->gender ?? '') === 'male' ? 'selected' : '' }} data-en="Male" data-jp="男性">Male</option>
                            <option value="female" {{ old('gender', $user->profile->gender ?? '') === 'female' ? 'selected' : '' }} data-en="Female" data-jp="女性">Female</option>
                            <option value="other" {{ old('gender', $user->profile->gender ?? '') === 'other' ? 'selected' : '' }} data-en="Other" data-jp="その他">Other</option>
                        </select>
                    </div>
                </div>

                {{-- Location / Prefecture --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="City" data-jp="市区町村">City</label>
                        <input type="text" name="location" value="{{ old('location', $user->profile->location ?? '') }}" required
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Prefecture" data-jp="都道府県">Prefecture</label>
                        <select name="prefecture" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition">
                            <option value="" data-en="Select" data-jp="選択">Select</option>
                            @foreach($prefectures as $pref)
                                <option value="{{ $pref }}" {{ old('prefecture', $user->profile->prefecture ?? '') === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Hobbies --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Hobbies" data-jp="趣味">Hobbies</label>
                    <input type="text" name="hobbies" value="{{ old('hobbies', $user->profile->hobbies ?? '') }}"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition"
                        placeholder="Hiking, Cooking, Photography" data-placeholder-en="Hiking, Cooking, Photography" data-placeholder-jp="ハイキング、料理、写真">
                    <p class="text-[11px] text-gray-300 dark:text-gray-500 mt-1" data-en="Separate with commas. Used for compatibility matching." data-jp="カンマ区切り。相性マッチングに使用されます。">Separate with commas. Used for compatibility matching.</p>
                </div>

                {{-- Interests --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Interests" data-jp="興味">Interests</label>
                    <input type="text" name="interests" value="{{ old('interests', $user->profile->interests ?? '') }}"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition"
                        placeholder="Music, Travel, Anime" data-placeholder-en="Music, Travel, Anime" data-placeholder-jp="音楽、旅行、アニメ">
                </div>

                {{-- Bio --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="About you" data-jp="自己紹介">About you</label>
                    <textarea name="bio" rows="3"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition resize-none"
                        placeholder="A few words about yourself..." data-placeholder-en="A few words about yourself..." data-placeholder-jp="自己紹介を書きましょう...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                </div>

                <button type="submit" class="w-full btn btn-rose py-2.5" data-en="Save changes" data-jp="変更を保存">Save changes</button>
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
            document.getElementById('photo-preview').innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
