# sso-client-module

## Installation

### Pre-requisite

Install the `nwidart/laravel-modules` and `joshbrw/laravel-module-installer` first.
```
composer require nwidart/laravel-modules
```
```
composer require joshbrw/laravel-module-installer
```
Publish the package's configuration file by running:
```
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```
At `composer.json`, setup autoload config
```json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/",
      "Database\\Factories\\": "database/factories/",
      "Database\\Seeders\\": "database/seeders/"
  }
}
```
Don't forget to run composer dump-autoload afterwards.


### Link Private Repos

At `composer.json`, add the following config:
```javascript
"require": {
        \\ other package...
        "marslabdev/sso-client-module": "dev-main"
    },
~
~
~
"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:marslabDev/sso-client-module.git"
        }
    ],
```
Run `composer update`.



