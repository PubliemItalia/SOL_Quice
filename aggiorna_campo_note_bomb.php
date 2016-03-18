<?php
session_start();
$conf = $_GET['conf'];
$lingua = $_SESSION['lang'];
if ($conf == "si_bomb") {
   $output .= "";
} else {
  switch ($lingua) {
	case "it":
	$note = "Caratteristiche delle bombole";
	break;
	case "en":
	$note = "Cylinders specifications";
	break;
  }
   $output .= "<textarea name=note style=\"width:100%; font-family:Arial; font-size:12px; background-color:#FFFFCC;\" rows=5 id=note>".$note."</textarea>";
  }
echo $output;
 ?>
