<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_number', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->enum('role', ['user', 'admin', 'department'])->default('user');
            $table->string('department', 100)->nullable();
            $table->string('profile_picture')->default('default-avatar.png');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
