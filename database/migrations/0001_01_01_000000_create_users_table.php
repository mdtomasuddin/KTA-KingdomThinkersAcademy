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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 50)->nullable()->comment('User Identifier Code');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable()->comment('Unique Handle');
            $table->string('email', 255)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_relation', 100)->nullable();
            $table->string('designation', 150)->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('birthday')->nullable();
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->string('signature_image')->nullable();
            $table->enum('role', ['parent', 'student', 'teacher', 'contracted_teacher', 'coop', 'micro_school', 'admin', 'super_admin'])->default('student');
            $table->text('bio')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('terms_and_conditions')->default(false)->comment('Terms Agreement');
            $table->string('timezone', 50)->default('UTC');
            $table->string('google_id')->nullable()->unique();
            $table->string('apple_id')->nullable()->unique();
            $table->enum('status', ['active', 'pending', 'inactive', 'suspended'])->default('pending');
            $table->timestamp('last_seen_at')->nullable()->comment('Timestamp of last user activity');
            $table->rememberToken();
            $table->timestamps();

            // Indexes
            $table->index('role', 'idx_users_role');
            $table->index('username', 'idx_users_username');
            $table->index('status', 'idx_users_global_status');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
