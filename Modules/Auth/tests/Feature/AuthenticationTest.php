<?php

namespace Modules\Auth\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_login_form(): void
    {
        $response = $this->get(route('auth.login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth-module::login');
    }

    /** @test */
    public function it_can_login_user_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'SecretPassword123!'),
            'status'   => UserStatusEnum::Active->value,
        ]);

        $response = $this->post(route('auth.login.store'), [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect(config('auth-module.redirects.login', '/dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_cannot_login_user_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('ValidPassword123!'),
        ]);

        $response = $this->post(route('auth.login.store'), [
            'email'    => $user->email,
            'password' => 'WrongPassword!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function it_prevents_suspended_user_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'ValidPassword123!'),
            'status'   => UserStatusEnum::Suspended->value,
        ]);

        $response = $this->post(route('auth.login.store'), [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function it_can_logout_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('auth.logout'));

        $response->assertRedirect();
        $this->assertGuest();
    }

    /** @test */
    public function it_prevents_admin_login_on_frontend_route(): void
    {
        $admin = User::factory()->admin()->create([
            'password' => bcrypt($password = 'AdminPassword123!'),
        ]);

        $response = $this->post(route('auth.login.store'), [
            'email'    => $admin->email,
            'password' => $password,
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function it_can_login_admin_on_admin_route(): void
    {
        $admin = User::factory()->admin()->create([
            'password' => bcrypt($password = 'AdminPassword123!'),
        ]);

        $response = $this->post(route('admin.login.store'), [
            'email'    => $admin->email,
            'password' => $password,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function it_prevents_user_login_on_admin_route(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'UserPassword123!'),
        ]);

        $response = $this->post(route('admin.login.store'), [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
