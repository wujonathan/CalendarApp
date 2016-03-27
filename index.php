<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="http://classes.engineering.wustl.edu/cse330/content/calendar.js"></script>
</head>


<body>
  <div class="layer0">
    <div class="logins">
     <button class="btns" id="login" data="0">Log In</button>
     <button class="btns" id="createUser" data="0">Create User</button>
   </div>
   <div class="logouts">
    <div id="loggedUser"></div>
    <button class="btns" id="logout">Log Out</button>
  </div>
  <div class="userLoginDetails">
    <div>
      <form id="userlogin" action="#">
        <br> Please Input the details for login: </br><br></br>
        Username <input type="text"  name="username" id="username">  <br>
        Password <input type="password"  name="password" id="password">  <br><br></br>
        <input id="submitLogin" type="button" name="submit" value="Login"/>
      </form>
      <div id="loginUserMsg"></div> 
    </div>
  </div>
  <div class="userCreateDetails">
    <div>
      <form id="userCreate">
        <br> Please Input the details for registering: </br><br></br>
        Username <input type="text"  name="newUsername" id="newUsername">  <br>
        Password <input type="password"  name="newPassword" id="newPassword">  <br><br></br>
        <input id="submitCreateUser" type="button" name="submit" value="Create User"/>
      </form>
      <div id="userCreateMsg"></div> 
    </div>
  </div>
  <div class="layer1">
    <div class="date" id="date">

    </div>
    <div class="calendar">
      <div class="nexts">
        <button class="btns" id="prev">Prev Month</button>
        <button class="rbtns" id="next">Next Month</button>
      </div>
      <div class="cal" id="cal"></div>
    </div>
    <div class="addEvents">
      <button class="btns" id="createEvent" data="0">Create Event</button>
      <button class="btns" id="shareCalendar" data="0">Share My Cal</button>
    </div>
    <div class="eventCreateDetails">
      <div>
        <form id="newEvent">
          <br> Please Input the details of event (Required Feilds in *): </br><br></br>
          Title* <input type="text"  name="eventTitle" id="eventTitle">  <br>
          Day* <input type="date"  name="eventDate" id="eventDate"> <br>
          Time* <input type="time"  name="eventTime" id="eventTime"> <br>
          <textarea rows="4" cols="50" name="desc" id="desc" placeholder="Enter Description Here.."></textarea>  <br>
          Invite others? <input class="text" id="invitees" placeholder="username1, username2, ..."><br><br></br>
          <input id="submitNewEvent" type="button" name="submit" value="Create Event"/>
        </form>
        <div id="addEventMsg"></div> 
      </div>
    </div>
    <div class="shareDetails">
      <div>
        <form id="newShare">
          <br> Please input the details for sharing your calendar: </br><br></br>
            Share With <input class="text" name="shareWith" id="shareWith" placeholder="username1, username2, ..."><br><br></br>
          <input id="submitShare" type="button" name="submit" value="Share"/>
        </form>
        <div id="shareMsg"></div> 
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
var globalMonth={};
var monthList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
function firstload(){
  var curDate = new Date();
  var curMonth = curDate.getMonth();
  var curYear = curDate.getFullYear();
  var thisMonth= new Month(curYear,curMonth);
  globalMonth.mon=thisMonth;
  var weeksinMonth=thisMonth.getWeeks();
  var str="";
  str=str.concat("<table align='center' border=1 cellpadding=2> <tr> <th class='cell'>Sun <th class='cell'>Mon <th class='cell'>Tue <th class='cell'>Wed <th class='cell'>Thu <th class='cell'>Fri <th class='cell'>Sat</tr>");
  for(var i=0;i<weeksinMonth.length;i++){
    str=str.concat("<tr>");
    var daysinWeek= weeksinMonth[i].getDates();
    for(var j=0;j<7;j++){
      var theDay= daysinWeek[j].getDate();
      var theMonth= daysinWeek[j].getMonth();
      if (theMonth == curMonth){
        str=str.concat("<td class='cell'>".concat(theDay));
      }
      else{
         str=str.concat("<td class='oldcell'>".concat(theDay));
      }
   }
    str=str.concat("</tr>");
  }
  str=str.concat("</table>");
  document.getElementById("cal").innerHTML = str;
  document.getElementById("date").innerHTML = monthList[curMonth] + ", " + curYear;
}
function backMonth(){
  var toMonth=globalMonth.mon.prevMonth();
  var curMonth = toMonth.month;
  var curYear = toMonth.year;
  globalMonth.mon=toMonth;
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
        str=str.concat("<td class='cell'>".concat(theDay));
      }
      else{
         str=str.concat("<td class='oldcell'>".concat(theDay));
      }
    }
    str=str.concat("</tr>");
  }
  str=str.concat("</table>");
  document.getElementById("cal").innerHTML = str;
  document.getElementById("date").innerHTML = monthList[curMonth]+ ", " + curYear;
}

function forwardMonth(){
  var toMonth=globalMonth.mon.nextMonth();
  var curMonth = toMonth.month;
  var curYear = toMonth.year;
  globalMonth.mon=toMonth;
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
        str=str.concat("<td class='cell'>".concat(theDay));
      }
      else{
         str=str.concat("<td class='oldcell'>".concat(theDay));
      }
    }
    str=str.concat("</tr>");
  }
  str=str.concat("</table>");
  document.getElementById("cal").innerHTML = str;
  document.getElementById("date").innerHTML = monthList[curMonth] + ", " + curYear;
}

document.addEventListener("DOMContentLoaded", firstload, false);
$("#next").click( forwardMonth);
$("#prev").click( backMonth);

function toggleState(item){
 if($(item).attr("data") == "0") {
   $(item).attr("data","1");
 } 
 else {
   $(item).attr("data", "0");
 }
}


$("#login").click( function(){
 var neighbor = $("#createUser");
 if ($(neighbor).attr("data") == "1"){
    $(".userCreateDetails").hide();
    toggleState(neighbor);
 }
 if ($(this).attr("data") == "0"){
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
}}
});
});

$("#createUser").click( function(){
 var neighbor = $("#login");
 if ($(neighbor).attr("data") == "1"){
    $(".userLoginDetails").hide();
    toggleState(neighbor);
 }
 if ($(this).attr("data") == "0"){
     $(".userCreateDetails").show();
 }
 else{
     $(".userCreateDetails").hide();
 }
 toggleState(this);
});

$("#shareCalendar").click( function(){
 var neighbor = $("#createEvent");
 if ($(neighbor).attr("data") == "1"){
  $(".eventCreateDetails").hide();
    toggleState(neighbor);
 }
 if ($(this).attr("data") == "0"){
      $(".shareDetails").show();
 }
 else{
      $(".shareDetails").hide();
 }
 toggleState(this);
});

$("#createEvent").click( function(){
 var neighbor = $("#shareCalendar");
 if ($(neighbor).attr("data") == "1"){
    $(".shareDetails").hide();
    toggleState(neighbor);
 }
 if ($(this).attr("data") == "0"){
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
 if (newusrname == "" || newusrpass == ""){
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
   }
   else{
     $("#userCreateMsg").empty();
     $("#userCreateMsg").append('<div class="failText">'+response.message+'</div>');
   }
 }
})
});

$("#submitLogin").click( function(){
 var usrname = $("#username").val();
 var usrpass = $("#password").val();
 var pdata = {
   username : usrname,
   password : usrpass
 };
  if (usrname == "" || usrpass == ""){
     $("#loginUserMsg").empty();
     $("#loginUserMsg").append('<div class="failText">Invalid Username or Password</div>');
     return;
 }
 $.ajax({type:'POST', url: 'login_ajax.php', data: pdata, dataType: 'json', success: function(response) {
   if(response.success){ 
     $("#loginUserMsg").empty();
     $("#loginUserMsg").append('<div class="successText">Login Success!!</div>');
     setTimeout(function() {
     $(".userLoginDetails").fadeOut(300);
     $(".logins").hide();
     $(".logouts").show();
     $(".addEvents").show();
     $("#loginUserMsg").empty();
     $("#userlogin")[0].reset();
     $("#loggedUser").append('<div>Hello '+usrname+'!</div>');
     },1000); 
   }
   else{
     $("#loginUserMsg").empty();
     $("#loginUserMsg").append('<div class="failText">'+response.message+'</div>');
   }
 }
})
});


$("#submitNewEvent").click( function(){
 var title = $("#eventTitle").val();
 var date= $("#eventDate").val()
 var time = $("#eventTime").val();
 var desc = $("#desc").val();
 var group = $("#invitees").val();
 if (title == "" || date == "" || time == ""){
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
   }
   else{
     $("#addEventMsg").empty();
     $("#addEventMsg").append('<div class="failText">'+response.message+'</div>');
   }
 }
})
});


$("#submitShare").click( function(){
 var shareTo = $("#shareWith").val();
 if (shareTo == ""){
     $("#shareMsg").empty();
     $("#shareMsg").append('<div class="failText">One or More Required Field is Missing</div>');
     return;
 }
 var pdata = {
   shareTo : shareTo,
 };
 $.ajax({type:'POST', url: 'sharecal_ajax.php', data: pdata, dataType: 
'json', success: function(response) {
   if(response.success){
     $("#shareMsg").empty();
     $("#shareMsg").append('<div class="successText">Calendar Shared!</div>');
     setTimeout(function() {
     $(".shareDetails").fadeOut(300);
     $("#shareMsg").empty();
     $("#newShare")[0].reset();
     },1000); 
   }
   else{
     $("#shareMsg").empty();
     $("#shareMsg").append('<div class="failText">'+response.message+'</div>');
   }
 }
})
});



</script>
</body>
</html>

