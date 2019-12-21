<?php

include("src/php/db.php");

session_start();
if (isset[$_SESSION["user"]] && isset($_GET["username"])){
	echo $_GET["username"];
} else {
	echo "nope";
}

?>