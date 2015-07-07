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

	var self = this;
	var res = function(data){
		self._receive(data);
	}

	// create object and send
	var name = this._classname;
	var data = JSON.stringify(this.getData());
	var obj = {};
	obj[name] = data;

	$.post(url, obj, res);
};

/**
 * Receive function called on result when this object was send.
 * You need to override this and assign the classes attributes!
 *
 * @param data received data as json object
 * @return void
 */
flimsy.mvc.Model.prototype.receive = function(data){
	throw new flimsy.mvc.MethodNotImplementedException("Model", "receive");
};

/**
 * Used to send this objects data as string (JSON.stringify()).
 * You need to override this and return an object containg the data you want to send!
 *
 * @return void
 */
flimsy.mvc.Model.prototype.getData = function(){
	throw new flimsy.mvc.MethodNotImplementedException("Model", "getData");
};

flimsy.mvc.Model.prototype._receive = function(data){
	try{
		var obj = JSON.parse(data);

		// check classname
		if(obj.class != this._classname){
			return;
		}
	}
	catch(e){
		throw new flimsy.mvc.DataNoJsonException(data);
	}

	this.receive(obj.data);

	if(this._callback){
		this._callback(obj.data);
	}
};

/**
 * Constructor.
 * This exception is used in flimsy.mvc.Model.
 *
 * @param data the data which failed parsing to json.
 */
flimsy.mvc.DataNoJsonException = function(data){
	this.name = "DataNoJsonException";
	this.message = "The data could not be parsed to an JSON object! Data was: "+data;
};

flimsy.util.js.extend(Error, flimsy.mvc.DataNoJsonException);

/**
 * Constructor.
 * This exception is used in flimsy.mvc.Model.
 *
 * @param data the data which failed parsing to json.
 */
flimsy.mvc.DataNoJsonException = function(data){
	this.name = "DataNoJsonException";
	this.message = "The data could not be parsed to an JSON object! Data was: "+data;
};

flimsy.util.js.extend(Error, flimsy.mvc.DataNoJsonException);
