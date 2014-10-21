<?php
    require_once __DIR__ .'/app/sys_const.php';
    require_once __DIR__ .'/common/com.php';
    require_once 'Com_SQL.php';
      	$FileName = X(filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING));
	//setlocale(LC_ALL,'ja_JP.UTF-8'); 
	//mb_http_output('UTF-8');
	   $sql= getdata_Customer();
	  $result= SQLQuery($sql);
	  $Json['total']= count($result);
     
        $Json['page']=0;
	//$Json['header']='Customer List';
	$Json['columns'][]= (array('field' => 'recid',                   'caption' => 'NO',                 'size' => '30px',    'style'=>  'text-align: left; color:#ff8000','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusID',                   'caption' => 'ID',        'size' => '50px',    'sortable' => true, 'style'=>  'text-align: left; color: blue ',   'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusName',                 'caption' => 'Customer Name',      'size' => '150px',   'sortable' => true, 'style'=>  'text-align: left; color: #191919 ',     'editable'=> array('type'=> 'text')));
	//$Json['columns'][]= (array('field' => 'CusLoadType',           'caption' => 'Load Type',          'size' => '100px',   'sortable' => true, 'style'=>  'text-align: left',     'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusPhoneNumber',           'caption' => 'Phone Number',       'size' => '110px',  'resizable'=>true,   'sortable' => true, 'style'=>     'color: red ; text-align:center',    'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'CusDescription',           'caption' => 'Description',        'size' => '250px',   'sortable' => true, 'style'=>  'text-align: center; color:#751919',  'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'OtherType',		  'caption' => 'O',  'hidden' => true,        'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Daily',                    'caption' => 'D',   'hidden' => true,            'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Weekly',                   'caption' => 'W',  'hidden' => true,            'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Monthly',                  'caption' => 'M',  'hidden' => true,          'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'COtherType',               'caption' => 'Other',         'size' => '60px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CDaily',                   'caption' => 'Daily',             'size' => '60px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CWeekly',                  'caption' => 'Weekly',            'size' => '60px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CMonthly',                 'caption' => 'Monthly',           'size' => '60px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusDateIssus',             'caption' => 'Date Issus',         'size' => '150px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'date')));
	$Json['columns'][]= (array('field' => 'TypeOther',		  'caption' => 'TypeOther',  'hidden' => TRUE,        'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'TypeDaily',                    'caption' => 'TypeDaily',   'hidden' => TRUE,            'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'TypeWeekly',                   'caption' => 'TypeWeekly',  'hidden' => TRUE,            'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'TypeMonthly',                  'caption' => 'TypeMonthly',  'hidden' => TRUE,          'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
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
				//'CusLoadType' => $row["CusLoadType"],
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
				'TypeOther' => $row["TypeOther"],
				'TypeDaily' => $row["TypeDaily"],
				'TypeWeekly' => $row["TypeWeekly"],
				'TypeMonthly' => $row["TypeMonthly"],
				//'Monthly' => $row["Monthly"],
				'nullRow' => ''

			)
		);
	}
	  
		//echo json_encode($Json);
	if($FileName) {
    SaveExcelEX('ItemsRanking'.$FileName,$Json);
	 }else {
		echo json_encode($Json);
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
    $form.=''.$check.' onclick="func_outputCheckBoxContent();"/>';  
    $form.= '</form>';
    
    return $form;
    
    
}

?>