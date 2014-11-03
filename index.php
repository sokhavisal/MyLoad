<!DOCTYPE html>
<html>
<head>
 
    <title>Load System Control</title>
    
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <script type="text/javascript"  src="js/jquery.js"></script>
     <!--<link rel="stylesheet" type="text/css" href="http://w2ui.com/src/w2ui-1.4.min.css" />-->
      <link rel="stylesheet" type="text/css" href="css/button.css" />
       <!--//<script type="text/javascript" src="http://w2ui.com/src/w2ui-1.4.min.js"></script>-->
        <script type="text/javascript"  src="js/w2ui-1.4.js"></script>
           <script type="text/javascript"  src="js/w2com.js"></script>  
	<script type="text/javascript" src="js/w2ui-1.4.min.js"></script>
	 <link rel="stylesheet" type="text/css" href="css/w2ui-1.4.min.css" />
	   <link rel="stylesheet" type="text/css" href="css/icon.css" />
</head>
<body>
<div style="width: 99%; height: 90px; padding: 2px; margin: 2px; border-color: silver;background-color: #d4e7b2;">
 <div style="float: left ; height: 100%; width: 100%;"><img src="logo/nobg.png" style="height: 100%;" alt="" aling="center" width="191px"></div> 
    <div id="main" style="width: 100%; height: 800px;"></div>   
<div style="width: 99%; height: 30px; padding: 5px; margin: 2px; border-color: silver; background-color:#d4e7b2"><h4 style='font-size:70%; text-align: center; padding: 0px opx  5px;color: #36648b;'>Copyright(C) 20013-<?=date('Y')?> Real Max Co.,Ltd. All Rights Reserved.</h4>
   </div>
	
			
    <div style="clear: both;"></div>
  
    </div>
    

<script type="text/javascript">
    var CusID ='';
    var ID='';
     var CusIDDeatailform='';
    var loadType='';
    var param ='';
   var loadIDDeatailform ='';
   var loadTypeDeatailform ='';
 var msg_SaveConfirm ="Are You Sure to Save This Record ？";   
// widget configuration
 var pstyle = 'border: 1px solid #dfdfdf; padding: 5px; ';
 var footstyle='border: 1px solid ##6497b1; padding: 5px; margin:2px; padding:2px; ';
 var layPopup = {
    name: 'layPopup',
    padding: 4,
    panels: [
        { type: 'main', minSize: 300, overflow: 'hidden' }
    ]
};

var mainf ={
    layout:{
	name: 'layout',
	padding: 0,
	panels:[
	    
	  
	    
		{type: 'left', size:'200',resizable:true, mixSize:120},
		{type: 'preview', size:'300',resizable:true, mixSize:120,hidden:true},
		{type:'main',minSize: 550, overflow: 'hidden' },
		      
		
		{ type: 'right', size: '600',mixSize:550, resizable: true,hidden:true, style: pstyle ,
		     toolbar: {                
			items: [                           
//				    { type: 'button',  id: 'backHome',  caption: 'メインページ', img: 'icn-application-home' },
//				    { type: 'break' },	
				  	
				    { type: 'spacer' },
				    { type: 'button',  id: 'logout', caption: 'Printer', img: 'icn-application-put' }
				
				    
			],
			onClick: function (event) {
			     var row = {rows:[]};
			      $.ajax({
                                        type: "POST",
                                        url: 'Getdata_rptSummary.php?Cusid='+ CusIDDeatailform +'&loadid='+loadIDDeatailform+'&loadtype='+loadTypeDeatailform,
                                        data: row,
					//async: true,
					 success: function(msg){
					     if (msg==""){
						
						alert(msg);
					     }else{
						 
					      printExternal('getdata_reportA5.php?Cusid='+ CusIDDeatailform +'&loadid='+loadIDDeatailform+'&loadtype='+loadTypeDeatailform);
					    }
					 }
			      });
				
				
			}
		}},
	]
    },
};
    /// group grid Detail.
    var gDailyDetail = {
	grid: { 
		name: 'gDailyDetail',
		header:'<font color="#008080"><h4> Detail </h4></font>',
                style:pstyle,
		url:'get_dataDetail.php',
		
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
	
		columns: [{}],
	   
	     onDblClick: function (event) {        
		    
			w2ui.gSummary.lock('lock...',true);
			//sleep(3000);
//			w2confirm('message', function (btn) {
//			   if (!btn){
//			       
			       w2ui.gSummary.reload();
			       w2ui.gSummary.unlock();
//			   }
//			}
			
			
		}
            
	}
	   
	
    };
    
    
 var gDetail = {
	grid: { 
		name: 'gDetail',
		//header:'Weekly Detail',
                style:pstyle,
		//url:'get_dataDetail.php?sid='+ID,
		//autoload:true,
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
	
		columns: [{}],
	   
		onDblClick: function (event) {        
		    
		    CusID = w2ui.gDetail.get(event.recid);
		    CusIDDeatailform=CusID.CusID;
		    loadIDDeatailform= CusID.LoadID;
		    loadTypeDeatailform=CusID.LoadType;
		    
		  //  alert(CusIDDeatailform);
		   // alert(loadIDDeatailform);
		   // alert(loadTypeDeatailform);
		  // event.onComplete = function() {
			w2ui.gSummary.fixedBody=false;
			w2ui.gSummary.url='getdata_Summary.php?Cusid='+CusIDDeatailform+'&loadid='+loadIDDeatailform+'&loadtype='+loadTypeDeatailform;
			w2ui.gSummary.reload();
//			  w2ui.layout.content('right',$().w2grid(gSummary.grid));
//			 CusIDDeatailform='';
//			loadIDDeatailform='';
//			loadTypeDeatailform='';
			

		   // }
		}
            
	}
	   
	
    };
  var gSummary = {
	grid: { 
		name: 'gSummary',
		header:'<font color="#0080ff"><h4> Summary </h4></font>',
                style:pstyle,
		//url:'getdata_Summary.php',
		//fixedBody: true,
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
		  sortData: [ { field: 'recid', direction: 'asc' } ],
		columns: [{}],
	}
	   
	
    };   


    

 var gUser = {
	grid: { 
		name: 'gUser',
                style:pstyle,
		header:'Customer List',
		autoload:true,
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
	
		columns: [
            { field: 'fname', caption: 'First Name', size: '180px' },
            { field: 'lname', caption: 'Last Name', size: '180px' },
            { field: 'email', caption: 'Email', size: '40%' },
            { field: 'sdate', caption: 'Start Date', size: '120px' },
	    ],
	    records: [
            { recid: 1, fname: 'Jane', lname: 'Doe', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 2, fname: 'Stuart', lname: 'Motzart', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 3, fname: 'Jin', lname: 'Franson', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 4, fname: 'Susan', lname: 'Ottie', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 5, fname: 'Kelly', lname: 'Silver', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 6, fname: 'Francis', lname: 'Gatos', email: 'jdoe@gmail.com', sdate: '4/3/2012' }
        ],
	        onClick: function (event) {        
                   
		    
		}
            
	}
    };

 var gLoadForm = {
	grid: { 
		name: 'gLoadForm',
                style:pstyle,
		header:'Daily load',
		autoload:true,
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
	
		columns: [
            { field: 'fname', caption: 'First Name', size: '180px' },
            { field: 'lname', caption: 'Last Name', size: '180px' },
            { field: 'email', caption: 'Email', size: '40%' },
            { field: 'sdate', caption: 'Start Date', size: '120px' },
	    ],
	    records: [
            { recid: 1, fname: 'Jane', lname: 'Doe', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 2, fname: 'Stuart', lname: 'Motzart', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 3, fname: 'Jin', lname: 'Franson', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 4, fname: 'Susan', lname: 'Ottie', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 5, fname: 'Kelly', lname: 'Silver', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 6, fname: 'Francis', lname: 'Gatos', email: 'jdoe@gmail.com', sdate: '4/3/2012' }
        ],
	        onDblClick: function (event) {        
                    w2ui['layout'].show('right');
		    w2ui['layout'].show('preview');
		    w2ui.layout.content('right',$().w2grid(gSummary.grid));
		    w2ui.layout.content('preview',$().w2grid(gDetail.grid));
		    w2ui.gSummary.reload();

		}
            
	}
    };
 var gCusRegWeekly = {
	grid: { 
		name: 'gCusRegWeekly',
                style:pstyle,
		header:'<font color="white"><h4> Registration Weekly </h4></font>',
		url:'getdat_WeeklyRegistration.php',
		autoload:true,
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
	
		columns: [{}],
	   
	        onDblClick: function (event) {      
		 CusID = w2ui.gCusRegWeekly.get(event.recid);
		 ID=CusID.CusID;
                    w2ui['layout'].show('right');
		    w2ui['layout'].show('preview');
		    w2ui.layout.content('preview',$().w2grid(gDetail.grid)); 
		    //w2ui.layout.content('right',$().w2grid(gSummary.grid));
		    
		    w2ui.gDetail.header='Weekly Detail';
		    w2ui.gDetail.url='get_dataWeeklyDetail.php?sid='+ID;
		    w2ui.gDetail.reload();
		    //w2ui.gSummary.url ='getdata_Summary.php?Cusid='+ID;
		  //  w2ui.gSummary.reload();
		    
		},
                onEdit: function (){
                     openPopup('Customer List',w2ui.layPopup,w2ui.fCusList,450,500);
				w2ui.fCusList.record=w2ui.gCusRegWeekly.get(w2ui.gCusRegWeekly.getSelection());
		           	w2ui.fCusList.refresh();
                                w2ui.fCusList.reload();
                                 var row = {rows:[]};  
                                row['rows'][0] =  w2ui.gCusRegWeekly.record;
                                alert(row['rows'][0].CusID);
                                //alert("sdfd");
                }
            
	}
    };
 var gCusRegDaily = {
	grid: { 
		name: 'gCusRegDaily',
		header:'<font color="white"><h4> Registration Daily </h4></font>',
                style:pstyle,
		url:'getdat_DailyRegistration.php',
		autoload:true,
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
	
		columns: [{}],
	   
	     onClick: function (event) {        
                   
		
		},
	    onDblClick: function (event) {
			CusIDDeatailform='';
			loadIDDeatailform='';
			loadTypeDeatailform='';
		 CusID = w2ui['gCusRegDaily'].get(event.recid);
		  ID=CusID.CusID;
			w2ui['layout'].show('right');
			w2ui['layout'].show('preview');
			w2ui.gDetail.header='<font color="#0080ff"><h4>Daily Detail </h4></font>';
			w2ui.gDetail.url='get_dataDetail.php?sid='+ID;
			w2ui.gSummary.clear();
			w2ui.gDetail.reload();
			
			//w2ui.layout.content('right',$().w2grid(gSummary.grid));
			//w2ui.layout.content('preview',$().w2grid(gDetail.grid));
			//w2ui.gDetail.url='get_dataDetail.php?sid='+ID;
			
//		    event.onComplete = function () {
//			  
//			
//		   };
		},
            
	}
	   
	
    };

 var gCusRegMonthly = {
	grid: { 
		name: 'gCusRegMonthly',
		//header:'<font color="white"><h4> Registration Monthly </h4></font>',
                style:pstyle,
		//url:'getdata_Customer.php',
		autoload:true,
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
	
		columns: [{}],
	    
	     onClick: function (event) {        
                   
		     // w2ui.layout.content('right', w2ui.gSummary);
		       

		}
            
	}
	   
	
    };
var gCusList = {
	grid: { 
		name: 'gCusList',
                style:pstyle,
		header:'<font color="white"><h4> Customer List </h4></font>',
		url:'getdata_Customer.php',
		//autoload:true,
		show: {
			header:true,
			toolbar:true,
			footer:true,
			toolbarAdd:true,
                        toolbarEdit:true,
			toolbarDelete:true,
			toolbarSave:true,
                        toolbarSearch  : true
		},
		multiSearch: true,
	
		columns: [{}],
	   
	        onClick: function (event) {        
                   
		    
		},
		
		onAdd: function(event)
		{
		  //  openPopup('Customer List',w2ui.layout,w2ui.fCusList,450,500);
		}
	}
    };
var fCusList = {
	form: {
	    name:'fCusList',

	     fields: [

			{ name: 'CusName',          type: 'text', required: true },
			{ name: 'CusPhoneNumber',   type: 'text', required: true },
			{ name: 'CusDescription',      type: 'text'},
			
	    ],
	actions: {
			
			'Reset': function () {
			  
				this.clear();  
			},
			
                        'Close': function () {
			    
				$().w2popup('close');
			},
	 		
			'Add': function () {
			    
                          // var html = w2ui['gCusList'].getCellHTML(0, 2);
			  // alert(html);
                               // alert(row['rows'][0].CusName);
                              w2ext.confirm(msg_SaveConfirm, function(btn) {
                                if (btn === w2ext.buttons.Yes)
                                    {
                                         var row = {rows:[]};  
                                       row['rows'][0] =  w2ui.fCusList.record;
                                         row['rows'][1] =  w2ui.fCusList.get(w2ui.gCusRegWeekly.getSelection());
                                         alert(row['rows'][1].CusID);
                                $.ajax({
                                        type: "POST",
                                        url: "dbsmMain.php?type=add&f=1",
                                        data: row,
                                        success: function(msg){
    //					    if(msg.length > 1){
    //						    w2ext.alertIcon = w2ext.icons.error;
    //							    w2ext.alert("Error: " + msg);
    //					    }else {
    //						w2ext.alertIcon = w2ext.icons.accept;
    //						    w2ext.alert( "追加しました。");
    //					    }
                                                w2ui.gCusList.reload();
                                        }
                                });





                                    } else
                                            {
                                                                      //  event.preventDefault();  
                                             }
			});
			    
			}
		}
    
 }
};
 var bSidebar = {
	sidebar: {
		name: 'bSidebar',
		nodes: [
		    { id: 'general', text: 'Customer Registration', group: true, expanded: true, nodes: [
		    { id: 'CusList', text: 'Customer List', img: 'icon-page' , selected: true },
		]},
		    { id: 'RegistrationLoad', text: ' Registration Load  ', group: true, expanded: true, nodes: [
		     { id: 'RegDaily', text: 'Customer ListDaily', img: 'icon-page' },
		    { id: 'RegWeekly', text: 'Customer ListWeekly', img: 'icon-page' },
		    { id: 'RegMonthly', text: 'Customer ListMonthly', img: 'icon-page' }, 
		    { id: 'RegOther', text: 'Customer ListOther', img: 'icon-page' } 
		    
		 ]},
	    
		    { id: 'general1', text: 'Operation', group: true, expanded: true, nodes: [
		    { id: 'Daily', text: 'Daily Form', img: 'icon-page' },
		    { id: 'Weekly',text:'Weekly Load', img: 'icon-page' },
		    { id: 'html1', text: 'Some HTML1', img: 'icon-page' }
		    
		 ]}
	],
		
                onClick: function (event) {
			switch (event.target) {
			    case 'CusList':
				w2ui.layout.content('main', w2ui.gCusList);
				w2ui['layout'].hide('right');
				w2ui['layout'].hide('preview');

				break;
			    case 'RegDaily':
				w2ui['layout'].hide('right');
				w2ui['layout'].hide('preview');
				w2ui.layout.content('main', w2ui.gCusRegDaily);
				//w2ui.layout.content('preview',$().w2grid(gDetail.grid));
				

				break;
			    case 'RegWeekly':
				w2ui['layout'].hide('right');
				w2ui['layout'].hide('preview');
				w2ui.layout.content('main', w2ui.gCusRegWeekly);
				//w2ui.layout.content('preview',$().w2grid(gDailyDetail.grid));
				
				break;
			    case 'RegMonthly':
				w2ui['layout'].hide('right');
				w2ui.layout.content('main', w2ui.gCusRegMonthly);
				w2ui['layout'].hide('preview');
			    


				break;
			}
	    }              
	}
};



$(function () {
    $('#main').w2layout(mainf.layout);
  
	
	
	w2ui.layout.content('main',$().w2grid(gCusList.grid));
	w2ui.layout.content('main',$().w2grid(gCusRegDaily.grid));
	w2ui.layout.content('main',$().w2grid(gCusRegWeekly.grid));
	w2ui.layout.content('main',$().w2grid(gCusRegMonthly.grid));
	
	
	//w2ui.layout.content('main',$().w2grid(gLoadForm.grid));
	

	
	w2ui.layout.content('left',$().w2sidebar(bSidebar.sidebar));
	
	//w2ui.layout.content('preview',$().w2grid(gDailyDetail.grid));
	w2ui.layout.content('right',$().w2grid(gSummary.grid));
	//w2ui.layout.content('right',$().w2grid(gDailySummary.grid));
	
	// Detail 
	// w2ui.layout.content('preview',$().w2grid(gDailyDetail.grid));
	w2ui.layout.content('preview',$().w2grid(gDetail.grid));
	
	 //$().w2layout(layout);
	 $().w2form(fCusList.form);
	// $().w2grid(gDailyDetail.grid);
	
	  
});
$(window).resize(function() {
	var wheight=$(window).height()-15;
	$("#layout").css("height",wheight);
});

function openPopup(title,lobj,fobj,h,w) {
	var winh=h || 400;
	var winw=w || 600;
	
	w2popup.open({
		title 	: title,
		width	: winw,
		height	: winh,
		showMax : true,
		body 	: '<div id="main" style="position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;"></div>',
		onOpen  : function (event) {
			event.onComplete = function () {
				$('#w2ui-popup #main').w2render(lobj);
				lobj.content('main', fobj);
			};
		},
		onMax : function (event) { 
			event.onComplete = function () {
				//w2ui.mainf.resize();
				//w2ui.frmContent.resize();
			};
		},
		onMin : function (event) {
			event.onComplete = function () {
				//w2ui.mainf.resize();
				//w2ui.frmContent.resize();
			};
		}
	});
};
var w2ext = {
	btn: '',
	alertIcon: null,
	buttons: {
		Yes	: 'Yes',
		No	: 'No',
		Ok	: 'Ok'
	},
	alert: function(msg, title, callBack) {
		if (typeof callBack === 'undefined' && typeof title === 'function') {
			callBack = title;
			title = w2utils.lang('Notification');
		}
		if (typeof title === 'undefined') {
			title = w2utils.lang('Notification');
		}
		w2ext.btn = '';
		var imgicon = (w2ext.alertIcon) ? w2ext.alertIcon : w2ext.icons.exclamation;
		if ($('#w2ui-popup').length > 0) {
			w2popup.message({
				width	: 400,
				height	: 150,
				html:   '<div style="position: absolute; top: 12px; left: 0px; right: 0px; bottom: 40px; overflow: auto">'+
						'	<div class="w2ui-centered">'+
						'		<div style="font-size:13px;"><img src="'+ imgicon +'" align="middle" style="position:relative;top:-7px;left:-13px;">'+ this.Return2Br(msg) +'</div>'+
						'	</div>'+
						'</div>'+
						'<div style="position: absolute; bottom: 7px; left: 0px; right: 0px; text-align: center; padding: 5px">'+
						'   <input type="button" id="'+ w2ext.buttons.Ok +'" value="OK" onclick="w2popup.message();" class="w2ui-popup-button">'+
						'</div>',
				onOpen: function () {
					var btns = $('#w2ui-popup .w2ui-popup-message .w2ui-popup-button');
					btns.on('click', function () {
						w2popup.message();
					});
					btns.on('blur', function(){
						var bt2 = $('#w2ui-popup .w2ui-popup-message .w2ui-popup-button');
						for (var i=0;i<bt2.length;i++) {
							if (bt2[i].id === w2ext.buttons.Ok) {
								setTimeout(function() {
									$(bt2[i]).focus();
								}, 0);
								break;
							}
						}
					});
					btns.on('keydown', function(event) {
						event.preventDefault();
						switch (event.keyCode) {
							case 13: // enter
								w2popup.message();
								break;
						}
					});
					for (var i=0;i<btns.length;i++) {
						if (btns[i].id === w2ext.buttons.Ok) { $(btns[i]).focus(); break;}
					}
				},
				onClose : function () {
					if (typeof callBack === 'function') { callBack(); }
				}
		});
	} else {
			w2popup.open({
				width	: 450,
				height	: 200,
				showMax	: false,
				modal	: true,
				title	: title,
				speed	: 0.2,
				body:	'<div class="w2ui-centered">'+
						'	<div style="font-size:13px;"><img src="'+ imgicon +'" align="middle" style="position:relative;top:-7px;left:-13px;">'+ this.Return2Br(msg) +'</div>'+
						'</div>',
				buttons:'<input type="button" id="'+ w2ext.buttons.Ok +'" value="OK" class="w2ui-popup-button">',
				onOpen: function (event) {
					event.onComplete = function () {
						var btns = $('#w2ui-popup .w2ui-popup-button');
						btns.on('click', function () {
							w2popup.close();
						});
						btns.on('blur', function(){
							var bt2 = $('#w2ui-popup .w2ui-popup-button');
							for (var i=0;i<bt2.length;i++) {
								if (bt2[i].id === w2ext.buttons.Ok) {
									setTimeout(function(){
									   $(bt2[i]).focus();
									}, 0);
									break;
								}
							}
						});
						btns.on('keydown', function(event) {
							event.preventDefault();
							switch (event.keyCode) {
								case 13: // enter
									w2popup.close();
									break;
							}
						});
						for (var i=0;i<btns.length;i++) {
							if (btns[i].id === w2ext.buttons.Ok) { $(btns[i]).focus(); break;}
						}
					};
				},
				onClose : function (event) {
					event.onComplete = function() {
						if (typeof callBack === 'function') { callBack(); }
					};
				}
			});
		}
	},
	confirm : function (msg, title, callBack) {
		if (typeof callBack === 'undefined' && typeof title === 'function') {
			callBack = title;
			title = w2utils.lang('Confirmation');
		}
		if (typeof title === 'undefined') {
			title = w2utils.lang('Confirmation');
		}
		w2ext.btn = '';
		if ($('#w2ui-popup').length > 0) {
			w2popup.message({
				width	: 400,
				height	: 150,
				html:	'<div style="position:absolute;top:12px;left:0px;right:0px;bottom:40px;overflow:auto;">'+
						'	<div class="w2ui-centered">'+
						'		<div style="font-size:13px;"><img src="'+ w2ext.icons.question +'" align="middle" style="position:relative;top:-7px;left:-13px;">'+ this.Return2Br(msg) +'</div>'+
						'	</div>'+
						'</div>'+
						'<div style="position: absolute; bottom: 7px; left: 0px; right: 0px; text-align: center; padding: 5px">'+
						'   <input id="'+ w2ext.buttons.No +'" type="button" value="'+ w2utils.lang(w2ext.buttons.No) +'" class="w2ui-popup-button">'+
						'   <input id="'+ w2ext.buttons.Yes +'" type="button" value="'+ w2utils.lang(w2ext.buttons.Yes) +'" class="w2ui-popup-button">'+
						'</div>',
				onOpen: function () {
					var btns = $('#w2ui-popup .w2ui-popup-message .w2ui-popup-button');
					btns.on('click', function (event) {
						w2ext.btn = event.target.id;
						w2popup.message();
					});
					btns.on('blur', function(event){
						var bt2 = $('#w2ui-popup .w2ui-popup-message .w2ui-popup-button');
						var next = (event.target.id === w2ext.buttons.Yes) ? w2ext.buttons.No : w2ext.buttons.Yes;
						for (var i=0;i<bt2.length;i++) {
							if (bt2[i].id === next) { $(bt2[i]).focus(); event.preventDefault(); break;}
						}
					});
					btns.on('keydown', function(event) {
						event.preventDefault();
						switch (event.keyCode) {
							case 9: // tab
								$(event.target).blur();
								break;
							case 13: // enter
								$(event.target).click();
								break;
						}
					});
					for (var i=0;i<btns.length;i++) {
						if (btns[i].id === w2ext.buttons.Yes) { $(btns[i]).focus(); break;}
					}
				},
				onClose: function() {
					if (typeof callBack === 'function') { callBack(w2ext.btn); }
					w2ext.btn = '';
				}
			});
		} else {
			w2popup.open({
				width		: 450,
				height		: 200,
				title		: title,
				modal		: true,
				showClose	: false,
				speed		: 0.2,
				body:		'<div class="w2ui-centered">'+
							'	<div style="font-size:13px;"><img src="'+ w2ext.icons.question +'" align="middle" style="position:relative;top:-7px;left:-13px;">'+ this.Return2Br(msg) +'</div>'+
							'</div>',
				buttons:	'<input id="'+ w2ext.buttons.No +'" type="button" value="'+ w2utils.lang(w2ext.buttons.No) +'" class="w2ui-popup-button">'+
							'<input id="'+ w2ext.buttons.Yes +'" type="button" value="'+ w2utils.lang(w2ext.buttons.Yes) +'" class="w2ui-popup-button">',
				onOpen: function (event) {
					event.onComplete = function () {
						var btns = $('#w2ui-popup .w2ui-popup-button');
						btns.on('click', function (event) {
							w2ext.btn = event.target.id;
							w2popup.close();
						});
						btns.on('blur', function(event){
							var bt2 = $('#w2ui-popup .w2ui-popup-button');
							var next = (event.target.id === w2ext.buttons.Yes) ? w2ext.buttons.No : w2ext.buttons.Yes;
							for (var i=0;i<bt2.length;i++) {
								if (bt2[i].id === next) { $(bt2[i]).focus(); break;}
							}
						});
						btns.on('keydown', function(event) {
							event.preventDefault();
							switch (event.keyCode) {
								case 9: // tab
									$(event.target).blur();
									break;
								case 13: // enter
									$(event.target).click();
									break;
							}
						});
						for (var i=0;i<btns.length;i++) {
							if (btns[i].id === w2ext.buttons.Yes) { $(btns[i]).focus(); break;}
						}
					};
				},
				onClose: function(event) {
					event.onComplete = function() {
						if (typeof callBack === 'function') { callBack(w2ext.btn); }
						w2ext.btn = '';
					};
				}
			});
		}
	},
	Return2Br: function(html) {
		if (html === null) return html;
		switch (typeof html) {
			case 'number':
					break;
			case 'string':
					html = String(html).replace(/\n/g, "<br>");
					break;
			case 'object':
					for (var a in html) html[a] = this.Return2Br(html[a]);
					break;
		}
		return html;
	},
	icons: {
//  icons obtained from http://ec-sozai.net/
		accept: 'data:image/png;base64,'+
			'iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz'+
			'AAALEgAACxIB0t1+/AAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAABZ0RVh0'+
			'Q3JlYXRpb24gVGltZQAwMy8xNC8xMfMrQs0AAAO5SURBVEiJrZZdaFtlGMd/OUlOPtY2SQ1t1YqV'+
			'Zlvb1A5dQK0TYd4NsTVFBl6sjImFYUEUBWErYi9UJgpWyxRlIILI6FanF96osM2wyWgvuiw1plPo'+
			'apd+nX6ZtDntOV4cc3pOzpI26v8qz5PnPb/3Pe973udvm52dZRudBN7argjoA/pLFdhKwKLA0A4g'+
			'heoCzpUDU43Br3PXGEvH+GMxzmpuESk7Q8BTQ4Xop8Ef5sHadvYGI5Zn7wSmg5LzowwnBpnJpHA6'+
			'wWEHwQaCAIoCigobmyDLUOMN0dl8nD13PVQUWAhTARRVYTgxSOzWEC4RROedFm9WTob1HLTXd9HZ'+
			'fBzBJliARpgOOjP6JsmFS3g920MKlclCKNDOsYf7LcB8FM1nL4yf/tcgAK8HUlKMC+OnjemoETYE'+
			'2h5dnjyLx10+5J6q3TzT8jIAHjdcnjxLcn40//eQEQbAcGIQlwg2yzkqrUj9IV5/8msqxACgjXeJ'+
			'2vOMEvhnr25KY6QzqR0dBqMeuz9K9/53sQtOMvKSnhedkM6kuCmN5VOqvrLr6RiiozzQA9X7ONx2'+
			'Qo/tgnmmogPiM1f0WIcl50dwlAHzij6ORk6ZAPf5Wkw1TgckZn+xwpbW5hBMO1ha3fvfIeC5W4+z'+
			'8iojU9+bagQBpGzaCvtLXka4w8GwC06eCh3FK/r0XKT+EC01B/T49soEb/8U5eLvX5nG2myQkVf0'+
			'WH9xu5xVKOqCCbgn+AjPtb1BXWUjla4Aw/H3sQtOOsKv6jV/Lv/GQOwYq+uSZaKqCh7HLuvKfO4g'+
			'irJV2Bl+hd7HP6OushGAAw2HqXIFOdh4BL+7ZlsQaPdntXfrVeuwUPU+Nja2Cr9NDHD++ik2FRkA'+
			'l8PL0829HGzsBmB1XeLTq71FQQDyBjQZuoEOa6t7gpwBtqnI/DjxBe9dfB4pOw1o31SFK6Ddn9de'+
			'Yz4zVRQEkNuA1tp2E6wVoMEfptYbIiebB9xaGueDS93cXpnQc98lPiQ5d7U0SIZab4gGfzifahWA'+
			'OIBgE+ho6mE9Zx0oZaf5OPYiUnaaycUb/JA6UxIEWrvpaOox3vzx/K8+gL3BCO31XWSy1sGLazMM'+
			'/PwCX46eQFEVa4FBmazW1wzduw+K9LPPR06SkmL/ez8r2qnP3fiIK1Pny+7Uj977LNGWl7bt1CYg'+
			'aEbnm/FPzB5E0HyIomrfkdGDdDT1FBqfkh7EAsxD8+5qaW2O5fUFqlzV+NzB/+yu8tqpOS1UUbNa'+
			'6p7vR5tdXxkQWzEQwN8kyHfwFX3KEgAAAABJRU5ErkJggg==',
		exclamation: 'data:image/png;base64,'+
			'iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz'+
			'AAALEgAACxIB0t1+/AAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAABZ0RVh0'+
			'Q3JlYXRpb24gVGltZQAwMy8xNC8xMfMrQs0AAAKoSURBVEiJtZbPS1RRFMc/576ZRrOBCAYzDAyk'+
			'hdhChSAQXEj+AfoHqC0DN22kIBcKhv+Au378A7ZqEYiQIbpxbJNuDNyYvwZK0GmcZt49LV7vze83'+
			'b4i+q7nnXu7nnDnn3XMkk8nQRC+B+WaHgDlgIeyAhMDGgZUIkGpNAO9bgWnFoeMNOFxDMl8g/wOy'+
			'R9BxBxK30NQAdI+iXcM1d0eBBSA52ULSi8jFHiZukZiCgBhFrYCCFgVbMGiyDx16gd5+1BBYDfNA'+
			'6iLpV5hvbzEJi4nbetFXyBYMNm+wvdPo0HMQpwZYDiuBPs/gnH3EaXebQqrl5hzc1GN0ZLkGaP4u'+
			'xgPrzlJD0LUHz0hOZUlOZbk+9qEuzGl3cTKryM5SuXm8HLYCXo7M/muctuYR6e+fDfecNhez/xo5'+
			'2fJNK+UwL6r0IiZh69RRPdh5400Bk7BIerHCbPBzdbYdVF0U2YuD0H0Tt8jFHpxtB/4FkcnhWmRQ'+
			'VJmYRb5/Kq0D2MmW9x1FlOZD/kb/zrgiR+u1MHKniITDTPJeZGfA+/jJHteB5c+ryiVc9jI8Zx4N'+
			'KCukWPArcRPsr1Dg1eYMV5sz0T1SIJ4MlqWr2ztRjVDzLUitwI3uWph2PkSL4bCOia/BCxK//6Q5'+
			'rCgV3aAEuzuGLbSQtAiyBYN2j1bA+gFIDaDJvsjAZgXitx1SA76p3wC7AIiDDs5i841hrZS+zRt0'+
			'cLb85d/1q3EOmNeuYWzvNO7Bm7qv/sW7jkggN+d4fa2Urzlo1M/Wn+JkVv9bPwsMiIOOLOP2TFK8'+
			'jEXPYcFQvIzh9kzWBVVH5qs0gxxvIDtLFTOIiHouWlCVyhlkcLZ68AmdQWqAPjSYrnKnkMtAe8p7'+
			'CP5xuvIVdTitVsNhNSwhC3jezbUAkUYggD/OJSPPzlV+/wAAAABJRU5ErkJggg==',
		error: 'data:image/png;base64,'+
			'iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz'+
			'AAALEgAACxIB0t1+/AAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAABZ0RVh0'+
			'Q3JlYXRpb24gVGltZQAwMy8xNC8xMfMrQs0AAAOzSURBVEiJpZZPTBxVHMc/7w3LLruLTaPdbsXY'+
			'NlE8aPQgSGtigNI0Nr0YTCVkE26NaYxR0R7lYI8C0igxjYfGEDSaYLySSGAltl2QUo0X0It/SmFG'+
			'00JZlmWYeR7orPP2sRTi9/Z+8+b3eb8333nvJxzH4QF6H/jgQZOAHuDiThPEDrB2YGQXkHK9Cnyz'+
			'F5gKD25dv8bv2XHsn39i/c4dVhdvk0wfIrZ/P6lnn+Nwcyt1x44buXcDK4EWpnPk+nu5Nz9HVAoi'+
			'QiAQWAI8BQqFqxRFX1Fb/xRN3e/xaGNTRWA5TAEo3yfX/yHzXw5TIyVRaSzSUNFXFHyf+s4MTd0X'+
			'EFIawDCsBBq70M1SdpykJc292EEKWPV8Ui81c7JvwAAGo/YgOjXQx1J2nNo9goKMtZbEnswyNdAX'+
			'ftQeho3A1jeaGx4iaUk9iWURiSe2BVixGMKytFjSkswND7EwnQtCI2EYALn+XmqkXpGwLFovDXLq'+
			'ypABtGIxXv78C1ovDWpAAdRISa6/V5svuf+tFm/eYOW+68pBR06f4WBDowYMQAcbGjly+owBjErB'+
			'yvwcizdvBCFVquyP7IThuqpojHg6XRoHwJoDB0qgQPF0mqpoTHs/KgV/Tn6vVQbAwlSOaqHD3LU8'+
			'o10Z7NkZDfjaxFUNZM/OMNqVwV3La+9XC8FfV38wYXnbRgrTfwFw6cfpUsyK/VdBJRCAFILVxdsm'+
			'rLiyXNHq7lqesfPn8NbXtbi3vs7Y+XPbgoLkxeVlExZ9aJ9+IIZkxWK0ffqZVlEQP/HJ5Yq/hQKq'+
			'k0kTlkil8JWJC7suXFGgcpeG5SlFbd1jJuzQ8w1slMEi8YQBsmdn+LrlRcM02wE3lNJugxLs8Ik2'+
			'ir4O89wNCo6tgUa7MhQcx3BpwbHx3A3t/aKveLy5pTQWjuM8DfyifJ9vMx1s/var9r/JSISWjz4m'+
			'nk4brovEE5y6MkTBsZl4501819VAVU88ySvDXwUH8jPBqa9g65Ice+N19lVZmjNlJIIVqd7WdZF4'+
			'As/d0EAKWN70aBu8HN5GEWxjD0DdsePUd2ZY9Xwtoe+6Fe3truU1EGxdM/WdmTCoJ9jG8IJQvs93'+
			'776NPZmltuz0343u7eI+KwWElJzsG+Do2Q7ubnqGaSqp6CvubnocPduxLai8skCl7LeuX2PqUr/W'+
			'g0ghkIAP+ErvQV54q7u88dmxBzGAATTorvK2TeGfv6l5+BESqdT/7q4C7bY5LVfFZnUnB1xka3U9'+
			'e4CISiCAfwHJg65g4mpiKQAAAABJRU5ErkJggg==',
		question: 'data:image/png;base64,'+
			'iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz'+
			'AAALEgAACxIB0t1+/AAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAABZ0RVh0'+
			'Q3JlYXRpb24gVGltZQAwMy8xNC8xMfMrQs0AAANCSURBVEiJrZbNbxNHGIefmXXiOHEajIMtFKIC'+
			'iapUQZhU4kIrLhE5V66qtJXyB3DoDbg1quDWcqv6FyARQCLihgTlAmouPSQrFIGiElRFbonzYYId'+
			'25tkZ3pwd+3x+iuF32n21cw+85uv9xUbGxu00Q/A9XadgFngRqsOogUsDdzvAFKvr4D5w8B07cfy'+
			'epnFTJE/txzyjmKreEC8N0R/WDIaDzMx1Mt4sifw705gPuhFtszcUo61d/tIIRBSAAIhQOtKV600'+
			'SmuGP+ri23MxPk0YUANYD9MASsOdpW0evyogpUTKwCQDUkqjlOLSSJRvzh2lZojfqoX5oF8XNlh8'+
			'U8ayZFtIvVxXkUqG+f7zRADo/S3tRe/Zuf8NArAsib3ucM/O1YbTUHWmobJHPz3NEgpZgZ+MDEZI'+
			'pxJcOHXEj9mZPI9ebrPw+m2g/8GBy7WLido9FMb055ZySBl0NDIY4eaXnxgggNRQP1cnP2ZqLB4Y'+
			'I6VkbilnxjxXK5sOazv7DQ/D1cmTfrvguNz64x/sTN6PzZw/TjRsroaUgrWdfVY2HS+kfRuLmWJD'+
			'ULK/m2R/t/995cEK83aWHx+usp7fAyAatujrDi69lAL775L/HfIaL7Ll/+6Rqd29ihPPlQeYGosb'+
			'k9jdcwNjhRQ8f1Pi67NHTFiu5CKCl56C4zJvZ43Y5S9OGPu08PotBacBTAi2igdVp9WZqQYPTFDp'+
			'VMIA2Zk8Pz/5q2n/3T3lt31nfd2SoktbYO2JnLez/hI3U6Srerr9Vixioc33t6G8U/dqs9QWpLXm'+
			'WJ/vp+ps7FgPa+8KCKu1tUcvtwAa7lEAprSRDXxnn53oRan2zqbG4sycP86FUwNt+yqlmRjqNWBn'+
			'AEbjYYYHujoCdiKlNMMDXYzGw17oTAhYBpACplMxbj7LImXwgnrqdBmVUkynBmtf/mVvz2aB6+PJ'+
			'Hi6NRPltdbfpq19/5xrJdSt5rWa/ZqFJPvvl9yz2uvPB81nTTH17cZsnq4fP1JOno3w30T5TG0Co'+
			'FDp3bbMGEYjKcA26rgaZTsXqC5+WNUgA6EG96ipXctkpuwz0WMQi1ntXV546LU7r1bRYbXUCblCZ'+
			'3ewhIKIZCOBfhDxozvp/VHsAAAAASUVORK5CYII='
	}
	

};
 
 function func_save (){
     var row = {rows:[]};
	row['rows'][0]=w2ui.fCusList.record;
	$.ajax({
		type: "POST",
		url: "dbsmMain.php?type=add&f="+no,
		data: row,
		success: function(msg){
			if(msg.length > 1){
				w2ext.alertIcon = w2ext.icons.error;
					w2ext.alert("Error: " + msg);
			}else {
                            w2ext.alertIcon = w2ext.icons.accept;
				w2ext.alert( "追加しました。");
			}
			w2ui.gCusList.reload();
		}
	});
 }

 function func_outputCheckBoxContent(){
   
           w2ui.gCusList.on('click', function(event) {
	      // alert('hello');
			obj = w2ui.gCusList;
			
			var HT= w2ui.gCusList.columns[event.column].field;
//			var r = w2ui.gCusList.get(event.recid) ;
//			var recid = w2ui.gCusList.getSelection();
			var row = {rows:[]};
			var record = w2ui['gCusList'].get(event.recid);
			//alert(HT);
			   row['CusID']=record.CusID;
			   row['COtherType']=HT;
			   row['OtherType']=record.OtherType;
			   row['Daily']=record.Daily;
			   row['Weekly']=record.Weekly;
			   row['Monthly']=record.Monthly;
			   
			   row['TypeOther']=record.TypeOther;
			   row['TypeDaily']=record.TypeDaily;
			   row['TypeWeekly']=record.TypeWeekly;
			   row['TypeMonthly']=record.TypeMonthly;
			//}
//			
			$.ajax({
				type: "POST",
				url: "dbs_Main.php?type=save&f=0",
				data: row,
				success: function (data) {
				if (data!=''){
				    alert(data);
					
				}
			    }
			});
			
	
	  w2ui.gCusList.off('click');
	   w2ui.gCusList.reload();
	    
	});  
	
 }
function func_passParam (){
     var row = {rows:[]};
	
	 row['CusID']=CusID.CusID;
	$.ajax({
		type: "POST",
		url: "get_dataDetail.php?type=ParamID&f=0",
		data: row,
		
		success: function(msg){
		
    
		}
	});
    
}
function func_DeleteTransection (){
    
    alert('hello');
}

function printExternal(str) {
printWindow = window.open(str);
setTimeout('printWindow.print()', 2000);
setTimeout('printWindow.close()', 2000);
}
</script>

</body>
</html>