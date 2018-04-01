<?php
namespace App\Utils;

class ListUtils
{
    public static function getFilters(string $filters)
    {
        //TODO See to implement it as a constant (to be implementerd in the annotation and tests too.
        if ($filters == "All") {
            return null;
        }
        $mainFilters = explode("/", $filters);
        $filters = array();
        for ($i = 0; $i < count($mainFilters); $i++) {
            $tmp = explode('=', $mainFilters[$i]);
            $filters[$tmp[0]] = explode('_', $tmp[1]);
        }
        return $filters;
    }
}
