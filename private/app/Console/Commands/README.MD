php artisan make:gen Campaign -t with_translation

'resources/views/admin/template/sidebar.blade.php'
{{--INNER_PART_FOR_STUB_GENERATION_DONT_DELETE--}}'

'database/seeds/PagesTableSeeder.php'
//INNER_PART_FOR_STUB_GENERATION_DONT_DELETE"


'routes/web.php'
//INNER_PART_FOR_STUB_GENERATION_DONT_DELETE"
       
'routes/admin.php
//INNER_PART_FOR_STUB_GENERATION_DONT_DELETE



# Gen V0.1

### Fire Starter
```
php artisan make:gen {model} -t with_translation
```


::1- Create migration::
```
php artisan make:genCreateMigrate {model} {—t|type=}
——t with_translation | without_translation
```

::2- Do migration::
```
php artisan make:GenMigrate || php artisan migrate
```


 ::3- Adding the Article Resources to the admin routes file::
```
php artisan make:genResourceAdmin {model} —-force force
```


::4- Add the Article links to the admin sidebar::
```
 php artisan make:genSidebarAdmin {model} —-force force
```

 ::5- Create the Admin ArticleController.php::
```
 php artisan make:genControllerAdmin {model}
```

::6- Create the Article Entity::
```
php artisan make:genCreateEntity {model}
```

 ::7- Create the Article_Translation Entity::
```
 php artisan make:genCreateEntityTranslation {model}
```

::8- Create Admin/Article View Files / From::
```
php artisan make:genFormViewAdmin {model}
```

::9- Create Admin/Article View Files / Index::
```
 php artisan make:genIndexViewAdmin {model}
```

::10- Add related informations to the Page Seeder::
```
 php artisan make:genSeeder {model} —-force force
```

::11- Do db:seed::
```
 php artisan make:genDbSeed || php artisan db:seed
```

::12- Create Web Views/ Main::
```
 php artisan make:genWebMainView {model}
```

::13- Create Web View / Detail::
```
 php artisan make:genWebDetailView {model}
```

::14- Adding the Article Web Resources to the web routes file::
```
 php artisan make:genResourceWeb {{model}} —-force force
```

 ::15- Create the Web ArticleController.php::
```
 php artisan make:genControllerWeb {model}
```



# Gen Develops
1 -> HBC Integrated Gen 
	AppServiceProvider -> panelResources
	Admin Issues -> Process method

2 ->  Relation between Models via standart Gen and HBC standart of Gen 
3 -> Canonical Integration 