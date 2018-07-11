<?php
include_once("checkloginstatus.php");

if(isset($_GET["clients"]))
{

  $getClients = preg_replace('#[^a-z0-9_]#i','',$_GET["clients"]);

  if($getClients =="get_all")
  {
  	 $sql = "select * from client";
  	//

  	if($user_query = $connx->query($sql))
  	{
  	  $num_rows = $user_query->num_rows;

  	  if($num_rows <1)
  	  {
  		echo "No_Res";
  		exit();
  	  }
  	  else
  	  {
  			$rows = array();
  			while ($row = mysqli_fetch_array($user_query)) {
  				$rows[] = $row;
  			}
  			echo json_encode($rows);
  			mysqli_close($connx);
  			exit();
  	  }
  	 }
   }
}

if(isset($_POST["comment"   ])&&
  isset($_POST["total_time"])&&
  isset($_POST["end_time"  ])&&
  isset($_POST["start_time"])&&
  isset($_POST["date"      ])&&
  isset($_POST["client"    ])&&
  isset($_POST["client_val"])&&
  isset($_POST["task"      ])&&
  isset($_POST["status"    ])
)
{
  echo"all were sent";
  exit();
  // $getClients = preg_replace('#[^a-z0-9_]#i','',$_GET["clients"]);
  //
  // if($getClients =="get_all")
  // {
  // 	 $sql = "select * from client";
  // 	//
  //
  // 	if($user_query = $connx->query($sql))
  // 	{
  // 	  $num_rows = $user_query->num_rows;
  //
  // 	  if($num_rows <1)
  // 	  {
  // 		echo "No_Res";
  // 		exit();
  // 	  }
  // 	  else
  // 	  {
  // 			$rows = array();
  // 			while ($row = mysqli_fetch_array($user_query)) {
  // 				$rows[] = $row;
  // 			}
  // 			echo json_encode($rows);
  // 			mysqli_close($connx);
  // 			exit();
  // 	  }
  // 	 }
  //  }
}
?>
