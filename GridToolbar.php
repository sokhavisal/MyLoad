<!DOCTYPE html>
<html>
<head>
	<title>W2UI Demo: grid-17</title>
<!--	<link rel="stylesheet" type="text/css" href="//w2ui.com/src/w2ui-1.3.min.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script type="text/javascript" src="//w2ui.com/src/w2ui-1.3.min.js"></script
<link rel="stylesheet" type="text/css" href="css/icon.css" />-->
    <link rel="stylesheet" type="text/css" href="http://w2ui.com/src/w2ui-1.4.1.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://w2ui.com/src/w2ui-1.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/icon.css" />
</head>
<body>

<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
    	var rc='';
	var pstyle = 'border: 1px solid blue; padding: 5px; ';
var popSiirePalam='';
var mainf ={
    layout:{
	name: 'layout',
	padding: 0,
	panels:[
		
		{type:'main',minSize: 550,size:'300', overflow: 'hidden' },
		
	]
    },
};
 var gItemRanking = {
	grid: { 
		name: 'gItemRanking',
                style:pstyle,
		header:'Items Ranking',
		//autoload:true,
		url:'getdata_Customer.php',
		toolbar: {
		    items: [
			{ type: 'spacer', id: 'spacer'},
			{ type: 'menu',   id: 'output', caption: 'test', img: 'icn-application-put', items: 
                                                  [
						      { id: 'outcsv',text: 'CSV', icon: 'icon-excel-csv' },
                                                      { id: 'outxls',text: 'Excel', icon: 'icon-excel-xls' },                                                      
						      { id: 'outxlsx',text: 'Excel2007', icon: 'icon-excel-xlsx' }
						   ]
                                               },
					   
					    { type: 'break',  id: 'break0' }
		    ],
		    
		    onClick : function (target, data){ 
			//alert(target);
			var LegRecord= w2ui.gItemRanking.records.length;
			
			//alert(popSiirePalam);
			if (rc==''){
				popSiirePalam='?sid='+ "''"; 
			    }else {
				
				popSiirePalam='?sid='+rc;
			    }
			    //var attrID= $(data.subItem).attr('id');
			   // 
			   //alert(data.target); 
			//alert  ($(data.subItem).attr('id'));
			    func_popToolClick(target, $(data.subItem).attr('id'),'getdata_Customer.php',popSiirePalam,LegRecord);	
					    
		    }
	     },
		
		show: {
			header:true,
			toolbar:true,
			footer:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
		
		 //searches:[{}],   
		columns: [{}],

	        onClick: function (event) {        
                   
		    
		}
            
	}
    };

function func_popToolClick(target,tID,OutURL,Param,cnt) {
	if (target == 'back'){
		$().w2popup('close');
		
	//出力アイコンクリック時
	}else if(target !='output'){
		//エクセル出力
		if(tID== 'outxls'){
		   // if(!session_checking()){
			if(cnt>65536) {
				//window.alert('Excel最大行数を超えています。\n処理を終了します。');
				w2ext.alertIcon = w2ext.icons.error;
				w2ext.alert('Excel最大行数を超えています。\n処理を終了します。');
				}

			//出力対象URLが存在する場合
			if(OutURL.length > 0) {
				var date = new Date();
				var yy = date.getFullYear();
				var mm = ('0' + (date.getMonth() + 1)).slice(-2);
				var dd = ('0' + date.getDate()).slice(-2);
				var HH= ('0'+ date.getHours()).slice(-2);
				var MM= ('0'+   date.getMinutes()).slice(-2);
				var ss= ('0'+   date.getSeconds()).slice(-2);
				var SendURL = OutURL+Param+"&filename="+yy+mm+dd+HH+MM+ss+".xlsx";
				window.open(SendURL);
			}
		   // }
		//エクセル2007出力d\]
		} else if(tID== 'outxlsx'){
		  //  if(!session_checking()){
			if(cnt>1048576) {
				//window.alert('Excel最大行数を超えています。\n処理を終了します。');
				w2ext.alertIcon = w2ext.icons.error;
				w2ext.alert('Excel最大行数を超えています。\n処理を終了します。');
			}

			//出力対象URLが存在する場合
			if(OutURL.length > 0) {
				var date = new Date();
				var yy = date.getFullYear();
				var mm = ('0' + (date.getMonth() + 1)).slice(-2);
				var dd = ('0' + date.getDate()).slice(-2);
				var HH= ('0'  + date.getHours()).slice(-2);
				var MM= ('0'+   date.getMinutes()).slice(-2);
				var ss= ('0'+   date.getSeconds()).slice(-2); 
				var SendURL = OutURL+Param+"&filename="+yy+mm+dd+HH+MM+ss+".xlsx";
				window.open(SendURL);
			}
		   // }
		//CSV出力
		} else if(tID== 'outcsv'){
		   // if(!session_checking()){
			//出力対象URLが存在する場合
			if(OutURL.length > 0) {
				var date = new Date();
				var yy = date.getFullYear();
				var mm = ('0' + (date.getMonth() + 1)).slice(-2);
				var dd = ('0' + date.getDate()).slice(-2);
				var HH= ('0'  + date.getHours()).slice(-2);
				var MM= ('0'+   date.getMinutes()).slice(-2);
				var ss= ('0'+   date.getSeconds()).slice(-2); 
				var SendURL = OutURL+Param+"&filename="+yy+mm+dd+HH+MM+ss+".csv";
				
				window.open(SendURL);
				
			}
		    //}
		//印刷時		
		}
                else if((tID== 'print' || tID== 'outcsv' || tID== 'outxlsx' || tID== 'outxls') && OutRowCount == 0){
		    if(!session_checking()){
			//window.alert('出力できるレコードが存在しません。');
			w2ext.alertIcon = w2ext.icons.error;
			w2ext.alert('出力できるレコードが存在しません。');
		    }
		}
	}
}
$(function () {
      $('#main').w2layout(mainf.layout);
      
    w2ui.layout.content('main',$().w2grid(gItemRanking.grid));
});
</script>

</body>
</html>