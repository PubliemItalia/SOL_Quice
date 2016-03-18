<?php
session_start();
$lingua = $_SESSION['lang'];
$conf = $_GET['conf'];
if ($conf == "si_bomb") {
  switch ($lingua) {
	case "it":
	$puls_carr = "Procedi con la scelta delle bombole";
	break;
	case "en":
	$puls_carr = "Continue with cylinders choice";
	break;
  }
  $output .= "<input type=button name=button style=\"float:right; height:25px; cursor:pointer;\" onClick=\"goToCylinders()\" id=button value=\"".$puls_carr."\">";
} else {
  switch ($lingua) {
	case "it":
	$puls_carr = "Inserisci nel carrello";
	break;
	case "en":
	$puls_carr = "Add to cart";
	break;
  }
  $output .= "<input type=hidden name=conf id=conf value=".$conf.">";
  $output .= "<input type=submit name=submit style=\"float:right; height:25px; cursor:pointer;\" onClick=\"validateForm()\" id=submit value=\"".$puls_carr."\">";
}
echo $output;
 ?>
