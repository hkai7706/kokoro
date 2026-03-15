@extends('layouts.app')
@section('title', 'Complete Your Profile - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100" data-en="Complete Your Profile" data-jp="プロフィールを完成させる">Complete Your Profile</h1>
        <p class="text-sm text-gray-400 mt-1" data-en="Tell us about yourself so others can find you" data-jp="自分のことを教えてください">Tell us about yourself so others can find you</p>
    </div>

    <div class="card p-6 animate-in">
        <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-5">
                {{-- Photo Upload --}}
                <div class="text-center">
                    <div class="relative inline-block">
                        <div id="photo-preview" class="w-28 h-28 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-2 border-gray-200 dark:border-gray-600 mx-auto">
                            <svg class="w-14 h-14 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <label class="absolute bottom-0 right-0 bg-rose-500 text-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer shadow hover:bg-rose-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <input type="file" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                        </label>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5" data-en="Upload your photo (max 5MB)" data-jp="写真をアップロード（最大5MB）">Upload your photo (max 5MB)</p>
                    @error('profile_photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Display Name *" data-jp="表示名 *">Display Name *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Age *" data-jp="年齢 *">Age *</label>
                        <input type="number" name="age" value="{{ old('age') }}" min="18" max="99" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition">
                        @error('age') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Gender *" data-jp="性別 *">Gender *</label>
                        <select name="gender" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition">
                            <option value="" data-en="Select" data-jp="選択">Select</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }} data-en="Male" data-jp="男性">Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }} data-en="Female" data-jp="女性">Female</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }} data-en="Other" data-jp="その他">Other</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="City / Location *" data-jp="市区町村 *">City / Location *</label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition"
                            placeholder="e.g. Shibuya" data-placeholder-en="e.g. Shibuya" data-placeholder-jp="例: 渋谷">
                        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Prefecture" data-jp="都道府県">Prefecture</label>
                        <select name="prefecture" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition">
                            <option value="" data-en="Select prefecture" data-jp="都道府県を選択">Select prefecture</option>
                            @foreach($prefectures as $pref)
                                <option value="{{ $pref }}" {{ old('prefecture') === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Hobbies" data-jp="趣味">Hobbies</label>
                    <input type="text" name="hobbies" value="{{ old('hobbies') }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition"
                        placeholder="e.g. Hiking, Cooking, Photography (comma separated)" data-placeholder-en="e.g. Hiking, Cooking, Photography (comma separated)" data-placeholder-jp="例: ハイキング、料理、写真（カンマ区切り）">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Interests" data-jp="興味">Interests</label>
                    <input type="text" name="interests" value="{{ old('interests') }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition"
                        placeholder="e.g. Music, Travel, Anime (comma separated)" data-placeholder-en="e.g. Music, Travel, Anime (comma separated)" data-placeholder-jp="例: 音楽、旅行、アニメ（カンマ区切り）">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="About You" data-jp="自己紹介">About You</label>
                    <textarea name="bio" rows="4"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition resize-none"
                        placeholder="Tell potential matches about yourself..." data-placeholder-en="Tell potential matches about yourself..." data-placeholder-jp="自己紹介を書きましょう...">{{ old('bio') }}</textarea>
                </div>

                <button type="submit" class="w-full btn btn-rose py-3" data-en="Complete Profile & Start Matching" data-jp="プロフィール完成 & マッチング開始">
                    Complete Profile & Start Matching
                </button>
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
</script>
@endsection
