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

    
    //TODO remove under there?
    public static function objSort(array &$objArray, string $indexFunction, $sort_flags = 0)
    {
        if ($objArray == null || count($objArray) == 0) {
            return;
        }
        $indices = array();
        foreach ($objArray as $obj) {
            $indices[] = $obj->$indexFunction();
        }
        return self::doubleMergeSort($indices, $objArray, $sort_flags);
       // return array_multisort($indices, $sort_flags, $objArray);
    }
    
    private static function doubleMergeSort($master, $follower, $direction)
    {
    	if (count($master) == 0) {
    		return array('master' => $master, 'follower' => $follower);
    	}
    	$arr1 = self::doubleMergeSort(
    			array_slice($master, 0, floor(count($master) / 2)), 
    			array_slice($follower, 0, floor(count($follower) / 2)),
    			$direction
    	);
    	$arr2 = self::doubleMergeSort(
    			array_slice($master, ceil(count($master) / 2)), 
    			array_slice($follower, ceil(count($follower) / 2)),
    			$direction
    	);
    	return self::doubleMerge($arr1, $arr2, $direction);
    }
    
    private static function doubleMerge($arr1, $arr2, $direction)
    {
    	$arrays = array('master' => array(), 'follower' => array());
    	$lenth1 = count($arr1['master']);
    	$lenth2 = count($arr2['master']);
    	$index_merged = 0;
    	$j = 0;
    	if ($direction == SORT_DESC) {
    		
    	} else if ($direction == SORT_ASC) {
    		for ($i = 0; $i < $lenth1; $i++) {
    			if ($j == $lenth2) {
    				$arrays['master'][$index_merged] = $arr1['master'][$i];
    				$arrays['follower'][$index_merged] = $arr1['follower'][$i];
    				$index_merged++;
    			} else if ($arr1['master'][$i] < $arr2['master'][$j]) {
    				$arrays['master'][$index_merged] = $arr1['master'][$i];
    				$arrays['follower'][$index_merged] = $arr1['follower'][$i];
    				$index_merged++;
    			} else {
    				$arrays['master'][$index_merged] = $arr2['master'][$j];
    				$arrays['follower'][$index_merged] = $arr2['follower'][$j];
    				$index_merged++;
    				$j++;
    			}
    		}
    		for ($i = $j; $j < $lenth2; $i++) {
    			$arrays['master'][$index_merged] = $arr2['master'][$j];
    			$arrays['follower'][$index_merged] = $arr2['follower'][$j];
    			$index_merged++;
    		}
    	}
    }
}
