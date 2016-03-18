<?php
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
if (!isset($_SESSION[lang])) {
$_SESSION[lang] = "it";
}
if ((isset($_POST[mod_lang])) AND ($_POST[lang] != "")) {
$_SESSION[lang] = $_POST[lang];
}
if ((isset($_GET[mod_lang])) AND ($_GET[lang] != "")) {
$_SESSION[lang] = $_GET[lang];
}
$lingua = $_SESSION[lang];
//echo "lingua: ".$lingua."<br>";
include "query.php";
include "traduzioni_interfaccia.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$codice_ricerca = $_GET[cod];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Quice - Prodotti</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/visual.css" />
<link href="css/lightbox3.css" rel="stylesheet" />
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<style type="text/css">
<!--
#main_container {
	width:960px;
	margin: auto;
	margin-top: 10px;
	margin-bottom:20px;
    /*	background-color: #CCCCCC;*/
	min-height:300px;
	overflow:hidden;
	height: auto;
}
#pulsante_invio {
	width:120px;
	padding: 10px;
	margin-left: 10px;
	height: 10px;
	background-color: #666;
	color:white;
}
-->
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox3.js"></script>

</head>
<?php
//if ($mode != "") {
//echo "<body onLoad=compilazione()>";
//} else {
echo "<body>";
//}
?><body>
<div id="main_container">

<?php
//********************************************************
//visualizzazione articolo unico con varianti a icona
//********************************************************
switch ($_SESSION[lang]) {
  case "it":
  $code = "Codice";
  $price = "Prezzo";
  $inserisci_carrello = "Inserisci nel carrello";
  $scheda_tecnica = "Scheda tecnica";
  $voce_stampa = "Stampa";
  $add_favoriti = "Aggiungi ai preferiti";
  $elim_favoriti = "Elimina dai preferiti";
  $gallery = "Galleria immagini";
  $dic_pressione = "Press. collaudo/esercizio";
  $dic_punz = "Tipo bombola";
  $dic_ricollaudo = "Revisione prima/succ.";
  $dic_col_corpo = "Colore corpo";
  $dic_col_ogiva = "Colore ogiva";
  $dic_termoretr = "Termoretraibile rosso";
  $dic_disc_med = "Disco medicale";
  $dic_bar_code = "Barcode";
  $dic_solvente = "Solvente";
  $dic_note = "Note";
  $dic_anni = "anni";
  $risp_aff = "Si";
  $risp_neg = "No";
  $bomb_compl = "Bombola completa";
break;
  case "en":
  $code = "Code";
  $price = "Price";
  $inserisci_carrello = "Add to cart";
  $scheda_tecnica = "Technical sheet";
  $voce_stampa = "Print";
  $add_favoriti = "Add to favourites";
  $elim_favoriti = "Remove from favourites";
  $gallery = "Image gallery";
  $dic_pressione = "Test/Working pressure";
  $dic_punz = "Marking";
  $dic_ricollaudo = "Test first/following";
  $dic_col_corpo = "Body colour";
  $dic_col_ogiva = "Groin colour";
  $dic_termoretr = "Red film";
  $dic_disc_med = "Med. Disc";
  $dic_bar_code = "Barcode";
  $dic_solvente = "Solvent";
  $dic_note = "Notes";
  $dic_anni = "years";
  $risp_aff = "Yes";
  $risp_neg = "No";
  $bomb_compl = "Whole cylinder";
  break;
}

//riquadro bombola
echo "<div id=risultati_bombole>";
$sqla = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$codice_ricerca."'";
	$risulta = mysql_query($sqla) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	//while bombola
	while ($rigaa = mysql_fetch_array($risulta)) {
		$cod_valvola = $rigaa[id_valvola];
		$cod_cappellotto = $rigaa[id_cappellotto];
		$pres_pescante = $rigaa[id_pescante];
		$categ1 = $rigaa[categoria1_it];
		$categ2 = $rigaa[categoria2_it];
		$categ3 = $rigaa[categoria3_it];
		$icona_capacit = '<div class=icona_singola><img src="immagini/'.$rigaa[categoria4_it].'l_neg.png"></div>';
		$punzonatura = $rigaa[punz_ogiva];
		$prezzo_corpo = $rigaa[prezzo];
		if ($rigaa[categoria4_it] == 0) {
		  $capacit = "0,5";
		} else {
		  $capacit = $rigaa[categoria4_it];
		}
		//recupero informazioni valvola
		if ($rigaa[id_valvola] != "") {
		  $sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigaa[id_valvola]'";
		  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
		  while ($rigam = mysql_fetch_array($risultm)) {
			$prezzo_valvola = $rigam[prezzo];
			if ($rigaa[id_valvola] == "Val104") {
			  $descr_valvola .= '<span style="color:#0079ca;">';
			} else {
			  $descr_valvola .= '<span style="color:#000;">';
			}
		//echo "id: ".$rigaa[id]."<br>";
			switch ($_SESSION[lang]) {
			  case "it":
				//$descr_valvola = $rigaa[id_valvola]." ".$rigam[descrizione1_it];
				$descr_valvola .= $rigam[descrizione1_it];
			  break;
			  case "en":
				if ($rigam[descrizione1_en] != "") {
				  $descr_valvola .= $rigam[descrizione1_en];
				} else {
				  $descr_valvola .= $rigam[descrizione1_it];
				}
			  break;
			}
			$descr_valvola .= "</span>";
		  }
		}

		//recupero informazioni cappellotto
		if ($rigaa[id_cappellotto] != "") {
		  $sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigaa[id_cappellotto]'";
		  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
		  while ($rigan = mysql_fetch_array($risultn)) {
			$prezzo_cappellotto = $rigan[prezzo];
			switch ($_SESSION[lang]) {
			  case "it":
				stripslashes($descr_cappellotto = $rigan[descrizione1_it]);
			  break;
			  case "en":
				if ($rigan[descrizione1_en] != "") {
				  stripslashes($descr_cappellotto = $rigan[descrizione1_en]);
				} else {
				  stripslashes($descr_cappellotto = $rigan[descrizione1_it]);
				}
			  break;
			}
		  }
		}
		switch ($rigaa[id_pescante]) {
			  case "":
				$prezzo_pescante = "";
			  break;
			  case "NO":
				$prezzo_pescante = "0";
			  break;
			  case "SI":
				$prezzo_pescante = "4";
			  break;
		}
		$prezzo_totale = $rigaa[prezzo]+$prezzo_valvola+$prezzo_cappellotto+$prezzo_pescante;

		switch ($_SESSION[lang]) {
		  case "it":
			$desc_bomb = $rigaa[descrizione1_it];
		  break;
		  case "en":
			if ($rigaa[descrizione1_en] != "") {
			  $desc_bomb = $rigaa[descrizione1_en];
			} else {
			  $desc_bomb = $rigaa[descrizione1_it];
			}
		  break;
		}
		  

echo "<div class=riquadro_bombole>";
  echo "<div id=blocco_sup style=\"width:940px; height:100px; border-bottom:1px solid rgb(200,200,200);\">";
	echo "<div id=solo_descrizioni style=\"width:550px; height:auto;; float:left;\">";
	  echo "<div id=\"componente_titolo_".$rigaa[rif_famiglia]."\" style=\"width:550px; height:auto;; float:left;\">";
		//descrizioni
		echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:490px; height:71px; margin-bottom:2px;\">";
		  echo $desc_bomb."<br>".$descr_valvola."<br>".$descr_cappellotto."<br>";
		echo "</div>";
		//prezzi
		echo "<div class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:40px; height:auto; text-align:right; font-size:12px; font-weight:normal; line-height:140%;\">";
		  echo number_format($prezzo_corpo,2,",",".")."<br>";
		  if ($rigaa[id_valvola] != "") {
			  echo number_format($prezzo_valvola,2,",",".");
		  }
		  echo "<br>";
		  if ($rigaa[id_cappellotto] != "") {
			echo number_format($prezzo_cappellotto,2,",",".");
		  }
	  echo "</div>"; 
	echo "</div>"; 
	  switch ($_SESSION[lang]) {
		case "it":
		  $dic_pesc_con = "Con pescante";
		  $dic_pesc_senza = "Senza pescante";
		break;
		case "en":
		  $dic_pesc_con = "With pescante";
		  $dic_pesc_senza = "Without pescante";
		break;
	  }
	  echo "<div id=\"pescante_".$rigaa[rif_famiglia]."\" style=\"width:auto; height:auto; float:left;\">";
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:250px; height:auto; margin-bottom:5px; font-weight:normal; font-size:12px; color:rgb(0,0,0);\">";
	  		  switch ($rigaa[id_pescante]) {
				  case "":
					echo $dic_pesc_senza."<input type=radio name=pescante".$rigaa[id]." id=no_pesc".$rigaa[id]." onClick=\"prezzo_senza_pescante(".$rigaa[rif_famiglia].")\">";
					echo $dic_pesc_con."<input type=radio name=pescante".$rigaa[id]." id=ok_pesc".$rigaa[id]." onClick=\"prezzo_con_pescante(".$rigaa[rif_famiglia].")\">";
				  break;
				  case "SI":
					echo $dic_pesc_con."<input name=pescante".$rigaa[id]." type=radio id=ok_pesc".$rigaa[id]." checked>";
				  break;
				  case "NO":
					echo $dic_pesc_senza."<input name=pescante".$rigaa[id]." type=radio id=no_pesc".$rigaa[id]." checked>";
				  break;
			  }

		echo "</div>"; 
		echo "<div id=\"componente_pescante_".$rigaa[rif_famiglia]."\" class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:280px; height:auto; text-align:right; color:rgb(0,0,0); font-size:12px; font-weight:normal; line-height:140%;\">";
	if ($prezzo_pescante == "") {
		echo "0,00";
		  echo "<input name=prezzo_pescante_hidden".$rigaa[rif_famiglia]." type=hidden id=prezzo_pescante_hidden".$rigaa[rif_famiglia]." value=0>";
} else {
		  echo number_format($prezzo_pescante,2,",",".");
		  echo "<input name=prezzo_pescante_hidden".$rigaa[rif_famiglia]." type=hidden id=prezzo_pescante_hidden".$rigaa[rif_famiglia]." value=".$prezzo_pescante.">";
	}
		 
		echo "</div>";
	echo "</div>";
	//fine pescante
	echo "</div>";
	//fine componente titolo

	echo "<div id=\"componente_codice_".$rigaa[rif_famiglia]."\" style=\"width:380px; height:100px; float:right;\">";
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"width:250px; height:auto; margin-bottom:5px; float:right; font-size:12px; text-align:right;\">";
		echo "<span style=\"font-weight:normal;\">".$code."</span> ";
		echo $rigaa[codice_art];
	  echo "</div>"; 
	  echo "<div class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:280px; height:auto; text-align:right; color:#0079ca; float:right\">";
		echo "<span style=\"font-weight:normal;\">".$price." ".$bomb_compl."</span> ".number_format($prezzo_totale,2,",",".");
	  echo "</div>";
	  echo "<div id=componente_dati class=componente_dati_bombola style=\"margin-left:5px; width:280px; height:auto; text-align:right; float:right; margin-top:25px;\">";
		//echo "<div class=\"scritte_bottoncini_bomb\" style=\"width:130px;\">";
		  switch ($_SESSION[lang]) {
			case "it":
			$Scritta_capacity = "Capacit&agrave;";
			  echo "<strong>Costi orientativi.<br>Contattare i buyer per i prezzi aggiornati!</strong>";
			break;
			case "en":
			$Scritta_capacity = "Capacity";
			  echo "<strong>Costs may not be real.<br>Please contact buyers for updated prices!</strong>";
			break;
		  }
		//echo "</div>"; 
	  //fine div componente_dati_bombola
	  echo "</div>";
	echo "</div>";
	  //fine div componente_codice
  echo "</div>";
//fine div blocco_sup
	
  echo "<div style=\"width:530px; height:auto; float:left; margin-top:30px;\">";
	echo "<div id=\"componente_descrizione_".$rigaa[rif_famiglia]."\" class=\"componente_descrizione_bombola\">";
	  echo "<div class=\"descr_famiglia_bombole\" style=\"width:340px; height:100px;\">";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_pressione;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
		  if ($rigaa[pressione] == 0) {
			  echo "-";
		  } else {
			echo $rigaa[pressione]." bar";
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_punz;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo $rigaa[punz_ogiva];
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_ricollaudo;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo $rigaa[anni_anello_scadenza]." ".$dic_anni;
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_col_corpo;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo str_replace("bidoni","",$rigaa[descrizione3_it]);
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb>";
		  echo "<div class=scritte_bottoncini_bomb>";
			echo $dic_col_ogiva;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb>";
			echo str_replace("bidoni","",$rigaa[descrizione4_it]);
		  echo "</div>";
		echo "</div>";
	  echo "</div>";
	  echo "<div class=\"descr_famiglia_bombole\" style=\"margin-left:10px; width:185px; height:100px;\">";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_termoretr;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigaa[termoretr_rosso]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_disc_med;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigaa[disc_medicale]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_bar_code;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
		  switch ($rigaa[barcode]) {
			  case "0":
				echo $risp_neg;
			  break;
			  case "1":
				echo $risp_aff;
			  break;
		  }
		  echo "</div>";
		echo "</div>";
		echo "<div class=contenitore_bottoncini_bomb_corto>";
		  echo "<div class=scritte_bottoncini_bomb_corto>";
		  echo $dic_solvente;
		  echo "</div>";
		  echo "<div class=bottoncini_bomb_corto>";
			echo $rigaa[solvente];
		  echo "</div>";
		echo "</div>";
	  echo "</div>";
	//fine div componente_descrizione_bombola
	echo "</div>";
	echo "<div id=componente_iconcine_".$rigaa[rif_famiglia]." style=\"float:left; width:530px; margin-top:35px;\">";
	  echo "<div class=\"descr_famiglia\" style=\"width:525px;\">";
		echo "<strong>".$Scritta_capacity." ".$capacit." l";
		if ($rigaa[capac_kg] > 0) {
			echo " (".$rigaa[capac_kg]." kg)</strong>";
		}
	  echo "</div>";
	  echo $icona_capacit;
	echo "</div>";
  //fine div raggruppamento
  echo "</div>";
  $desc_bomb = ""; 
  $descr_valvola = "";
  $descr_cappellotto = "";
  //$prezzo_pescante = "";
  $prezzo_valvola = "";
  $prezzo_cappellotto = "";
  $prezzo_corpo = "";
  $punzonatura = "";
  
$corpo = str_replace(" ","_",$rigaa[descrizione3_it]);
$ogiva = str_replace(" ","_",$rigaa[descrizione4_it]);
if ($rigaa[id_valvola] != "") {
  $sqld = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '".$rigaa[id_valvola]."'";
  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigad = mysql_fetch_array($risultd)) {
	  switch($rigad[descrizione3_it]) {
		case "valvola_riduttrice":
		  $valvola = "vr";
		break;
		case "valvola_parziale_ottone":
		  $valvola = "vpo";
		break;
		case "valvola_parziale_cromata":
		  $valvola = "vpc";
		break;
		case "valvola_completa_ottone":
		  $valvola = "vco";
		break;
		case "valvola_completa_cromata":
		  $valvola = "vcc";
		break;
		case "valvola5-8":
		  $valvola = "v5-8";
		break;
		case "valvola_integrata_parziale":
		  $valvola = "vip";
		break;
	  }
  }
} else {
	$valvola = "v0";
}
if ($rigaa[id_cappellotto] != "") {
  $cappellotto = str_replace(" ","_",$rigaa[id_cappellotto]);
} else {
  $cappellotto = "CAP000";
}
$img_bombola = $corpo."-".$ogiva."-".$valvola."-".$cappellotto.".png";
echo "<div id=componente_immagine_".$rigaa[rif_famiglia]." class=\"componente_immagine_bombola\" style=\"margin-top:10px;\">";
echo "<img src=temp_bombole/".$img_bombola." width=248 height=248>";
echo "</div>";
$corpo = "";
$ogiva = "";
$valvola = "";
$cappellotto = "";
$img_bombola = "";
		//fine div riquadro bombola
		echo "</div>"; 
	//fine while bombola
	}
//div riquadro valvola
		if ($cod_valvola != "") {

	  $sqlq = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$cod_valvola'";
	  $risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione11 " . mysql_error());
	  while ($rigaq = mysql_fetch_array($risultq)) {

			echo '<div id="riquadro_prodotto" style="margin-top:20px;">';
			//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
			echo "<div id=raggruppamento>";
			echo "<div class=Titolo_famiglia>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo str_replace("_"," ",$rigaq[categoria3_it]);
			  break;
			  case "en":
				if ($rigaq[categoria3_en] == "") {
				  echo str_replace("_"," ",$rigaq[categoria3_it]);
				} else {
				  echo str_replace("_"," ",$rigaq[categoria3_en]);
				}
			  break;
			}
			echo "</div>";
			echo "<div id=componente_descrizione>";
			echo "<div class=descr_famiglia>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo stripslashes($rigaq[descrizione2_it]);
			  break;
			  case "en":
			  echo stripslashes($rigaq[descrizione2_en]);
			  break;
			}
			echo "</div>";
			echo "<div id=variante class=variante_testuale>";
			if ($rigaq[categoria4_it] != "0") {
			  switch ($_SESSION[lang]) {
				case "it":
				echo stripslashes($rigaq[categoria4_it]);
				break;
				case "en":
				echo stripslashes($rigaq[categoria4_en]);
				break;
			  }
			}
			echo "</div>";
			echo "</div>";
			//echo "<div id=risultato>";
			echo "<div id=componente_dati>";
			echo "<div class=scritte_bottoncini>".$code."</div>"; 
			  echo "<div class=bottoncini>";
			  if (substr($rigaq[codice_art],0,1) != "*") {
				echo $rigaq[codice_art];
			  } else {
				echo substr($rigaq[codice_art],1);
			  }
			  echo "</div>";
			//echo "<div class=scritte_bottoncini>".$grmerci."</div>"; 
			//echo "<div class=bottoncini>".$rigaq[gruppo_merci]."</div>";
			echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>";
		if ($rigaq[prezzo] > 0) {
			echo number_format($rigaq[prezzo],2,",",".");
		} else {
		  switch ($_SESSION[lang]) {
			case "it":
			  echo "da calcolare";
			break;
			case "en":
			  echo "to be quoted";
			break;
		  }
		}
		echo "</div>";
			echo "<div class=scritte_bottoncini>".$package."</div>"; 
		  echo "<div class=bottoncini>";
			  switch ($_SESSION[lang]) {
				case "it":
				  echo $rigaq[confezione];
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$rigaq[confezione]);
				$conf = str_replace("blocchi da", "blocks of",$conf);
				$conf = str_replace("fogli da", "sheets of",$conf);
				$conf = str_replace("blister singoli", "one piece",$conf);
				$conf = str_replace("bustina singola", "one bag",$conf);
				$conf = str_replace("etichetta singola", "one label",$conf);
				$conf = str_replace("etichette", "labels",$conf);
				$conf = str_replace("fogli", "sheets",$conf);
				$conf = str_replace("bustine", "bags",$conf);
				  echo $conf;
				break;
			  }
		  echo "</div>";
			echo "</div>";
			echo "<div id=componente_iconcine>";
			echo "</div>";
			echo "</div>";
			
			echo "<div id=componente_immagine>";
			if ($rigaq[foto] != "") {
			  echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
			} else {
			  echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
			}
			echo "</div>";
	  }
			echo "</div>";
	  
		// fine if ($cod_valvola != "") {
		}
	
	
	//div riquadro cappellotto
		if ($cod_cappellotto != "") {

	  $sqlq = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$cod_cappellotto'";
	  $risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione11 " . mysql_error());
	  while ($rigaq = mysql_fetch_array($risultq)) {

			echo '<div id="riquadro_prodotto" style="margin-top:20px;">';
			//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
			echo "<div id=raggruppamento>";
			echo "<div class=Titolo_famiglia>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo str_replace("_"," ",$rigaq[categoria3_it]);
			  break;
			  case "en":
				if ($rigaq[categoria3_en] == "") {
				  echo str_replace("_"," ",$rigaq[categoria3_it]);
				} else {
				  echo str_replace("_"," ",$rigaq[categoria3_en]);
				}
			  break;
			}
			echo "</div>";
			echo "<div id=componente_descrizione>";
			echo "<div class=descr_famiglia>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo stripslashes($rigaq[descrizione2_it]);
			  break;
			  case "en":
			  echo stripslashes($rigaq[descrizione2_en]);
			  break;
			}
			echo "</div>";
			echo "<div id=variante class=variante_testuale>";
			if ($rigaq[categoria4_it] != "0") {
			  switch ($_SESSION[lang]) {
				case "it":
				echo stripslashes($rigaq[categoria4_it]);
				break;
				case "en":
				echo stripslashes($rigaq[categoria4_en]);
				break;
			  }
			}
			echo "</div>";
			echo "</div>";
			//echo "<div id=risultato>";
			echo "<div id=componente_dati>";
			echo "<div class=scritte_bottoncini>".$code."</div>"; 
			  echo "<div class=bottoncini>";
			  if (substr($rigaq[codice_art],0,1) != "*") {
				echo $rigaq[codice_art];
			  } else {
				echo substr($rigaq[codice_art],1);
			  }
			  echo "</div>";
			//echo "<div class=scritte_bottoncini>".$grmerci."</div>"; 
			//echo "<div class=bottoncini>".$rigaq[gruppo_merci]."</div>";
			echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>";
		if ($rigaq[prezzo] > 0) {
			echo number_format($rigaq[prezzo],2,",",".");
		} else {
		  switch ($_SESSION[lang]) {
			case "it":
			  echo "da calcolare";
			break;
			case "en":
			  echo "to be quoted";
			break;
		  }
		}
		echo "</div>";
			echo "<div class=scritte_bottoncini>".$package."</div>"; 
		  echo "<div class=bottoncini>";
			  switch ($_SESSION[lang]) {
				case "it":
				  echo $rigaq[confezione];
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$rigaq[confezione]);
				$conf = str_replace("blocchi da", "blocks of",$conf);
				$conf = str_replace("fogli da", "sheets of",$conf);
				$conf = str_replace("blister singoli", "one piece",$conf);
				$conf = str_replace("bustina singola", "one bag",$conf);
				$conf = str_replace("etichetta singola", "one label",$conf);
				$conf = str_replace("etichette", "labels",$conf);
				$conf = str_replace("fogli", "sheets",$conf);
				$conf = str_replace("bustine", "bags",$conf);
				  echo $conf;
				break;
			  }
		  echo "</div>";
			echo "</div>";
			echo "<div id=componente_iconcine>";
			echo "</div>";
			echo "</div>";
			
			echo "<div id=componente_immagine>";
			if ($rigaq[foto] != "") {
			  echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
			} else {
			  echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
			}
			echo "</div>";
	  }
			echo "</div>";
	  
		// fine if ($cod_cappellotto != "") {
		}
	//div riquadro pescante
	//echo "pres_pescante: ".$pres_pescante."<br>";
		if ($pres_pescante == "SI") {

	  $sqlq = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '*DT020'";
	  $risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione11 " . mysql_error());
	  while ($rigaq = mysql_fetch_array($risultq)) {

			echo '<div id="riquadro_prodotto" style="margin-top:20px;">';
			echo "<div id=raggruppamento>";
			echo "<div class=Titolo_famiglia>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo str_replace("_"," ",$rigaq[categoria3_it]);
			  break;
			  case "en":
				if ($rigaq[categoria3_en] == "") {
				  echo str_replace("_"," ",$rigaq[categoria3_it]);
				} else {
				  echo str_replace("_"," ",$rigaq[categoria3_en]);
				}
			  break;
			}
			echo "</div>";
			echo "<div id=componente_descrizione>";
			echo "<div class=descr_famiglia>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo stripslashes($rigaq[descrizione2_it]);
			  break;
			  case "en":
			  echo stripslashes($rigaq[descrizione2_en]);
			  break;
			}
			echo "</div>";
			echo "<div id=variante class=variante_testuale>";
			if ($rigaq[categoria4_it] != "0") {
			  switch ($_SESSION[lang]) {
				case "it":
				echo stripslashes($rigaq[categoria4_it]);
				break;
				case "en":
				echo stripslashes($rigaq[categoria4_en]);
				break;
			  }
			}
			echo "</div>";
			echo "</div>";
			//echo "<div id=risultato>";
			echo "<div id=componente_dati>";
			echo "<div class=scritte_bottoncini>".$code."</div>"; 
			  echo "<div class=bottoncini>";
			  if (substr($rigaq[codice_art],0,1) != "*") {
				echo $rigaq[codice_art];
			  } else {
				echo substr($rigaq[codice_art],1);
			  }
			  echo "</div>";
			echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>";
		if ($rigaq[prezzo] > 0) {
			echo number_format($rigaq[prezzo],2,",",".");
		} else {
		  switch ($_SESSION[lang]) {
			case "it":
			  echo "da calcolare";
			break;
			case "en":
			  echo "to be quoted";
			break;
		  }
		}
		echo "</div>";
			echo "<div class=scritte_bottoncini>".$package."</div>"; 
		  echo "<div class=bottoncini>";
			  switch ($_SESSION[lang]) {
				case "it":
				  echo $rigaq[confezione];
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$rigaq[confezione]);
				$conf = str_replace("blocchi da", "blocks of",$conf);
				$conf = str_replace("fogli da", "sheets of",$conf);
				$conf = str_replace("blister singoli", "one piece",$conf);
				$conf = str_replace("bustina singola", "one bag",$conf);
				$conf = str_replace("etichetta singola", "one label",$conf);
				$conf = str_replace("etichette", "labels",$conf);
				$conf = str_replace("fogli", "sheets",$conf);
				$conf = str_replace("bustine", "bags",$conf);
				  echo $conf;
				break;
			  }
		  echo "</div>";
			echo "</div>";
			echo "<div id=componente_iconcine>";
			echo "</div>";
			echo "</div>";
			
			echo "<div id=componente_immagine>";
			if ($rigaq[foto] != "") {
			  echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
			} else {
			  echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
			}
			echo "</div>";
	  }
			echo "</div>";
	  
		// fine if ($pres_pescante != "") {
		}
		
echo "</div>"; 
		  
?>


</div>
</body>
</html>
