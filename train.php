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

//Just in case an Andoid or someone who already trained tried to access this page.

//To Test training, comment out these lines.
if($userdata['race'] == "Android" || timeDiff($userdata['train']) < 6){
	header("location:http://www.planetmado.com/index.php?pageid=stats");
	exit;
}

//Base powerlevel tree
if ($totalpl < 2000)
	$trainbonus = 20;
elseif (2000 <= $totalpl && $totalpl < 4000)
	$trainbonus = 30;
elseif (4000 <= $totalpl && $totalpl < 8000)
	$trainbonus = 40;
elseif (8000 <= $totalpl && $totalpl < 16000)
	$trainbonus = 80;
elseif (16000 <= $totalpl && $totalpl < 32000)
	$trainbonus = 120;
elseif (32000 <= $totalpl && $totalpl < 64000)
	$trainbonus = 200;
elseif (64000 <= $totalpl && $totalpl < 128000)
	$trainbonus = 450;
elseif (128000 <= $totalpl && $totalpl < 256000)
	$trainbonus = 750;
elseif (256000 <= $totalpl && $totalpl < 512000)
	$trainbonus = 1200;
elseif (512000 <= $totalpl && $totalpl < 1024000)
	$trainbonus = 2000;
elseif (1024000 <= $totalpl && $totalpl < 2048000)
	$trainbonus = 3500;
elseif (2048000 <= $totalpl && $totalpl < 4096000)
	$trainbonus = 6000;
elseif (4096000 <= $totalpl && $totalpl < 8192000)
	$trainbonus = 8000;
elseif (8192000 <= $totalpl && $totalpl < 16384000)
	$trainbonus = 10000;

//Calculate training adjustments
//Adjust for race

if($race == "Saiyan")
	$adjust = .25;
if($race == "Half Saiyan Half Human")
	$adjust = .1;
//Adjust for planet
if($planet == "Vegeta")
	$adjust += .1;

//Adjust for weighted items. Items must have commas in order to detect items
//UCwords makes sure that the word is formatted correctly
foreach ($witems as $value){
	$value = ucwords($value);
	if($value == "Shirt")
		$adjust += .03;
	if($value == "Pants")
		$adjust += .04;
	if($value == "Shoes")
		$adjust += .02;
	if($value == "Belt")
		$adjust += .02;
	if($value == "Hat")
		$adjust += .025;
	if($value == "Wrist")
		$adjust += .02;
	if($value == "Socks")
		$adjust += .015;
}
unset($value);

//Calculate training with adjustments
if($adjust > 0)
	$trainbonus = $trainbonus * $adjust + $trainbonus;
$totalpl = round($totalpl + $trainbonus);
$currentpl -= $trainbonus;

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
header("location:http://www.planetmado.com/index.php?pageid=stats");
?>