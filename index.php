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
  <div id="username">Hello</div>
  <button class="btns" id="logout">Log Out</button>
</div>
<div class="userLoginDetails">
  <div>
    <form id="userlogin" action="#">
      <br> Please Input the details for login: </br><br></br>
      Username <input type="text"  name="username" id="username">  <br>
      Password <input type="password"  name="password" id="password">  <br><br></br>
      <input id="submitLogin" type="submit" name="submit" value="Create User"/>
    </form>
  </div>
</div>
<div class="userCreateDetails">
  <div>
    <form id="userCreate" action="#">
      <br> Please Input the details for registering: </br><br></br>
      Username <input type="text"  name="newUsername" id="newUsername">  <br>
      Password <input type="password"  name="newPassword" id="newPassword">  <br><br></br>
      <input id="submitCreateUser" type="submit" name="submit" value="Create User"/>
    </form>
  </div>
</div>
<div class="layer1">
  <div class="date">Today is 
    
  </div>
  <div class="calendar">
  </div>
  <div class="addEvent">
      <button class="btns" id="createEvent">Create Event</button>
      <button class="btns" id="shareCalendar">Share My Cal</button>
  </div>
  <div class="eventCreateDetails">
    <div>
    <form id="newEvent" action="#">
      <br> Please Input the details of event: </br><br></br>
      Title <input type="text"  name="eventTitle">  <br>
      Day <input type="date"  name="eventDate"> <br>
      Time <input type="time"  name="eventTime"> <br>
      <textarea rows="4" cols="50" name="comment" placeholder="Enter Description Here.."></textarea>  <br>
      <button class="btns" id="inviteOthers">Invite others</button><br><br></br>
      <input id="submitNewEvent" type="submit" name="submit" value="Create Event"/>
    </form>
    </div>
  </div>
  <div class="shareDetails">
    <div>
    <form id="newShare" action="#">
      <br> Please input the details for sharing your calendar: </br><br></br>
      Share With: <input type="text"  name="shareWith">  <br>
      <button class="btns" id="addMore">Add more</button><br><br></br>
      <input id="submitShare" type="submit" name="submit" value="Share"/>
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
 $.ajax({type:'POST', url: 'createuser_ajax.php', data: pdata}).done( function(response) {
 alert("success");
 });
});
</script>
</body>
</html>

