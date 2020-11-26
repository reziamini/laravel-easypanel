[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/build-status/master)

# EasyPanel
EasyPanel is a beautiful admin panel based on Livewire and Live and it's a full customizable.

![EasyPanel screenshots](https://linkpicture.com/q/Screenshot-2020-11-07-201015.png)

### Features :
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

## Install:

1. Install the Package in Laravel project with Composer.
```bash
composer require rezaamini-ir/laravel-easypanel
```
2. Publish EasyPanel files with one command : 
```
php artisan panel:install
```
Congrats! You installed the package, follow docs.

## Usage:
You can create a CRUD for a model, use todo feature, settings option and etc.


### Make a CRUD:

---
1 . Create a CRUD config with this command:

```bash
php artisan panel:config [name] -m [MODEL]
```
[name]: action name (should be equals to model name in lower case word)
[MODEL]: Model name

2 . Edit CRUD config in `resources/cruds/name.php` based on your needs

3 . Run CRUD creator command to make CRUD files and components :

```bash
php artisan panel:crud [name]
```
Now You have a few files and components for CRUD action of this model
- Livewire PHP Component stored in : `app/Http/Livewire/Admin/Name`
- Livewire Blade Component stored in : `resources/views/livewire/admin/name`

You are free to make change in components and edit them.


### Manage Admins

---
in default EasyPanel use `is_superuser` column in your `users` table to detect an admin and you can customize it.

Run this command out to make a user as an admin:
```bash
php artisan panel:add [user_id]
```

To remove an admin you can execute this command:
```bash
php artisan panel:remove [user_id]
```

`[user_id]` : It's id of user that you want to make as an admin

**These commands use UserProvider class in EasyPanel and You can use your own class instead of that and pass it in config file**


## Config

| Key | Value | Description |
| --- | --- | --- |
| `enable` | `bool` | Module status |
| `todo` | `bool` | TODO feature status |
| `user_model` | `string` | Address of User model class |
| `auth_class` | `string` | Address of user authentication class |
| `admin_provider_class` | `string` | Address of user provider class |
| `admin_provider_class` | `string` | Address of user provider class |
| `column` | `string` | That column in `users` table which determine user is admin or not |
| `redirect_unauthorized` | `string` | If user is unauthenticated it will be redirected to this address |
| `route_prefix` | `string` | Prefix of admin panel address e.g: if set it `admin` address will be : http://127.0.0.1/admin |
| `pagination_count` | `int` | Count of data which is showed in read action |
| `actions` | `array` | List of enabled action which you have created a crud config for them. |

## What we use in this package:
- [AdminMart Template](https://adminmart.com/)
- [Livewire](https://github.com/livewire/livewire)
- [Laravel EasyBlade](https://github.com/rezaamini-ir/laravel-easyblade)

## Contribution: 
If you feel you can improve our package You are free to pull request & submit issue :)

## V2 Path 
- [ ] ACL System
- [ ] Logging System
- [ ] File manager
- [ ] RTL Style
- [ ] Translation
- [ ] Custom menu
- [ ] Relational inputs
- [x] Separate CRUDs config
- [x] Make Command lines readable
- [ ] More input types & editors
- [ ] Add some unit tests
