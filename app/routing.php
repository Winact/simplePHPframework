<?php

/**
 *
 * routing.php
 *
 * Standart access routing
 *
 * @author     winact
 * @copyright  2021 Fabian
 *
 */

/**
 *
 * $route array
 *
 * [route => [destination, request-method]]
 *
 */

define("root", $_SERVER["DOCUMENT_ROOT"]);

class routing {
    private static $route = [];
    private static $redirects = [];
    private static $routeParameter = [];

    static function add($route) {
        if(is_array($route)) {
            self::$route = array_merge(self::$route, $route);
        }
    }

    private static function addArrayEntry($route, $return, $method) {
        self::$route[$route][$method] = $return;
//        if(!isset(self::$route[$route])) {
//            self::$route[$route] = [];
//        } else {
//            self::$route[$route][$method] = $return;
//        }
    }
    static function get($route, $return) {
        if(self::urlRouteParameters($route) == true) {
            # replace "{}" with ""
            $return = preg_replace("/{[^}]*}/", "?", $return);
            echo $return;
        }

        self::addArrayEntry($route, $return, "GET");
    }

    static function post($route, $return) {
        self::addArrayEntry($route, $return, "POST");
    }

    static function put($route, $return) {
        self::addArrayEntry($route, $return, "PUT");
    }

    static function delete($route, $return) {
        self::addArrayEntry($route, $return, "DELETE");
    }

    # TODO: routing with parameters
    private static function urlRouteParameters($url) {
        if (preg_match('/{.*}/', $url)) {
            return true;
        } else {
            return false; 
        }
    }

    static function boot() {
        $pageFound = false;
        foreach(self::$route as $routeURI => $routeFILE) {
            $routeURI = explode("/", $routeURI);
            $URL = explode("/", $_SERVER["REQUEST_URI"]);
            $count = count($URL);
            foreach($URL as $urlKey => $urlValue) {
                if(self::urlRouteParameters((($routeURI[$urlKey] ?? ""))) == true) {
                    $count--;
                } elseif($urlValue == ($routeURI[$urlKey] ?? "")) {
                    $count--;
                }
            }
            functions::debug("count: " . $count);
            if($count == 0) {
                $pageFound = true;
                if(is_array($routeFILE)) {
                    if(array_key_exists($_SERVER["REQUEST_METHOD"], $routeFILE)) {
                        echo "test";
                        self::loadFile($routeFILE[$_SERVER["REQUEST_METHOD"]]);
                    } else {
                        include(root . "/resources/errors/404.html");
                        http_response_code(404);
                    }
                } else {
                    self::loadFile($routeFILE);
                }
                break;
            }
        }
        if($pageFound == false) {
            include(root . "/resources/errors/404.html");
            http_response_code(404);
        }
    }

    private static function loadFile($path) {
        $path = root . "/routes" . $path;
        if(file_exists($path)) {
            include($path);
        } else {
            include(root . "/resources/errors/404.html");
            http_response_code(404);
        }
    }

    static function temp() {
        print("<pre>".print_r(self::$route,true)."</pre>"); 
    }

    static function redirect($request, $redirect, $statusCode = false) {
        self::$redirects[$request] = [$redirect, $statusCode];
    }

    static function maintenance() {
        include(root . "/resources/maintenance/index.php");
        http_response_code(503);
    }
}
