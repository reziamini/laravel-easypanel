[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/build-status/master)

# EasyPanel
EasyPanel is a beautiful, customizable and flexible admin panel based on Livewire for Laravel.

![EasyPanel screenshots](https://linkpicture.com/q/Screenshot-2020-11-07-201015.png)

### Features :
- Easy to install
- Create CRUD for every model in 1 minute
- Manage route prefix and addresses
- Beautiful UI/UX with AdminMart template
- Add/remove Admins with command line
- UserProviders and Authentication classes are customizable and you can change them 
- You can create your own routes and customize view and components
- Manage pagination count
- Real time validation with [Livewire](https://github.com/livewire/livewire)
- A small and beautiful TODO (You can disable it in config)
- Create a nice and responsive view based on your data in config file for every CRUDs
- Strong commands to manage package
- Custom validation based on config file
- Ajax search with [Livewire](https://github.com/livewire/livewire) in every column which you want

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

### Base Config
| Key | Type | Description |
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
| `lazy_mode` | `bool` | Lazy mode for Real-Time Validation |
| `actions` | `array` | List of enabled action which you have created a crud config for them. |

### CRUD Config
| Key | Type | Description |
| --- | --- | --- |
| `model` | `string` | CRUD Model |
| `search` | `array` | Columns in model table which you want to search in read action |
| `create` | `bool` | Create Action for this model |
| `update` | `bool` | Update Action for this model |
| `delete` | `bool` | Delete Action for this model |
| `validation` | `array` | Validation rules in create and update action (it uses Laravel validation system) |
| `fields` | `array` | Fields as key and type as value (for update and create action) |
| `store` | `array` | Where every files of inputs will store |
| `extra_values` | `array` | Extra values which you want to pass create and update method as extra param |
| `show` | `array` | Every data which you want to show in read action (if data is related on other tables pass it as an array, key is relation name and value is column name in related table) |

## What do we use in this package?
- [AdminMart Template](https://adminmart.com/)
- [Livewire](https://github.com/livewire/livewire)
- [Laravel EasyBlade](https://github.com/rezaamini-ir/laravel-easyblade)
- [CKEditor 5](https://github.com/ckeditor/ckeditor5)

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
- [ ] Multiple Templates
- [x] Separate CRUDs config
- [x] Make Command lines readable
- [ ] More input types & editors
- [ ] Admin Manager page in panel
- [ ] Add some unit tests
