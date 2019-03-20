# Laravel Settings
A laravel package for manage your app settings
<hr>

# Installation
```
composer require surya/laravel-settings
```
This package require laravel 5.5 or higher, if your current version of laravel is below 5.5 you could install this package but it isn't tested at all.

Register the ServiceProvider in `config/app.php`
```php
'providers' => [
    Surya\Setting\SettingServiceProvider::class,
]
```

Also register the Facade Alias
```php
'aliases' => [
    'Setting' => Surya\Setting\Facades\Setting::class,
]
```

Publish migration table
```
php artisan vendor:publish --provider="Surya\Setting\SettingServiceProvider::class" --tag="migrations"
```

Migrate
```
php artisan migrate
```

# Usage
By default the folder that use for store our setting is located in `resources/settings`, so you must create `settings` folder by your self.

## Creating Setting File
Let's create setting file call `general.php`
```php
return [
    'site_name'     => [
        'type'      => 'text',
        'default'   => 'Laravel',
        'label'     => 'Site Name'
    ],
    'genre'         => [
        'type'      => 'radio',
        'default'   => 'male',
        'label'     => 'Genre',
        'options'   => [
            'male'      => 'Male',
            'female'    => 'Female'
        ]
    ]
]
```
> the filename of setting also refer to group, used for getting setting value and prop
the setting file only containts an array of setting properties. the `site_name` is the key of the setting.

available setting properties:
1. type => the type of the setting, basically the input tag e.g: text, textarea, select, number, etc.
2. default => the default value of the setting.
3. label => the setting label.
4. options => this specific for type select and radio only.

## Rendering Setting File
After the setting file was created. You can render the setting file by using blade directive
```php
@rendersettings('general')
```
> the `@rendersettings` directive doesn't include the form tag, so you should render your setting between form tag
```php
<form method="POST" action="#yoursettingsaveroute">
    {!! csrf_field() !!}
    @rendersettings('general')
    <input type="submit" value="Save">
</form>
```
All the setting type are bootstrap friendly so it will adapt to your bootstrap theme.

## Saving Your Setting
You can simply use facade to saving settings
```php
use Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function save(Request $request)
    {
        Setting::save($request->except('_token'));
        return redirect('your.view');
    }
}
```

## Play With Value

Getting Setting Value
<hr>

There's three diffrent ways to getting setting value.
use the directive
```
@settings('filename.key')
```

use the helper function
```php
settings('group.key');
```

use the facade class
```php
Setting::get('group.key');
```

getting setting propperty
<hr>

```php
Setting::getSettingProp('group.key.default')
```
or
```php
setting('group.key.default')
```

checking if setting exists

```php
Setting::exists('group', 'key)
```
or
```php
settingExists('group', 'key')
```

## Modify Setting Type
You still has control for modify each of setting type or adding new setting type.

publish setting types view
```
php artisan vendor:publish --provider="Surya\Setting\SettingServiceProvider::class" --tag="views"
```
as you can see in `resources/view/vendor/setting/settings` each setting `type` view has exact name of `type` property, so if you want additional setting type just add another view file.

for example if you want create setting that accept email
```php
<div class="form-group">
    <label for="email-{{ $i }}">{{ $label }}</label>
    <input type="email" id="email-{{ $i }}" class="form-control" value="{{ $value }}" name="value[]">
</div>
```
> all properties for each setting key are automatically passed.
save as `email.blade.php` and it's automatically recognized as email setting type.
