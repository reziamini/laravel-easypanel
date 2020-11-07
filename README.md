# Laravel Easy Panel
A flexible and beautiful admin panel based on Livewire with lots of feature.

<img src="https://linkpicture.com/q/Screenshot-2020-11-07-201015.png"> 

# Features:

- Create CRUD in config file.
- Manage route prefix and addresses
- Beautiful UI/UX with AdminMart template
- Add/remove Admins with command line
- Every UserProviders and Authentication classes are customizable and you can change them 
- You can create your own routes and customize our views and components
- Manage pagination count
- Real time validation with [Livewire](https://github.com/livewire/livewire)
- Customize every actions in your project
- A small and beautiful TODO (You can disable it in your config)
- Create a nice and responsive view based on your data in config file for every CRUDs
- Custom validation based on config file
 
# How to install:

First of all you must install package with composer :
```bash
composer require rezaamini-ir/laravel-easypanel
```
Next you should publish config, migration and views just with one command :
```bash
php artisan install:admin
``` 

If You need to add TODO feature in your project you should run this command out to create todo table:
```bash
php artisan migrate
```
and you don't want this option please set `todo` key in your config to `false`

Congratulations. now You have installed the package.

## Configurations:

After run the `install:admin` command you are able to edit config file in `config/easy_panel.php`
There are lots of feature in config file you can edit or manage.

Imagine you want to create a CRUD action for a model, You can edit `actions` key in your config file like the basic example.

To create CRUDs action for all keys you must run this command : 
```bash
php artisan crud:all
```
Or if you want to run command for just one key you can pass the key.
```bash
php artisan crud:all article
```

There are some important notes about actions in your config file :
- the action key must be equal to model name in lower case
- every fields (values in your db) should be passed in `fields` key
- pass the true address of model 

After run this command you are able to edit and customize your CRUD in your project
- PHP Components address : `app/Http/Livewire/Admin/[ActionKey]`
- Blade Components address : `resources/views/livewire/admin/[actionKey]`

## What we use in this package:
- [AdminMart Template](https://adminmart.com/)
- [Livewire](https://github.com/livewire/livewire)
- [Laravel EasyBlade](https://github.com/rezaamini-ir/laravel-easyblade)

## Contribution: 
If you feel you can improve our package You are free to pull request & submit issue :)
