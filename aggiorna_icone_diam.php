<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$capacita = $_GET[cap];
$diam = $_GET[diam];
$materiale = $_GET[materiale];
$reset = $_GET['reset'];
$ord = $_GET[ord];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

		$array_diametri = array();
		$array_capacita = array();

if ($reset == 1) {
$_SESSION[diametro] = "";
			$sqlf = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria2_it = '$_SESSION[categoria2]' AND categoria1_it = '$_SESSION[categoria1]' AND categoria3_it = '$_SESSION[categoria3]' AND id_valvola = '$_SESSION[id_valvola]' AND materiale = '$materiale' ORDER BY codice_art ASC";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
		while ($rigaf = mysql_fetch_array($risultf)) {
			if (!in_array($rigaf[diametro],$array_diametri)){
		  $add_diam = array_push($array_diametri,$rigaf[diametro]);
		  $blocco_diametri .= "<div class=icona_singola><img src=immagini/".$rigaf[diametro].".png onClick=\"diam_change_def('".$rigaf[diametro]."','".$materiale."','".$ord."')\"></div>";
		  //fine if in array
			}
			//fine while
		}
		} else {
		$sqlf = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria2_it = '$_SESSION[categoria2]' AND categoria1_it = '$_SESSION[categoria1]' AND categoria3_it = '$_SESSION[categoria3]' AND id_valvola = '$_SESSION[id_valvola]' AND materiale = '$materiale' AND categoria4_it = '$capacita' ORDER BY codice_art ASC";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
		while ($rigaf = mysql_fetch_array($risultf)) {
		//if ($rigaf[categoria4_it] == $capacita) {
		  $blocco_diametri .= "<div class=icona_singola><img src=immagini/".$rigaf[diametro].".png onClick=\"diam_change_def('".$rigaf[diametro]."','".$materiale."','".$ord."')\"></div>";
		//} else {
		  //$blocco_diametri .= "<div class=icona_singola_abbassata><img src=immagini/".$rigaf[diametro].".png onClick=\"diam_change_def('".$rigaf[diametro]."','".$materiale."','".$ord."')\"></div>";
		  //}
	//fine while ricerca diametri per materiale
	}
	//fine if reset
}
	//output finale
				echo $blocco_diametri;
?>
