$(document).ready(function(){
 	//search();
});


function search(){
	var ss = $("#search_field").val();
	//alert(ss);
	$.ajax({
		url: "../PHP/search.php", type : "post", async : false,
		data:{
			'ajax' : true,
			'search_string' : ss
		},
	success: function( data ) {
		//alert("success!");
		$("#results").html(data);
	},
	error: function(xhr, status, error) {
		var err = JSON.parse(xhr.responseText);
  		alert(err.Message);
	}
	});
	
	$("title").html("Done with ajax request");
}

$( document ).ajaxComplete(function(xhr) {
	console.log(xhr.responseText);
});

$( document ).ajaxError(function(xhr) {
	console.log("Error");
	var err = JSON.parse(xhr.responseText);
	console.log(err.Message);
});