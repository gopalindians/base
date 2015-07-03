flimsy.util.js.namespace("util.js", flimsy);

flimsy.util.js.extend = function(base, child){
	child.prototype = Object.create(base.prototype);
    child.prototype.constructor = child;
};
