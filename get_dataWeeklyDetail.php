<?php
    require_once __DIR__ .'/app/sys_const.php';
    require_once __DIR__ .'/common/com.php';
    require_once 'Com_SQL.php';
      	mb_http_output('UTF-8');
	 $IDc = X(filter_input(INPUT_GET, 'sid', FILTER_SANITIZE_STRING));
//	if(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING) =='ParamID') {
//	    
//	   $cusID=$_POST['CusID'];
//	   // $cusID=$_POST['rows'][0]['CusID'];
//	  
//	}
	//$ID=$cusID;

	  $sql= getdata_WeeklyDetail($IDc);
	  $result= SQLQuery($sql);
	  $Json['total']= count($result);
     
        $Json['page']=0;
	//$Json['header']='Registration Daily';
	$Json['columns'][]= (array('field' => 'recid',                   'caption' => 'NO',        hidden => TRUE,         'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Delete',                   'caption' => 'Delete',                 'size' => '70px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'LoadID',                   'caption' => 'LoadID',        'size' => '70px',    'sortable' => true, 'style'=>  'text-align: center',   'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusID',                 'caption' => 'CusID',      'size' => '150px',   'sortable' => true, 'style'=>  'text-align: left',     'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'CusName',               'caption' => 'Other',         'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusAmount',                   'caption' => 'Daily',             'size' => '70px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusAmountPerDay',                  'caption' => 'Weekly',            'size' => '70px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusAmountDay',                 'caption' => 'Monthly',           'size' => '70px',    'style'=>  'text-align: center','type' => 'int'));
	//$Json['columns'][]= (array('field' => 'Currentotal',           'caption' => 'Currentotal',          'size' => '100px',   'sortable' => true, 'style'=>  'text-align: left',     'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusProfit',           'caption' => 'Phone Number',       'size' => '150px',  'resizable'=>true,   'sortable' => true, 'style'=>     'text-align: left', 'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'LoadType',           'caption' => 'Description',        'size' => '250px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusLoadIssusDate',             'caption' => 'Date Issus',         'size' => '150px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'date')));
	
	
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
				'LoadID' => $row["LoadID"],
				'CusID' => $row["CusID"],
				'CusName' => $row["CusName"],
                                'CusAmount' => $row["CusAmount"],
			        'CusAmountPerDay' => $row["CusAmountPerDay"],
				 'CusAmountDay' => $row["CusAmountDay"],
				'CusProfit' => $row["CusProfit"],
				'LoadType' => $row["LoadType"],
				'CusLoadIssusDate' => $row["CusLoadIssusDate"],
				'Delete' => func_ButtonEdit () ,
			    
				'nullRow' => ''

			)
		);
	}
	  
		echo json_encode($Json);

  function func_ButtonEdit(){
      $button='';
      $button.='<div>';
      $button.='<input  class="myButton" type="button" value="Delete" name="btnedit" onclick="func_DeleteTransection()">';
      $button.='</div>'; 
      return $button;
  }


?>

