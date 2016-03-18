<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$diam = $_GET[diam];
$ord = $_GET[ord];
$materiale = $_GET[materiale];
$_SESSION[materiale] = $materiale;
$_SESSION[diametro] = $diam;
/*include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$sqlt = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND categoria2_it = '$_SESSION[categoria2]' AND categoria1_it = '$_SESSION[categoria1]' AND categoria3_it = '$_SESSION[categoria3]' AND id_valvola = '$_SESSION[id_valvola]' AND materiale = '$materiale' AND categoria4_it = '$_SESSION[capacita]' AND diametro = '$_SESSION[diametro]'";
		  $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
		while ($rigat = mysql_fetch_array($risultt)) {
$descr .= "<div class=Titolo_famiglia>".str_replace("_"," ",$rigat[categoria3_it])."</div>";
				$descr .= "<div class=descr_famiglia>".stripslashes($rigat[descrizione2_it])."</div>";
				//recupero informazioni valvola
		$sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigat[id_valvola]'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
		while ($rigam = mysql_fetch_array($risultm)) {
				$descr .= "<div class=descr_famiglia>".stripslashes($rigam[descrizione2_it]);
				$descr .= "</div>";
				//fine while valvola
		}
				//recupero informazioni cappellotto
		$sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigat[id_cappellotto]'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
		while ($rigan = mysql_fetch_array($risultn)) {
				$descr .= "<div class=descr_famiglia>".stripslashes($rigan[descrizione2_it]);
				$descr .= "</div>";
				//fine while cappellotto
		}
	//fine while principale
		}*/
	//output finale
				//echo $descr;
				echo "pippo";
?>
