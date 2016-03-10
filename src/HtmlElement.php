<?php

namespace Spatie\HtmlElement;

class HtmlElement
{
    /** @var string */
    protected $element;

    /** @var \Spatie\HtmlElement\Attributes */
    protected $attributes;

    /** @var string */
    protected $contents;

    /**
     * Examples:
     * 
     * el('p');                                 <p></p>
     * el('p', 'Hello!')                        <p>Hello!</p>
     * el('p#intro', 'Hello!')                  <p id="intro">Hello!</p>
     * el('p', ['id' => 'intro'], 'Hello!')     <p id="intro">Hello!</p>
     *
     * @link https://github.com/spatie/html-element#examples
     * 
     * @param string $tag  The html element tag.
     * @param array|string $attributes  When only two arguments are passed, the second parameter
     *                                  represents the content instead of the attribute.
     * @param array|string $contents  Content can be passed in as a string or an array which will 
     *                                get concatenated as siblings.
     * 
     * @return string
     */
    public static function render(string $tag, $attributes = null, $content = null) : string
    {
        return (new static(func_get_args()))->renderTag();
    }

    protected function __construct($arguments)
    {
        list($abbreviation, $attributes, $contents) = $this->parseArguments($arguments);

        $this->attributes = new Attributes();

        $this->parseContents($contents);
        $this->parseAbbreviation($abbreviation);
        $this->parseAttributes($attributes);
    }

    protected function parseArguments($arguments)
    {
        $attributes = isset($arguments[2]) ? $arguments[1] : [];
        $contents = $arguments[2] ?? $arguments[1] ?? '';

        $tags = preg_split('/\s*>\s*/', $arguments[0], 2);

        if (isset($tags[1])) {
            $contents = static::render($tags[1], [], $contents);
        }

        return [$tags[0], $attributes, $contents];
    }

    protected function parseContents($contents)
    {
        $this->contents = is_array($contents) ? implode('', $contents) : $contents;
    }

    protected function parseAbbreviation(string $abbreviation)
    {
        $parsed = (new AbbreviationParser())->parse($abbreviation);

        $this->element = $parsed['element'];

        if (!empty($parsed['id'])) {
            $this->attributes->setAttribute('id', $parsed['id']);
        }

        $this->attributes->addClass($parsed['classes']);

        foreach ($parsed['attributes'] as $attribute => $value) {
            $this->attributes->setAttribute($attribute, $value);
        }
    }

    protected function parseAttributes(array $attributes)
    {
        $this->attributes->setAttributes($attributes);
    }

    protected function renderTag() : string
    {
        return Tag::render($this->element, $this->attributes, $this->contents);
    }
}
