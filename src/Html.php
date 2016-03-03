<?php

namespace Spatie\HtmlElement;

class Html
{
	public static function el(...$arguments) : string
	{
        $tag = $arguments[0];
        $attributes = isset($arguments[2]) ? $arguments[1] : [];
        $contents = $arguments[2] ?? $arguments[1] ?? [];

        if (! is_array($contents)) {
            $contents = [$contents];
        }

        return (new Element($tag, $attributes, $contents))->render();
	}
}
