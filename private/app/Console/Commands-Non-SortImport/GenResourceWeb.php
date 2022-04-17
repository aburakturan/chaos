<?php
namespace App\Console\Commands;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenResourceWeb extends GeneratorCommand
{
    protected $signature = 'make:genResourceWeb {name} {--force=}';
    protected $description = 'Add the new resource to Admin Routes.';
    protected $type = 'Resource';
    protected $ns = '';

    protected function getStub()
    {
        return 'routes/web.php';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return 'routes/web.php';
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        $argUpper=ucfirst($class);
        $argLower=lcfirst($class);

 $arg ="// ".$argUpper." Resource
        \$".$argLower."Page = App\Models\Entities\Page::whereTemplate('".$argUpper."')->first();
        if (!is_null(\$".$argLower."Page) && !is_null(\$".$argLower."Page->getSlug(\$locale))) {
            Route::get(\$".$argLower."Page->getSlug(\$locale), [
                'uses' => '".$argUpper."Controller@index',
                'as' => 'web.' . \$locale . '.".$argLower.".index',
            ]);

            Route::get(\$".$argLower."Page->getSlug(\$locale) . '/{slug}', [
                'uses' => '".$argUpper."Controller@detail',
                'as' => 'web.' . \$locale . '.".$argLower.".detail',
            ]);
        }
        
        //INNER_PART_FOR_STUB_GENERATION_DONT_DELETE";

        return str_replace('//INNER_PART_FOR_STUB_GENERATION_DONT_DELETE', $arg, $stub);
    }
}

