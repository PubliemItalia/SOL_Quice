<?php
$testo_ita = addslashes($_POST[testo_ita]);
$id = $_POST[id];
$mod_testo_ita = $_POST[mod_testo_ita];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

if ($mod_testo_ita != "") {
	$queryd = "UPDATE qui_prodotti_consumabili_descr40 SET descrizione1_it = '$testo_ita' WHERE id = '$id'";
	if (mysql_query($queryd)) {
	} else {
	echo "Errore durante l'inserimento0: ".mysql_error();
	}
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento senza titolo</title>
<script language="javascript" type="text/javascript">
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
</script>
</head>

<body>
<table width="800" border="1" >
  <tr>
    <td width="155">TESTO ITA</td>
    <td width="155">TESTO ENG</td>
    <td width="208">Modifica Ita</td>
    <td width="195">Modifica eng</td>
    <td width="65"></td>
  </tr>
  <?php
  $sqlz = "SELECT * FROM qui_prodotti_consumabili_descr40 ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
if (strlen($rigaz[descrizione1_it]) > 40) {
  echo "<tr>";
  echo "<form id=form".$rigaz[id]." name=form".$rigaz[id]." method=post action=prova_40_char.php>";
    echo "<td>";
	echo $rigaz[descrizione1_it];
    echo "</td>";
    echo "<td>";
	echo $rigaz[descrizione1_en];
	echo "</td>";
    echo "<td>";
    echo "<textarea name=testo_ita onKeyDown=\"limitText(this.form.testo_ita,this.form.countdown,40);\" onKeyUp=\"limitText(this.form.testo_ita,this.form.countdown,40);\">";
echo stripslashes(substr($rigaz[descrizione1_it],0,40));
echo "</textarea><br>";
echo "<font size=1>(Maximum characters: 40)<br>";
echo "You have <input readonly type=text name=countdown size=3 value=40> characters left.</font>";
echo "</td>";
echo "<td>&nbsp;</td>";
    echo "<td>";
	echo $rigaz[id]."<br>";
	echo "<input type=hidden name=id id=id value=".$rigaz[id].">";
	echo "<input type=hidden name=mod_testo_ita id=mod_testo_ita value=1>";
	echo "<input name=submit type=image id=submit src=immagini/button_mod.gif value=submit></td>";
  echo "</form>";
  echo "</tr>";
	} else {
/*  echo "<tr>";
    echo "<td>";
	echo $rigaz[descrizione1_it];
    echo "</td>";
    echo "<td>";
	echo $rigaz[descrizione1_en];
	echo "</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
  echo "</tr>";
*/	}
}
  ?>
</table>
</body>
</html>