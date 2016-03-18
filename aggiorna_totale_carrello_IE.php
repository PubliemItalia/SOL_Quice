<?php
include "query.php";
$carrello = $_GET['id_carrello'];

mysql_set_charset("utf8"); //settare la codifica della connessione al db
  $queryb = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0'";
$resultb = mysql_query($queryb);
while($rigab = mysql_fetch_array($resultb)) {
$totale_carrello = $totale_carrello + $rigab[totale];
}
	//output finale
	
	
	
	
	echo $totale_carrello;
	//echo "10";
	

 ?>
