<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->enum('role', ['admin', 'custm', 'cosmt'])
                ->default('customer')
                ->after('email');
        });
        Schema::table('users', function (Blueprint $table) {
            $table
                ->string('phone')
                ->after('email');
        });
        Schema::table('users', function (Blueprint $table) {
            $table
                ->string('main_delivery_address')
                ->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role']);
            $table->dropColumn(['phone']);
            $table->dropColumn(['main_delivery_address']);
        });
    }
}
