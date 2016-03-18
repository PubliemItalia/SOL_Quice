<?php
include "query.php";
$id_riga = $_GET['id_riga'];
$carrello = $_GET['carrello'];

//mysql_set_charset("utf8"); //settare la codifica della connessione al db

/*$queryg = "SELECT * FROM qui_righe_carrelli WHERE id = '$id_riga'";
$resultg = mysql_query($queryg) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowg = mysql_fetch_array($resultg)) {
$carrello = $rowg[id_carrello];
}
*/
$queryb = "SELECT SUM(totale) as somma FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0'";
$resultb = mysql_query($queryb);
list($somma) = mysql_fetch_array($resultb);
$totale_carrello = $somma;

	//output finale
	
	
	
	
	echo $totale_carrello;
	//echo "Hi";

 ?>
