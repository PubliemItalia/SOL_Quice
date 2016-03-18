<?php
include "query.php";
$id_riga = $_GET['id_riga'];
//$carrello = $_GET['carrello'];
$carrello = $_SESSION[carrello];

//mysql_set_charset("utf8"); //settare la codifica della connessione al db

/*$queryg = "SELECT * FROM qui_righe_carrelli WHERE id = '$id_riga'";
$resultg = mysql_query($queryg) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowg = mysql_fetch_array($resultg)) {
$carrello = $rowg[id_carrello];
}
*/
$queryb = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello'";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$totale_carrello = $totale_carrello + $rowb[totale];
}
	//output finale
	
	
	
	
//	echo $totale_carrello;
	echo $carrello;
	//echo "Hi";

 ?>
