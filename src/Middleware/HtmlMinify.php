<?php

namespace Abordage\LaravelHtmlMin\Middleware;

use Abordage\LaravelHtmlMin\Facades\HtmlMin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HtmlMinify
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!config('html-min.enable')) {
            return $response;
        }

        if (!in_array(strtoupper($request->getMethod()), ['GET', 'HEAD'])) {
            return $response;
        }

        if (!$response instanceof Response) {
            return $response;
        }

        if ($response->getStatusCode() >= 500) {
            return $response;
        }

        $html = $response->getContent();

        if (class_exists('\BeyondCode\ServerTiming\Facades\ServerTiming')) {
            \BeyondCode\ServerTiming\Facades\ServerTiming::start('Minification');
        }

        /** @phpstan-ignore-next-line */
        $htmlMin = HtmlMin::minify($html);

        if (class_exists('\BeyondCode\ServerTiming\Facades\ServerTiming')) {
            \BeyondCode\ServerTiming\Facades\ServerTiming::stop('Minification');
        }

        return $response->setContent($htmlMin);
    }
}
