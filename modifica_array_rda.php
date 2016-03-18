<?php
session_start();

$check = $_GET['check'];
$id_rda = $_GET['id_rda'];
$stringa_rda = $_GET['array_rda'];
if ($stringa_rda != "") {
$array_rda = explode(",",$stringa_rda);
} else {
$array_rda = array();
}
if ($check == 0) {
  foreach($array_rda as $sing_rda) {
	  if ($sing_rda == $id_rda) {
		$key = array_search($sing_rda,$array_rda);
		if($key!==false){
			unset($array_rda[$key]);
		}
	  }
}
} else {
  if (!in_array($id_rda,$array_rda)) {
	  $add_rda = array_push($array_rda,$id_rda);
  }
}
  $x = 0;
  foreach($array_rda as $sing_rda)  {
	  if ($x == 0) {
	  $varstringrda = $sing_rda;
	  } else {
	  $varstringrda .= ",".$sing_rda;
	  }
	  $x = $x+1;
  }
  if (substr($varstringrda,0,1) == ",") {
	  $varstringrda = substr($varstringrda,1);
  }
$output .= '<input name="js_array_rda" id="js_array_rda" type="hidden" value="'.$varstringrda.'" />';
//output finale
echo $output;
//echo "ciao";

