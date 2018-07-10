<?php
session_start();

$_SESSION = array();

if(isset($_COOKIE["id"]) || isset($_COOKIE["uname"]))
{
  setcookie("id",'',strtotime('-5 days'),'/');
  setcookie("uname",'',strtotime('-5 days'),'/');
}
session_unset();
session_destroy();
if(isset($_SESSION['ulogin']) || isset($_SESSION['uid']) )
{
  header("location: index.php");
}
else {
  header("location: index.php");
}
 ?>
