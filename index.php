<?php
// Start the session
session_start();
if(isset($_SESSION['ulogin']))
{
  header('location: dashboard.php?u='.$_SESSION['ulogin']);
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
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
	#submitBtn
	{
		margin-top:10px;
	}
	</style>
</head>
<body>
  <div id="container" class="container">
	<div style="margin-top: 20px;">
		<h2>Time Sheet App: Sign in</h2>
	</div>
    <div class="login-container">
      <form id="login_form" method="post" action="login.php" class="form-control">
        <div>
          <p id="error" class="text-danger">

          </p>
        </div>
        <div>
          <label for="username" >Username:</label>
          <input name="username" id="username" type="text" class="form-control">
        </div>
        <div>
          <label for="password">Password:</label>
          <input name="password" id="password" type="password" class="form-control">
        </div>
        <div>
          <input type="submit" id="submitBtn" >
        </div>
      </form>
    </div>
  </div>
  <script>

  /**
    Clear UI Error Indicators
  **/
  function clearErrors(ev)
  {
    var error = document.getElementById("error");
    error.innerText = "";
  }


    /**
    Attempt To Log User In
    **/
    function loginAttempt(ev)
    {
      ev.preventDefault();
      this.disabled = true;
      try{
        //Check username
        //Check password

        var username = document.getElementById("username");
        var password = document.getElementById("password");
        if(username.value.trim()=="" || password.value.trim()=="")
        {
          throw "Please Complete All Fields";
        }

        var rgx = new RegExp("^[^a-zA-Z0-9]+$")
        if(rgx.test(username.value.trim()))
        {
          throw "Invalid Username Format Supplied!";
        }

        /**
        Since No Errors Were Thrown, We Initiate Ajax Request To Server To Validate User
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
            if(xmlhttp.responseText.trim() == "login_failed")
            {
              var error = document.getElementById("error");
              error.innerHTML  = "Failed To Validate User!";
            }
            else {

              //alert(xmlhttp.responseText.trim());

              window.location = "dashboard.php?u="+xmlhttp.responseText.trim();
            }
          }

        }
        xmlhttp.open("post","login.php");
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("username="+username.value.trim()+"&password="+password.value.trim());

      }
      catch(err)
      {
         var error = document.getElementById("error");
         error.innerHTML  = err;

      }
      this.disabled = false;

    };


    window.onload = function()
    {
      var subBtn = document.getElementById("submitBtn");
      subBtn.addEventListener("click",loginAttempt);   //Attach Event Listener To Submit Button

      //var container = document.getElementById("login_form");
      //container.addEventListener("click",clearErrors);  //Attach Event Listener To Container For Clearing Errors
    };
  </script>
</body>
</html>
