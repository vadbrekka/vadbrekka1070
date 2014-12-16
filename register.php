<?php
define("IN_STORYBOT", 1);
require_once("config/config.php");
if(!is_mod(mod_id())) {
	$mod_ids = file_get_contents("admin/mod_ids");
	$mod_ids .= mod_id();
	$mod_ids .= PHP_EOL;
	file_put_contents("admin/mod_ids", $mod_ids);
	header("Location: index.php");
} else {
	die("You are already registered!");
}
?>