<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
</head>


<body>
<div class="layer0">
<div class="logins">
     <button class="btns" id="login">Log In</button>
     <button class="btns" id="createUser">Create User</button>
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
  </div>
</div>
<div class="layer1">
  <div class="date">Today is 
    
  </div>
  <div class="calendar">
  </div>
  <div class="addEvents">
      <button class="btns" id="createEvent">Create Event</button>
      <button class="btns" id="shareCalendar">Share My Cal</button>
  </div>
  <div class="eventCreateDetails">
    <div>
    <form id="newEvent">
      <br> Please Input the details of event: </br><br></br>
      Title <input type="text"  name="eventTitle" id="eventTitle">  <br>
      Day <input type="date"  name="eventDate" id="eventDate"> <br>
      Time <input type="time"  name="eventTime" id="eventTime"> <br>
      <textarea rows="4" cols="50" name="desc" id="desc" placeholder="Enter Description Here.."></textarea>  <br>
      Invite others? <input class="text" id="invitees" placeholder="username1, username2, ..."><br><br></br>
      <input id="submitNewEvent" type="button" name="submit" value="Create Event"/>
    </form>
    </div>
  </div>
  <div class="shareDetails">
    <div>
    <form id="newShare">
      <br> Please input the details for sharing your calendar: </br><br></br>
      Share With: <input type="text"  name="shareWith">  <br>
      <button class="btns" id="addMore">Add more</button><br><br></br>
      <input id="submitShare" type="button" name="submit" value="Share"/>
    </form>
    </div>
  </div>
</div>
</div>
</div>
<script>
 $("#login").click( function(){
 $(".userLoginDetails").show();
});
  $("#createUser").click( function(){
 $(".userCreateDetails").show();
});
 $("#createUser").click( function(){
 $(".userCreateDetails").show();
});
  $("#shareCalendar").click( function(){
 $(".shareDetails").show();
});
  $("#createEvent").click( function(){
 $(".eventCreateDetails").show();
});
$("#submitCreateUser").click( function(){
 var newusrname = $("#newUsername").val();
 var newusrpass = $("#newPassword").val();
 var pdata = {
 newUsername : newusrname,
 newPassword : newusrpass
 };
 $.ajax({type:'POST', url: 'createuser_ajax.php', data: pdata, dataType: 'json', success: function(response) {
 if(response.success){ 
 $(".userCreateDetails").append('<div class="successText">Success!!</div>');
 $(".userCreateDetails").delay(1000).fadeOut(300);
 }
 else{
 $(".userCreateDetails").append('<div class="failText">'+response.message+'</div>');
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
 $.ajax({type:'POST', url: 'login_ajax.php', data: pdata, dataType: 'json', success: function(response) {
 if(response.success){ 
 $(".userLoginDetails").append('<div class="successText">Login Success!!</div>');
 $(".userLoginDetails").delay(1000).fadeOut(300);
 $(".logins").delay(1000).hide();
 $(".logouts").delay(1000).show();
 $(".addEvents").delay(1000).show();
 $("#loggedUser").append('<div>Hello '+usrname+'!</div>');
 }
 else{
 $(".userLoginDetails").append('<div class="failText">'+response.message+'</div>');
 }
 }
 })
 });


 $("#submitNewEvent").click( function(){
 var title = $("#eventTitle").val();
 var date = $("#eventDate").val();
 var time = $("#eventTime").val();
 var desc = $("#desc").val();
 var group = $("#invitees").val();
 var grouped = "no";
 if (group){
 grouped = "yes";
 }
 console.log(group);
 var pdata = {
 title : title,
 date : date,
 time : time,
 description : desc,
 groups : group,
 grouped : grouped
 };
 $.ajax({type:'POST', url: 'addevent_ajax.php', data: pdata, dataType: 'json', success: function(response) {
 if(response.success){ 
 $(".eventCreateDetails").append('<div class="successText">Login Success!!</div>');
 $(".eventCreateDetails").delay(1000).fadeOut(300);
 }
 else{
 $(".eventCreateDetails").append('<div class="failText">'+response.message+'</div>');
 }
 }
 })
 });

</script>
</body>
</html>

