<?php

namespace Spatie\HtmlElement\Test\Helpers\Arr;

use Spatie\HtmlElement\Helpers\Arr;

class ArrTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_flattens_an_array()
    {
        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            Arr::flatten(['a', ['b', 'c', ['d']]])
        );
    }
}
