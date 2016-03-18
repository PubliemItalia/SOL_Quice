<?php
session_start();
$id = $_GET[id];
$negozio = $_GET[shop];
$quant = $_GET[quant];
$check = $_GET[check];
$soglia = $_GET[soglia];
$gestione = $_GET[gestione];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

switch ($check) {
	case "1":
	  $testoQuery = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
	  $result = mysql_query($testoQuery);
	  while ($row = mysql_fetch_array($result)) {
	  $codice_art = $row[codice_art];
	  $totali = $row[giacenza];
	  //fine while
	  }
	  $nuova_giacenza = $totali+$quant;
	  $sqlk = "UPDATE qui_prodotti_".$negozio." SET giacenza = '$nuova_giacenza' WHERE id = '$id'";
	  if (mysql_query($sqlk)) {
	  } else {
	  echo "Errore durante l'inserimento4: ".mysql_error();
	  }
		$venduti = 0;
			$sqlk = "SELECT * FROM qui_righe_rda WHERE negozio = '$negozio' AND codice_art = '$codice_art' AND stato_ordine = '4'";
			$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigak = mysql_fetch_array($risultk)) {
				  $venduti = $venduti + $rigak[quant];
			  }
		$ordinati = 0;
		$sqly = "SELECT * FROM qui_righe_rda WHERE negozio = '$negozio' AND codice_art = '$codice_art' AND (stato_ordine = '1' OR stato_ordine = '2')";
		$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		  while ($rigay = mysql_fetch_array($risulty)) {
			  $ordinati = $ordinati + $rigay[quant];
		  }
		  $giacenza = ($nuova_giacenza-$ordinati);
		  if ($nuova_giacenza > 0) {
		  $perc_ordinati = ($ordinati/$nuova_giacenza)*100;
		  }
		  if ($perc_ordinati >= 80) {
			  $dic_giacenza = "Giacenza (DA ORDINARE)";
		  } else {
			  $dic_giacenza = "Giacenza";
		  }
					
		  //output finale
	  $div_image .= '<div style="width:100%; height:auto; padding:5px 0px; background-color: #e6e6e6; font-size:13px;">
					  Situazione prodotto
					</div>
					<div style="width:200px; text-align:left; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px; margin-top:10px;">
					  Venduti
					</div>
					<div style="width:60px; text-align:right; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px; margin-top:10px;">
					  '.$venduti.'
					</div>
					<div style="width:200px; text-align:left; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px; margin-top:10px;">
					  In Ordine
					</div>
					<div style="width:60px; text-align:right; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px; margin-top:10px;">
					  '.$ordinati.'
					</div>
					<div style="width:200px; text-align:left; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px;">
					  '.$dic_giacenza.'
					</div>
					<div style="width:60px; text-align:right; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px;">
					  '.$nuova_giacenza.'
					</div>
					<div style="width:200px; text-align:left; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px;">
					  Totali
					</div>
					<div style="width:60px; text-align:right; padding-top:3px; border-bottom:1px solid rgb(0,0,0); float:left; height:20px;">
					  '.$giacenza.'
					</div>';
	break;
	case "2":
	  $sqlk = "UPDATE qui_prodotti_".$negozio." SET soglia = '$soglia', gestione_scorta = '$gestione' WHERE id = '$id'";
	  if (mysql_query($sqlk)) {
		  $div_image = "Operazione completata correttamente";
	  } else {
	  echo "Errore durante l'inserimento4: ".mysql_error();
	  }
	break;
}
	echo $div_image;
?>
