<?
/**
 ** This has been coded and developed for Matthew Dougherty and PlanetMado.com.
 ** Any unauthorized use of this code is prohibited.
 **/
require_once('config.php');
session_start();
//Load data from session variable
$userdata = $_SESSION['userdata'];
//Store session variables into local variables
$username = $userdata['username'];
$password = $userdata['password'];
$currentpl = $userdata['currentpl'];
$totalpl = $userdata['totalpl'];
$sensu = $userdata['sensu'];
//Check that player has sensu beans
if($sensu == 0){
	header("location:http://www.planetmado.com/index.php?pageid=stats");
	exit;
}

//deduct a sensu bean and set current power level to total power level
$sensu--;
$currentpl = $totalpl;

$query = "UPDATE members SET currentpl='$currentpl',sensu='$sensu',dead='',maxpl='' WHERE username='$username' AND password='$password'";
mysql_query($query);
header("location:http://www.planetmado.com/index.php?pageid=stats");
?>