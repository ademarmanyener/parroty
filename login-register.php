<?php include("src/php/header.php"); ?>

<?php

include("src/php/db.php");

session_start();
if (isset($_SESSION["user"])){
	header("Location: index");
}

if ($cnn->connect_error){
	echo "error: ".$cnn->connect_error;
}

if (isset($_POST["login"]) || isset($_POST["register"])){
	$username = $_POST["username"];
	$password = $_POST["password"];
}

$canRegister = 1;
$canLogin = 0;

$result = $cnn->query("SELECT * FROM users");

/*while ($row = $result->fetch_assoc()){
	if (isset($_POST["login"])){
		if ($row["username"] == $username && $row["password"] == $password){
			$canLogin = 1;
		} else {
			$canLogin = 0;
		}
	} else if (isset($_POST["register"])){
		if ($row["username"] != $username){
			$canRegister = 1;
		} else {
			$canRegister = 0;
		}
	}
}*/

if (isset($_POST["login"])){
	while ($row = $result->fetch_assoc()){
		if ($row["username"] == $username && $row["password"] == $password && $username != NULL && $password != NULL){
			$canLogin = 1;
		}
	}
} else if (isset($_POST["register"])){
	while ($row = $result->fetch_assoc()){
		if ($row["username"] == $username || $username == NULL || $password == NULL){
			$canRegister = 0;
		}
	}
}

$errorText = null;
if (isset($_POST["login"])){
	if ($canLogin == 1){
		echo "giriş başarılı!";
		session_start();
		$_SESSION["user"] = $username;
		header("Location: index");
	} else {
		$errorText = "Giriş işlemi başarısız.";
	} 
} else if (isset($_POST["register"])){
	if ($canRegister == 1){
		$cnn->query("INSERT INTO users VALUES('$username', '$password', 'src/img/logo-black.png', '".date('d-m-Y H:i:s')."', 'normal')");
		$errorText = "Kayıt işlemi başarılı.";
	} else {
		$errorText = "Kayıt işlemi başarısız.";
	}
}

$cnn->close();

?>

<form method="post" action="">
	<div class="container-fluid my-content">
	<br>
	<div class="container">
		<div class="row">
			<div class="col-sm text-right">Kullanıcı Adı: </div>
			<div class="col-sm"><input class="form-control" type="" name="username"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm text-right">Şifre: </div>
			<div class="col-sm"><input class="form-control" type="password" name="password"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm text-right"><input type="submit" name="register" class="btn btn-success" value="Register"></div>
			<div class="col-sm"><input type="submit" name="login" class="btn btn-primary" value="Login"></div>
		</div>
		<br>
		<div class="row">
		<div class="col-sm-12 text-center font-second" style="font-size: 25px; color: darkred"><?php echo $errorText; ?></div>
		</div>
		<br>
	</div>
	<br>
	</div>
</form>

<?php include("src/php/footer.php"); ?>
