@extends('layouts.app')
@section('title', 'Complete Your Profile - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold gradient-text">Complete Your Profile</h1>
        <p class="text-gray-500 mt-2">Tell us about yourself so others can find you</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl p-8 animate-fade-in-up">
        <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                {{-- Photo Upload --}}
                <div class="text-center">
                    <div class="relative inline-block">
                        <div id="photo-preview" class="w-32 h-32 rounded-full bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center overflow-hidden border-4 border-kokoro-yellow shadow-lg mx-auto">
                            <svg class="w-16 h-16 text-pink-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <label class="absolute bottom-0 right-0 bg-primary text-white rounded-full w-10 h-10 flex items-center justify-center cursor-pointer shadow-lg hover:bg-primary-dark transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <input type="file" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                        </label>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Upload your photo (max 5MB)</p>
                    @error('profile_photo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Display Name *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Age & Gender --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Age *</label>
                        <input type="number" name="age" value="{{ old('age') }}" min="18" max="99" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                        @error('age') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gender *</label>
                        <select name="gender" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                            <option value="">Select</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Location & Prefecture --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">City / Location *</label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="e.g. Shibuya">
                        @error('location') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Prefecture</label>
                        <select name="prefecture" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                            <option value="">Select prefecture</option>
                            @foreach($prefectures as $pref)
                                <option value="{{ $pref }}" {{ old('prefecture') === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Hobbies --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Hobbies</label>
                    <input type="text" name="hobbies" value="{{ old('hobbies') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="e.g. Hiking, Cooking, Photography (comma separated)">
                </div>

                {{-- Interests --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Interests</label>
                    <input type="text" name="interests" value="{{ old('interests') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="e.g. Music, Travel, Anime (comma separated)">
                </div>

                {{-- Bio --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">About You</label>
                    <textarea name="bio" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition resize-none"
                        placeholder="Tell potential matches about yourself...">{{ old('bio') }}</textarea>
                </div>

                <button type="submit" class="w-full btn-primary text-lg py-4">
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
