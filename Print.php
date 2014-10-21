
<link rel="stylesheet" type="text/css" href="css/button.css" />
<input type='button' class="myButton" value='print' onclick="printExternal('http://localhost/wu2ui1.4/getdata_report.php')">
<?php
//this function to get the files

//$strpage=array("index.php","BMW","Toyota");
//$arraylenght=count($strpage);
//for($i=0;$i<$arraylenght;$i++) {
//    echo "<br>";
//   echo $strpage[$i];
//   echo "<br>";
//}

?>

<script type="text/javascript" >
function printExternal(str) {
printWindow = window.open(str,"mywindow");
setTimeout('printWindow.print()', 2000);
setTimeout('printWindow.close()', 2000);
}
</script>

