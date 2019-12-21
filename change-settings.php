<?php

session_start();
if (isset($_SESSION["user"]) && $_SESSION["user"] == $_GET["username"]){
  include("src/php/header-user.php");
} else {
  header("Location: index");
}

$errorText = null;
if (isset($_POST["changePassword"])){  
  $result = $cnn->query("SELECT * FROM users WHERE username = '".$_GET["username"]."'");
  while ($row = $result->fetch_assoc()){
    if ($row["password"] == $_POST["oldPassword"]){
      if ($_POST["newPassword"] != NULL && $_POST["newPasswordAgain"] != NULL && $_POST["newPassword"] == $_POST["newPasswordAgain"] && $_POST["newPassword"] != $_POST["oldPassword"]){
        $cnn->query("UPDATE users SET password = '".$_POST["newPassword"]."' WHERE username = '".$_GET["username"]."'");
        $errorText = "Şifreniz değiştirildi!";
      } else {
        $errorText = "Şifrelerin eşleştiğine emin misiniz?";
      }
    } else {
      $errorText = "Doğru şifre girdiğinize emin misiniz?";
    }
  }
}

if (isset($_POST["update_avatar"]))
	if ($_POST["avatarURL"] != NULL){
		$cnn->query("UPDATE users SET avatar = '".$_POST["avatarURL"]."' WHERE username = '".$_GET["username"]."'");
		header("Location: profile?username=".$_GET["username"]);
	} else {
		$errorText = "URL boş bırakılamaz!";
	}

if (isset($_POST["remove_avatar"])){
	$cnn->query("UPDATE users SET avatar = 'src/img/logo.png' WHERE username='".$_SESSION["user"]."'");
	header("Location: change-settings?option=avatar&username=".$_SESSION["user"]);
}
?>

<div class="container-fluid my-content">
  <div class="container">
    <?php
			if ($_GET["option"] == "avatar"){
				$result = $cnn->query("SELECT * FROM users WHERE username = '".$_GET["username"]."'");
				if ($result->num_rows > 0){
					while ($row = $result->fetch_assoc()){
						echo '
							<form method="POST">
							<br>
							<div class="row">
								<div class="col-lg-12 text-center"><img src="'.$row["avatar"].'" class="img-fluid w-50"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12 text-center"><input type="input" name="avatarURL" value="'.$row["avatar"].'" class="form-control"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12 text-center"><input type="submit" name="update_avatar" class="btn btn-primary w-100 h-100" style="border-radius: 0px; border-top-left-radius: 15px; border-top-right-radius: 15px;" value="Update Avatar"></div>
							</div>
							<div class="row">
								<div class="col-lg-12 text-center"><input type="submit" name="remove_avatar" class="btn btn-danger w-100 h-100" style="border-radius: 0px; border-bottom-left-radius: 15px; border-bottom-right-radius: -15px;" value="Remove Avatar"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12 text-center font-second" style="font-size: 25px;">'.$errorText.'</div>
							</div>
							<br>
							</form>
						';
					}
				}	
		}

    if ($_GET["option"] == "password"){
      echo '
            <form method="post">
              <br>  
              <div class="row">
                <div class="col-sm-4 font-second align-self-center text-right">Current Password: </div>
                <div class="col-sm-6 font-second"><input type="password" class="form-control" name="oldPassword"></div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-4 font-second align-self-center text-right">New Password: </div>
                <div class="col-sm-6 font-second"><input type="password" class="form-control" name="newPassword"></div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-4 font-second align-self-center text-right">New Password Again: </div>
                <div class="col-sm-6 font-second"><input type="password" class="form-control" name="newPasswordAgain"></div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-12 text-center font-second"><input type="submit" class="btn btn-success w-50 h-100" name="changePassword" value="Change Password"></div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-12 text-center font-second" style="color: darkred; font-size: 25px;">'.$errorText.'</div>
              </div>
              <br>
            </form>
              ';
    }
    ?>
  </div>
</div>

<?php include("src/php/footer.php"); ?>
