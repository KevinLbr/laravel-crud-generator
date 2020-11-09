# Getting started

# Introduction

# Config


Dans le composer.json du projet 
```
"KevinLbr\\CrudGenerator\\": "packages/kevinlbr/crud-generator/src/"
```

Dans config/app.php
```
KevinLbr\CrudGenerator\Crud`GeneratorServiceProvider::class,
```

et 
```
composer dump-autoload
php artisan vendor:publish --tag=crud-generator
```

# How use
```
php artisan make:migration create_[nameS]_table
php artisan migrate
php artisan kevinlbr:crud [name]
```

/routes/web.php

```
Route::resource('[name]', 'Admin\[name]Controller');
Route::post('[name]/set-[name]-position-ajax', 'Admin\[name]Controller@ajaxPosition')->name('[name].position-ajax');
```

Crud is created

TODO
- ajouter les routes auto
- Interface ou trait séparé du model, pour recup le necessaire concernant le model
- Pas de copie de create, edit, index, juste d'un _form, pour plus de flexibilité
- faire la doc 
- les trad (gender_name, ..) doivent etre dans lang (prefix singulier, prefix pluriel, nom singulier, nom pluriel)
- améliorer les rules ?
- Tests
