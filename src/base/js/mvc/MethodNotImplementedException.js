base.util.js.namespace('mvc', base);

/**
 * Constructor.
 *
 * @param classname the classname
 * @param method the method name which must be overwritten
 */
base.mvc.MethodNotImplementedException = function(classname, method){
	this.name = 'MethodNotImplementedException';
	this.message = 'The method '+method+' was not implemented in class '+classname;
};

base.util.js.extend(Error, base.mvc.MethodNotImplementedException);
