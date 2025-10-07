<?php

#-----------helpers php-----------#
#------Authors: AlexanderSYN------#

namespace App\Helpers;


//---------------------------------
// messages (error and success)
//---------------------------------
class Messages 
{
    public static function setMessage(string $key, string $message) : void {
        session([$key => $message]);
    }

    public static function hasMessage(string $key) : bool {
        return session()->has($key);
    }

    public static function getMessage(string $key) : string {
        $message = session($key, '');
        session()->forget($key);
        return $message;
    }

    //---------------------------------
    // for a quick set of messages
    //---------------------------------
    public static function error(string $message) : void {
        self::setMessage('error', $message);
    }

    public static function success(string $message) : void {
        self::setMessage('success', $message);
    }
}

#-----------...-------------------#

?>