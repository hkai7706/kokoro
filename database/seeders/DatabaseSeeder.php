<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin
        $admin = User::firstOrCreate(
            ['email' => 'hkai7706@gmail.com'],
            [
                'name' => 'Felikz',
                'password' => bcrypt('000000'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // Create demo users for testing
        $demoUsers = [
            ['name' => 'Sakura Tanaka', 'email' => 'sakura@demo.com', 'gender' => 'female', 'age' => 25, 'location' => 'Shibuya', 'prefecture' => 'Tokyo', 'bio' => 'Love hiking and photography. Looking for someone who enjoys the outdoors!', 'hobbies' => 'Hiking, Photography, Cooking', 'interests' => 'Nature, Art, Music'],
            ['name' => 'Kenji Yamamoto', 'email' => 'kenji@demo.com', 'gender' => 'male', 'age' => 28, 'location' => 'Shinjuku', 'prefecture' => 'Tokyo', 'bio' => 'Software engineer who loves ramen and gaming. Let\'s explore Tokyo together!', 'hobbies' => 'Gaming, Ramen, Running', 'interests' => 'Technology, Food, Travel'],
            ['name' => 'Yuki Sato', 'email' => 'yuki@demo.com', 'gender' => 'female', 'age' => 23, 'location' => 'Namba', 'prefecture' => 'Osaka', 'bio' => 'University student studying art. I love visiting galleries and trying new cafes.', 'hobbies' => 'Drawing, Cafe hopping, Reading', 'interests' => 'Art, Literature, Coffee'],
            ['name' => 'Takeshi Honda', 'email' => 'takeshi@demo.com', 'gender' => 'male', 'age' => 30, 'location' => 'Gion', 'prefecture' => 'Kyoto', 'bio' => 'Traditional tea ceremony instructor. I appreciate Japanese culture and mindfulness.', 'hobbies' => 'Tea ceremony, Meditation, Calligraphy', 'interests' => 'Culture, History, Zen'],
            ['name' => 'Mika Suzuki', 'email' => 'mika@demo.com', 'gender' => 'female', 'age' => 26, 'location' => 'Tenjin', 'prefecture' => 'Fukuoka', 'bio' => 'Foodie and travel enthusiast. Always planning my next adventure!', 'hobbies' => 'Traveling, Cooking, Yoga', 'interests' => 'Food, Wellness, Adventure'],
            ['name' => 'Ryu Nakamura', 'email' => 'ryu@demo.com', 'gender' => 'male', 'age' => 27, 'location' => 'Chatan', 'prefecture' => 'Okinawa', 'bio' => 'Surfing instructor living the island life. Looking for someone to share sunsets with.', 'hobbies' => 'Surfing, Diving, Music', 'interests' => 'Ocean, Sports, Festivals'],
        ];

        foreach ($demoUsers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password123'),
                    'role' => 'user',
                    'status' => 'active',
                ]
            );

            Profile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'age' => $data['age'],
                    'gender' => $data['gender'],
                    'location' => $data['location'],
                    'prefecture' => $data['prefecture'],
                    'bio' => $data['bio'],
                    'hobbies' => $data['hobbies'],
                    'interests' => $data['interests'],
                    'is_complete' => true,
                    'last_active_at' => now()->subMinutes(rand(0, 120)),
                ]
            );
        }

        echo "Seeded: Admin (hkai7706@gmail.com / 000000)\n";
        echo "Seeded: 6 demo users (password: password123)\n";
    }
}
