<?php
    include('Cofig_Connection/mysqli_connection.php');
    include('include/function.php');
    $error = null;
    $rsult='';
    $query='';
    if(isset($_POST['registration'])){
	$usernamesignup = $_POST['usernamesignup'];
	$emailsignup = $_POST['emailsignup'];
	$passwordsignup = $_POST['passwordsignup'];
	$passwordsignup_confirm = $_POST['passwordsignup_confirm'];
	$First_Name=$_POST['First_Name'];
	$Last_Name=$_POST['Last_Name'];
	$address=$_POST['address'];
	$telphone=$_POST['phoneNumber'];
	
	$checkuser=selectSql($con, "SELECT COUNT(*) FROM users WHERE username = '$usernamesignup'");
	$check= mysqli_fetch_row($checkuser);
	$rowuser=$check[0];
	$checkemail=selectSql($con, "SELECT COUNT(*) FROM users WHERE email = '$emailsignup'");
	$checkmail= mysqli_fetch_row($checkemail);
	$rowmail=$checkmail[0];
	
	if($rowuser=='1'){
	    //check username if exist
	    $error = 'Username is already exist! <br><br>';
	} 
	
	if($rowmail=='1'){
	    //check Email if exist
	    $error .= 'Email is already exist! <br><br>';
	}
	
	if($passwordsignup!=$passwordsignup_confirm){
	    //check password if match
	    $error .= 'Password is not match!';
	}

	    // insert into database 
	$sql=  selectSql($con,"INSERT INTO `users`(name,surname, `username`, `password`, `email`,address,tel) "
		. "VALUES ('$First_Name','$Last_Name','$usernamesignup','$passwordsignup','$emailsignup','$address','$telphone') ");
	$rsult='Registration is succeful.';
	
	
    }
    
	
//    $sql = "INSERT INTO `users`(`name`, `surname`, `username`, `password`, `email`, `address`, `tel`, `ac_type`, `user_status`) "
//	    . "VALUES ('name','surname','username','password','email','address','tel','ac_type','1')";	
//    if(executeSql($con, $sql)){
//	echo 'Success';
//    }else{
//	echo 'Fail';
//    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
	<div id="header">	    	   		
	    <div id="wrapper" >
		<div id="login" class="animate form">    
                            <form  action="" autocomplete="on" method="post"> 
                                <h1> Sign up </h1> 
				
				<p> 
                                    <label for="username" class="uname" data-icon="u"> First Name </label>
                                    <input id="username" name="First_Name" required="required" type="text" placeholder="eg. X8df!90EO" value="<?php if (!empty($error)) echo $usernamesignup; ?>"/>
                                </p>
				<p> 
                                    <label for="username" class="uname" data-icon="u"> Last Name </label>
                                    <input id="username" name="Last_Name" required="required" type="text" placeholder="eg. X8df!90EO" value="<?php if (!empty($error)) echo $usernamesignup; ?>"/>
                                </p>
				
				<p> 
                                    <label for="username" class="uname" data-icon="u"> Your User Name </label>
                                    <input id="username" name="usernamesignup" required="required" type="text" placeholder="eg. X8df!90EO"  value="<?php if (!empty($error)) echo $usernamesignup; ?>" />
                                </p>
				
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p"> Your Password</label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="mysuperusername690" />
                                </p>
				
				<p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p"> Your Comfirm Password</label>
                                    <input id="passwordsignup" name="passwordsignup_confirm" required="required" type="password" placeholder="mysuperusername690"  />
                                </p>
				
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mysupermail@mail.com" value="<?php if (!empty($error)) echo $emailsignup; ?>"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="e">Your address </label>
                                    <input id="passwordsignup" name="address" required="required" type="text" placeholder="eg. sokat , khan , city..." value="<?php if (!empty($error)) echo $usernamesignup; ?>"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="e">Your Phone Number  </label>
                                    <input id="passwordsignup_confirm" name="phoneNumber" required="required" type="text" placeholder="eg. 023888819 / 098 230102" value="<?php if (!empty($error)) echo $usernamesignup; ?>"/>
                                </p>
				
				
				<?php 
				   
				if (!empty($error)){
					echo '<span style="color:red;">'.$error.'</span>';
				} else {
				    echo '<span style="color:blue;">'.$rsult.'</span>';
				}
					
				 
				?>
                                <p class="signin button"> 
				    <input type="submit" value="Sign up" name="registration"/> 
				 </p>
                                <p class="change_link">  
					    Already a member ?
					    <a href="index.php" class="to_register"> Go and log in </a>
				</p>
                            </form>			    
		</div>
	    </div>
	</div>		
    </body>
</html>
