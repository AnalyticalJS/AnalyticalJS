<?php
namespace App\Helpers;

use Illuminate\Support\Collection;

class PaginatePages
{

    /**
     * Create paginator
     *
     * @param  Illuminate\Support\Collection  $collection
     * @param  int     $pageNumber
     * @param  int     $size
     * @return string
     */
    public static function paginate($data,$pageNumber,$size)
    {
        if($pageNumber > 1){
            $result = collect($data)->slice(($size*($pageNumber-1)),$size);
        } else {
            $result = collect($data)->slice(0,$size);
        }

        return $result;
        
    }

}