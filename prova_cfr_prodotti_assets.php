<style type="text/css">
.allin_centr {
	text-align: center;
	font-family:Arial;
	font-size:12px;
}
</style>
<table width="900" border="0">
  <tr>
    <td width="120">ASSETS</td>
    <td colspan="3" class="allin_centr">ONLINE</td>
    <td colspan="3" class="allin_centr">NUOVO</td>
  </tr>
  <tr>
    <td class="allin_centr">COD.</td>
    <td width="55" class="allin_centr">ID</td>
    <td width="223" class="allin_centr">Descr.</td>
    <td width="100" class="allin_centr">Prezzo</td>
    <td width="55" class="allin_centr">ID</td>
    <td width="217" class="allin_centr">Descr.</td>
    <td width="100" class="allin_centr">Prezzo</td>
  </tr>
<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$queryb = "SELECT * FROM qui_assets_online WHERE categoria1_it != 'Bombole' ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id_prodotto = $rowb[id];
$cod_online = $rowb[codice_art];
$queryc = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rowb[codice_art]' ORDER BY id ASC";
$resultc = mysql_query($queryc);
$presenza = mysql_num_rows($resultc);
if ($presenza == 0) {
  echo "<tr class=allin_centr>";
    echo "<td>".$rowb[codice_art]."</td>";
    echo "<td bgcolor=#99FFFF>".$rowb[id]."</td>";
    echo "<td bgcolor=#99FFCC>".$rowb[descrizione1_it]."</td>";
    echo "<td bgcolor=#99FF99>".$rowb[prezzo]."</td>";
    echo "<td bgcolor=#FFFFCC></td>";
    echo "<td bgcolor=#FFFF99 style=color:red; font-weight:bold;>NUOVO</td>";
    echo "<td bgcolor=#FFFF66>&nbsp;</td>";
  echo "</tr>";
} else {
	while ($rowc = mysql_fetch_array($resultc)) {
$prezzo_nuovo = $rowc[prezzo];
$id_nuovo = $rowc[id];
$descr_nuovo = $rowc[descrizione1_it];
}
if ($rowb[prezzo] != $prezzo_nuovo) {
  echo "<tr class=allin_centr>";
    echo "<td>".$rowb[codice_art]."</td>";
    echo "<td bgcolor=#99FFFF>".$rowb[id]."</td>";
    echo "<td bgcolor=#99FFCC>".$rowb[descrizione1_it]."</td>";
    echo "<td bgcolor=#99FF99>".$rowb[prezzo]."</td>";
    echo "<td bgcolor=#FFFFCC>".$id_nuovo."</td>";
    echo "<td bgcolor=#FFFF99>".$descr_nuovo."</td>";
    echo "<td bgcolor=#FFFF66>".$prezzo_nuovo.";</td>";
  echo "</tr>";
  $queryq = "UPDATE qui_prodotti_assets SET prezzo = '$rowb[prezzo]' WHERE codice_art = '$rowb[codice_art]'";
if (mysql_query($queryq)) {
} else {
echo "Errore durante l'inserimento3: ".mysql_error();
}

}
}
$presenza = "";
$prezzo_nuovo = "";
$id_nuovo = "";
$descr_nuovo = "";

}
?>
</table>
