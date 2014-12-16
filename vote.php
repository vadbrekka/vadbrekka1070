<?php
define("IN_STORYBOT", 1);
require_once("config/config.php");

if(!is_mod(mod_id())) {
	die("No access!");
}

if($_GET['vote'] == "yes") {
	if(intval(file_get_contents("log/count")) < 149) {
		postImageStory($_GET['file'], mod_id(), $config['username'], $config['password']);
	}
	header("Location: mod.php");
} elseif($_GET['vote'] == "no") {
	deleteImage($_GET['file'], $config['username'], $config['password']);
	header("Location: mod.php");
} else {
	die("Incorrect input value!");
}