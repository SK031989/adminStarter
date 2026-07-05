<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\App\Http\Requests\UpdatePasswordRequest;
use Modules\Auth\App\Http\Requests\UpdateProfileRequest;
use Modules\Auth\App\Services\PasswordResetService;
use Modules\Auth\App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileService $profileService,
        protected PasswordResetService $passwordResetService
    ) {}

    /**
     * Show user profile edit view.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        // Redirect admin/tenant-admin accessing non-prefixed route to the admin-prefixed one
        $isAdminCase = $user->is_admin || $user->hasRole('Tenant Admin');
        if ($isAdminCase && !$request->is('admin/*')) {
            return redirect()->route('admin.profile.edit');
        } elseif (!$isAdminCase && $request->is('admin/*')) {
            return redirect()->route('auth.profile.edit');
        }

        $user->load('loginActivities');

        return view('auth-module::profile', compact('user'));
    }

    /**
     * Update user profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile($request->user(), $request->validated());

        return redirect()->route($this->getProfileRedirectRoute())
            ->with('success', 'Profile information updated successfully.');
    }

    /**
     * Update user password.
     */
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $this->passwordResetService->changePassword(
            $request->user(),
            $request->input('current_password'),
            $request->input('new_password')
        );

        return redirect()->route($this->getProfileRedirectRoute())
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Remove the profile avatar.
     */
    public function destroyAvatar(Request $request): RedirectResponse
    {
        $this->profileService->deleteAvatar($request->user());

        return redirect()->route($this->getProfileRedirectRoute())
            ->with('success', 'Profile picture removed.');
    }

    /**
     * Delete user account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'delete_password' => ['required', 'string'],
        ]);

        try {
            $this->profileService->deleteAccount($request->user(), $request->input('delete_password'));
            
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Your account has been deleted.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route($this->getProfileRedirectRoute())
                ->withErrors(['delete_password' => 'The provided password does not match.'], 'accountDeletion');
        }
    }

    /**
     * Get the appropriate redirect route name depending on if the user is an admin.
     */
    private function getProfileRedirectRoute(): string
    {
        $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
        return $isAdminCase ? 'admin.profile.edit' : 'auth.profile.edit';
    }
}
