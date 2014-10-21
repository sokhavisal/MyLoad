<?php
    require_once __DIR__ .'/app/sys_const.php';
    require_once __DIR__ .'/common/com.php';
	mb_http_output('UTF-8');
	mysqli_query("set names utf8");
    $TableName=array(
	    
	        0 => 'tblCustomer',						
		
		);
	$TableNo=filter_input(INPUT_GET, 'f', FILTER_SANITIZE_STRING);
	if($TableNo >= 0 && $TableNo <= count($TableName)){
		//更新処理の場合
		if(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING) =='save') {
			$setfile='';
			$setvalue='';
			$changeCheck='';
			$Type ='';
			$TypeValue='';
			
			$HT=$_POST['COtherType'];
			$CusID = $_POST['CusID'];
			$other = $_POST['OtherType'];
			$Daily = $_POST['Daily'];
			$Weekly = $_POST['Weekly'];
			$Monthly = $_POST['Monthly'];
			$TypeOther=$_POST['TypeOther'];
			$TypeDaily=$_POST['TypeDaily'];
			$TypeWeekly=$_POST['TypeWeekly'];
			$TypeMonthly=$_POST['TypeMonthly'];
			
		   if ($TableNo==0){
			switch ($HT){
			    case 'COtherType':
				
				$changeCheck=$other;
				$setfile='OtherType';
				$Type='TypeOther';
				$LoadTypeValue=$TypeOther;
				    if ($other=='0'){
					$TypeValue='2';

				    }else {
					$TypeValue='0';
					}
				break;
			    
			    case 'CDaily':
				$changeCheck=$Daily;
				$setfile='Daily';
				$Type='TypeDaily';
				$LoadTypeValue=$TypeDaily;
				    if ($Daily=='0'){
					$TypeValue='3';

				    }else {
					$TypeValue='0';
					}
				break;
			    case 'CWeekly':
				$changeCheck=$Weekly;
				$setfile='Weekly';
				$Type='TypeWeekly';
				$LoadTypeValue=$TypeWeekly;
				    if ($Weekly=='0'){
					$TypeValue='4';

				    }else {
					$TypeValue='0';
					}
				break;
			    
			    case 'CMonthly':
				$changeCheck=$Monthly;
				$setfile='Monthly';
				$Type='TypeMonthly';
				$LoadTypeValue=$TypeMonthly;
				    if ($Monthly=='0'){
					$TypeValue='5';

				    }else {
					$TypeValue='0';
					}
				break;

			}
			// change check value. 
			if ($changeCheck=='0'){

					$changeCheck='1';

				    } else {

					 $changeCheck='0';
			
				    }
				    
				   // check customer in load or not in load.  
				 $SQL='SELECT count(*) As COUNT   FROM tblCusLoadDetail WHERE CusID = '.$CusID .' AND LoadType = '.$LoadTypeValue ;
				    $result = SQLQuery($SQL);
				   $RowPos=0;
				   for ($i=0;$i<count($result);$i++){
				        $RowPos = $RowPos + 1;
				        $row=$result[$i];
				   }
				   
				// if custoer is not in load you can removed check. 
				if ($row['COUNT']  == '0' ){
				   $SQL=' UPDATE '.$TableName[$TableNo].' SET  '.($setfile).' = '. $changeCheck.' ,'.($Type).' = '.($TypeValue).'  WHERE CusID='.($CusID); 
				   SQLExecute($SQL);
				   
				 // I will create message form Detail to display when user removed checkbox.   
				}else {
				    
				   echo $msg="Your Balance is still in My Account,Can not remove check ! "; 
				}
				
				  
		      }
		 
 
		}
	}
?>
