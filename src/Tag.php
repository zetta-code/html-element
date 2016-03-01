<?php

namespace Spatie\HtmlElement;

class Tag
{
    public static function parse(string $path) : array
    {
        $parts = preg_split('/(?=[.#])/', $path);

        return array_reduce($parts, function ($parts, $part) {

            switch ($part[0]) {
                case '.':
                    $parts['classes'][] = ltrim($part, '.');
                    break;
                case '#':
                    $parts['id'] = ltrim($part, '#');
                    break;
                default:
                    $parts['tag'] = $part;
                    break;
            }

            return $parts;

        }, ['tag' => '', 'id' => '', 'classes' => []]);
    }
}
