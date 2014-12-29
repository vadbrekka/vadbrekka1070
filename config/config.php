<?php
if(!defined("IN_STORYBOT")) {
	die("Invalid access!");
}
require_once("src/snapchat.php");

$config = array();
$config['username'] = 'SNAPCHAT-USERNAME';
$config['password'] = 'SNAPCHAT-PASSWORD';

$config['adminpassword'] = 'ADMIN-PASSWORD'; //v2.1, does nothing now
$config['secret'] = "secretj32h09"; //some random characters. DO NOT CHANGE IT except if you are starting a new installation.

$config['moderation'] = true; //disable for instant posting

$config['max_snaps_per_hour'] = 150;

$config['NSFW'] = true; //v2.1

$config['picturesallowed'] = true;
$config['videosallowed'] = false;
$config['send_verify_snap'] = true;
$config['picturetime'] = 3;
$config['videotime'] = 5;

$config['firstsetup'] = true;

if(strpos(file_get_contents("admin/mod_banned"), mod_id()) !== false) {
	die("Your mod ID is banned! Sorry, but you abused it, and this is the consequence.");
}

function is_banned($username) {
	if(strpos(file_get_contents("admin/snap_banned"), $username) !== false) {
		return true;
	} else {
		return false;
	}
}
function is_mod($id) {
	if(strpos(file_get_contents("admin/mod_ids"), $id) !== false) {
		return true;
	} else {
		return false;
	}
}

function mod_id() {
	$mod_id = md5("storybot".$_SERVER['REMOTE_ADDR'].$config['secret']);
	return $mod_id;
}
function deleteImage($file, $username, $password) {
	unlink("media/temp/".$file);
	$snapchat = new Snapchat($username, $password); //create new instance of class Snapchat
	$id = $snapchat->upload(Snapchat::MEDIA_IMAGE, file_get_contents('media/reject.jpg')); //send verification snap
    $exploded = explode("__", $file);
    $exploded = explode(".", $exploded[1]);
    $snapchat->send($id, array($exploded[0]), 10); //10 seconds long
}
function postImageStory($file, $mod_id, $username, $password) {
	$snapchat = new Snapchat($username, $password); //create new instance of class Snapchat
	$id = $snapchat->upload(Snapchat::MEDIA_IMAGE, file_get_contents('media/temp/'.$file)); //upload the temp to story
    $snapchat->setStory($id, Snapchat::MEDIA_IMAGE); //set story
    $id = $snapchat->upload(Snapchat::MEDIA_IMAGE, file_get_contents('media/accept.jpg')); //send verification snap
    $exploded = explode("__", $file);
    $exploded = explode(".", $exploded[1]);
    $snapchat->send($id, array($exploded[0]), 10); //10 seconds long
    rename("media/temp/".$file, "media/archive/".$file); //move temp to archive
    $imagelog = file_get_contents("log/imagelog");
    $imagelog .= "MOD: ".$mod_id. " - FILE: ".$file." - TIME: ".time();
    $imagelog .= PHP_EOL;
    file_put_contents("log/imagelog", $imagelog);
    $count = intval(file_get_contents("log/count"));
    $count++;
    file_put_contents("log/count", $count);
}

if($config['firstsetup']) {
	die("Please edit config/config.php with your own settings, then change the 'firstsetup' value to FALSE and your panel will become live!");
}
?>