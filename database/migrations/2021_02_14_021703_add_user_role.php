<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Schema::table('users', function (Blueprint $table) {
        //     $table->text('role')
        //         ->after('username')
        //         ->nullable();
        // });

        Schema::table('users', function (Blueprint $table) {
            $table->text('role')
                ->after('password')
                ->nullable();

            $table->text('satker')
                ->after('role')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
