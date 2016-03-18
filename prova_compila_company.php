<?php
include "query.php";
$queryb = "SELECT * FROM qui_rda WHERE stato = '4' AND id_company = '0' ORDER BY id DESC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
	$id_unita = $rowb[id_unita];
	$id_rda = $rowb[id];
  $queryc = "SELECT * FROM qui_unita WHERE id_unita = '$rowb[id_unita]'";
  $resultc = mysql_query($queryc);
  while ($rowc = mysql_fetch_array($resultc)) {
	  $IDCompany = $rowc[IDCompany];
  }
$querya = "UPDATE qui_rda SET id_company = '$IDCompany' WHERE id = '$id_rda'";
if (mysql_query($querya)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
/*
*/
  echo "IDCompany ".$IDCompany." - id_unita ".$id_unita." - id_rda ".$id_rda."<br>";
  $id_rda = "";
  $id_unita = "";
  $IDCompany = "";
}
?>