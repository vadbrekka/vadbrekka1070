<?php
if($_GET['lol'] == "jpg") {
	file_put_contents("log/count", "0");
} else {
	header("Location: index.php");
}