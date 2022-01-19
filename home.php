<?
/**
 ** This has been coded and developed for Matthew Dougherty and PlanetMado.com.
 ** Any unauthorized use of this code is prohibited.
 **/
require_once('config.php');
session_start();

//Make sure someone is logged in
if(!isset($_SESSION['username'])){
	header("location:http://www.planetmado.com/index.php?pageid=loginnew");
	exit;
}
//set local variables from global
$username = $_SESSION['username'];
$password = $_SESSION['password'];

//Grab info from database
$query = "SELECT * FROM members WHERE username='$username' AND password='$password'";
$result = mysql_query($query);

//make database row available to session
$userdata = mysql_fetch_array($result);
$_SESSION['userdata'] = $userdata;

//Check to see if they haven't trained in 72 hours. If they haven't then give them full life and reload.
//Comparison of PL is to prevent infinite loop.
if(	timeDiff($userdata['train']) >= 72 &&
	$userdata['currentpl'] < $userdata['totalpl'] &&
	$userdata['dead'] == '')
	{
	$fullheal = $userdata['totalpl'];
	$healquery = "UPDATE members SET currentpl='$fullheal' WHERE username='$username' AND password='$password'";
	mysql_query($healquery);
	header("location:http://www.planetmado.com/index.php?pageid=stats");
	exit;
}elseif(timeDiff($userdata['train']) >= 72 &&
		$userdata['currentpl'] < $userdata['maxpl'] &&
		$userdata['dead'] !='' &&
		$userdata['planet'] != 'The Next Dimension')
		{
	$fullheal = $userdata['maxpl'];
	$healquery = "UPDATE members SET currentpl='$fullheal' WHERE username='$username' AND password='$password'";
	mysql_query($healquery);
	header("location:http://www.planetmado.com/index.php?pageid=stats");
	exit;
}
//If you are namek, check to see if it is the next day and your meditate counter should be reset
if($userdata['race']== "Namek"){
	$currentdate = date('j');
	$lastmeditate = date('j',strtotime($userdata['meditate']));
	if($currentdate != $lastmeditate){
		$currentdate = date(DATE_RFC822);
		$meditatequery = "UPDATE members SET meditate='$currentdate',meditatecount='0' WHERE username='$username' AND password='$password'";
		mysql_query($meditatequery);
		header("location:http://www.planetmado.com/index.php?pageid=stats");
		exit;
	}
}

//load user moves into an array
$movelist = explode(",",$userdata['moves']);

//Set variables for the timer
$nexttrain = strtotime($userdata['train']) + 21600;
$currenttime = strtotime(date(DATE_RFC822));
$timediff = $nexttrain - $currenttime;
?>

<html>
<head>
	<title>Welcome!</title>

<!-- start of loading scripts -->
<link rel="stylesheet" href="http://www.planetmado.com/sal/css/general.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://www.planetmado.com/sal/js/jquery.min.js"></script>
<script language="JavaScript" src="http://www.planetmado.com/sal/js/timer.js"></script>

<script type="text/javascript">
//Set the slide down effect for moves list
	$(document).ready(function(){
	$("ul li label").click(function () { 
		$(this).next().slideToggle("fast");
		});
		});
	
	//set the timer countdown
	diff = <?echo $timediff;?>;
</script>
<!-- end scripts -->

</head>
<body>

<!-- end scripts -->
<center>
<h3>Welcome <?echo ucwords($userdata['username']);?></h3>

<!-- Display action links. Show Meditate if the person is Namek. Do not let them train if they are android. -->
<h4>
<?if($userdata['race']!='Android'):?>
<?if(timeDiff($userdata['train'])<6):?>
<span id='timer'></span>
<?else:?>
<a href="http://www.planetmado.com/sal/train.php">Self Train</a>
<?endif;?>
 &#8226; 
<?endif;?>
<?if($userdata['race']=='Namek' && $userdata['currentpl'] > 0 && $userdata['meditatecount']<3):?><a href="http://www.planetmado.com/sal/meditate.php">Meditate</a> &#8226; <?endif;?>
<?if($userdata['sensu']!=0):?><a href="http://www.planetmado.com/sal/sensu.php">Eat a Sensu Bean</a> &#8226; <?endif;?>
<a href="http://www.planetmado.com/sal/logout.php">Logout</a>
</center>
<!-- End of action links-->

</h4>


		<p><b>Race:</b>
		<?echo $userdata['race'];?>
</p>

		<p><b>Power Level:</b>
		<?echo $userdata['currentpl'];?> out of <?echo $userdata['totalpl'];?>
</p>

		<p><b>Planet:</b>
		<?echo $userdata['planet'];?>
</p>

		<p><b>Credits:</b>
		<?echo $userdata['credits'];?>
</p>

		<p><b>Email:</b>
		<?echo $userdata['email'];?>
</p>

		<p><b>Last Date Trained:</b>
		<?echo $userdata['train'];?>
</p>
	<?if($userdata['race'] == "Namek"):?>

		<p><b>Last time meditated:</b>
		<?echo $userdata['meditate'];?>
</p>

		<p><b>Times meditated today:</b>
		<?echo $userdata['meditatecount'];?>
</p>
	<?endif;?>

		<p><b>People you have been to:</b>
		<?echo $userdata['people'];?>
</p>

		<p><b>Sensu Beans:</b>
		<?echo $userdata['sensu'];?>
</p>

		<p><b>Items:</b>
		<?echo $userdata['items'];?>
</p>

		<p><b>Weighted Items:</b>
		<?echo $userdata['weighted'];?>
</p>

		<p><b>Died:</b>
		<?echo $userdata['dead'];?>
</p>

		<p><b>Job(s):</b>
		<?echo $userdata['jobs'];?>
</p>

		<p><b>Alignment:</b>
		<?echo $userdata['alignment'];?>
</p>

		<p><b>Description:</b>
		<?echo $userdata['description'];?>
</p>

		<p><b>Techniques:</b></p>
		<ul>
		<?	//This loads up all the moves from a database table
			foreach ($movelist as $move){
			$movequery = "SELECT * FROM moves WHERE name='$move'";
			$moverow = mysql_fetch_array(mysql_query($movequery));
			echo "<li><label><b>".$moverow['name']."</b></label><span>".$moverow['description']."</span></li>";
			}
			?>
		</ul>

</body>

</html>