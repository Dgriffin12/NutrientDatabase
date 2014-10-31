var search_string = ""; //global for nutrition facts knowing the name, rather than querying for it.
var logged_in = false; //global for knowing if a user is logged in
var cur_user = ""; //global user_name

//sets on click events and attempts to login off of a cookie.
$(document).ready(function(){	
	set_on_clicks();
	cookie_login_attempt();
});

//Reverts the page back to its original state, except performs a search on the global variable search_string.
function home(){
	$("#login").html('Login: <div id = "login_results"></div><input id = "username_login" type = "text" value = "username"/><input id = "password_login" type = "password" value = "password"/><button id = "login_button" onclick = "login(\'\', \'\')">Login</button><button id = "create_acc_button" onclick = "create_acc()">Create Account</button>');
	$("#Goals").html("");
	$("#Diary").html("");
	$("#search_field_div").html('<br><br>Search for a food:<br><input id = "search_field" type = "text" value = "Search for Food"/><button id = "search_button" onclick = "search(false)">Search</button>');
	$("#results").html("");
	set_on_clicks();
	cookie_login_attempt();
	search(search_string);
}

//Search function, ajax lookup for names of foods, paramater data used for coming back from nutrition facts(re-searching on the search_string IF back is pressed)
//data = true : re-search initiated from pressing back after viewing nutrition facts on an item.
//data = false : search from main page
function search(data){
	$("#results").css("color", "black");
	if(!data)
	{
		search_string = $("#search_field").val();
	}
	if (search_string=="" || search_string == "Search for Food") 
	{
    	document.getElementById("results").innerHTML="";
    	return;
  	} 
  	
  	if (window.XMLHttpRequest)
  	{
    	// code for IE7+, Firefox, Chrome, Opera, Safari
    	xmlhttp=new XMLHttpRequest();
  	} else 
  	{ // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
  	
  	xmlhttp.onreadystatechange=function() {
    	if(xmlhttp.readyState==4 && xmlhttp.status==200) 
    	{
      		document.getElementById("results").innerHTML=xmlhttp.responseText;
    	}
  	} //end of function
  	
  xmlhttp.open("GET","../PHP/search.php?q=" + search_string + "&k="+ logged_in,true);
  xmlhttp.send();
  $("#search_field").val("Search for Food");
}

//login function, gets rid of cookie if there is one and reinstantiates a new cookie for this login.
function login(acc, pw){
	var username;
	var password;
	if(acc === "" || pw === "")
	{
		username = $("#username_login").val();
		password = $("#password_login").val();
	}else
	{
		username = acc;
		password = pw;
	}

	$.ajax({
		method: 'get',
		url: '../PHP/login.php',
		data: {
			'username' : username,
			'password' : password,
			'ajax' : true
		},
		success: function(data){
			var array = jQuery.parseJSON(data);
			if(array['status'] == "good")
			{
				logged_in = true;
				cur_user = array['username'];
				diary_update();
				search(search_string);
				$("#notify").css("color", "blue");
				$("#notify").html("Logged in as "+ array['username'] + '.');
				$("#login").html('<button id = "logout_button" onclick = "logout()">Logout</button>');
				$("#Goals").html('<button id = "goals_button" onclick = "view_goals()">Goals</button>');
				$("#Diary").html(array['username'] + "'s Food Journal");
				$("#search_field_div").html("<br><br>Search for a food:<br><input id = 'search_field' type = 'text' value = 'Search for Food'/><button id = 'search_button' onclick = 'search(false)'>Search</button><button id = 'add_food_button' onclick = 'add_food()'>Add Food to Database</button>");
				set_on_clicks();
				document.cookie =  Math.floor(Math.random()*9223372036854775807) + '|' + array['username'];
				create_and_store_cookie();
			}else
			{
				$("#login_results").css("color", "red");
				$("#login_results").html(array['text']);
			}
		}
	});
	
}

//Create account function, gets username and password from corresponding main_page.html fields, ajax to database to enter info.
function create_acc(){
	var username = $("#username_login").val();
	var password = $("#password_login").val();
	var p1_edit = false;
	var p2_edit = false;
	var acc_change = false;
	
	$("#results").html("");
	$("#login").html("");
	$("#Diary").html("<label style = 'font-weight:bold'>Create Account </label><br>");
	$("#Diary").append("<label>Account Name:</label><input id = 'account_name_field' type = 'text'></input><br>");
	$("#Diary").append("<label>Password:        </label><input id = 'password' type = 'password'></input><br>");
	$("#Diary").append("<label>Confirm Password:</label><input id = 'password2' type = 'password'></input><div id = 'pw_notify' style='color:red'><br></div>");
	$("#Diary").append('<button id = "back_to_diary">Back</button><br>' + "<button id = 'create_account_submit_button'>Submit</button>");
	$("#back_to_diary").on("click", function(){
		home();
	});
	$("#search_field_div").html("");
	$("#create_account_submit_button").on("click.validate_submit", function(){
		validate_create_acc_field();
	});
	$("#account_name_field").change(function(){
		acc_change = true;
		if($("#account_name_field").val() == "" && acc_change == true)
		{
			$("#login_results").html("");
			$("#pw_notify").html("Account Name required for account creation.");
			$("#create_account_submit_button").unbind("click.good_submit");
		}else if(($("#account_name_field").val != "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
		{
			$("#pw_notify").html("<br>");
			$("#results").html("");
			$("#results").css("color", "black");
			$("#create_account_submit_button").on("click.good_submit", function(){					
				create_acc_submit();
			});
		}
	});
	$("#account_name_field").keyup(function(){
		acc_change = true;
		if($("#account_name_field").val() == "" && acc_change == true)
		{
				$("#login_results").html("");
				$("#pw_notify").html("Account Name required for account creation.");
				$("#create_account_submit_button").unbind("click.good_submit");
		}else if(($("#account_name_field").val != "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
		{
			$("#pw_notify").html("<br>");
			$("#results").html("");
			$("#results").css("color", "black");
			$("#create_account_submit_button").on("click.good_submit", function(){					
				create_acc_submit();
			});
		}
	});
	$("#password").change(function(){
		p1_edit = true;
		if(p1_edit && p2_edit)
		{
			validate_create_acc_field();
			if(($("#password").val() != $("#password2").val())  && ($("#account_name_field").val == "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#login_results").html("");
				$("#pw_notify").html("Account Name required for account creation.");
				$("#create_account_submit_button").unbind("click.good_submit");
			}else if(($("#password").val() != $("#password2").val()) && ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#login_results").html("");
				$("#pw_notify").html("Passwords do not match.");
				$("#create_account_submit_button").unbind("click.good_submit");
			}else if(($("#account_name_field").val != "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#pw_notify").html("<br>");
				$("#results").html("");
				$("#results").css("color", "black");
				$("#create_account_submit_button").on("click.good_submit", function(){					
					create_acc_submit();
				});
			}
		}
	});
	$("#password").keyup(function(){
		p1_edit = true;
		if(p1_edit && p2_edit)
		{
			validate_create_acc_field();
			if(($("#password").val() != $("#password2").val())  && ($("#account_name_field").val == "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#login_results").html("");
				$("#pw_notify").html("Account Name required for account creation.");
				$("#create_account_submit_button").unbind("click.good_submit");
			}else if(($("#password").val() != $("#password2").val()) && ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#login_results").html("");
				$("#pw_notify").html("Passwords do not match.");
				$("#create_account_submit_button").unbind("click.good_submit");
			}else if(($("#account_name_field").val != "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#pw_notify").html("<br>");
				$("#results").html("");
				$("#results").css("color", "black");
				$("#create_account_submit_button").on("click.good_submit", function(){					
					create_acc_submit();
				});
			}
		}
	});
	$("#password2").change(function(){
		p2_edit = true;
		if(p1_edit && p2_edit)
		{
			validate_create_acc_field();
			if((($("#password").val() != $("#password2").val())) && ($("#account_name_field").val == "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#login_results").html("");
				$("#pw_notify").html("Account Name required for account creation.");
				$("#create_account_submit_button").unbind("click.good_submit");
			}else if(($("#password").val() != $("#password2").val()) && ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#login_results").html("");
				$("#pw_notify").html("Passwords do not match.");
				$("#create_account_submit_button").unbind("click.good_submit");
			}else if(($("#account_name_field").val != "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#pw_notify").html("<br>");
				$("#results").html("");
				$("#results").css("color", "black");
				$("#create_account_submit_button").on("click.good_submit", function(){
					create_acc_submit();
				});
			}
		}
	});
	$("#password2").keyup(function(){
		p2_edit = true;
		if(p1_edit && p2_edit)
		{
			validate_create_acc_field();
			if((($("#password").val() != $("#password2").val())) && ($("#account_name_field").val == "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#login_results").html("");
				$("#pw_notify").html("Account Name required for account creation.");
				$("#create_account_submit_button").unbind("click.good_submit");
			}else if(($("#password").val() != $("#password2").val()) && ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#login_results").html("");
				$("#pw_notify").html("Passwords do not match.");
				$("#create_account_submit_button").unbind("click.good_submit");
			}else if(($("#account_name_field").val != "")&& ($("#password").val() != "") && ($("#password2").val() != ""))
			{
				$("#pw_notify").html("<br>");
				$("#results").html("");
				$("#results").css("color", "black");
				$("#create_account_submit_button").on("click.good_submit", function(){
					create_acc_submit();
				});
			}
		}
	});
}

//validation for create account fields.
function validate_create_acc_field()
{
	$("#create_account_submit_button").unbind("click.good_submit");
	if(($("#account_name_field").val() == "") && (($("#password").val() == "") || ($("#password2").val() == "")))
	{
		$("#pw_notify").css("color", "red");
		$("#pw_notify").html("Account Name and Password required for account creation.");
		$("#login_results").html("");
		$("#create_account_submit_button").unbind("click.good_submit");
	}
	else if($("#account_name_field").val() == "")
	{
		$("#pw_notify").css("color", "red");
		$("#pw_notify").html("Account Name required for account creation.");
		$("#login_results").html("");
		$("#create_account_submit_button").unbind("click.good_submit");
	}else if($("#password").val() == "")
	{
		$("#pw_notify").css("color", "red");
		$("#pw_notify").html("Password required for account creation.");
		$("#login_results").html("");
		$("#create_account_submit_button").unbind("click.good_submit");
	}else if($("#password2").val() == "")
	{
		$("#pw_notify").css("color", "red");
		$("#pw_notify").html("Please confirm your password.");
		$("#login_results").html("");
		$("#create_account_submit_button").unbind("click.good_submit");
	}

}

function create_acc_submit()
{
	var username = $("#account_name_field").val();
	var password = $("#password").val();
	$.ajax({
		method: 'get',
		url: '../PHP/create_acc.php',
		data: {
			'username' : username,
			'password' : password,
			'ajax' : true
		},
		success: function(data){
			var array = jQuery.parseJSON(data);
			$("#login").html("<div id = 'login_results'></div>");
			if(array['status'] == "good")
			{
				$("#login_results").css("color", "green");
				login(username,password);
				$("#login").html("Login: <div id = 'login_results'></div><input id = 'username_login' type = 'text' value = 'username'/><input id = 'password_login' type = 'password' value = 'password'/><button id = 'login_button' onclick = 'login()'>Login</button><button id = 'create_acc_button' onclick = 'create_acc()'>Create Account</button>'");
				$("#search_field_div").html("<br><br>Search for a food:<br><input id = 'search_field' type = 'text' value = 'Search for Food'/><button id = 'search_button' onclick = 'search(false)'>Search</button><button id = 'add_food_button' onclick = 'add_food()'>Add Food to Database</button>");
				set_on_clicks();
				$("#login_results").html(array['text']);
			}else
			{
				$("#login_results").css("color", "red");
				$("#pw_notify").html(array['text']);
			}
			
		},
		error: function(data){
			$("results").html("something fucked up in php");
		}
	});
	
	
}

//Logout Function, gets rid of cookie in database
function logout()
{
	results = document.cookie.split('|');
	var username = results[1];
	var long_num = results[0];
	
	$.ajax({
		method: 'get',
		url: '../PHP/cookie_logout.php',
		data: {
			'username' : username,
			'long_num' : long_num
		}
	});
	logged_in = false;
	cur_user = "";
	diary_update();
	if(search_string != "")
	{
		search("search_string");
	}else
	{
		$("#results").html("");
	}
	$("#notify").html("");
	$("#login").html('Login: <div id = "login_results"></div><input id = "username_login" type = "text" value = "username"/><input id = "password_login" type = "password" value = "password"/><button id = "login_button" onclick = "login()">Login</button><button id = "create_acc_button" onclick = "create_acc()">Create Account</button>');
	$("#Diary").html("");
	$("#Goals").html("");
	$("Daily_Intake_Table").html("");
	document.cookie = "";
}

//creates and stores a cookie in the database.
function create_and_store_cookie()
{
	var cookie = document.cookie;
	$.ajax({
		method: 'get',
		url: '../PHP/store_cookie.php',
		data: {
			'cookie' : cookie
		}
	});
}

//attempts to login with the document.cookie, should be called from document.ready only(when the user first loads the page)
function cookie_login_attempt()
{
	$("#results").html("");
	results = document.cookie.split('|');
	var username = results[1];
	var long_num = results[0];
	//$("#results2").html(username + " " + long_num);
	$.ajax({
		method: 'get',
		url: '../PHP/cookie_login.php',
		data: {
			'username' : username,
			'long_num' : long_num
		},
		success: function(data){
			var array = jQuery.parseJSON(data);
			if(array['status'] == "good")
			{
				logged_in = true;
				cur_user = array['username'];
				diary_update();
				$("#notify").css("color", "blue");
				$("#notify").html("Logged in as "+ array['username'] + '.');
				$("#login").html('<button id = "logout_button" onclick = "logout()">Logout</button>');
				$("#Diary").html(array['username'] + "'s Food Journal\n" + array['results']);
				$("#Goals").html('<button id = "goals_button" onclick = "view_goals()">Goals</button>');
				$("#search_field_div").html("<br><br>Search for a food:<br><input id = 'search_field' type = 'text' value = 'Search for Food'/><button id = 'search_button' onclick = 'search(false)'>Search</button><button id = 'add_food_button' onclick = 'add_food()'>Add Food to Database</button>");
				set_on_clicks();
			}
			
		}
	});
}

//info will return the nutrition facts of the item of which the "Nutrition" button was pressed, will fill html "#results" and add a back button to call search on the previous search params
function info(food_NDB_No, weight)
{
	$.ajax({
		method: 'get',
		url: '../PHP/food_data_lookup.php',
		data: {
			'NDB_No' : food_NDB_No,
			'logged_in': logged_in,
			'weight' : weight
		},
		success: function(data){
			var back_to_search = "<button onclick = 'search(" + true + ")'>Back</button>";
			$("#results").html(back_to_search + data);
			$("#Food_Amount").change(function(){
				nutrition_update(food_NDB_No, $("#Food_Amount").val());
			});
		}
	});
	
}

function add_entry(food_NDB_No)
{
	var weight = $("#Food_Amount").val();
	if(!weight)
	{
		weight = '0';
	}
	$.ajax({
		method: 'get',
		url: '../PHP/add_entry.php',
		data: {
			'NDB_No' : food_NDB_No,
			'username': cur_user,
			'weight' : weight
		},
		success: function(data){			
			if(data)
			{
				diary_update();	
			}
		}
	});
}

function diary_update()
{
	if(cur_user !== "")
	{
		$.ajax({
			method: 'get',
			url: '../PHP/update_diary.php',
			data: {
				'username' : cur_user
			},
			success: function(data){
				$("#Diary").html(data);
			}
		});
	}else
	{
		$("#Diary").html("");
	}
}

function remove_entry(iddiary_entry)
{
	$.ajax({
		method: 'get',
		url: '../PHP/remove_entry.php',
		data: {
			'id' : iddiary_entry
		},
		success:function(data){
			if(data)
			{
				diary_update();
			}
		}
	});
}

function nutrition_update(food_NDB_No, food_weight)
{
	var multiplier = food_weight / 100; //food_weight in grams divided by 100g(which is what the nut_vals are based upon)
	$.ajax({
		method: 'get',
		url: '../PHP/nutrition_update.php',
		data: {
			'NDB_No' : food_NDB_No
		},
		success:function(data){
			var array = jQuery.parseJSON(data);
			$("#calories").html((array['calories']*multiplier).toFixed(2));
			$("#total_fat").html((array['total_fat']*multiplier).toFixed(2) + "g");
			$("#sat_fat").html((array['sat_fat']*multiplier).toFixed(2) + "g");
			$("#trans_fat").html((array['trans_fat']*multiplier).toFixed(2) + "g");
			$("#mono_fat").html((array['mono_fat']*multiplier).toFixed(2) + "g");
			$("#poly_fat").html((array['poly_fat']*multiplier).toFixed(2) + "g");
			$("#cholesterol").html((array['cholesterol']*multiplier).toFixed(2) + "mg");
			$("#sodium").html((array['sodium']*multiplier).toFixed(2) + "mg");
			$("#carbs").html((array['carbs']*multiplier).toFixed(2) + "g");
			$("#fiber").html((array['fiber']*multiplier).toFixed(2) + "g");
			$("#sugar").html((array['sugar']*multiplier).toFixed(2) + "g");
			$("#protein").html((array['protein']*multiplier).toFixed(2) + "g");
		}
	});
}

function view_goals()
{
	$("#results").html("");
	$("#Goals").html('<button id = "goals_button" onclick = "view_goals()">Goals</button>');
	$("#goals_button").attr('onclick', 'cookie_login_attempt()');
	$("#goals_button").text('Diary');
	$.ajax({
		method: 'get',
		url: '../PHP/fetch_goals.php',
		data: {
			'cur_user' : cur_user
		},
		success: function(data){
			$("#Diary").html(cur_user + "'s Goals: <br>" + data);
			$("#Diary").append("<div id = 'updated_goals_notify'></div>");
		}
	});

}

function set_protein_goal(number_in_grams)
{
	$.ajax({
		method: 'get',
		url: '../PHP/update_goals.php',
		data: {
			'type' : "protein",
			'goal' : number_in_grams,
			'user' : cur_user
		},
		success: function(data){
			if(data)
			{
				$("#updated_goals_notify").html("Successfully updated protein goal.");
			}else
			{
				$("#updated_goals_notify").html("Failed to update protein goal.");
			}
		}
	});
}

function set_carb_goal(number_in_grams)
{
	$.ajax({
		method: 'get',
		url: '../PHP/update_goals.php',
		data: {
			'type' : "carbs",
			'goal' : number_in_grams,
			'user' : cur_user
		},
		success: function(data){
			if(data)
			{
				$("#updated_goals_notify").html("Successfully updated carbohydrate goal.");
			}else
			{
				$("#updated_goals_notify").html("Failed to update carbohydrate goal.");
			}
		}
	});
}

function set_fat_goal(number_in_grams)
{
	$.ajax({
		method: 'get',
		url: '../PHP/update_goals.php',
		data: {
			'type' : "fat",
			'goal' : number_in_grams,
			'user' : cur_user
		},
		success: function(data){
			if(data)
			{
				$("#updated_goals_notify").html("Successfully updated fat goal.");
			}else
			{
				$("#updated_goals_notify").html("Failed to update fat goal.");
			}
		}
	});
}

function set_cal_goal(number)
{
	$.ajax({
		method: 'get',
		url: '../PHP/update_goals.php',
		data: {
			'type' : "calories",
			'goal' : number,
			'user' : cur_user
		},
		success: function(data){
			if(data)
			{
				$("#updated_goals_notify").html("Successfully updated calorie goal.");
			}else
			{
				$("#updated_goals_notify").html("Failed to update calorie goal.");
			}
		}
	});
}

function add_food()
{
	var cal_changed = false;
	var fat_changed = false;
	var carb_changed = false;
	var protein_changed = false;
	var serv_changed = false;
	
	$("#Goals").html('<button id = "goals_button" onclick = "view_goals()">Goals</button><button id = "diary_button" onclick = "cookie_login_attempt()">Diary</button>');
	$("#Diary").html("<label>Food Name: </label><input id = 'food_name' class = 'check_val_add' style = 'color:red' type = 'text' value = 'Name of Food'></input><br>");
	$("#Diary").append("<label>Calories: </label><input id = 'calories_field' class = 'check_val_add' style = 'color:red' type = 'text' value = 'Calories'></input><br>");
	$("#Diary").append("<label>Fat: </label><input id = 'fat_field' class = 'check_val_add' style = 'color:red' type = 'text' value = 'Fat in grams'></input><br>");
	$("#Diary").append("<label>Carbohydrates: </label><input id = 'carbohydrates_field' class = 'check_val_add' style = 'color:red' type = 'text' value = 'Carbohydrates in grams'></input><br>");
	$("#Diary").append("<label>Sugars: </label><input id = 'sugars_field' class = 'check_val_add' type = 'text' style = 'color:red' value = 'Sugar in grams'></input><br>");
	$("#Diary").append("<label>Protein: </label><input id = 'protein_field' class = 'check_val_add' style = 'color:red' type = 'text' value = 'Protein in grams'></input><br>");
	$("#Diary").append("<label>Number of Servings: </label><input id = 'serving_field' class = 'check_val_add' style = 'color:red' type = 'text' value = '# of Servings'></input><br>");
	$("#Diary").append("<label>Serving Size Unit: </label><input id = 'unit_field' class = 'check_val_add' style = 'color:red' type = 'text' value = 'Serving(Cup, tbsp, etc.)'></input><br>");
	$("#Diary").append("<button id = 'submit_add_food'>Submit</button><div id = 'submit_add_food_notify' style = 'color:red'></div><br>");
	$("#search_field_div").html("");
	$("#results").html("");
	$("#results").css("color", "red");
	
	$(".check_val_add").on("focus", function(){
		$(this).val("");
		$(this).css("color", "black");
	});
	
	$("#food_name").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#calories_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#calories_field").on("change", function(){
		cal_changed = true;
		if(fat_changed && carb_changed && protein_changed)
		{
			var intRegex = /^\d+$/;
			var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
			if(( !intRegex.test($("#fat_field").val()) && !floatRegex.test($("#fat_field").val()) ) || ( !intRegex.test($("#carbohydrates_field").val()) && !floatRegex.test($("#carbohydrates_field").val()) ) || ( !intRegex.test($("#sugars_field").val()) && !floatRegex.test($("#sugars_field").val()) ) || ( !intRegex.test($("#protein_field").val()) && !floatRegex.test($("#protein_field").val()) )) 
			{
				$("#results").html("Calories, Fat, Carbohydrates, Sugar, Number of servings, and Protein must be numeric.");
				$("#submit_add_food").unbind("click");
				$("#submit_add_food").bind("click", function(){
					$("submit_add_food_notify").html("Please fix errors before continuing submission.");
				});
			}else
			{
				if($("#calories_field").val() != ((($("#protein_field").val())*4)+(($("#carbohydrates_field").val())*4)+(($("#fat_field").val())*9)))
				{
					$("#results").html("Warning: Calories do not match Fat, Protein and Carbohydrate Values!<br> Calories(" + $("#calories_field").val() + ") does not equal the sum of Fat(" + $("#fat_field").val()*9 + "), Carbohydrates(" + $("#carbohydrates_field").val()*4 + "), and Protein(" + $("#protein_field").val()*4 + ")");
					$("#submit_add_food").unbind("click");
					$("#submit_add_food").bind("click", function(){
						$("submit_add_food_notify").html("Please fix errors before continuing submission.");
					});
				}else
				{
					$("#submit_add_food").on("click", add_food_submit());
				}
			}			
		}
	});
	$("#fat_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#fat_field").on("change",function(){
		fat_changed = true;
		if(cal_changed && carb_changed && protein_changed)
		{
			var intRegex = /^\d+$/;
			var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
			if(( !intRegex.test($("#calories_field").val()) && !floatRegex.test($("#calories_field").val()) ) || ( !intRegex.test($("#carbohydrates_field").val()) && !floatRegex.test($("#carbohydrates_field").val()) ) || ( !intRegex.test($("#sugars_field").val()) && !floatRegex.test($("#sugars_field").val()) ) || ( !intRegex.test($("#protein_field").val()) && !floatRegex.test($("#protein_field").val()) )) 
			{
				$("#results").html("Calories, Fat, Carbohydrates, Sugar, Number of servings, and Protein must be numeric.");
				$("#submit_add_food").unbind("click");
				$("#submit_add_food").bind("click", function(){
					$("submit_add_food_notify").html("Please fix errors before continuing submission.");
				});
			}else
			{
				if($("#calories_field").val() != ((($("#protein_field").val())*4)+(($("#carbohydrates_field").val())*4)+(($("#fat_field").val())*9)))
				{
					$("#results").html("Warning: Calories do not match Fat, Protein and Carbohydrate Values!<br> Calories(" + $("#calories_field").val() + ") does not equal the sum of Fat(" + $("#fat_field").val()*9 + "), Carbohydrates(" + $("#carbohydrates_field").val()*4 + "), and Protein(" + $("#protein_field").val()*4 + ")");
					$("#submit_add_food").unbind("click");
					$("#submit_add_food").bind("click", function(){
						$("submit_add_food_notify").html("Please fix errors before continuing submission.");
					});
				}else
				{
					$("#submit_add_food").on("click", add_food_submit());
				}
			}			
		}
	});
	$("#carbohydrates_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#carbohydrates_field").on("change", function(){
		carb_changed = true;
		if(cal_changed && fat_changed && protein_changed)
		{
			var intRegex = /^\d+$/;
			var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
			if(( !intRegex.test($("#calories_field").val()) && !floatRegex.test($("#calories_field").val()) ) || ( !intRegex.test($("#fat_field").val()) && !floatRegex.test($("#fat_field").val()) ) || ( !intRegex.test($("#sugars_field").val()) && !floatRegex.test($("#sugars_field").val()) ) || ( !intRegex.test($("#protein_field").val()) && !floatRegex.test($("#protein_field").val()) )) 
			{
				$("#results").html("Calories, Fat, Carbohydrates, Sugar, Number of servings, and Protein must be numeric.");
				$("#submit_add_food").unbind("click");
				$("#submit_add_food").bind("click", function(){
						$("submit_add_food_notify").html("Please fix errors before continuing submission.");
					});
			}else
			{
				if($("#calories_field").val() != ((($("#protein_field").val())*4)+(($("#carbohydrates_field").val())*4)+(($("#fat_field").val())*9)))
				{
					$("#results").html("Warning: Calories do not match Fat, Protein and Carbohydrate Values!<br> Calories(" + $("#calories_field").val() + ") does not equal the sum of Fat(" + $("#fat_field").val()*9 + "), Carbohydrates(" + $("#carbohydrates_field").val()*4 + "), and Protein(" + $("#protein_field").val()*4 + ")");
					$("#submit_add_food").unbind("click");
					$("#submit_add_food").bind("click", function(){
						$("submit_add_food_notify").html("Please fix errors before continuing submission.");
					});
				}else
				{
					$("#submit_add_food").on("click", add_food_submit());
				}
			}			
		}
	});
	$("#sugars_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#protein_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#protein_field").on("change", function(){
		protein_changed = true;
		if(cal_changed && fat_changed && carb_changed)
		{
			var intRegex = /^\d+$/;
			var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
			if(( !intRegex.test($("#calories_field").val()) && !floatRegex.test($("#calories_field").val()) ) || ( !intRegex.test($("#fat_field").val()) && !floatRegex.test($("#fat_field").val()) ) || ( !intRegex.test($("#carbohydrates_field").val()) && !floatRegex.test($("#carbohydrates_field").val()) ) || ( !intRegex.test($("#sugars_field").val()) && !floatRegex.test($("#sugars_field").val()) )) 
			{
				$("#results").html("Calories, Fat, Carbohydrates, Sugar, Number of servings, and Protein must be numeric.");
				$("#submit_add_food").unbind("click");
				$("#submit_add_food").bind("click", function(){
						$("submit_add_food_notify").html("Please fix errors before continuing submission.");
					});
			}else
			{
				if($("#calories_field").val() != ((($("#protein_field").val())*4)+(($("#carbohydrates_field").val())*4)+(($("#fat_field").val())*9)))
				{
					$("#results").html("Warning: Calories do not match Fat, Protein and Carbohydrate Values!<br> Calories(" + $("#calories_field").val() + ") does not equal the sum of Fat(" + $("#fat_field").val()*9 + "), Carbohydrates(" + $("#carbohydrates_field").val()*4 + "), and Protein(" + $("#protein_field").val()*4 + ")");
					$("#submit_add_food").unbind("click");
					$("#submit_add_food").bind("click", function(){
						$("submit_add_food_notify").html("Please fix errors before continuing submission.");
					});
				}else
				{
					$("#submit_add_food").on("click", add_food_submit());
				}
			}			
		}
	});
	$("#serving_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#serving_field").on("change", function(){
		serv_changed = true;
	});
	$("#unit_field").on("click", function(){
		$(this).val("");
		$(this).css("color", "black");
	});
	
	
}











function add_food_submit()
{
	var desc = $("#food_name").val();
	var cals = $("#calories_field").val();
	var fats = $("#fat_field").val();
	var carbs = $("#carbohydrates_field").val();
	var sugars = $("#sugars_field").val();
	var protein = $("#protein_field").val();
	var amount = $("#serving_field").val();
	var serving = $("#unit_field").val();
	var d_set = false;
	var c_set = false;
	var f_set = false;
	var car_set = false;
	var s_set = false;
	var p_set = false;
	var serv_set = false;
	var unit_set = false;
	$("#results").html("");
	$("#results").css("color", "black");
	if(desc === "Name of Food" || desc.length === 0)
	{
		$("#food_name").css("color","red");
		$("#food_name").val("Required Field");
		$("#food_name").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#food_name").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else
	{
		d_set = true;
	}
	if(cals === "Calories" || cals.length === 0 || cals < 0)
	{
		$("#calories_field").css("color","red");
		$("#calories_field").val("Required Field");
		$("#calories_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#calories_field").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else
	{
		c_set = true;
	}
	if(fats === "Fat in grams" || fats.length === 0 || fats < 0)
	{
		$("#fat_field").css("color","red");
		$("#fat_field").val("Required Field");
		$("#fat_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#fat_field").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else
	{
		f_set = true;
	}
	if(carbs === "Carbohydrates in grams" || carbs.length === 0 || carbs < 0)
	{
		$("#carbohydrates_field").css("color","red");
		$("#carbohydrates_field").val("Required Field");
		$("#carbohydrates_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#carbohydrates_field").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else
	{
		car_set = true;
	}
	if(sugars === "Sugar in grams" || sugars.length === 0 || sugars < 0)
	{
		$("#sugars_field").css("color","red");
		$("#sugars_field").val("Required Field");
		$("#sugars_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#sugars_field").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else
	{
		s_set = true;
	}
	if(protein === "Protein in grams" || protein.length === 0 || protein < 0)
	{
		$("#protein_field").css("color","red");
		$("#protein_field").val("Required Field");
		$("#protein_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#protein_field").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else
	{
		p_set = true;
	}
	if(amount === "# of Servings" || amount.length === 0)
	{
		$("#serving_field").css("color","red");
		$("#serving_field").val("Required Field");
		$("#serving_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#serving_field").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else if(amount <= 0)
	{
		$("#serving_field").css("color","red");
		$("#serving_field").val("# must be > 0");
		$("#serving_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#serving_field").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else
	{
		serv_set = true;
	}
	if(serving === "Serving(Cup, tbsp, etc.)" || amount.length === 0)
	{
		$("#unit_field").css("color","red");
		$("#unit_field").val("Required Field");
		$("#unit_field").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
		$("#unit_field").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
		});
	}else
	{
		unit_set = true;
	}
	if(d_set && c_set && f_set && car_set && s_set && p_set && serv_set && unit_set)
	{
			$.ajax({
				method: 'get',
				url: '../PHP/add_food.php',
				data: {
					'description' : desc,
					'calories' : cals,
					'fat' : fats,
					'carbs' : carbs,
					'sugars' : sugars,
					'protein' : protein, 
					'amount' : amount,
					'serving' : serving
				},
				success: function(data){
					if(data)
					{
						$("#results").html("");
						cookie_login_attempt();
						info(data, 1);
					}else
					{
						$("#results").html("Failed to insert food.");
					}
				}
			});
	}
}

function set_on_clicks()
{
	$("#username_login").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#username_login").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#password_login").on("click", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#password_login").on("focus", function(){
			$(this).val("");
			$(this).css("color", "black");
	});
	$("#search_field").on("click", function(){
			if($(this).val() === "Search for Food")
			{
				$(this).val("");
			}
			$(this).css("color", "black");
	});
	$("#search_field").focus(function(){
		if($(this).val() === "Search for Food")
		{
			$(this).val("");
		}
			$(this).css("color", "black");
	});
}

