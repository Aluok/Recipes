<?php
namespace AppBundle\Utils;

class ListUtils
{	
    public static function getCategoriesFilters(string $categories)
    {
    	if ($categories == "All") {//TODO See to implement it as a constant (to be implementerd in the annotation too.
        	return null;
    	}
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
