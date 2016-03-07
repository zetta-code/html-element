<?php

namespace Spatie\HtmlElement\Test;

use Spatie\HtmlElement\TagParser;

class TagParserTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parser = new TagParser();
    }

    /** @test */
    function it_can_parse_a_plain_element()
    {
        $this->assertEquals(
            [['element' => 'div', 'id' => null, 'classes' => [], 'attributes' => []]],
            $this->parser->parse('div')
        );
    }

    /** @test */
    function it_can_parse_an_element_with_an_id()
    {
        $this->assertEquals(
            [['element' => 'div', 'id' => 'main', 'classes' => [], 'attributes' => []]],
            $this->parser->parse('div#main')
        );
    }

    /** @test */
    function it_can_parse_an_element_with_a_class()
    {
        $this->assertEquals(
            [['element' => 'div', 'id' => null, 'classes' => ['container'], 'attributes' => []]],
            $this->parser->parse('div.container')
        );
    }

    /** @test */
    function it_can_parse_an_element_with_multiple_classes()
    {
        $this->assertEquals(
            [['element' => 'div', 'id' => null, 'classes' => ['container', 'fluid'], 'attributes' => []]],
            $this->parser->parse('div.container.fluid')
        );
    }

    /** @test */
    function it_can_parse_an_element_with_an_id_and_a_class()
    {
        $this->assertEquals(
            [['element' => 'div', 'id' => 'main', 'classes' => ['container'], 'attributes' => []]],
            $this->parser->parse('div#main.container')
        );
    }

    /** @test */
    function it_can_parse_attributes()
    {
        $this->assertEquals(
            [['element' => 'a', 'id' => null, 'classes' => [], 'attributes' => ['href' => '#']]],
            $this->parser->parse('a[href=#]')
        );
    }

    /** @test */
    function it_can_parse_attributes_with_quotes()
    {
        $this->assertEquals(
            [['element' => 'a', 'id' => null, 'classes' => [], 'attributes' => ['href' => '#']]],
            $this->parser->parse('a[href="#"]')
        );

        $this->assertEquals(
            [['element' => 'a', 'id' => null, 'classes' => [], 'attributes' => ['href' => '#']]],
            $this->parser->parse("a[href='#']")
        );
    }

    /** @test */
    function it_can_parse_attributes_and_classes()
    {
        $this->assertEquals(
            [['element' => 'a', 'id' => null, 'classes' => ['foo', 'bar'], 'attributes' => ['href' => '#']]],
            $this->parser->parse('a.foo[href="#"].bar')
        );
    }

    /** @test */
    function it_can_parse_multiple_attributes()
    {
        $this->assertEquals(
            [['element' => 'a', 'id' => null, 'classes' => [], 'attributes' => ['href' => '#', 'title' => 'Link']]],
            $this->parser->parse('a[href="#"][title="Link"]')
        );
    }
}
