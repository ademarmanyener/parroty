<div class="container-fluid">
	<div class="row my-content">

<?php

include("src/php/db.php");

if ($cnn->connect_error){
	echo "error: ".$cnn->connect_erro;
}

$result = $cnn->query("SELECT * FROM products ORDER BY product_added_time DESC");

if ($result->num_rows > 0){
	while ($row = $result->fetch_assoc()){
		echo "
		<div class='col-xl-3 my-post'><a href='post?id=".$row["product_id"]."'>
			<div class='row justify-content-center'><div style='width: 100%; height: 225px; background-image: url(".$row["product_image"]."); background-repeat: none; background-size: cover; background-position: center;'></div></div>
			<div class='row'><p style='margin-left: 10px;'>".$row["product_title"]."</p></div>
			<div class='row'><p style='margin-left: 10px;'>Fiyat: ".$row["product_price"]." TL</p></div>
			<div class='row'><button class='btn btn-warning w-100 col-lg-12'>'".$row["product_title"]."' ürün detayı</button></div>			
		</a></div>
		";
	}
} else {
	echo "no post!";
}

$cnn->close();

?>
	
	</div>
</div>
