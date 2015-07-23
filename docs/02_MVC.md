# MVC

## Controller

To write a controller you need to extend the *Controller* class:

```PHP
class MyController extends base\Controller{
    function __construct($view){ // this controller WILL use a view
        base\Controller::__construct(array(), $view); // pass empty params array and view
    }

    function resolveGET(array $get){ // accept GET parameters, called on GET requests
        // this is a nice way to delegate work:
        if(isset($get['action'])){
            $this->doSomethingComplex();
        }

        $this->view->setName($get['name']); // pass a GET parameter to view
        $this->view->display(); // show page
    }
    
    // you can override resolveXY() for different methods, see Controller for more

    private function doSomethingComplex(){
        // do something, validate a form or something...
    }
}
```

There is a *StaticController*, which can be used for standard pages, without logic.

## View

A view is used to display your page. As for a controller, you have to extend the *View* base class:

```PHP
class MyView extends base\View{
    function display(){
        // use smarty or whatever to display your page
    }
}
```

## Model

A model is used to map a front end object (JavaScript) to a backend object (PHP and database), which makes it easier to store data and manipulate your page.
The communication is established using POST Ajax requests. Requests are handled asynchronous.

### Server

Server sides, overload the *Model* class to create a new entity. You have to override a few methods to send and receive an object to/from the frontend:

```PHP
class TestModel extends base\Model{
    const NAME = 'TestModel'; // classname

    public $a; // some data
    public $b;

    function __construct(){
        base\Model::__construct(TestModel::NAME); // pass the identification name to parent class
    }

    static function jsonDeserialize($post){
        // here we check and get an object from the POST request
        if(($data = base\Model::checkJsonObject($post, TestModel::NAME)) == null){
            return null;
        }

        // if it maps to this class, create a new instance, set data and return it
        $obj = new TestModel();
        base\Model::set($obj, 'a', $data); // use this static method to set members,
        base\Model::set($obj, 'b', $data); // it will check the member for existance

        return $obj;
    }

    // this is used to send this object to the frontend
    function getData(){
        return array('a' => $this->a, 'b' => $this->b));
    }
}
```

Now that we have our entities backend representation, we can use it to receive and send an object to the frontend on request. In a controller you can do the following (if it accepts POST requests):

```PHP
$test = TestModel::jsonDeserialize($_POST); // receive the entity

if($test){ // if it maps to "TestModel", use it and send the result
    $test->a = 123;
    $test->b = 456;
    print $test->jsonSerialize();
}
else{
    // send an error or expected entity
}
```

Notice, *jsonSerialize()* does not print to the output, it returns a string containing the serialized object. This can be useful to chain multiple objects by concatenation. If you just want to send a single object, you can directly print it.

### Client

As for the backend, we create a client side entity by extending the *Model* base class, but this time the JavaScript version:

```JS
var TestModel = function(){
    base.mvc.Model.call(this, 'TestModel'); // pass the identification to the base class

    this.a = 987; // some data
    this.b = 654;
};

base.util.js.extend(base.mvc.Model, TestModel); // extend it by calling this function

TestModel.prototype.receive = function(data){ // will be called, if an received object maps to this class
    this.a = data.a;
    this.b = data.b;
};

TestModel.prototype.getData = function(){ // equivalent to jsonSerialize()
    return {a:this.a, b:this.b};
};
```

And use it:

```JS
$(document).ready(function(){
    // create a new entity
    var test = new TestModel();
    
    // check output before
    console.log(test.a); // will print "987"
    console.log(test.b); // "654"

    // check output after by using the (optioal) callback function
    var callback = function(data){
        console.log(test.a+"|"+test.b); // will print "123|456"
    }

    // send it to ./ (URL) and asynchroniously receive result in callback
    test.send("./", callback);
});
```
