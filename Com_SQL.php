<?php
function getdata_Customer(){
     $sql ='';
    $sql.= 'Select CusID, CusName,  CusPhoneNumber, CusDescription, CusDateIssus, OtherType , Daily, Weekly, Monthly, TypeOther, TypeDaily, TypeWeekly,TypeMonthly from tblcustomer ';
     return $sql;
}

function getdata_RgistrationDaily(){
     $sql ='';
    $sql.= 'Select CusID, CusName,  CusPhoneNumber, CusDescription, CusDateIssus, OtherType , Daily, Weekly, Monthly from tblcustomer where  Daily = 1  ';
     return $sql;
}

function getdata_RgistrationWeekly(){
     $sql ='';
    $sql.= 'Select CusID, CusName,  CusPhoneNumber, CusDescription, CusDateIssus, OtherType , Daily, Weekly, Monthly from tblcustomer where  Weekly = 1  ';
     return $sql;
}
function getdata_Detail($cusID){
     $sql ='';
    $sql.= 'Select LoadID, CusID, CusName, CusAmount, CusAmountPerDay, CusAmountDay, CusProfit, LoadType, CusLoadIssusDate from tblCusLoadDetail where  LoadType= 2  AND CusID = "'.$cusID.'" ';
     return $sql;
}

function getdata_WeeklyDetail($cusID){
     $sql ='';
    $sql.= 'Select LoadID, CusID, CusName, CusAmount, CusAmountPerDay, CusAmountDay, CusProfit, LoadType, CusLoadIssusDate from tblCusLoadDetail where LoadType=3 AND CusID = "'.$cusID.'" ';
     return $sql;
}
function getdata_Summary(){
    $sql='';
    $sql.='SELECT ';
    $sql.='sumaryID ,';
    $sql.='LoadID ,';
    $sql.='CusID ,';
    $sql.='CusName ,';
    $sql.='CusAmountPerDay ,';
    $sql.='CusAmountDay ,';
    $sql.='LoadType ,';
    $sql.='Description ,';
    $sql.='StartDate ,';
    $sql.='EndDate ,';
    $sql.='Status ,';
    $sql.='(select sum(CusAmountPerDay)  from tblCusSummary where CusID = 001 and LoadID = 02 and LoadType = 2) AS CurrentTotal ';
   // $sql.='(select sum(CusAmountPerDay)  from tblCusSummary where CusID= '.$CusID.' and LoadID = '.$LoadID.' and LoadType = '.$loadType.') AS CurrentTotal ';
    $sql.='FROM ';
    $sql.='tblCusSummary ';
    return $sql;
}
function getdata_ViewSummary($LoadID,$CusID,$LoadType){
    $sql='';
    $sql.='SELECT ';
    $sql.='sumaryID ,';
    $sql.='LoadID ,';
    $sql.='CusID ,';
    $sql.='CusName ,';
    $sql.='CusAmountPerDay ,';
    $sql.='CusAmount ,';
    $sql.='CusAmountDay ,';
    $sql.='LoadType ,';
    $sql.='Description ,';
    $sql.='StartDate ,';
    $sql.='EndDate ,';
    $sql.='Status, ';
   
    // $sql.='(select sum(CusAmountPerDay)  from viewSummaryDetail where LoadID= "'.$LoadID.'"   AND CusID = "'.$CusID.'"   AND LoadType = "'.$LoadType.'"  ) AS CurrentTotal , ';
    $sql.='(select sum(CusAmountPerDay)  from viewSummaryDetail where LoadID= "'.$LoadID.'"   AND CusID = "'.$CusID.'"   AND LoadType = "'.$LoadType.'"  ) AS CurrentTotal , ';
     $sql.='(SELECT CusAmount FROM tblCusLoadDetail  where LoadID= "'.$LoadID.'"   AND CusID = "'.$CusID.'"   AND LoadType = "'.$LoadType.'" )  -(select sum(CusAmountPerDay)  from viewSummaryDetail where LoadID= "'.$LoadID.'"   AND CusID = "'.$CusID.'"   AND LoadType = "'.$LoadType.'"  ) AS RemainTotal  , ';
    $sql.='(select count(Status) from viewSummaryDetail where Status=1 AND LoadID= "'.$LoadID.'"   AND CusID = "'.$CusID.'"   AND LoadType = "'.$LoadType.'"  ) AS TotalPaid , ';
    $sql.='(select count(Status) from viewSummaryDetail where Status=0 AND LoadID= "'.$LoadID.'"   AND CusID = "'.$CusID.'"   AND LoadType = "'.$LoadType.'"  ) AS TotalUnPaid ';
    $sql.='FROM ';
    $sql.='viewSummaryDetail  ';
    $sql.='where  ';
    $sql.='LoadID = "'.$LoadID.'"  ';
      $sql.='AND  ';
    $sql.='CusID = "'.$CusID.'"  ';
     $sql.='AND  ';
    $sql.='LoadType = "'.$LoadType.'"  ';
    return $sql;
}
function  Getdata_rptSummary($CusID,$LoadID,$LoadType){
    $sql='';
    $sql.='SELECT * FROM viewSummaryDetail where CusID="'.$CusID.'" AND LoadID="'.$LoadID.'" AND LoadType="'.$LoadType.'" ';
    return $sql;
}



?>
