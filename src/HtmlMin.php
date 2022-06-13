<?php

namespace Abordage\LaravelHtmlMin;

use Abordage\HtmlMin\HtmlMin as BaseHtmlMin;

class HtmlMin extends BaseHtmlMin
{
    public function minify(string $html): string
    {
        $this->findDoctypeInDocument((bool)config('html-min.find_doctype_in_document'));
        $this->removeWhitespaceBetweenTags((bool)config('html-min.remove_whitespace_between_tags'));
        $this->removeBlankLinesInScriptElements((bool)config('html-min.remove_blank_lines_in_script_elements'));

        return parent::minify($html);
    }
}
