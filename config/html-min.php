<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Enable HTML Minification
    |--------------------------------------------------------------------------
    |
    | When enabled, HTML responses will be minified automatically.
    | Set to false to disable minification (useful for debugging).
    |
    */
    'enable' => env('HTML_MINIFY', true),

    /*
    |--------------------------------------------------------------------------
    | Require DOCTYPE
    |--------------------------------------------------------------------------
    |
    | When enabled, minification will be skipped if <!DOCTYPE> is not found
    | in the first 100 characters. This prevents minifying non-HTML content.
    |
    */
    'find_doctype_in_document' => true,

    /*
    |--------------------------------------------------------------------------
    | Remove Whitespace Between Tags
    |--------------------------------------------------------------------------
    |
    | Removes unnecessary whitespace between HTML tags: "> <" becomes "><".
    | May affect inline elements spacing in some edge cases.
    |
    */
    'remove_whitespace_between_tags' => true,

    /*
    |--------------------------------------------------------------------------
    | Remove Blank Lines in Script Elements
    |--------------------------------------------------------------------------
    |
    | Removes blank lines inside <script> tags. Useful for inline scripts,
    | but may break code that relies on line numbers for debugging.
    |
    */
    'remove_blank_lines_in_script_elements' => false,

    /*
    |--------------------------------------------------------------------------
    | Remove Trailing Slashes from Void Elements
    |--------------------------------------------------------------------------
    |
    | In HTML5, void elements (link, meta, img, br, etc.) should not have
    | trailing slashes. Converts <link /> to <link>.
    |
    */
    'remove_trailing_slashes' => false,
];
