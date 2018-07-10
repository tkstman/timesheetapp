<?php
    //Starts session
    session_start();
    include_once("conx.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $user_id ="";
    $user_stats = FALSE;
    $user_name ="";


   //Read your session (if it is set)

    function evalLoggedUser($connx, $id, $u)
    {

        $checkersql = "SELECT id FROM employee WHERE id=(?) AND user_name=(?) AND active=1 ";

        if($statement = $connx->prepare($checkersql))
        {

          $statement->bind_param("is",$id,$u);
          $statement->execute();
          $statement->bind_result($user_id);
          $statement->fetch();

          if($user_id!=0 && $user_id>0 && $user_id== $id)
          {
            return true;
          }
        }
        return false;
    }

   if (isset($_SESSION['uid']) && isset($_SESSION['ulogin']) )
   {
      $user_id= preg_replace('#[^0-9]#','',$_SESSION['uid']);
      $user_name= preg_replace('#[^a-z0-9]#i','',$_SESSION['ulogin']);

      $user_stats = evalLoggedUser($connx, $user_id, $user_name);

      if($user_stats != TRUE)
      {
          header("location: ../logout.php");
      }
   }
   else if( isset($_COOKIE["id"]) && isset($_COOKIE["uname"] ) )
   {
       $_SESSION['uid'] = preg_replace('#[^0-9]#','',$_COOKIE["id"]);
       $_SESSION['ulogin'] = preg_replace('#[^a-z0-9]#i','',$_COOKIE["uname"]);
       $user_id = $_SESSION['uid'];
       $user_name = $_SESSION['ulogin'];
       //header('location: index.php');
       $user_stats = evalLoggedUser($connx, $user_id, $user_name);

       if($user_stats != TRUE)
       {
           header("location: ../logout.php");
       }
   }


?>
