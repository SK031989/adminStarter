<?php

namespace Modules\ModuleBuilder\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Models\DynamicField;
use Modules\ModuleBuilder\App\Enums\FieldTypeEnum;
use Modules\ModuleBuilder\App\Services\ModuleBuilderService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class DynamicModulePolicyTest extends TestCase
{
    use RefreshDatabase;

    protected string $moduleClassName = 'TestWidget';
    protected string $moduleSlug = 'test-widgets';
    protected string $modulePath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modulePath = base_path("Modules/{$this->moduleClassName}");
    }

    protected function tearDown(): void
    {
        // Cleanup generated files
        if (File::exists($this->modulePath)) {
            File::deleteDirectory($this->modulePath);
        }

        // Clean from modules_statuses.json
        $statusesPath = base_path('modules_statuses.json');
        if (File::exists($statusesPath)) {
            $statuses = json_decode(file_get_contents($statusesPath), true);
            unset($statuses[$this->moduleClassName]);
            file_put_contents($statusesPath, json_encode($statuses, JSON_PRETTY_PRINT));
        }

        parent::tearDown();
    }

    /** @test */
    public function it_generates_policy_and_registers_it(): void
    {
        // 1. Create a dynamic module definition
        $module = DynamicModule::create([
            'tenant_id' => 1,
            'name'      => 'TestWidget',
            'slug'      => $this->moduleSlug,
            'status'    => 'active',
        ]);

        DynamicField::create([
            'tenant_id'   => 1,
            'module_id'   => $module->id,
            'field_name'  => 'title',
            'label'       => 'Title',
            'type'        => FieldTypeEnum::Text->value,
            'is_required' => true,
            'is_nullable' => false,
            'sort_order'  => 1,
            'status'      => 'active',
        ]);

        // 2. Generate the module
        $service = app(ModuleBuilderService::class);
        $generated = $service->generateModule($module);

        // 3. Assert all expected files were created
        $this->assertFileExists($generated['policy']);
        $this->assertFileExists($generated['service_provider']);
        $this->assertFileExists($generated['module_json']);

        // Check file contents for permissions mapping
        $policyContent = file_get_contents($generated['policy']);
        $this->assertStringContainsString("'test-widgets.view'", $policyContent);
        $this->assertStringContainsString("'test-widgets.create'", $policyContent);
        $this->assertStringContainsString("'test-widgets.update'", $policyContent);
        $this->assertStringContainsString("'test-widgets.delete'", $policyContent);

        // 4. Test the generated policy class
        $modelClass  = "Modules\\TestWidget\\App\\Models\\TestWidget";
        $policyClass = "Modules\\TestWidget\\App\\Policies\\TestWidgetPolicy";
        
        $this->assertTrue(class_exists($modelClass));
        $this->assertTrue(class_exists($policyClass));

        // Manually register the policy with the Gate since the ServiceProvider wasn't booted
        Gate::policy($modelClass, $policyClass);

        // Create standard user (non-admin) without roles/permissions
        $user = \Modules\Auth\App\Models\User::factory()->create([
            'tenant_id' => 1,
            'is_admin'  => false,
        ]);
        
        $this->assertFalse(Gate::forUser($user)->allows('viewAny', $modelClass));
        $this->assertFalse(Gate::forUser($user)->allows('create', $modelClass));

        // Create admin user (always bypasses checks via Gate::before)
        $admin = \Modules\Auth\App\Models\User::factory()->create([
            'tenant_id' => 1,
            'is_admin'  => true,
        ]);
        
        $this->assertTrue(Gate::forUser($admin)->allows('viewAny', $modelClass));
        $this->assertTrue(Gate::forUser($admin)->allows('create', $modelClass));
    }
}
