<?PHP
include "query.php";
//  $queryb = "SELECT * FROM qui_righe_rda WHERE categoria LIKE '%Etichette%'";
  $queryb = "SELECT * FROM qui_righe_rda WHERE categoria LIKE '%Etichette%' AND data_inserimento >= '1335186000'";
$resultb = mysql_query($queryb);
  while ($rigab = mysql_fetch_array($resultb)) {
	  $sommaquant = $sommaquant + ($rigab[quant]*$rigab[confezione]);
	  $sommaprez = $sommaprez + $rigab[totale];
  }
echo "quantit&agrave; finale: ".number_format($sommaquant,2,",",".");
echo "totale euro: ".number_format($sommaprez,2,",",".");
?>