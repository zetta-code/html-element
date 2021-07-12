<?php

namespace Spatie\HtmlElement\Test;

use PHPUnit\Framework\TestCase;
use Spatie\HtmlElement\Attributes;

class AttributesTest extends TestCase
{
    /** @test */
    public function it_starts_empty()
    {
        $attributes = new Attributes();

        $this->assertTrue($attributes->isEmpty());
        $this->assertEmpty($attributes->toArray());
        $this->assertEmpty($attributes->toString());
    }

    /** @test */
    public function it_accepts_classes_as_strings()
    {
        $attributes = new Attributes();

        $this->assertArraySubset(
            ['class' => 'foo bar'],
            $attributes->addClass('foo bar')->toArray()
        );
    }

    /** @test */
    public function it_accepts_classes_as_an_array()
    {
        $attributes = new Attributes();

        $this->assertArraySubset(
            ['class' => 'foo bar'],
            $attributes->addClass(['foo', 'bar'])->toArray()
        );
    }

    /** @test */
    public function it_accepts_attributes()
    {
        $attributes = new Attributes();

        $this->assertArraySubset(
            ['href' => '#'],
            $attributes->setAttribute('href', '#')->toArray()
        );
    }

    /** @test */
    public function it_accepts_class_attribute()
    {
        $attributes = new Attributes();

        $this->assertArraySubset(
            ['class' => 'container'],
            $attributes->setAttribute('class', 'container')->toArray()
        );
    }

    /** @test */
    public function it_accepts_attributes_without_values()
    {
        $attributes = new Attributes();

        $this->assertArraySubset(
            ['required' => null],
            $attributes->setAttribute('required')->toArray()
        );
    }

    /** @test */
    public function it_accepts_multiple_attributes()
    {
        $attributes = new Attributes();

        $this->assertArraySubset(
            ['name' => 'email', 'required' => null],
            $attributes->setAttributes(['name' => 'email', 'required'])->toArray()
        );
    }

    protected function assertArraySubset(array $expectedSubset, array $actualArray)
    {
        foreach ($expectedSubset as $key => $value) {
            $this->assertArrayHasKey($key, $actualArray);
            if ($value !== null) {
                $this->assertSame($value, $actualArray[$key]);
            } else {
                $this->assertSame('', $actualArray[$key]);
            }
        }
    }
}
