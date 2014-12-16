<?php
define("IN_STORYBOT", 1);
require_once("config/config.php");
if(is_mod(mod_id())) {
	header("Location: mod.php");
} else {
	echo('<html>
<head>
<title>Storybot - '.$config['username'].'</title>
</head>
<body>
<img src="http://b.thumbs.redditmedia.com/in0eLkjDwflTCR6bw5NxYtLb2OhCtzNhZJrkgA-g30M.png" /><hr />
<form action="register.php" method="GET">
Click to register and be a mod! By registering, you agree that a md5 hash of your IP will be logged for identification purposes. You cannot "unregister" (accounts are permanent).<br /><br />If you abuse this moderation privilege, you can and will be banned.<br /><br /><input type="submit" value="Register">
</form>
</body>
</html>');
}
?>
