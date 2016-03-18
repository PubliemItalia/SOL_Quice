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
	$sqlk = "SELECT * FROM qui_prodotti_assets WHERE id = '$id'";
	$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigak = mysql_fetch_array($risultk)) {
		$chilaggio = $rigak[capac_kg];
	}
//per ogni tipologia di bombole costruisco il blocco delle icone dei litraggi
	$sqlm = "SELECT * FROM qui_prodotti_assets WHERE rif_famiglia = '$famiglia' ORDER BY categoria4_it ASC";
	$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigam = mysql_fetch_array($risultm)) {
		if ($rigam[id] == $id) {
    if ($rigam[categoria4_it] == 0) {
	  $capacit = "0,5";
  } else {
	  $capacit = $rigam[categoria4_it];
  }
	  $blocco_cat4 .= "<div class=icona_singola><img src=\"immagini/".$rigam[categoria4_it]."l_neg.png\"></div>";
		} else {
	  $blocco_cat4 .= "<div class=icona_singola style=\"cursor:pointer;\"><img src=\"immagini/".$rigam[categoria4_it]."l.png\" name=\"imm_".$rigam[categoria4_it]."l\" id=\"imm_".$rigam[categoria4_it]."l\" border=0 onMouseOver=\"MM_swapImage('imm_".$rigam[categoria4_it]."l','','immagini/".$rigam[categoria4_it]."l_neg.png',1)\" onMouseOut=\"MM_swapImgRestore()\" onClick=\"compilazione(".$rigam[id].",".$rigam[rif_famiglia].")\"></div>";
		}
  }
		  switch ($_SESSION[lang]) {
			case "it":
			$Scritta_capacity = "Capacit&agrave;";
			break;
			case "en":
			$Scritta_capacity = "Capacity";
			break;
		  }

		$div_dati .= "<div class=\"descr_famiglia\" style=\"width:525px;\">";
		$div_dati .= "<strong>".$Scritta_capacity." ".$capacit." l";
		if ($chilaggio > 0) {
			$div_dati .= " (".$chilaggio." kg)</strong>";
		}
		$div_dati .= "</div>";
		$div_dati .= $blocco_cat4; 
	//output finale
	echo $div_dati;
//	echo $id;
?>