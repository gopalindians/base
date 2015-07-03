flimsy.util.js.namespace("util.js", flimsy);

/**
 * Function to extends JS classes.
 * Create the constructor and call extend afterwards. Then add your methods by prototype chaining.
 *
 * @param base base class (Constructor, not an instance)
 * @param child child class (Constructor, not an instance)
 * @return void
 */
flimsy.util.js.extend = function(base, child){
	child.prototype = Object.create(base.prototype);
    child.prototype.constructor = child;
};
