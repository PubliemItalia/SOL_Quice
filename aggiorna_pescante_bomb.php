<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$lingua = $_GET[lang];
$id = $_GET[id];
$negozio = $_GET[negozio];
$famiglia = $_GET[famiglia];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

switch ($lingua) {
  case "it":
	$dic_pesc_con = "Con pescante";
	$dic_pesc_senza = "Senza pescante";
  break;
  case "en":
	$dic_pesc_con = "With pescante";
	$dic_pesc_senza = "Without pescante";
  break;
}
$testoQuery = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($rigak = mysql_fetch_array($result)) {
  //recupero informazioni pescante
$div_dati .= "<div class=\"Titolo_famiglia_bombole\" style=\"width:250px; height:auto; margin-bottom:5px; font-weight:normal; font-size:12px; color:rgb(0,0,0);\">";
switch ($rigak[id_pescante]) {
  case "":
$div_dati .= $dic_pesc_senza."<input type=radio name=pescante".$rigak[id]." id=no_pesc".$rigak[id]." onClick=\"prezzo_senza_pescante(".$rigak[rif_famiglia].")\">";
$div_dati .= $dic_pesc_con."<input type=radio name=pescante".$rigak[id]." id=ok_pesc".$rigak[id]." onClick=\"prezzo_con_pescante(".$rigak[rif_famiglia].")\">";
	$prezzo_pescante = 0;
  break;
  case "SI":
$div_dati .= $dic_pesc_con."<input name=pescante".$rigak[id]." type=radio id=ok_pesc".$rigak[id]." checked>";
	$prezzo_pescante = 4;
  break;
  case "NO":
$div_dati .= $dic_pesc_senza."<input name=pescante".$rigak[id]." type=radio id=no_pesc".$rigak[id]." checked>";
	$prezzo_pescante = 0;
  break;
}
$div_dati .= "</div>"; 
$div_dati .= "<div id=\"componente_pescante_".$rigak[rif_famiglia]."\" class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:280px; height:auto; text-align:right; color:rgb(0,0,0); font-size:12px; font-weight:normal; line-height:140%;\">";
$div_dati .= number_format($prezzo_pescante,2,",",".");
$div_dati .= "<input name=prezzo_pescante_hidden".$rigak[rif_famiglia]." type=hidden id=prezzo_pescante_hidden".$rigak[rif_famiglia]." value=".$prezzo_pescante.">";
$div_dati .= "</div>";
  }

//output finale
	echo $div_dati;
//	echo $id;
?>
