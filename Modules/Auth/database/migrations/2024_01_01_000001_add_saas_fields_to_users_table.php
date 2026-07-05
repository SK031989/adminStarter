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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->default(1)->after('id')->index();
            $table->string('phone', 20)->nullable()->after('password');
            $table->string('avatar')->nullable()->after('phone');
            $table->string('status', 20)->default('active')->after('avatar')->index();
            $table->boolean('is_admin')->default(false)->after('status')->index();
            
            // Two Factor Columns
            $table->text('two_factor_secret')->nullable()->after('is_admin');
            $table->boolean('two_factor_enabled')->default(false)->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_enabled');

            // Login metadata
            $table->timestamp('last_login_at')->nullable()->after('two_factor_confirmed_at');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');

            // SoftDeletes
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tenant_id',
                'phone',
                'avatar',
                'status',
                'is_admin',
                'two_factor_secret',
                'two_factor_enabled',
                'two_factor_confirmed_at',
                'last_login_at',
                'last_login_ip',
                'deleted_at'
            ]);
        });
    }
};
