[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/rezaamini-ir/laravel-easypanel/build-status/master)

# EasyPanel
EasyPanel is a beautiful, customizable and flexible admin panel based on Livewire for Laravel.

![EasyPanel screenshots](https://aminireza.ir/EasyPanel.gif)

### Features :
- Easy to install
- Multi Language
- RTL and LTR mode
- Sort Data just with a click
- Support CKEditor and Persian Font for RTL mode
- Create CRUD for every model in 1 minute
- Manage route prefix and addresses
- A beautiful UI/UX with AdminMart template
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
Congrats! You installed the package, follow the [Usage](#usage) section.

## Usage:

First you have to define admins then You can create a CRUD for a model.
Follow the doc.

## Define Admins

In default EasyPanel uses `is_superuser` column in your `users` table to detect an admin (you can customize it).

**If you don't have any column in your users table you have to create a boolean column with is_superuser name then do these steps:**

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

## Multi Lang
If you want change language of Module You have to pass 2 steps: 

1 - copy `en_panel.json` file in `resources/lang` and paste it in this folder with your lang name like `fr_panel.json` then customize it.
File format must have `_panel.json` suffix, e.g: `fr_panel.json`, `fr` is your language like : fa, en, fr, ar, ..

2 - Set your `lang` in easy panel config file in `config/easy_panel.php` in `lang` key, this value must be equal to your suffix language file name in the lang directory, like `fr`.

## TODO
If you need TODO feature you have to publish TODO migration with this command 
```bash
php artisan panel:migration
```
It will publish TODO's migration file then you can migrate the migrations with `php artisan migrate`.

After pass these steps, You must set `todo` key in config file to `true`.

Now you have a TODO inside your panel for each admin.

## Config

### Base Config
| Key | Type | Description |
| --- | --- | --- |
| `enable` | `bool` | Module status |
| `todo` | `bool` | TODO feature status |
| `rtl_model` | `bool` | If you want a RTL base panel set it `true` |
| `lang` | `bool` | Your default language with this format : `**_panel.json` which you have to just use `**` like `en` or `fa` |
| `user_model` | `string` | Address of User model class |
| `auth_class` | `string` | Address of user authentication class |
| `admin_provider_class` | `string` | Address of user provider class |
| `column` | `string` | That column in `users` table which determine user is admin or not |
| `redirect_unauthorized` | `string` | If user is unauthenticated it will be redirected to this address |
| `route_prefix` | `string` | Prefix of admin panel address e.g: if set it `admin` address will be : http://127.0.0.1/admin |
| `pagination_count` | `int` | Count of data which is showed in read action |
| `lazy_mode` | `bool` | Lazy mode for Real-Time Validation |
| `actions` | `array` | List of enabled action which you have created a crud config for them. |

### CRUD Component methods
| Method/Property | Return Type | Description |
| --- | --- | --- |
| `create` | `bool` | Create Action for this model |
| `update` | `bool` | Update Action for this model |
| `delete` | `bool` | Delete Action for this model |
| `with_auth` | `bool` | It will fill `user_id` key for create and update action with `auth()->user()->id` |
| `getModel` | `string` | CRUD Model |
| `searchable` | `array` | Columns in model table which you want to search in read action |
| `validationRules` | `array` | Validation rules in create and update action (it uses Laravel validation system) |
| `inputs` | `array` | Input name as key and Input type as value (for update and create action) |
| `storePaths` | `array` | Where every files of inputs will store |
| `fields` | `array` | Every data which you want to show in read action (if data is related on other tables pass it as an array, key is relation name and value is column name in related table) |

## What do we use in this package?
- [AdminMart Template](https://adminmart.com/)
- [Livewire](https://github.com/livewire/livewire)
- [Laravel EasyBlade](https://github.com/rezaamini-ir/laravel-easyblade)
- [CKEditor 5](https://github.com/ckeditor/ckeditor5)
- [Vazir Font](https://github.com/rastikerdar/vazir-font)

## Contribution: 
If you feel you can improve our package You are free to send a pull request or submit an issue :)

## V2 Path 
- [ ] ACL System
- [ ] Logging System
- [x] CRUD Maker GUI
- [ ] File manager
- [x] RTL Style
- [x] Translation
- [ ] Custom menu
- [x] Relational inputs
- [ ] Multiple Templates
- [ ] More input types & editors
- [ ] Admin Manager page in panel
