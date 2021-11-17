<?php

/**
 *
 * routing.php
 *
 * Init file
 *
 * @author     winact
 * @copyright  2021 Fabian
 *
 */

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/routing.php";
require $_SERVER["DOCUMENT_ROOT"] . "/app/config.php";
require $_SERVER["DOCUMENT_ROOT"] . "/app/functions.php";
require $_SERVER["DOCUMENT_ROOT"] . "/app/database.php";

routing::add([
    "/" => "/shop/index.html",
    "/login" => "/shop/login.html",
    "/single-product/{id}" => "/shop/single-product.html",
    "/test/aaa/{aada}" => "/shop/single-product.html",
]);

# check if $test and $test2 are the same


routing::post("/authentication", "/shop/authentication.php");
routing::get("/authentication", "/shop/single-product.html");
# outing::temp();
routing::boot();

database::connect();

$test = database::query("SELECT * FROM `test` WHERE id = ?")
        ->execute([1])
        ->getOne();
