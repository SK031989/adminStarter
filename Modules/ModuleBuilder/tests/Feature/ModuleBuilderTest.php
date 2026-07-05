<?php

namespace Modules\ModuleBuilder\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Models\DynamicField;
use Modules\ModuleBuilder\App\Enums\FieldTypeEnum;

class ModuleBuilderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_denies_access_to_non_admin_users(): void
    {
        $user = \Modules\Auth\App\Models\User::factory()->create([
            'tenant_id' => 1,
            'is_admin'  => false,
        ]);

        $response = $this->actingAs($user)
            ->get(route('module-builder.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function it_can_list_modules(): void
    {
        DynamicModule::factory()->count(3)->create(['tenant_id' => 1]);

        $response = $this->actingAsAdmin()
            ->get(route('module-builder.index'));

        $response->assertOk()
            ->assertViewIs('module-builder::index')
            ->assertViewHas('modules');
    }

    /** @test */
    public function it_can_create_a_module(): void
    {
        \Illuminate\Support\Facades\Event::fake();

        $data = [
            'name'        => 'Invoice',
            'icon'        => 'bi-receipt',
            'description' => 'Invoice management',
            'status'      => 'active',
        ];

        $response = $this->actingAsAdmin()
            ->post(route('module-builder.store'), $data);

        $response->assertRedirect();

        $this->assertDatabaseHas('dynamic_modules', [
            'name' => 'Invoice',
            'slug' => 'invoice',
        ]);
    }

    /** @test */
    public function it_validates_module_name_is_required(): void
    {
        $response = $this->actingAsAdmin()
            ->post(route('module-builder.store'), ['status' => 'active']);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_validates_module_name_is_unique(): void
    {
        DynamicModule::factory()->create(['name' => 'Employee', 'slug' => 'employee', 'tenant_id' => 1]);

        $response = $this->actingAsAdmin()
            ->post(route('module-builder.store'), [
                'name'   => 'Employee',
                'status' => 'active',
            ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_can_view_a_module(): void
    {
        $module = DynamicModule::factory()->create(['tenant_id' => 1]);

        $response = $this->actingAsAdmin()
            ->get(route('module-builder.show', $module));

        $response->assertOk()
            ->assertViewIs('module-builder::show');
    }

    /** @test */
    public function it_can_update_a_module(): void
    {
        $module = DynamicModule::factory()->create(['tenant_id' => 1]);

        $response = $this->actingAsAdmin()
            ->put(route('module-builder.update', $module), [
                'name'   => 'Updated Module',
                'status' => 'active',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('dynamic_modules', ['name' => 'Updated Module']);
    }

    /** @test */
    public function it_can_delete_a_module(): void
    {
        $module = DynamicModule::factory()->create(['tenant_id' => 1]);

        $response = $this->actingAsAdmin()
            ->delete(route('module-builder.destroy', $module));

        $response->assertRedirect(route('module-builder.index'));
        $this->assertSoftDeleted('dynamic_modules', ['id' => $module->id]);
    }

    // -------------------------------------------------------------------------
    // Field Management
    // -------------------------------------------------------------------------

    /** @test */
    public function it_can_add_a_field_to_a_module(): void
    {
        $module = DynamicModule::factory()->create(['tenant_id' => 1]);

        $response = $this->actingAsAdmin()
            ->post(route('module-builder.fields.store', $module), [
                'field_name'  => 'email',
                'label'       => 'Email Address',
                'type'        => FieldTypeEnum::Email->value,
                'is_required' => true,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('dynamic_fields', [
            'module_id'  => $module->id,
            'field_name' => 'email',
        ]);
    }

    /** @test */
    public function it_validates_field_name_format(): void
    {
        $module = DynamicModule::factory()->create(['tenant_id' => 1]);

        $response = $this->actingAsAdmin()
            ->post(route('module-builder.fields.store', $module), [
                'field_name' => 'Invalid Name!',
                'label'      => 'Test',
                'type'       => FieldTypeEnum::Text->value,
            ]);

        $response->assertSessionHasErrors(['field_name']);
    }

    /** @test */
    public function it_prevents_duplicate_field_names_in_same_module(): void
    {
        $module = DynamicModule::factory()->create(['tenant_id' => 1]);
        DynamicField::factory()->create([
            'module_id'  => $module->id,
            'field_name' => 'email',
            'tenant_id'  => 1,
        ]);

        $response = $this->actingAsAdmin()
            ->post(route('module-builder.fields.store', $module), [
                'field_name' => 'email',
                'label'      => 'Email',
                'type'       => FieldTypeEnum::Email->value,
            ]);

        $response->assertSessionHasErrors(['field_name']);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function actingAsAdmin(): static
    {
        $user = \Modules\Auth\App\Models\User::factory()->create([
            'tenant_id' => 1,
            'is_admin'  => true,
        ]);

        return $this->actingAs($user);
    }
}
