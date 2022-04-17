<?php
namespace App\Console\Commands;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenCreateRelationMigrate extends GeneratorCommand
{
    protected $signature = 'make:genCreateRelationMigrate {name} {relation} {--t|type=}';
    protected $description = 'Create a new Relation Migration.';
    protected $type = 'Migration';
    protected $ns = '';


    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $relation = $this->argument('relation');


        $path = $this->getPath($name);

        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->files->put($path, $this->buildArguments($name,$path));

        $this->files->put($path, $this->buildArgumentRelationLower($relation,$path));
        $this->files->put($path, $this->buildArgumentRelationUpper($relation,$path));

        $this->info($this->ns."\\".$class.$this->type.' created successfully.');
    }

    protected function buildArguments($name,$path)
    {
        $stub = $this->files->get($path);

        return $this->replaceNamespace($stub, $name)->replaceArguments($stub, $name);
    }

    protected function buildArgumentRelationLower($relation,$path)
    {
        $stub = $this->files->get($path);

        return $this->replaceNamespace($stub, $relation)->replaceArgumentRelationLower($stub, $relation);
    }

    protected function buildArgumentRelationUpper($relation,$path)
    {
        $stub = $this->files->get($path);

        return $this->replaceNamespace($stub, $relation)->replaceArgumentRelationUpper($stub, $relation);
    }

    protected function getStub()
    {
        if ($this->options()['type']=='with_translation')
        {
            return app_path() . '/Console/Stubs/MigrationRelationTranslation.stub';
        }
        elseif ($this->options()['type']=='without_translation')
        {
            return app_path() . '/Console/Stubs/MigrationWithoutTranslation.stub';
        }
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . $this->ns;
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return 'database/migrations/'.date('Y_m_d_His').'_create_'.lcfirst($this->argument('name')).'_'.lcfirst($this->argument('relation')).'_pivot_table.php';
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
    protected function replaceArgumentRelationLower($stub, $relation)
    {
        $class = str_replace($this->getNamespace($relation).'\\', '', $relation);

        if ( ctype_upper( $class[0] ))  $arg = lcfirst($class);
        else $arg = $class;

        return str_replace('$$Dummy_Model_Name_Relation_Lower$$', $arg, $stub);
        
    }

    protected function replaceArgumentRelationUpper($stub, $relation)
    {
        $class = str_replace($this->getNamespace($relation).'\\', '', $relation);

        if ( ctype_upper( $class[0] ))  $arg = $class;
        else $arg = ucfirst($class);

        return str_replace('$$Dummy_Model_Name_Relation_Upper$$', $arg, $stub);
    }



}

