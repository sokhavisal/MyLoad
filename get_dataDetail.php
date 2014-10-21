<?php
    require_once __DIR__ .'/app/sys_const.php';
    require_once __DIR__ .'/common/com.php';
    require_once 'Com_SQL.php';
      	mb_http_output('UTF-8');
	 $IDc = X(filter_input(INPUT_GET, 'sid', FILTER_SANITIZE_STRING));
	  //$LoadType = X(filter_input(INPUT_GET, 'sid', FILTER_SANITIZE_STRING));
//	if(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING) =='ParamID') {
//	    
//	   $cusID=$_POST['CusID'];
//	   // $cusID=$_POST['rows'][0]['CusID'];
//	  
//	}
	//$ID=$cusID;

	  $sql= getdata_Detail($IDc);
	  $result= SQLQuery($sql);
	  $Json['total']= count($result);
     
        $Json['page']=0;
	//$Json['header']='Registration Daily';
	$Json['columns'][]= (array('field' => 'recid',                 'caption' => 'NO',  hidden=>true,             'size' => '30px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'Editable',                 'caption' => 'Delete',               'size' => '70px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'LoadID',                'caption' => 'L-ID',             'size' => '46px',    'sortable' => true, 'style'=>  'text-align: center',   'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'CusID',                 'caption' => 'C-ID',             'size' => '50px',   'sortable' => true, 'style'=>  'text-align: left',     'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'CusName',               'caption' => 'Name',             'size' => '150px',    'style'=>  'text-align: left','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusAmount',             'caption' => 'Total ',     'size' => '80px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusAmountPerDay',       'caption' => 'P/D',       'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	$Json['columns'][]= (array('field' => 'CusAmountDay',          'caption' => 'Day',       'size' => '50px',    'style'=>  'text-align: center','type' => 'int'));
	//$Json['columns'][]= (array('field' => 'CusLoadType',         'caption' => 'Load Type',        'size' => '100px',   'sortable' => true, 'style'=>  'text-align: left',     'editable'=> array('type'=> 'int')));
	$Json['columns'][]= (array('field' => 'LoadType',              'caption' => 'L-T',          'size' => '36px',  'resizable'=>true,   'sortable' => true, 'style'=>     'text-align: left', 'editable'=> array('type'=> 'text')));
	$Json['columns'][]= (array('field' => 'CusLoadIssusDate',              'caption' => 'S-Date','size' => '100px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'int')));
	//$Json['columns'][]= (array('field' => 'CusLoadIssusDate',      'caption' => 'Date Issus',        'size' => '150px',   'sortable' => true, 'style'=>  'text-align: center',  'editable'=> array('type'=> 'date')));
	
	
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
				'LoadType' => $row["LoadType"],
				'CusLoadIssusDate' => $row["CusLoadIssusDate"],
				'Editable' => func_ButtonEdit(),
				
				'nullRow' => ''

			)
		);
		 //  $Json['records'][$RowPos-1]['style'] = 'background-color:#ffefd5 '; 
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

