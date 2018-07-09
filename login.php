<?php

if(isset($_SESSION['username']))
header('location: dashboard.php?u='.$_SESSION['username']);


$username ='';
$password ='';
//Retrieve Login Variables
if(isset($_POST['username']) && isset($_POST['password']))
{
  include_once("includes/conx.php");
  $username = mysqli_real_escape_string($conx,trim($_POST['username']));
  $password = md5($_POST['password']);




  if($username =="" || $password=="")
  {
    echo "login_failed";
  }
  echo "We Got Here";
}

//Sanitize Login Variables


?>
