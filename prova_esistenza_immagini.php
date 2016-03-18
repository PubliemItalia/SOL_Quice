<?php
$negozio = $_GET[negozio];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$sqlz = "SELECT * FROM qui_prodotti_".$negozio." WHERE obsoleto = '0' ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
	if (!is_file("files/".$rigaz[foto])) {
		echo $rigaz[id]." - ".$rigaz[negozio]." - ".$rigaz[foto]."<br>";
	}
}
?>