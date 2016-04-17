<?php
namespace AppBundle\Utils;

class ListUtils
{
    public static function getCategoriesFilters(string $categories)
    {
        return explode("/", $categories);
    }

    public static function objSort(array &$objArray, string $indexFunction, $sort_flags = 0)
    {
        if ($objArray == null || count($objArray) == 0) {
            return;
        }
        $indices = array();
        foreach ($objArray as $obj) {
            $indices[] = $obj->$indexFunction();
        }
        return array_multisort($indices, $sort_flags, $objArray);
    }
}
