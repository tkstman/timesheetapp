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

  //GET THE USER'S INFORMATION
  while ($row = mysqli_fetch_array($user_query,MYSQLI_ASSOC))
  {

  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <style>
    td,th {
      width:152px!important;
      padding-left:0px!important;
      /* padding-right:0px!important; */
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
  </style>
  <script>

  var jsobject=0;
  var oldColor, oldText,oldValue, padTop, oldDate, oldEndTime,oldStartTime,padBottom= "";


  function checkUpdateTotalTime(source,sourceParent)
  {
    var tDay = new Date();
    console.log(sourceParent.innerHTML.trim());
    //console.log(sourceParent.nextSibling.nextSibling.innerHTML.trim());
    // if(sourceParent.innerHTML.trim() !=="")
    // {
      if(source.name=="end_time" && sourceParent.innerHTML.trim()!=="" && sourceParent.previousSibling.previousSibling.innerHTML.trim() !=="")
      {
        console.log("get the value of the start time");
        var starttemp = sourceParent.previousSibling.previousSibling.innerHTML.trim();   //THE OTHER TABLE CELL'S VALUE
        var s = new Date(tDay.toDateString() +" " + starttemp); //THE OTHER TABLE CELL'S VALUE AS DATE
        var ec = new Date(tDay.toDateString() +" " + sourceParent.innerHTML.trim());  //THE CURRENT TABLE CELL'S VALUE

        if(s=="Invalid Date" || ec=="Invalid Date")
        {
          alert("Invalid Date Range");
          return;
        }
        console.log(sourceParent.nextSibling.nextSibling.innerHTML.trim());

        var sh =s.getHours();
        var sm =s.getMinutes();
        var ech =ec.getHours();
        var ecm =ec.getMinutes();
        var resultHour = ech-sh;
        var resultMins = ecm-sm;
        console.log("Hours sh "+ (sh));
        console.log("Hours ech "+ (ech));
        console.log("Hours "+ (ech-sh));
        sourceParent.nextSibling.nextSibling.innerHTML=resultHour+" hours "+ resultMins+" mins";
        //check if value is in correct date format
      }
      else if(source.name=="start_time" && sourceParent.innerHTML.trim()!==""  && sourceParent.nextSibling.nextSibling.innerHTML.trim() !=="")
      {
        console.log("get the value of the end time");
        var endtemp = sourceParent.nextSibling.nextSibling.innerHTML.trim();
        var ec = new Date(tDay.toDateString() +" " + endtemp); //THE OTHER TABLE CELL'S VALUE AS DATE
        var s = new Date(tDay.toDateString() +" " + sourceParent.innerHTML.trim());  //THE CURRENT TABLE CELL'S VALUE Start Time

        if(s=="Invalid Date" || ec=="Invalid Date")
        {
          alert("Invalid Date Range");
          return;
        }
        console.log(sourceParent.nextSibling.nextSibling.innerHTML.trim());

        var sh =s.getHours();
        var sm =s.getMinutes();
        var ech =ec.getHours();
        var ecm =ec.getMinutes();
        var resultHour = ech-sh;
        var resultMins = ecm-sm;
        console.log("Hours sh "+ (sh));
        console.log("Hours ech "+ (ech));
        console.log("Hours "+ (ech-sh));
        sourceParent.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML=resultHour+" hours "+ resultMins+" mins";
        console.log(endtemp);
        //check if value is in correct date format
      }

      //t = tDay.toDateString() +" " + source.value;
      //console.log(sourceParent.innerHTML.trim());

    // }
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
  MAKE TABLE CELL INTO EDITABLE DATE INPUT ELEMENTS
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
  MAKE TABLE CELL INTO EDITABLE DATE INPUT ELEMENTS
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

    xmlhttp.onreadystatechange = function()
    {
      if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
      {
        if(xmlhttp.responseText.trim() == "_failed")
        {
          alert(xmlhttp.responseText.trim());
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
       }
       else if(y==2){
         tds[x].addEventListener("click", makeEditableDateInput);
       }
       else if(y==3 ){
          tds[x].addEventListener("click", makeEditableStartTimeInput);
       }
       else if(y==4 ){
          tds[x].addEventListener("click", makeEditableEndTimeInput);
       }
       else if (y==5){

       }
       else {
         tds[x].addEventListener("click", makeEditableInput);
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
              $sqlTask = "select * from task";
            //

            if($task_user_query = $connx->query($sqlTask))
            {
              $task_num_rows = $task_user_query->num_rows;

              if($task_num_rows <1)
              {

              }
              else
              {
                $task_rows = array();
                while ($task_row = $task_user_query->fetch_assoc()) {
                  $task_rows[] = $task_row;
                }
                echo json_encode($task_rows);
                mysqli_close($connx);
                exit();
              }

              echo '<tr>
                <th scope="row">1</th>
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
          ?>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td data-value="2">Otto</td>
            <td >2014-09-02</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>@twitter</td>
            <td><input type="submit" class"save-btn" value="Save"/></td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td data-value="2">Thornton</td>
            <td>2014-09-02</td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>@twitter</td>
            <td><input type="submit" class"save-btn" value="Save"/></td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td data-value="2">the Bird</td>
            <td>2014-09-02</td>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>@twitter</td>
            <td><input type="submit" class"save-btn" value="Save"/></td>
          </tr>

         </tbody>
       </table>
    </div>
  </div>
</body>


</html>
