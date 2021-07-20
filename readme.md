# LaravelUniqueSluggable

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This package allows you to create unique slugs. It keeps all the slugs you define in the slugs table. It also satisfies all requests and directs it to the controller you define in your model.

## Installation
``` bash
composer require oguzcandemircan/laravel-unique-sluggable
```

## Usage

Your models should use the `OguzcanDemircan\LaravelUniqueSluggable\HasSlug` trait and define `slugSource` property
```php
<?php

namespace App\Models;

...
use OguzcanDemircan\LaravelUniqueSluggable\HasSlug;

class Page extends Model
{
    use HasFactory;
    use HasSlug;
    
    protected $slugSource = 'title';
```
```php
use App\Models\Page;
use App\Models\Post;

Page::create(['title' => 'Great Title']);
//Slug is great-title
Post::create(['title' => 'Great Title']);
//you get eror
```
If you want all your requests to be captured and routed automatically, you should add the `controller` property to your model.
```php
protected $controller [PageController::class, 'show'];
```
When your application receives a request, `OguzcanDemircan\LaravelUniqueSluggable\Controllers\SlugController` calls the controller class you defined in your model if there is a matching slug.


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Oğuzcan Demircan][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](LISANCE) for more information.

[ico-version]: https://img.shields.io/packagist/v/oguzcandemircan/laraveluniquesluggable.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/oguzcandemircan/laraveluniquesluggable.svg?style=flat-square


[link-packagist]: https://packagist.org/packages/oguzcandemircan/laraveluniquesluggable
[link-downloads]: https://packagist.org/packages/oguzcandemircan/laraveluniquesluggable
[link-author]: https://github.com/oguzcandemircan
[link-contributors]: ../../contributors
