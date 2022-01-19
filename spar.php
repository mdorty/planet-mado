<?
/**
 ** This has been coded and developed for Matthew Dougherty and PlanetMado.com.
 ** Any unauthorized use of this code is prohibited.
 **/
require_once('config.php');
session_start();

if($_SESSION['username'] != "Mado" && $_SESSION['password'] != "aidenscott"){
	header("location:http://www.planetmado.com/index.php?pageid=wrongpass");
	exit;
}

//Grab users and load them into the dropdown menu
$query = "SELECT username FROM members";
$result = mysql_query($query);
$options="";

//Loop to load dropdown
while ($row=mysql_fetch_array($result)) { 
    $name=$row["username"]; 
    $options.="<option value=\"$name\">".$name."</option>"; 
}

//If a user was selected from the dropdown, fill in their info
if(isset($_POST['select']) && $_POST['user'] != "create"){
	$auser = $_POST['user'];
	$userquery = "SELECT * FROM members WHERE username='$auser'";
	$userdata = mysql_fetch_array(mysql_query($userquery));
	unset($_POST['select']);
}

//If the admin selected save, update the database
if(isset($_POST['save'])){

$username = $_POST['username'];
$password = $_POST['password'];
$race = $_POST['race'];
$currentpl = $_POST['currentpl'];
$maxpl = $_POST['maxpl'];
$totalpl = $_POST['totalpl'];
$planet = $_POST['planet'];
$snakewaycount = $_POST['snakewaycount'];
$gravity = $_POST['gravity'];
$credits = $_POST['credits'];
$email = $_POST['email'];
$train = $_POST['train'];
$meditate = $_POST['meditate'];
$meditatecount = $_POST['meditatecount'];
$people = $_POST['people'];
$sensu = $_POST['sensu'];
$items = $_POST['items'];
$weighted = $_POST['weighted'];
$dead = $_POST['dead'];
$jobs = $_POST['jobs'];
$alignment = $_POST['alignment'];
$description = $_POST['description'];
$moves = $_POST['moves'];
$notes = $_POST['notes'];
	
	$updatequery = "UPDATE members SET password='$password',race='$race',currentpl='$currentpl',maxpl='$maxpl',totalpl='$totalpl',planet='$planet',snakewaycount='$snakewaycount',gravity='$gravity',credits='$credits',email='$email',train='$train',meditate='$meditate',meditatecount='$meditatecount',people='$people',sensu='$sensu',items='$items',weighted='$weighted',dead='$dead',jobs='$jobs',alignment='$alignment',description='$description',moves='$moves',notes='$notes' WHERE username='$username'";
mysql_query($updatequery);

unset($_POST['save']);
}


//If create button was pressed
if(isset($_POST['create']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$race = $_POST['race'];
	$currentpl = $_POST['currentpl'];
	$totalpl = $_POST['totalpl'];
	$planet = $_POST['planet'];
	$credits = $_POST['credits'];
	$email = $_POST['email'];
	$train = $_POST['train'];
	$meditate = $_POST['meditate'];
	$meditatecount = $_POST['meditatecount'];
	$people = $_POST['people'];
	$sensu = $_POST['sensu'];
	$items = $_POST['items'];
	$weighted = $_POST['weighted'];
	$dead = $_POST['dead'];
	$jobs = $_POST['jobs'];
	$alignment = $_POST['alignment'];
	$description = $_POST['description'];
	$moves = $_POST['moves'];
	$notes = $_POST['notes'];

	$createquery = "INSERT INTO members VALUES('','$username','$password','$race','$currentpl','','$totalpl','$planet','$snakewaycount','$gravity','$credits','$email','$description','$dead','$train','$items','$weighted','$meditate','$meditatecount','$people','$jobs','$alignment','$moves','$sensu','$notes')";
	mysql_query($createquery);

	unset($_POST['create']);
}
//load user moves into an array
$movelist = explode(",",$userdata['moves']);
?>

<html>
<head>
	<title>Welcome Admin!</title>
<script type="text/javascript" src="http://www.planetmado.com/sal/js/jquery.min.js"></script>
<link rel="stylesheet" href="http://www.planetmado.com/sal/css/admin.css" type="text/css" media="screen" />
<script type="text/javascript">
function GetRFC822Date()
  {
	var oDate = new Date()
    var aMonths = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", 
                            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

    var aDays = new Array( "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    var dtm = new String();

    dtm = aDays[oDate.getDay()] + ", ";
    dtm += padWithZero(oDate.getDate()) + " ";
    dtm += aMonths[oDate.getMonth()] + " ";
    dtm += oDate.getFullYear() + " ";
    dtm += padWithZero(oDate.getHours()) + ":";
    dtm += padWithZero(oDate.getMinutes()) + ":";
    dtm += padWithZero(oDate.getSeconds()) + " " ;
    dtm += getTZOString(oDate.getTimezoneOffset());
    return dtm;
  }
  //Pads numbers with a preceding 0 if the number is less than 10.
  function padWithZero(val)
  {
    if (parseInt(val) < 10)
    {
      return "0" + val;
    }
    return val;
  }

  /* accepts the client's time zone offset from GMT in minutes as a parameter.
  returns the timezone offset in the format [+|-}DDDD */
  function getTZOString(timezoneOffset)
  {
    var hours = Math.floor(timezoneOffset/60);
    var modMin = Math.abs(timezoneOffset%60);
    var s = new String();
    s += (hours > 0) ? "-" : "+";
    var absHours = Math.abs(hours)
    s += (absHours < 10) ? "0" + absHours :absHours;
    s += ((modMin == 0) ? "00" : modMin);
    return(s);
  }
</script>
<script type="text/javascript">
//Set the slide down effect for moves list
	$(document).ready(function(){
	$("ul li label").click(function () { 
		$(this).next().slideToggle("fast");
		});
		});
</script>
</head>
<body>
<div id="content">
<h1>Administration<br/><br/>

<!-- Notify the admin that the user was updated -->
<?if($updateresult){
	echo "User Updated";
	$updateresult = false;
}?>
</h1>

<!-- Admin page. There you cannot train. Just modify users. -->
<div id="links">
<a href="http://www.planetmado.com/forum/showthread.php?t=935" target="_bank">Alignment</a> &#8226; 
<a href="http://www.planetmado.com/custommoves973132.php" target="_blank">Custom Ki Techniques</a> &#8226; 
<a href="http://www.planetmado.com/fightingstyles973132.php" target="blank">Fighting Styles</a> &#8226; 
<a href="http://www.planetmado.com/masters973132.php" target="_blan">Masters</a> &#8226; 
<a href="http://www.planetmado.com/refstuff973132.html" target="_blan">Misc Ref Rules</a> &#8226; 
<a href="http://www.planetmado.com/moves973132.php" target="_blan">Moves List</a> &#8226; 
<a href="http://www.planetmado.com/transformations973132.php" target="_bank">Transformations</a> &#8226; 
<a href="logout.php">Logout</a>
</div>

<!-- Select user. -->
<form method="post" action="admin.php" id="select">
<select name="user">
<option value="create">Create a User</option>
<?=$options?>
</select>
<input type="submit" name="select" value="Select User">
</form>

<div id="data">
<form method="post" action="admin.php" name="userdata" id="userdata">
	<div>
		<label>Username:</label>
		<input type="text" name="username" value="<?=$userdata['username'];?>"/>
	</div>
		<div>
			<label>Password:</label>
		<input type="text" name="password" value="<?=$userdata['password'];?>" />
		</div>
	<div>
		<label>Race:</label>
		<select name="race">
			<option value="Android" <?if($userdata['race']=="Android") echo 'selected';?>>Android</option>
			<option value="Devil" <?if($userdata['race']=="Devil") echo 'selected';?>>Devil</option>
			<option value="Duugo" <?if($userdata['race']=="Duugo") echo 'selected';?>>Duugo</option>
			<option value="Half Saiyan Half Human" <?if($userdata['race']=="Half Saiyan Half Human") echo 'selected';?>>Half Saiyan Half Human</option>
			<option value="Human" <?if($userdata['race']=="Human") echo 'selected';?>>Human</option>
			<option value="Namek" <?if($userdata['race']=="Namek") echo 'selected';?>>Namek</option>
			<option value="Saiyan" <?if($userdata['race']=="Saiyan") echo 'selected';?>>Saiyan</option>
		</select>
	</div>
	<div>
		<label>Current Power Level:</label>
		<input type="text" name="currentpl" value="<?=$userdata['currentpl'];?>" />
	</div>
	<div>
		<label>Max Power Level:</label>
		<input type="text" name="maxpl" value="<?=$userdata['maxpl'];?>" />
	</div>
	<div>
		<label>Total Power Level:</label>
		<input type="text" name="totalpl" value="<?=$userdata['totalpl'];?>" />
	</div>
	<div>
		<label>Planet:</label>
		<select name="planet">
		<option value="Earth" <?if($userdata['planet']=="Earth") echo 'selected';?>>Earth</option>
		<option value="Namek" <?if($userdata['planet']=="Namek") echo 'selected';?>>Namek</option>
		<option value="Vegeta" <?if($userdata['planet']=="Vegeta") echo 'selected';?>>Vegeta</option>
		<option value="Freeza" <?if($userdata['planet']=="Freeza") echo 'selected';?>>Freeza</option>
		<option value="The Moon" <?if($userdata['planet']=="The Moon") echo 'selected';?>>The Moon</option>
		<option value="Mado" <?if($userdata['planet']=="Mado") echo 'selected';?>>Mado</option>
		<option value="Yadrat" <?if($userdata['planet']=="Yadrat") echo 'selected';?>>Yadrat</option>
		<option value="The Next Dimension" <?if($userdata['planet']=="The Next Dimension") echo 'selected';?>>The Next Dimension</option>
		<option value="Snake Way" <?if($userdata['planet']=="Snake Way") echo 'selected';?>>Snake Way</option>
		</select>
	</div>
	<div>
		<label>Times Ran/Flew Snake Way:</label>
		<input type="text" name="snakewaycount" value="<?=$userdata['snakewaycount'];?>" />
	</div>
	<div>
		<label>Gravity:</label>
		<input type="text" name="gravity" value="<?=$userdata['gravity'];?>" />
	</div>
	<div>
		<label>Credits:</label>
		<input type="text" name="credits" value="<?=$userdata['credits'];?>" />
	</div>
	<div>
		<label>Email:</label>
		<input type="text" name="email" value="<?=$userdata['email'];?>" />
	</div>
	<div>
		<label>Last date trained:</label>
		<input type="text" name="train" value="<?echo $userdata['train'];?>" /><input type="button" value="Set to now" onclick="document.userdata.train.value = GetRFC822Date()"/>
	</div>
	<div>
		<label>Last time meditated:</label>
		<input type="text" name="meditate" value="<?=$userdata['meditate'];?>" />
	</div>
	<div>
		<label>Times meditated today:</label>
		<input type="text" name="meditatecount" value="<?=$userdata['meditatecount'];?>" />
	</div>
	<div>
		<label>People you have been to:</label>
		<textarea rows="6" cols="50" name="people"><?=$userdata['people'];?></textarea>
	</div>
	<div>
		<label>Sensu Beans:</label>
		<input type="text" name="sensu" value="<?=$userdata['sensu'];?>" />
	</div>
	<div>
		<label>Items:</label>
		<textarea rows="6" cols="50" name="items"><?=$userdata['items'];?></textarea>
	</div>
	<div>
		<label>Weighted Items:</label>
		<textarea rows="6" cols="50" name="weighted"><?=$userdata['weighted'];?></textarea>
		<select name="listweighted">
		<option>Shirt</option>
		<option>Pants</option>
		<option>Shoes</option>
		<option>Belt</option>
		<option>Hat</option>
		<option>Wrist</option>
		<option>Socks</option>
		<select>
		<input type="button" value="Add item" onclick="var newtext = document.userdata.listweighted.value;document.userdata.weighted.value += newtext + ',';">
	</div>
	<div>
		<label>Died:</label>
		<input type="text" name="dead" value="<?=$userdata['dead'];?>" /><input type="button" value="Set to now" onclick="document.userdata.dead.value = GetRFC822Date();document.userdata.maxpl.value = (<?=$userdata['totalpl'];?>/2);document.userdata.currentpl.value = 0"/>
	</div>
	<div>
		<label>Job(s):</label>
		<textarea rows="6" cols="50" name="jobs"><?=$userdata['jobs'];?></textarea>
	</div>
	<div>
		<label>Alignment:</label>
		<input type="text" name="alignment" value="<?=$userdata['alignment'];?>" />
	</div>
	<div>
		<label>Description:</label>
		<textarea rows="6" cols="50" name="description"><?=$userdata['description'];?></textarea>
	</div>
	<div>
		<label>Moves:</label>
		<textarea rows="6" cols="50" name="moves"><?=$userdata['moves'];?></textarea>
	</div>
	<div>
		<label>How the moves will look on the player's page:</label>
		<ul>
		<?	//This loads up all the moves from a database table
			foreach ($movelist as $move){
			$movequery = "SELECT * FROM moves WHERE name='$move'";
			$moverow = mysql_fetch_array(mysql_query($movequery));
			echo "<li><label><b>".$moverow['name']."</b></label><span>".$moverow['description']."</span></li>";
			}
			?>
		</ul>
	</div>
	<div>
		<label>Ref Notes:</label>
		<textarea rows="6" cols="50" name="notes"><?=$userdata['notes'];?></textarea>
	</div>
	<div>
	<?if($_POST['user'] == "create" || !isset($_POST['user'])):?>
	<input type="submit" name="create" value="Create User"/>
	<?else:?>
	<input type="submit" name="save" value="Save User Data"/>
	<?endif;?>
	</form>
	</div>
</div>

<div>
</body>
</html>