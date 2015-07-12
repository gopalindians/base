base.util.js.namespace('exceptions', base);

/**
 * Constructor.
 * This exception is used in base.mvc.Model.
 *
 * @param model the model which caused this status error
 * @param status the status code
 */
base.exceptions.AjaxStatusException = function(model, status){
	this.name = 'AjaxStatusException';
	this.message = 'Bad status on ajax request: '+status;
};

base.util.js.extend(Error, base.exceptions.AjaxStatusException);
