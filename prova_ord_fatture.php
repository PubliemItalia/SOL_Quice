<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
	echo '
	<form action="prova_ord_fatture.php" method="get">ord n. '.$rigag[id].'</strong><br>
	<input name="ordine" type="text" />
	<input name="salva" type="submit" />
	<input name="aggiorna" id="aggiorna" type="hidden" value=1/>
	';
	echo '</form>';
$ordine = $_GET[ordine];
$aggiorna = $_GET[aggiorna];
if ($aggiorna == 1) {
	  echo 'RdA: ';
  $sqlz = "SELECT DISTINCT id_rda FROM qui_righe_rda WHERE n_ord_sap = '$ordine'";
  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $allrows = mysql_num_rows($risultz);
  while ($rigaz = mysql_fetch_array($risultz)) {
	  $id_rda = $rigaz[id_rda];
	  	  echo $id_rda.", ";
  }
  $sqls = "SELECT DISTINCT * FROM qui_righe_rda WHERE id_rda = '$id_rda' ORDER BY id ASC LIMIT 1";
  $risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigas = mysql_fetch_array($risults)) {
		  $id_resp = $rigas[id_resp];
		  $id_unita = $rigas[id_unita];
 		  $nome_unita = $rigas[nome_unita];
 		  $logo = strtolower($rigas[azienda_prodotto]);
$sqlr = "SELECT * FROM qui_utenti WHERE user_id = '$rigas[id_resp]'";
	$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigar = mysql_fetch_array($risultr)) {
		$nome_resp = $rigar[nome];
	}
  }
	$sqly = "SELECT * FROM qui_RdF_temp WHERE n_ord_sap = '$ordine'";
	$risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	$presenza_ord = mysql_num_rows($risulty);
	if ($presenza_ord > 0) {
		echo 'Fattura gi&agrave; fatta<br>';
	} else {
		$actual_date = mktime();
	  $queryss = "INSERT INTO qui_RdF_temp (id_unita, nome_unita, id_resp, nome_resp, id_operatore, nome_operatore, data_ordine, data_fattura, data_ultima_modifica, n_ord_sap, logo) VALUES ('$id_unita', '$nome_unita', '$id_resp', '$nome_resp', '473', 'Nicoletta Susanna Canegrati', '$actual_date', '$actual_date', '$actual_date', '$ordine', '$logo')";
	  if (mysql_query($queryss)) {
	  } else {
	  echo "Errore durante l'inserimento1". mysql_error();
	  }
 
 } 
}
?>