<!DOCTYPE html>
<head>
  <meta charset="UTF-8"/>
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="http://classes.engineering.wustl.edu/cse330/content/calendar.js"></script>
</head>


<body>
  <div class="layer0">
    <div class="logins">
     <button class="btns" id="login" data-tog="0">Log In</button>
     <button class="btns" id="createUser" data-tog="0">Create User</button>
   </div>
   <div class="logouts">
    <div id="loggedUser" data-tog="0"></div>
    <button class="btns" id="logout">Log Out</button>
  </div>
  <div class="userLoginDetails">
    <div>
      <form id="userlogin" action="#">
        <br> Please Input the details for login: <br>
        Username <input type="text"  name="username" id="username">  <br>
        Password <input type="password"  name="password" id="password">  <br>
        <input id="submitLogin" type="button" name="submit" value="Login"/>
      </form>
      <div id="loginUserMsg"></div> 
    </div>
<!--     <input type="hidden" id="hdnSession" data-value="@Request.RequestContext.HttpContext.Session['token']" />
+ --> 
  </div>
  <div class="userCreateDetails">
    <div>
      <form id="userCreate">
        <br> Please Input the details for registering: <br>
        Username <input type="text"  name="newUsername" id="newUsername">  <br>
        Password <input type="password"  name="newPassword" id="newPassword">  <br>
        <input id="submitCreateUser" type="button" name="submit" value="Create User"/>
      </form>
      <div id="userCreateMsg"></div> 
    </div>
  </div>
  <div class="eventDisplay">
    <div class="eventInfo" id="eventInfo">
    </div>
    <div class="eventModifier">
      <button class="btns" id="deleteEvent" data-tog="0">Delete Event</button>
      <button class="btns" id="alterEvent" data-tog="0">Alter Event</button>
    </div>
  </div>
  <div class="editEvent">
    <form id="eventAlter">

      New Title<input type="text"  name="editTitle" id="editTitle">  <br>
      New Time<input type="time"  name="eventTime" id="editTime"> <br>
      New Description <br>
      <textarea rows="4" cols="50" name="desc" id="editDesc" placeholder="Enter New Description Here.."></textarea>  <br>
      <input id="editEvent" type="button" name="submit" value="Edit Event"/>
    </form>
    <div id="editEventMsg"></div>
  </div>
  <div class="eventInfoMsg">
  </div>
  <div class="layer1">
    <div class="date" id="date">

    </div>
    <div class="calendar">
      <div class="nexts">
        <button class="btns" id="prev">Prev Month</button>
        <button class="rbtns" id="next">Next Month</button>
      </div>
      <div class="cal" id="cal" data-tog=""></div>
    </div>
    <div class="addEvents">
      <button class="btns" id="createEvent" data-tog="0">Create Event</button>
      <button class="btns" id="shareCalendar" data-tog="0">Share My Cal</button>
    </div>
    <div class="eventCreateDetails">
      <div>
        <form id="newEvent">
          <br> Please Input the details of event (Required Feilds in *): <br>
          Title* <input type="text"  name="eventTitle" id="eventTitle">  <br>
          Day* <input type="date"  name="eventDate" id="eventDate"> <br>
          Time* <input type="time"  name="eventTime" id="eventTime"> <br>
          <textarea rows="4" cols="50" name="desc" id="desc" placeholder="Enter Description Here.."></textarea>  <br>
          Invite others? <input class="text" id="invitees" placeholder="username1, username2, ..."><br><br>
          <input id="submitNewEvent" type="button" name="submit" value="Create Event"/>
        </form>
        <div id="addEventMsg"></div> 
      </div>
    </div>
    <div class="shareDetails">
      <div>
        <form id="newShare">
          <br> Please input the details for sharing your calendar: <br>
          Share With <input class="text" id="shareWith" placeholder="username1, username2, ..."><br><br>
          <input id="submitShare" type="button" name="submit" value="Share"/>
        </form>
        <div id="shareMsg"></div> 
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var toMonth;
var usrname;
var globalMonth;
var monthList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var evt;
var something;
var date;
var time;
//var token;

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
$.ajax({type:'POST', url: 'fetchEvents_ajax.php', data: pdata, dataType: 'json', success: function(response) { 
 for (var i = 0; i < response.length; ++i) 
 {
   var resp = response[i];
   if (usrname == resp.host){
    $("#"+resp.day).append('<li class="event" data-eventID="'+resp.eventID+'" data-time="'+resp.time+'" data-desc="'+resp.desc+'">'+resp.title+'</li>');
  }
  else{
   $("#"+resp.day).append('<li class="invitedEvent" data-eventID="'+resp.eventID+'" data-time="'+resp.time+'" data-host="'+resp.host+'" data-owner="'+resp.owner+'" data-desc="'+resp.desc+'">'+resp.title+'</li>');
 }
}
}});
}
document.getElementById("cal").innerHTML = str;
document.getElementById("date").innerHTML = monthList[curMonth] + ", " + curYear;
}

function firstload(){
  var curDate = new Date();
  var curMonth = curDate.getMonth();
  var curYear = curDate.getFullYear();
  var thisMonth= new Month(curYear,curMonth);
  toMonth = thisMonth;
  $( document ).ready(load);
}

function backMonth(){
  toMonth=globalMonth.prevMonth();
  $( document ).ready(load);
}

function forwardMonth(){
  toMonth=globalMonth.nextMonth();
  $( document ).ready(load);
}


document.addEventListener("DOMContentLoaded", firstload, false);
$("#next").click( forwardMonth);
$("#prev").click( backMonth);

function toggleState(item){
 if($(item).attr("data-tog") == "0") {
   $(item).attr("data-tog","1");
 } 
 else {
   $(item).attr("data-tog", "0");
 }
}

$(document).on('click', ".event", function(event){
  $("#eventInfoMsg").empty();
  something=this;
  var evt = $(this).parent().attr('id');
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


$(document).on('click', ".invitedEvent", function(event){
  $("#eventInfoMsg").empty();
  something=this;
  var evt = $(this).parent().attr('id');
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

$("#logout").click( function(){
 $.ajax({type:'POST', url: 'logout_ajax.php', dataType: 'json', success: function(response) {
   if(response.success){
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
     $("#loginUserMsg").empty();
     $("#loginUserMsg").append('<div class="successText">Login Success!!</div>');
     $("#loggedUser").attr("data-tog","1");
     setTimeout(function() {
       $(".userLoginDetails").fadeOut(300);
       $(".logins").hide();
       $(".logouts").show();
       $(".addEvents").show();
       $("#loginUserMsg").empty();
       $("#userlogin")[0].reset();
       $("#loggedUser").append('<div>Hello '+usrname+'!</div>');
     },1000); 
     toggleState($("#login"));
     firstload();
//     var sessToken = "<?php echo $_SESSION['token'];?>";
  //   console.log(sessToken);
     $("#hdnSession").attr("data-value",sessToken);
   }
   else{
     $("#loginUserMsg").empty();
     $("#loginUserMsg").append('<div class="failText">'+response.message+'</div>');
   }
 }
});
});


$("#submitNewEvent").click( function(){
 var title = $("#eventTitle").val();
 var date = $("#eventDate").val();
 console.log(date);
 var time = $("#eventTime").val();
 var desc = $("#desc").val();
 var group = $("#invitees").val();
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

$("#deleteEvent").click( function(){
  var eventID= $(something).attr("data-eventID");
//  var token= $("#hdnSession").attr("data-value");
  var pdata = {
   eventID : eventID
   //token : token
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

$("#editEvent").click( function(){
  var eventID= $(something).attr("data-eventID");
  var title = $("#editTitle").val();
  var time = $("#editTime").val();
  var desc = $("#editDesc").val();
  var pdata = {
   eventID : eventID,
   title : title,
   time : time,
   description : desc
 };
 $.ajax({type:'POST', url: 'editEvent_ajax.php', data: pdata, dataType: 'json', success: function(response) {
   if(response.success){ 
     $("#eventInfo").empty();
     $("#eventInfoMsg").append('<div class="successText">Event Edited!</div>');
     $(".eventDisplay").hide();
     $(".editEvent").hide();
     toggleState($(".eventDisplay"));
     toggleState($(".editEvent"));
     load();
   }
   else{
     $("#eventInfoMsg").empty();
     $("#eventInfoMsg").append('<div class="failText">Edit Failed</div>');
   }
 }
});
});

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



</script>
</body>
</html>
