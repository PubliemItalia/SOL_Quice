<?php
include "query.php";
$queryb = "SELECT * FROM qui_prodotti_consumabili_cassini ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = $rowb[codice_art];
$querys = "SELECT * FROM content_type_sanificazione_vivisol WHERE nid = '$codice_art'";
$results = mysql_query($querys);
$presenza_codice = mysql_num_rows($results);
if ($presenza_codice > 0) {
while ($rows = mysql_fetch_array($results)) {
$vecchio_codice = $rows[field_sv_code_value];
}
$queryt = "UPDATE qui_prodotti_consumabili_cassini SET codice_art = '$vecchio_codice', codice_numerico = '$codice_art' WHERE id = '$id'";
if (mysql_query($queryt)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$aggiornati .= $codice_art." sanif<br>";
} else {
$non_trovati .= $codice_art."<br>";

}
$vecchio_codice = "";
$codice_art = "";
$id = "";
}
/*$queryb = "SELECT * FROM qui_prodotti_consumabili_cassini ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = $rowb[codice_art];
$querys = "SELECT * FROM content_type_ricambi WHERE nid = '$codice_art'";
$results = mysql_query($querys);
$presenza_codice = mysql_num_rows($results);
if ($presenza_codice > 0) {
while ($rows = mysql_fetch_array($results)) {
$vecchio_codice = $rows[field_ricambi_code_value];
}
$queryt = "UPDATE qui_prodotti_consumabili_cassini SET codice_art = '$vecchio_codice', codice_numerico = '$codice_art' WHERE id = '$id'";
if (mysql_query($queryt)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$aggiornati .= $codice_art." ricambi<br>";
} else {
$non_trovati .= $codice_art."<br>";

}
$vecchio_codice = "";
$codice_art = "";
$id = "";
}
*//*$queryb = "SELECT * FROM qui_prodotti_consumabili_cassini ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = $rowb[codice_art];
$querys = "SELECT * FROM content_type_carta_buste_penne WHERE nid = '$codice_art'";
$results = mysql_query($querys);
$presenza_codice = mysql_num_rows($results);
if ($presenza_codice > 0) {
while ($rows = mysql_fetch_array($results)) {
$vecchio_codice = $rows[field_cartabustepenne_id_value];
}
$queryt = "UPDATE qui_prodotti_consumabili_cassini SET codice_art = '$vecchio_codice', codice_numerico = '$codice_art' WHERE id = '$id'";
if (mysql_query($queryt)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$aggiornati .= $codice_art." carta_buste_penne arch<br>";
} else {
$non_trovati .= $codice_art."<br>";

}
$vecchio_codice = "";
$codice_art = "";
$id = "";
}
*/
/*$queryb = "SELECT * FROM qui_prodotti_consumabili_cassini ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = $rowb[codice_art];
$querys = "SELECT * FROM content_type_accessori WHERE nid = '$codice_art'";
$results = mysql_query($querys);
$presenza_codice = mysql_num_rows($results);
if ($presenza_codice > 0) {
while ($rows = mysql_fetch_array($results)) {
$vecchio_codice = $rows[field_accessori_id_value];
}
$queryt = "UPDATE qui_prodotti_consumabili_cassini SET codice_art = '$vecchio_codice', codice_numerico = '$codice_art' WHERE id = '$id'";
if (mysql_query($queryt)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$aggiornati .= $codice_art." codice_art_uff arch<br>";
} else {
$non_trovati .= $codice_art."<br>";

}
$vecchio_codice = "";
$codice_art = "";
$id = "";
}
*/
/*$queryb = "SELECT * FROM qui_prodotti_consumabili_cassini ORDER BY id ASC";
$resultb = mysql_query($queryb);
while ($rowb = mysql_fetch_array($resultb)) {
$id = $rowb[id];
$codice_art = $rowb[codice_art];
$querys = "SELECT * FROM content_type_ufficio_e_archivio WHERE nid = '$codice_art'";
$results = mysql_query($querys);
$presenza_codice = mysql_num_rows($results);
if ($presenza_codice > 0) {
while ($rows = mysql_fetch_array($results)) {
$vecchio_codice = $rows[field_ufficioarchivio_id_value];
}
$queryt = "UPDATE qui_prodotti_consumabili_cassini SET codice_art = '$vecchio_codice', codice_numerico = '$codice_art' WHERE id = '$id'";
if (mysql_query($queryt)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$aggiornati .= $codice_art." codice_art_uff arch<br>";
} else {
$non_trovati .= $codice_art."<br>";

}
$vecchio_codice = "";
$codice_art = "";
$id = "";
}
*/?>
<table width="400" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="199" align="center">Aggiornati</td>
    <td width="201" align="center">NOn trovati</td>
  </tr>
  <tr>
    <td align="center" valign="top"><?php echo $aggiornati; ?></td>
    <td align="center" valign="top"><?php echo $non_trovati; ?></td>
  </tr>
</table>
