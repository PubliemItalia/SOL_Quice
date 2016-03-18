<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$dest = $_GET['dest'];
$singola = $_GET['singola'];
$multipla = $_GET['multipla'];
$check = $_GET['check'];
$id_riga = $_GET['id_riga'];
$id_rda = $_GET['id_rda'];
$lingua = $_GET['lang'];
$multi = $_GET['multi'];
$ordine_fornitore = addslashes($_GET['ordine_fornitore']);
$id_fornitore = addslashes($_GET['id_fornitore']);
$tx_fornitore = addslashes($_GET['tx_fornitore']);

			

if ($ordine_fornitore != "") {
  $query = "UPDATE qui_righe_rda SET assegnaz_fornitore = '$id_fornitore', fornitore_tx = '$tx_fornitore', ord_fornitore = '$ordine_fornitore' WHERE id_rda = '$id_rda' AND output_mode = 'sap' AND flag_chiusura = '0' AND flag_buyer = '4'";
	} else {
  $query = "UPDATE qui_righe_rda SET assegnaz_fornitore = '', fornitore_tx = '', ord_fornitore = '' WHERE id_rda = '$id_rda' AND output_mode = 'sap' AND flag_chiusura = '0' AND flag_buyer = '4'";
}
	if (mysql_query($query)) {
	} else {
	  echo "Errore durante l'inserimento: ".mysql_error();
	}


//procedura per il buyer
$id_buyer = $_GET['id_utente'];
	
$querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND stato_ordine = '4' AND flag_chiusura = '0' AND output_mode = 'SAP' AND flag_buyer = '4' ORDER BY id ASC";
  $sf = 1;
  //inizia il corpo della tabella
  $result = mysql_query($querya);
  while ($row = mysql_fetch_array($result)) {
 $query = "UPDATE qui_righe_rda SET flag_buyer = '$check', id_buyer = '$id_buyer' WHERE id_rda = '$id_rda' AND output_mode = 'sap' AND flag_chiusura = '0'";
  if (mysql_query($query)) {
  } else {
	$tab_output .= "Errore durante l'inserimento: ".mysql_error();
  }
}


///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//INIZIO OUTPUT BLOCCO SING RDA

  $array_date_chiusura = array();
  $querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda' AND stato_ordine = '4' AND flag_chiusura = '0' AND output_mode = 'SAP' AND flag_buyer = '4' ORDER BY id ASC";
$tab_output .= $querya."<br>";
$sf = 1;
  //inizia il corpo della tabella
  $result = mysql_query($querya);
  while ($row = mysql_fetch_array($result)) {
	$tot = $tot + 1;
	$data_leggibile = date("d.m.Y",$row[data]);
	$id_prod_riga = $row[id_prodotto];
	$codice_art_riga = $row[codice_art];
	$ordine_forn_db = $row[fornitore_tx]." ".$row[ord_fornitore];	
	$nazione_prodotto = $row[nazione];
	if ($row[stato_ordine == 4]) {
	  $add_data = array_push($array_date_chiusura,$row[data_ultima_modifica]);
	}
	$descrizione_prodotto = $row[descrizione];
	$prezzo_prodotto = $row[prezzo];
	$confezione_prodotto = $row[confezione];
	if ($row[negozio] == "labels") {
	  $confezione_prodotto = "";
	  $prezzo_prodotto = "";
	  //$tab_output .= "ord stamp: ".$ord_stamp."<br>";
	  $totale_art = $row[totale];
	}
	
	//$tab_output .= "<form name=carrello method=get action=popup_vis_rda.php#".$row[id].">";
	if ($sf == 1) {
	  $tab_output .= "<div class=sfondoRigaColor>";
	} else {
	  $tab_output .= "<div class=sfondoRigaBianco>";
	}
	$tab_output .= "<div style=\"width:70px; height:auto; float:left; margin-left:10px;\">";
	  if (substr($codice_art_riga,0,1) != "*") {
		$tab_output .= $codice_art_riga;
	  } else {
		$tab_output .= substr($codice_art_riga,1);
	  }
	$tab_output .= "</div>";
	$tab_output .= "<div style=\"width:70px; height:20px; float:left;\">";
	  $tab_output .= $nazione_prodotto;
	$tab_output .= "</div>";
	$tab_output .= "<div style=\"width:250px; height:auto; float:left;\">";
	  if (strlen($descrizione_prodotto) < 3) {
		$tab_output .= $descrizione_ita." <strong>(da tradurre)</strong>";
	  } else {
		$tab_output .= $descrizione_prodotto;
	  }
	  //$tab_output .= $descrizione_prodotto;
	  $descrizione_prodotto = "";
	  $descr_ita = "";
	$tab_output .= "</div>";
	$tab_output .= "<div style=\"width:80px; height:20px; float:left;\">";
	  $tab_output .= $confezione_prodotto;
	$tab_output .= "</div>";
	$tab_output .= "<div style=\"width:80px; height:20px; float:left; text-align:right;\">";
	  $tab_output .= number_format($prezzo_prodotto,2,",","");
	$tab_output .= "</div>";
	$tab_output .= "<div style=\"width:80px; height:auto; float:left; text-align:right;\">";
		  $tab_output .= number_format($row[quant],0,",",".");
	$tab_output .= "</div>";
	$tab_output .= "<div style=\"width:80px; height:auto; float:left; text-align:right; padding-right:10px;\">";
		$tab_output .= number_format($row[totale],2,",","");
	$tab_output .= "</div>";
	$tab_output .= "<div style=\"width:135px; height:20px; float:left;\">";
	$tab_output .= $ordine_forn_db;
	//qui va l'indicazione del numero ordine
	$tab_output .= "</div>";
	$tab_output .= "<div style=\"width:50px; float:right; margin-right:15px; text-align:right; height:20px;\">";
	//qui va la checkbox per la selezione della riga
	if ($row[flag_buyer] == 4) {
	  $tab_output .= '<input name="id_riga[]" type="checkbox" id="id_riga[]" checked value="'.$row[id].'" onClick="processa('.$row[id].','.$id.');">';
	} else {
	  $tab_output .= '<input name="id_riga[]" type="checkbox" id="id_riga[]" value="'.$row[id].'" onClick="processa('.$row[id].','.$id.');">';
	}
	$tab_output .= "</div>";
	$tab_output .= "</div>";
  $ordine_forn_db = "";
  if ($sf == 1) {
  $sf = $sf + 1;
  } else {
  $sf = 1;
  }
  }
//fine blocco sing rda




//output finale

echo $tab_output;

//$tab_output .= "pippo";



 ?>
