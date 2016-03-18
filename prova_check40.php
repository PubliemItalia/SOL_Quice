<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlz = "SELECT * FROM qui_prodotti_consumabili ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$descr_it = addslashes($rigaz[descrizione1_it]);
$descr_en = addslashes($rigaz[descrizione1_en]);
if (strlen($rigaz[descrizione1_it]) > 40) {
	echo "Art. ".$rigaz[cod_art]."(id ".$rigaz[id]." (descrizione ita = ".strlen($rigaz[descrizione1_it]).")<br>";
	echo substr($rigaz[descrizione1_it],0,40)."<br>";
	$correzioni = $correzioni + 1;
}
if (strlen($rigaz[descrizione1_en]) > 40) {
	echo "Art. ".$rigaz[cod_art]."(id ".$rigaz[id]." (descrizione eng = ".strlen($rigaz[descrizione1_en]).")<br>";
	echo substr($rigaz[descrizione1_en],0,40)."<br>";
	$correzioni = $correzioni + 1;
}
}
echo "CORREZIONI TOTALI: ".$correzioni."<br>";
?>