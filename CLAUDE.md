# KOKORO - Partner Matching Platform

## Project Overview
KOKORO is a partner-matching web application built for the Japanese market. Users create profiles, browse/search for potential matches, like each other, and chat when mutually matched.

## Tech Stack
- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade templates, Tailwind CSS (CDN), Vanilla JS
- **Database:** SQLite (default), PostgreSQL/Supabase (optional)
- **Build:** Vite 7, laravel-vite-plugin
- **Font:** Plus Jakarta Sans via fonts.bunny.net
- **Deployment:** Railway (PostgreSQL + HTTPS via proxy)

## Quick Start
```bash
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

## Default Accounts
- **Admin:** hkai7706@gmail.com / 000000
- **Demo users:** sakura@demo.com, kenji@demo.com, yuki@demo.com, takeshi@demo.com, mika@demo.com, ryu@demo.com (all password: password123)

## Project Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php      # Login, register, logout (specific error: no account / wrong password)
│   │   ├── PasswordResetController.php # Forgot password, reset password with token
│   │   ├── HomeController.php      # Home feed, search with filters
│   │   ├── ProfileController.php   # Profile CRUD, view other users
│   │   ├── MatchController.php     # Like/unlike, block/report, who-liked-me
│   │   ├── MessageController.php   # Inbox, conversation, AJAX send, polling
│   │   └── AdminController.php     # Dashboard, user/report/match management
│   ├── Middleware/
│   │   ├── AdminMiddleware.php         # Admin-only route guard
│   │   ├── EnsureProfileComplete.php   # Forces profile completion
│   │   ├── CheckBanned.php             # Blocks banned users
│   │   ├── ForceHttps.php              # HTTP→HTTPS redirect (non-local envs)
│   │   └── SecurityHeaders.php         # CSP, X-Frame-Options, etc.
│   └── Providers/
│       └── AppServiceProvider.php      # URL::forceScheme('https') for non-local
├── Models/
│   ├── User.php        # Core user with roles, matching methods, compatibility algorithm
│   ├── Profile.php     # Age, gender, location, prefecture, hobbies, interests, bio, photo
│   ├── Like.php        # sender_id → receiver_id
│   ├── UserMatch.php   # user1_id ↔ user2_id (table: "matches")
│   ├── Message.php     # sender_id → receiver_id, read_at tracking
│   ├── Block.php       # user_id → blocked_user_id
│   ├── Report.php      # reporter_id → reported_user_id, status workflow
│   ├── Notification.php
│   └── AdminLog.php
resources/views/
├── layouts/
│   ├── app.blade.php       # Main layout: sidebar, dark mode, ENG/JP toggle
│   └── admin.blade.php     # Admin layout
├── landing.blade.php       # Public landing page (SEO, testimonials, 3-step flow)
├── auth.blade.php          # Login/register (standalone, own lang toggle, show/hide password)
├── auth-verify-email.blade.php  # Email verification notice page
├── auth-forgot-password.blade.php # Forgot password form
├── auth-reset-password.blade.php  # Reset password form (with token)
├── errors/
│   └── 404.blade.php       # Custom 404 page (bilingual, KOKORO-branded)
├── home.blade.php          # Activity hub: 4 mini games (Top Top style), articles, profiles
├── search.blade.php        # Search with filters (prefecture, gender, age range)
├── profile.blade.php       # Edit own profile (horizontal photo layout)
├── profile-create.blade.php # First-time profile setup (progress dots, guidance)
├── user-profile.blade.php  # View other user (like/unlike, block/report, compat score)
├── liked.blade.php         # Profiles user has liked
├── who-liked-me.blade.php  # Profiles that liked user
├── messages/
│   ├── inbox.blade.php         # Conversation list (unread highlights, chevrons)
│   └── conversation.blade.php  # Chat UI with AJAX send + polling
└── admin/                  # Admin views (dashboard, users, reports, matches, messages)
```

## Key Architecture Decisions

### Compatibility Algorithm (User::compatibilityWith)
- Hobbies matching: 40% weight
- Interests matching: 40% weight
- Prefecture proximity: 10% weight
- Age proximity: 10% weight
- Returns 0-100 score

### ENG/JP Translation System
- All text uses `data-en` / `data-jp` attributes on HTML elements
- Placeholders use `data-placeholder-en` / `data-placeholder-jp`
- `applyLanguage(lang)` in layouts/app.blade.php swaps all text content
- Auth page has its own standalone `applyAuthLang()` since it doesn't use the layout
- Language preference stored in `localStorage` key `kokoro-lang`

### Prefecture → City Cascading Dropdown
- Both `profile-create.blade.php` and `profile.blade.php` use a cascading select: user picks prefecture first, then city populates
- `prefectureCities` JS object maps all 47 prefectures to their major cities
- `updateCityDropdown()` function populates city `<select>` based on selected prefecture
- Shows "Please select a prefecture first" hint if user clicks city before choosing prefecture
- Supports `old()` value restoration on validation failure
- City is stored in `location` field, prefecture in `prefecture` field

### Login Error Messages
- `AuthController@login` checks if email exists before attempting auth
- Non-existent email: "There is no account with this email. Please sign up first."
- Wrong password: "The password does not match our records."

### Show/Hide Password
- Auth page (`auth.blade.php`) has eye icon toggle on all 3 password fields (login, register, confirm)
- `togglePassword(inputId, btn)` JS function switches input type between password/text
- Uses two SVG icons: eye-open (visible) and eye-closed (hidden), toggled via CSS `hidden` class

### Dark Mode
- Tailwind `darkMode: 'class'` configuration
- Toggle via `localStorage` key `kokoro-dark-mode`
- Pre-render script prevents flash of wrong theme

### HTTPS / SSL
- **ForceHttps middleware** (`app/Http/Middleware/ForceHttps.php`): Redirects HTTP→HTTPS on non-local environments
- **AppServiceProvider**: Forces `URL::forceScheme('https')` when not local, also checks `X-Forwarded-Proto` header and `APP_URL` config
- **TrustProxies**: Configured with `at: '*'` in `bootstrap/app.php` to trust Railway's load balancer
- Middleware registered in `bootstrap/app.php` via `$middleware->web(prepend: [ForceHttps::class])`

### Messaging System
- **AJAX send**: `conversation.blade.php` sends messages via `fetch()` POST with JSON body (no page reload)
- **Optimistic UI**: Message appears instantly in chat before server confirms
- **Polling**: `/messages/{userId}/new?after={lastMsgId}` polled every 5 seconds for new incoming messages
- **Read receipts**: Double checkmark (✓✓) shown for read messages
- **XSS protection**: Messages escaped via `e()` helper server-side, and `replace()` for HTML entities client-side

### Rate Limiting
- Auth routes: 5 requests/minute
- Like action: 60/hour
- Message send: 30/minute
- Message polling: 20/minute

### Mini Games (Top Top Style)
All games are client-side JavaScript in `home.blade.php`. No backend routes needed.

1. **Love Quiz** — 5-question personality quiz with gradient answer buttons (A/B/C/D), correct/wrong visual feedback (green flash / red shake), progress dots, confetti on completion
2. **Love Fortune** — Tap-to-reveal fortune card with animated flip, gradient backgrounds per fortune level, sparkle effects
3. **Emoji Match** — Memory card game with CSS 3D flip animation (perspective, backface-visibility, rotateY), timer, move counter, star rating (1-3 stars based on performance), glow effect on matches
4. **Heart Catcher** (NEW) — Tap game where hearts/emojis fall from the top. 30-second timer with visual countdown bar, score counter, combo multiplier system (3x/5x/10x), bad emojis that subtract points, increasing difficulty. Top Top-inspired gameplay.

### Articles System
- 3 articles with gradient banner headers, category pill badges, reading time estimates
- Article modals with frosted glass close button, numbered/icon step layouts
- Content covers: first date tips, communication in relationships, self-improvement

## Database
- **Connection:** SQLite at `database/database.sqlite` (local), PostgreSQL on Railway (production)
- **Migrations:** `database/migrations/` (11 migration files)
- **Seeder:** `database/seeders/DatabaseSeeder.php` creates admin + 6 demo users with profiles

## Routes Summary
| Method | URI | Controller | Key middleware |
|--------|-----|------------|----------------|
| GET | / | Landing page | - |
| GET/POST | /auth, /login, /register | AuthController | throttle |
| GET | /email/verify | verification.notice | auth |
| GET | /email/verify/{id}/{hash} | verification.verify | auth, signed |
| POST | /email/verification-notification | verification.send | auth, throttle |
| GET/POST | /forgot-password | PasswordResetController | throttle |
| GET | /reset-password/{token} | PasswordResetController@showResetForm | - |
| POST | /reset-password | PasswordResetController@resetPassword | - |
| GET | /home | HomeController@index | auth, CheckBanned |
| GET | /search | HomeController@search | auth, CheckBanned |
| GET | /profile | ProfileController@show | auth |
| PUT | /profile | ProfileController@update | auth |
| GET | /user/{id} | ProfileController@viewUser | auth |
| POST | /like, /unlike, /skip | MatchController | auth, throttle |
| GET | /liked | MatchController@liked | auth |
| GET | /who-liked-me | MatchController@whoLikedMe | auth |
| POST | /block, /unblock, /report | MatchController | auth, throttle |
| GET | /messages | MessageController@inbox | auth |
| GET | /messages/{userId} | MessageController@conversation | auth |
| POST | /messages/{userId} | MessageController@send | auth, throttle |
| GET | /messages/{userId}/new | MessageController@getNewMessages | auth, throttle |
| GET | /admin/* | AdminController | AdminMiddleware |

## Security
- CSRF protection on all POST routes
- XSS sanitization via `e()` helper in messages
- SecurityHeaders middleware (CSP, X-Frame-Options, X-Content-Type-Options, etc.)
- ForceHttps middleware for non-local environments
- TrustProxies configured for Railway load balancer
- Bcrypt password hashing (12 rounds)
- Banned user middleware check on every authenticated request
- Rate limiting on auth, likes, messages, and polling

## Design System (v2 — Clean & Modern)

### Color Palette
- **Primary:** Tailwind's built-in `rose-500` (`#e11d48`) — no custom colors in tailwind config
- **Accent colors:** `emerald` (success/matched), `amber` (warnings), `violet` (interests/messages), `red` (destructive)
- **Game gradients:** rose→pink (Quiz), violet→indigo (Fortune), amber→orange (Emoji Match), emerald→teal (Heart Catcher)
- **Neutral:** Tailwind's `gray` scale
- **Dark mode body:** `gray-950`

### CSS Classes (defined in `layouts/app.blade.php`)
| Class | Purpose |
|-------|---------|
| `.card` | White bg, 1px gray border, 1rem radius, hover shadow |
| `.btn` | Base button: inline-flex, centered, 0.625rem radius, semibold |
| `.btn-rose` | Primary: rose-500 bg, white text |
| `.btn-outline` | Transparent bg, 1.5px gray border |
| `.btn-ghost` | Gray-100 bg, subtle |
| `.btn-sm` | Smaller: 0.75rem font, 0.375rem 0.875rem padding |
| `.tag` | Pill tag: 0.75rem font, 0.375rem 0.75rem padding, rounded-md |
| `.sidebar-link` | Nav link with active state (rose-50 bg, rose-500 text) |
| `.mobile-nav-item` | Bottom nav item, 0.6875rem font |
| `.animate-in` | fadeInUp animation, 0.4s ease-out |

### Game-Specific CSS (defined in `home.blade.php`)
| Animation | Purpose |
|-----------|---------|
| `@keyframes float` | Gentle up/down bobbing for game card icons |
| `@keyframes shake` | Wrong answer feedback in Love Quiz |
| `@keyframes popIn` | Scale-up entrance for fortune reveal |
| `@keyframes confetti-fall` | Falling confetti particles on game completion |
| `@keyframes heartFloat` | Hearts falling from top in Heart Catcher |
| `.game-card` | Gradient bg, rounded-2xl, hover lift, cursor pointer |
| `.flip-card` | 3D perspective container for Emoji Match cards |
| `.flip-card-inner` | Transform-style preserve-3d, transition rotateY |

### Design Principles
- **Minimal gradients** in layout — solid backgrounds with subtle tints
- **Rich gradients** in games — colorful, playful, Top Top-inspired
- **Clean white header** with border (not colored)
- **Consistent border-radius:** cards 1rem, buttons 0.625rem, inputs 0.75rem (rounded-xl)
- **Subtle shadows** on hover only (layout), bold shadows in games
- **No custom Tailwind colors** — uses built-in rose, violet, emerald, amber, etc.

### Landing Page (`landing.blade.php`)
- Standalone page (not using app layout), own Tailwind config
- Uses `rose-500` for all primary elements (buttons, accents, icons)
- Simplified hero: "Real people. Real connections."
- 3-step how-it-works, feature cards, testimonials, stats, CTA, footer
- Cookie consent banner

### View-Specific UI Patterns
- **profile.blade.php**: Horizontal photo+description layout, comma-separated hobby helper text
- **profile-create.blade.php**: Progress indicator dots (step 1 of 2), motivating copy, reassurance text, cascading Prefecture→City dropdown
- **profile.blade.php**: Cascading Prefecture→City dropdown (same as profile-create), horizontal photo layout
- **auth.blade.php**: Show/hide password toggle (eye icon) on all password fields
- **inbox.blade.php**: Conversation count subtitle, ring-2 highlight on unread avatars, chevron arrows
- **conversation.blade.php**: Compact header, partner name links to profile, optimistic message UI
- **user-profile.blade.php**: Contextual status hints after actions, compatibility explanation text

## Conventions
- **Naming:** Routes use dot notation (`who.liked.me`, `messages.inbox`)
- **Views:** kebab-case filenames (`who-liked-me.blade.php`)
- **CSS:** Tailwind utility classes + design system classes (`.card`, `.btn`, `.btn-rose`, `.btn-outline`, `.btn-ghost`, `.btn-sm`, `.tag`, `.sidebar-link`, `.animate-in`)
- **Dark mode:** All views use `dark:` Tailwind variants, body bg `gray-950`
- **Translations:** Every user-facing text element has `data-en`/`data-jp` attributes
- **Forms:** Laravel `@csrf` and `@method` directives, inputs use `rounded-xl` with `focus:ring-2 focus:ring-rose-200 focus:border-rose-400`
- **Photos:** Stored in `storage/app/public/profile_photos/`, accessed via `asset('storage/...')`
- **Documentation:** Update both `CLAUDE.md` and `PROJECT.md` for every fix/feature

## Deployment
- **Procfile** present for Railway deployment
- Run `php artisan migrate --force` and `php artisan storage:link` on deploy
- Set `APP_ENV=production`, `APP_DEBUG=false` in production
- Railway terminates SSL at proxy level — ForceHttps middleware + TrustProxies handle this
