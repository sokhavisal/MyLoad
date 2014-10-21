<?php
    require_once __DIR__ .'/app/sys_const.php';
    require_once __DIR__ .'/common/com.php';
    require_once 'Com_SQL.php';
      	
	//setlocale(LC_ALL,'ja_JP.UTF-8'); 
	//mb_http_output('UTF-8');
	  $sql= getdata_RgistrationWeekly();
	  $result= SQLQuery($sql);
	  $Json['total']= count($result);
     
        $Json['page']=0;
	//$Json['header']='Registration Daily';
	$Json['columns'][]= (array('field' => 'recid',                   'caption' => 'NO',                 'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusID',                   'caption' => 'Customer ID',        'size' => '70px',    'sortable' => true, 'style'=>  'text-align: center',   'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusName',                 'caption' => 'Customer Name',      'size' => '150px',   'sortable' => true, 'style'=>  'text-align: left',     'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'COtherType',               'caption' => 'Other',         'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CDaily',                   'caption' => 'Daily',             'size' => '70px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CWeekly',                  'caption' => 'Weekly',            'size' => '70px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CMonthly',                 'caption' => 'Monthly',           'size' => '70px',    'style'=>  'text-align: center','type' => 'int'));
	//$Json['columns'][]= (array('field' => 'CusLoadType',           'caption' => 'Load Type',          'size' => '100px',   'sortable' => true, 'style'=>  'text-align: left',     'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusPhoneNumber',           'caption' => 'Phone Number',       'size' => '150px',  'resizable'=>true,   'sortable' => true, 'style'=>     'text-align: left', 'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'CusDescription',           'caption' => 'Description',        'size' => '250px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'CusDateIssus',             'caption' => 'Date Issus',         'size' => '150px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'date')));
	$Json['columns'][]= (array('field' => 'OtherType',		  'caption' => 'O',          'size' => '50px', 'hidden'=> true,   'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Daily',                    'caption' => 'D',              'size' => '50px','hidden'=> true,    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Weekly',                   'caption' => 'W',             'size' => '50px', 'hidden'=> true ,    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Monthly',                  'caption' => 'M',           'size' => '50px',  'hidden'=> true,  'style'=>  'text-align: center','type' => 'int'));
	
	$RowPos=0;
               for  ($i=0;$i<count($result);$i++) 
	
		 {
		$RowPos = $RowPos + 1;
                $row=$result[$i];
		$Json['records'][]=
		(
			array
			(
				'recid' => $RowPos,
				'CusID' => $row["CusID"],
				'CusName' => $row["CusName"],
				'CusPhoneNumber' => $row["CusPhoneNumber"],
                                'CusDescription' => $row["CusDescription"],
			        'CusDateIssus' => $row["CusDateIssus"],
				'OtherType' => $row["OtherType"],
				'COtherType' => checkboxOther($row["OtherType"]),
				'Daily' => $row["Daily"],
				'CDaily' => checkboxOther($row["Daily"]),
				'Weekly' => $row["Weekly"],
				'CWeekly' => checkboxOther($row["Weekly"]),
				'CMonthly' => checkboxOther($row["Monthly"]),
				'Monthly' => $row["Monthly"],
				'nullRow' => ''

			)
		);
	}
	  
		echo json_encode($Json);
		
function checkboxOther($check){
   // $check='checked';
    if($check=='1'){
	
	$check='checked';
   }else {	    
	$check='unchecked';   
	}
    
    $form='<form>';
    $form.='<input type="checkbox" name="" value="" ';
    $form.=''.$check.' onclick="func_outputCheckBoxContent();"/>';  
    $form.= '</form>';
    
    return $form;
    
    
}

?>