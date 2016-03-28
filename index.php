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
    <div class="myTags">
      <button class="btns" id="tagWork">View Work</button>
      <button class="btns" id="tagSchool">View School</button>
      <button class="btns" id="tagPersonal">View Personal</button>
    </div>
    <div class="viewAll">
      <button class="btns" id="tagDisable">View All</button>
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
        Tag <br>
        <div class="tags" id="tags">
          <input type="radio" name="tags" value="work" id="work"> Work<br>
          <input type="radio" name="tags" value="school" id="school"> School<br>
          <input type="radio" name="tags" value="personal" id="personal"> Personal<br>
        </div>
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
<script type="text/javascript" src="calendar.js"></script>
</body>
</html>
