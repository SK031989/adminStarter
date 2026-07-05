<?php

namespace Modules\ModuleBuilder\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\ModuleBuilder\App\Models\DynamicModule;

class DynamicModuleFactory extends Factory
{
    protected $model = DynamicModule::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'tenant_id'       => 1,
            'name'            => Str::title($name),
            'slug'            => Str::slug($name),
            'icon'            => 'bi-grid',
            'description'     => $this->faker->sentence(),
            'is_generated'    => false,
            'generation_path' => null,
            'settings'        => null,
            'sort_order'      => $this->faker->numberBetween(0, 50),
            'status'          => 'active',
        ];
    }

    /**
     * Mark the module as already generated.
     */
    public function generated(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_generated'    => true,
            'generation_path' => base_path('Modules/' . Str::studly($attributes['name'])),
        ]);
    }

    /**
     * Set to inactive.
     */
    public function inactive(): static
    {
        return $this->state(['status' => 'inactive']);
    }
}
