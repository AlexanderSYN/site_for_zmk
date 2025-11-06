<?php

namespace App\Http\Controllers\Auth\HeroesMPActions\helper;

//============================
// Helper for register
// Хелпер для регистрации
//============================

use Exception;

class Helper_register {
    /**
     * Checking before getting the first_name for the database
     * (Проверка перед получением first_name для базы данных)
     * 
     * @param string first_name from array
     * 
     * @return (first_name is null ? 'none' : first_name from array)
    */
    public static function get_current_first_name(array $get_full_name) {
        try {
            return $get_full_name[1];
        } catch (Exception $e) {
            return 'none';
        }
    }

    /**
     * Checking before getting the patronymic for the database
     * (Проверка перед получением patronymic для базы данных)
     * 
     * @param string patronymic from array
     * 
     * @return (patronymic is null ? 'none' : patronymic from array)
    */
    public static function get_current_patronymic(array $get_full_name) {
        try {
            return $get_full_name[2];
        } catch (Exception $e) {
            return 'none';
        }
    }

}

?>