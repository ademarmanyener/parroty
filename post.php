<?php
session_start();
if (isset($_SESSION["user"])){
	include 'src/php/header-user.php';
} else {
	include 'src/php/header.php';
}

// check if product with this id doesn't exist or didn't enter any id
if (!isset($_GET["id"])){
	header("Location: index");
} else {
	$result = $cnn->query("SELECT * FROM products WHERE product_id = ".$_GET["id"]."");
	if (!$result->num_rows > 0){
		header("Location: index");
	}	
}

function checkProductNumber($id){
	include 'src/php/db.php';
	$result = $cnn->query("SELECT * FROM products WHERE product_id = ".$id."");
	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			if ($row["product_number"] > 0){
				return true;
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
}

// sepete ekle
if (isset($_POST["add_shopping"]) && isset($_SESSION["user"])){
	if (checkProductNumber($_GET["id"]) == true){
		$cnn->query("INSERT INTO shopping_cart VALUES('".$_SESSION["user"]."', ".$_GET["id"].", '".date('d-m-Y H:i:s')."')");
		$cnn->query("UPDATE products SET product_number = product_number - 1 WHERE product_id = ".$_GET["id"]."");
		header("Location: shopping-cart?username=".$_SESSION["user"]);
	} else {
		echo "nope";
	}
} else if (isset($_POST["add_shopping"]) && !isset($_SESSION["user"])){
	echo '
		<div class="container-fluid font-second text-white text-center align-self-center" style="font-size: 20px; background-color: #C0392B;">Kayıt olmalısınız!</div>
	';
}

include 'src/php/db.php';
$result = $cnn->query("SELECT * FROM products WHERE product_id = ".$_GET["id"]."");
if (!$result->num_rows > 0){
	echo "böyle bir kayıt yok!";
} else {
	while ($row = $result->fetch_assoc()){
		$product_title = $row["product_title"];
		$product_price = $row["product_price"];
		$product_description = $row["product_description"];
		$product_image = $row["product_image"];
		$product_number = $row["product_number"];
		$product_added_time = $row["product_added_time"];
		$product_added_by = $row["product_added_by"];
	}
}

?>

<form method="POST" action="">
<div class="container-fluid" style="height: 500px; background-image: url(<?php echo $product_image; ?>); background-repeat: no-repeat; background-position: center; background-size: cover;"></div>
<div class="container-fluid my-content">
	<div class="container">
		<br>
		<div class="row">
			<div class="col-sm-12 font-second text-center" style="font-size: 25px;"><?php echo $product_title; ?></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12 font-second text-left" style="font-size: 25px;">Detaylar:</div>
		</div>
		<div class="row">
			<div class="col-sm-12 font-second text-left text-break" style="font-size: 20px;"><?php echo $product_description; ?></div>
		</div>
		<br>
		<div class="row justify-content-end">
			<div class="col-sm-2 align-self-center font-second text-center" style="font-size: 20px;">Fiyat: <?php echo $product_price; ?> TL</div>
			<div class="col-sm-2 align-self-center font-second text-center" style="font-size: 20px;">Stok: <?php echo $product_number; ?></div>
			<div class="col-sm-2 align-self-center font-second text-center" style="font-size: 15px;"><input name="" type="button" id="1452534" class="btn btn-success shopier w-100 h-100 font-second" value="(YENİ!) Hızlı Satın Al"></div>
			<div class="col-sm-2 align-self-center font-second text-center" style="font-size: 15px;"><input name="add_shopping" type="submit" class="btn btn-success w-100 h-100 font-second" value="Sepete Ekle"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-4 font-second align-self-center">Product added time: <?php echo $product_added_time; ?></div>
			<div class="col-sm-2 font-second align-self-center"></div>
			<div class="col-sm-4 font-second align-self-center text-right"><a href="profile?username=<?php echo $product_added_by; ?>">Product added by: <?php echo $product_added_by; ?></a></div>
			<div class="col-sm-2 font-second align-self-center text-center" style="width: 100px; height: 100px; background-image: url(<?php echo getUsersAvatar($product_added_by); ?>); background-size: contain; background-repeat: no-repeat; background-position: center;"></div>
		</div>
		<br>
		<?php
			if (isset($_SESSION["user"]) && isAdmin($_SESSION["user"]) == true){
				?>
					<div class="row justify-content-center">
						<div class="col-sm-4"><a href="manage-posts?option=edit&id=<?php echo $_GET["id"]; ?>" class="btn btn-danger w-100 h-100" style="font-size: 20px; border-radius: 0px; border-top-left-radius: 15px; border-top-right-radius: 15px;">Ürünü Düzenle</a></div>
					</div>
					<div class="row justify-content-center">
						<div class="col-sm-4"><a href="manage-posts?option=remove&id=<?php echo $_GET["id"]; ?>" class="btn btn-danger w-100 h-100" style="font-size: 20px; border-radius: 0px;">Ürünü Sil</a></div>
					</div>
				<?php
			}
		?>
	</div>	
</div>
</form>

<?php

include("src/php/footer.php");
?>