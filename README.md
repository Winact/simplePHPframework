# simple-php-framework
 
Simple, fast and secure PHP Framework with easy integration.

Add multiple Routes
```
routing::add([
    "/" => "/shop/index.html",
    "/login" => "/shop/login.html",
    "/single-product/{id}" => "/shop/single-product.html",
    "/test/aaa/{aada}" => "/shop/single-product.html",
]);
```

You can use one route for different request methods. Allowed methods are Post, Get, Delete and Put.
```
routing::get("/authentication", "/shop/single-product.html");

routing::post("/authentication", "/shop/authentication.php");
```

Starts the Routing.
```
routing::boot();
```

Starts the maintenance mode. 
The default directory for the maintenance mode is "/resources/maintenance/".
Important: Either the Routing should be started, or the maintenance mode,
```
routing::maintenance();
```

Outputs the passed message to the console.
```
functions::debug("console print");
```

Execute Query with prepared statements.
To fetch a result, you can use the Methods getOne / getAll.
```
database::query("SELECT * FROM `table` WHERE id = ?")
        ->execute([1])
        ->getOne();
```

Executes a raw query without escaping.
```
database::rawQuery("SELECT * FROM `table` WHERE id = 1")
        ->getOne();
```
