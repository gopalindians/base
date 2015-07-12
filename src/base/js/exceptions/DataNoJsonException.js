base.util.js.namespace('exceptions', base);

/**
 * Constructor.
 * This exception is used in base.mvc.Model.
 *
 * @param data the data which failed parsing to json.
 */
base.exceptions.DataNoJsonException = function(data){
	this.name = 'DataNoJsonException';
	this.message = 'The data could not be parsed to an JSON object! Data was: '+data;
};

base.util.js.extend(Error, base.exceptions.DataNoJsonException);
