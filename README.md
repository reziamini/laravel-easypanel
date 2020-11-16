[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/build-status/master)

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
- Ajax search with [Livewire](https://github.com/livewire/livewire) in every column you want
 
# How to install:

First of all you must install package with composer :
```bash
composer require rezaamini-ir/laravel-easypanel
```
Next you should publish config, migration and views just with one command :
```bash
php artisan panel:install
``` 
**Congratulations! You have installed the package.**

If You need to add TODO feature in your project you should run this command to create todo table:
```bash
php artisan migrate
```
and you set the `todo` key in your config to `true`

## Configurations:

After run the `install:admin` command you are able to edit config file in `config/easy_panel.php`
There are lots of feature in config file you can edit or manage.

Imagine you want to create a CRUD action for a model, You can edit `actions` key in your config file like the basic example.

To create CRUDs action for all keys you must run this command : 
```bash
php artisan panel:crud
```
Or if you want to run command for just one key you can pass the key.
```bash
php artisan panel:crud article
```

To delete CRUDs action for all keys you can run this command : 
```bash
php artisan panel:delete
```
Or if you want to run command for just one key you can pass the key.
```bash
php artisan panel:delete article
```

There are some important notes about actions in your config file :
- the action key must be equal to model name in lower case
- every fields (values in your db) should be passed in `fields` key
- pass the true address of model 

After run this command you are able to edit and customize your CRUD in your project
- PHP Components address : `app/Http/Livewire/Admin/[ActionKey]`
- Blade Components address : `resources/views/livewire/admin/[actionKey]`

#### Create/Delete admin

There are 2 commands in EasyPanel which uses UserProvider class to set a user as an admin or remove it.

To set a user as an admin You can use this command :

```
php artisan panel:add 1
```

And to remove a user You can user this command : 

```
php artisan panel:remove 1
```

**1 is `user.id` here**

### What does every key in config file ?

- `enable` key gives you an option to disable or enable whole module, do you want to disable admin panel ? set it `false`
-  `todo` : it gives a `boolean` value. if You set it to `true` You will have a TODO list in your panel
- `user_model`, if You have a different model for users of you don't use from Laravel 8.x you should pass your own user model in this key.

As i said at top, EasyPanel is so flexible, You can pass your `UserProvider` or `Auth` class in config file. Image you have a separate table for admins and You don't use column for authenticate admins, You can write your own UserProvider and your own Auth class and pass it to config to use it.

What is `show` key in every action in config file ? It specifies what's column should be showed in CRUD list.
For example you want to show only title in your articles list, you can just pass the `title` to the `show` key in config file.

## What we use in this package:
- [AdminMart Template](https://adminmart.com/)
- [Livewire](https://github.com/livewire/livewire)
- [Laravel EasyBlade](https://github.com/rezaamini-ir/laravel-easyblade)

## Contribution: 
If you feel you can improve our package You are free to pull request & submit issue :)

## Todo 
- [ ] ACL System
- [ ] Logging System
- [ ] RTL Style
- [ ] Translation
- [ ] Separate CRUDs config
- [x] Make Command lines readable
- [ ] More input types & editors
- [ ] Add some unit tests
