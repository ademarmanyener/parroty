<?php

session_start();
if (isset($_SESSION["user"])){
  include("src/php/header-user.php");
} else {
  include("src/php/header.php");
}

include("src/php/content.php");

include("src/php/footer.php");

?>