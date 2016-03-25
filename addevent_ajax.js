function loginAjax(event){
	var day = document.getElementById("day").value; 
	var month = document.getElementById("month").value;
	var year = document.getElementById("year").value;
	var grouped = document.getElementById("grouped").value;
	var groups = document.getElementById("groups").value;
	var groupsArr= groups.split(',');
	var groups = JSON.stringify(groupsArr);
	var title = document.getElementById("title").value; 
	var description = document.getElementById("description").value; 
	var hour = document.getElementById("hour").value; 
	var minute = document.getElementById("minute").value; 
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "day=" + encodeURIComponent(day) + "&month=" + encodeURIComponent(month) + "&year=" + encodeURIComponent(year) + "&grouped=" + encodeURIComponent(grouped) + "&groups=" + encodeURIComponent(groups) + "&title=" + encodeURIComponent(title) + "&description=" + encodeURIComponent(description) + "&hour=" + encodeURIComponent(hour) + "&minute=" + encodeURIComponent(minute);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "addevent_ajax.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've added an event!");
		}else{
			alert("You failed to add an event.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
 
$(function(){document.getElementById("submitEvent").addEventListener("click", loginAjax, false);}
) // Bind the AJAX call to button click