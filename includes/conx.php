<?php

     $connx = mysqli_connect('localhost','root','','timesheetapp');

     if(mysqli_connect_errno())
     {
       echo mysqli_connect_error();
       exit();
     }

?>
