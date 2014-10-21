<?php

 require_once __DIR__ .'/app/sys_const.php';
    require_once __DIR__ .'/common/com.php';
    require_once 'Com_SQL.php';
    $DataRow ='';
   // require_once 'getdata_report.php';
	$CusID = filter_input(INPUT_GET, 'Cusid', FILTER_SANITIZE_STRING);
	$LoadID = filter_input(INPUT_GET, 'loadid', FILTER_SANITIZE_STRING);
	$LoadType = filter_input(INPUT_GET, 'loadtype', FILTER_SANITIZE_STRING);
	//$TableNo=filter_input(INPUT_GET, 'Con', FILTER_SANITIZE_STRING);
	//echo 
	//$sql='';
	//$sql= Getdata_rptSummary($CusID,$LoadID,$LoadType);
	  $sql= getdata_ViewSummary($LoadID,$CusID,$LoadType);
	// $sql.='SELECT * FROM viewSummaryDetail where CusID="'.$CusID.'" AND LoadID="'.$LoadID.'" AND LoadType="'.$LoadType.'" ';
	$result= SQLQuery($sql);
	$RowPos =0;
	
	   for  ($i=0;$i<count($result);$i++) {
		$RowPos = $RowPos + 1;
                $row=$result[$i];
		
		
		$DataRow.='<tr>';
		$DataRow.='<td class="lalign" style="color:red;font-size:15px; ">';
		$DataRow.=''.checkboxOther($row['Status']).'';
		$DataRow.='</td><td>';
		$DataRow.=''.$row['LoadID'].'';
		$DataRow.='</td><td>';
		$DataRow.=''. $row['CusID'].'';
		$DataRow.='</td><td>';
		$DataRow.=''.$row['CusName'].'';
		$DataRow.='</td><td>';
		$DataRow.=''.$row['CusAmountPerDay'].'';
		$DataRow.='</td><td>';
		$DataRow.=''. $row['CusAmountDay'].'';
		$DataRow.='</td><td>';
		$DataRow.=''. $row['Description'].'';
		$DataRow.='</td><td>';
		$DataRow.=''. $row['StartDate'].'';
		$DataRow.="</td></tr>";
		
	//echo $DataRow;
	
		//echo '<tr>';
		    //echo '<td class="lalign" style="color:red;">';
		   // echo checkboxOther($row['Status']);
		
		
		//echo "</td><td>";
		//echo     $row['LoadID'];
		//echo "</td><td>";
		//echo    $row['CusID'];
		//echo "</td><td>";
		//echo    $row['CusName'];
		//echo "</td><td>";
		//echo   $row['CusAmountPerDay'];
		//echo "</td><td>";
		//echo   $row['CusAmountDay'];
		//echo "</td><td>";
		//echo  $row['Description'];
		//echo "</td><td>";
		//echo  $row['StartDate'];
		//echo "</td></tr>";
		
	   }
	   $UserName=$row['CusName'];
	   $UnPaid= $row['TotalUnPaid'];
	   $Paid=$row["TotalPaid"];
	   $RemainTotal=$row["RemainTotal"];
	   $CurrentTotal=$row["CurrentTotal"];
	   $GrandTotal=$row["CusAmount"];
	   
	
function checkboxOther($check){
   // $check='checked';
    if($check=='1'){
	
	$check='checked';
   }else {	    
	$check='unchecked';   
	}
    
    $form='<form>';
    $form.='<input type="checkbox" name="" value="" ';
    $form.=''.$check.' onclick=" "/>';  
    $form.= '</form>';
    
    return $form;
    
    
}
?>
<!DOCTYPE html>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/tblReport.css" />
<link rel="stylesheet" type="text/css" href="css/button.css" />
<body>
   
 <div id="wrapper">
     <div id="topleft" style="width:30%;  float: left; margin: 0px; ">
	 <h5 style=" padding: 10px; font-family: 'Amarante', Tahoma, sans-serif; font-size:15px; color: #2391dd;">Invoice No:____________</h5>
	 <h5 style=" padding: 10px; font-family: 'Amarante', Tahoma, sans-serif; font-size:15px; color: #2391dd;">Date/Month/Year:____/_______/__________</h5>
	 <h5 style=" padding: 10px; font-family: 'Amarante', Tahoma, sans-serif; font-size:15px; color: #2391dd;">User Name:  <span style="color:red;"><?php echo $UserName;?></span> </h5>
	 <h5 style=" padding: 10px; font-family: 'Amarante', Tahoma, sans-serif; font-size:15px; color: #2391dd;">Signature: .........................</h5>
     </div>
     
     
     <div id="topright" style="width: 30%;  float: right;  margin: 0px;">
	 <span style="float: right;"><img src="logo/nobg.png" alt="Smiley face" height="100" width="120"  ></span>
	 <div style="clear:both"></div>
	 <h5 style=" padding: 5px; font-family: 'Amarante', Tahoma, sans-serif; font-size:15px; text-align: right;">Logo</h5>
	 <h5 style=" margin: 5px; font-family: 'Amarante', Tahoma, sans-serif; font-size:15px;text-align: right; color: #2391dd;">Tel:098794488 / 012785855</h5>
     </div>
     
     <br>   <br>   <br>   <br>   <br>   <br>
     <br>   <br>   <br>   <br>   <br>   <br>
     
     <h1 style=" margin: 5px;">Summary Detail</h1>
  <table id="keywords" border="1"   cellspacing="0" cellpadding="0">
     
    <thead>
      <tr>
	<th ><span>Status</span></th>
	<th ><span>L-ID</span></th>
	<th><span>C-ID</span></th>
        <th><span>C-Name</span></th>
        <th><span>AmountP/D</span></th>
        <th><span>AmountDay</span></th>
        <th><span>Description</span></th>
	 <th><span>Recived Date</span></th>
<!--       // <th><span>Description</span></th>-->
      </tr>
    </thead>
    <tbody>

	
	<?php echo $DataRow;?>
      
    </tbody>

  </table>
     <hr> <hr>
     <table id="footer" border="1"  >
      
       <tr>
	<th style="color: #008000; padding: 10px 10px 10px 10px; font-size: 10px; font-family: 'Amarante', Tahoma, sans-serif;"><span>Paid:</span></th>
	<th style="color: #008000; padding: 10px 10px  10px 10px; font-size: 13px; font-family: 'Amarante', Tahoma, sans-serif;"><span>UnPaid:</span></th>
	<th style="color: red; padding: 10px 10px  10p 10px; font-size: 13px;"><span></span></th>
	<th style="color: red; padding: 10px 10px  10px 10px; font-size: 13px;"><span></span></th>
	<th style="color: #088da5; padding: 10px 10px  10px 350px; font-size: 18px; font-family: 'Amarante', Tahoma, sans-serif;"><span>Current Total:</span></th>
        <th style="color: #ff69b4; padding: 10px 10px  10px 10px; font-size: 15px; font-family: 'Amarante', Tahoma, sans-serif;"><span><?php echo $CurrentTotal;?></span></th>
	 <th style="color: #0000ff; padding: 10px 10px  10px 10px; font-size: 15px;font-family: 'Amarante', Tahoma, sans-serif;"><span>20-10-2014</span></th>
      </tr>
      
       <tr>
	   <th style="color: red; padding: 10px 10px  10px 10px; font-size: 13px; font-family: 'Amarante', Tahoma, sans-serif;"><span><?php echo $Paid; ?></span></th>
	<th style="color: red; padding: 10px 10px  10px 10px; font-size: 13px; font-family: 'Amarante', Tahoma, sans-serif;"><span><?php echo $UnPaid;?></span></th>
	<th style="color: red; padding: 10px 10px  10px 10px; font-size: 13px;"><span></span></th>
	<th style="color: red; padding: 10px 10px  10px 10px; font-size: 13px;"><span></span></th>
	<th style="color: #088da5; padding: 10px 10px  10px 350px; font-size: 18px; font-family: 'Amarante', Tahoma, sans-serif;"><span>Remain Total:</span></th>
        <th style="color: #6dc066; padding: 10px 10px  10px 10px; font-size: 15px; font-family: 'Amarante', Tahoma, sans-serif;"><span><?php echo $RemainTotal; ?></span></th>
	<th style="color: #0000ff; padding: 10px 10px  10px 10px; font-size: 15px; font-family: 'Amarante', Tahoma, sans-serif;"><span>20-10-2014</span></th>
      </tr>
      
       <tr>
	<th style="color: red; padding: 10px 10px  10px 10px;"><span></span></th>
	<th style="color: red; padding: 10px 10px  10px 10px;"><span></span></th>
	<th style="color: red; padding: 10px 10px  10px 10px; font-size: 13px;"><span></span></th>
	<th style="color: red; padding: 10px 10px  10px 10px; font-size: 13px;"><span></span></th>
	<th style="color: #088da5; padding: 10px 10px  10px 350px; font-size: 18px; font-family: 'Amarante', Tahoma, sans-serif;"><span>Grand Total:</span></th>
        <th style="color: red; padding: 10px 10px  10px 10px; font-size: 15px; font-family: 'Amarante', Tahoma, sans-serif;"><span><?php echo $GrandTotal;?></span></th>
	 <th style="color: #0000ff; padding: 10px 10px  10px 10px; font-size: 15px; font-family: 'Amarante', Tahoma, sans-serif;"><span>20-10-2014</span></th>
      </tr>
 

  </table>
     <table id="footbuttom" style="float: center; background-color: red;" >
	    <div id="footerrpt" style="width: 100%; color: red;">
			<hr>
		    <h5 style="text-align: center; color: #2391dd;   margin: 15px; font-size: 17px;  font-family: 'Amarante', Tahoma, sans-serif;"> Thank You for Your join with me !</h5> 
		    <h5 style="text-align: justify; color: #2391dd; font-size: 15px;  font-family: 'Amarante', Tahoma, sans-serif;">Create By: visal</h5>
		    <h5 style="text-align: right; color: #2391dd;  margin: 15px; font-size: 11px; font-family: 'Amarante', Tahoma, sans-serif; "> Date: 20-10-2014</h5>
	    </div>
     </table>
 </div> 
</body>

