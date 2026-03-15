# KOKORO - Partner Matching Platform

## Project Overview
KOKORO is a partner-matching web application built for the Japanese market. Users create profiles, browse/search for potential matches, like each other, and chat when mutually matched.

## Tech Stack
- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade templates, Tailwind CSS (CDN), Vanilla JS
- **Database:** SQLite (default), PostgreSQL/Supabase (optional)
- **Build:** Vite 7, laravel-vite-plugin
- **Font:** Plus Jakarta Sans via fonts.bunny.net

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
│   │   ├── AuthController.php      # Login, register, logout
│   │   ├── HomeController.php      # Home feed, search with filters
│   │   ├── ProfileController.php   # Profile CRUD, view other users
│   │   ├── MatchController.php     # Like/unlike, block/report, who-liked-me
│   │   ├── MessageController.php   # Inbox, conversation, send, polling
│   │   └── AdminController.php     # Dashboard, user/report/match management
│   └── Middleware/
│       ├── AdminMiddleware.php         # Admin-only route guard
│       ├── EnsureProfileComplete.php   # Forces profile completion
│       ├── CheckBanned.php             # Blocks banned users
│       └── SecurityHeaders.php         # CSP, X-Frame-Options, etc.
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
├── landing.blade.php       # Public landing page (SEO, testimonials)
├── auth.blade.php          # Login/register (standalone, own lang toggle)
├── home.blade.php          # Activity hub: mini games, blog, news, suggested profiles
├── search.blade.php        # Search with filters (prefecture, gender, age range)
├── profile.blade.php       # Edit own profile
├── profile-create.blade.php # First-time profile setup
├── user-profile.blade.php  # View other user (like/unlike, block/report, compat score)
├── liked.blade.php         # Profiles user has liked
├── who-liked-me.blade.php  # Profiles that liked user
├── messages/
│   ├── inbox.blade.php         # Conversation list
│   └── conversation.blade.php  # Chat UI with polling
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

### Dark Mode
- Tailwind `darkMode: 'class'` configuration
- Toggle via `localStorage` key `kokoro-dark-mode`
- Pre-render script prevents flash of wrong theme

### Message Polling
- `conversation.blade.php` polls `/messages/{userId}/new?after={lastMsgId}` every 5 seconds
- New messages appended to DOM without page reload

### Rate Limiting
- Auth routes: 5 requests/minute
- Like action: 60/hour
- Message send: 30/minute

## Database
- **Connection:** SQLite at `database/database.sqlite`
- **Migrations:** `database/migrations/` (11 migration files)
- **Seeder:** `database/seeders/DatabaseSeeder.php` creates admin + 6 demo users with profiles

## Routes Summary
| Method | URI | Controller | Key middleware |
|--------|-----|------------|----------------|
| GET | / | Landing page | - |
| GET/POST | /auth, /login, /register | AuthController | throttle |
| GET | /home | HomeController@index | auth, CheckBanned |
| GET | /search | HomeController@search | auth, CheckBanned |
| GET | /profile | ProfileController@show | auth |
| GET | /user/{id} | ProfileController@viewUser | auth |
| POST | /like, /unlike | MatchController | auth, throttle |
| GET | /who-liked-me | MatchController@whoLikedMe | auth |
| POST | /block, /unblock, /report | MatchController | auth |
| GET | /messages | MessageController@inbox | auth |
| GET/POST | /messages/{userId} | MessageController | auth |
| GET | /admin/* | AdminController | AdminMiddleware |

## Security
- CSRF protection on all POST routes
- XSS sanitization via `e()` helper in messages
- SecurityHeaders middleware (CSP, X-Frame-Options, X-Content-Type-Options, etc.)
- Bcrypt password hashing (12 rounds)
- Banned user middleware check on every authenticated request

## Design System (v2 — Clean & Modern)

### Color Palette
- **Primary:** Tailwind's built-in `rose-500` (`#e11d48`) — no custom colors in tailwind config
- **Accent colors:** `emerald` (success/matched), `amber` (warnings), `violet` (interests/messages), `red` (destructive)
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

### Design Principles
- **Minimal gradients** — solid backgrounds with subtle tints instead
- **Clean white header** with border (not colored)
- **Consistent border-radius:** cards 1rem, buttons 0.625rem, inputs 0.75rem (rounded-xl)
- **Subtle shadows** on hover only
- **No custom Tailwind colors** — uses built-in rose, violet, emerald, amber, etc.

### Landing Page (`landing.blade.php`)
- Standalone page (not using app layout), own Tailwind config
- Uses `rose-500` for all primary elements (buttons, accents, icons)
- No custom color definitions — built-in Tailwind only
- Subtle hero gradient: `bg-gradient-to-b from-rose-50/50 to-white`
- CTA section: `bg-rose-50` (not gradient)

## Conventions
- **Naming:** Routes use dot notation (`who.liked.me`, `messages.inbox`)
- **Views:** kebab-case filenames (`who-liked-me.blade.php`)
- **CSS:** Tailwind utility classes + design system classes (`.card`, `.btn`, `.btn-rose`, `.btn-outline`, `.btn-ghost`, `.btn-sm`, `.tag`, `.sidebar-link`, `.animate-in`)
- **Dark mode:** All views use `dark:` Tailwind variants, body bg `gray-950`
- **Translations:** Every user-facing text element has `data-en`/`data-jp` attributes
- **Forms:** Laravel `@csrf` and `@method` directives, inputs use `rounded-xl` with `focus:ring-2 focus:ring-rose-200 focus:border-rose-400`
- **Photos:** Stored in `storage/app/public/profile_photos/`, accessed via `asset('storage/...')`

## Deployment
- **Procfile** present for Railway deployment
- Run `php artisan migrate --force` and `php artisan storage:link` on deploy
- Set `APP_ENV=production`, `APP_DEBUG=false` in production
