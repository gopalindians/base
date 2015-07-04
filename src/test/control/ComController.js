$(document).ready(function(){
	var callback = function(data){
		console.log("callback");
	}

	var test = new TestModel();
	
	console.log(test.a);
	console.log(test.b);

	test.send("./", callback);

	console.log(test.a);
	console.log(test.b);
});
