<?php

class config {
    static function database($param) {
        return parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/app/configs/config.ini")[$param];
    }
}