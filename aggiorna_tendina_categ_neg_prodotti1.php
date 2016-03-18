<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$shop = $_GET['shop'];

$output .= '<select name="categoria_ricerca" class="codice_lista_nopadding" id="categoria_ricerca" style="height:27px; width:90%;">';
$output .= '<option selected value="">Tutte</option>';


	  $sqlt = "SELECT DISTINCT categoria1_it FROM qui_prodotti_".$shop." ORDER BY categoria1_it ASC";
  $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
  while ($rigat = mysql_fetch_array($risultt)) {
	  $output .= "<option value=".$rigat[categoria1_it].">".ucfirst(str_replace("_"," ",$rigat[categoria1_it]))."</option>";
  }
	
  $output .= "</select>";
/*
*/
//output finale
echo $output;
//echo "ciao";

