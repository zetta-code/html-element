<?php

namespace Spatie\HtmlElement;

use Spatie\HtmlElement\Helpers\Arr;

class TagParser
{
    public function parse(string $tag) : array
    {
        return Arr::map($this->splitTags($tag), function (string $tag) {
            return $this->parseTag($tag);
        });
    }

    protected function splitTags(string $tag) : array
    {
        return preg_split('/\s*>\s*/', $tag);
    }

    protected function parseTag(string $tag) : array
    {
        return array_reduce($this->explodeTag($tag), function ($parts, $part) {

            switch ($part[0]) {
                case '.':
                    $parts['classes'][] = ltrim($part, '.');
                    break;
                case '#':
                    $parts['id'] = ltrim($part, '#');
                    break;
                case '[':
                    $attribute = explode('=', trim($part, '[]'), 2);
                    $parts['attributes'][$attribute[0]] = trim($attribute[1], '\'"');
                    break;
                default:
                    $parts['element'] = $part;
                    break;
            }

            return $parts;

        }, ['element' => null, 'id' => null, 'classes' => [], 'attributes' => []]);
    }

    protected function explodeTag(string $tag) : array
    {
        // First split out the attributes set with `[...=...]`
        $parts = preg_split('/(?=( \[[^]]+] ))/x', $tag);

        // Afterwards we can extract the rest of the attributes
        return Arr::flatMap($parts, function ($part) {

            if (strpos($part, '[') === 0) {
                list($attributeValue, $rest) = explode(']', $part, 2);
                return [$attributeValue] + $this->explodeTag($rest);
            }

            return preg_split('/(?=( (\.) | (\#) ))/x', $part);
        });
    }
}
