# Routing

## Router

To setup a new router for your website, create a new Router object and add paths:

```PHP
$router = new base\Router('base_path'); // base_path is optional

// Option 1: simple path resolver
$router->when('/', // start page (index)
              array('GET'), // limit request type to: GET, POST, PUT, DELETE, ...
              new IndexController(new IndexView(/* some useful params, e.g. db connection or smarty */)));

// Option 2: path resolver with (non optional) GET parameters
$router->when('/my_page/:param0/:param1', // page: "my_page", params: "param0", "param1" (as much as you need)
              array('GET'),
              new MyPageController(new MyPageView()));

// Option 3: path resolver with optional GET parameters
$router->when('/other_page/:param0/:param1?', // page: "other_page", params: "param0", "param1" (last parameter is optional)
              array('GET'),
              new OtherPageController(new MyPageView())); // you can use the same view for multiple controllers of course

// this is not possible (required parameter after optional parameter):
//$router->when('/foo/:bar?/:param', ...);

// Option 4: multiple resolver for a single page with multiple parameters
$router->when('/:name', // start page (index), but this time with parameter
              array('POST'), // requires POST request
              new CompletlyDifferentController(new IndexView()));

// Option 5: resolve unresolved pages:
$router->otherwise('/404'); // redirect to 404, which does not exists in this example, see exceptions

// and finally resolve current URL:
$router->resolve();
```

You do not have to pass a view, lets say for form validation controller.
Using option 4, the route "/" won't be replaced, but extended. If you call your page like: http://yourpage.com/ the URL will be resolved by the first route. If you call: http://yourpage.com/:param the URL will be resolved by the second route. This can be used to use different controllers for the "same" route. If you like to delegate this on your own, you can use option 3.

If a path cannot be resolved, the page will be redirected to *otherwise(path)*, which must accepts the required method (GET, POST, ...). If this page also doesn't exists or doesn't accept the HTTP method, an *RouteUnresolvedException* will be thrown. There are two possible exceptions thrown by *resolve()*:

* RouterPathException - the URL cannot be parsed
* RouteUnresolvedException - the route couldn't be resolved (even after redirecting)

Catch them like so:

```PHP
try{
    $router->resolve();
}
catch(base\RouterPathException $e){
    // handle...
}
catch(base\RouteUnresolvedException $e){
    // handle...
}
```

### Trigger

It is possible to trigger a route (= controller). This can be used to execute some code in a controller, like reading data from database that is always needed:

```
$router->trigger('/myroute', array('GET', 'POST'));
```

This will trigger the GET and POST methods from "myroute" controller. The methods are optional, if you leave them out, the GET method will be used by default.

## Routing in HTML and file paths

Since we use a RESTful URL, relative file paths cannot be resolved correctly in HTML. To solve this issue use one of the following methods:

```HTML
<!-- set the absolute base path, which is used to resolve ALL other relative paths (best solution in my opinion): -->
<!DOCTYPE html>
<html>
    <head>
        <base href="/your/base/path/" />
        <!-- ... -->
    </head>
    <body>
        <img src="relative/path.png" /> <!-- works! -->
        <!-- ... -->
    </body>
</html>

<!-- use absolute paths: -->
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <img src="/your/base/path/relative/path.png" /> <!-- works! -->
        <!-- ... -->
    </body>
</html>

<!-- fix the relative path (NOT recommended): -->
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <img src="../relative/path.png" /> <!-- fixes example URL: http://yourpage.com/home/:yourname -->
        <!-- ... -->
    </body>
</html>
```
