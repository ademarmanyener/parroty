<?php
include("src/php/base-top.php");
include("src/php/db.php");


include "src/php/minibots.class.php";


$curl=curl_init('https://localhost/phpmyadmin');//CURL BAŞLATMA
$gelenveri = curl_exec($curl);//ÇALIŞTIR
curl_close($curl);//KAPAT
echo $gelenveri;//EKRANA YAZDIR.
//CURL SEÇENEKLİ KULLANMA
$curl=curl_init();//CURL BAŞLATMA
$adres='https://localhost/phpmyadmin';
curl_setopt($curl,CURLOPT_URL,$adres);//CURL ADRES BELİRLEME
curl_setopt($curl,CURLOPT_POST,true);//CURL POST ONAYI
$gelenveri = curl_exec($curl);//ÇALIŞTIR
curl_close($curl);//KAPAT
echo $gelenveri;//EKRANA YAZDIR.

/*
$sayfada = 1; // sayfada gösterilecek içerik miktarını belirtiyoruz.
 
$sorgu = $cnn->query('SELECT COUNT(*) AS toplam FROM products');
$sonuc = $sorgu->fetch_assoc();
echo $sorgu->fetch_assoc();
$toplam_icerik = $sonuc['toplam'];
 
$toplam_sayfa = ceil($toplam_icerik / $sayfada);
 
$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
 
if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
 
$limit = ($sayfa - 1) * $sayfada;
$sorgu = $cnn->query('SELECT * FROM products LIMIT ' . $limit . ', ' . $sayfada);
 
while($icerik = $sorgu->fetch_assoc()) {
	?>

	<div class="row" style="background-color: white;">
		<div class="col-sm-12"><?php echo $icerik["product_title"] ?></div>
	</div>

	<?php
}
 
for($s = 1; $s <= $toplam_sayfa; $s++) {
   if($sayfa == $s) { // eğer bulunduğumuz sayfa ise link yapma.
      echo $s . ' '; 
   } else {
      echo '<a class="bg-light" href="?sayfa=' . $s . '">' . $s . '</a> ';
   }
}*/


?>