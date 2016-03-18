<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id_rda = $_GET[id_rda];
$aggiorna = $_GET[aggiorna];
if ($aggiorna == 1) {
  $sqlz = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id_rda'";
  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $allrows = mysql_num_rows($risultz);
  while ($rigaz = mysql_fetch_array($risultz)) {
	$sqly = "SELECT * FROM qui_packing_list WHERE id = '$rigaz[pack_list]'";
	$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigay = mysql_fetch_array($risulty)) {
		$data_chiusura = $rigay[data_spedizione];
	}
  }
	$query = "UPDATE qui_righe_rda SET flag_chiusura = '1', data_ultima_modifica = '$data_chiusura', data_chiusura = '$data_chiusura'   WHERE output_mode != 'sap' AND id_rda = '$id_rda' AND stato_ordine = '4' AND flag_chiusura = '0'";
  if (mysql_query($query)) {
		echo "riga RdA ".$id_rda." aggiornata<br>";
  } else {
  echo "Errore durante l'inserimento3: ".mysql_error();
  }
	  $querya = "UPDATE qui_rda SET stato = '4', data_ultima_modifica = '$data_chiusura', data_chiusura = '$data_chiusura' WHERE id = '$id_rda' AND stato = '3'";
	if (mysql_query($querya)) {
		echo "RdA ".$id_rda." aggiornata<br>";
	} else {
	echo "Errore durante l'inserimento3: ".mysql_error();
	}
	} else {
		echo "RdA ".$id_rda." non aggiornata<br>";
}
$sqlg = "SELECT * FROM qui_rda WHERE stato = '3' AND id > '3209' ORDER BY id ASC";
//$sqlg = "SELECT * FROM qui_rda WHERE stato = '4' ORDER BY id ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
  $sqlf = "SELECT * FROM qui_righe_rda WHERE id_rda = '$rigag[id]'";
  $risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $tuttelerighe = mysql_num_rows($risultf);
  while ($rigaf = mysql_fetch_array($risultf)) {
	  if (($rigaf[stato_ordine] == 4) && ($rigaf[output_mode] != "sap")) {
		$righe4 = $righe4 + 1;
	  }
  }
  if ($righe4 == $tuttelerighe) {
	echo '<form action="prova_coerenza_rda3_righe_4.php" method="get">rda n. '.$rigag[id].'</strong><br>';
	echo "<strong>rda n. ".$rigag[id]."</strong><br>";
	echo "stato 4: ".$righe4." - tutte le righe: ".$tuttelerighe."<br><br>";
	echo '<input name="salva" type="submit" />
	<input name="id_rda" id="id_rda" type="hidden" value="'.$rigag[id].'" />
	<input name="aggiorna" id="aggiorna" type="hidden" value=1/>
	';
	echo '</form>';
  }
  $tuttelerighe = "";
  $righe4 = "";
}
?>