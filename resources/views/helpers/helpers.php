<?php

#-----------helpers php-----------#
#------Authors: AlexanderSYN------#

session_start();

class helpers {
    function redirect(string $path) {
        header("Location: $path");
    }
}

//---------------------------------
// messages (error and success)
//---------------------------------
class messages {
    function setMessage(string $key, string $message) : void {
        $_SESSION['messages'][$key] = $message;
    }

    function hasMessage(string $key) {
        return isset($_SESSION['messages'][$key]);
    }

    function getMessage(string $key) : string {
        $messages = $_SESSION['messages'][$key] ?? '';
        unset($_SESSION['messages'][$key]);
        
        return $messages;
    }
}

#-----------...-------------------#

?>