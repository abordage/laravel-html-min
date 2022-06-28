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

        if (!$this->compressionPossible($request, $response)) {
            return $response;
        }

        $html = $response->getContent();

        if (class_exists('\BeyondCode\ServerTiming\Facades\ServerTiming')) {
            \BeyondCode\ServerTiming\Facades\ServerTiming::start('Minification');
        }

        $htmlMin = HtmlMin::minify($html);

        if (class_exists('\BeyondCode\ServerTiming\Facades\ServerTiming')) {
            \BeyondCode\ServerTiming\Facades\ServerTiming::stop('Minification');
        }

        return $response->setContent($htmlMin);
    }

    /**
     * @param Request $request
     * @param mixed $response
     * @return bool
     */
    private function compressionPossible(Request $request, $response): bool
    {
        if (!config('html-min.enable')) {
            return false;
        }

        if (!in_array(strtoupper($request->getMethod()), ['GET', 'HEAD'])) {
            return false;
        }

        if (!$response instanceof Response) {
            return false;
        }

        if ($response->getStatusCode() >= 500) {
            return false;
        }

        return true;
    }
}
