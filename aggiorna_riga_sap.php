<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id_riga = $_GET['id_riga'];
$id_rda = $_GET['id_rda'];


$querya = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
  $result = mysql_query($querya);
  while ($row = mysql_fetch_array($result)) {
	if ($row[flag_buyer] == 4) {
		$check = "2";
	} else {
		$check = "4";
	}
	 $query = "UPDATE qui_righe_rda SET flag_buyer = '$check' WHERE id = '$id_riga'";
	  if (mysql_query($query)) {
	  } else {
		$tab_output .= "Errore durante l'inserimento: ".mysql_error();
	  }
  }

//echo $tab_output;
 ?>
