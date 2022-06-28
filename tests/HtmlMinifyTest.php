<?php

namespace Abordage\LaravelHtmlMin\Tests;

use Abordage\LaravelHtmlMin\HtmlMinServiceProvider;
use Abordage\LaravelHtmlMin\Middleware\HtmlMinify;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;

use function PHPUnit\Framework\assertEquals;

class HtmlMinifyTest extends Orchestra
{
    protected string $htmlWithoutDoctype;
    protected string $htmlResponse;
    protected string $jsonResponse;

    protected function setUp(): void
    {
        parent::setUp();


        $this->htmlWithoutDoctype = '<div>   content   </div>';

        $this->htmlResponse = <<<EOT
<!DOCTYPE html>
<html   lang='en'>
    <head>
        <title>
                Awesome
                            Title
        </title>
        <style>
            a:  {
                    color:   inherit;
                    background-color:      transparent;
                    text-decoration:   inherit
            }
        </style>
    </head>
    <body>
        <div>
            <p>
                <span  style='color:   #fff'>
                I <i>imagine </i> that right now you're
                feeling a bit like <span  style='color:   #fff'>Alice</span>,

                 tumbling down
                 the rabbit hole?
            </p>
        </div>

        <footer>

            <script type="text/javascript">
                (function() {
                    let a = 1
                    const b = c
                })();
            </script>

        </footer>

    </body>
</html>
EOT;

        $jsonData = ['name' => 'Alice', 'state' => 'Wonderland', 'author' => '   Lewis    Carroll   '];
        $this->jsonResponse = (string)json_encode($jsonData);

        Route::any('/dummy-without-doctype', fn () => response($this->htmlWithoutDoctype))->middleware(HtmlMinify::class);
        Route::any('/dummy-json', fn () => response()->json($jsonData))->middleware(HtmlMinify::class);
        Route::any('/dummy-post-500', fn () => response($this->htmlResponse, 500))->middleware(HtmlMinify::class);
        Route::any('/dummy-post', fn () => $this->htmlResponse)->middleware(HtmlMinify::class);
    }

    protected function getPackageProviders($app): array
    {
        return [
            HtmlMinServiceProvider::class,
        ];
    }

    public function testHandle(): void
    {
        /** test */
        $content = $this->get('/dummy-without-doctype')->content();
        $excepted = $this->htmlWithoutDoctype;
        assertEquals($excepted, $content);

        /** test */
        config(['html-min.find_doctype_in_document' => false]);
        $content = $this->get('/dummy-without-doctype')->content();
        $excepted = '<div>content</div>';
        assertEquals($excepted, $content);
        config(['html-min.find_doctype_in_document' => true]);

        /** test */
        $content = $this->get('/dummy-json')->content();
        $excepted = $this->jsonResponse;
        assertEquals($excepted, $content);

        /** test */
        $content = $this->get('/dummy-post-500')->content();
        $excepted = $this->htmlResponse;
        assertEquals($excepted, $content);

        /** test */
        $content = $this->put('/dummy-post')->content();
        $excepted = $this->htmlResponse;
        assertEquals($excepted, $content);

        /** test */
        config(['html-min.enable' => false]);
        $content = $this->get('/dummy-post')->content();
        $excepted = $this->htmlResponse;
        assertEquals($excepted, $content);

        /** test */
        config(['html-min.enable' => true]);
        config(['html-min.remove_whitespace_between_tags' => true]);
        config(['html-min.remove_blank_lines_in_script_elements' => true]);

        $content = $this->get('/dummy-post')->content();
        $excepted = <<<EOT
<!DOCTYPE html><html lang='en'><head><title>Awesome Title</title><style>a: { color: inherit; background-color: transparent; text-decoration: inherit }</style></head><body><div><p><span style='color: #fff'>I <i>imagine</i> that right now you're feeling a bit like <span style='color: #fff'>Alice</span>, tumbling down the rabbit hole?</p></div><footer><script type="text/javascript">(function() {
let a = 1
const b = c
})();</script></footer></body></html>
EOT;
        assertEquals($excepted, $content);

        /** test */
        config(['html-min.remove_whitespace_between_tags' => false]);
        config(['html-min.remove_blank_lines_in_script_elements' => false]);

        $content = $this->get('/dummy-post')->content();
        $excepted = <<<EOT
<!DOCTYPE html> <html lang='en'> <head> <title> Awesome Title </title> <style> a: { color: inherit; background-color: transparent; text-decoration: inherit } </style> </head> <body> <div> <p> <span style='color: #fff'> I <i>imagine </i> that right now you're feeling a bit like <span style='color: #fff'>Alice</span>, tumbling down the rabbit hole? </p> </div> <footer> <script type="text/javascript">
                (function() {
                    let a = 1
                    const b = c
                })();
            </script> </footer> </body> </html>
EOT;
        assertEquals($excepted, $content);
    }
}
