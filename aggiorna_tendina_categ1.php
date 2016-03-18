<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$unita = $_GET['unita'];
$categoria = $_GET['categoria'];
$shop = $_GET['shop'];

$output .= "<strong>Categoria</strong><br>";
$output .= "<select name=\"categoria_ricerca\" class=\"codice_lista_nopadding\" id=\"categoria_ricerca\" style=\"height:20px; font-size:12px;\" onChange=\"avviso_filtri_on('1'); agg_tendina_unita(this.value);\">";
$output .= "<option selected value=\"\">Tutte</option>";
	
  $sqlt = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE (stato_ordine != '4' OR stato_ordine != '0') AND id_unita = '$unita' ORDER BY categoria ASC";
  $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
  while ($rigat = mysql_fetch_array($risultt)) {
    if ($rigat[categoria] != "") {
    if ($rigat[categoria] == $categoria) {
	  $output .= "<option selected value=".$rigat[categoria].">".ucfirst(str_replace("_"," ",$rigat[categoria]))."</option>";
	} else {
	  $output .= "<option value=".$rigat[categoria].">".ucfirst(str_replace("_"," ",$rigat[categoria]))."</option>";
	}
  }
  }
	
  $output .= "</select>";
/*
*/
//output finale
echo $output;
//echo "ciao";

