<?php

use App\Models\Entities\Page;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete All Pages
        $pages = Page::all();
        foreach ($pages as $row) {
            $row->forceDelete();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Page::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // Set new pages
        $pages = [
            [
                'template' => 'Home',
                'tr' => [
                    'title' => 'Ana Sayfa',
                    'force_slug' => '/',
                ],
                'en' => [
                    'title' => 'Home Page',
                    'force_slug' => '/',
                ],
            ],
            [
                'template' => 'Article',
                'tr' => [
                    'meta_title' => 'Article',
                    'meta_description' => 'Article',
                    'title' => 'Article',
                ],
                'en' => [
                    'title' => 'Article',
                ],
            ],

            [
                'template' => 'Lazanya',
                'tr' => [
                    'meta_title' => 'Lazanya',
                    'meta_description' => 'Lazanya',
                    'title' => 'Lazanya',
                ],
                'en' => [
                    'title' => 'Lazanya',
                ],
            ],

            [
                'template' => 'Category',
                'tr' => [
                    'meta_title' => 'Category',
                    'meta_description' => 'Category',
                    'title' => 'Category',
                ],
                'en' => [
                    'title' => 'Category',
                ],
            ],

            //INNER_PART_FOR_STUB_GENERATION_DONT_DELETE
        ];

        // Create
        foreach ($pages as $attributes) {
            $this->createRow($attributes);
        }
    }

    public function createRow($attributes, $parent = null)
    {
        $children = array_pull($attributes, 'children');

        // Create instance
        $instance = Page::create($attributes);

        if ($parent) {
            $instance->appendToNode($parent);
        }
        $instance->save();

        // Create children
        $relation = new \Illuminate\Database\Eloquent\Collection;
        foreach ((array)$children as $child) {
            $relation->add($child = $this->createRow($child, $instance));
            $child->setRelation('parent', $instance);
        }
        $instance->refreshNode();
        return $instance->setRelation('children', $relation);
    }
}
