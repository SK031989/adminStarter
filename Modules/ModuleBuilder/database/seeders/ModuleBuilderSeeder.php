<?php

namespace Modules\ModuleBuilder\database\seeders;

use Illuminate\Database\Seeder;
use Modules\ModuleBuilder\App\Models\DynamicField;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Enums\FieldTypeEnum;

class ModuleBuilderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding ModuleBuilder demo data...');

        // ── Employee Module ───────────────────────────────────────────────────
        $employee = DynamicModule::firstOrCreate(
            ['slug' => 'employees'],
            [
                'tenant_id'   => 1,
                'name'        => 'Employee',
                'icon'        => 'bi-people',
                'description' => 'Manage company employees',
                'status'      => 'active',
            ]
        );

        $this->seedFields($employee, [
            ['first_name', 'First Name',      FieldTypeEnum::Text,     true,  true,  false],
            ['last_name',  'Last Name',        FieldTypeEnum::Text,     true,  true,  false],
            ['email',      'Email',            FieldTypeEnum::Email,    true,  true,  false],
            ['phone',      'Phone',            FieldTypeEnum::Text,     false, false, false],
            ['department', 'Department',       FieldTypeEnum::Select,   false, false, true ],
            ['hire_date',  'Hire Date',        FieldTypeEnum::Date,     false, false, true ],
            ['salary',     'Salary',           FieldTypeEnum::Number,   false, false, false],
            ['is_active',  'Is Active',        FieldTypeEnum::Boolean,  false, false, true ],
        ]);

        // ── Product Module ────────────────────────────────────────────────────
        $product = DynamicModule::firstOrCreate(
            ['slug' => 'products'],
            [
                'tenant_id'   => 1,
                'name'        => 'Product',
                'icon'        => 'bi-box-seam',
                'description' => 'Product catalog management',
                'status'      => 'active',
            ]
        );

        $this->seedFields($product, [
            ['name',        'Product Name', FieldTypeEnum::Text,     true,  true,  false],
            ['sku',         'SKU',          FieldTypeEnum::Text,     true,  true,  false],
            ['description', 'Description',  FieldTypeEnum::Textarea, false, false, false],
            ['price',       'Price',        FieldTypeEnum::Number,   true,  false, true ],
            ['stock',       'Stock',        FieldTypeEnum::Number,   false, false, true ],
            ['category',    'Category',     FieldTypeEnum::Select,   false, false, true ],
            ['image',       'Image',        FieldTypeEnum::Image,    false, false, false],
            ['is_featured', 'Featured',     FieldTypeEnum::Boolean,  false, false, true ],
        ]);

        // ── Project Module ────────────────────────────────────────────────────
        $project = DynamicModule::firstOrCreate(
            ['slug' => 'projects'],
            [
                'tenant_id'   => 1,
                'name'        => 'Project',
                'icon'        => 'bi-kanban',
                'description' => 'Project tracking module',
                'status'      => 'active',
            ]
        );

        $this->seedFields($project, [
            ['title',       'Title',        FieldTypeEnum::Text,     true,  true,  false],
            ['description', 'Description',  FieldTypeEnum::Textarea, false, false, false],
            ['start_date',  'Start Date',   FieldTypeEnum::Date,     false, false, true ],
            ['end_date',    'End Date',     FieldTypeEnum::Date,     false, false, true ],
            ['budget',      'Budget',       FieldTypeEnum::Number,   false, false, false],
            ['priority',    'Priority',     FieldTypeEnum::Select,   false, false, true ],
            ['tags',        'Tags',         FieldTypeEnum::Checkbox, false, false, false],
            ['attachment',  'Attachment',   FieldTypeEnum::File,     false, false, false],
        ]);

        $this->command->info('ModuleBuilder seeding completed!');
    }

    // -------------------------------------------------------------------------
    // Helper
    // -------------------------------------------------------------------------

    private function seedFields(DynamicModule $module, array $fields): void
    {
        foreach ($fields as $index => [$fieldName, $label, $type, $required, $searchable, $filterable]) {
            DynamicField::firstOrCreate(
                ['module_id' => $module->id, 'field_name' => $fieldName],
                [
                    'tenant_id'     => $module->tenant_id,
                    'label'         => $label,
                    'type'          => $type->value,
                    'is_required'   => $required,
                    'is_searchable' => $searchable,
                    'is_filterable' => $filterable,
                    'is_nullable'   => !$required,
                    'sort_order'    => $index + 1,
                    'status'        => 'active',
                ]
            );
        }
    }
}
