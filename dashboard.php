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
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>@twitter</td>
            <td><input type="submit" value="Save"/></td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>@twitter</td>
            <td><input type="submit" value="Save"/></td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>@twitter</td>
            <td><input type="submit" value="Save"/></td>
          </tr>

         </tbody>
       </table>
    </div>
  </div>
</body>
<script>


var oldColor, oldText, padTop, padBottom= "";

function endEdit(input) {
	var td = input.parentNode;
	td.removeChild(td.firstChild);	//remove input
	td.innerHTML = input.value;
	if (oldText != input.value.trim() )
		td.style.color = "red";

	// td.style.paddingTop = padTop;
	// td.style.paddingBottom = padBottom;
	// td.style.backgroundColor = oldColor;
}

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

function makeEditableDrop(ev)
{
  if(this.childNodes[0] && this.childNodes[0].tagName && this.childNodes[0].tagName=="SELECT")
  {
    return;
  }

  oldText= this.innerHTML.trim();

  var input = document.createElement("SELECT");
	input.value = oldText;
  input.className ="";
  this.innerHTML="";
  this.insertBefore(input,this.childNodes[0]);
  input.onblur = function () { endEdit(this); };
  input.select();
}

window.onload = function(){
 var tds = document.getElementsByTagName("td");
 var y=0;
 for(var x=0; x<tds.length; x++)
 {
   if(y!=7)
   {
     if(y==1)
     {
       tds[x].addEventListener("click", makeEditableDrop);
     }
     else if(y==2 || y==3 || y==4 || y==5){

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
 console.log(tds);
 }
</script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<style>
  td,th {
    width:152px!important;
    padding-left:0px!important;
    padding-right:0px!important;
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
</html>
