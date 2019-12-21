<?php

session_start();
if (isset($_SESSION["user"])){
	include("src/php/header-user.php");
	if (isAdmin($_SESSION["user"]) == false){
		header("Location: index");
	}
} else {
	header("Location: index");
}

$result = $cnn->query("SELECT * FROM site_values");
if ($result->num_rows > 0){
	while ($row = $result->fetch_assoc()){
		$headerLogo = $row["header_logo"];	
		$headerText = $row["header_text"];	
		$headerMotto = $row["header_motto"];	
		$footerLogo = $row["footer_logo"];	
		$footerText = $row["footer_text"];	
		$footerMotto = $row["footer_motto"];	
		$tabLogo = $row["tab_logo"];	
		$tabText = $row["tab_text"];	
	}
}

include("src/php/db.php");
if (isset($_POST["submit_manage_site_values"])){
	$cnn->query("UPDATE site_values SET header_logo = '".$_POST["input_header_logo"]."', header_text = '".$_POST["input_header_text"]."', header_motto = '".$_POST["input_header_motto"]."', footer_logo = '".$_POST["input_footer_logo"]."', footer_text = '".$_POST["input_footer_text"]."', footer_motto = '".$_POST["input_footer_motto"]."', tab_logo = '".$_POST["input_tab_logo"]."', tab_text = '".$_POST["input_tab_text"]."' WHERE 1");
	header("Location: manage-site-values");	
}

?>

<form method="POST" action="">
<div class="container-fluid my-content">
	<div class="container border">
		<div class="row">
			<div class="col-sm-12"><br></div>
			<div class="col-sm-12 font-second text-center" style="font-size: 25px;">Manage Site Values</div>
			<div class="col-sm-12"><br></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3 font-second text-right align-self-center">Header Logo: </div>
			<div class="col-sm-7"><input type="input" name="input_header_logo" class="form-control" value="<?php echo $headerLogo; ?>"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3 font-second text-right align-self-center">Header Text: </div>
			<div class="col-sm-7"><input type="input" name="input_header_text" class="form-control" value="<?php echo $headerText; ?>"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3 font-second text-right align-self-center">Header Motto: </div>
			<div class="col-sm-7"><input type="input" name="input_header_motto" class="form-control" value="<?php echo $headerMotto; ?>"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3 font-second text-right align-self-center">Footer Logo: </div>
			<div class="col-sm-7"><input type="input" name="input_footer_logo" class="form-control" value="<?php echo $footerLogo; ?>"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3 font-second text-right align-self-center">Footer Text: </div>
			<div class="col-sm-7"><input type="input" name="input_footer_text" class="form-control" value="<?php echo $footerText; ?>"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3 font-second text-right align-self-center">Footer Motto: </div>
			<div class="col-sm-7"><input type="input" name="input_footer_motto" class="form-control" value="<?php echo $footerMotto; ?>"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3 font-second text-right align-self-center">Tab Logo: </div>
			<div class="col-sm-7"><input type="input" name="input_tab_logo" class="form-control" value="<?php echo $tabLogo; ?>"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3 font-second text-right align-self-center">Tab Text: </div>
			<div class="col-sm-7"><input type="input" name="input_tab_text" class="form-control" value="<?php echo $tabText; ?>"></div>
		</div>
		<br>
		<div class="row justify-content-center">
			<div class="col-sm-8"><input type="submit" name="submit_manage_site_values" class="btn btn-success w-100 h-100" value="Update"></div>
		</div>
		<br>
	</div>
</div>
</form>

<?php include("src/php/footer.php"); ?>
