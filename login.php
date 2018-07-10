<?php
session_start();
if(isset($_SESSION['login']))
{
  header('location: dashboard.php?u='.$_SESSION['login']);
}


$username ='';
$password ='';
//Retrieve Login Variables
if(isset($_POST['username']) && isset($_POST['password']))
{
  include_once("includes/conx.php");
  $username = mysqli_real_escape_string($connx,trim($_POST['username']));
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM EMPLOYEE WHERE user_name=(?) and pword=(?)";
  $stmt = $connx->prepare($sql);
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();


  //PROCESS PREPARED STATEMENT FOR RESULT
  $stmt->store_result();
  $meta = $stmt->result_metadata();

  while ($column = $meta->fetch_field()) {
     $bindVarsArray[] = &$results[$column->name];
  }
  call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);

  $stat=$stmt->fetch();

  if( ($stat!="" && $stat!=NULL) && $results["user_name"] != "")
  {
    $_SESSION["ulogin"] = $results["user_name"];
    $_SESSION["uid"] = $results["id"];
    setcookie("uname",$results["user_name"],strtotime('+30 days'),"/","","",TRUE);
    setcookie("id",$results["id"],strtotime('+30 days'),"/","","",TRUE);
    echo $results["user_name"];
    exit();
  }

  $stmt->close();


  if($username =="" || $password=="" || $stat=="" || $stat==NULL)
  {
    echo "login_failed";
    exit();
  }
}

//Sanitize Login Variables


?>
