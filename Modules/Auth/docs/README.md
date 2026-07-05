# Auth Module

A production-ready, enterprise-level **Authentication Module** for Laravel 12 SaaS platforms.
Integrates user login, registration, email verification, password reset, profile management, activity logging, and API tokens (Sanctum) inside a secure multi-tenant environment.

---

## Features

- ✅ **Secure Authentication** — Session login, logout, remember me toggles.
- ✅ **SaaS User Registration** — Auto-associates users to organizations/tenants.
- ✅ **Password Security** — `StrongPasswordRule` validator requiring customizable complexity.
- ✅ **Email Verification** — Queued email notifications and signed validation routes.
- ✅ **Reset Workflows** — Expiry-protected token links via forgot-password mail alerts.
- ✅ **Detailed Logging** — `auth_login_activities` logs device, browser, IP address, and status.
- ✅ **Profile Portal** — Details edit, password upgrade, avatar update/delete, and account deletion confirmation modal.
- ✅ **Access Control** — Active status verification check middleware (suspension guard).

---

## Installation & Setup

Enable the Auth module inside your Laravel application and run the database migrations:

```bash
# Enable module
php artisan module:enable Auth

# Run migrations
php artisan module:migrate Auth

# Seed default administrator and user accounts
php artisan module:seed Auth --class=AuthSeeder
```

---

## Routes

### Web Routes

| Method | URI | Name |
|---|---|---|
| GET | `/login` | `auth.login` |
| POST | `/login` | `auth.login.store` |
| GET | `/admin/login` | `admin.login` |
| POST | `/admin/login` | `admin.login.store` |
| POST | `/auth/logout` | `auth.logout` |
| GET | `/register` | `auth.register` |
| POST | `/register` | `auth.register.store` |
| GET | `/auth/forgot-password` | `auth.password.request` |
| POST | `/auth/forgot-password` | `auth.password.email` |
| GET | `/auth/reset-password/{token}` | `auth.password.reset` |
| POST | `/auth/reset-password` | `auth.password.update` |
| GET | `/auth/verify-email` | `auth.verify.notice` |
| GET | `/auth/verify-email/{id}/{hash}`| `auth.verify.verify` |
| POST | `/auth/email/verification` | `auth.verify.resend` |
| GET | `/profile` | `auth.profile.edit` |
| PUT | `/profile` | `auth.profile.update` |
| PUT | `/profile/password` | `auth.profile.password.update`|
| DELETE| `/profile/avatar` | `auth.profile.avatar.destroy` |
| DELETE| `/profile` | `auth.profile.destroy` |

### API Routes

| Method | URI | Description |
|---|---|---|
| POST | `/api/v1/auth/login` | Generate a new Sanctum API token |
| GET | `/api/v1/auth/user` | Fetch current authenticated user |
| POST | `/api/v1/auth/logout` | Revoke current token |

---

## CLI Utilities

```bash
# Display all registered accounts
php artisan auth:list-users

# Create a new administrator account
php artisan auth:create-admin "Alice" "alice@saas.local" "SecurePass123!"
```

---

## Module Structure

```
Modules/Auth/
├── App/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── LogoutController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   ├── ResetPasswordController.php
│   │   │   ├── VerificationController.php
│   │   │   └── ProfileController.php
│   │   ├── Requests/
│   │   │   ├── LoginRequest.php
│   │   │   ├── RegisterRequest.php
│   │   │   ├── ForgotPasswordRequest.php
│   │   │   ├── ResetPasswordRequest.php
│   │   │   ├── UpdateProfileRequest.php
│   │   │   └── UpdatePasswordRequest.php
│   │   └── Middleware/
│   │       └── VerifyUserStatus.php
│   ├── Models/
│   │   ├── User.php
│   │   └── LoginActivity.php
│   ├── Repositories/
│   │   └── UserRepository.php
│   ├── Services/
│   │   ├── AuthService.php
│   │   ├── RegistrationService.php
│   │   ├── PasswordResetService.php
│   │   └── ProfileService.php
│   ├── Policies/
│   │   └── UserPolicy.php
│   ├── Rules/
│   │   └── StrongPasswordRule.php
│   ├── Events/
│   │   ├── UserRegistered.php
│   │   ├── UserLoggedIn.php
│   │   └── UserLoggedOut.php
│   ├── Listeners/
│   │   ├── SendWelcomeEmail.php
│   │   └── LogAuthActivity.php
│   ├── Jobs/
│   │   ├── SendWelcomeEmailJob.php
│   │   └── SendVerificationEmailJob.php
│   ├── Notifications/
│   │   ├── WelcomeNotification.php
│   │   └── PasswordResetNotification.php
│   ├── Traits/
│   │   └── HasTenantAuth.php
│   └── Providers/
│       ├── AuthServiceProvider.php
│       └── RouteServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_add_saas_fields_to_users_table.php
│   │   └── 2024_01_01_000002_create_auth_login_activities_table.php
│   ├── factories/
│   │   └── UserFactory.php
│   └── seeders/
│       └── AuthSeeder.php
├── resources/views/
│   ├── layouts/
│   │   └── auth.blade.php
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── verify.blade.php
│   ├── profile.blade.php
│   └── passwords/
│       ├── email.blade.php
│       └── reset.blade.php
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
├── config/
│   └── auth-module.php
├── tests/
│   ├── Feature/
│   │   └── AuthenticationTest.php
│   └── Unit/
│       └── UserTest.php
├── module.json
└── composer.json
```
