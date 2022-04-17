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
         * php artisan make:genCreateMigrate {name} {--t|type=}
         * -t with_translation | without_translation
         **/

        if ($this->options()['type']=='with_translation')
        {
            $command_1 = 'make:genCreateMigrate '.$model.' -t with_translation';
        }
        elseif ($this->options()['type']=='without_translation')
        {
            $command_1 = 'make:genCreateMigrate '.$model.' -t without_translation';
        }

        Artisan::call($command_1);

        /*
         * 2- php artisan migrate
         * php artisan make:GenMigrate || php artisan migrate
         **/

        $command_2 = 'make:GenMigrate';
        Artisan::call($command_2);

        /*
         * 3- Adding the Article Resources to the admin routes file
         * php artisan make:genResourceAdmin {model} --force force
         **/

        $command_3 = 'make:genResourceAdmin '.$model.' --force force';
        Artisan::call($command_3);

        /*
         * 4- Add the Article links to the admin sidebar
         * php artisan make:genSidebarAdmin {model} --force force
         **/

        $command_4 = 'make:genSidebarAdmin '.$model.' --force force';
        Artisan::call($command_4);

        /*
         * 5- Create the Admin ArticleController.php
         * php artisan make:genControllerAdmin {model}
         **/

        $command_5 = 'make:genControllerAdmin '.$model;
        Artisan::call($command_5);

        /*
         * 6- Create the Article Entity
         * php artisan make:genCreateEntity {model}
         **/

        $command_6 = 'make:genCreateEntity '.$model;
        Artisan::call($command_6);

        /*
         * 7- Create the Article_Translation Entity
         * php artisan make:genCreateEntityTranslation {model}
         **/

        if ($this->options()['type']=='with_translation')
        {
            $command_7 = 'make:genCreateEntityTranslation '.$model;
            Artisan::call($command_7);
        }


        /*
         * 8- Create Admin/Article View Files / From
         * php artisan make:genFormViewAdmin {model}
         **/


        $command_8 = 'make:genFormViewAdmin '.$model;
        Artisan::call($command_8);

        /*
         * 9- Create Admin/Article View Files / Index
         * php artisan make:genIndexViewAdmin {model}
         **/

        $command_9 = 'make:genIndexViewAdmin '.$model;
        Artisan::call($command_9);

        /*
         * 10- Add related informations to the Page Seeder
         * php artisan make:genSeeder {model} --force force
         **/

        $command_10 = 'make:genSeeder '.$model.' --force force';
        Artisan::call($command_10);


        /*
         * 11- php artisan db:seed
         * php artisan make:genDbSeed || php artisan db:seed
         **/

        $command_11 = 'make:genDbSeed';
        Artisan::call($command_11);

        /*
         * 12- Create Web Views/ Main
         * php artisan make:genWebMainView {model}
         **/

        $command_12 = 'make:genWebMainView '.$model;
        Artisan::call($command_12);

        /*
         * 13- Create Web View / Detail
         * php artisan make:genWebDetailView {model}
         **/

        $command_13 = 'make:genWebDetailView '.$model;
        Artisan::call($command_13);

        /*
         * 14- Adding the Article Web Resources to the web routes file
         * php artisan make:genResourceWeb {{model}} --force force
         **/

        $command_14 = 'make:genResourceWeb '.$model.' --force force';
        Artisan::call($command_14);

        /*
         * 15- Create the Web ArticleController.php
         * php artisan make:genControllerWeb {model}
         **/

        $command_15 = 'make:genControllerWeb '.$model;
        Artisan::call($command_15);



    }

}
