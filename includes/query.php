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
?>