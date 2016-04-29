<?php
namespace AppBundle\Tests\Utils;

class ListUtilsTest //TODO see to implement Phpunit test case
{
    public function testGetFilters()
    {
        $filters = "All";
        $result = ListUtils::getFilters($filters);
        assert(is_array($result));
        assert(count($result) == 2);
        assert(count($result['category']) == 0);
        assert(count($result['ingredients']) == 0);
        $filters = "category=breakfast_snacks";
        $result = ListUtils::getFilters($filters);
        assert(is_array($result));
        assert(count($result) == 2);
        assert(count($result['category']) == 2);
        assert(count($result['ingredients']) == 0);
        assert($result['category'][0] == 'breakfast');
        assert($result['category'][1] == 'snacks');

        $filters = "ingredients=egg_milk";
        $result = ListUtils::getFilters($filters);
        assert(is_array($result));
        assert(count($result) == 2);
        assert(count($result['ingredients']) == 2);
        assert(count($result['category']) == 0);
        assert($result['ingredients'][0] == 'egg');
        assert($result['ingredients'][1] == 'milk');

        $filters = "category=breakfast_snacks/ingredients=egg_milk";
        $result = ListUtils::getFilters($filters);
        assert(is_array($result));
        assert(count($result) == 2);
        assert(count($result['ingredients']) == 2);
        assert(count($result['category']) == 2);
        assert($result['ingredients'][0] == 'egg');
        assert($result['ingredients'][1] == 'milk');
        assert($result['category'][0] == 'breakfast');
        assert($result['category'][1] == 'snacks');
    }
}
