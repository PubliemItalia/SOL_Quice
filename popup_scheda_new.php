<?php
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
if ($_GET[codice_art] != "") {
$id = $_GET[codice_art];
} else {
$id = $_POST[codice_art];
}
if ($_GET[negozio] != "") {
$negozio = $_GET[negozio];
} else {
$negozio = $_POST[negozio];
}
if ($_GET[lang] != "") {
$lingua = $_GET[lang];
} else {
$lingua = $_POST[lang];
}
$mode = $_GET[mode];
/*echo "negozio: ".$negozio."<br>";
echo "lingua: ".$lingua."<br>";
echo "codice_art: ".$id."<br>";
*/
//funzione x l'elenco della directory
function elencafiles($dirname){
$arrayfiles=Array();
if(file_exists($dirname)){
$handle = opendir($dirname);
while (false !== ($file = readdir($handle))) {
if(is_file($dirname.$file)){
array_push($arrayfiles,$file);
}
}
$handle = closedir($handle);
}
sort($arrayfiles);
return $arrayfiles;
}
//fine funzione

/*echo "array immagini: ";
print_r($_FILES);
echo "<br>";
echo "array POST: ";
print_r($_POST);
echo "<br>";
*///$lingua = $_SESSION[lang];
include "query.php";
include "traduzioni_interfaccia.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id_utente = $_SESSION[user_id];
$sqlh = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
$vecchio_cod_art = $rigah[codice_originale_duplicato];
}


$sqleee = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$id'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
	if ($rigaeee[categoria1_it] == "bombole") {
	  $mat_bomb = "Bombola in ".$rigaeee[materiale];
	  $categoria3_it = $rigaeee[categoria3_it]." - ".$mat_bomb;
	  $categoria3_en = $rigaeee[categoria3_en]." - ".$mat_bomb;
	  $descrizione2_it = stripslashes($rigaeee[descrizione2_it])." - <strong>".$rigaeee[prezzo];
	  $descrizione2_en = $rigaeee[descrizione2_en]." - <strong>".$rigaeee[prezzo];
	} else {
	  $categoria3_it = $rigaeee[categoria3_it];
	  $categoria3_en = $rigaeee[categoria3_en];
	  $descrizione2_it = stripslashes($rigaeee[descrizione2_it]);
	  $descrizione2_en = $rigaeee[descrizione2_en];
	}
	  $categoria1_it = $rigaeee[categoria1_it];
	  $categoria2_it = $rigaeee[categoria2_it];
	  $categoria4_it = $rigaeee[categoria4_it];
	  $categoria1_en = $rigaeee[categoria1_en];
	  $categoria2_en= $rigaeee[categoria2_en];
	  $categoria4_en = $rigaeee[categoria4_en];
	  $descrizione1_it = stripslashes($rigaeee[descrizione1_it]);
	  $descrizione3_it = stripslashes($rigaeee[descrizione3_it]);
	  $descrizione4_it = stripslashes($rigaeee[descrizione4_it]);
	  $descrizione1_en = $rigaeee[descrizione1_en];
	  $descrizione3_en = $rigaeee[descrizione3_en];
	  $descrizione4_en = $rigaeee[descrizione4_en];
	switch($lingua) {
case "fr":
$descrizione = $rigaeee[descrizione_fr];
break;
case "de":
$descrizione = $rigaeee[descrizione_de];
break;
case "es":
$descrizione = $rigaeee[descrizione_es];
break;
case "it":
$categoria1 = $categoria1_it;
$categoria2 = $categoria2_it;
$categoria3 = $categoria3_it;
$categoria4 = $categoria4_it;
$descrizione1 = stripslashes($descrizione1_it);
$descrizione2 = stripslashes($descrizione2_it);
$descrizione3 = stripslashes($descrizione3_it);
$descrizione4 = stripslashes($descrizione4_it);
break;
case "en":
$categoria1 = $categoria1_en;
$categoria2 = $categoria2_en;
$categoria3 = $categoria3_en;
$categoria4 = $categoria4_en;
$descrizione1 = $descrizione1_en;
$descrizione2 = $descrizione2_en;
$descrizione3 = $descrizione3_en;
$descrizione4 = $descrizione4_en;
break;
}
$paese = $rigaeee[paese];
$extra = $rigaeee[extra];
$variante_pharma = $rigaeee[variante_pharma];
$etich_x_foglio = $rigaeee[art_x_conf];
$id_valvola = $rigaeee[id_valvola];
$id_cappellotto = $rigaeee[id_cappellotto];
$id_pescante = $rigaeee[id_pescante];
$codice_art = $rigaeee[codice_art];
$gruppo_merci = $rigaeee[gruppo_merci];
$wbs = $rigaeee[wbs];
$prezzo = $rigaeee[prezzo];
$confezione = $rigaeee[confezione];
$foto = $rigaeee[foto];
$percorso_pdf = $rigaeee[percorso_pdf];
}

switch($lingua) {
case "it":
$titolo_scheda = "Scheda prodotto";
break;
case "en":
$titolo_scheda = "Product sheet";
break;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titolo_scheda; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/visual.css" />
<style type="text/css">
<!--
#main_container {
	width:960px;
	margin: auto;
	margin-top: 10px;
	height: 300px;
/*	background-color: #CCCCCC;
*/
}
.raggruppo {
	width:490px;
	height:220px;
	float:left;
	padding:10px 0px 0px 10px;
}
#editing_container {
	width:800px;
	margin: auto;
	background:#CCCCCC;
}
#lingua_scheda {
	width:950px;
	margin: auto;
	background-color: #727272;
	margin-bottom: 10px;
	color: #FFFFFF;
	height: 20px;
	text-align: right;
	padding-right: 5px;
	vertical-align: middle;
	font-weight: bold;
}
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.testo_chiudi {
	color: #FFFFFF;
	font-weight: bold;
}
.Stile5_gallery {
	color: #33CCFF;
	font-weight: bold;
}
.Stile2_hidden {
	color: #33CCFF;
	font-weight: bold;
	display: none;
}
.Stile4 {
	color: #009900;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
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
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;
}
</script>
</head>
<?php
if ($mode == "print") {
echo "<body onLoad=\"javascript:window.print()\">";
} else {
//echo "<body onLoad=\"refreshParent()\">";
echo "<body>";
}
?>
<div id="lingua_scheda">
  <table width="950" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="801" class="testo_chiudi"><img src="immagini/spacer.gif" width="810" height="15"></td>
        <td class="Stile1" width="119">
          <div align="right">
        <form name="form1" method="get" action="popup_scheda.php">
            <?php
			if ($mode == "print") {
			} else {
$azione_form = $_SERVER['PHP_SELF'];
			switch($lingua) {
case "it":
echo "<a href=".$azione_form."?mode=print&id=". $id."&negozio=".$negozio."&lang=".$lingua."><span class=Stile1>Stampa</span></a>";
break;
case "en":
echo "<a href=".$azione_form."?mode=print&id=". $id."&negozio=".$negozio."&lang=".$lingua."><span class=Stile1>Print</span></a>";
break;
}

	}
        ?>
        </form>
          </div>
        </td>
        <td width="30"><img src="immagini/spacer.gif" width="30" height="15"></td>
    </tr>
    </table>    
</div>
<div id="main_container">
<?php
switch ($lingua) {
  case "it":
  $code = "Codice";
  $grmerci = "Gr. Merci";
  $price = "Prezzo";
  $package = "Confezione";
  $pcs = "Pezzi";
  $gallery = "Galleria immagini";
  break;
  case "en":
  $code = "Code";
  $grmerci = "Goods gr.";
  $price = "Price";
  $package = "Package";
  $pcs = "Pcs";
  $gallery = "Image gallery";
  break;
}
//partenza delle operazioni di query
		echo "<div id=riquadro_prodotto>";
		//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
				echo "<div id=raggruppamento>";
		echo "<div class=Titolo_famiglia>";
			echo str_replace("_"," ",$categoria3);
		echo "</div>";
		echo "<div id=componente_descrizione>";
		echo "<div class=descr_famiglia>";
			echo stripslashes($descrizione2);
		echo "</div>";
		echo "<div id=variante class=variante_testuale>";
			echo stripslashes($categoria4);
		echo "<br>";
  //recupero informazioni valvola
if ($categoria1_it == "Bombole") {
  if ($id_valvola == "") {
	  $descr_valvola = "Senza valvola";
	} else {
	  $sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$id_valvola'";
	  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
		//echo "<br>query:".$sqlk."<br>";
		while ($rigam = mysql_fetch_array($risultm)) {
		  $prezzo_valvola = $rigam[prezzo];
		  echo "<div class=descr_famiglia>";
		  switch ($_SESSION[lang]) {
			case "it":
			  $descr_valvola = $id_valvola."<br>".$rigam[descrizione2_it];
			break;
			case "en":
			  if ($rigam[descrizione2_en] != "") {
				$descr_valvola = $rigam[descrizione2_en];
			  } else {
				$descr_valvola = $rigam[descrizione2_it];
			  }
			break;
		  }
		  echo stripslashes($descr_valvola);
		  $descr_valvola = "";
		  echo " - <strong>".$prezzo_valvola." &euro;</strong>";
		  echo "</div>";
		}
	}
}
				
				
  //recupero informazioni cappellotto
if ($categoria1_it == "Bombole") {
  if ($id_cappellotto == "") {
	  $descr_cappellotto = "Senza cappellotto";
  } else {
	$sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$id_cappellotto'";
	$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
	  //echo "<br>query:".$sqlk."<br>";
	  while ($rigan = mysql_fetch_array($risultn)) {
		$prezzo_cappellotto = $rigan[prezzo];
		echo "<div class=descr_famiglia>";
		  switch ($_SESSION[lang]) {
			case "it":
			  $descr_cappellotto = $rigan[descrizione2_it];
			break;
			case "en":
			  if ($rigan[descrizione2_en] != "") {
				$descr_cappellotto = $rigan[descrizione2_en];
			  } else {
				$descr_cappellotto = $rigan[descrizione2_it];
			  }
			break;
		  }
		echo stripslashes($descr_cappellotto);
		echo " - <strong>".$prezzo_cappellotto." &euro;</strong>";
		echo "</div>";
	  }
  }
}

  //recupero informazioni pescante
if ($categoria1_it == "Bombole") {
  if ($id_pescante != "SI") {
	  $descr_pescante = "Senza pescante";
	} else {
	$prezzo_pescante = "5.00";
	  $descr_pescante = "Con pescante - <strong>".$prezzo_pescante." &euro;</strong>";
	}
	echo "<div class=descr_famiglia>";
	echo $descr_pescante;
	echo "</div>";
  }
  if ($categoria1_it == "Bombole") {
	$prezzo_totale = $prezzo+$prezzo_valvola+$prezzo_cappellotto+$prezzo_pescante;
	$prezzo_pescante = "";
	$prezzo_valvola = "";
	$prezzo_cappellotto = "";
	switch ($_SESSION[lang]) {
	  case "it":
	  $dic_prezzi_bombole = "<br><br><strong>Costi orientativi.<br>Contattare i buyer per i prezzi aggiornati!</strong>";
	  break;
	  case "en":
	  $dic_prezzi_bombole = "<br><br><strong>Costs may not be real.<br>Please contact buyers for updated prices!</strong>";
	  break;
	}
  } else {
	$prezzo_totale = $prezzo;
  }
				
		echo "</div>";
		echo "</div>";
		//echo "<div id=risultato>";
		echo "<div id=componente_dati>";
		
		//echo "<span class=Titolo_bianco_xspazio>DATI</span><br>";
		echo "<div class=scritte_bottoncini>".$code."</div>"; 
		echo "<div class=bottoncini>".$codice_art."</div>";
		echo "<div class=scritte_bottoncini>".$grmerci."</div>"; 
		echo "<div class=bottoncini>".$gruppo_merci."</div>";
		echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>".number_format($prezzo_totale,2,",",".");
		echo $dic_prezzi_bombole;
		echo "</div>";
		echo "<div class=scritte_bottoncini>".$package."</div>"; 
		echo "<div class=bottoncini>".$confezione." ".$pcs."</div>";
		echo "</div>";
		
		echo "<div id=componente_iconcine>";
		//echo "<img border=0 onclick=\"compilazione(1624)\" src=immagini/S.png></img>";
		echo "</div>";
		echo "</div>";
		
		echo "<div id=componente_immagine>";
	if ($categoria1_it == "Bombole") {
	  //******************************************
	  //******************************************
	  // Read the image
	  //$fondo = new Imagick("componenti/fondo.png");
	  $corpo = new Imagick("componenti/bombole/".str_replace(" ","_",$descrizione3_it).".png");
	  $ogiva = new Imagick("componenti/ogiva/".str_replace(" ","_",$descrizione4_it).".png");
	  $valvola = new Imagick("componenti/valvola/".str_replace(" ","_",$id_valvola).".png");
	  if ($rigak[id_cappellotto] != "") {
	  $cappellotto = new Imagick("componenti/cappellotto/".str_replace(" ","_",$id_cappellotto).".png");
	  }
	  
	  // Clone the image and flip it 
	  $bombola = $corpo->clone();
	  
	  // Composite i pezzi successivi sopra il fondo in questo ordine 
	  //$bombola->compositeImage($corpo, imagick::COMPOSITE_OVER, 0, 0);
	  $bombola->compositeImage($ogiva, imagick::COMPOSITE_OVER, 0, 0);
	  $bombola->compositeImage($valvola, imagick::COMPOSITE_OVER, 0, 0);
	  if ($rigak[id_cappellotto] != "") {
	  $bombola->compositeImage($cappellotto, imagick::COMPOSITE_OVER, 0, 0);
	  }
	  $timecode= date("dmYHis",time());
	  $nomefile = "temp_bombole/".$timecode."_".$codice_art.".png";
	  $bombola->writeImage($nomefile);
	  
	  $corpo = "";
	  $ogiva = "";
	  $valvola = "";
	  $cappellotto = "";
	  //************************************
	  //*************************************
		  }
	  if ($foto != "") {
	if ($categoria1_it == "Bombole") {
		echo "<img src=".$nomefile." width=248 height=248>";
	  } else {
		echo "<img src=files/".$foto." width=248 height=248>";
	  }
	  } else {
		echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
	  }
		echo "</div>";

		//componente bottoni
		echo "<div id=componente_bottoni>";
		echo "<div class=comandi>";
		echo "cat: ".$categoria1_it."<br>";
		echo "</div>"; 
		echo "<div class=comandi>";
		$nome_gruppo = mt_rand(1000,9999);
		//operazioni di costruzione della gallery
		$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$id' ORDER BY precedenza ASC";
		$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$num_img = mysql_num_rows($risultz);
		if ($num_img > 0) {
		$a = 1;
		while ($rigaz = mysql_fetch_array($risultz)) {
		if ($a == 1) {
		   echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
		} else {
		  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]></a> ";
		}
		$a = $a + 1;
		}
		}
		//fine  costruzione gallery
		echo "</div>"; 
		echo "<div class=comandi>";
	if ($percorso_pdf != "") {
		echo "<a href=documenti/".$percorso_pdf." target=_blank>";
		echo "<span class=pulsante_scheda>";
						switch ($lingua) {
					case "it":
					echo "Scheda tecnica";
					break;
					case "en":
					echo "Technical sheet";
					break;
					}
echo "</span>";
echo "</a>";
	}
		echo "</div>"; 
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
/*
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$id' AND id_utente = '$_SESSION[user_id]'";

		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
			if ($preferiti_presenti > 0) {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$id."&negozio_prod=".$negozio."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
					switch ($lingua) {
					case "it":
					echo "Elimina dai preferiti";
					break;
					case "en":
					echo "Remove from favourites";
					break;
					}
					echo "</span>";
			} else {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$negozio."&id_prod=".$qid."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($lingua) {
					case "it":
					echo "Aggiungi ai preferiti";
					break;
					case "en":
					echo "Add to favourites";
					break;
					}
					echo "</span>";
			}
		echo "</div>"; 
		echo "</a>";
		echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$id."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		echo "<div class=comandi>";
		echo "<span class=pulsante_stampa>";
				switch ($lingua) {
					case "it":
					echo "Stampa";
					break;
					case "en":
					echo "Print";
					break;
					}
					echo "</span>";
		echo "</div>"; 
		echo "</a>";
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		echo "<div class=comandi>";
			if ($categoria1 == "Bombole") {
				$modulo = "popup_modifica_scheda_bombola.php";
			} else {
				$modulo = "popup_modifica_scheda.php";
			}
			if ($vis_admin == 1) {
				echo "<a href=".$modulo."?action=edit&id=".$id."&negozio=".$negozio."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
			}
		echo "</div>"; 
	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$negozio."&id_prod=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
				switch ($lingua) {
					case "it":
					echo "Inserisci nel carrello";
					break;
					case "en":
					echo "Add to cart";
					break;
					}
echo "</div></a>";
*/	
		//fine div componente_bottoni
		echo "</div>"; 
		echo "</div>"; 
		//********************************************************
		//fine if elementi famiglia senza icone, (tutti elementi diversi tra loro)
		//***********************************************************
	?>
</div>
</body>
</html>
