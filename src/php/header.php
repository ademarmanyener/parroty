<?php include("src/php/base-top.php"); ?>
<?php //include("src/php/functions.php"); ?>

<?php

include("src/php/db.php");
$result = $cnn->query("SELECT * FROM announcements WHERE visibility = 'everyone'");
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

<div class="container-fluid my-header">
	<div class="container">
		<div class="row text-center">
			<div class="col-lg-1"><img onclick="window.location.href='index'" height="100" src="<? echo getSiteValues('header_logo'); ?>"></div>
			<div class="col-lg-8 align-self-center"><?php echo getSiteValues("header_text"); ?> <?php echo getSiteValues("header_motto"); ?></div>
			<div class="col-lg align-self-center"><button onclick="window.location.href='login-register'" class="btn btn-warning w-100 h-100">Giriş Yap/Kayıt Ol</button></div>
			<div class="col-lg-1 align-self-center"><a href="<?php echo getSocialLinks("git"); ?>" target="_blank"><button class="btn btn-link w-100 h-100">git</button></a></div>
		</div>
	</div>
</div>
