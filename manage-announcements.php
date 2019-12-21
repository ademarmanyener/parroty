<?php

session_start();
include("src/php/db.php");
if (isset($_SESSION["user"])){
	$result = $cnn->query("SELECT * FROM users WHERE username = '".$_SESSION["user"]."' AND permission = 'admin'");
	if ($result->num_rows > 0){
		include("src/php/header-user.php");

?>

<?php

$result = $cnn->query("SELECT * FROM announcements");
if ($result->num_rows > 0){
	while ($row = $result->fetch_assoc()){
		$text = $row["text"];
		$added_by = $row["added_by"];
		$added_time = $row["added_time"];
		$visibility = $row["visibility"];
	}
}

if (isset($_POST["save_announcement"])){
	if (isset($_POST["visibility_check"])){
		$visibility = "everyone";
	} else {
		$visibility = "users";
	}
	$cnn->query("UPDATE announcements SET id = '0', text = '".$_POST["announcement_text"]."', added_by = '".$_SESSION["user"]."', added_time = '".date('d-m-Y H:i:s')."', visibility='".$visibility."' WHERE 1");
	header("Location: manage-announcements");
}

if (isset($_POST["disable_announcement"])){
	$cnn->query("UPDATE announcements SET id = '1' WHERE 1");
	header("Location: manage-announcements");
}

?>

<form method="POST" action="">
	<div class="container-fluid my-content">
		<div class="container">
			<br>
			<div class="row">
				<div class="col-sm-12 text-center font-second" style="font-size: 25px;">Duyuruları Düzenle</div>
			</div>
			<br>		
			<div class="row">
				<div class="col-sm-4 text-right align-self-center font-second" style="font-size: 20px;">Duyuru Yazısı: </div>
				<!--<div class="col-sm-4"><input type="input" name="announcement_text" value=<?php echo $text; ?> class="form-control align-self-center font-second" style="font-size: 20px;"></div>-->
			  <div class="col-sm-4"><textarea name="announcement_text" class="form-control" rows="5"><?php echo $text ?></textarea></div>
			</div>
			<br>		
			<div class="row">
				<div class="col-sm-12">
					<div class="form-check text-center">
					<input type="checkbox" class="form-check-input" name="visibility_check" <?php if ($visibility == "everyone"){ echo "checked"; } ?> id="visibility_checkbox">
						<label class="form-check-label" for="visibility_checkbox">Herkes Görsün Mü?</label>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12 text-center align-self-center"><input type="submit" name="save_announcement" class="btn btn-success w-50 h-100 font-second" style="font-size: 20px;" value="Duyuruyu Kaydet"></div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12 text-center align-self-center"><input type="submit" name="disable_announcement" class="btn btn-danger w-50 h-100 font-second" style="font-size: 20px;" value="Duyuruyu Devre Dışı Bırak"></div>
			</div>
			<br>
		</div>
	</div>
</form>

<?php

		include("src/php/footer.php");
	} else {
		header("Location: index");
	}
} else {
	header("Location: index");
}

?>
