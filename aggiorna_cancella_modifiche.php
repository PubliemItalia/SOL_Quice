<?php
$id = $_GET[id];
$negozio = $_GET[shop];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$testoQuery = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($row = mysql_fetch_array($result)) {
	$sqlw = "UPDATE qui_prodotti_".$negozio." SET foto_sost = '', filepath = '' WHERE id = '$id'";
	if (mysql_query($sqlw)) {
	} else {
	echo "Errore durante l'inserimento4: ".mysql_error();
	}
  $sql = "DELETE FROM qui_gallery WHERE id_prodotto = '$row[codice_art]' AND temp = 'T'";
  $risultato = mysql_query($sql) or die("Impossibile eseguire l'interrogazione");
//fine while
}
	//output finale
	echo $div_image;
?>
