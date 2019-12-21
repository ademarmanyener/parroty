<?php

include("src/php/db.php");
session_start();
if (isset($_SESSION["user"])){
	$result = $cnn->query("SELECT * FROM users WHERE username = '".$_SESSION["user"]."'");
	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			if ($row["permission"] == "admin"){	
							
				if (isset($_GET["remove_user"]) && $row["permission"] == "admin" && isset($_SESSION["user"])){
					$cnn->query("DELETE FROM users WHERE username='".$_GET["remove_user"]."'");		
				}

				if (isset($_POST["edit_user_save"]) && isset($_GET["edit_user"]) && $row["permission"] == "admin" && isset($_SESSION["user"])){
					$cnn->query("UPDATE users SET username = '".$_GET["edit_user"]."', password = '".$_POST["edit_user_password"]."', avatar = '".$_POST["edit_user_avatar"]."', added_time = '".$_POST["edit_user_added_time"]."' WHERE username = '".$_GET["edit_user"]."'");
					header("Location: manage-users");
				}

				if (isset($_GET["edit_user"]) && $row["permission"] == "admin" && isset($_SESSION["user"])){
					$result = $cnn->query("SELECT * FROM users WHERE username = '".$_GET["edit_user"]."'");			
					if ($result->num_rows > 0){
						while ($row = $result->fetch_assoc()){
							$user_password = $row["password"];
							$user_avatar = $row["avatar"];
							$user_added_time = $row["added_time"];
							$user_permission = $row["permission"];
						}
					}
					
					echo '
						<form method="POST" action="">
							<div class="container-fluid my-content">
								<div class="row">
									<div class="col-md-3">
										<div class="row">
											<div class="col-md-4 text-right align-self-center">Kullanıcı Adı: </div>								
											<div class="col-md-8 align-self-center"><input type="input" name="edit_user_username" value="'.$_GET["edit_user"].'" class="form-control w-100 h-100"></div>								
										</div>
									</div>
									<div class="col-md-2">
										<div class="row">
											<div class="col-md-4 text-right align-self-center">Şifre: </div>								
											<div class="col-md-8 align-self-center"><input type="input" name="edit_user_password" value="'.$user_password.'" class="form-control w-100 h-100"></div>								
										</div>
									</div>
									<div class="col-md-2">
										<div class="row">
											<div class="col-md-4 text-right align-self-center">Avatar: </div>								
											<div class="col-md-8 align-self-center"><input type="input" name="edit_user_avatar" value="'.$user_avatar.'" class="form-control w-100 h-100"></div>								
										</div>
									</div>
									<div class="col-md-3">
										<div class="row">
											<div class="col-md-4 text-right align-self-center">Kayıt Tarihi: </div>								
											<div class="col-md-8 align-self-center"><input type="input" name="edit_user_added_time" value="'.$user_added_time.'" class="form-control w-100 h-100"></div>								
										</div>
									</div>
									<div class="col-md-2">
										<div class="row">
											<div class="col-md-12 text-center align-self-center"><input type="submit" class="btn btn-success w-100 h-100" name="edit_user_save" value="Değişiklikleri Kaydet"></div>								
										</div>
									</div>
								</div>
							</div>
						</form>
					';
				}

				if (isset($_GET["make_admin"]) && $row["permission"] == "admin" && isset($_SESSION["user"])){
					$cnn->query("UPDATE users SET permission='admin' WHERE username='".$_GET["make_admin"]."'");
					header("Location: manage-users");
				}

				if (isset($_GET["make_normal"]) && $row["permission"] == "admin" && isset($_SESSION["user"])){
					$cnn->query("UPDATE users SET permission='normal' WHERE username='".$_GET["make_normal"]."'");
					header("Location: manage-users");
				}
				
				include("src/php/header-user.php");
				echo '
					<form method="POST" action="">
					<div class="container-fluid my-content" style="padding-top: 25px; padding-bottom: 25px;">
						<div class="container">
							<div class="row">';

							$result = $cnn->query("SELECT * FROM users ORDER BY added_time DESC");
							if ($result->num_rows > 0){
								while ($row = $result->fetch_assoc()){
									if ($row["username"] != $_SESSION["user"]){
										echo '
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-12 text-center"><a href="profile?username='.$row["username"].'"><div style="width: 100%; height: 250px; background-image: url('.$row["avatar"].'); background-repeat: no-repeat; background-size: cover; background-position: center;"></div></a></div>
												</div>
												<div class="row">
													<div class="col-md-12 text-center font-second" style="font-size: 25px;">'.$row["username"].'</div>
												</div>
												<div class="row">';
												if ($row["permission"] != "admin"){
													echo '<div class="col-md-12 text-center"><a href="manage-users?make_admin='.$row["username"].'" class="btn btn-success w-100 h-100" style="border-radius: 0px;">Make Admin</a></div>';
												} else {
													echo '<div class="col-md-12 text-center"><a href="manage-users?make_normal='.$row["username"].'" class="btn btn-danger w-100 h-100" style="border-radius: 0px;">Make Normal</a></div>';
												}
										echo '<div class="col-md-12 text-center"><a href="manage-users?edit_user='.$row["username"].'" class="btn btn-warning w-100 h-100" style="border-radius: 0px;">Edit '.$row["username"].'</a></div>
													<div class="col-md-12 text-center"><a href="manage-users?remove_user='.$row["username"].'" class="btn btn-danger w-100 h-100" style="border-radius: 0px;">Remove '.$row["username"].'</a></div>
												</div>
											</div>
										';
									}
								}
							}
								
				echo '</div>
						</div>
					</div>
					</form>
				';
				include("src/php/footer.php");
			} else {
				header("Location: index");
			}
		}
	} else {
		header("Location: index");
	}
} else {
	header("Location: index");
}

?>
