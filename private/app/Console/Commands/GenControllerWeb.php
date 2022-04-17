<?php
namespace App\Console\Commands;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenControllerWeb extends GeneratorCommand
{
    protected $signature = 'make:genControllerWeb {name}';
    protected $description = 'Create a new Web Controller.';
    protected $type = 'Controller';
    protected $ns = '\Http\Controllers\Web';

    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $this->files->put($path, $this->buildArguments($name,$path));

        $this->info($this->ns."\\".$class.$this->type.' created successfully.');
    }

    protected function buildArguments($name,$path)
    {
        $stub = $this->files->get($path);

        return $this->replaceNamespace($stub, $name)->replaceArguments($stub, $name);
    }

    protected function getStub()
    {
        return app_path() . '/Console/Stubs/ControllerWeb.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . $this->ns;
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'Controller.php';
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        if ( ctype_upper( $class[0] ))  $arg = $class;
        else $arg = ucfirst($class);

        return str_replace('$$Dummy_Model_Name_Upper$$', $arg, $stub);
    }

    protected function replaceArguments($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        if ( ctype_upper( $class[0] ))  $arg = lcfirst($class);
        else $arg = $class;

        return str_replace('$$Dummy_Model_Name_Lower$$', $arg, $stub);
    }



}

