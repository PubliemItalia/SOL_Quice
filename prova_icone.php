<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
echo "<table width=500 border=1>";
  echo "<tr>";
     echo "<td>icone</td>";
     echo "<td>Categorie4</td>";
     echo "</tr>";
  echo "<tr>";
     echo "<td valign=top>";
$sqlz = "SELECT DISTINCT icona FROM qui_prodotti_consumabili";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
echo $rigaz[icona]."<br>";
}
	 echo "</td>";
     echo "<td valign=top>";
$sqlz = "SELECT DISTINCT categoria4_it FROM qui_prodotti_consumabili";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
echo $rigaz[categoria4_it]."<br>";
}
	 echo "</td>";
     echo "</tr>";
echo "</table>";
?>