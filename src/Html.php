<?php

namespace Spatie\HtmlElement;

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
		list($element, $elementId, $elementAttributes) = Tag::parse($arguments[0]);

        list($attributes, $contents) = $this->parseAttributesAndContent($arguments);

		return [
			$element,
			$arguments[1] ?? [],
			$arguments[2] ?? ''
		];
	}

    protected function parseAttributesAndContent(array $arguments) : array
    {
        // If the first argument isn't set, return empty values.
        if (! isset($arguments[1])) {
            return [[], ''];
        }

        // If the first argument is a string, these are the contents and the attributes are empty.
        if (is_string($arguments[1])) {
            return [[], $arguments[1]];
        }

        // If there weren't any exceptions, return the default parameters.
        return [$arguments[1], $arguments[2]];
    }
}
