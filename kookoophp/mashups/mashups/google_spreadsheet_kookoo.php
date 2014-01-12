<?php
 
// Zend library include path. Make sure this is in the same directory
set_include_path("ZendGdata-1.11.11/library");
//Make sure this is path     
include_once("farinspace-google-spreadsheet-0a21310/Google_Spreadsheet.php");
 
$u = "{gmail username}";
$p = "{gmail password}";
 
$ss = new Google_Spreadsheet($u,$p);
$ss->useSpreadsheet("IPL");
 
// if not setting worksheet, "Sheet1" is assumed
// $ss->useWorksheet("worksheetName");
 
$row = array
(
    "caller_id" => $_REQUEST['cid']
    , "selection" => "{some data}" 
);
 
if ($ss->addRow($row)) echo "Form data successfully stored using Google Spreadsheet";
else echo "Error, unable to store spreadsheet data";
 
?>
