$(document).ready(function(){
	var test = new TestModel();
	
	// before
	console.log(test.a);
	console.log(test.b);

	// after
	var callback = function(data){
		console.log(test.a+"|"+test.b);
	}

	test.send("./", callback);
});
