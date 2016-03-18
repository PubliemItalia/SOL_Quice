<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$id_riga = $_GET['id_riga'];
$quant_evasa = $_GET['quant_evasa'];
$sqln = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigan = mysql_fetch_array($risultn)) {
	$originale_quant = $rigan[quant];
	$prezzo_prodotto = $rigan[prezzo];
	$codice_art = $rigan[codice_art];
	$negozio_riga = $rigan[negozio];
}
// $tab_output .= $quant_residua;
if ($negozio_riga == "labels") {
  $sqlr = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$codice_art'";
  $risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
  while ($rigar = mysql_fetch_array($risultr)) {
	if ($rigar[ric_mag] == "mag") {
		$prezzo_prodotto = $rigar[prezzo];
	}
  }
}
$quant_residua = $originale_quant - $quant_evasa;
$totale_evaso = $quant_evasa * $prezzo_prodotto;
$totale_da_evadere = $quant_residua * $prezzo_prodotto;

$sqln = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigan = mysql_fetch_array($risultn)) {

$tab_output .= "<div class=columns_righe1>";
//div codice riga
$tab_output .= "<div id=confez5_riga style=\"padding-left:10px;\">";
if (substr($rigan[codice_art],0,1) != "*") {
  $tab_output .= $rigan[codice_art];
} else {
  $tab_output .= substr($rigan[codice_art],1);
}
//fine div codice riga
$tab_output .= "</div>";

//div descrizione riga
$tab_output .= "<div class=descr4_riga style=\"width:430px;\">";
$tab_output .= $rigan[descrizione];
//fine div descrizione riga
$tab_output .= "</div>";


//div nome unità riga
$tab_output .= "<div class=cod1_riga>";
$tab_output .= $rigan[nome_unita];
//fine div nome unità riga
$tab_output .= "</div>";
//div quant riga
$tab_output .= "<div class=price6_riga_quant>";
$tab_output .= intval($quant_residua);
$tab_output .= "</div>";



//div pulsante per evasione parziale riga
$tab_output .= "<div class=lente_prodotto>";
//fine div pulsante per evasione parziale riga
$tab_output .= "</div>";

//div pulsante per visualizzare scheda
$tab_output .= "<div class=lente_prodotto>";
//fine div pulsante per visualizzare scheda
$tab_output .= "</div>";
//div totale riga
$tab_output .= "<div class=price6_riga>";
$tab_output .= number_format($totale_da_evadere,2,",",".");
//fine div totale riga
$tab_output .= "</div>";

//div output mode riga (vuoto)
switch ($rigan[output_mode]) {
case "":
$button_style = "vuoto9_riga";
break;
case "mag":
$button_style = "style_mag";
break;
case "sap":
$button_style = "style_sap";
break;
case "ord":
$button_style = "style_ord";
break;
}
$tab_output .= "<div class=".$button_style.">";
//fine div output mode riga
$tab_output .= "</div>";

//div evaso (vuoto)
$tab_output .= "<div class=vuoto9_riga>";
//fine div evaso
$tab_output .= "</div>";
//div checkbox (vuoto)
$tab_output .= "<div class=sel_all_riga id=".$rigan[id].">";
//fine div checkbox
$tab_output .= "</div>";

//fine contenitore riga tabella
$tab_output .= "</div>";

//fine foreach
if ($sf == 1) {
$sf = 0;
} else {
$sf = 1;
}
}
/*
*/
//fine blocco sing rda
//output finale
//echo "pippo";
echo $tab_output;
 ?>
