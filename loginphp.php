
<?php
include ("Cofig_Connection/mysqli_connection.php");
$error = null;
error_reporting(0);
	if ($_POST['login']){
	    if($_POST['username'] && $_POST['password']){
		$username= mysqli_real_escape_string($con,$_POST['username']);
		$password= mysqli_real_escape_string($con,$_POST['password']);
		$sql = "SELECT * FROM tblUser where UserLogin='$username' and UserPassword='$password'";
		$user=  mysqli_fetch_array(mysqli_query($con,$sql));
		if($user==null){
		    $error = '<span style="color:red;">Username and Password are incorrect! </br><br>Please Try Again!</span> <br>';
		}else{
		    header('Location: index.php');
		}
	    }	 
	}		
?>
<html>
    <head>
        <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/styles.css" />
	<link rel="stylesheet" type="text/css" href="cssTab/demo.css" />
        <link rel="stylesheet" type="text/css" href="cssTab/style2.css" />
	<link rel="stylesheet" type="text/css" href="css/login.css" />
	  <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
        <title>Register</title>
    </head>
    <body>

	  <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="index.php" autocomplete="on" method="post" > 
                                <h1>Log in</h1> 
				    <p> 
					<label for="username" class="uname" data-icon="u" > Your username </label>
					<input id="username" name="username" required="required" type="text" placeholder="myusername or mymail@mail.com" />
				     </p>
				     <p> 
					<label for="password" class="youpasswd" data-icon="p"> Your password </label>
					<input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
				     </p>
				     <?php 
					if($error!=null){
					    echo $error;
					}
				     ?>
				     <p class="login button"> 
					 <input type="submit" value="Login" name="login" /> 
				    </p>
				    <p class="change_link">
					Not a member yet ?
					<a href="register.php" class="to_register">Join us</a>
				    </p>
                            </form>
                        </div>
	    </div>
	
	
</body>
</html>