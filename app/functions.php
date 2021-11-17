<?php

class functions {
    static function debug($message) {
        echo "<script>console.log('" . $message .  "')</script>";
    }
    
    static function ipaddress() {
        return $_SERVER['HTTP_CLIENT_IP']
        ?? $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['HTTP_X_FORWARDED']
        ?? $_SERVER['HTTP_FORWARDED_FOR']
        ?? $_SERVER['HTTP_FORWARDED']
        ?? $_SERVER['REMOTE_ADDR'];
    }
}