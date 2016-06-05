<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role')->unique();
            $table->timestamps();
        });

        $role = new \App\Role();
        $role->role = "Admin";
        $role->save();

        $role = new \App\Role();
        $role->role = "Doctor";
        $role->save();

        $role = new \App\Role();
        $role->role = "Nurse";
        $role->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('roles');
    }
}
