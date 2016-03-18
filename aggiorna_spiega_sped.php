<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id = $_GET['id'];
$lingua = $_GET['lang'];
	  $sqlp = "SELECT * FROM qui_spedizioni WHERE id = '".$id."'";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigap = mysql_fetch_array($risultp)) {
		$costo_aggiuntivo =  $rigap[prezzo];
		switch ($lingua) {
		  case "it":
			  $output =  $rigap[spiega_it];
		  break;
		  case "en":
			  $output =  $rigap[spiega_en];
		  break;
		}
	  }
	  if ($costo_aggiuntivo > 0) {
		$output .= number_format($costo_aggiuntivo,2,",",".").' euro';
	  }
echo $output;
 ?>
