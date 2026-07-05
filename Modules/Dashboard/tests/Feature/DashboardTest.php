<?php

namespace Modules\Dashboard\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\App\Models\User;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_accessing_admin_are_redirected_to_admin_login()
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function non_admin_users_accessing_admin_are_redirected_to_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect('/admin/dashboard');
    }

    /** @test */
    public function admin_users_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    /** @test */
    public function admin_users_accessing_admin_root_are_redirected_to_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertRedirect('/admin/dashboard');
    }

    /** @test */
    public function dashboard_route_redirects_admin_to_admin_panel()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function dashboard_route_allows_user_access()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    /** @test */
    public function admin_can_access_user_list_page()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('User Management');
    }

    /** @test */
    public function non_admin_cannot_access_user_list_page()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_roles_list_page()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('admin.roles.index'));

        $response->assertStatus(200);
        $response->assertSee('Roles');
    }

    /** @test */
    public function admin_can_update_user_role()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['is_admin' => false]);
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Tenant Admin', 'guard_name' => 'web']);

        $response = $this->actingAs($admin)->put(route('admin.users.role.update', $user), [
            'role' => 'Tenant Admin',
        ]);

        $response->assertRedirect();
        $this->assertTrue($user->fresh()->hasRole('Tenant Admin'));
    }
}
