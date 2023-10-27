<?php

namespace App\Core;

class FlashMessage extends Session
{
    protected const F_MESSAGES_KEY = 'f_messages';
    
    public function __construct()
    {
        $fmessages = $_SESSION[self::F_MESSAGES_KEY] ?? [];
        foreach($fmessages as $key => &$fmessage) {
            $fmessage['removed'] = true;
        }
        $_SESSION[self::F_MESSAGES_KEY] = $fmessages;
    }

    public function setFlashMessage(string $key, string $message) {
        $_SESSION[self::F_MESSAGES_KEY][$key] = [
            'removed' => false,
            'value' => $message
        ];
    }

    public function getFlashMessage(string $key) {
        $temp = [];
        if(!isset($_SESSION[self::F_MESSAGES_KEY][$key]['value'])) {
            return false;
        } else {
            $temp = $_SESSION[self::F_MESSAGES_KEY][$key]['value'];
            unset($_SESSION[self::F_MESSAGES_KEY][$key]);
        }

        return $temp ?? false;
    }
    
    /*public function __destruct()
    {
        $fmessages = $_SESSION[self::F_MESSAGES_KEY] ?? [];
        foreach($fmessages as $key => &$fmessage) {
            if($fmessage['removed']) {
                unset($fmessages[$key]);
                var_dump("done");
            }
        }
        $_SESSION[self::F_MESSAGES_KEY] = $fmessages;
    }*/
}