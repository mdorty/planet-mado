<?php
/**
 ** This has been coded and developed for Matthew Dougherty and PlanetMado.com.
 ** Any unauthorized use of this code is prohibited.
 **/
require_once('config.php');

//Prevent MySQL Injection
$username	= $_POST['myusername']; 
$password	= $_POST['mypassword'];

$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

if($username=="admin" && $password=="1990dougherty")
{
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	header("location:http://www.planetmado.com/sal/admin.php");
	exit;
}

$query	= "SELECT * FROM members WHERE username='$username' AND password='$password'";
$result	= mysql_query($query);

$count=mysql_num_rows($result);

if($count == 1){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	header("location:http://www.planetmado.com/index.php?pageid=stats");
}else
	header("location:http://www.planetmado.com/index.php?pageid=wrongpass");
?>