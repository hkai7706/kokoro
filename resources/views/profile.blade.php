@extends('layouts.app')
@section('title', 'My Profile - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-extrabold mb-6">My Profile</h1>

    <div class="bg-white rounded-3xl shadow-xl p-8 animate-fade-in-up">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                {{-- Photo --}}
                <div class="text-center">
                    <div class="relative inline-block">
                        <div id="photo-preview" class="w-32 h-32 rounded-full bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center overflow-hidden border-4 border-kokoro-yellow shadow-lg mx-auto">
                            @if($user->profile && $user->profile->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-pink-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            @endif
                        </div>
                        <label class="absolute bottom-0 right-0 bg-primary text-white rounded-full w-10 h-10 flex items-center justify-center cursor-pointer shadow-lg hover:bg-primary-dark transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <input type="file" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Display Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Age</label>
                        <input type="number" name="age" value="{{ old('age', $user->profile->age ?? '') }}" min="18" max="99" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gender</label>
                        <select name="gender" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                            <option value="male" {{ old('gender', $user->profile->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->profile->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $user->profile->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">City / Location</label>
                        <input type="text" name="location" value="{{ old('location', $user->profile->location ?? '') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Prefecture</label>
                        <select name="prefecture" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition">
                            <option value="">Select</option>
                            @foreach($prefectures as $pref)
                                <option value="{{ $pref }}" {{ old('prefecture', $user->profile->prefecture ?? '') === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Hobbies</label>
                    <input type="text" name="hobbies" value="{{ old('hobbies', $user->profile->hobbies ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Hiking, Cooking, Photography">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Interests</label>
                    <input type="text" name="interests" value="{{ old('interests', $user->profile->interests ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Music, Travel, Anime">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">About You</label>
                    <textarea name="bio" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition resize-none"
                        placeholder="Tell others about yourself...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                </div>

                <button type="submit" class="w-full btn-primary text-lg py-4">Save Changes</button>
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
