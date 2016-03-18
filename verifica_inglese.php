<?php
$categoria = $_POST['categoria'];
$negozio = $_POST['negozio'];
switch ($categoria) {
	case "categoria1_it":
	$cat_en = "categoria1_en";
	break;
	case "categoria2_it":
	$cat_en = "categoria2_en";
	break;
	case "categoria3_it":
	$cat_en = "categoria3_en";
	break;
	case "categoria4_it":
	$cat_en = "categoria4_en";
	break;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento senza titolo</title>
</head>

<body>
<form action="verifica_inglese.php" method="post" name="form1" id="form1">
  <table width="300" border="0">
    <tr>
      <td>Negozio<br>
        <select name="negozio" id="negozio">
        <?php
		switch($negozio) {
	case "":
          echo "<option selected value=>Scegli</option>";
          echo "<option value=qui_prodotti_assets>Assets</option>";
          echo "<option value=qui_prodotti_consumabili>Consumabili</option>";
          echo "<option value=qui_prodotti_spare_parts>Spare parts</option>";
	break;
	case "qui_prodotti_assets":
          echo "<option value=>Scegli</option>";
          echo "<option selected value=>Scegli</option>";
          echo "<option selected value=qui_prodotti_assets>Assets</option>";
          echo "<option value=qui_prodotti_consumabili>Consumabili</option>";
          echo "<option value=qui_prodotti_spare_parts>Spare parts</option>";
	break;
	case "qui_prodotti_consumabili":
          echo "<option value=>Scegli</option>";
          echo "<option value=qui_prodotti_assets>Assets</option>";
          echo "<option selected value=qui_prodotti_consumabili>Consumabili</option>";
          echo "<option value=qui_prodotti_spare_parts>Spare parts</option>";
	break;
	case "qui_prodotti_spare_parts":
          echo "<option value=>Scegli</option>";
          echo "<option value=qui_prodotti_assets>Assets</option>";
          echo "<option value=qui_prodotti_consumabili>Consumabili</option>";
          echo "<option selected value=qui_prodotti_spare_parts>Spare parts</option>";
	break;
		}
		  ?>
      </select></td>
      <td>Categoria<br>
        <select name="categoria" id="categoria">
        <?php
		switch($categoria) {
	case "":
          echo "<option selected value=>Scegli</option>";
          echo "<option value=categoria1_it>Cat 1</option>";
          echo "<option value=categoria2_it>Cat 2</option>";
          echo "<option value=categoria3_it>Cat 3</option>";
          echo "<option value=categoria4_it>Cat 4</option>";
	break;
	case "categoria1_it":
          echo "<option value=>Scegli</option>";
          echo "<option selected value=categoria1_it>Cat 1</option>";
          echo "<option value=categoria2_it>Cat 2</option>";
          echo "<option value=categoria3_it>Cat 3</option>";
          echo "<option value=categoria4_it>Cat 4</option>";
	break;
	case "categoria2_it":
          echo "<option value=>Scegli</option>";
          echo "<option value=categoria1_it>Cat 1</option>";
          echo "<option selected value=categoria2_it>Cat 2</option>";
          echo "<option value=categoria3_it>Cat 3</option>";
          echo "<option value=categoria4_it>Cat 4</option>";
	break;
	case "categoria3_it":
          echo "<option value=>Scegli</option>";
          echo "<option value=categoria1_it>Cat 1</option>";
          echo "<option value=categoria2_it>Cat 2</option>";
          echo "<option selected value=categoria3_it>Cat 3</option>";
          echo "<option value=categoria4_it>Cat 4</option>";
	break;
	case "categoria4_it":
          echo "<option value=>Scegli</option>";
          echo "<option value=categoria1_it>Cat 1</option>";
          echo "<option value=categoria2_it>Cat 2</option>";
          echo "<option value=categoria3_it>Cat 3</option>";
          echo "<option selected value=categoria4_it>Cat 4</option>";
	break;
		}
		  ?>
      </select></td>
      <td><input type="submit" name="submit" id="submit" value="Cerca"></td>
    </tr>
  </table>
</form>
<?php

$array_trovati = array();
if ((isset($_POST['categoria'])) AND (isset($_POST['negozio']))) {
  echo "<table width=300 border=0>";
    echo "<tr>";
     echo "<td>".$categoria."</td>";
     echo "<td>".$cat_en."</td>";
    echo "</tr>";
include "query.php";
$sqlbbb = "SELECT * FROM ".$negozio." WHERE ".$cat_en." = ''";
//echo "query: ".$sqlbbb."<br>";
$risultbbb = mysql_query($sqlbbb) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigab = mysql_fetch_array($risultbbb)) {
	if (!in_array($rigab[$categoria],$array_trovati)) {
    echo "<tr>";
 echo "<td>".$rigab[$categoria]."</td>";
     echo "<td>".$rigab[".$cat_en."]."</td>";
    echo "</tr>";
	$add_trov = array_push($array_trovati,$rigab[$categoria]);
	}
}
  echo "</table>";
  }
?>
</body>
</html>