<?php
namespace AppBundle\Utils;

class ListUtils
{
    public static function getCategoriesFilters(string $categories)
    {
        if ($categories == "All") {
            //TODO See to implement it as a constant (to be implementerd in the annotation too.
            return null;
        }
        return explode("/", $categories);
    }
}
