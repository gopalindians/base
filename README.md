# flimsy

A lightweight PHP/JS router and MVC framework, build for hand written simple and complex web applications.

## Requirements

* PHP (latest version recommended)
* .htaccess support (RewriteEngine and FollowSymLinks)
* JS
* jQuery (include before flimsy JS files!)
* MySQL (optional)

## Setup

1. Download the latest flimsy version.
2. Copy the flimsy directory to any location into your project you like.
3. Copy the .htaccess file into your projects root directory.
4. Setup flimsy in your index.php.
5. And you're ready to use flimsy!

Setup flimsy in your index.php:

```PHP
define('FLIMSY_ROOT', 'path/to/flimsy');
require_once 'path/to/flimsy/flimsy.php'; // this will include all required classes
```

## Usage

### Router

To setup a new router for your website, create a new Router object and add paths:

```PHP
$router = new Router('base_path'); // base_path is optional

// Option 1: simple path resolver
$router->when('/', // start page (index)
			  array('GET'), // limit request type to: GET, POST, PUT, DELETE
			  new IndexController(new IndexView(/* some useful params, e.g. db connection or smarty */)));

// Option 2: path resolver with GET parameters
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
$router->otherwise(/404); // redirect to 404, which does not exists in this example, see exception

// and finally resolve current URL:
$router->resolve();
```

You do not have to pass a view, lets say for form validation controller.

If a path cannot be resolved, the page will be redirected to *otherwise(path)*, which must accepts the required method (GET, POST, ...). If this page also doesn't exists or doesn't accept the HTTP method, an *RouteUnresolvedException* will be thrown. There are two possible exceptions thrown by *resolve()*:

* RouterPathException - the URL cannot be parsed
* RouteUnresolvedException - the route couldn't be resolved (even after redirecting)

Catch them like so:

```PHP
try{
	$router->resolve();
}
catch(RouterPathException $e){
	// handle...
}
catch(RouteUnresolvedException $e){
	// handle...
}
```

### Routing in HTML and file paths

Since we use a RESTful URL, relative file paths cannot be resolved correctly. To solve this issue use one of the following methods:

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

### Controller

To write a controller you need to extend the *Controller* class:

```PHP
class MyController extends Controller{
	function __construct($view){ // this controller WILL use a view
		Controller::__construct($view);
	}

	function exec(array $get, $method){ // accept GET parameters and HTTP method passed by router
		// this is a nice way to delegate work:
		if(isset($get['action'])){
			$this->doSomethingComplex();
		}

		$this->view->setName($get['name']); // pass a GET parameter to view
		$this->view->display(); // show page
	}

	private function doSomethingComplex(){
		// do something, validate a form or something...
	}
}
```

### View

A view is used to display your page. As for a controller, you have to extend the *View* base class:

```PHP
class MyView extends View{
	function display(){
		// use smarty or whatever to display your page
	}
}
```

### Model

A model is used to map a front end object (JavaScript) to a backend object (PHP), which makes it easier to store data and manipulate your page.

#### Server

*WIP*

#### Client

First of all, you should set jQuery ajax to async, so that you page does not freeze on posts.
Put these lines before executing any flimsy code:

```
$.ajaxSetup({
	async:true
});
```

*WIP*

### Database

flimsy provides MySQL database access and an simple interface for other databases. We just discuss the MySQL class here, to keep things simple.
*MySQL* uses a mysqli PHP object to connect and work with your database. It is wrapped to shorten queries and to support usage of transactions. Transactions are activated by default and require a call to *commit()* to commit your changes. This is not required for selects, creating tables and so on (default behavior of mysqli). The connection will be closed when the object gets destroyed.

Example for simple queries:

```PHP
$db = new MySQL('host', 'user', 'password', 'database');

$db->query('CREATE TABLE ...'); // simply calls query of mysqli and returns result (mixed)
$db->select('FROM ...'); // adds SELECT in front of query and returns results AS AN ARRAY OF OBJECTS, which covers most (if not all) uses of an SELECT
$db->insert('...'); // analog to select
$db->delete('...'); // analog to select
$db->exists('...'); // adds EXISTS SELECT(SELECT 1 FROM in front of query, you need to provide the table and WHERE, the result will be true/false
$db->commit(); // commit your changes (INSERTs mostly)
$db->rollback(); // if called before commit(), all changes will be rolled back
```

## License

MIT
