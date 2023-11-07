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
        }

        return $temp ?? false;
    }

    public function getMessagesArray() {
        $arr = array();
        $fmessages = $_SESSION[self::F_MESSAGES_KEY] ?? [];
        foreach($fmessages as $key => &$fmessage) {
            $arr[$key] = $fmessage['value'];
        }
        unset($_SESSION[self::F_MESSAGES_KEY]);

        return json_encode($arr);
    }
}