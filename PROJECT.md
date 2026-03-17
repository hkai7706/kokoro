# KOKORO — Full Project Documentation

## What is KOKORO?
KOKORO is a bilingual (English/Japanese) partner-matching web application targeting the Japanese market. Users register, create a profile, discover potential matches, like each other, and chat when mutually matched. It includes an admin panel for user/report management.

---

## Directory Structure & File Map

### Root Files
| File | Purpose |
|------|---------|
| `CLAUDE.md` | AI assistant context — project overview, conventions, architecture notes |
| `PROJECT.md` | This file — full project documentation and file map |
| `README.md` | Basic Laravel readme |
| `SETUP.md` | Setup/deployment instructions |
| `Procfile` | Railway deployment command (`web: php artisan serve ...`) |
| `nixpacks.toml` | Railway Nixpacks build configuration |
| `composer.json` | PHP dependencies (Laravel 12, etc.) |
| `package.json` | Node dependencies (Vite, laravel-vite-plugin) |
| `vite.config.js` | Vite build config for Laravel assets |
| `phpunit.xml` | Test configuration |
| `.env` / `.env.example` | Environment variables (DB, app key, etc.) |
| `artisan` | Laravel CLI entry point |

### `bootstrap/` — Application Bootstrap
| File | Purpose |
|------|---------|
| `app.php` | Creates the Laravel Application instance. Configures routing (web + console), middleware stack (ForceHttps prepended, SecurityHeaders appended, TrustProxies), and exception handling. |
| `providers.php` | Registers service providers (AppServiceProvider) |

### `config/` — Configuration
Standard Laravel config files. Key customizations:
- `database.php` — SQLite default, PostgreSQL for production
- `filesystems.php` — Public disk for profile photo storage
- `session.php` — Session driver configuration

### `app/Http/Controllers/` — Request Handlers

| Controller | Routes | Purpose |
|------------|--------|---------|
| `AuthController.php` | `/auth`, `/login`, `/register`, `/logout` | Handles login form display, login validation (specific errors: no account vs wrong password), user registration with bcrypt hashing, and session logout |
| `HomeController.php` | `/home`, `/search` | Home page (passes suggested profiles to view), search with filters (prefecture, gender, age range, keyword) |
| `ProfileController.php` | `/profile/*`, `/user/{id}` | Profile CRUD (create, show, update), view other users with compatibility score calculation |
| `MatchController.php` | `/like`, `/unlike`, `/skip`, `/liked`, `/who-liked-me`, `/block`, `/unblock`, `/report` | Like/unlike users (creates mutual match if reciprocal), skip profiles, view likes given/received, block/unblock users, file reports |
| `MessageController.php` | `/messages`, `/messages/{userId}`, `/messages/{userId}/new` | Inbox listing with last message + unread count, conversation view with read receipt marking, AJAX message send (returns JSON), polling endpoint for new messages |
| `AdminController.php` | `/admin/*` | Admin dashboard (stats), user management (ban/unban/delete), report review/resolve, match listing, message overview |

### `app/Http/Middleware/` — Request Filters

| Middleware | Applied To | Purpose |
|------------|-----------|---------|
| `ForceHttps.php` | All web routes (prepended) | Redirects HTTP to HTTPS on non-local environments. Works with Railway's SSL termination proxy. |
| `SecurityHeaders.php` | All web routes (appended) | Adds CSP, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy headers |
| `AdminMiddleware.php` | `/admin/*` routes | Checks `user->isAdmin()`, redirects to admin login if not admin |
| `EnsureProfileComplete.php` | Authenticated user routes | Redirects to `/profile/create` if user has no profile record |
| `CheckBanned.php` | Authenticated user routes | Logs out and shows error if `user->is_banned` is true |

### `app/Models/` — Eloquent Models

| Model | Table | Key Fields | Relationships |
|-------|-------|------------|---------------|
| `User.php` | `users` | name, email, password, role, is_banned | hasOne Profile, hasMany Likes/Messages/Blocks/Reports. Contains `compatibilityWith()` algorithm, `isMatchedWith()`, `hasBlocked()`, `getAllMatches()`, `isAdmin()` |
| `Profile.php` | `profiles` | user_id, age, gender, prefecture, location, hobbies, interests, bio, profile_photo, last_active_at | belongsTo User |
| `Like.php` | `likes` | sender_id, receiver_id | belongsTo User (sender, receiver) |
| `UserMatch.php` | `matches` | user1_id, user2_id | belongsTo User (user1, user2). `getPartner($userId)` returns the other user |
| `Message.php` | `messages` | sender_id, receiver_id, message, read_at | belongsTo User (sender, receiver) |
| `Block.php` | `blocks` | user_id, blocked_user_id | belongsTo User |
| `Report.php` | `reports` | reporter_id, reported_user_id, reason, details, status, admin_notes | belongsTo User (reporter, reported) |
| `Notification.php` | `notifications` | user_id, type, content, read_at | belongsTo User |
| `AdminLog.php` | `admin_logs` | admin_id, action, target_type, target_id, details | belongsTo User (admin) |

### `app/Providers/`
| File | Purpose |
|------|---------|
| `AppServiceProvider.php` | Forces HTTPS scheme for URL generation on non-local environments. Checks `X-Forwarded-Proto` header and `APP_URL` config as fallbacks. |

### `database/migrations/` — Schema Definitions
Migrations run in order to create all tables:

1. `create_users_table` — id, name, email, password, role (default 'user'), is_banned, timestamps
2. `create_cache_table` — Laravel cache store
3. `create_jobs_table` — Laravel queue jobs
4. `create_profiles_table` — user_id (FK), age, gender, prefecture, location, hobbies, interests, bio, profile_photo, last_active_at
5. `create_likes_table` — sender_id, receiver_id (both FK to users), unique constraint
6. `create_matches_table` — user1_id, user2_id (both FK to users), unique constraint
7. `create_messages_table` — sender_id, receiver_id (FK), message text, read_at nullable
8. `create_reports_table` — reporter_id, reported_user_id (FK), reason, details, status, admin_notes
9. `create_blocks_table` — user_id, blocked_user_id (FK), unique constraint
10. `create_notifications_table` — user_id (FK), type, content, read_at
11. `create_admin_logs_table` — admin_id (FK), action, target_type, target_id, details
12. `add_indexes_and_details_column` — Performance indexes on likes, messages, matches

### `database/seeders/`
| File | Purpose |
|------|---------|
| `DatabaseSeeder.php` | Creates 1 admin user + 6 demo users with complete profiles (ages 22-30, various prefectures, hobbies, interests). Used for development and demo. |

### `routes/`
| File | Purpose |
|------|---------|
| `web.php` | All HTTP routes organized in 3 groups: Public (landing, auth), Authenticated (home, profile, matching, messages), Admin (dashboard, management). See Routes Summary in CLAUDE.md. |
| `console.php` | Artisan console commands (empty by default) |

### `resources/views/` — Blade Templates

#### Layouts
| View | Used By | Purpose |
|------|---------|---------|
| `layouts/app.blade.php` | All authenticated pages | Main layout with sidebar navigation (desktop), bottom nav (mobile), dark mode toggle, ENG/JP language toggle, notification indicator. Defines CSS design system classes (.card, .btn, .tag, etc.) and `applyLanguage()` JS function. |
| `layouts/admin.blade.php` | All admin pages | Admin layout with sidebar nav (Dashboard, Users, Matches, Reports, Messages), admin-specific styling |

#### Public Pages
| View | Route | Purpose |
|------|-------|---------|
| `landing.blade.php` | `/` (unauthenticated) | Standalone landing page. Hero section ("Real people. Real connections."), 3-step how-it-works, feature cards, testimonials, stats counter, CTA, footer, cookie consent. Own Tailwind config, doesn't use app layout. |
| `auth.blade.php` | `/auth` | Login/register toggle form. Standalone page with own language toggle (`applyAuthLang()`). Show/hide password toggle (eye icon) on all password fields. Handles both login and registration in a single view. |

#### Authenticated User Pages
| View | Route | Purpose |
|------|-------|---------|
| `home.blade.php` | `/home` | **Activity hub** — 4 interactive mini games (Top Top style with gradient cards, animations), 3 articles with gradient banners, suggested profiles carousel. Games: Love Quiz, Love Fortune, Emoji Match, Heart Catcher. All game logic is client-side JS. |
| `search.blade.php` | `/search` | Search/filter users by prefecture, gender, age range, keyword. Displays profile cards in a grid. |
| `profile.blade.php` | `/profile` | Edit own profile. Horizontal photo+description layout, cascading Prefecture→City dropdown, helper text for hobbies field, success message display. |
| `profile-create.blade.php` | `/profile/create` | First-time profile creation. Progress dots (step indicator), cascading Prefecture→City dropdown, motivating copy ("Profiles with photos get 5x more likes"), reassurance text. |
| `user-profile.blade.php` | `/user/{id}` | View another user's profile. Shows compatibility score with explanation, like/unlike buttons with contextual hints ("You're matched!" or "Waiting for them..."), block/report modal. |
| `liked.blade.php` | `/liked` | Grid of profiles the user has liked. Shows match status. |
| `who-liked-me.blade.php` | `/who-liked-me` | Grid of users who liked the current user. Like-back button. |

#### Message Views
| View | Route | Purpose |
|------|-------|---------|
| `messages/inbox.blade.php` | `/messages` | Conversation list sorted by last message time. Shows partner avatar (ring highlight if unread), last message preview, unread count badge, conversation count subtitle. |
| `messages/conversation.blade.php` | `/messages/{userId}` | Chat UI. Compact header with back arrow + partner info (links to profile). Message bubbles (rose for sent, white for received). AJAX send via fetch() with optimistic UI. Polls for new messages every 5s. Read receipts (✓✓). Report/block in menu. |

#### Admin Views
| View | Route | Purpose |
|------|-------|---------|
| `admin/login.blade.php` | `/admin/login` | Admin-specific login form |
| `admin/dashboard.blade.php` | `/admin/dashboard` | Stats overview (total users, matches, messages, reports) |
| `admin/users.blade.php` | `/admin/users` | User list with ban/unban/delete actions |
| `admin/matches.blade.php` | `/admin/matches` | All matches listing |
| `admin/reports.blade.php` | `/admin/reports` | Report queue with review/resolve workflow |
| `admin/messages.blade.php` | `/admin/messages` | Message overview/monitoring |

### `public/` — Web Root
| File | Purpose |
|------|---------|
| `index.php` | Laravel entry point |
| `.htaccess` | Apache URL rewriting |
| `favicon.ico` | Site favicon |
| `images/default-avatar.svg` | Fallback avatar image |
| `robots.txt` | Search engine crawl rules |

### `storage/` — Application Storage
- `app/public/` — User-uploaded files (profile photos in `profiles/` subdirectory)
- `app/public/` is symlinked to `public/storage/` via `php artisan storage:link`
- Photos accessed via `asset('storage/profiles/filename.png')`

### `resources/css/` and `resources/js/`
- `app.css` — Minimal, most styling via Tailwind CDN
- `app.js` / `bootstrap.js` — Vite entry points (minimal usage, most JS inline in Blade)

---

## How Files Relate To Each Other

### Request Flow
```
Browser Request
  → public/index.php
    → bootstrap/app.php (creates app, configures middleware)
      → routes/web.php (matches URL to controller)
        → Middleware chain: ForceHttps → CheckBanned → EnsureProfileComplete
          → Controller method
            → Model queries (Eloquent)
              → Blade view (extends layout)
                → HTML response
```

### Key Relationships

**User Registration Flow:**
`auth.blade.php` → `AuthController@register` → creates `User` model → redirects to `profile-create.blade.php` → `ProfileController@store` → creates `Profile` model → redirects to `/home`

**Matching Flow:**
`home.blade.php` or `search.blade.php` → click user → `user-profile.blade.php` → Like button → `MatchController@like` → creates `Like` record → if mutual like exists, creates `UserMatch` record + `Notification` → redirects back

**Messaging Flow:**
`inbox.blade.php` (lists matched conversations) → click conversation → `conversation.blade.php` → type message → JS `fetch()` POST → `MessageController@send` → creates `Message` + `Notification` → returns JSON → JS appends to DOM. Meanwhile, `setInterval` polls `MessageController@getNewMessages` every 5s.

**Admin Flow:**
`admin/login.blade.php` → `AdminController@login` → `AdminMiddleware` checks role → `admin/dashboard.blade.php`. Admin can manage users (ban/delete), review reports, view matches/messages.

### Model Dependencies
```
User ─┬─ hasOne Profile
      ├─ hasMany Like (as sender)
      ├─ hasMany Message (as sender/receiver)
      ├─ hasMany Block
      ├─ hasMany Report (as reporter)
      └─ belongsToMany UserMatch (as user1 or user2)

UserMatch ─── connects two Users (mutual like)
Message ──── sender User → receiver User
Like ─────── sender User → receiver User
Block ────── user User → blocked User
Report ───── reporter User → reported User
```

### Layout Inheritance
```
layouts/app.blade.php
  ├── home.blade.php
  ├── search.blade.php
  ├── profile.blade.php
  ├── profile-create.blade.php
  ├── user-profile.blade.php
  ├── liked.blade.php
  ├── who-liked-me.blade.php
  ├── messages/inbox.blade.php
  └── messages/conversation.blade.php

layouts/admin.blade.php
  ├── admin/dashboard.blade.php
  ├── admin/users.blade.php
  ├── admin/matches.blade.php
  ├── admin/reports.blade.php
  └── admin/messages.blade.php

Standalone (no layout):
  ├── landing.blade.php
  ├── auth.blade.php
  └── admin/login.blade.php
```

---

## Bilingual System (ENG/JP)

Every user-facing text element uses dual data attributes:
```html
<span data-en="Hello" data-jp="こんにちは">Hello</span>
<input data-placeholder-en="Search..." data-placeholder-jp="検索...">
```

The `applyLanguage(lang)` function in `layouts/app.blade.php` iterates all `[data-en]` and `[data-placeholder-en]` elements and swaps their content based on the selected language. Language preference is stored in `localStorage('kokoro-lang')`.

`auth.blade.php` has its own `applyAuthLang()` since it doesn't use the app layout.

---

## Mini Games (home.blade.php)

All games are self-contained JavaScript within the home view. No server-side logic.

1. **Love Quiz** — Multiple-choice personality quiz. Gradient answer buttons, correct/wrong animations, progress dots, confetti celebration.
2. **Love Fortune** — Random fortune card. Tap to reveal with flip animation, gradient backgrounds per fortune level.
3. **Emoji Match** — Memory card game. CSS 3D flip transforms, timer, move counter, star rating system.
4. **Heart Catcher** — Tap game inspired by Top Top. Falling emoji hearts to catch, 30-second timer, combo multiplier, increasing difficulty, score-based confetti.

---

## Deployment (Railway)

1. Push to GitHub (Railway auto-deploys)
2. Railway builds via `nixpacks.toml` + `Procfile`
3. Environment variables set in Railway dashboard (APP_KEY, DB connection, APP_URL with https://)
4. SSL terminated at Railway proxy → ForceHttps middleware + TrustProxies handle URL generation
5. `php artisan migrate --force` and `php artisan storage:link` run on deploy
