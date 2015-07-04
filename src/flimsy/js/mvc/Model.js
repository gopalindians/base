flimsy.util.js.namespace("mvc", flimsy);

/**
 * Constructor.
 *
 * @param classname pass the name of implementing class to serialize/deserialize,
 *		  should be unique, default is "Model"
 */
flimsy.mvc.Model = function(classname){
	if(!classname){
		this._classname = "Model";
	}
	else{
		this._classname = classname;
	}

	this._callback = null;
};

/**
 * Posts this object to the server, using default schema.
 *
 * @see Model.php
 * @param url the URL to pass the object
 * @param callback a callback function which will be called to receive the result
 * @return void
 */
flimsy.mvc.Model.prototype.send = function(url, callback){
	if(typeof url !== "string"){
		return;
	}

	this._callback = callback;

	$.post(url, {class:this._classname, data:this}, this._receive);
};

/**
 * Receive function called on result when this object was send.
 * You need to override this and assign the classes attributes!
 *
 * @param data received data as json object
 * @return void
 */
flimsy.mvc.Model.prototype.receive = function(data){
	// override!
};

/**
 * Private!
 */
flimsy.mvc.Model.prototype._receive = function(result){
	console.log('mäh');

	try{
		var obj = JSON.parse(result);

		// check classname
		if(obj.class != this._classname){
			return;
		}
	}
	catch(e){
		return;
	}

	this.receive(obj.data);

	if(this._callback){
		this._callback(obj.data);
	}
};
