<?php
namespace AppBundle\Tests\Utils;

class ListUtilsTest //TODO see to implement Phpunit test case
{
    public function testGetCategoriesFilters()
    {
        $categories = "";
        $result = ListUtils::getCategoriesFilters($categories);
        assert(is_array($result));
        assert(count($result) == 0);
        $categories = "breakfast/snacks";
        $result = ListUtils::getCategoriesFilters($categories);
        assert(is_array($result));
        assert(count($result) == 2);
        assert($result[0] == 'breakfast');
        assert($result[1] == 'snacks');
    }
}
