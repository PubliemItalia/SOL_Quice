<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlf = "SELECT DISTINCT id_prod, descrizione FROM qui_preferiti WHERE negozio = '$_GET[negozio]' ORDER BY id_prod ASC";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
  $sqlg = "SELECT * FROM qui_prodotti_".$_GET[negozio]." WHERE id = '$rigaf[id_prod]'";
  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $presenza = mysql_num_rows($risultg);
  if ($presenza == 0) {
	echo "articolo da sistemare ".$_GET[negozio].": ".$rigaf[id_prod]." - ".$rigaf[descrizione]."<br>";
  } else {
	while ($rigag = mysql_fetch_array($risultg)) {
	 // echo "articolo OK ".$_GET[negozio].": ".$rigag[id]." - ".$rigag[descrizione1_it]."<br>";
	}
  }
}
?>