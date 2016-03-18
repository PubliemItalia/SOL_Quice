
<?php
$materiale = $_POST[materiale];
$capacita = $_POST[capacita];
$prezzo_corpo = $_POST[prezzo_corpo];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$sqlq = "SELECT DISTINCT materiale FROM qui_prodotti_assets WHERE categoria1_it = 'Bombole' ORDER BY id ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
$blocco_materiali .= "<option value=".$rigaq[materiale].">".$rigaq[materiale]."</option>";
}
$sqlt = "SELECT DISTINCT categoria4_it FROM qui_prodotti_assets WHERE categoria1_it = 'Bombole' ORDER BY id ASC";
$risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigat = mysql_fetch_array($risultt)) {
$blocco_capacita .= "<option value=".$rigat[categoria4_it].">".$rigat[categoria4_it]."</option>";
}

if ($prezzo_corpo == "") {
$sqlz = "SELECT * FROM qui_prodotti_assets WHERE materiale = '$materiale' AND categoria4_it = '$capacita' ORDER BY id ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
echo $rigaz[id]." - ".$rigaz[categoria2_it]." - ".$rigaz[categoria3_it]." - ".$rigaz[id_valvola]." - ".$rigaz[prezzo]."<br>";
}
} else {
$sqlq = "UPDATE qui_prodotti_assets SET prezzo = '$prezzo_corpo' WHERE materiale = '$materiale' AND categoria4_it = '$capacita'";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
if (mysql_query($risultq)) {
} else {
//echo "Errore durante la modifica". mysql_error()."<br>";
}
}


?>
<html>
<head>
</head>
<body>
<form id="form1" name="form1" method="post">
<table width="500" border="1">
  <tr>
    <td width="131">
      <select name="materiale" id="materiale">
      <?php echo $blocco_materiali; ?>
      </select>
    </td>
    <td width="152">
          <select name="capacita" id="capacita">
      <?php echo $blocco_capacita; ?>
      </select>
</td>
    <td width="113">
          <input name="prezzo_corpo" type="text" id="prezzo_corpo" size="5" maxlength="5">
</td>
    <td width="76"><input type="submit"></td>
  </tr>
</table>
</form>
</body>
</html>