# HtmlMin: Laravel package for HTML minification

Very simple (and very fast) html compression.

<p style="text-align: center;" align="center">
    <img alt="Laravel HtmlMin" src="https://github.com/abordage/laravel-html-min/blob/master/docs/images/abordage-laravel-html-min-cover.png">
</p>

<p style="text-align: center;" align="center">

<a href="https://packagist.org/packages/abordage/laravel-html-min" title="Packagist version">
    <img alt="Packagist Version" src="https://img.shields.io/packagist/v/abordage/laravel-html-min">
</a>

<a href="https://scrutinizer-ci.com/g/abordage/laravel-html-min/" title="Scrutinizer Quality Score">
    <img alt="Scrutinizer Quality Score" 
         src="https://scrutinizer-ci.com/g/abordage/laravel-html-min/badges/quality-score.png?b=master">
</a>

<a href="https://github.com/abordage/laravel-html-min/actions/workflows/tests.yml" title="GitHub Tests Status">
    <img alt="GitHub Tests Status" src="https://img.shields.io/github/workflow/status/abordage/laravel-html-min/Tests?label=tests">
</a>


<a href="https://github.com/abordage/laravel-html-min/actions/workflows/tests.yml" title="GitHub Code Style Status">
    <img alt="GitHub Code Style Status" src="https://img.shields.io/github/workflow/status/abordage/laravel-html-min/PHP%20CS%20Fixer?label=code%20style">
</a>



<a href="https://www.php.net/" title="PHP version">
    <img alt="PHP Version Support" src="https://img.shields.io/packagist/php-v/abordage/laravel-html-min">
</a>

<a href="https://github.com/abordage/laravel-html-min/blob/master/README.md" title="License">
    <img alt="License" src="https://img.shields.io/github/license/abordage/laravel-html-min">
</a>

</p>


## Features:
- Removing extra whitespaces
- Removing html comments (works correctly with `livewire/livewire` comments)
- Skip `textarea`, `pre` and `script` elements
- Very fast. See benchmark

## Requirements
- PHP 7.4 or higher
- Laravel 8+

## Installation

You can install the package via composer:

```bash
composer require abordage/laravel-html-min
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="html-min-config"
```
## Usage
To enable compression just register middleware:

```php
// app/Http/Kernel.php

protected $middleware = [
    'web' => [
        // other middleware
        
        \Abordage\LaravelHtmlMin\Middleware\HtmlMinify::class,
    ],
    
    // ...
];
```

It's all. Optionally you can change the settings in `config/html-min.php`

## Configuration

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Enable Html Min
    |--------------------------------------------------------------------------
    */
    'enable' => env('HTML_MINIFY', true),

    /*
    |--------------------------------------------------------------------------
    | Find DOCTYPE in document
    |--------------------------------------------------------------------------
    */
    'find_doctype_in_document' => true,

    /*
    |--------------------------------------------------------------------------
    | Remove whitespace between tags
    |--------------------------------------------------------------------------
    */
    'remove_whitespace_between_tags' => true,

    /*
    |--------------------------------------------------------------------------
    | Remove blank lines in script elements
    |--------------------------------------------------------------------------
    */
    'remove_blank_lines_in_script_elements' => false,
];
```

## Benchmark

See [abordage/html-min-benchmark](https://github.com/abordage/html-min-benchmark)

## Testing

```bash
composer test:all
```

or

```bash
composer test:phpunit
composer test:phpstan
composer test:phpcsf
```

## Feedback

If you have any feedback, comments or suggestions, please feel free to open an issue within this repository.

## Contributing

Please see [CONTRIBUTING](https://github.com/abordage/.github/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Pavel Bychko](https://github.com/abordage)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
