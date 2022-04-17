<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entities\Category;
use App\Models\Entities\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends AdminController
{

    protected $pageMeta = [
        'title' => 'Categorys',
        'desc' => 'Ekle, düzenle, kategorile, sırala, sil',
    ];

    protected $modelMeta = [
        'name' => 'category',
        'singularTitle' => 'Category',
        'pluralTitle' => 'Categorys',
        'deleteTitle' => 'Category',
    ];


    public function process(Request $request, string $type, $id = null)
    {
        if ($type == 'store') {
            $row = new Category;
        } else {
            $row = Category::withTrashed()->withDepth()->findOrFail($id);
        }

        // Set Fields
        $row->fill($request->all());
        $row->redirect_first_child = (bool) $request->get('redirect_first_child');

        // Set Images
        if ($row->imageAttributes) {
            foreach ($row->imageAttributes as $imageKey => $imageAttributes) {
                $row->setImage($request, $imageKey);
            }
        }

        return $this->processAfter($row, $type);
    }

    public function index($rows = null)
    {
        $rows = Category::withDepth()->defaultOrder()->get();

        return parent::index($rows);
    }

    public function sort($rows = null)
    {
        $rows = Category::withDepth()->defaultOrder()->get()->toTree();

        return parent::sort($rows);
    }

    public function rebuildTree(Request $request)
    {
        $nestedSet = json_decode($request->nestable_list, true);

        Category::rebuildTree($nestedSet);

        $this->generateFlashMessage('success', 'Sıralamalar ve alt öğeler güncellendi!');

        return redirect()->route('admin.'.$this->modelMeta['name'].'.sort');
    }

    public function trash($rows = null)
    {
        $rows = Category::onlyTrashed()->withDepth()->defaultOrder()->get();

        return parent::trash($rows);
    }

    public function create($row = null)
    {
        $row = new Category;

        return parent::create($row);
    }

    public function store(Request $request)
    {
        return $this->process($request, 'store');
    }

    public function edit($id)
    {
        $row = Category::withTrashed()->findOrFail($id);

        return parent::edit($row);
    }

    public function update(Request $request, $id)
    {
        return $this->process($request, 'update', $id);
    }

    public function deleteConfirmation($id)
    {
        $row = Category::findOrFail($id);

        return parent::deleteConfirmation($row);
    }

    public function destroy($id)
    {
        $row = Category::findOrFail($id);

        return parent::destroy($row);
    }

    public function hardDeleteConfirmation($id)
    {
        $row = Category::withTrashed()->findOrFail($id);

        return parent::hardDeleteConfirmation($row);
    }

    public function hardDelete($id)
    {
        $row = Category::withTrashed()->findOrFail($id);

        return parent::hardDelete($row);
    }

    public function restoreConfirmation($id)
    {
        $row = Category::withTrashed()->findOrFail($id);

        return parent::restoreConfirmation($row);
    }

    public function restore($id)
    {
        $row = Category::withTrashed()->findOrFail($id);

        return parent::restore($row);
    }
}
