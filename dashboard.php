<?php
include_once("includes/checkloginstatus.php");

$u="";
$isOwner="no";
if(isset($_GET["u"]))
{
  $u = preg_replace('#[^a-z0-9]#i','',$_GET["u"]);
}
else {
  header("location: index.php");
  exit();
}
$u=mysqli_real_escape_string($connx,trim($u));
$sql = "select * from employee where user_name='$u' AND active=1 LIMIT 1";
//
if($user_query = $connx->query($sql))
{

  $num_rows = $user_query->num_rows;
  if($num_rows <1)
  {
    header("location: logout.php");
  }

  if($u == $user_name && $user_stats==true)
  {
    $isOwner ="yes";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  
  <style>
    td,th {
      width:152px!important;
      /* padding-left:0px!important; */
      /* padding-right:0px!important; */
    }
	
	.editable
	{
		background-color: rgba(150, 150, 150, 0.19);
	}

    .myselect-control
    {
      display: block;
      font-size: 1rem;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: .25rem;
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;

    }
	#navbarSupportedContent
	{
		display: block!important;
	}
	.navbar-nav.navbar-right
	{
		float: right!important;
		position: relative!important;
	}
	.bg-light 
	{
		background-color: #346ba2!important;
	}
	.login-container
	{
		margin-top:10px;
	}
  </style>
  <script>

  var jsobject=0;
  var oldColor, oldText,oldValue, padTop, oldDate, oldEndTime,oldStartTime,padBottom= "";


  function checkUpdateTotalTime(source,sourceParent)
  {
    var tDay = new Date();
    //console.log(sourceParent.innerHTML.trim());
    //console.log(sourceParent.nextSibling.nextSibling.innerHTML.trim());
    // if(sourceParent.innerHTML.trim() !=="")
    // {
      if(source.name=="end_time" && sourceParent.innerHTML.trim()!=="" && sourceParent.previousSibling.previousSibling.innerHTML.trim() !=="")
      {
        console.log("get the value of the start time");
        var starttemp = sourceParent.previousSibling.previousSibling.innerHTML.trim();   //THE OTHER TABLE CELL'S VALUE
        var s = new Date(tDay.toDateString() +" " + starttemp); //THE OTHER TABLE CELL'S VALUE AS DATE
        var ec = new Date(tDay.toDateString() +" " + sourceParent.innerHTML.trim());  //THE CURRENT TABLE CELL'S VALUE

        if(s=="Invalid Date" || ec=="Invalid Date" || s>ec)
        {
          alert("Invalid Date Range");
		  sourceParent.innerHTML="";
		  sourceParent.nextSibling.nextSibling.innerHTML="";
          return;
        }
        //console.log(sourceParent.nextSibling.nextSibling.innerHTML.trim());

        var sh =s.getHours();
        var sm =s.getMinutes();
        var ech =ec.getHours();
        var ecm =ec.getMinutes();
		
		var resultHour = ech-sh;		
		var resultMins = "";
		if(ecm-sm>=0)
		{
			console.log(ecm-sm);
			resultMins=ecm-sm;
		}
		else{
			resultMins=60+(ecm-sm);
			resultHour=resultHour-1;
		}
        

        // console.log("Hours sh "+ (sh));
        // console.log("Hours ech "+ (ech));
        // console.log("Hours "+ (ech-sh));
        sourceParent.nextSibling.nextSibling.innerHTML=resultHour+" Hrs "+ resultMins+" Mins";
        //check if value is in correct date format
      }
      else if(source.name=="start_time" && sourceParent.innerHTML.trim()!==""  && sourceParent.nextSibling.nextSibling.innerHTML.trim() !=="")
      {
        var endtemp = sourceParent.nextSibling.nextSibling.innerHTML.trim();
        var ec = new Date(tDay.toDateString() +" " + endtemp); //THE OTHER TABLE CELL'S VALUE AS DATE
        var s = new Date(tDay.toDateString() +" " + sourceParent.innerHTML.trim());  //THE CURRENT TABLE CELL'S VALUE Start Time

        if(s=="Invalid Date" || ec=="Invalid Date" || s>ec)
        {
          alert("Invalid Date Range");
		  sourceParent.innerHTML="";
		  sourceParent.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML="";
          return;
        }
        //console.log(sourceParent.nextSibling.nextSibling.innerHTML.trim());

        var sh =s.getHours();
        var sm =s.getMinutes();
        var ech =ec.getHours();
        var ecm =ec.getMinutes();
        var resultHour = ech-sh;
        var resultMins = ecm-sm;
        // console.log("Hours sh "+ (sh));
        // console.log("Hours ech "+ (ech));
        // console.log("Hours "+ (ech-sh));
        sourceParent.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML=resultHour+" hours "+ resultMins+" mins";
        // console.log(endtemp);
        //check if value is in correct date format
      }

  }

  /*
  DISABLE EDITABLE TEXT INPUT ELEMENTS
  */
  function endEdit(input) {
  	var td = input.parentNode;
  	td.removeChild(td.firstChild);	//remove input
  	td.innerHTML = input.value;
  	if (oldText != input.value.trim() )
  		td.style.color = "red";
  }


  /*
  DISABLE EDITABLE START TIME INPUT ELEMENTS
  */
  function endStartTimeEdit(input) {
  	var td = input.parentNode;
  	td.removeChild(td.firstChild);	//remove input
  	td.innerHTML = input.value;
  	if (oldStartTime != input.value.trim() )
  		td.style.color = "red";

    checkUpdateTotalTime(input,td);
  }

  /*
  DISABLE EDITABLE END TIME INPUT ELEMENTS
  */
  function endEndTimeEdit(input) {
  	var td = input.parentNode;
  	td.removeChild(td.firstChild);	//remove input
  	td.innerHTML = input.value;
  	if (oldEndTime != input.value.trim() )
  		td.style.color = "red";

    checkUpdateTotalTime(input,td);
  }

  /*
  DISABLE EDITABLE DATE INPUT ELEMENTS
  */
  function endDateEdit(input) {
  	var td = input.parentNode;
  	td.removeChild(td.firstChild);	//remove input
  	td.innerHTML = input.value;
  	if (oldDate != input.value.trim() )
  		td.style.color = "red";
  }

  /*
  DISABLE EDITABLE DROPDOWN ELEMENTS
  */
  function endDrop(dropdown) {
  	var td = dropdown.parentNode;
    //console.log(td);
  	td.removeChild(td.firstChild);	//remove input
  	td.innerHTML = dropdown.options[dropdown.selectedIndex].text; //dropdown.value;
    td.setAttribute("data-value",dropdown.options[dropdown.selectedIndex].value);

  	if (oldText != dropdown.options[dropdown.selectedIndex].text.trim() )
  		td.style.color = "red";
  }

  /*
  MAKE TABLE CELL INTO EDITABLE INPUT ELEMENTS
  */
  function makeEditableInput(ev)
  {
    if(this.childNodes[0] && this.childNodes[0].tagName && this.childNodes[0].tagName=="INPUT")
    {
      return;
    }

    oldText= this.innerHTML.trim();

    var input = document.createElement("input");
  	input.value = oldText;
    input.className ="myselect-control";
    this.innerHTML="";
    this.insertBefore(input,this.childNodes[0]);
    input.onblur = function () { endEdit(this); };
    input.select();
    //console.log(this);
  }

  /*
  MAKE TABLE CELL INTO EDITABLE DATE INPUT ELEMENTS
  */
  function makeEditableDateInput(ev)
  {
    if(this.childNodes[0] && this.childNodes[0].tagName && this.childNodes[0].tagName=="INPUT")
    {
      return;
    }

    oldDate= this.innerHTML.trim();

    var input = document.createElement("input");
    input.type = "date";
    input.name = "start_date";
  	input.value = oldDate;
    //input.className ="myselect-control";
    this.innerHTML="";
    this.insertBefore(input,this.childNodes[0]);
    input.onblur = function () { endDateEdit(this); };
    input.select();
    //console.log(this);
  }

  /*
  MAKE TABLE CELL INTO EDITABLE STARTTIME INPUT ELEMENTS
  */
  function makeEditableStartTimeInput(ev)
  {
    if(this.childNodes[0] && this.childNodes[0].tagName && this.childNodes[0].tagName=="INPUT")
    {
      return;
    }

    oldStartTime= this.innerHTML.trim();

    var input = document.createElement("input");
    input.type = "time";
    input.name = "start_time";
  	input.value = oldStartTime;
    //input.className ="myselect-control";
    this.innerHTML="";
    this.insertBefore(input,this.childNodes[0]);
    input.onblur = function () { endStartTimeEdit(this); };
    input.select();
    //console.log(this);
  }

  /*
  MAKE TABLE CELL INTO EDITABLE ENDTIME INPUT ELEMENTS
  */
  function makeEditableEndTimeInput(ev)
  {
    if(this.childNodes[0] && this.childNodes[0].tagName && this.childNodes[0].tagName=="INPUT")
    {
      return;
    }

    oldEndTime= this.innerHTML.trim();

    var input = document.createElement("input");
    input.type = "time";
    input.name = "end_time";
  	input.value = oldEndTime;
    //input.className ="myselect-control";
    this.innerHTML="";
    this.insertBefore(input,this.childNodes[0]);
    input.onblur = function () { endStartTimeEdit(this); };
    input.select();
  }


  /*
  MAKE TABLE CELL INTO EDITABLE DROPDOWN MENU
  */
  function makeEditableDrop(ev)
  {
    if(this.childNodes[0] && this.childNodes[0].tagName && this.childNodes[0].tagName=="SELECT")
    {
      return;
    }

    oldText= this.innerHTML.trim();

    var dropdown = document.createElement("SELECT");
    for(var p=0; p<jsobject.length; p++)
    {
      //console.log(jsobject[p]);
      if(jsobject[p].name!= oldText)
      {
        var option = document.createElement("option");
        option.value =jsobject[p].id;
        option.text = jsobject[p].name;
        dropdown.appendChild(option);
      }
      else {
        oldValue=jsobject[p].id;
      }

    }

    if(jsobject.length>1)
    {
      var option = document.createElement("option");
      option.value =oldValue;//jsobject[p].id;
      option.text = oldText;
      dropdown.insertBefore(option,dropdown.childNodes[0]);
    }

    dropdown.className ="";
    this.innerHTML="";
    this.insertBefore(dropdown,this.childNodes[0]);
    dropdown.onblur = function () { endDrop(this); };
    dropdown.focus();
  }

//Submitting Task Values To Database
  function saveTask(ev)
  {
    //Get The values from the table cells and verify that they are not empty and have correct formats
    var comment    = this.parentNode.previousSibling.previousSibling.innerHTML.trim();
    var total_time = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.innerHTML.trim();
    var end_time   = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.innerHTML.trim();
    var start_time = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.innerHTML.trim();
    var date       = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.innerHTML.trim();
    var client     = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.innerHTML.trim();
	console.log(this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.getAttribute("data-value"));
    var client_val = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.getAttribute("data-value").trim();
    var task       = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.innerHTML.trim();
    var state = this.getAttribute("data-value").trim();
    var timeFormat = /^([0-9]{2})\:([0-9]{2})$/;
    var clientFormat = /^\d+$/;
    var dateFormat = /^\d{4}\-\d{1,2}\-\d{1,2}$/;


    if(comment==""|| total_time=="" || end_time=="" || start_time=="" || date=="" || client=="" || task=="" || client_val=="")
    {
      alert("Task Values Must Be Entered Before Saving! Please Try Again");
      return;
    }

    if(timeFormat.test(end_time) == false || timeFormat.test(start_time) == false)
    {
        alert("Invalid Time Format! Please Try Again");
        return;
    }

    if(!clientFormat.test(client_val))
    {
      alert("Invalid Client Info! Please Reload And Resubmit");
      return;
    }
    var status=""
    if(state=="new" ||state=="old")
    {
      status=state;
    }
    else {
      alert("Invalid Input! Please Resubmit");
      return;
    }

    if(!dateFormat.test(date))
    {
      alert("Invalid Date! Please Resubmit");
      return;
    }

    //SEND NEW VALUES TO DATABASE
    /**
    Since No Errors Were Thrown, We Initiate Ajax Request To Server To Validate User
    **/
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
     } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append( "comment"   ,comment     );
    data.append( "total_time",total_time   );
    data.append( "end_time"  ,end_time     );
    data.append( "start_time",start_time   );
    data.append( "date"      ,date         );
    data.append( "client"    ,client         );
    data.append( "client_val",client_val    );
    data.append( "task"      ,task        );
    data.append( "status"    ,status      );
	if(status=="old")
	{
		var task_id       = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.innerHTML.trim();
		console.log(task_id + " task id");
		if(!clientFormat.test(task_id))
		{
		  alert("Invalid Task Info! Please Reload And Resubmit");
		  return;
		}
		data.append("task_id",task_id);
	}

    xmlhttp.onreadystatechange = function()
    {
      if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
      {
        if(xmlhttp.responseText.trim() == "Successful Entry!")
        {
          alert(xmlhttp.responseText.trim());
		  location.reload();
          // var error = document.getElementById("error");
          // error.innerHTML  = "Failed To Validate User!";
        }
        else {
          alert(xmlhttp.responseText.trim());
          //window.location = "dashboard.php?u="+xmlhttp.responseText.trim();
        }
      }

    }
    xmlhttp.open("post","includes/query.php");
    xmlhttp.send(data);

  }

//ON PAGE LOAD
  window.onload = function(){
   var tds = document.getElementsByTagName("td");
   var y=0;


   /**
  	//Retrieve Clients From Database
  	**/
  	var xmlhttp;
  	if (window.XMLHttpRequest) {
  		xmlhttp = new XMLHttpRequest();
  	 } else {
  		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	}

  	xmlhttp.onreadystatechange = function()
  	{
  	  if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
  	  {
    		if(xmlhttp.responseText.trim() == "No_Res")
    		{
    			//alert("hiyo");
    		  //var error = document.getElementById("error");
    		  //error.innerHTML  = "No Clients Available!";
    		}
    		else {
				//alert(xmlhttp.responseText.trim());
    		  jsobject = JSON.parse(xmlhttp.responseText.trim());
    		}
  	  }

  	}
  	xmlhttp.open("GET","includes/query.php?clients=get_all",true);
  	xmlhttp.send();


  //ASSIGN INITIAL LISTENERS TO TABLE CELLS
   for(var x=0; x<tds.length; x++)
   {
     if(y!=7)
     {
       if(y==1)
       {
         tds[x].addEventListener("click", makeEditableDrop);
		 tds[x].title+="CLICK TO EDIT";
       }
       else if(y==2){
         tds[x].addEventListener("click", makeEditableDateInput);
		 tds[x].title+=" CLICK TO EDIT";
       }
       else if(y==3 ){
          tds[x].addEventListener("click", makeEditableStartTimeInput);
		  tds[x].title+=" CLICK TO EDIT";
       }
       else if(y==4 ){
          tds[x].addEventListener("click", makeEditableEndTimeInput);
		  tds[x].title+=" CLICK TO EDIT";
       }
       else if (y==5){

       }
       else {
         tds[x].addEventListener("click", makeEditableInput);
		 tds[x].title+=" CLICK TO EDIT";
       }

       y++;
     }
     else{
       y=0;
     }
   }

   //ASSIGN INITIAL LISTENERS TO Save Btns
   var savbtns = document.getElementsByClassName("save-btn");
   for(var n=0;n<savbtns.length;n++)
   {
      savbtns[n].addEventListener("click",saveTask);
   }



  }
  </script>
</head>
<body>
  <div id=container>	
    <div>
		<header>
			<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
			  <a class="navbar-brand" href="#" >Time Sheet App</a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav navbar-right">
					<li class="nav-item">
					 <?php 
						if($user_id=="")
						{
							echo '<a class="nav-link" href="index.php">Login<span class="sr-only">(current)</span></a>';
							
						}
						else{
						   echo '<a class="nav-link" href="logout.php">Logout <span class="sr-only"></span></a>';
						}
							   
					  ?>
					  </li> 
				  </ul>
			  </div>
			</nav>
		</header>
    </div>
	
	<div id="user-details">   
	<?php
		$sqlUser = "SELECT employee_manager.`manager_id`, employee.*, job_role.name FROM `employee_manager` INNER JOIN employee ON `employee_manager`.employee_id=employee.id INNER JOIN job_role ON employee.position =job_role.id where employee.id=(?)";
            
            if($user_stamt = $connx->prepare($sqlUser))
            {
				
			    $user_stamt->bind_param("i",$user_id);
			    if($user_stamt->execute())
			    {					
					$user_result= $user_stamt->get_result();
					$man_id="";
					while ($user_row = $user_result->fetch_array()) 
					{
						$man_id=$user_row[0];
						echo '<div class="col-sm-6" style="float: left;">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">'. $user_row[9].'</h5>
										<p class="card-text">'.$user_row[4].' '.$user_row[5].'</p>				
									</div>
								</div>
							</div>'.
							
							'<div class="col-sm-6" style="float: left;">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">ADDRESS</h5>
										<p class="card-text">'.$user_row[7].'</p>				
									</div>
								</div>
							</div>'
							
							;
			  		}
					
					$sqlMang = "Select first_name,last_name from employee where employee.id=(?)";
					if($man_stamt = $connx->prepare($sqlMang))
					{
						$man_stamt->bind_param("i",$man_id);
						if($man_stamt->execute())
						{
							$man_result= $man_stamt->get_result();
							while($man_row = $man_result->fetch_array())
							{
								echo '<div class="col-sm-6" style="float: left;">
										<div class="card">
											<div class="card-body">
												<h5 class="card-title">REPORTING MANAGER</h5>
												<p class="card-text">'.$man_row[0].' '.$man_row[1].'</p>				
											</div>
										</div>
									</div>';
							}
						}
					}
			  		                    
			  	    //echo 'something odd occurred';
			  	    //exit();
			    }
            }
	?>
		
	</div>
	
	
    <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Task</th>
            <th scope="col">Client</th>
            <th scope="col">Date</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">Total Time</th>
            <th scope="col">Comment</th>
          </tr>
        </thead>
        <tbody>
          <?php
		  
            $sqlTask = "SELECT task.*, employee.*, client.* FROM task INNER JOIN employee ON task.user_id=employee.id INNER JOIN client ON task.client_id=client.id where task.user_id=(?)";
            
            if($task_user_stamt = $connx->prepare($sqlTask))
            {
				
			    $task_user_stamt->bind_param("i",$user_id);
			    if($task_user_stamt->execute())
			    {					
					$task_result= $task_user_stamt->get_result();
					
					while ($task_row = $task_result->fetch_array()) {
					$bval = new Datetime($task_row[5]); //start time;
					 $xval=	new Datetime($task_row[6]); //end time;
					   
						echo '<tr>
			  		  <th scope="row">'.$task_row[0].'</th>
			  		  <td>'.$task_row[1].'</td>
			  		  <td data-value='.$task_row[2].'>'.$task_row[17].'</td>
			  		  <td>'.$task_row[4].'</td>
			  		  <td>'.substr($task_row[5],0,5).'</td>
			  		  <td>'.substr($task_row[6],0,5).'</td>
			  		  <td>'.$xval->diff($bval)->format("%h Hrs %i Mins").'</td>
			  		  <td>'.$task_row[7].'</td>
			  		  <td><input type="submit" class="save-btn" data-value="old" value="Save"/></td>
			  	    </tr>';						
			  		}
			  		                    
			  	    echo '<tr>
			  		  <th scope="row">+</th>
			  		  <td></td>
			  		  <td></td>
			  		  <td></td>
			  		  <td></td>
			  		  <td></td>
			  		  <td></td>
			  		  <td></td>
			  		  <td><input type="submit" class="save-btn" data-value="new" value="Save"/></td>
			  	    </tr>';
			  	    exit();
			    }
            }
          ?>
          

         </tbody>
       </table>
    </div>
  </div>
</body>


</html>
