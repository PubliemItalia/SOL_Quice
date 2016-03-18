<?php
include "query.php";
$id_riga = $_GET['id_riga'];

  $querya = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$resulta = mysql_query($querya);
while($rigaa = mysql_fetch_array($resulta)) {
$id_rda =$rigaa[id_rda];
}
  $queryb = "SELECT * FROM qui_rda WHERE id = '$id_rda'";
$resultb = mysql_query($queryb);
while($rigab = mysql_fetch_array($resultb)) {
	//$lista_totali .= $rigab[totale]."<br>";
	echo $rigab[totale_rda];
}

	//output finale
	
	
	
	
	//echo number_format($totale_rda,2,",",".");
	

 ?>
