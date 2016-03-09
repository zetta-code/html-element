<?php

namespace Spatie\HtmlElement;

class Attributes
{
    protected $attributes = [];

    protected $classes = [];

    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    public function setAttributes(array $attributes)
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

        return $this;
    }

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return static
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

    public function isEmpty() : bool
    {
        return empty($this->attributes) && empty($this->classes);
    }

    public function toArray() : array
    {
        return array_merge($this->attributes, ['class' => implode(' ',$this->classes)]);
    }

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

    public function __toString() : string
    {
        return $this->toString();
    }
}
