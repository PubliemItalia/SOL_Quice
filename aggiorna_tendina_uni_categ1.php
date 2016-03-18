<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$categ = $_GET['categ'];
$shop = $_GET['shop'];
$soloshop = $_GET['soloshop'];
    if ($soloshop == "") {
	  $output .= '<select name="unita" class="codice_lista_nopadding" id="unita" style="height:27px; width: 90%;">
		<option selected value="">Scegli unit&agrave;</option>';
	  if ($shop == "") {
		$sqlr = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda WHERE categoria = '$categ' ORDER BY nome_unita ASC";
	  } else {
		$sqlr = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda WHERE categoria = '$categ' AND negozio = '$shop' ORDER BY nome_unita ASC";
	  }
	} else {
//	  $output .= '<select name="unita" class="codice_lista_nopadding" id="unita" style="height:27px; width: 90%;" onchange="agg_tendina_categ_unita(this.value)">
	  $output .= '<select name="unita" class="codice_lista_nopadding" id="unita" style="height:27px; width: 90%;">
		<option selected value="">Scegli unit&agrave;</option>';
	  $sqlr = "SELECT DISTINCT id_unita,nome_unita FROM qui_righe_rda WHERE negozio = '$shop' ORDER BY nome_unita ASC";
	}
	$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione10" . mysql_error());
	while ($rigar = mysql_fetch_array($risultr)) {
	  if ($rigar[id_unita] != "") {
		  $output .= '<option value="'.$rigar[id_unita].'">'.str_replace("_"," ",$rigar[nome_unita]).'</option>';
	  }
	}
  $output .= '</select>';
/*
*/
//output finale
echo $output;
//echo "ciao";

