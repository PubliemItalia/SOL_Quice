<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$categoria = $_GET['categoria'];
$id_utente = $_SESSION[user_id];
  $sqlt = "SELECT DISTINCT negozio FROM qui_righe_rda WHERE categoria = '".$categoria."'";
  $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
  while ($rigat = mysql_fetch_array($risultt)) {
	$shopDaModulo = $rigat[negozio];
  }

	$output .= "<strong>Negozio</strong><br>";
	$output .= "<select name=shop class=codice_lista_nopadding id=shop onChange=\"agg_tendina_unita_neg(this.value); agg_tendina_categ_neg(this.value);\">";
	switch ($shopDaModulo) {
	case "":
	$output .= "<option selected value=>Tutti</option>";
	$output .= "<option value=assets>Assets</option>";
	$output .= "<option value=consumabili>Consumabili</option>";
	$output .= "<option value=spare_parts>Ricambi</option>";
	$output .= "<option value=labels>Etichette</option>";
	$output .= "<option value=vivistore>Vivistore</option>";
	break;
	case "assets":
	$output .= "<option selected value=>Tutti</option>";
	$output .= "<option selected value=assets>Assets</option>";
	$output .= "<option value=consumabili>Consumabili</option>";
	$output .= "<option value=spare_parts>Ricambi</option>";
	$output .= "<option value=labels>Etichette</option>";
	$output .= "<option value=vivistore>Vivistore</option>";
	break;
	case "consumabili":
	$output .= "<option selected value=>Tutti</option>";
	$output .= "<option value=assets>Assets</option>";
	$output .= "<option selected value=consumabili>Consumabili</option>";
	$output .= "<option value=spare_parts>Ricambi</option>";
	$output .= "<option value=labels>Etichette</option>";
	$output .= "<option value=vivistore>Vivistore</option>";
	break;
	case "spare_parts":
	$output .= "<option value=>Tutti</option>";
	$output .= "<option value=assets>Assets</option>";
	$output .= "<option value=consumabili>Consumabili</option>";
	$output .= "<option selected value=spare_parts>Ricambi</option>";
	$output .= "<option value=labels>Etichette</option>";
	$output .= "<option value=vivistore>Vivistore</option>";
	break;
	case "labels":
	$output .= "<option value=>Tutti</option>";
	$output .= "<option value=assets>Assets</option>";
	$output .= "<option value=consumabili>Consumabili</option>";
	$output .= "<option value=spare_parts>Ricambi</option>";
	$output .= "<option selected value=labels>Etichette</option>";
	$output .= "<option value=vivistore>Vivistore</option>";
	break;
	case "vivistore":
	$output .= "<option value=>Tutti</option>";
	$output .= "<option value=assets>Assets</option>";
	$output .= "<option value=consumabili>Consumabili</option>";
	$output .= "<option value=spare_parts>Ricambi</option>";
	$output .= "<option value=labels>Etichette</option>";
	$output .= "<option selected value=vivistore>Vivistore</option>";
	break;
	}
  $output .= "</select>";
/*
*/
//output finale
$output .= $output;
//$output .= "ciao";

