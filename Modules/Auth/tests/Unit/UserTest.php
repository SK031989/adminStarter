<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_identifies_admin_status(): void
    {
        $admin = User::factory()->admin()->create();
        $user  = User::factory()->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function it_can_determine_first_name_accessor(): void
    {
        $user = User::factory()->create(['name' => 'Alice Margatroid']);

        $this->assertEquals('Alice', $user->first_name);
    }

    /** @test */
    public function it_can_detect_suspended_account(): void
    {
        $suspended = User::factory()->suspended()->create();
        $active    = User::factory()->create();

        $this->assertTrue($suspended->isSuspended());
        $this->assertFalse($active->isSuspended());
    }

    /** @test */
    public function it_tracks_user_verifications(): void
    {
        $verified   = User::factory()->create();
        $unverified = User::factory()->unverified()->create();

        $this->assertTrue($verified->hasVerifiedEmail());
        $this->assertFalse($unverified->hasVerifiedEmail());
    }
}
