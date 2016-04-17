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

    // public static function objSort(array &$objArray, string $indexFunction, $sort_flags = 0)
    // {
    //     if ($objArray == null || count($objArray) == 0) {
    //         return;
    //     }
    //     $indices = array();
    //     foreach ($objArray as $obj) {
    //         $indices[] = $obj->$indexFunction();
    //     }
    //     return array_multisort($indices, $sort_flags, $objArray);
    // }
}
