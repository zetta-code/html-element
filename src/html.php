<?php

namespace Spatie\HtmlElement\Html;

class Html
{
	public static function el(string $element, $attributes = [], $content = '') : string
	{
		return (new Html())->element($element, $attributes, $content);
	}

	public function element(string $element, $attributes = [], $content = '') : string
	{
		list($element, $attributes, $content) = $this->parseArguments(func_get_args());

		$attributes = $this->renderAttributes($attributes);

        $openingTag = empty($attributes) ? 
        	"<{$element}>" : 
        	"<{$element} {$attributes}>";

        $closingTag = "</{$element}>";

        return "{$openingTag}{$content}{$closingTag}";
	}

	protected function renderAttributes(array $attributes) : string
    {
        if (empty($attributes)) {
            return '';
        }

        $attributeStrings = [];

        foreach ($attributes as $attribute => $value) {

            if (empty($value)) {
                $attributeStrings[] = $attribute;
                continue;
            }

            $attributeStrings[] = "{$attribute}=\"{$value}\"";
        }

        return implode(' ', $attributeStrings);
    }

	protected function parseArguments(array $arguments) : array
	{
		$element = $arguments[0];

		if (! isset($arguments[1])) {
			return [$element, [], null];
		}

		if (is_string($arguments[1])) {
			return [$element, [], $arguments[1]];
		}

		return [
			$element,
			$arguments[1] ?? [],
			$arguments[2] ?? ''
		];
	}
}
