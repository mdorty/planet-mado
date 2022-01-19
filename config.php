<?
/**
 ** This has been coded and developed for Matthew Dougherty and PlanetMado.com.
 ** Any unauthorized use of this code is prohibited.
 **/
date_default_timezone_set('America/Los_Angeles');

$dbhostname="localhost";
$dbusername="planetm6_auto";
$dbpassword="";
$database="planetm6_autoupdate";

mysql_connect("$dbhostname", "$dbusername", "$dbpassword") or die("cannot connect to server"); 
mysql_select_db("$database") or die("Cannot select DB");


//Get the time difference from input time to now
function timeDiff($date){
//set current time
$currdate = strtotime(date(DATE_RFC822));
//get comparison time
$startdate = strtotime($date);
//Convert to hours. Time is in decimal format.
$diff = (($currdate - $startdate)/60)/60;
return $diff;
}
?>
