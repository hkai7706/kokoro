<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        if ($user->hasCompletedProfile()) {
            return redirect()->route('home');
        }
        $prefectures = $this->getPrefectures();
        return view('profile-create', compact('user', 'prefectures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:99',
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string|max:255',
            'prefecture' => 'nullable|string|max:255',
            'hobbies' => 'nullable|string|max:1000',
            'interests' => 'nullable|string|max:1000',
            'bio' => 'nullable|string|max:2000',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $user = auth()->user();
        $user->update(['name' => $request->name]);

        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profiles', 'public');
        }

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'age' => $request->age,
                'gender' => $request->gender,
                'location' => $request->location,
                'prefecture' => $request->prefecture,
                'hobbies' => $request->hobbies,
                'interests' => $request->interests,
                'bio' => $request->bio,
                'profile_photo' => $photoPath,
                'is_complete' => true,
                'last_active_at' => now(),
            ]
        );

        return redirect()->route('home')->with('success', 'Profile created! Start matching now.');
    }

    public function show()
    {
        $user = auth()->user()->load('profile');
        $prefectures = $this->getPrefectures();
        return view('profile', compact('user', 'prefectures'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:99',
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string|max:255',
            'prefecture' => 'nullable|string|max:255',
            'hobbies' => 'nullable|string|max:1000',
            'interests' => 'nullable|string|max:1000',
            'bio' => 'nullable|string|max:2000',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $user = auth()->user();
        $user->update(['name' => $request->name]);

        $data = $request->only(['age', 'gender', 'location', 'prefecture', 'hobbies', 'interests', 'bio']);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($user->profile && $user->profile->profile_photo) {
                Storage::disk('public')->delete($user->profile->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $data['is_complete'] = true;
        $data['last_active_at'] = now();

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return back()->with('success', 'Profile updated successfully!');
    }

    public function viewUser($id)
    {
        $user = \App\Models\User::with('profile')->findOrFail($id);
        $currentUser = auth()->user();
        $isMatched = $currentUser->isMatchedWith($user->id);
        $hasLiked = $currentUser->hasLiked($user->id);

        return view('user-profile', compact('user', 'isMatched', 'hasLiked'));
    }

    public function getPrefectures(): array
    {
        return [
            'Hokkaido', 'Aomori', 'Iwate', 'Miyagi', 'Akita', 'Yamagata', 'Fukushima',
            'Ibaraki', 'Tochigi', 'Gunma', 'Saitama', 'Chiba', 'Tokyo', 'Kanagawa',
            'Niigata', 'Toyama', 'Ishikawa', 'Fukui', 'Yamanashi', 'Nagano',
            'Gifu', 'Shizuoka', 'Aichi', 'Mie',
            'Shiga', 'Kyoto', 'Osaka', 'Hyogo', 'Nara', 'Wakayama',
            'Tottori', 'Shimane', 'Okayama', 'Hiroshima', 'Yamaguchi',
            'Tokushima', 'Kagawa', 'Ehime', 'Kochi',
            'Fukuoka', 'Saga', 'Nagasaki', 'Kumamoto', 'Oita', 'Miyazaki', 'Kagoshima', 'Okinawa',
        ];
    }
}
