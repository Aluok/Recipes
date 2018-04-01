<?php

namespace Tests\App\Utils;

use App\Utils\ListUtils;

class ListUtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider filtersProvider
     */
    public function testGetFilters($filters, $expected)
    {
        $result = ListUtils::getFilters($filters);
        
        $this->assertEquals($expected, $result);
    }

    public function filtersProvider()
    {
        return array(
            array(
                'All',
                null,
            ),
            array(
                'category=breakfast_snacks',
                array('category' => array('breakfast', 'snacks'))
            ),
            array(
                'ingredients=egg_milk',
                array('ingredients' => array('egg', 'milk'))
            ),
            array(
                'category=breakfast_snacks/ingredients=egg_milk',
                array('category' => array('breakfast', 'snacks'), 'ingredients' => array('egg', 'milk'))
            ),
        );
    }
}
