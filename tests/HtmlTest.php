<?php

namespace Spatie\HtmlElement\Test;

use Spatie\HtmlElement\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_parses_a_tag()
    {
        $this->assertEquals('<div></div>', Html::el('div'));
    }

    /** @test */
    function it_parses_a_tag_with_text_contents()
    {
        $this->assertEquals('<div>Hello world</div>', Html::el('div', 'Hello world'));
    }

    /** @test */
    function it_parses_a_tag_with_empty_arguments_and_text_contents()
    {
        $this->assertEquals('<div>Hello world</div>', Html::el('div', [], 'Hello world'));
    }

    /** @test */
    function it_parses_a_tag_with_a_plain_argument()
    {
        $this->assertEquals(
            '<div class="intro">Hello world</div>',
            Html::el('div', ['class' => 'intro'], 'Hello world')
        );
    }

    /** @test */
    function it_parses_a_tag_with_an_argument_without_a_value()
    {
        $this->assertEquals(
            '<div contenteditable>Hello world</div>',
            Html::el('div', ['contenteditable'], 'Hello world')
        );
    }

    /** @test */
    function it_parses_an_array_of_content_items()
    {
        $this->assertEquals(
            '<ul><li>Cookies</li><li>Cream</li></ul>',
            Html::el('ul', ['<li>Cookies</li>', '<li>Cream</li>'])
        );
    }

    /** @test */
    function it_parses_an_id_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<div id="container"></div>',
            Html::el('div#container')
        );
    }

    /** @test */
    function it_only_parses_one_id_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<div id="container"></div>',
            Html::el('div#main#container')
        );
    }

    /** @test */
    function it_parses_a_class_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<div class="container"></div>',
            Html::el('div.container')
        );
    }

    /** @test */
    function it_parses_multiple_classes_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<div class="container fluid"></div>',
            Html::el('div.container.fluid')
        );
    }

    /** @test */
    function it_merges_classes_passed_in_through_the_tag_name_and_attributes()
    {
        $this->assertEquals(
            '<div class="fluid container"></div>',
            Html::el('div.container', ['class' => ['fluid']], '')
        );
    }

    /** @test */
    function it_renders_self_closing_tags_when_relevant()
    {
        $this->assertEquals('<img src="/background.jpg">', Html::el('img', ['src' => '/background.jpg'], []));
    }

    /** @test */
    function it_recognizes_uppercase_self_closing_tags()
    {
        $this->assertEquals('<IMG src="/background.jpg">', Html::el('IMG', ['src' => '/background.jpg'], []));
    }

    /** @test */
    function it_renders_emmet_style_nested_tags()
    {
        $this->assertEquals(
            '<div class="container"><div class="row"></div></div>',
            Html::el('div.container>div.row')
        );
    }

    /** @test */
    function it_allows_spaces_around_child_separators()
    {
        $this->assertEquals(
            '<div class="container"><div class="row"></div></div>',
            Html::el('div.container > div.row')
        );
    }
}
