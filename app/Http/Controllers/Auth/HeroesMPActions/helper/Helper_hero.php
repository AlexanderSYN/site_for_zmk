<?php

namespace App\Http\Controllers\Auth\HeroesMPActions\helper;

use App\Models\heroes_added_by_user;
use App\Models\city_heroes;
use Exception;

class Helper_hero {
    //=========================================================================
    // we get the path to the image, if new_path_image == null, 
    // then we use old_path_image
    // otherwise we use new_path_image
    //
    // мы получаем путь к изображению, если new_path_image == null,
    // тогда мы используем old_path_image
    // в противном случае мы используем new_path_image
    //=========================================================================
    public static function get_path_image($new_path_image, $old_path_image) {
        return $new_path_image == null ? $old_path_image : $new_path_image;
    } 

    /**
    * for added heroes page!
    * We get: the user's role, type, and hero's city. If role = user, then 
    * we transfer to the page with the characters that he himself added, if the admin
    * or moder then show all the characters, otherwise assume that the user has switched 
    * and do the same as I wrote above. at the end, we get a query for sql
    *
    * (для страницы добавленных героев!
    * получаем: роль пользователя, тип и город героя. Eсли роль = user, тогда 
    * перекидываем на страницу с героями, которых он сам добавил, если admin
    * или moder тогда показать всех героев, иначе считать, что перешел user 
    * и сделать также, как я писал выше. в конце получаем запрос для sql)

    * @return errors ? null : $heroes, there will be data from bd heroes (там будут данные из бд heroes)
     */
    public static function get_current_url_for_added_heroes($role, $city_id, $type, $user_id)
    {
        // to get the city where the hero is located
        // для получения города, в котором находится герой
        try {
            switch ($role) {
                case 'user':
                    $heroes = heroes_added_by_user::where('city', $city_id)
                        ->where('type', $type)
                        ->where('added_user_id', $user_id)
                        ->with('user', 'city_relation')
                        ->orderBy('name_hero', 'desc')
                        ->paginate(10);
                    break;
                case 'moder':
                    $heroes = heroes_added_by_user::where('city',  $city_id)
                        ->where('type', $type)
                        ->with('user', 'city_relation')
                        ->orderBy('name_hero', 'desc')
                        ->paginate(10);
                    break;
                case 'admin':
                    $heroes = heroes_added_by_user::where('city',  $city_id)
                        ->where('type', $type)
                        ->with('user', 'city_relation')
                        ->orderBy('name_hero', 'desc')
                        ->paginate(10);
                    break;
                default:
                    $heroes = heroes_added_by_user::where('city',  $city_id)
                        ->where('type', $type)
                        ->where('added_user_id', $user_id)
                        ->with('user', 'city_relation')
                        ->orderBy('name_hero', 'desc')
                        ->paginate(10);
                    break;
            }

            return $heroes;

        } catch (Exception $e) {
            return redirect()->route('profile');
        }

        
    }
}

?>