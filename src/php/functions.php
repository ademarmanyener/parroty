<?php

/*function announcement($visibility){
	if ($visibility == "users"){
		$result = $cnn->query("SELECT * FROM announcements WHERE visibility = 'everyone' OR visibility = 'users'");
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
	} else if ($visibility == "everyone"){
			$result = $cnn->query("SELECT * FROM announcements WHERE visibility = 'everyone' OR visibility = 'users'");
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
	}
}*/

function getSocialLinks($site){
	include("src/php/db.php");
	$result = $cnn->query("SELECT * FROM links WHERE site = '$site'");
	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			return $row["link"];
		}
	} else {
		return false;
	}
}


function isAdmin($username){
	include("src/php/db.php");
	$result = $cnn->query("SELECT * FROM users WHERE username = '".$username."'");
	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			if ($row["permission"] == "admin"){
				return true;
			} else {
				return false;
			}
		}	
	} else {
		return false;
	}
}

function getSiteValues($option){
	include("src/php/db.php");
	$result = $cnn->query("SELECT * FROM site_values");
	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			return $row[$option];
		}
	} else {
		return false;
	}
}

function getUsersAvatar($username){
	include "src/php/db.php";
	$result = $cnn->query("SELECT * FROM users WHERE username = '".$username."'");
	$tempValue;
	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			$tempValue = $row["avatar"];
		}
		return $tempValue;
	} else {
		return 1;
	}
}

?>
