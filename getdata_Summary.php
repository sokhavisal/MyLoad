<?php
    require_once __DIR__ .'/app/sys_const.php';
    require_once __DIR__ .'/common/com.php';
    require_once 'Com_SQL.php';
      	mb_http_output('UTF-8');
	 $CusID = X(filter_input(INPUT_GET, 'Cusid', FILTER_SANITIZE_STRING));
	$LoadID = filter_input(INPUT_GET, 'loadid', FILTER_SANITIZE_STRING);
	$LoadType = filter_input(INPUT_GET, 'loadtype', FILTER_SANITIZE_STRING);

	    $sql= getdata_ViewSummary($LoadID,$CusID,$LoadType);
	//  $sql= getdata_ViewSummary('03','001','3');
	  $result= SQLQuery($sql);
	  $Json['total']= count($result);
     
        $Json['page']=0;
	//$Json['header']='Registration Daily';

    
	$Json['columns'][]= (array('field' => 'recid',              'caption' => 'NO',             'hidden'=> true,     'size' => '50px',     'style'=>       'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'cStatus',            'caption' => 'Status',				'size' => '50px',     'style'=>       'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Status',             'caption' => 'Status',          'hidden'=> true,    'size' => '50px',     'style'=>       'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'sumaryID',           'caption' => 'S-ID',            'hidden'=> true,    'size' => '50px',     'sortable' => true, 'style'=>  'text-align: center',   'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'LoadID',             'caption' => 'L-ID',				'size' => '50px',     'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'date')));
	$Json['columns'][]= (array('field' => 'CusID',              'caption' => 'C-ID',				'size' => '50px',     'sortable' => true, 'style'=>  'text-align: left',     'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'CusName',            'caption' => 'Name',				'size' => '130px',     'style'=>      'text-align: left','type' => 'text'));
	$Json['columns'][]= (array('field' => 'CusAmountPerDay',    'caption' => 'P/D',				        'size' => '130px',    'style'=>      'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'LoadType',           'caption' => 'Type',	    'hidden'=> true,    'size' => '50px',     'style'=>      'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Description',          'caption' => 'Description','hidden'=> true, 	'size' => '85px',     'style'=>      'text-align: center','type' => 'text'));
	$Json['columns'][]= (array('field' => 'StartDate',            'caption' => 'StartDate',				'size' => '85px',    'resizable'=>true,   'sortable' => true, 'style'=>     'text-align: left', 'editable'=> array('type'=> 'date')));
	$Json['columns'][]= (array('field' => 'EndDate',      'caption' => 'EndDate',   'hidden'=> FALSE,                    'size' => '85px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'date')));
	$Json['columns'][]= (array('field' => 'CurrentTotal',      'caption' => 'CurrentTotal',   'hidden'=> true,                    'size' => '250px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'TotalPaid',      'caption' => 'TotalPaid',   'hidden'=> true,                    'size' => '250px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'TotalUnPaid',      'caption' => 'TotalUnPaid',   'hidden'=> true,                    'size' => '250px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusAmount',      'caption' => 'CusAmount',   'hidden'=> true,                    'size' => '250px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'RemainTotal',      'caption' => 'RemainTotal',   'hidden'=> true,                    'size' => '250px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'int')));
	//$Json['columns'][]= (array ('summary' => true, 'field'=>'sumaryID'));
	
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
				'Status' => $row["Status"],
				'cStatus' => checkbox($row["Status"]),
				'sumaryID' => $row["sumaryID"],
				'CusID' => $row["CusID"],
				'CusName' => $row["CusName"],
                                'CusAmountPerDay' => $row["CusAmountPerDay"],
			        'LoadType' => $row["LoadType"],
				 'Description' => $row["Description"],
				'StartDate' => $row["StartDate"],
				'EndDate' => $row["EndDate"],
				'TotalPaid' => $row["TotalPaid"],
				'TotalUnPaid' => $row["TotalUnPaid"],
				'CurrentTotal' => $row["CurrentTotal"],
				'CusAmount' => $row["CusAmount"],
			    'RemainTotal' => $row["RemainTotal"],
			     'nullRow' => ''
			)
		);
		
		if ($row["Status"]=='1'){
									    //#b0e0e6
		    $Json['records'][$RowPos-1]['style'] = 'background-color:#b0e0e6 '; 

		}else {								//#ffc0cb	
		    $Json['records'][$RowPos-1]['style'] = 'background-color: #ffc0cb';  
		}
		
	}
	
	
	$Sumarydata1=array (
	    'summary'=> TRUE,
	     'recid'=>'S-1',
	    
	    'CusAmountPerDay'=>'<span style="color:#ff0000; font-size:14px;"> '.$row["CurrentTotal"].' </span>',
	    'LoadID' =>'<span style="float: right;color:#008080; "> Paid </span>',
	    'CusID' =>'<span style="float: right;color:#008080; "> UnPaid </span>',
	    
	    'CusName' =>'<span style="float: right; color:#088da5;">Current Total</span>',
	    'StartDate' =>  '<span style="color:blue; font-size:14px;"> 1/1/2012 </span> ',
	    'EndDate' => '<span style="color:blue; font-size:14px;"> 2/1/2012 </span>',
	    );
	
	$Sumarydata2= array (    
	    'summary'=> TRUE,
	    'recid'=>'S-2',
	    'cStatus' =>'<span style="float: right;color:#008080; ">Total:</span>',
	    'LoadID' =>'<span style="float: right;color:#fd482f; font-size:20px;"> '.$row["TotalPaid"].' </span>',
	    'CusID' =>'<span style="text-align: center;color:#fd482f; font-size:20px;  "> '.$row["TotalUnPaid"].' </span>',
	    'CusAmountPerDay'=>'<span style="color:#ff1493; font-size:14px;"> '.$row["RemainTotal"].' </span>',
	    'CusName' =>'<span style="float: right; color:#088da5;">Remain Total</span>',
	    'StartDate' =>  '<span style="color:blue; font-size:14px;"> 1/1/2012 </span> ',
	    'EndDate' => '<span style="color:blue; font-size:14px;"> 2/1/2012 </span>',
	    );
	
	$Sumarydata3= array (    
	    'summary'=> TRUE,
	     'recid'=>'S-3',
	  
	    'CusAmountPerDay'=>'<span style="color:#68228b; font-size:14px;"> '.$row["CusAmount"].' </span>',
	   // 'CusName' =>'<span style="float: right;color:#fd482f; ">Date To Date:</span>',
	     'CusName' =>'<span style="float: right; color:#088da5;">Grand Total</span>',
	    'StartDate' =>  '<span style="color:blue; font-size:14px;"> 1/1/2012 </span> ',
	    'EndDate' => '<span style="color:blue; font-size:14px;"> 2/1/2012 </span>',
	    'nullRow' => ''
	    );
	
	   array_push($Json['records'],$Sumarydata1);
	   array_push($Json['records'],$Sumarydata2);
	   array_push($Json['records'],$Sumarydata3);
	   
echo json_encode($Json);
		
function checkbox($check){
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



