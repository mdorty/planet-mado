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
$currentpl = $userdata['currentpl'];
$totalpl = $userdata['totalpl'];
$race = $userdata['race'];
$username = $userdata['username'];
$password = $userdata['password'];
$meditatecount = $userdata['meditatecount'];
$trainbonus = 0;

//Just in case a non-Namek or dead Namek made it to this page.
//Check to see that the person doesn't meditate more than 3 times in 1 day.
if( $userdata['race'] != "Namek" || $currentpl <= 0 || $meditatecount >= 3 ){
	header("location:http://www.planetmado.com/index.php?pageid=stats");
	exit;
}

//Base powerlevel tree
if ($totalpl < 10000)
	$trainbonus = .02;
elseif (10000 <= $totalpl && $totalpl < 100000)
	$trainbonus = .01;
elseif (100000 <= $totalpl && $totalpl < 300000)
	$trainbonus = .005;
elseif (300000 <= $totalpl && $totalpl < 800000)
	$trainbonus = .0025;
elseif ($totalpl >= 800000)
	$trainbonus = .001;

//Calculate training adjustments
$adjust = round($totalpl * $trainbonus);
$totalpl = round($totalpl + $adjust);
$currentpl += $adjust;
//Generate meditate date and +1 to count
$meditatedate = date(DATE_RFC822);
$meditatecount++;

//Update database
$query = "UPDATE members SET currentpl='$currentpl',totalpl='$totalpl',meditate='$meditatedate',meditatecount='$meditatecount' WHERE username='$username' AND password='$password'";
mysql_query($query);
header("location:http://www.planetmado.com/index.php?pageid=stats");
?>