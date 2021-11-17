<?php

/**
 *
 * database.php
 *
 * Database Class
 *
 * @author     winact
 * @copyright  2021 Fabian
 *
 */

class database {
    public static $connection;
    private static $str;

    private static $select;
    private static $where;
    private static $from;
    private static $query;


    static function connect() {
        $servername = config::database("host");
        $username = config::database("username");
        $password = config::database("password");
        $dbname = config::database("dbname");

        self::$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param $query
     * @return performed query.
     */
    static function rawQuery($query) {
        self::$str = self::$connection->query($query);
        return new self;
    }

    /**
     * @param $input
     * @return first index of the results.
     */
    function getOne() {
        self::$str = self::$str->fetch();
        return self::$str;
    }

    /**
     * @param $input
     * @return all results as a array of the performed query.
     */
    function getAll() {
        self::$str = self::$str->fetchAll();
        return self::$str;
    }

    function toJSON() {
        self::$str = json_encode(self::$str);
        return new self;
    }

    static function disconnect() {
        self::$connection->close();
    }

    static function query($query) {
        self::$str = $query;
        return new self;
    }

    function execute($bindparam) {
        if (is_array($bindparam)) {
            self::$connection = self::$connection->prepare(self::$str);
            self::$connection->execute($bindparam);
            self::$str = self::$connection;
            return new self;
        }
    }
    /*
    function event_cron($name, $interval, $start, $query) {

    }
    function event_show() {
        return $this->connection->query("SHOW EVENTS FROM " . $this->database);
    }
    */
    static function error() {
        functions::clog("Konnte nicht mit der Datenbank verbinden!");
        header("HTTP/1.1 500");
    }
}
