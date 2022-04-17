<?php
namespace App\Console\Commands;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenResourceAdmin extends GeneratorCommand
{
    protected $signature = 'make:genResourceAdmin {name} {--force=}';
    protected $description = 'Add the new resource to Admin Routes.';
    protected $type = 'Resource';
    protected $ns = '';

    protected function getStub()
    {
        return 'routes/admin.php';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return 'routes/admin.php';
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        $argUpper=ucfirst($class);
        $argLower=lcfirst($class);

        $arg ="//".$argUpper."
Route::panelResource('".$argLower."', '".$argUpper."Controller', [
    'sortable' => true, 
    'softDelete' => true,
]);

//INNER_PART_FOR_STUB_GENERATION_DONT_DELETE
";

        return str_replace('//INNER_PART_FOR_STUB_GENERATION_DONT_DELETE', $arg, $stub);
    }
}

