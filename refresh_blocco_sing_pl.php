<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$dest = $_GET['dest'];
$check = $_GET['check'];
$def = $_GET['def'];
$id_pl = $_GET['id_pl'];
$datalog = mktime();
if ($def == "1") {
//aggiornamento PL
  $query = "UPDATE qui_packing_list SET check_completato = '$check' WHERE id = '$id_pl'";
  if (mysql_query($query)) {
	  //aggiornamento magazzino
/*
	$sqlc = "SELECT * FROM qui_righe_rda WHERE pack_list = '$id_pl'";
	$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
	while ($rowc = mysql_fetch_array($risultc)) {
	  $quant_giac = $rowc[quant];
	  $sqlb = "SELECT * FROM qui_prodotti_".$rowc[negozio]." WHERE codice_art = '$rowc[codice_art]'";
	  $risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
	  while ($rowb = mysql_fetch_array($risultb)) {
		$giacenza = $rowb[giacenza];
	  }
		  $nuova_giacenza = $giacenza-$rowc[quant];
		  $sqlk = "UPDATE qui_prodotti_".$rowc[negozio]." SET giacenza = '$nuova_giacenza' WHERE codice_art = '$rowc[codice_art]'";
		  if (mysql_query($sqlk)) {
		  } else {
			echo "Errore durante l'inserimento4: ".mysql_error();
		  }
	  $nuova_giacenza = "";
	  $giacenza = "";
	}
*/	
	  //aggiornamento righe RdA
	$queryc = "UPDATE qui_righe_rda SET flag_buyer = '2', stato_ordine = '4', flag_chiusura = '1', data_ultima_modifica = '$datalog', data_chiusura = '$datalog' WHERE pack_list = '$id_pl'";
	  if (mysql_query($queryc)) {
	  } else {
		echo "Errore durante l'inserimento3: ".mysql_error();
	  }
	  $riepilogo = "chiusura definitiva packing list (".$n_pl.") da magazziniere ".$_SESSION[nome];
	  $datalogtx = date("d.m.Y H:i",$datalog);
	  $operatore = addslashes($_SESSION['nome']);
	  $queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'packing_list', '$n_pl', '$riepilogo')";
		if (mysql_query($queryb)) {
		} else {
		  echo "Errore durante l'inserimento6". mysql_error();
		}
  } else {
	echo "Errore durante l'inserimento7: ".mysql_error();
  }
}


 ?>