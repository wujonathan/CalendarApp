<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" href="style.css">
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
      Username <input type="text"  name="username">  <br>
      Password <input type="password"  name="password">  <br><br></br>
      <input id="submitLogin" type="submit" name="submit" value="Create User"/>
    </form>
  </div>
</div>
<div class="userCreateDetails">
  <div>
    <form id="userCreate" action="#">
      <br> Please Input the details for registering: </br><br></br>
      Username <input type="text"  name="newUsername">  <br>
      Password <input type="password"  name="newPassword">  <br><br></br>
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
  </div>
  <div class="eventCreateDetails">
    <div>
    <form id="newEvent" action="#">
      <br> Please Input the details of event: </br><br></br>
      Username <input type="text"  name="username">  <br>
      Password <input type="password"  name="password">  <br><br></br>
      <input id="submitLogin" type="submit" name="submit" value="Create User"/>
    </form>
    </div>
  </div>
</div>
</div>
  <?php  
     require 'database.php';
 $stmt4 = $mysqli->prepare("SELECT news_id, story, local, path, user_id FROM news WHERE day(last_update)=day(NOW()) and month(last_update)=month(NOW()) and year(last_update)=year(NOW()) order by RAND() LIMIT 1");

  if(!$stmt4){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
  }
  $stmt4->execute();
  $stmt4->bind_result($news_id, $text, $local, $path, $user_id);
  $stmt4->fetch();
  printf("<div class='layer2'><div class='label'>Random Story of the Day:</div>\n<ul><div class='holder'><div class='story'>%s</div>\n",$text);
  if ($path != ""){
   printf("<a href=%s> %s </a>\n",$path, $path);
        }
   printf("</div></ul>\n<div><form action='viewStory.php' method='post'><input type='hidden' name='news_id' value='%s'/><input type='submit' class='editComment' name='viewStory' value='Expand'/></form></div></div>\n<div class='layer1'>", $news_id);
  $stmt4->close();

 $array = array();
  $stmt = $mysqli->prepare("SELECT news_id, story, local, path, user_id,last_update FROM news order by last_update DESC");
  if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
  }
  $stmt->execute();
  $stmt->bind_result($news_id, $text, $local, $path, $user_id, $date_story);
  while($stmt->fetch()){
    array_push($array, htmlspecialchars($news_id), htmlspecialchars($user_id), htmlspecialchars($text), htmlspecialchars($path), htmlspecialchars($date_story));
}
$stmt->close();
echo "<ul>\n";
    $arr_length = count($array);
    for($i=0;$i<$arr_length;$i+=5)
{
    $news_id2 = $array[$i];	  
    $user_id2 = $array[$i+1];	  
    $text2 = $array[$i+2];	  
    $path2 = $array[$i+3];	   
    $date_story2 = $array[$i+4];	   
    $stmt2 = $mysqli->prepare("SELECT username FROM registered_users WHERE id=?");
    $stmt2->bind_param('i', $user_id2);
    $stmt2->execute();
    $stmt2->bind_result($author);
    $stmt2->fetch();
    $stmt2->close();
    if ($path2 != ""){
    printf("<div class='holder'><div class='story'>%s</div>\n<a href=%s> %s </a>\n<div class='author'>Published by %s on %s</div>\n<div class='label'>Comments:</div><ul>\n",$text2,$path2,$path2,$author, $date_story2);
    }
    else{
    printf("<div class='holder'><div class='story'>%s</div>\n<div class='author'>Published by %s on %s</div>\n<div class='label'>Comments:</div><ul>\n",$text2,$author, $date_story2);
    }
    $comments_array = array();
    $stmt3 = $mysqli->prepare("SELECT comments_id, comment, user_id FROM comments WHERE news_id=?");	      
    $stmt3->bind_param('i', $news_id2);
    $stmt3->execute();
    $stmt3->bind_result($comments_id, $comment, $commenter_id); 
    while($stmt3->fetch()){
	  array_push($comments_array, htmlspecialchars($comment), htmlspecialchars($commenter_id));
      }
      $stmt3->close();		    
      $arr_length2 = count($comments_array);
    for($j=0;$j<$arr_length2;$j+=2)
    {
    $stmt4 = $mysqli->prepare("SELECT username FROM registered_users WHERE id=?");
    $stmt4->bind_param('i', $comments_array[$j+1]);
    $stmt4->execute();
    $stmt4->bind_result($commenter);
    $stmt4->fetch();
    $stmt4->close();
    printf("<div class='comment'><div class='story'>%s</div><div class='author'>Comment by %s</div></div>\n", $comments_array[$j],$commenter);
    }
    echo "</ul></div>\n";
}	    
  echo "</ul>\n";  

   ?>
</div>

</body>
</html>

