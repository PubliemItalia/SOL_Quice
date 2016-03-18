<style type="text/css">
.allin_centr {
	text-align: center;
	font-family:Arial;
	font-size:12px;
}
</style>
<table width="900" border="0">
  <tr>
    <td class="allin_centr">COD.</td>
    <td class="allin_centr">ID</td>
  </tr>
<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$queryb = "SELECT * FROM qui_prodotti_labels ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id_prodotto = $rowb[id];
$queryc = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rowb[codice_art]' ORDER BY id ASC";
$resultc = mysql_query($queryc);
$presenza = mysql_num_rows($resultc);
if ($presenza > 1) {
  echo "<tr class=allin_centr>";
    echo "<td>".$rowb[codice_art]."</td>";
    echo "<td>".$presenza."</td>";
  echo "</tr>";
}
$presenza = "";
$prezzo_nuovo = "";
$id_nuovo = "";
$descr_nuovo = "";

}
?>
</table>
