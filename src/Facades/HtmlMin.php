<?php

namespace Abordage\LaravelHtmlMin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Abordage\LaravelHtmlMin\HtmlMin minify(string $html)
 *
 * @see \Abordage\LaravelHtmlMin\HtmlMin
 */
class HtmlMin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-html-min';
    }
}
