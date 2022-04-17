<?php

use App\Models\Entities\Permission;
use App\Models\Entities\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentencesTable extends Migration
{
    private $rootPermissions;
    private $adminPermissions;
    private $permissions;

    public function __construct()
    {
        $this->rootPermissions = [
            'admin.sentence.index' => 'Admin - Sentence: Index',
            'admin.sentence.edit' => 'Admin - Sentence: Edit',
            'admin.sentence.create' => 'Admin - Sentence: Create',
            'admin.sentence.delete' => 'Admin - Sentence: Delete',
            'admin.sentence.hard-delete' => 'Admin - Sentence: Hard Delete',
            'admin.sentence.restore' => 'Admin - Sentence: Restore',
        ];

        $this->adminPermissions = [
            'admin.sentence.index' => 'Admin - Sentence: Index',
            'admin.sentence.edit' => 'Admin - Sentence: Edit',
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentences', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('sentence_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sentence_id')->unsigned();
            $table->string('locale')->index();

            $table->longText('content')->nullable();

            $table->unique(['sentence_id','locale']);
            $table->foreign('sentence_id')->references('id')->on('sentences')->onDelete('cascade');
        });

        // Permissions
        $rootRole = Role::find(1);
        $adminRole = Role::find(2);

        foreach ($this->rootPermissions as $name => $title) {
            $permission = Permission::firstOrCreate([
                'name' => $name,
                'title' => $title,
            ]);

            if (!is_null($rootRole)) {
                $rootRole->givePermissionTo($permission);
            }
        }

        foreach ($this->adminPermissions as $name => $title) {
            $permission = Permission::firstOrCreate([
                'name' => $name,
                'title' => $title,
            ]);

            if (!is_null($adminRole)) {
                $adminRole->givePermissionTo($permission);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('sentences');
        Schema::dropIfExists('sentence_translations');

        // Permissions
        $this->permissions = array_merge($this->rootPermissions, $this->adminPermissions);

        foreach ($this->permissions as $name => $title) {
            $permission = Permission::where('name', $name)->first();

            if (!is_null($permission)) {
                $permission->delete();
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
