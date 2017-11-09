<?php

namespace Spatie\HtmlElement\Test\Helpers\Arr;

use PHPUnit\Framework\TestCase;
use Spatie\HtmlElement\Helpers\Arr;

class ArrTest extends TestCase
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
