<?php
define("IN_STORYBOT", 1);
require("config/config.php");
$file = $_GET['file'];
if(file_exists("media/temp/".$file)) {
	rename("media/temp/".$file, "media/reported/".$file);
	$data = file_get_contents("log/reportlog");
	$data .= "IMAGE: ".$file." - MOD: ".mod_id();
	$data .= PHP_EOL;
	file_put_contents("log/reportlog", $data);
	header("Location: mod.php");
} else {
	die;
}
?>