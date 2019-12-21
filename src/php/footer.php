<?php
//include("src/php/functions.php");
?>

<div class="container-fluid my-footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 text-center"><br><img height="200" src="<?php echo getSiteValues("footer_logo"); ?>"><br><br></div>
			<div class="col-lg-4 align-self-center text-center"><?php echo getSiteValues("footer_text"); ?> <?php echo getSiteValues("footer_motto"); ?></div>
			<div class="col-lg align-self-end">
				<div class="row">
				<div class="col-sm"><a href="<?php echo getSocialLinks('facebook'); ?>" target="_blank"><button class="w-100 btn"><img height="50" src="src/img/social_medias/facebook.png"></a></button></div>
					<div class="col-sm"><a href="<?php echo getSocialLinks('twitter'); ?>" target="_blank"><button class="w-100 btn"><img height="50" src="src/img/social_medias/twitter.png"></a></button></div>
					<div class="col-sm"><a href="<?php echo getSocialLinks('youtube'); ?>" target="_blank"><button class="w-100 btn"><img height="50" src="src/img/social_medias/youtube.png"></a></button></div>
					<div class="col-sm"><a href="<?php echo getSocialLinks('instagram'); ?>" target="_blank"><button class="w-100 btn"><img height="50" src="src/img/social_medias/instagram.png"></a></button></div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center text-light font-second" style="background-color: #212F3C; border-top: 5px solid #58D68D; border-top-left-radius: 25px; border-top-right-radius: 25px; font-size: 15px; padding-top: 25px; padding-bottom: 25px;">
			@2019 - Anıl Adem Yener
		</div>
	</div>
</div>
<?php include("src/php/base-bottom.php"); ?>
