/*globals $:false */
var toMonth;
var usrname;
var globalMonth;
var monthList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var evt;
var something;
var date;
var token;

/*function loads the calendar by adding table to the 'cal' object in the center of the page. If user is logged in, the fuction makes ajax request to the fetchEvent_ajax.php to get all events associated (created, shared with or invited) with the user and updates the calendar*/
function load(){
  $("#cal").empty();
  var curMonth = toMonth.month;
  var curYear = toMonth.year;
  globalMonth=toMonth;
  var weeksinMonth=toMonth.getWeeks();
  var str="";
  str=str.concat("<table align='center' border=1 cellpadding=2> <tr> <th class='cell'>Sun <th class='cell'>Mon <th class='cell'>Tue <th class='cell'>Wed <th class='cell'>Thu <th class='cell'>Fri <th class='cell'>Sat</tr>");
  for(var i=0;i<weeksinMonth.length;i++){
   str=str.concat("<tr>");
   var daysinWeek= weeksinMonth[i].getDates();
   for(var j=0;j<7;j++){
     var theDay= daysinWeek[j].getDate();
     var theMonth= daysinWeek[j].getMonth();
     if (theMonth == curMonth){
      var preDivElem = "<td class='cell' id='";
      var postDivElem = "'>";       
      var newDivElem = preDivElem+theDay.toString()+postDivElem;
      str=str.concat(newDivElem.concat(theDay));
    }
    else{
      str=str.concat("<td class='oldcell'>".concat(theDay));
    }
  }
  str=str.concat("</tr>");
}
str=str.concat("</table>");
if($("#loggedUser").attr("data-tog") == "1") {
 var pre = "";
 var newCurMonth = parseInt(curMonth)+1;
 if (curMonth < 10){
  pre = "0";    
}
var queryMonth = curYear+"-"+pre+newCurMonth.toString();
var pdata = {
  queryMonth : queryMonth
};
/*Using jquery ajax call. filtering json data using inbuilt type:'json' method so that no parse in needed*/
$.ajax({type:'POST', url: 'fetchEvents_ajax.php', data: pdata, dataType: 'json', success: function(response) { 
 for (var i = 0; i < response.length; ++i) 
 {
   var resp = response[i];
   if (usrname == resp.host){
    $("#"+resp.day).append('<li class="event '+resp.eventTag+'" data-eventID="'+resp.eventID+'" data-time="'+resp.time+'" data-desc="'+resp.desc+'">'+resp.title+'</li>');
  }
  else{
   $("#"+resp.day).append('<li class="invitedEvent '+resp.eventTag+'" data-eventID="'+resp.eventID+'" data-time="'+resp.time+'" data-host="'+resp.host+'" data-owner="'+resp.owner+'" data-desc="'+resp.desc+'">'+resp.title+'</li>');
 }
}
}});
}
document.getElementById("cal").innerHTML = str;
document.getElementById("date").innerHTML = monthList[curMonth] + ", " + curYear;
}

/*function loads the calendar with current month. Default on document load*/
function firstload(){
  var curDate = new Date();
  var curMonth = curDate.getMonth();
  var curYear = curDate.getFullYear();
  var thisMonth= new Month(curYear,curMonth);
  toMonth = thisMonth;
  $( document ).ready(load);
}

/*function loads the previous month. called by event handler when clicked 'Prev Month' button*/
function backMonth(){
  toMonth=globalMonth.prevMonth();
  $( document ).ready(load);
}

/*function loads the next month. called by event handler when clicked 'Next Month' button*/
function forwardMonth(){
  toMonth=globalMonth.nextMonth();
  $( document ).ready(load);
}


document.addEventListener("DOMContentLoaded", firstload, false);
$("#next").click( forwardMonth);
$("#prev").click( backMonth);

/*Toggles value of "data-tog" from 1 to 0 and reverse. Used for example,When one clicks the button 'Log In' users can view the 'login info' section below the button. This function toggles the state of the button so that a next click on the 'Log In' button collapses the login info section*/
function toggleState(item){
 if($(item).attr("data-tog") == "0") {
   $(item).attr("data-tog","1");
 } 
 else {
   $(item).attr("data-tog", "0");
 }
}

/*Loads the 'event info' section on the top left corner of the page when users click on individual self created events (green) in their calendar*/
$(document).on('click', ".event", function(event){
  $("#eventInfoMsg").empty();
  something=this;
  evt = $(this).parent().attr('id');
  date = $("#date").text();
  var time24 = $(this).attr("data-time").split(":");
  var hour24 = parseInt(time24[0]);
  var hour = ((hour24 + 11) % 12) + 1;
  var amPm = hour24 > 11 ? "pm" : "am";
  var time = hour.toString() + ":" + time24[1] + amPm; 
  var str = "<div>Event Title: " +  $(this).text() + "<br> Scheduled for: " + evt.toString() + " " +date +"<br> Time: " + time + "<br> Description: " + $(this).attr("data-desc")+"</div>";    
  document.getElementById("eventInfo").innerHTML = str;
  $(".eventDisplay").show();
});

/*Loads the 'event info' section on the top left corner of the page when users click on individual invited/shared events (blue) in their calendar*/
$(document).on('click', ".invitedEvent", function(event){
  $("#eventInfoMsg").empty();
  something=this;
  evt = $(this).parent().attr('id');
  date = $("#date").text();
  var time24 = $(this).attr("data-time").split(":");
  var hour24 = parseInt(time24[0]);
  var hour = ((hour24 + 11) % 12) + 1;
  var amPm = hour24 > 11 ? "pm" : "am";
  var time = hour.toString() + ":" + time24[1] + amPm;   
  var str = "<div>" + $(this).attr("data-owner") + "'s calendar.<br> Event Title: " +  $(this).text() + "<br> Scheduled for: " + evt.toString() + " " +date +"<br> Time: " + time + "<br> Description: " + $(this).attr("data-desc")  + "<br> Event Host: " +  $(this).attr("data-host")+"</div>";
  document.getElementById("eventInfo").innerHTML = str;
  $(".eventDisplay").show();
});

$("#alterEvent").click( function(){
  if ($(this).attr("data-tog") == "0"){
    $(".editEvent").show();
  }
  else{
    $(".editEvent").hide();
  }
  toggleState(this);
});

/*event handler for 'Log In' button. Opens up 'login info' section right below the button*/
$("#login").click( function(){
 var neighbor = $("#createUser");
 if ($(neighbor).attr("data-tog") == "1"){
  $(".userCreateDetails").hide();
  toggleState(neighbor);
}
if ($(this).attr("data-tog") == "0"){
  $(".userLoginDetails").show();
}
else{
  $(".userLoginDetails").hide();
}
toggleState(this);
});

/*'Log Out' button event handler. Makes ajax call to 'logout_ajax.php'*/
$("#logout").click( function(){
 $.ajax({type:'POST', url: 'logout_ajax.php', dataType: 'json', success: function(response) {
   if(response.success){
    $(".myTags").hide();
    $(".viewAll").hide();
    $(".logouts").delay(1000).hide();
    $(".logins").delay(1000).show();
    $(".addEvents").delay(1000).hide();
    $(".eventDisplay").delay(1000).hide();
    $(".editEvent").delay(1000).hide();
    $("#loggedUser").empty();
    $("#loggedUser").attr("data-tog","0");
    firstload();
  }}
});
});

/*event handler for 'Create User' button. Opens up 'new user info' section right below the button*/
$("#createUser").click( function(){
 var neighbor = $("#login");
 if ($(neighbor).attr("data-tog") == "1"){
  $(".userLoginDetails").hide();
  toggleState(neighbor);
}
if ($(this).attr("data-tog") == "0"){
 $(".userCreateDetails").show();
}
else{
 $(".userCreateDetails").hide();
}
toggleState(this);
});

/*event handler for 'Share My Cal' button. Opens up 'sharee info' section right below the button*/
$("#shareCalendar").click( function(){
 var neighbor = $("#createEvent");
 if ($(neighbor).attr("data-tog") == "1"){
  $(".eventCreateDetails").hide();
  toggleState(neighbor);
}
if ($(this).attr("data-tog") == "0"){
  $(".shareDetails").show();
}
else{
  $(".shareDetails").hide();
}
toggleState(this);
});

/*event handlers for event's tag (radio) button*/
$("#tagWork").click( function(){
  $(".event").hide();
  $(".invitedEvent").hide();
  $(".work").show();
  $(".school").hide();
  $(".personal").hide();
});

$("#tagSchool").click( function(){
  $(".event").hide();
  $(".invitedEvent").hide();
  $(".work").hide();
  $(".school").show();
  $(".personal").hide();
});

$("#tagPersonal").click( function(){
  $(".event").hide();
  $(".invitedEvent").hide();
  $(".work").hide();
  $(".school").hide();
  $(".personal").show();
});

$("#tagDisable").click( function(){
  $(".event").show();
  $(".invitedEvent").show();
});

/*event handler for 'Create Event' button. Opens up 'event info' section right below the button*/
$("#createEvent").click( function(){
 var neighbor = $("#shareCalendar");
 if ($(neighbor).attr("data-tog") == "1"){
  $(".shareDetails").hide();
  toggleState(neighbor);
}
if ($(this).attr("data-tog") == "0"){
 $(".eventCreateDetails").show();
}
else{
 $(".eventCreateDetails").hide();
}
toggleState(this);
});

/*event handler for 'New User Info's submit' button. Makes ajax call if non-empty input fields is provided. If successful user creation, hides the notifies 'success' and hides 'New User Info' section. If failed, notifies 'fail' state*/ 
$("#submitCreateUser").click( function(){
 var newusrname = $("#newUsername").val();
 var newusrpass = $("#newPassword").val();
 if (newusrname === "" || newusrpass === ""){
   $("#userCreateMsg").empty();
   $("#userCreateMsg").append('<div class="failText">Invalid Username or Password</div>');
   return;
 }
 var pdata = {
   newUsername : newusrname,
   newPassword : newusrpass
 };
 $.ajax({type:'POST', url: 'createuser_ajax.php', data: pdata, dataType: 'json', success: function(response) {
   if(response.success){ 
     $("#userCreateMsg").empty();
     $("#userCreateMsg").append('<div class="successText">Success!!</div>');
     setTimeout(function() {
       $(".userCreateDetails").fadeOut(300);
       $("#userCreateMsg").empty();
       $("#userCreate")[0].reset();
     },1000);
     toggleState($("#createUser"));
     firstload();
   }
   else{
     $("#userCreateMsg").empty();
     $("#userCreateMsg").append('<div class="failText">'+response.message+'</div>');
   }
 }
});
});

/*event handler for  'Login Info's submit' button. Makes ajax call if non-empty input fields is provided. If successful user login, hides the notifies 'success' and hides 'Login Info' section. If failed, notifies 'fail' state*/ 
$("#submitLogin").click( function(){
 usrname = $("#username").val();
 var usrpass = $("#password").val();
 var pdata = {
   username : usrname,
   password : usrpass
 };
 if (usrname === "" || usrpass === ""){
   $("#loginUserMsg").empty();
   $("#loginUserMsg").append('<div class="failText">Invalid Username or Password</div>');
   return;
 }
 $.ajax({type:'POST', url: 'login_ajax.php', data: pdata, dataType: 'json', success: function(response) {
   if(response.success){ 
    token=response.token;
     $("#loginUserMsg").empty();
     $("#loginUserMsg").append('<div class="successText">Login Success!!</div>');
     $("#loggedUser").attr("data-tog","1");
     setTimeout(function() {
       $(".userLoginDetails").fadeOut(300);
       $(".logins").hide();
       $(".logouts").show();
       $(".addEvents").show();
       $(".myTags").show();
       $(".viewAll").show();
       $("#loginUserMsg").empty();
       $("#userlogin")[0].reset();
       $("#loggedUser").append('<div>Hello '+usrname+'!</div>');
     },1000); 
     toggleState($("#login"));
     firstload();
   }
   else{
     $("#loginUserMsg").empty();
     $("#loginUserMsg").append('<div class="failText">'+response.message+'</div>');
   }
 }
});
});

/*event handler for 'Event Info's submit' button. Makes ajax call if non-empty input fields is provided. If successful event creation, hides the notifies 'success' and hides 'Event Info' section. If failed, notifies 'fail' state*/ 
$("#submitNewEvent").click( function(){
 var title = $("#eventTitle").val();
 var date = $("#eventDate").val();
 console.log(date);
 var time = $("#eventTime").val();
 var desc = $("#desc").val();
 var group = $("#invitees").val();
 var tag;
 var tags=document.getElementsByName("tags");
 console.log(tags[0].value);
 for(var i=0; i<tags.length;i++){
  if(tags[i].checked){
    tag=tags[i].value;
    break;
  }
}
if (title === "" || date === "" || time === ""){
 $("#addEventMsg").empty();
 $("#addEventMsg").append('<div class="failText">One or More Required Field is Missing</div>');
 return;
}
var pdata = {
 title : title,
 date : date,
 time : time,
 description : desc,
 groups : group,
 tag: tag
};
$.ajax({type:'POST', url: 'addevent_ajax.php', data: pdata, dataType: 'json', success: function(response) {
 if(response.success){ 
   $("#addEventMsg").empty();
   $("#addEventMsg").append('<div class="successText">Event Created!</div>');
   setTimeout(function() {
     $(".eventCreateDetails").fadeOut(300);
     $("#addEventMsg").empty();
     $("#newEvent")[0].reset();
   },1000); 
   toggleState($("#createEvent"));
   load();
 }
 else{
   $("#addEventMsg").empty();
   $("#addEventMsg").append('<div class="failText">'+response.message+'</div>');
 }
}
});
});

/*event handler for 'Delete Event' button. Makes ajax call to delete the event from the database*/
$("#deleteEvent").click( function(){
  var eventID= $(something).attr("data-eventID");
var pdata = {
 eventID : eventID,
   token : token
 };
 $.ajax({type:'POST', url: 'deleteEvent_ajax.php', data: pdata, dataType: 'json', success: function(response) {
   if(response.success){ 
     $("#eventInfo").empty();
     $("#eventInfoMsg").append('<div class="successText">Delete Success!!</div>');
     $(".eventDisplay").hide();
     $(".editEvent").hide();
     toggleState($(".eventDisplay"));
     toggleState($(".editEvent"));
     load();
   }
   else{
     $("#eventInfoMsg").empty();
     $("#eventInfoMsg").append('<div class="failText">Delete Failed</div>');
   }
 }
});
});

/*event handler for 'Delete Event' button. Opens up 'Edit info' sectionand  makes ajax call to edit the event from the database*/
$("#editEvent").click( function(){
  var eventID= $(something).attr("data-eventID");
  var title = $("#editTitle").val();
  var time = $("#editTime").val();
  var desc = $("#editDesc").val();
  var pdata = {
   eventID : eventID,
   title : title,
   time : time,
   description : desc,
   token : token
 };
 $.ajax({type:'POST', url: 'editEvent_ajax.php', data: pdata, dataType: 'json', success: function(response) {
   if(response.success){ 
     $("#eventInfo").empty();
     $("#eventInfoMsg").append('<div class="successText">Event Edited!</div>');
     $(".eventDisplay").hide();
     $(".editEvent").hide();
     $("#eventAlter")[0].reset();
     load();
   }
   else{
     $("#eventInfoMsg").empty();
     $("#eventInfoMsg").append('<div class="failText">Edit Failed</div>');
   }
 }
});
});

/*event handler for 'Sharee Info's submit' button. Makes ajax call if non-empty input fields is provided. If successful calendar share, hides the notifies 'success' and hides 'Sharee Info' section. If failed, notifies 'fail' state*/ 
$("#submitShare").click( function(){
 var shareTo = $("#shareWith").val();
 if (shareTo === ""){
   $("#shareMsg").empty();
   $("#shareMsg").append('<div class="failText">One or More Required Field is Missing</div>');
   return;
 }
 var pdata = {
   shareTo : shareTo
 };
 $.ajax({type:'POST', url: 'sharecal_ajax.php', data: pdata, dataType: 
  'json', success: function(response) {
   var allSuccess = 1;
   $("#shareMsg").empty();
   for (var i = 0; i < response.length; ++i)
   {
     var resp = response[i];
     if(resp.success){
      $("#shareMsg").append('<div class="successText">Calendar Shared with '+resp.user+'</div>'); 
    }
    else{
      allSuccess = 0;
      $("#shareMsg").append('<div class="failText">'+resp.message+' with '+resp.user+'</div>');
    }
  }
  if (allSuccess){
    setTimeout(function() {
     $(".shareDetails").fadeOut(300);
     $("#shareMsg").empty();
     $("#newShare")[0].reset();
   },1000);
    toggleState($("#shareCalendar"));
  }
}});
});

