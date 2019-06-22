<?php
  session_start();   
  if (isset($_POST['csrf_request']))
  {

$myfile = fopen("Tokens.txt", "r") or die("Unable to open file!");
list($tok,$sid) = explode(",",chop(fgets($myfile)),2); // chop() is a must because fgets() returns new line character
fclose($myfile);

if($sid == $_COOKIE['sessionCookie']){
echo $tok;
}
  
  }  
?>