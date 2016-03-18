<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$reset = $_GET[reset];
$capacita = $_GET[cap];
$diam = $_GET[diam];
$ord = $_GET[ord];
$materiale = $_GET[materiale];
$_SESSION[materiale] = $materiale;
$_SESSION[capacita] = $capacita;
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$array_capacita = array();
$sqlt = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria2_it = '$_SESSION[categoria2]' AND categoria1_it = '$_SESSION[categoria1]' AND categoria3_it = '$_SESSION[categoria3]' AND id_valvola = '$_SESSION[id_valvola]' AND materiale = '$materiale' ORDER BY codice_art ASC";
		  $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
		while ($rigat = mysql_fetch_array($risultt)) {
			if (!in_array($rigat[categoria4_it],$array_capacita)){
		  $add_capac = array_push($array_capacita,$rigat[categoria4_it]);
if ($reset == 1) {
$_SESSION[capacita] = "";
		  $blocco_cat4 .= "<div class=icona_singola><img src=immagini/".$rigat[icona]." onClick=\"cap_change('".$rigat[categoria4_it]."','".$materiale."','".$ord."')\"></div>";
} else {

		  if ($rigat[categoria4_it] == $capacita) {
		  $blocco_cat4 .= "<div class=icona_singola><img src=immagini/".$rigat[icona]." onClick=\"cap_change('".$rigat[categoria4_it]."','".$materiale."','".$ord."')\"></div>";
		  } else {
		  $blocco_cat4 .= "<div class=icona_singola_abbassata><img src=immagini/".$rigat[icona]." onClick=\"cap_change('".$rigat[categoria4_it]."','".$materiale."','".$ord."')\"></div>";
		  }
	//fine if reset
	}
	//fine while ricerca capacità per materiale
	}
}
//$blocco_cat4 .= $_SESSION[capacita];
	//output finale
				echo $blocco_cat4;
?>
