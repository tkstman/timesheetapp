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

function checkForValidTask($cnx, $tsk_id)
{
	$checkersql_tsk = "SELECT id FROM task WHERE id=(?)";
	$tsk_rt="";
        if($statement_ts = $cnx->prepare($checkersql_tsk))
        {

          $statement_ts->bind_param("i",$tsk_id);
          $statement_ts->execute();
          $statement_ts->bind_result($tsk_rt);
          $statement_ts->fetch();

          if($tsk_rt!=0 && $tsk_rt>0 && $tsk_rt!= "")
          {
            return true;
          }
        }
        return false;
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
	
	$comment    = mysqli_real_escape_string($connx,$_POST["comment"   ]);
	$total_time = mysqli_real_escape_string($connx,$_POST["total_time"]);
	$end_time   = mysqli_real_escape_string($connx,$_POST["end_time"  ]);
	$start_time = mysqli_real_escape_string($connx,$_POST["start_time"]);
	$date       = mysqli_real_escape_string($connx,$_POST["date"      ]);
	$client     = mysqli_real_escape_string($connx,$_POST["client"    ]);
	$client_val = mysqli_real_escape_string($connx,$_POST["client_val"]);
	$task       = mysqli_real_escape_string($connx,$_POST["task"      ]);
	$status      =mysqli_real_escape_string($connx,$_POST["status"    ]);
	
	
	$timeFormat = "/^([0-9]{2})\:([0-9]{2})$/";
    $clientFormat = "/^\d+$/";
    $dateFormat = "/^\d{4}\-\d{1,2}\-\d{1,2}$/";
	
	$sqlTasking="";
	$statTask="";

    if($user_id=="" || $comment==""|| $total_time=="" || $end_time=="" || $start_time=="" || $date=="" || $client=="" || $task=="" || $client_val=="")
    {
      echo "Task Values Must Be Entered Before Saving! Please Try Again";
      exit();
    }

    if(preg_match($timeFormat,$end_time) == false || preg_match($timeFormat,$start_time) == false)
    {
        echo"Invalid Time Format! Please Try Again";
        exit();
    }

    if(!preg_match($clientFormat,$client_val))
    {
      echo "Invalid Client Info! Please Reload And Resubmit";
      exit();
    }

    if($status=="new" ||$status=="old")
    {
		if($status=="new")
		{
			$sqlTasking="insert into task (name,client_id,user_id,start_date,start_time,end_time,comments) values (?,?,?,?,?,?,?)";
			$statTask =$connx->prepare($sqlTasking);
			$statTask->bind_param("siissss",$task ,$client_val,$user_id,$date ,$start_time,$end_time ,$comment ); 
		}
		else
		{
			if(isset($_POST["status"    ]))
			{
				$task_id  = mysqli_real_escape_string($connx,$_POST["task_id"    ]);
				if(!checkForValidTask($connx,$task_id))
				{
					echo "Invalid Task Info";
					exit();
				}
				
				
				$sqlTasking="update task set name=?,client_id=?,user_id=?,start_date=?,start_time=?,end_time=?,comments=? where task.id=?";
				$statTask = $connx->prepare($sqlTasking);
				$statTask->bind_param("siissssi",$task ,$client_val,$user_id,$date ,$start_time,$end_time ,$comment,$task_id ); 
			}
		}
    }
    else {
      echo "Invalid Input! Please Resubmit";
      exit();
    }

    if(!preg_match($dateFormat,$date))
    {
      echo "Invalid Date! Please Resubmit";
      exit();
    }
	
	 
	
	if($statTask->execute())
	{
		$statTask->store_result();
		if($statTask->affected_rows >0)
		{
			echo "Successful Entry!";
			exit();
		}
	}
  echo "all were sent";
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
