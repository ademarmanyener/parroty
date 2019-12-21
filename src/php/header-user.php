<?php include("src/php/base-top.php"); ?>
<?php //include("src/php/functions.php"); ?>

<?php

if (isset($_POST["logout"])){
	unset($_SESSION["user"]);
	header("Location: index");
}

include("src/php/db.php");

if ($cnn->connect_error){
	echo "error: ".$cnn->connect_error;
}

if (isset($_SESSION["user"])){
	$result = $cnn->query("SELECT * FROM users WHERE username='".$_SESSION["user"]."'");
}

$isAdmin = 0;
$userAvatar = null;
if ($result->num_rows > 0){
	while ($row = $result->fetch_assoc()){
		if ($row["username"] == $_SESSION["user"]){
			$userAvatar = $row["avatar"];
		}
		if ($row["permission"] == "admin"){
			$isAdmin = 1;
		}
	}
}

if (isset($_POST["add_product"])){
	header("Location: manage-posts?option=add");
}

if (isset($_POST["edit_product"])){
	header("Location: manage-posts?option=edit");
}

if (isset($_POST["remove_product"])){
	echo "soon.";
}

if (isset($_POST["manage_users"])){
	header("Location: manage-users");
}

if (isset($_POST["shopping_cart"])){
	header("Location: shopping-cart?username=".$_SESSION["user"]);
}

if (isset($_POST["manage_announcements"])){
	header("Location: manage-announcements");
}

?>

<?php

$result = $cnn->query("SELECT * FROM announcements WHERE visibility = 'everyone' OR visibility = 'users'");
if ($result->num_rows > 0){
	while ($row = $result->fetch_assoc()){
		if ($row["id"] == "0"){
			echo '
				<div class="container-fluid font-second" style="font-size: 20px; background-color: #ABEBC6;">
					<div class="row">
						<div class="col-xl-1 align-self-center font-weight-bold">DUYURU: </div>
						<div class="col-xl-11 text-break">'.$row["text"].' ('.$row["added_by"].')</div>
					</div>
				</div>
			';
  	}                       
	}
}    

?>

<form method="post" action="">
<div class="container-fluid my-header">
	<div class="container">
		<div class="row text-center">
			<div class="col-lg-1"><img onclick="window.location.href='index'" height="100" src="<?php echo getSiteValues('header_logo'); ?>"></div>
			<div class="col-lg-6 align-self-center"><?php echo getSiteValues("header_text"); ?> <?php echo getSiteValues("header_motto"); ?></div>
			<div class="col-lg-2 align-self-center"><input type="submit" name="shopping_cart" class="btn btn-success w-100 h-100 font-second" value="Sepetim"></div>
			<div class="col-lg-2 align-self-center"><input type="submit" name="logout" class="btn btn-danger w-100 h-100 font-second" value="Çıkış Yap"></div>
			<div class="col-lg-1 align-self-center"><a href="profile?username=<?php echo $_SESSION["user"]; ?>"><div style="width: 80px; height: 80px; background-image: url(<?php echo $userAvatar; ?>); background-repeat: no-repeat; background-size: cover; background-position: center; border: 1px solid black; border: 2px solid #58D68D; border-radius: 10px; background-color: white;"></div></a></div>
		</div>
		<?php
		if ($isAdmin == 1){
			echo '<div class="row justify-content-center">
							<div class="col-lg-3"><input type="submit" name="add_product" class="btn btn-primary font-second w-100 h-75" style="font-size: 15px; line-height: 15px;" value="Ürün Ekle"></div>
							<div class="col-lg-3"><input type="submit" name="edit_product" class="btn btn-primary font-second w-100 h-75" style="font-size: 15px; line-height: 15px;" value="Ürünleri Düzenle/Sil"></div>
              <div class="col-lg-3"><input type="submit" name="manage_users" class="btn btn-primary font-second w-100 h-75" style="font-size: 15px; line-height: 15px;" value="Kullanıcıları Düzenle/Sil"></div>
              <div class="col-lg-3"><input type="submit" name="manage_announcements" class="btn btn-primary font-second w-100 h-75" style="font-size: 15px; line-height: 15px;" value="Duyuruları Düzenle"></div>
						</div>';
		}
		?>
	</div>
</div>
</form>
