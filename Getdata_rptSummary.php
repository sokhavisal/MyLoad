<?php

 require_once __DIR__ .'/app/sys_const.php';
    require_once __DIR__ .'/common/com.php';
    require_once 'Com_SQL.php';
   // require_once 'getdata_report.php';
	$CusID = filter_input(INPUT_GET, 'Cusid', FILTER_SANITIZE_STRING);
	$LoadID = filter_input(INPUT_GET, 'loadid', FILTER_SANITIZE_STRING);
	$LoadType = filter_input(INPUT_GET, 'loadtype', FILTER_SANITIZE_STRING);
	//$TableNo=filter_input(INPUT_GET, 'Con', FILTER_SANITIZE_STRING);
	//echo 
	//$sql= Getdata_rptSummary($CusID,$LoadID,$LoadType);
	 $sql='';
	 $sql.='SELECT * FROM viewSummaryDetail where CusID="'.$CusID.'" AND LoadID="'.$LoadID.'" AND LoadType="'.$LoadType.'" ';
	$result= SQLQuery($sql);
	$RowPos =0;
	   for  ($i=0;$i<count($result);$i++) {
		$RowPos = $RowPos + 1;
                $row=$result[$i];
		
		$DataRow ='';
		$DataRow.='<tr>';
		$DataRow.='<td class="lalign" style="color:red;">';
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
		
	echo $DataRow;
	
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

	
