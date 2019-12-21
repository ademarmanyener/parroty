<?php

session_start();
if (isset($_SESSION["user"])){
  include("src/php/header-user.php");
} else {
  include("src/php/header.php");
}

include("src/php/db.php");

$username = $_GET["username"];
$userAddedTime = null;
$userPermission = null;
$userAvatar = null;

$result = $cnn->query("SELECT * FROM users WHERE username = '".$username."'");

if ($result->num_rows > 0){
  while ($row = $result->fetch_assoc()){
		if ($row["username"] == $username){
      $userAddedTime = $row["added_time"];
      $userPermission = $row["permission"];
			$userAvatar = $row["avatar"];
			if ($userPermission == "admin"){
				$userColor = "#58D68D";
			} else if ($userPermission == "normal"){
				$userColor = "#3498DB";
			}
		}
  }
} else {
	header("Location: index");
}

if (isset($_POST["change_avatar"])){
  header("Location: change-settings?option=avatar&username=".$username);
}

if (isset($_POST["change_password"])){
  header("Location: change-settings?option=password&username=".$username);
}

if (isset($_POST["manage_users"])){
	header("Location: manage-users");
}

if (isset($_POST["remove_account"])){
	$cnn->query("DELETE FROM users WHERE username='".$_POST["remove_account_username"]."'");
	session_destroy();
	header("Location: index");
}

if (isset($_POST["manage_site_values"])){
	header("Location: manage-site-values");
}

if (isset($_POST["manage_links"])){
	header("Location: manage-links");
}

$cnn->close();

?>

<form method="POST" action="">
  <div class="container-fluid my-content">
		<br><br>
		<div class="container">
      <div class="row">
			<div class="col-lg-4"><a href="<?php echo $userAvatar; ?>"><div style="width: 350px; height: 350px; background-image: url(<?php echo $userAvatar; ?>); background-repeat: no-repeat; background-size: contain; background-position: center; border: 0px solid <?php echo $userColor; ?>; background-color: white;"></div></a></div>
        <div class="col-lg-8 text-center align-self-center">
          <div class="row font-second" style="font-size: 25px;">
            <div class="col-lg-12">Kullanıcı Adı: <?php echo $username; ?></div>
            <div class="col-lg-12">Kayıt Tarihi: <?php echo $userAddedTime; ?></div>
            <div class="col-lg-12">Yetkisi: <?php echo $userPermission; ?></div>
          </div>
        </div>
      </div>  
    <?php
    if (isset($_SESSION["user"]) && $username == $_SESSION["user"]){
      echo '<div class="row">
              <div class="col-lg-4"><input type="submit" name="change_avatar" style="border-radius: 0px;" class="btn btn-warning w-50 h-100" value="Change Avatar"><input type="submit" name="change_password" style="border-radius: 0px;" class="btn btn-warning w-50 h-100" value="Change Password"></div>
            </div>';
    }
    if ($userPermission == "admin" && isset($_SESSION["user"]) && $_SESSION["user"] == $_GET["username"]){
      echo '<div class="row">
              <div class="col-lg-4"><input type="submit" name="manage_users" style="border-radius: 0px;" class="btn btn-warning w-100 h-100" value="Manage Users"></div>
						</div>
						<div class="row">
							<div class="col-lg-4"><input type="submit" name="manage_site_values" style="border-radius: 0px;" class="btn btn-success w-100 h-100" value="Manage Site Values"></div>
						</div>
						<div class="row">
							<div class="col-lg-4"><input type="submit" name="manage_links" style="border-radius: 0px;" class="btn btn-success w-100 h-100" value="Linklerini Düzenle"></div>
						</div>

';
    }
    if (isset($_SESSION["user"]) && $_SESSION["user"] == $_GET["username"]){
      echo '
				<div class="row justify-content-end" style="margin-top: 5px;">
					<input type="hidden" name="remove_account_username" value='.$_SESSION["user"].'>
          <div class="col-lg-3"><input type="submit" class="btn btn-danger w-100 h-100" name="remove_account" value="Remove Account"></div>
        </div>
      '; 
    }
    include("src/php/db.php");
    $result = $cnn->query("SELECT * FROM products WHERE product_added_by = '".$_GET["username"]."' ORDER BY product_added_time DESC");
    if ($result->num_rows > 0){
      echo '<br><br>';
      echo '<div class="row justify-content-center">
              <div class="col-lg-8 font-second text-center" style="font-size: 20px; border-top-left-radius: 15px; border-top-right-radius: 15px; background-color: #212F3C; color: white;"><br>Gönderiler<br><br></div>
            </div>';
      while ($row = $result->fetch_assoc()){
        ?>
          <div class="row justify-content-center">
            <div class="col-lg-8" style="background-color:<?php echo $userColor; ?>;">
              <a href="post?id=<?php echo $row['product_id']; ?>" style="text-decoration: none; color: black;"><div class="row">
                <div class="col-sm-2" style="width: 100px; height: 100px; background-image: url(<?php echo $row["product_image"]; ?>); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                <div class="col-sm-8 align-self-center font-second text-center" style="font-size: 15px;"><?php echo $row["product_title"]; ?></div>
                <div class="col-sm-2 align-self-center font-second text-right" style="font-size: 15px;"><?php echo $row["product_price"]." TL"; ?></div>
              </div></a>
            </div>
          </div>
        <?php
      }
    } else {
      echo "Hiç gönderi yok!";
    }
    ?>
    </div>
		<br><br>
	</div>
</form>

<?php include("src/php/footer.php"); ?>