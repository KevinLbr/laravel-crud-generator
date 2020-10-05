# Getting started

# Introduction

# Config


Dans le composer.json du projet 
```
"CkcNet\\CrudGenerator\\": "packages/ckcnet/crud-generator/src/"
```

Dans config/app.php
```
CkcNet\CrudGenerator\Crud`GeneratorServiceProvider::class,
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
php artisan ckc:crud [name]
```

/routes/web.php

```
Route::resource('[name]', 'Admin\[name]Controller');
Route::post('[name]/set-[name]-position-ajax', 'Admin\[name]Controller@ajaxPosition')->name('[name].position-ajax');
```

Crud is created

TODO
- ajouter dans la sidebar le li
- ajouter les routes auto
- fichier de config pour savoir quel nom de colonne correspond a un type file, etc
- les infos gender, name, plurial etc sont pas forcement bien placé dans le controler, peut etre les mettre dans un fichier de conf ou de translation ?
- pour plus de flexibilité, gerer les vues des stubs autrement, c'est a dire, faire seulement les form, pour le reste (edit, create, index) ça depend de l'administration, donc faire que les _form, et un table pour le listing, qui devront etre include dans les vues en question
- améliorer les rules ?
- faire la doc 
 