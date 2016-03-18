<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id_utente = $_SESSION[user_id];
$unita = $_GET['unita'];
$categoria = $_GET['categoria'];
$shop = $_GET['shop'];

$output .= "<strong>Unit&agrave;</strong><br>";
$output .= "<select name=\"unita\" class=\"codice_lista_nopadding\" id=\"unita\" style=\"height:20px; font-size:12px;\" onChange=\"avviso_filtri_on('1'); agg_tendina_categ(this.value);\">";
$output .= "<option selected value=\"\">Scegli unita</option>";
	
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
	  $sqlg = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda WHERE stato_ordine = '4' AND ".$blocco_negozi_buyer." ORDER BY nome_unita ASC";
	} else {
	  $sqlg = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda WHERE stato_ordine = '4' AND negozio = '$shop' ORDER BY nome_unita ASC";
	}
	  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
	  while ($rigag = mysql_fetch_array($risultg)) {
	  if ($rigag[id_unita] == $unita) {
	  $output .= "<option selected value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
	  } else {
	  $output .= "<option value=".$rigag[id_unita].">".$rigag[nome_unita]."</option>";
	  }
	  }
	
	$output .= "</select>";
/*
*/
//output finale
echo $output;
//echo "ciao";
 ?>
