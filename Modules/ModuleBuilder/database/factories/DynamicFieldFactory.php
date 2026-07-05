<?php

namespace Modules\ModuleBuilder\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ModuleBuilder\App\Enums\FieldTypeEnum;
use Modules\ModuleBuilder\App\Models\DynamicField;
use Modules\ModuleBuilder\App\Models\DynamicModule;

class DynamicFieldFactory extends Factory
{
    protected $model = DynamicField::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'tenant_id'        => 1,
            'module_id'        => DynamicModule::factory(),
            'field_name'       => strtolower($name),
            'label'            => ucfirst($name),
            'type'             => $this->faker->randomElement(FieldTypeEnum::cases())->value,
            'is_required'      => $this->faker->boolean(30),
            'is_searchable'    => $this->faker->boolean(40),
            'is_filterable'    => $this->faker->boolean(30),
            'is_sortable'      => $this->faker->boolean(20),
            'is_nullable'      => true,
            'default_value'    => null,
            'options'          => null,
            'validation_rules' => null,
            'placeholder'      => "Enter {$name}...",
            'help_text'        => null,
            'sort_order'       => $this->faker->numberBetween(1, 20),
            'status'           => 'active',
        ];
    }

    /**
     * Make field required.
     */
    public function required(): static
    {
        return $this->state(['is_required' => true, 'is_nullable' => false]);
    }

    /**
     * Make a select field with options.
     */
    public function select(): static
    {
        return $this->state([
            'type'    => FieldTypeEnum::Select->value,
            'options' => ['option_1' => 'Option 1', 'option_2' => 'Option 2', 'option_3' => 'Option 3'],
        ]);
    }

    /**
     * Make a text type field.
     */
    public function text(): static
    {
        return $this->state(['type' => FieldTypeEnum::Text->value]);
    }
}
