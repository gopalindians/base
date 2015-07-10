/**
 * base namespace setup
 * INCLUDE THIS FILE BEFORE OTHER base JS FILES!
 */

var base = {};
base.util = {};
base.util.js = {};

/**
 * Adds an object to base namespace by string if it does not exist.
 * Example: my.sample.namespace
 *
 * @param space the new namespace object
 * @param parent the base namespace object, "space" will be chained
 * @return the parent namespace object
 */
base.util.js.namespace = function(space, parent){
	var spaces = space.split('.');
	
	if(!spaces.length || parent == null){
		return null;
	}
	
	var base = parent;
	var start = base;
	
	for(var i in spaces){		
		base[spaces[i]] = base[spaces[i]] || {};
		base = base[spaces[i]];
	}
	
	return start;
};
