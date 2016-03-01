<?php

namespace Spatie\HtmlElement;

class Html
{
    protected $tag;
    protected $attributes;
    protected $contents;

	public static function el(...$arguments) : string
	{
		return (new Html(...$arguments))->render();
	}

	protected function __construct(...$arguments)
	{
        list($tag, $id, $classes) = $this->parseTagArguments($arguments[0]);
        list($attributes, $contents) = $this->parseAttributeAndContentArguments($arguments);

        $attributes = $this->mergeAttributesWithTagAttributes($attributes, $id, $classes);

        $this->tag = $tag;
        $this->attributes = $attributes;
        $this->contents = $contents;
	}

    protected function render() : string
    {
        if ($this->isSelfClosingElement()) {
            return $this->renderOpeningTag();
        }

        return "{$this->renderOpeningTag()}{$this->renderContents()}{$this->renderClosingTag()}";
    }

    protected function parseTagArguments(string $tag) : array
    {
        $parts = preg_split('/(?=[.#])/', $tag);

        return array_reduce($parts, function ($parts, $part) {

            switch ($part[0]) {
                case '.':
                    $parts[2][] = ltrim($part, '.');
                    break;
                case '#':
                    $parts[1] = ltrim($part, '#');
                    break;
                default:
                    $parts[0] = $part;
                    break;
            }

            return $parts;

        }, ['', '', []]);
    }

    protected function parseAttributeAndContentArguments(array $arguments) : array
    {
        if (isset($arguments[2])) {
            return [$arguments[1], $arguments[2]];
        }

        if (isset($arguments[1])) {
            return [[], $arguments[1]];
        }

        return [[], ''];
    }

    protected function mergeAttributesWithTagAttributes(array $attributes, string $id, array $classes)
    {
        if (!empty($id)) {
            $attributes['id'] = $id;
        }

        if (!empty($classes)) {
            $attributes['class'] = isset($attributes['class']) ?
                implode(' ', $classes).' '.$attributes['class'] :
                implode(' ', $classes);
        }

        return $attributes;
    }

    protected function renderAttributes() : string
    {
        if (empty($this->attributes)) {
            return '';
        }

        $attributeStrings = [];

        foreach ($this->attributes as $attribute => $value) {

            if (is_int($attribute)) {
                $attributeStrings[] = $value;
                continue;
            }

            if (is_array($value)) {
                $value = implode(' ', $value);
            }

            $attributeStrings[] = "{$attribute}=\"{$value}\"";
        }

        return implode(' ', $attributeStrings);
    }

    protected function renderContents() : string
    {
        if (is_array($this->contents)) {
            return implode('', $this->contents);
        }

        return $this->contents;
    }

    protected function renderOpeningTag() : string
    {
        $attributes = $this->renderAttributes();

        return empty($attributes) ?
            "<{$this->tag}>" :
            "<{$this->tag} {$attributes}>";
    }

    protected function renderClosingTag() : string
    {
        return "</{$this->tag}>";
    }

    protected function isSelfClosingElement() : bool
    {
        return false;
    }
}
