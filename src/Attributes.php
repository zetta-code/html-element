<?php

namespace Spatie\HtmlElement;

class Attributes
{
    /** @var array */
    protected $attributes = [];

    /** @var array */
    protected $classes = [];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {

            if ($attribute === 'class') {
                $this->addClass($value);
                continue;
            }

            if (is_int($attribute)) {
                $attribute = $value;
                $value = '';
            }

            $this->setAttribute($attribute, $value);
        }
    }

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return static
     * @throws \Exception
     */
    public function setAttribute(string $attribute, string $value = '')
    {
        if ($attribute === 'class') {
            $this->addClass($value);
            return $this;
        }

        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * @param string|array $class
     *
     * @return static
     */
    public function addClass($class)
    {
        if (! is_array($class)) {
            $class = [$class];
        }

        $this->classes = array_unique(
            array_merge($this->classes, $class)
        );

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty() : bool
    {
        return empty($this->attributes) && empty($this->classes);
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return array_merge($this->attributes, ['class' => implode(' ',$this->classes)]);
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        if ($this->isEmpty()) {
            return '';
        }

        $attributes = $this->attributes;

        if (!empty($this->classes)) {
            $attributes['class'] = implode(' ', $this->classes);
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

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
