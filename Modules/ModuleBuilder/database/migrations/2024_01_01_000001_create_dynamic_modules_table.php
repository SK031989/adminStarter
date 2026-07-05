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
        Schema::create('dynamic_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();

            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->string('icon', 50)->default('bi-grid')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_generated')->default(false);
            $table->string('generation_path')->nullable();

            $table->json('settings')->nullable();
            $table->integer('sort_order')->default(0);

            $table->string('status', 20)->default('active')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_modules');
    }
};
