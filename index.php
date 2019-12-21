<?php
session_start();
if (isset($_SESSION["user"])){
	include "src/php/header-user.php";
} else {
	include "src/php/header.php";
}
?>

<div class="container-fluid my-content">
	<!--<div class="container">-->
		<div class="row justify-content-center">
		
		<?php
		$result = $cnn->query("SELECT * FROM products ORDER BY product_added_time DESC");
		if ($result->num_rows > 0){
			while ($row = $result->fetch_assoc()){
		?>
		
			<div class="col-lg-3 post" style="border-bottom: 5px solid #3498DB; box-shadow: 25px;">
				<a href="post?id=<?php echo $row['product_id']; ?>"><div class="row">
					<div class="col-lg-12" style="width: 100%; height: 225px; background-image: url(<?php echo $row["product_image"]; ?>); background-size: 	cover; background-repeat: no-repeat; background-position: center;"></div>
				</div></a>
				<div class="row">
					<div class="col-lg-12 font-second text-center text-break" style="font-size: 20px;"><?php echo $row["product_title"]; ?></div>
				</div>
				<div class="row">
					<div class="col-lg-12 font-second text-center"><?php echo $row["product_price"]; ?> TL</div>
				</div>
				<div class="row">
					<div class="col-lg-12 font-second text-center"><a href="post?id=<?php echo $row['product_id']; ?>" class="btn btn-primary w-75 h-100" style="border-radius: 0px; border-top-left-radius: 20px; border-top-right-radius: 20px;">Ürün Sayfasına Git</a></div>
				</div>
			</div>

		<?php
			}
		}
		?>
		
		</div>
	<!--</div>-->
</div>

<?php
include "src/php/footer.php";
?>