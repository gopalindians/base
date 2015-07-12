base.util.js.namespace('mvc', base);

/**
 * Constructor.
 *
 * @param classname pass the name of implementing class to serialize/deserialize,
 *		  should be unique, default is 'Model'
 */
base.mvc.Model = function(classname){
	if(!classname){
		this._classname = 'Model';
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
base.mvc.Model.prototype.send = function(url, callback){
	if(typeof url !== 'string'){
		return;
	}

	// connect
	var req = new XMLHttpRequest();
	req.open('POST', url, true);
	req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');

	// callback
	this._callback = callback;

	var self = this;
	req.onreadystatechange = function(){
		if(req.status != 200){
			throw new base.exceptions.AjaxStatusException(self._classname, req.status);
		}

		if(req.readyState == 4){
			self._receive(req.responseText);
		}
	};

	// send
	req.send(this._classname+'='+JSON.stringify(this.getData()));
};

/**
 * Receive function called on result when this object was send.
 * You need to override this and assign the classes attributes!
 *
 * @param data received data as json object
 * @return void
 */
base.mvc.Model.prototype.receive = function(data){
	throw new base.exceptions.MethodNotImplementedException('Model', 'receive');
};

/**
 * Used to send this objects data as string (JSON.stringify()).
 * You need to override this and return an object containg the data you want to send!
 *
 * @return void
 */
base.mvc.Model.prototype.getData = function(){
	throw new base.exceptions.MethodNotImplementedException('Model', 'getData');
};

base.mvc.Model.prototype._receive = function(data){
	try{
		var obj = JSON.parse(data);

		// check classname
		if(obj.class != this._classname){
			return;
		}
	}
	catch(e){
		throw new base.exceptions.DataNoJsonException(data);
	}

	this.receive(obj.data);

	if(this._callback){
		this._callback(obj.data);
	}
};
