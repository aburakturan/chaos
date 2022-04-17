<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Artisan;

class Gen extends Command
{

    protected $signature = 'make:gen {name} {--t|type=}';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $model = $this->argument('name');

        /*
         * 1 - Create migration
         * php artisan php artisan make:genCreateMigrate {name} {--t|type=}
         * -t with_translation | without_translation
         **/

        if ($this->options()['type']=='with_translation')
        {
            $command_1 = 'php artisan make:genCreateMigrate '.$model.' -t with_translation';
        }
        elseif ($this->options()['type']=='without_translation')
        {
            $command_1 = 'php artisan make:genCreateMigrate '.$model.' -t without_translation';
        }

        shell_exec($command_1);


        /*
         * 2- php artisan migrate
         * php artisan php artisan make:GenMigrate || php artisan migrate
         **/

        $command_2 = 'php artisan make:GenMigrate';
        shell_exec($command_2);

        /*
         * 3- Adding the Article Resources to the admin routes file
         * php artisan php artisan make:genResourceAdmin {model} --force force
         **/

        $command_3 = 'php artisan make:genResourceAdmin '.$model.' --force force';
        shell_exec($command_3);

        /*
         * 4- Add the Article links to the admin sidebar
         * php artisan php artisan make:genSidebarAdmin {model} --force force
         **/

        $command_4 = 'php artisan make:genSidebarAdmin '.$model.' --force force';
        shell_exec($command_4);

        /*
         * 5- Create the Admin ArticleController.php
         * php artisan php artisan make:genControllerAdmin {model}
         **/

        $command_5 = 'php artisan make:genControllerAdmin '.$model;
        shell_exec($command_5);

        /*
         * 6- Create the Article Entity
         * php artisan php artisan make:genCreateEntity {model}
         **/

        $command_6 = 'php artisan make:genCreateEntity '.$model;
        shell_exec($command_6);

        /*
         * 7- Create the Article_Translation Entity
         * php artisan php artisan make:genCreateEntityTranslation {model}
         **/

        if ($this->options()['type']=='with_translation')
        {
            $command_7 = 'php artisan make:genCreateEntityTranslation '.$model;
            shell_exec($command_7);
        }


        /*
         * 8- Create Admin/Article View Files / From
         * php artisan php artisan make:genFormViewAdmin {model}
         **/


        $command_8 = 'php artisan make:genFormViewAdmin '.$model;
        shell_exec($command_8);

        /*
         * 9- Create Admin/Article View Files / Index
         * php artisan php artisan make:genIndexViewAdmin {model}
         **/

        $command_9 = 'php artisan make:genIndexViewAdmin '.$model;
        shell_exec($command_9);

        /*
         * 10- Add related informations to the Page Seeder
         * php artisan php artisan make:genSeeder {model} --force force
         **/

        $command_10 = 'php artisan make:genSeeder '.$model.' --force force';
        shell_exec($command_10);


        /*
         * 11- php artisan db:seed
         * php artisan php artisan make:genDbSeed || php artisan db:seed
         **/

        $command_11 = 'php artisan make:genDbSeed';
        shell_exec($command_11);

        /*
         * 12- Create Web Views/ Main
         * php artisan php artisan make:genWebMainView {model}
         **/

        $command_12 = 'php artisan make:genWebMainView '.$model;
        shell_exec($command_12);

        /*
         * 13- Create Web View / Detail
         * php artisan php artisan make:genWebDetailView {model}
         **/

        $command_13 = 'php artisan make:genWebDetailView '.$model;
        shell_exec($command_13);

        /*
         * 14- Adding the Article Web Resources to the web routes file
         * php artisan php artisan make:genResourceWeb {{model}} --force force
         **/

        $command_14 = 'php artisan make:genResourceWeb '.$model.' --force force';
        shell_exec($command_14);

        /*
         * 15- Create the Web ArticleController.php
         * php artisan php artisan make:genControllerWeb {model}
         **/

        $command_15 = 'php artisan make:genControllerWeb '.$model;
        shell_exec($command_15);



    }

}
