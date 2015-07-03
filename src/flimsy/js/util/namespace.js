// flimsy namespace setup
var flimsy = {};
flimsy.util = {};
flimsy.util.js = {};

flimsy.util.js.namespace = function(space, parent){
	var spaces = space.split(".");
	
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
