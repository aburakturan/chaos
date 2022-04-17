<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTitleFieldToRolesAndPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = config('permission.table_names');

        Schema::table($config['roles'], function (Blueprint $table) {
            $table->string('title')->after('name')->nullable();
        });

        Schema::table($config['permissions'], function (Blueprint $table) {
            $table->string('title')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $config = config('permission.table_names');

        if (Schema::hasColumn($config['roles'], 'title')) {
            Schema::table($config['roles'], function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }

        if (Schema::hasColumn($config['permissions'], 'title')) {
            Schema::table($config['permissions'], function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
    }
}
