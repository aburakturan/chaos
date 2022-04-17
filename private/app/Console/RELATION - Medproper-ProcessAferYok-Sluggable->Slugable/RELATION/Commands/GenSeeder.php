<?php
namespace App\Console\Commands;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenSeeder extends GeneratorCommand
{
    protected $signature = 'make:genSeeder {name} {--force=}';
    protected $description = 'Add the new data to Seeder.';
    protected $type = 'Seeder';
    protected $ns = '';

    protected function getStub()
    {
        return 'database/seeds/PagesTableSeeder.php';

    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return 'database/seeds/PagesTableSeeder.php';
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        $argUpper=ucfirst($class);
        $argLower=lcfirst($class);

    $arg ="[
                'template' => '".$argUpper."',
                'tr' => [
                    'meta_title' => '".$argUpper."',
                    'meta_description' => '".$argUpper."',
                    'title' => '".$argUpper."',
                ],
                'en' => [
                    'title' => '".$argUpper."',
                ],
            ],

            //INNER_PART_FOR_STUB_GENERATION_DONT_DELETE";

        return str_replace('//INNER_PART_FOR_STUB_GENERATION_DONT_DELETE', $arg, $stub);
    }
}

