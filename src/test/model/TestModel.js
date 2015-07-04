var TestModel = function(){
	flimsy.mvc.Model.call(this, 'TestModel');

	this.a = 987;
	this.b = 654;
};

flimsy.util.js.extend(flimsy.mvc.Model, TestModel);

TestModel.prototype.receive = function(data){
	this.a = data.a;
	this.b = data.b;
};

TestModel.prototype.getData = function(){
	return {a:this.a, b:this.b};
};
