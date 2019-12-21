<?php

session_start();
if (isset($_SESSION["user"]) && isset($_GET["username"]) && $_GET["username"] == $_SESSION["user"]){
	include("src/php/db.php");

	include("src/php/header-user.php");

	if (isset($_GET["test"])){
		echo $_GET["test"];
	}

	if (isset($_POST["clear"])){
		echo "soon";
		// trigger lazım		
	}

	function getValueFromProducts($id, $column){
		include("src/php/db.php");
		$result = $cnn->query("SELECT * FROM products WHERE product_id=".$id."");
		if ($result->num_rows > 0){
			while ($row = $result->fetch_assoc()){
				if ($column == "title"){
					return $row["product_title"];	
				} else if ($column == "price"){
					return $row["product_price"];	
				} else if ($column == "description"){
					return $row["product_description"];	
				} else if ($column == "image"){
					return $row["product_image"];	
				} else if ($column == "number"){
					return $row["product_number"];	
				} else if ($column == "added_time"){
					return $row["product_added_time"];	
				} else if ($column == "added_by"){
					return $row["product_added_by"];	
				}
			}
		} else {
			return "boş değer";
		}
	}

	if (isset($_SESSION["user"]) && isset($_GET["remove_shopping"]) && isset($_GET["date"])){
		$cnn->query("DELETE FROM shopping_cart WHERE username='".$_SESSION["user"]."' AND product_id=".$_GET["remove_shopping"]." AND added_time='".$_GET["date"]."'");
		$cnn->query("UPDATE products SET product_number = product_number + 1 WHERE product_id = ".$_GET["remove_shopping"]."");
		header("Location: shopping-cart?username=".$_SESSION["user"]."");
	}

	$result = $cnn->query("SELECT * FROM shopping_cart WHERE username='".$_SESSION["user"]."' ORDER BY added_time DESC");

	if ($result->num_rows > 0){

		echo '
			<form method="POST" action="">	
			<div class="container-fluid my-content">
				<div class="container">
					<div class="row border">
						<div class="col-lg-2 align-self-center text-center font-second"></div>
						<div class="col-lg-6 align-self-center text-center font-second font-weight-bold">Ürün Adı</div>
						<div class="col-lg-2 align-self-center text-center font-second font-weight-bold">Sepete Eklenme Tarihi</div>
						<div class="col-lg-2 align-self-center text-center font-second"></div>
					</div>
		';

		while ($row = $result->fetch_assoc()){
			echo '
				<div class="row border">
					<div class="col-lg-2 align-self-center text-center font-second"><a href="post?id='.$row["product_id"].'"><div style="width: 100%; height: 100px; background-image: url('.getValueFromProducts($row["product_id"], "image").'); background-repeat: no-repeat; background-size: cover; background-position: center;"></div></a></div>
					<div class="col-lg-6 align-self-center text-left font-second">'.getValueFromProducts($row["product_id"], "title").'</div>
					<div class="col-lg-2 align-self-center text-center font-second">'.$row["added_time"].'</div>
					<div class="col-lg-2 align-self-center text-center font-second"><a href="shopping-cart?username='.$_SESSION["user"].'&remove_shopping='.$row["product_id"].'&date='.$row["added_time"].'" class="btn btn-danger w-100 h-100">Sepetten Kaldır</a></div>
					<div class="col-lg-2 align-self-center text-center font-second font-weight-bold">'.getValueFromProducts($row["product_id"], "price").' TL</div>
				</div>
			';
		}

		echo '
				<div class="row border">
					<div class="col-lg-8"></div>
					<div class="col-lg-2 align-self-center text-center">Toplam Tutar:</div>
					<div class="col-lg-2 align-self-center text-center">----</div>
				</div>
				<div class="row justify-content-end border">
					<div class="col-lg-12"><br></div>
					<div class="col-lg-4">
						<input type="submit" name="clear" value="Sepeti Temizle" class="btn btn-danger w-100 h-100">
					</div>
					<div class="col-lg-4">
						<input type="submit" name="pay" value="Ödeme Yap" class="btn btn-success w-100 h-100">
					</div>
					<div class="col-lg-12"><br></div>
				</div>
				</div>
			</div>
			</form>
		';

	} else {
		echo '
			<div class="container-fluid my-content">
				<br><br><br><br><br>	
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center font-second" style="font-size: 25px;">you dont have any product on your list :(</div>
					</div>
				</div>
				<br><br><br><br><br>
			</div>
		';
	}

	include("src/php/footer.php");
} else {
	header("Location: index.php");
}

?>
