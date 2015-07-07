flimsy.util.js.namespace("mvc", flimsy);

/**
 * Constructor.
 *
 * @param classname the classname
 * @param method the method name which must be overwritten
 */
flimsy.mvc.MethodNotImplementedException = function(classname, method){
	this.name = "MethodNotImplementedException";
	this.message = "The method "+method+" was not implemented in class "+classname;
};

flimsy.util.js.extend(Error, flimsy.mvc.MethodNotImplementedException);
