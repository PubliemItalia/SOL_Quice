<html>
<head></head>
<body>
<table width="800" border="1" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="2">Produzione</td>
    <td colspan="2"><p>Backup</p></td>
  </tr>
  <tr>
    <td>Codice</td>
    <td>prezzo</td>
    <td>codice</td>
    <td>prezzo</td>
  </tr>
<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlz = "SELECT * FROM qui_prodotti_labels ORDER BY codice_art ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$prezzo_prod = $rigaz[prezzo];
$codice_art = $rigaz[codice_art];
$sqlv = "SELECT * FROM qui_prodotti_labels_attuale WHERE codice_art = '$rigaz[codice_art]'";
$risultv = mysql_query($sqlv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$presenze = mysql_num_rows($risultv);
if ($presenze > 0) {
while ($rigav = mysql_fetch_array($risultv)) {
$prezzo_bck = $rigav[prezzo];
  echo "<tr>";
     echo "<td>".$codice_art."</td>";
     echo "<td>".$rigaz[prezzo]."</td>";
     echo "<td>".$rigav[codice_art].";</td>";
     echo "<td>".$prezzo_bck."</td>";
     echo "<td>";
//$sqlq = "UPDATE qui_prodotti_labels SET prezzo = '$prezzo_bck' WHERE codice_art = '$codice_art'";
//$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
//if (mysql_query($risultq)) {
	//echo "inserito ".$rigav[prezzo];
//} else {
//echo "Errore durante la modifica". mysql_error()."<br>";
//}
}
echo "</td>";
}
   echo "</tr>";
$prezzo_bck = "";
$codice_art = "";
   

}
?>
</table>
</body>
</html>