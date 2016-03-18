<?php
include "query.php";
$id_riga = $_GET['id_riga'];

  $querya = "SELECT * FROM qui_righe_ordini_for WHERE id = '$id_riga'";
$resulta = mysql_query($querya);
while($rigaa = mysql_fetch_array($resulta)) {
$id_ordine =$rigaa[id_ordine_for];
}
  $queryb = "SELECT * FROM qui_righe_ordini_for WHERE id_ordine_for = '$id_ordine'";
$resultb = mysql_query($queryb);
while($rigab = mysql_fetch_array($resultb)) {
	//$lista_totali .= $rigab[totale]."<br>";
	$totale_ordine = $totale_ordine+$rigab[totale];
}

$query = "UPDATE qui_ordini_for SET totale_ordine = '$totale_ordine' WHERE id = '$id_ordine'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
	//output finale
	//echo $totale_ordine;
	
	
	
	//echo $id_ordine;
	
	echo number_format($totale_ordine,2,",",".");
	

 ?>
