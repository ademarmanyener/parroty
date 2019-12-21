<?php include("src/php/header.php"); ?>

<?php

if (isset($_SESSION["username"]) == false){
  header("Location: index.php");
} else {
  echo $_SESSION["username"];
}

?>

<div class="container-fluid my-content">
  <div class="container border">asfsaf
  </div>
</div>

<?php include("src/php/footer.php"); ?>