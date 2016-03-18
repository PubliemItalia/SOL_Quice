<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
/*
$queryb = "SELECT * FROM qui_ordini_for WHERE id_company = '0' ORDER BY id DESC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
  $queryc = "SELECT * FROM qui_unita WHERE id_unita = '$rowb[id_unita]'";
  $resultc = mysql_query($queryc);
  while ($rowc = mysql_fetch_array($resultc)) {
	  $IDCompany = $rowc[IDCompany];
  $queryd = "SELECT * FROM qui_company WHERE IDCompany = '$rowc[IDCompany]'";
  $resultd = mysql_query($queryd);
  while ($rowd = mysql_fetch_array($resultd)) {
	$nomeCompany = $rowd[Company];
  }
  }
	$querya = "UPDATE qui_ordini_for SET id_company = '$IDCompany', nome_company = '$nomeCompany' WHERE id = '$rowb[id]'";
	if (mysql_query($querya)) {
	} else {
	echo "Errore durante l'inserimento: ".mysql_error();
	}
  echo "IDCompany ".$IDCompany." - id_unita ".$$nomeCompany." - id_ordine ".$rowb[id]."<br>";
  $nomeCompany = "";
  $id_unita = "";
  $IDCompany = "";
}
*/

/*

$queryb = "SELECT * FROM qui_packing_list WHERE id_company = '0' ORDER BY id DESC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
  $queryc = "SELECT * FROM qui_unita WHERE id_unita = '$rowb[id_unita]'";
  $resultc = mysql_query($queryc);
  while ($rowc = mysql_fetch_array($resultc)) {
	  $IDCompany = $rowc[IDCompany];
  $queryd = "SELECT * FROM qui_company WHERE IDCompany = '$rowc[IDCompany]'";
  $resultd = mysql_query($queryd);
  while ($rowd = mysql_fetch_array($resultd)) {
	$nomeCompany = $rowd[Company];
  }
  }
	$querya = "UPDATE qui_packing_list SET id_company = '$IDCompany', nome_company = '$nomeCompany' WHERE id = '$rowb[id]'";
	if (mysql_query($querya)) {
	} else {
	echo "Errore durante l'inserimento: ".mysql_error();
	}
  echo "IDCompany ".$IDCompany." - nomeCompany ".$nomeCompany." - id_pack ".$rowb[id]."<br>";
  $nomeCompany = "";
  $id_unita = "";
  $IDCompany = "";
}
*/


$queryb = "SELECT * FROM qui_righe_rda WHERE nome_company = '' ORDER BY id DESC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
  $queryc = "SELECT * FROM qui_unita WHERE id_unita = '$rowb[id_unita]'";
  $resultc = mysql_query($queryc);
  while ($rowc = mysql_fetch_array($resultc)) {
	$IDCompany = $rowc[IDCompany];
	$queryd = "SELECT * FROM qui_company WHERE IDCompany = '$rowc[IDCompany]'";
	$resultd = mysql_query($queryd);
	while ($rowd = mysql_fetch_array($resultd)) {
	  $nomeCompany = $rowd[Company];
	}
  }
  $querya = "UPDATE qui_righe_rda SET nome_company = '$nomeCompany' WHERE id = '$rowb[id]'";
  if (mysql_query($querya)) {
  } else {
  echo "Errore durante l'inserimento: ".mysql_error();
  }
	 
/*
*/
  echo "IDCompany ".$IDCompany." - nomeCompany ".$nomeCompany." - id_riga ".$rowb[id]."<br>";
  $nomeCompany = "";
  $id_unita = "";
  $IDCompany = "";
}
?>