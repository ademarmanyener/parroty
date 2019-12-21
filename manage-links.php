<?php
include("src/php/base-top.php");
include("src/php/db.php");
//include("src/php/functions.php");
session_start();

if (isset($_GET["remove"]) && isset($_SESSION["user"]) && isAdmin($_SESSION["user"]) != false){
	//include("src/php/db.php");
	$cnn->query("DELETE FROM links WHERE site = '".$_GET["remove"]."'");
	header("Location: manage-links");	
}

if (isset($_SESSION["user"]) && isAdmin($_SESSION["user"]) != false){
	//include("src/php/base-top.php");
	//include("src/php/db.php");

		if (isset($_POST["submit_add"])){
			$site = $_POST["input_add_site"];	
			$link = $_POST["input_add_link"];	
			$canAdd = 1;
			$result = $cnn->query("SELECT * FROM links WHERE site = '".$_POST["input_add_site"]."'");
			if ($result->num_rows > 0){
				$canAdd = 0;
			}

			if ($canAdd == 1){
				$cnn->query("INSERT INTO links VALUES ('".$_POST["input_add_site"]."', '".$_POST["input_add_link"]."')");
				header("Location: manage-links");	
			} else if ($canAdd == 0) {
				echo "<p class='text-white font-second text-center'>you can't add.</p>";
			}
		}

?>
<!-- showing this part if user is admin -->

<form method="POST" action="">
<div class="container-fluid my-content">
	<div class="container border">
		<div class="row justify-content-center">
			<div class="col-sm-5 text-center"><a href="index"><img src="src/img/logo.png"></a></div>
		</div>
		<div class="row">
			<div class="col-sm-12"><br></div>
			<div class="col-sm-12 text-center"><h3 class="font-second">Manage Links</h3></div>
			<div class="col-sm-12"><br></div>
		</div>
		<div class="row">
			<div class="col-sm-4 text-center"><h4 class="font-second">SİTE</h4></div>
			<div class="col-sm-4 text-center"><h4 class="font-second">LİNK</h4></div>
			<div class="col-sm-4"></div>
		</div>
		<div class="row border">
			<div class="col-sm-4"><input type="input" class="form-control font-second w-100 h-100" name="input_add_site"></div>
			<div class="col-sm-4"><input type="input" class="form-control font-second w-100 h-100" name="input_add_link"></div>
			<div class="col-sm-4"><input type="submit" class="btn btn-success font-second w-100 h-100" name="submit_add" value="Ekle"></div>
		</div>
		<?php
		$result = $cnn->query("SELECT * FROM links");
		if ($result->num_rows > 0){
			while ($row = $result->fetch_assoc()){
				?>
					<div class="row border">
						<div class="col-sm-4"><p class="font-second text-center"><?php echo $row["site"]; ?></p></div>
						<div class="col-sm-4"><p class="font-second text-center"><?php echo $row["link"]; ?></p></div>
						<div class="col-sm-4"><a href="manage-links?remove=<?php echo $row["site"]; ?>" class="btn btn-danger font-second w-100 h-100" name="submit_remove">Kaldır</a></div>
					</div>
				<?php
			}
		}		
		?>
	</div>
</div>
</form>

<?php
} else {
	header("Location: index");
}

?>
