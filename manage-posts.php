<?php
session_start();
if (isset($_SESSION["user"])){
  include("src/php/header-user.php");
} else {
  header("Location: index.php");
}

include("src/php/db.php");

$result = $cnn->query("SELECT * FROM users WHERE username = '".$_SESSION["user"]."'");

if ($result->num_rows > 0){
  while ($row = $result->fetch_assoc()){
    if ($row["permission"] != "admin"){
      header("Location: index");
    }
  }
} else {
  header("Location: index");
}

$canAdd = 0;
$canEdit = 0;
$errorText = NULL;
if (isset($_POST["add"])){
  $productID = $_POST["id"];
  $productTitle = $_POST["title"];
  $productPrice = $_POST["price"];
  $productDescription = $_POST["description"];
  $productImage = $_POST["image"];
  $productNumber = $_POST["number"];
  
  $result = $cnn->query("SELECT * FROM products");
  while ($row = $result->fetch_assoc()){
    //if ($row["product_id"] == $productID || $productID == NULL || $productTitle == NULL || $productPrice == NULL || $productDescription == NULL || $productImage == NULL || $productNumber == NULL){
    if ($productTitle == NULL || $productPrice == NULL || $productDescription == NULL || $productImage == NULL || $productNumber == NULL){
      $canAdd = 0;
    } else {
      $canAdd = 1;
    }
  }

  if ($canAdd == 1){
    //$cnn->query("INSERT INTO products (product_title, product_price, product_description, product_image, product_number, product_added_time, product_added_by) VALUES ('$productTitle', $productPrice, '$productDescription', '$productImage', $productNumber, '".date('d-m-Y H:i:s')."', '".$_SESSION["user"]."')");
    //$cnn->query("INSERT INTO products VALUES($productID, '$productTitle', $productPrice, '$productDescription', '$productImage', $productNumber, '".date('d-m-Y H:i:s')."', '".$_SESSION["user"]."')");
		$cnn->query("INSERT INTO products (product_title, product_price, product_description, product_image, product_number, product_added_time, product_added_by) VALUES ('$productTitle', $productPrice, '$productDescription', '$productImage', $productNumber, '".date('d-m-Y H:i:s')."', '".$_SESSION["user"]."')");
		$errorText = "Ürün eklendi!";
    header("Location: post?id=".$productID);
  } else {
    $errorText = "Ürün eklenemedi.";
  }
}

if (isset($_POST["edit"])){
  $productID = $_GET["id"];
  $productTitle = $_POST["title"];
  $productPrice = $_POST["price"];
  $productDescription = $_POST["description"];
  $productImage = $_POST["image"];
  $productNumber = $_POST["number"];

  $result = $cnn->query("SELECT * FROM products WHERE product_id = ".$productID);

  if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
      if ($row["product_id"] == $_GET["id"] && $productTitle != NULL && $productPrice != NULL && $productDescription != NULL && $productImage != NULL && $productNumber != NULL){
        $cnn->query("UPDATE products SET product_title = '".$productTitle."', product_price = ".$productPrice.", product_description = '".$productDescription."', product_image = '".$productImage."', product_number = ".$productNumber." WHERE product_id = ".$productID."");
        $errorText = "Ürün düzenlendi";
        header("Location: post?id=".$row["product_id"]);
      } else {
        $errorText = "Kayıt düzenlenirken hata.";
      }
    }
  } else {
    $errorText = "Böyle bir kayıt mevcut değil.";
  }
}

?>

<?php
if (!isset($_GET["option"]) || !isset($_SESSION["user"])){
	header("Location: index");	
}

if ($_GET["option"] == "add"){
  echo '
    <form method="POST">
      <div class="container-fluid my-content">
        <div class="container">
					<br>
					<div class="row">
						<div class="col-sm-12 text-center font-second" style="font-size: 25px;">ÜRÜN EKLE</div>
					</div>
          <!--<div class="row">
            <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">ID: </div>
            <div class="col-sm-6"><input type="input" disabled name="id" class="form-control"></div>
          </div>-->
          <br>
          <div class="row">
            <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Title: </div>
            <div class="col-sm-6"><input type="input" name="title" class="form-control"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Price: </div>
            <div class="col-sm-6"><input type="input" name="price" class="form-control"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Description: </div>
						<!--<div class="col-sm-6"><input type="text" name="description" class="form-control"></div>-->
						<div class="col-sm-6"><textarea name="description" class="form-control" rows="10"></textarea></div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Image: </div>
            <div class="col-sm-6"><input type="input" name="image" class="form-control"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Number: </div>
            <div class="col-sm-6"><input type="input" name="number" class="form-control"></div>
          </div>
          <br>
          <div class="row justify-content-center">
            <div class="col-sm-6 text-right font-second align-self-center"><input type="submit" style="font-size: 20px;" class="btn btn-success w-100 h-100" name="add" value="Add"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-12 text-center font-second" style="font-size: 25px; color: darkred;">'.$errorText.'</div>
          </div>
          <br>
        </div>
      </div>
    </form>
  ';
} else if ($_GET["option"] == "edit"){
  if (isset($_GET["id"])){
    $result = $cnn->query("SELECT * FROM products WHERE product_id = ".$_GET["id"]);
    if ($result->num_rows > 0){
      while ($row = $result->fetch_assoc()){
        echo '
          <form method="POST">
            <div class="container-fluid my-content">
              <div class="container">
                <br>
								<div class="row">
									<div class="col-sm-12 text-center font-second" style="font-size: 25px;">ÜRÜN DÜZENLE</div>
								</div>
								<div class="row">
                  <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">ID: </div>
                  <div class="col-sm-6"><input type="input" disabled name="id" class="form-control" value="'.$row["product_id"].'"></div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Title: </div>
                  <div class="col-sm-6"><input type="input" name="title" class="form-control" value="'.$row["product_title"].'"></div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Price: </div>
                  <div class="col-sm-6"><input type="input" name="price" class="form-control" value="'.$row["product_price"].'"></div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Description: </div>
                  <!--<div class="col-sm-6"><input type="input" name="description" class="form-control" value="'.$row["product_description"].'"></div>-->
                  <div class="col-sm-6"><textarea name="description" class="form-control" rows="10">'.$row["product_description"].'</textarea></div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Image: </div>
                  <div class="col-sm-6"><input type="input" name="image" class="form-control" value="'.$row["product_image"].'"></div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-4 text-right font-second align-self-center" style="font-size: 25px;">Number: </div>
                  <div class="col-sm-6"><input type="input" name="number" class="form-control" value="'.$row["product_number"].'"></div>
                </div>
                <br>
                <div class="row justify-content-center">
                  <div class="col-sm-6 text-right font-second align-self-center"><input type="submit" style="font-size: 20px;" class="btn btn-success w-100 h-100" name="edit" value="Edit"></div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 text-center font-second" style="font-size: 25px; color: darkred;">'.$errorText.'</div>
                </div>
                <br>
              </div>
            </div>
          </form>
        ';
      }
    } else {
      echo "Böyle bir ürün mevcut değil.";
    }
  } else {
    $result = $cnn->query("SELECT * FROM products WHERE product_added_by = '".$_SESSION["user"]."' ORDER BY product_added_time DESC");
    if ($result->num_rows > 0){
      echo '
        <form method="POST">
          <div class="container-fluid my-content">
            <div class="container">
              <div class="row">
             ';
              while ($row = $result->fetch_assoc()){
                echo '
                <div class="col-lg-4">
									<br>
									<div class="row">
                    <div class="col-lg-12 font-second">'.$row["product_id"]." ".$row["product_title"].'</div>
									</div>
									<br>
                  <div class="row">
                    <div class="col-lg-12 text-center"><a href="post?id='.$row["product_id"].'"><div style="width: 100%; height: 250px; background-image: url('.$row["product_image"].'); background-repeat: no-repeat; background-size: cover; background-position: center;"></div></a></div>
		  						</div>
									<br>	
                  <div class="row">
                    <div class="col-lg-12"><a href="manage-posts?option=edit&id='.$row["product_id"].'"><p class="btn btn-warning w-100 font-second">Edit '.$row["product_title"].'</p></a></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><a href="manage-posts?option=remove&id='.$row["product_id"].'"><p class="btn btn-danger w-100 font-second">Remove '.$row["product_title"].'</p></a></div>
										</div>
										<br>
                </div>
                ';
              }
            echo '
              </div>
            </div>
          </div>
        </form>
      ';
    } else {
      echo '
        <div class="container-fluid my-content">
          <div class="container text-center" style="height: 500px; line-height: 200px;"><br><h3>hiç gönderiniz yok!</h3><a href="manage-posts?option=add" style="font-size: 20px;">Yeni bir tane oluşturun!</a></div>
        </div>
      ';
    }
  }
} else if ($_GET["option"] == "remove"){
  if (isset($_GET["id"])){
    $cnn->query("DELETE FROM products WHERE product_id = ".$_GET["id"]);
    $cnn->query("DELETE FROM shopping_cart WHERE product_id = ".$_GET["id"]);
    header("Location: index");
  } else {
    header("Location: index");
  }
} else {
  header("Location: index");
} 
?>

<?php include("src/php/footer.php"); ?>
