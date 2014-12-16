<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
<title>entstory Mod</title>
<link rel="stylesheet" type="text/css" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript">
function tapbutton() {
    document.getElementById("overlay").style.display = "block";
}
</script>

<?php
define("IN_STORYBOT", 1);
$i = 0;
require_once("config/config.php");
if(!is_mod(mod_id())) {
	die("You need to register first! index.php");
}
$dir = new DirectoryIterator("media/temp");
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
    	if($i == 0) {
    		echo "</head>
<body onload=\"javascript:document.getElementById('overlay').style.display='none';\">";
	        echo "<span id='overlay' class='overlay'></span>
	        <img style='height: 360px; width: 240px;' src='media/temp/".$fileinfo->getFilename()."' /><br />";
	        if(intval(file_get_contents("log/count")) < intval($config['max_snaps_per_hour']-1)) {
	        	echo "<a class='myButton' type='submit' onclick='tapbutton();' href='vote.php?file=".$fileinfo->getFilename()."&vote=yes' />ACCEPT</a>";

    		} else {
	        	echo "<a class='myButton' type='submit' onclick='alert(\"Queue full for this hour! Max snaps of ".$config['max_snaps_per_hour']." reached. Resets at the top of every hour.\");' href='#' />ACCEPT</a>";

    		}
	        echo "<a class='myButtonred' type='submit' onclick='tapbutton();' href='vote.php?file=".$fileinfo->getFilename()."&vote=no' />REJECT</a>
	        <a class='banbutton' type='submit' onclick='tapabutton();' href='ban.php?file=".$fileinfo->getFilename()."&mod=".mod_id()."'>REPORT</a><br />
	        No nudes, no advertising, and picture has to involve trees in some way. Only report people who send nudes or ads, or spam. Just reject off topic submissions.";
	        $i = 1;
	    }
    }
}
if($i == 0) {
    echo "<meta http-equiv='refresh' content='30'></head><body>No more images needing moderation! This page will automatically refresh every 30 seconds.";
}
echo "<hr>Mod ID: ".mod_id();

?>