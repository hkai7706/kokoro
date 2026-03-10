# KOKORO - Partner Matching Platform

## Quick Start (XAMPP + SQLite)

1. **Navigate to project:**
   ```
   cd C:\xampp\htdocs\kokoro
   ```

2. **Install dependencies:**
   ```
   composer install
   ```

3. **Run migrations & seed:**
   ```
   php artisan migrate --seed
   ```

4. **Create storage link:**
   ```
   php artisan storage:link
   ```

5. **Start the server:**
   ```
   php artisan serve
   ```

6. **Open in browser:**
   - Landing page: http://localhost:8000
   - Auth page: http://localhost:8000/auth
   - Admin login: http://localhost:8000/admin/login

## Default Accounts

| Role  | Email               | Password     |
|-------|---------------------|--------------|
| Admin | hkai7706@gmail.com  | 000000       |
| User  | sakura@demo.com     | password123  |
| User  | kenji@demo.com      | password123  |
| User  | yuki@demo.com       | password123  |
| User  | takeshi@demo.com    | password123  |
| User  | mika@demo.com       | password123  |
| User  | ryu@demo.com        | password123  |

## Switching to Supabase PostgreSQL

1. **Enable PHP pgsql extension** in `C:\xampp\php\php.ini`:
   - Uncomment: `extension=pdo_pgsql`
   - Uncomment: `extension=pgsql`
   - Restart Apache

2. **Update `.env`:**
   ```
   DB_CONNECTION=pgsql
   DB_HOST=db.YOUR_PROJECT_REF.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=YOUR_SUPABASE_DB_PASSWORD
   ```

3. **Re-run migrations:**
   ```
   php artisan migrate:fresh --seed
   ```

## Project Structure

```
app/
  Http/
    Controllers/
      AuthController.php      # Login, register, logout
      ProfileController.php   # Profile CRUD
      HomeController.php      # Home feed, search
      MatchController.php     # Like, unlike, skip
      MessageController.php   # Inbox, chat, send
      AdminController.php     # Admin dashboard & management
    Middleware/
      AdminMiddleware.php      # Admin role check
      EnsureProfileComplete.php # Redirect to profile creation
      CheckBanned.php          # Block banned users
  Models/
    User.php, Profile.php, Like.php, UserMatch.php,
    Message.php, Report.php, Block.php, Notification.php, AdminLog.php

resources/views/
  landing.blade.php            # SEO landing page
  auth.blade.php               # Login/signup card
  profile-create.blade.php     # Profile completion
  home.blade.php               # Matching feed
  search.blade.php             # Search by area
  liked.blade.php              # Liked profiles
  profile.blade.php            # Edit profile
  user-profile.blade.php       # View other user
  messages/
    inbox.blade.php            # Conversations list
    conversation.blade.php     # Chat UI
  admin/
    login.blade.php            # Admin login
    dashboard.blade.php        # Stats & overview
    users.blade.php            # User management
    reports.blade.php          # Report management
    matches.blade.php          # Match browser
    messages.blade.php         # Message monitor
  layouts/
    app.blade.php              # Main user layout
    admin.blade.php            # Admin layout

database/migrations/           # 11 migration files
database/seeders/              # Admin + demo users
```
