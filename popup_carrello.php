<?php
$id_cart = $_GET[id_cart];
$lingua = $_GET[lang];
//$lingua = $_SESSION[lang];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
//variabili di paginazione
if (isset($_GET['limit'])) {
$limit = $_GET['limit'];
} else {
$limit = $_POST['limit'];
}
if (isset($_GET['page'])) {
$page = $_GET['page'];
} else {
$page = $_POST['page'];
}

//condizioni per evitare errori
if((!$limit) OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 5; //default
 } 

if((!$page) OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
      $page = 1; //default
 } 

//determino quanti sono in tutto gli articoli trovati
//non mi interessa l'ordinamento, che viene stabilito più sotto
$queryb = "SELECT * FROM qui_righe_carrelli WHERE id = '$id_cart'";
$resultb = mysql_query($queryb);
$total_items = mysql_num_rows($resultb);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titolo_carrello; ?></title>
<link href="tabelle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#main_container {
	width:800px;
	margin: auto;
}
-->
</style>
</head>

<body>
<div id="main_container">
<table width="960" border="0" cellspacing="0" cellpadding="0">
<tr>
      <td width="669">&nbsp;</td>
      <td width="331" class="ecoformdestra">
</td>
  </tr>
</table>
<table width="960" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><?php //include "base_ricerca.php"; ?>
</td>
  </tr>
</table>
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="861" class="ecoformdestra"><?php echo $elementi_pagina; ?></td>
    <td width="139" class="ecoformdestra"> <a href="<?php echo $_SERVER['PHP_SELF']; ?>?limit=5&page=1">5</a> | <a href="<?php echo $_SERVER['PHP_SELF']; ?>?limit=10&page=1">10</a> | <a href="<?php echo $_SERVER['PHP_SELF']; ?>?limit=15&page=1">15</a> | <a href="<?php echo $_SERVER['PHP_SELF']; ?>?limit=20&page=1">20</a> | <a href="<?php echo $_SERVER['PHP_SELF']; ?>?limit=25&page=1">25</a></td>
  </tr>
</table>
    <table width=960 border="0">
  <tr bgcolor="#CCCCCC"> 
    <td width="95" class=tabellecentro><?php echo $testata_codice; ?></td>
    <td width="125" class=tabellecentro><?php echo $testata_nazione; ?></td>
    <td width="320" class=tabellecentro><?php echo $testata_prodotto; ?></td>
    <td width="80" class=tabellecentro><?php echo $testata_imballo; ?></td>
    <td width="95" class=tabellecentro><?php echo $testata_prezzo; ?> &euro;</td>
    <td width="70" class=tabellecentro>+</td>
    <td width="70" class=tabellecentro><?php echo $testata_preferito; ?></td>
    <td width="70" class=tabellecentro><?php echo $testata_carrello; ?></td>
    </tr>
  <?php
$querya = "SELECT * FROM qui_righe_carrelli WHERE id = '$id_cart'";
$result = mysql_query($querya) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($row = mysql_fetch_array($risultg)) {
$id_prod = $row[id_prodotto];
 $sf = 1;
//inizia il corpo della tabella
$queryb = "SELECT * FROM qui_prodotti WHERE id = '$id_prod'";
$resultb = mysql_query($queryb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rowb = mysql_fetch_array($resultb)) {

if ($sf == 1) {
$sfondo = "#FFFF00";
} else {
$sfondo = "#FFFFFF";
}
Code	ID		Type	Material	Colour	Stamping	Price	Price	Remove	Qty.	Total


//*******************************************
//RIFERIMENTO PER RITORNO A LISTA
echo "<tr><td colspan=8><a name=".$row[id]."><img src=immagini/riga_prev.jpg width=960 height=1></a></td></tr>";
//*******************************************
echo "<tr bgcolor=".$sfondo."><td valign=top class=tabellecentro>";
echo $rowb[codice_art];
echo "</td>";
echo "<td valign=top class=tabelle>".stripslashes($rowb[nazione])."</td>";
echo "<td valign=top class=tabelle>";
switch($lingua) {
case "it":
echo $rowb[descrizione_it];
break;
case "en":
echo $rowb[descrizione_en];
break;
case "fr":
echo $rowb[descrizione_fr];
break;
case "de":
echo $rowb[descrizione_de];
break;
case "es":
echo $rowb[descrizione_es];
break;
}
echo "</td>";
echo "<td valign=top class=tabelledestra>";
echo $rowb[imballo];
echo "</td>";
echo "<td valign=top class=tabelledestra>";
echo number_format($rowb[prezzo],2,",",".");
echo "</td>";
echo "<td valign=top class=tabellecentro>";

echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?id=".$row[id]."&lang=".$lingua."', 'myPop1',800,400);\"><img src=immagini/button_add.gif width=19 height=19 border=0></a>";
echo "</td>";
echo "<td valign=top class=tabellecentro>";
echo "</td>";
echo "<td valign=top class=tabellecentro>";
echo "</td>";
echo "</tr>"; 
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}
}
echo "<tr><td colspan=8><img src=immagini/riga_prev.jpg width=960 height=1></td></tr>";
?>
</table>
    <table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="num_pag">
    <?php
//posizione per paginazione
$prev_page = $page - 1;

if($prev_page >= 1) { 
  echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?cat=$cat&limit=$limit&page=$prev_page&lang=$lingua><b><<</b></a>"; 
} 
for($a = 1; $a <= $total_pages; $a++)
{
   if($a == $page) {
      echo("<span class=current_num_pag> $a</span> | "); //no link
	 } else {
  echo("  <a href=".$_SERVER['PHP_SELF']."?cat=$cat&limit=$limit&page=$a&lang=$lingua> $a </a> | ");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   echo "<a href=".$_SERVER['PHP_SELF']."?cat=$cat&limit=$limit&page=$next_page&lang=$lingua><b>>></b></a>"; 
} 
?>
        </td>
      </tr>
    </table>
    </div>

</body>
</html>
