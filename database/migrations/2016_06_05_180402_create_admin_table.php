<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
        });

        $admin = new \App\Admin();
        $admin->username = "Admin";
        $admin->password = bcrypt("admin123");
        $admin->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('admins');
    }
}
