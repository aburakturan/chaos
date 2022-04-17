<?php
namespace App\Console\Commands;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenSidebarAdmin extends GeneratorCommand
{
    protected $signature = 'make:genSidebarAdmin {name} {--force=}';
    protected $description = 'Add the new data to Admin Sidebar.';
    protected $type = 'SideBar';
    protected $ns = '';

    protected function getStub()
    {
        return 'resources/views/admin/template/sidebar.blade.php';

    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return 'resources/views/admin/template/sidebar.blade.php';
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        $argUpper=ucfirst($class);
        $argLower=lcfirst($class);

    $arg ='{{-- '.$argUpper.' Resources --}}
            @if (auth()->user()->can(\'admin.'.$argLower.'.index\'))
                <li class="nav-item start">
                    <a href="{{ route(\'admin.'.$argLower.'.index\') }}" class="nav-link">
                        <i class="icon-notebook"></i>
                        <span class="title">'.$argUpper.' Module</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            {{--INNER_PART_FOR_STUB_GENERATION_DONT_DELETE--}}';

        return str_replace('{{--INNER_PART_FOR_STUB_GENERATION_DONT_DELETE--}}', $arg, $stub);
    }
}

