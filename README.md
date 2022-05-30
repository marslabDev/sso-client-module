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
```javascript
{
  "autoload": {
    "psr-4": {
      \\ other folders/namespaces...
      "Modules\\": "Modules/",
  }
}
```
Don't forget to run
```
composer dump-autoload
```



### Link Private Repos

At `composer.json`, add the following config:
```javascript
"require": {
        \\ other package...
        "marslabdev/sso-client-module": "dev-main"
    },

...

"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:marslabDev/sso-client-module.git"
        }
    ],
```
Last but not least
```
composer update
```

P.S: If this is your first time installation. GitHub may ask you to create OAuth Token to bypass the API rate limit from calling the repos. Follow the instructions given by GitHub by click the link to generate your own Personal Access Token.


