<?php

namespace Spatie\HtmlElement;

class Html
{
    /** @var string */
    protected $element;

    /** @var \Spatie\HtmlElement\Attributes */
    protected $attributes;

    /** @var string */
    protected $contents;

    public static function el(...$arguments) : string
    {
        $tag = $arguments[0];
        $attributes = isset($arguments[2]) ? $arguments[1] : [];
        $contents = $arguments[2] ?? $arguments[1] ?? [];

        if (is_array($contents)) {
            $contents = implode('', $contents);
        }

        return (new static($tag, $attributes, $contents))->render();
    }

    protected function __construct(string $tag, array $attributes = [], string $contents = '')
    {
        $this->attributes = new Attributes();
        $this->contents = $contents;

        $tags = preg_split('/\s*>\s*/', $tag, 2);

        if (isset($tags[1])) {
            $this->contents = static::el($tags[1], [], $this->contents);
        }

        $this->parseAndSetTag($tags[0]);

        $this->attributes->setAttributes($attributes);
    }

    protected function parseAndSetTag(string $tag)
    {
        $parsed = (new AbbreviationParser())->parse($tag);

        $this->element = $parsed['element'];

        if (!empty($parsed['id'])) {
            $this->attributes->setAttribute('id', $parsed['id']);
        }

        $this->attributes->addClass($parsed['classes']);

        foreach ($parsed['attributes'] as $attribute => $value) {
            $this->attributes->setAttribute($attribute, $value);
        }
    }

    protected function render() : string
    {
        if ($this->isSelfClosingElement()) {
            return $this->renderOpeningTag();
        }

        return "{$this->renderOpeningTag()}{$this->contents}{$this->renderClosingTag()}";
    }

    protected function isSelfClosingElement() : bool
    {
        return in_array(strtolower($this->element), [
            'area', 'base', 'br', 'col', 'embed', 'hr',
            'img', 'input', 'keygen', 'link', 'menuitem',
            'meta', 'param', 'source', 'track', 'wbr',
        ]);
    }

    protected function renderOpeningTag() : string
    {
        return $this->attributes->isEmpty() ?
            "<{$this->element}>" :
            "<{$this->element} {$this->attributes}>";
    }

    protected function renderClosingTag() : string
    {
        return "</{$this->element}>";
    }
}
