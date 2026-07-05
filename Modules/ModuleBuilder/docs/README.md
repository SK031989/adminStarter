# ModuleBuilder — Laravel 12 SaaS Module

A production-ready, enterprise-level **Dynamic Module Builder** for Laravel 12 SaaS platforms.
Allows non-technical users to define custom data modules (e.g. Employee, Product, Project) with typed fields,
then automatically generates fully functional Laravel CRUD code.

---

## Features

- ✅ **Visual Module Definition** — Name, icon, description, status
- ✅ **13 Field Types** — text, textarea, number, email, password, date, datetime, select, radio, checkbox, file, image, boolean
- ✅ **Code Generation** — Models, Controllers, Requests, Migrations, Blade Views, Routes, Permissions
- ✅ **REST API** — Full CRUD + field management via `/api/v1/module-builder`
- ✅ **SaaS Multi-tenancy** — All records scoped by `tenant_id`
- ✅ **Policy Authorization** — Spatie Permission compatible
- ✅ **Event-Driven** — `ModuleCreated` event → `GenerateModuleFiles` listener → `ModuleGenerateJob`
- ✅ **Queue Support** — Async generation via configurable queue
- ✅ **Drag-to-Reorder Fields** — Via AJAX API
- ✅ **Demo Seeder** — Employee, Product, Project modules with realistic fields

---

## Installation

```bash
# Module is already installed in Modules/ModuleBuilder/
php artisan module:enable ModuleBuilder
php artisan module:migrate ModuleBuilder
php artisan module:seed ModuleBuilder --class=ModuleBuilderSeeder
```

---

## Routes

### Web Routes (auth required)

| Method    | URI                                       | Name                            |
|-----------|-------------------------------------------|---------------------------------|
| GET       | `/module-builder`                         | `module-builder.index`          |
| GET       | `/module-builder/create`                  | `module-builder.create`         |
| POST      | `/module-builder`                         | `module-builder.store`          |
| GET       | `/module-builder/{id}`                    | `module-builder.show`           |
| GET       | `/module-builder/{id}/edit`               | `module-builder.edit`           |
| PUT       | `/module-builder/{id}`                    | `module-builder.update`         |
| DELETE    | `/module-builder/{id}`                    | `module-builder.destroy`        |
| POST      | `/module-builder/{id}/fields`             | `module-builder.fields.store`   |
| PUT       | `/module-builder/{id}/fields/{field}`     | `module-builder.fields.update`  |
| DELETE    | `/module-builder/{id}/fields/{field}`     | `module-builder.fields.destroy` |
| POST      | `/module-builder/{id}/fields/reorder`     | `module-builder.fields.reorder` |
| POST      | `/module-builder/{id}/generate`           | `module-builder.generate`       |
| GET       | `/module-builder/{id}/preview`            | `module-builder.preview`        |

### API Routes (Sanctum auth)

| Method    | URI                                          |
|-----------|----------------------------------------------|
| GET/POST  | `/api/v1/module-builder`                     |
| GET/PUT/DELETE | `/api/v1/module-builder/{id}`           |
| GET/POST  | `/api/v1/module-builder/{id}/fields`         |
| PUT/DELETE| `/api/v1/module-builder/{id}/fields/{field}` |
| POST      | `/api/v1/module-builder/{id}/generate`       |
| GET       | `/api/v1/module-builder/{id}/status`         |
| GET       | `/api/v1/module-builder/{id}/preview`        |

---

## Generation Pipeline

```
POST /module-builder/{id}/generate
         ↓
ModuleBuilderService::generateModule()
         ↓
  ├── MigrationGeneratorService  → Modules/{Name}/database/migrations/
  ├── ModelGeneratorService      → Modules/{Name}/App/Models/
  ├── ControllerGeneratorService → Modules/{Name}/App/Http/Controllers/
  │                                Modules/{Name}/App/Http/Requests/
  ├── ViewGeneratorService       → Modules/{Name}/resources/views/
  │                                  ├── index.blade.php
  │                                  ├── create.blade.php
  │                                  ├── edit.blade.php
  │                                  ├── show.blade.php
  │                                  └── partials/form,table,filters,actions
  ├── PermissionGeneratorService → module_permissions table
  │                                  {slug}.view / .create / .update / .delete
  └── Routes                     → Modules/{Name}/routes/web.php + api.php
```

---

## Database Tables

| Table                 | Purpose                            |
|-----------------------|------------------------------------|
| `dynamic_modules`     | Module definitions                 |
| `dynamic_fields`      | Field definitions per module       |
| `module_menus`        | Auto-generated nav menu entries    |
| `module_permissions`  | Auto-generated CRUD permissions    |

Every table includes: `id`, `tenant_id`, `status`, `timestamps`, `softDeletes`.

---

## Supported Field Types

| Type       | MySQL Column  | HTML Input       | Castable     |
|------------|---------------|------------------|--------------|
| text       | string        | text             | —            |
| textarea   | text          | textarea         | —            |
| number     | decimal       | number           | decimal:2    |
| email      | string        | email            | —            |
| password   | string        | password         | —            |
| date       | date          | date             | date         |
| datetime   | dateTime      | datetime-local   | datetime     |
| select     | string        | select           | —            |
| radio      | string        | radio            | —            |
| checkbox   | json          | checkbox         | array        |
| file       | string        | file             | —            |
| image      | string        | file[image/*]    | —            |
| boolean    | boolean       | checkbox(toggle) | boolean      |

---

## Configuration

```php
// config/modulebuilder.php
'modules_path'    => base_path('Modules'),
'auto_migrate'    => false,
'queue_connection'=> 'sync',
'queue_name'      => 'module-generation',
'field_types'     => [...],
'pagination'      => ['per_page' => 15],
```

---

## Artisan Commands

```bash
# Generate files for a module by slug
php artisan module-builder:generate employee

# List all dynamic modules
php artisan module-builder:list
```

---

## Module Structure

```
Modules/ModuleBuilder/
├── App/
│   ├── Http/Controllers/
│   │   ├── ModuleBuilderController.php     # CRUD
│   │   ├── ModuleFieldController.php       # Field management + reorder
│   │   └── GeneratedModuleController.php   # Generate / Status / Preview
│   ├── Http/Requests/
│   │   ├── StoreModuleRequest.php
│   │   ├── UpdateModuleRequest.php
│   │   └── StoreFieldRequest.php
│   ├── Models/
│   │   ├── DynamicModule.php
│   │   ├── DynamicField.php
│   │   ├── ModuleMenu.php
│   │   └── ModulePermission.php
│   ├── Services/
│   │   ├── ModuleBuilderService.php
│   │   ├── MigrationGeneratorService.php
│   │   ├── ModelGeneratorService.php
│   │   ├── ControllerGeneratorService.php
│   │   ├── ViewGeneratorService.php
│   │   └── PermissionGeneratorService.php
│   ├── Repositories/
│   │   ├── ModuleRepository.php
│   │   └── FieldRepository.php
│   ├── Policies/ModuleBuilderPolicy.php
│   ├── Rules/FieldTypeRule.php
│   ├── Events/ModuleCreated.php
│   ├── Listeners/GenerateModuleFiles.php
│   ├── Jobs/ModuleGenerateJob.php
│   ├── Observers/ModuleObserver.php
│   ├── Enums/FieldTypeEnum.php
│   ├── Traits/ModuleGeneratorTrait.php
│   └── Providers/
│       ├── ModuleBuilderServiceProvider.php
│       └── RouteServiceProvider.php
├── database/
│   ├── migrations/ (4 migrations)
│   ├── factories/
│   │   ├── DynamicModuleFactory.php
│   │   └── DynamicFieldFactory.php
│   └── seeders/ModuleBuilderSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── show.blade.php
│   └── partials/
│       ├── form.blade.php
│       ├── field-form.blade.php
│       ├── table.blade.php
│       ├── filters.blade.php
│       └── actions.blade.php
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
├── config/modulebuilder.php
├── tests/
│   ├── Feature/ModuleBuilderTest.php
│   └── Unit/FieldTypeEnumTest.php
├── module.json
└── composer.json
```

---

## License
MIT — SaaS Starter Kit
