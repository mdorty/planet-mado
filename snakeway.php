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
$planet = $userdata['planet'];
$witems = explode(',',$userdata['weighted']);
$username = $userdata['username'];
$password = $userdata['password'];
$trainbonus = 0;
$gravity = $userdata['gravity'];
$snakewaycount = $userdata['snakewaycount'];

//Just in case an Andoid or someone who already trained tried to access this page.

//To Test training, comment out these lines.
if($userdata['race'] == "Android" || timeDiff($userdata['train']) < 6 || $userdata['currentpl'] == 0){
	header("location:home.php");
	exit;
}

//Base powerlevel tree

	$trainbonus = .01;

//Calculate training adjustments
//Adjust for race

if($race == "Saiyan")
	$adjust = .25;
if($race == "Half Saiyan Half Human")
	$adjust = .1;



//Calculate training with adjustments
if($adjust > 0) {
	$trainbonus = ($trainbonus * $totalpl);
	$trainbonus = ($trainbonus * $adjust);
	$totalpl = round($trainbonus + $totalpl);
	$currentpl = round($trainbonus - $currentpl);
}
$totalpl = round($totalpl + ($trainbonus * $totalpl));
$currentpl = round($currentpl - ($trainbonus * $totalpl));

//If they died, record it.
if($currentpl <= 0){
	$deaddate = date(DATE_RFC822);
	$dead = true;
	$currentpl = 0;
	$maxpl = round($totalpl/2);
}
//Generate training date
$traindate = date(DATE_RFC822);
//Update database
if($dead)
	$query = "UPDATE members SET currentpl='$currentpl',totalpl='$totalpl',planet='Snake Way',dead='$deaddate',train='$traindate' WHERE username='$username' AND password='$password'";
else
	$query = "UPDATE members SET currentpl='$currentpl',totalpl='$totalpl',train='$traindate' WHERE username='$username' AND password='$password'";

mysql_query($query);
header("location:home.php");
?>