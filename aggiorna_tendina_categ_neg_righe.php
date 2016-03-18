<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$unita = $_GET['unita'];
$categoria = $_GET['categoria'];
$shop = $_GET['shop'];
$id_utente = $_SESSION[user_id];

$output .= "<strong>Categoria</strong><br>";
$output .= "<select name=\"categoria_righe\" class=\"codice_lista_nopadding\" id=\"categoria_righe\" style=\"height:20px; font-size:12px;\" onChange=\"avviso_filtri_on('1'); agg_tendina_unita(this.value);\">";
$output .= "<option selected value=\"\">Tutte</option>";

	$sqlt = "SELECT * FROM qui_buyer_negozi WHERE id_utente = '$id_utente' ORDER BY preferenza ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
	$num_negozi_buyer = mysql_num_rows($risultt);
	$z = 1;
    while ($rigat = mysql_fetch_array($risultt)) {
	  if ($z == 1) {
		$blocco_negozi_buyer .= "(negozio = '".$rigat[negozio]."'";
	  } else {
		$blocco_negozi_buyer .= " OR negozio = '".$rigat[negozio]."'";
	  }
	  $z = $z+1;
	  if ($z > $num_negozi_buyer) {
		$blocco_negozi_buyer .= ")";
	  }
	}

    if ($shop == "") {
	  $sqlt = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE (stato_ordine != '4' AND stato_ordine != '0') AND ".$blocco_negozi_buyer." ORDER BY categoria ASC";
	} else {
	  $sqlt = "SELECT DISTINCT categoria FROM qui_righe_rda WHERE (stato_ordine != '4' AND stato_ordine != '0') AND negozio = '$shop' ORDER BY categoria ASC";
	}
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

