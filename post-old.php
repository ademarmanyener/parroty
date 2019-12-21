<?php

include("src/php/db.php");

session_start();
if (isset($_SESSION["user"])){
	include("src/php/header-user.php");
} else {
	include("src/php/header.php");
}

$id = $_GET["id"];

function amIAdmin(){
	include("src/php/db.php");			
  $result = $cnn->query("SELECT * FROM users WHERE username = '".$_SESSION["user"]."'");
  if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
      if ($row["permission"]  == "admin"){
        return 0;
      } else {
        return 1;
      }
    }
  } else {
    return 1;
  }
}

if (isset($_POST["add_shopping"]) && isset($_SESSION["user"])){
	$cnn->query("INSERT INTO shopping_cart VALUES('".$_SESSION["user"]."', ".$_GET["id"].", '".date('d-m-Y H:i:s')."')");
	$cnn->query("UPDATE products SET product_number = product_number - 1 WHERE product_id = ".$_GET["id"]."");
	header("Location: shopping-cart?username=".$_SESSION["user"]);
} else if (isset($_POST["add_shopping"]) && !isset($_SESSION["user"])){
	echo '
		<div class="container-fluid font-second text-white text-center align-self-center" style="font-size: 20px; background-color: #C0392B;">Kayıt olmalısınız!</div>
	';
}

$result = $cnn->query("SELECT * FROM products WHERE product_id=$id");
if ($result->num_rows > 0){
	while ($row = $result->fetch_assoc()){
		if ($row["product_id"] == $id){
			$avatar = null;
			$resultForAvatar = $cnn->query("SELECT * FROM users WHERE username = '".$row['product_added_by']."'");
			while ($rowForAvatar = $resultForAvatar->fetch_assoc()){
				$avatar = $rowForAvatar["avatar"];
			}
			echo '
				<form method="POST">
				<div class="container-fluid my-content">
					<div class="container">
						<div class="row">
							<div class="col-lg">
								<div class="row" style="font-size: 50px;"><p class="font-second">'.$row["product_title"].'</p></div>
								<div class="row justify-content-center"><div style="width: 100%; height: 600px; background-image: url('.$row["product_image"].'); background-repeat: no-repeat; background-size: cover; background-position: center; border: 5px solid #EB984E; border-radius: 5px;"></div></div>
								<div class="row"><p class="font-second" style="font-size: 40px;">Fiyat: '.$row["product_price"].' TL</p></div>
								<div class="row text-break"><p class="font-second" style="font-size: 25px;">Detaylar: '.$row["product_description"].' </p></div>
								<div class="row text-break">
									<div class="col-md-2">';
									if ($row["product_number"] > 0){
							echo '<input name="add_shopping" type="submit" class="btn btn-success w-100 h-100 font-second" style="font-size: 20px;" value="Sepete Ekle">';
									} else {
							echo '<input type="button" class="btn btn-success w-100 h-100 font-second disabled" style="font-size: 20px;" value="Stok Kalmadı">';
									}
						echo '</div>
									<div class="col-md-4">
										<p class="font-second" style="font-size: 25px;">Stok: '.$row["product_number"].'</p>
									</div>
								</div>
								<br>
								<div class="row justify-content-end">
									<div class="col-sm-6 text-right align-self-center font-second" style="font-size: 20px;">added by: '.$row["product_added_by"]." (".$row["product_added_time"].")".'</div>
									<div class="col-sm-2"><a href="profile?username='.$row["product_added_by"].'"><div style="width: 100px; height: 100px; background-color: red; background-image: url('.$avatar.'); background-repeat: no-repeat; background-size: cover; background-position: center; border: 3px solid #3498DB; border-radius: 10px;"></div></a></div>
								</div>
								<br>
								'; if (isset($_SESSION["user"]) && $_SESSION["user"] == $row["product_added_by"] || isset($_SESSION["user"]) && amIAdmin() == 0){
									echo '								
								<div class="row justify-content-center">
									<div class="col-sm-12 text-center align-self-center font-second"><a href="manage-posts?option=edit&id='.$row["product_id"].'" class="btn btn-danger w-50 h-100" style="font-size: 20px; border-radius: 0px; border-top-left-radius: 15px; border-top-right-radius: 15px;">Ürünü Düzenle</a></div>
								</div>								
								<div class="row justify-content-center">
									<div class="col-sm-12 text-center align-self-center font-second"><a href="manage-posts?option=remove&id='.$row["product_id"].'" class="btn btn-danger w-50 h-100" style="font-size: 20px; border-radius: 0px;">Ürünü Sil</a></div>
								</div>								
									';
								}
								; echo '
							</div>
						</div>
					</div>
				</div>
				</form>
			';
		} else {
			echo "error!";
		}
	}
} else {
  header("Location: index");
}

$cnn->close();


?>

<?php

include("src/php/footer.php");

?>
