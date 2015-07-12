base.util.js.namespace('exceptions', base);

/**
 * Constructor.
 *
 * @param classname the classname
 * @param method the method name which must be overwritten
 */
base.exceptions.MethodNotImplementedException = function(classname, method){
	this.name = 'MethodNotImplementedException';
	this.message = 'The method '+method+' was not implemented in class '+classname;
};

base.util.js.extend(Error, base.exceptions.MethodNotImplementedException);
