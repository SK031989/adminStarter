<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dynamic_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->foreignId('module_id')
                  ->constrained('dynamic_modules')
                  ->cascadeOnDelete();

            $table->string('field_name', 64);
            $table->string('label', 100);
            $table->string('type', 30);              // FieldTypeEnum value

            $table->boolean('is_required')->default(false);
            $table->boolean('is_searchable')->default(false);
            $table->boolean('is_filterable')->default(false);
            $table->boolean('is_sortable')->default(false);
            $table->boolean('is_nullable')->default(true);

            $table->string('default_value')->nullable();
            $table->json('options')->nullable();         // for select/radio/checkbox
            $table->string('validation_rules')->nullable(); // pipe-separated
            $table->string('placeholder')->nullable();
            $table->text('help_text')->nullable();
            $table->json('settings')->nullable();

            $table->integer('sort_order')->default(0);
            $table->string('status', 20)->default('active')->index();
            $table->timestamps();
            $table->softDeletes();

            // A field_name must be unique within a module
            $table->unique(['module_id', 'field_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_fields');
    }
};
