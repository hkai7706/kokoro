<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// List users
$users = App\Models\User::all();
echo "=== USERS ===\n";
foreach($users as $u) {
    echo $u->id . ' | ' . $u->email . ' | ' . $u->role . ' | ' . $u->status . "\n";
}
echo 'Total: ' . $users->count() . "\n\n";

// Test auth login
$user = App\Models\User::where('role', 'user')->first();
if ($user) {
    Auth::login($user);
    echo "Logged in as: " . $user->name . " (id=" . $user->id . ")\n";

    // Test compatibility
    $other = App\Models\User::where('role', 'user')->where('id', '!=', $user->id)->first();
    if ($other) {
        $score = $user->compatibilityWith($other);
        echo "Compatibility with " . $other->name . ": " . $score . "%\n";
    }

    // Test hasBlocked
    echo "Has blocked user 2: " . ($user->hasBlocked(2) ? 'yes' : 'no') . "\n";
    echo "Has liked user 2: " . ($user->hasLiked(2) ? 'yes' : 'no') . "\n";
    echo "Unread messages: " . $user->unreadMessagesCount() . "\n";
} else {
    echo "No regular users found\n";
}
