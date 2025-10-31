<?php

namespace App\Http\Controllers\Auth\HeroesActions\helper;


class Helper_hero {
    //=========================================================================
    // we get the path to the image, if new_path_image == null, 
    // then we use old_path_image
    // otherwise we use new_path_image
    //=========================================================================
    public static function get_path_image($new_path_image, $old_path_image) {
        return $new_path_image == null ? $old_path_image : $new_path_image;
    } 
}

?>