<?php
/*include "validation.php";
$accessi_abilitati = array("super_admin","amministrazione","operatore","agente");
if (in_array($_SESSION['reparto'],$accessi_abilitati)) {
} else {
$pag_precedente = "main.php";
include "redir_neutro.php";
exit;
}
*/
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$_SESSION[pagina] = basename($_SERVER['PHP_SELF']);
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
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
$_SESSION[file_ritorno] = $file_presente;


if ($_GET[id] != "") {
$id = $_GET[id];
} else {
$id = $_POST[id];
}
if ($_GET[negozio] != "") {
$negozio = $_GET[negozio];
} else {
$negozio = $_POST[negozio];
}
$mode = $_GET[mode];
$descrizione1_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione1_it]));
$descrizione2_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione2_it]));
$descrizione3_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione3_it]));
$descrizione4_it_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione4_it]));
$descrizione1_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione1_en]));
$descrizione2_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione2_en]));
$descrizione3_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione3_en]));
$descrizione4_en_mod = addslashes(str_replace("\n","<br>",$_POST[descrizione4_en]));
$immagine1_mod = $_POST[immagine1];
$immagine2_mod = $_POST[immagine2];
$immagine3_mod = $_POST[immagine3];
$immagine4_mod = $_POST[immagine4];
$immagine5_mod = $_POST[immagine5];
$modifica_prodotto = $_POST[modifica_prodotto];
$consenso = $_POST[consenso];
$confezione_mod = $_POST[confezione];
$codice = $_POST[codice];
$prezzo_mod = str_replace(",",".",$_POST[prezzo]);
$gruppo_merci_mod = $_POST[gruppo_merci];
$wbs_mod = $_POST[wbs];
$immagine1_mod = $_POST[immagine1];
$img_gallery1_rem = $_POST[img_gallery1_rem];
$img_gallery2_rem = $_POST[img_gallery2_rem];
$img_gallery3_rem = $_POST[img_gallery3_rem];
$img_gallery4_rem = $_POST[img_gallery4_rem];
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
if ($_GET['categoria1'] != "") {
$categoria1 = $_GET['categoria1'];
} 

if ($_GET['categoria2'] != "") {
$categoria2 = $_GET['categoria2'];
} 

if ($_GET['categoria3'] != "") {
$categoria3 = $_GET['categoria3'];
} 

if ($_GET['categoria4'] != "") {
$categoria4 = $_GET['categoria4'];
} 

if ($_GET['codice_art'] != "") {
$codice_ricerca = $_GET['codice_art'];
} 

if ($_GET['anchor'] != "") {
$anchor_processo = $_GET['anchor'];
} 
$nofunz = $_GET['nofunz'];

$_SESSION[categoria1] = $_GET['categoria1'];
$_SESSION[categoria2] = $_GET['categoria2'];
$_SESSION[categoria3] = $_GET['categoria3'];
$_SESSION[categoria4] = $_GET['categoria4'];
$ordinamento = "codice_art DESC";
/*if ($_GET['ordinamento'] == "") {
$ordinamento = "codice_art";
$asc_desc = "ASC";
} else {
$ordinamento = $_GET['ordinamento'];
if ($_GET['asc_desc'] == "") {
$asc_desc = "ASC";
} else {
$asc_desc = "DESC";
//$asc_desc = $_GET['asc_desc'];
}
}
*/
$_SESSION[ordinamento] = $ordinamento;
$_SESSION[asc_desc] = $asc_desc;

include "functions.php";
if ($_GET['schedaVis'] == "") {
include "menu_quice3.php";
}
if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}

		$sqlc = "SELECT * FROM qui_utenti WHERE user_id = '$_SESSION[user_id]'";
		$risultc = mysql_query($sqlc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigac = mysql_fetch_array($risultc)) {
		   $flag_etichette_pharma = $rigac[flag_etichette_pharma];
		}


$_SESSION[percorso_modifica] = $_SESSION[file_ritorno]."?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&paese=".$paese."&negozio=".$negozio."&lang=".$_SESSION[lang];


///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query


$codiceDaModulo = $_GET['codice'];
$_SESSION[codice] = $_GET['codice'];
if (isset($_POST['codice'])) {
$codiceDaModulo = $_POST['codice'];
$_SESSION[codice] = $_POST['codice'];
}
if ($codiceDaModulo == "") {
$codiceDaModulo = $_SESSION[codice];
}
if ($codiceDaModulo != "") {
$a = "codice_art LIKE '%$codiceDaModulo%'";
$clausole++;
}

if (isset($_GET['nazione_ric'])) {
$nazioneDaModulo = $_GET['nazione_ric'];
$_SESSION[nazione_ric] = $_GET['nazione_ric'];
} 
if (isset($_POST['nazione_ric'])) {
$nazioneDaModulo = $_POST['nazione_ric'];
$_SESSION[nazione_ric] = $_POST['nazione_ric'];
}
//$_SESSION[cliente] = $clienteDaModulo;
if ($nazioneDaModulo == "") {
$nazioneDaModulo = $_SESSION[nazione_ric];
}
if ($nazioneDaModulo != "") {
$b = "nazione LIKE '%$nazioneDaModulo%'";
$clausole++;
}
switch($lingua) {
case "it":
$categoria1_lang = "categoria1_it";
$categoria2_lang = "categoria2_it";
$categoria3_lang = "categoria3_it";
$categoria4_lang = "categoria4_it";
break;
case "en":
$categoria1_lang = "categoria1_en";
$categoria2_lang = "categoria2_en";
$categoria3_lang = "categoria3_en";
$categoria4_lang = "categoria4_en";
break;
}

if ($categoria2 != "") {
if (($categoria1 == "Valvole")) {
$c = "descrizione4_it LIKE '%$categoria2%'";
	} else {
$c = "categoria2_it = '$categoria2'";
	}
$clausole++;
}

if (isset($_GET['negozio'])) {
$negozio = $_GET['negozio'];
$_SESSION[negozio] = $_GET['negozio'];
} 
if (isset($_POST['negozio'])) {
$negozio = $_POST['negozio'];
$_SESSION[negozio] = $_POST['negozio'];
}
if ($negozio == "") {
$negozio = $_SESSION[negozio];
}
if ($negozio != "") {
$d = "negozio = '$negozio'";
$clausole++;
}

if ($categoria1 != "") {
$e = "categoria1_it = '$categoria1'";
$clausole++;
}
if ($categoria3 != "") {
$f = "categoria3_it = '$categoria3'";
$clausole++;
}
if ($categoria4 != "") {
$g = "categoria4_it = '$categoria4'";
$clausole++;
}
if ($paese != "") {
$h = "(paese = '$paese' OR prodotto_multilingue LIKE '%$paese%')";
$clausole++;
}
if ($codice_ricerca != "") {
$l = "codice_art = '$codice_ricerca'";
$clausole++;
}
if ($_GET['mode'] != "") {
$mode = $_GET['mode'];
$id_back = $_GET['id'];
} else {
$sqlq = "SELECT * FROM qui_prodotti_".$negozio." WHERE categoria3_it = '$categoria3'";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_prodotti_trovati = mysql_num_rows($risultq);
if ($num_prodotti_trovati == 1) {
$mode = "back";
while ($rigaq = mysql_fetch_array($risultq)) {
$id_back = $rigaq[id];
}
}
}
//echo "id_back: ".$id_back."<br>";
//costruzione query, query diversa a seconda del negozio prescelto
switch ($negozio) {
case "assets":
$testoQuery = "SELECT * FROM qui_prodotti_assets ";
break;
case "consumabili":
$testoQuery = "SELECT * FROM qui_prodotti_consumabili ";
break;
case "spare_parts":
$testoQuery = "SELECT * FROM qui_prodotti_spare_parts ";
break;
case "labels":
$testoQuery = "SELECT * FROM qui_prodotti_labels ";
break;
case "vivistore":
$testoQuery = "SELECT * FROM qui_prodotti_vivistore ";
break;
}
if ($clausole > 0) {
$testoQuery .= "WHERE obsoleto = '0' AND ";
if ($clausole == 1) {
if ($a != "") {
$testoQuery .= $a;
}
if ($b != "") {
$testoQuery .= $b;
}
if ($c != "") {
$testoQuery .= $c;
}
if ($d != "") {
$testoQuery .= $d;
}
if ($e != "") {
$testoQuery .= $e;
}
if ($f != "") {
$testoQuery .= $f;
}
if ($g != "") {
$testoQuery .= $g;
}
if ($h != "") {
$testoQuery .= $h;
}
if ($l != "") {
$testoQuery .= $l;
}
} else {
if ($a != "") {
$testoQuery .= $a." AND ";
}
if ($b != "") {
$testoQuery .= $b." AND ";
}
if ($c != "") {
$testoQuery .= $c." AND ";
}
if ($d != "") {
$testoQuery .= $d." AND ";
}
if ($e != "") {
$testoQuery .= $e." AND ";
}
if ($f != "") {
$testoQuery .= $f." AND ";
}
if ($g != "") {
$testoQuery .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h." AND ";
}
if ($l != "") {
$testoQuery .= $l;
}
}

}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}

if ($negozio == "labels") {
$testoQuery .= " ORDER BY precedenza_int ASC";
} else {
$testoQuery .= " ORDER BY ".$ordinamento." ".$asc_desc;
}

/*
echo "<br>SESSION[categoria1]: ".$_SESSION[categoria1]."<br>";
echo "SESSION[categoria2]: ".$_SESSION[categoria2]."<br>";
echo "SESSION[categoria3]: ".$_SESSION[categoria3]."<br>";
echo "SESSION[categoria4]: ".$_SESSION[categoria4]."<br>";
echo "SESSION[negozio]: ".$_SESSION[negozio]."<br>";
echo "SESSION[pagina]: ".$_SESSION[pagina]."<br>";
echo "mode: ".$mode."<br>";
echo "testoQuery: ".$testoQuery."<br>";
*/
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
$_SESSION[percorso_indietro] = $_SESSION[file_ritorno]."?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&paese=".$paese."&negozio=".$negozio."&lang=".$lingua;
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
-->
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox3.js"></script>
<SCRIPT type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</SCRIPT>

</head>
<?php
if ($id != "") {

echo "<body onload=\"compilazione(".$_GET[id].")\">";
} else {
echo "<body>";
}

?>

<div id="main_container">
<?php
switch ($_SESSION[lang]) {
  case "it":
  $code = "Codice";
  $grmerci = "Gr. Merci";
  $price = "Prezzo";
  $package = "Confezione";
  $pcs = "";
  $gallery = "Galleria immagini";
  break;
  case "en":
  $code = "Code";
  $grmerci = "Goods gr.";
  $price = "Price";
  $package = "Package";
  $pcs = "";
  $gallery = "Image gallery";
  break;
}
//div con pulsante BACK che compare solo quando si arriva a questa pagina da una ricerca di visualizzazione
//ovvero da RICERCA, CARRELLO, PROCESSO BUYER
/*
if (($_GET['codice_art'] != "") AND ($_GET['schedaVis'] == "")) {
  echo "<div style=\"width: 958px; height: 25px; float: left;\">";
  $pos_report = stripos($_SESSION[percorso_ritorno],"unita");
  //echo "pos_report: ".$pos_report."<br>";
  //echo "ritorno: ".$_SESSION[percorso_ritorno]."<br>";
  
  if ($pos_report > 0) {
	  $percorso_back = $_SESSION[percorso_ritorno]."#".$anchor_processo;
  } else {
	  $percorso_back = $_SESSION[percorso_ritorno];
  }
	echo "<a href=\"".$percorso_back."\">";
	  echo "<div style=\"width: auto; height: 20px; float:right; font-size:14px; font-weight:bold; text-align:right; text-decoration:none; color:rgb(0,0,0);\">";
	  echo "BACK";
	  echo "</div>";
	echo "</a>";
  echo "</div>";
}
*/
//partenza delle operazioni di query
if ($nofunz == "") {
$risultq = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
//distinzione principale: se etichette_pharma o no
	$riga = $riga + 1;
	if ($negozio == "labels") {
	  //********************************************************
	  // if elementi famiglia con icone,
	  //  si visualizza solo il capo famiglia (rif_famiglia = id) 
	  // e tutti gli elementi collegati con l'id vanno a formare la tendina
	  //***********************************************************
		if ($rigaq[rif_famiglia] != "") {
		  if ($rigaq[rif_famiglia] == $rigaq[id]) {
			$blocco_varianti_pharma .= "<select name=litraggio id=litraggio onChange=\"compilazione_pharma(this.value,".$riga.")\">";
			$blocco_varianti_pharma .= "<option selected value=".$rigaq[rif_famiglia].">".$rigaq[categoria4_it]."</option>";
			$sqlm = "SELECT * FROM qui_prodotti_".$negozio." WHERE rif_famiglia = '$rigaq[id]' AND id != '$rigaq[rif_famiglia]' ORDER BY id ASC";
			$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			while ($rigam = mysql_fetch_array($risultm)) {
				$blocco_varianti_pharma .= "<option value=".$rigam[id].">".$rigam[categoria4_it]."</option>";
			}
			$blocco_varianti_pharma .= "</select>";
			//inizio div riquadro_prodotto
			echo "AAA";
			if ($rigaq[ordine_stampa] == 1) {
			echo "<div id=riquadro_prodotto_abbass>";
			} else {
			echo "<div id=riquadro_prodotto>";
			}
			//raggruppamento contenente titolo, descrizione e dati
			echo "<div id=raggruppamento_".$riga." class=raggruppo>";
			echo "<div class=Titolo_famiglia style=\"float:left;\">";
			  switch ($_SESSION[lang]) {
			  case "it":
			  echo str_replace("_"," ",substr($rigaq[categoria3_it],4));
			  break;
			  case "en":
				if ($rigaq[categoria3_en] == "") {
				echo str_replace("_"," ",substr($rigaq[categoria3_it],4));
				} else {
				echo str_replace("_"," ",$rigaq[categoria3_en]);
				}
			  break;
			  }					
			  echo "</div>";
			  echo "<div id=componente_descrizione>";
			  echo "<div id=descrpharma_".$riga." class=descr_famiglia>";
				switch ($_SESSION[lang]) {
				case "it":
				echo stripslashes($rigaq[descrizione2_it]);
				break;
				case "en":
				echo stripslashes($rigaq[descrizione2_en]);
				break;
				}					
			  echo "</div>";
			  echo "</div>";
			
			  echo "<div id=dati_".$riga." class=blocco_dati>";
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
			  if ($rigaq[ordine_stampa] == 1) {
				$oggetto = "Ordine_etichette_Adr_codice_".$rigaq[codice_art];
				echo "<a href=mailto:adv@publiem.it?bcc=mara.girardi@publiem.it&Subject=".$oggetto."><div style=\"margin-top:50px;width:120px; height:auto; padding:10px; background-color:red; color:white; float:left; text-align:center;font-size:14px;font-weight:bold; text-decoration:none;\">";
		  switch ($_SESSION[lang]) {
			case "it":
				echo "Etichetta in fase di approvazione;<br>per richiedere informazioni<br>CLICCA QUI";
			break;
			case "en":
				echo "Label on approval.<br>To request information<br>CLICK HERE";
			break;
		  }
				echo "</div></a>";
			  }
			  echo "</div>";
			  echo "<div id=variante_".$riga." class=Titolo_famiglia>";
			  echo $rigaq[categoria4_it];
			  echo "</div>";
			  echo "<div class=componente_iconcine>";
			  echo $blocco_varianti_pharma;
			  $blocco_varianti_pharma = "";	
			  echo "</div>";
			  //fine raggruppamento
			  echo "</div>";
			  echo "<div id=componente_immagine>";
			  if ($rigaq[foto] != "") {
				echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
			  } else {
				echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
			  }
			  echo "</div>";
		  
			  //componente bottoni
			  echo "<div id=componente_bottoni_".$riga." class=componente_bottoni_ph>";
			  echo "<div class=comandi_primo>";
				switch ($rigaq[azienda]) {
				  case "SOL":
					echo '<img src="immagini/bottone-sol.png">';
				  break;
				  case "VIVISOL":
					echo '<img src="immagini/bottone-vivisol.png">';
				  break;
				}
			  echo "</div>"; 
			  echo "<div class=comandi>";
			  $nome_gruppo = mt_rand(1000,9999);
			  //operazioni di costruzione della gallery
			if ($rigaq[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' AND precedenza = '3'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' ORDER BY precedenza ASC";
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
			}
			  //fine  costruzione gallery
			  echo "</div>"; 
			  echo "<div class=comandi>";
			  if ($rigaq[percorso_pdf] != "") {
				echo "<a href=documenti/".$rigaq[percorso_pdf]." target=_blank>";
				echo "<span class=pulsante_scheda>";
				switch ($_SESSION[lang]) {
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
			  //disabilitazione funzionale se visualizzazione da carrello o da processo
			if ($nofunz != "") {
			} else {
			  echo "<div class=comandi_spazio>";
			  echo "</div>"; 
			  $sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
			  $risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $preferiti_presenti = mysql_num_rows($risulteee);
			  if ($preferiti_presenti > 0) {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigaq[id]."&negozio_prod=".$rigaq[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
				  case "it":
				  echo "Elimina dai preferiti";
				  break;
				  case "en":
				  echo "Remove from favourites";
				  break;
				}
				echo "</span>";
			  } else {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
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
			  echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigaq[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
			  echo "<div class=comandi>";
			  echo "<span class=pulsante_stampa>";
			  switch ($_SESSION[lang]) {
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
			  $modulo = "popup_modifica_scheda.php";
			  if ($vis_admin == 1) {
				echo "<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
			  }
			  echo "</div>"; 
	
			  echo "<div class=spazio_puls_carrello>";
			  echo "</div>"; 
			  if ($rigaq[extra] != "") {
				switch ($_SESSION[lang]) {
				  case "it":
				  $scritta_puls = "Scegli quantit&agrave;";
				  break;
				  case "en":
				  $scritta_puls = "Choose quantity";
				  break;
				}
				if ($rigaq[ordine_stampa] == 1) {
				  echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
				} else {
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
				  echo $scritta_puls;
				}
				echo "</div></a>";
			  } else {
				if ($rigaq[ordine_stampa] == 1) {
				  echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
				} else {
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
				  switch ($_SESSION[lang]) {
					case "it":
					echo "Inserisci nel carrello";
					break;
					case "en":
					echo "Add to cart";
					break;
				  }
				  echo "</div></a>";
				}
			  }
			  //fine disabilitazione funzionale se visualizzazione da carrello o da processo
			}
			//fine div componente_bottoni
			echo "</div>"; 
			//fine div riquadro_prodotto
			echo "</div>";
		  }
		} else {
		//alternativa if ($rigaq[rif_famiglia] != "")
		  echo "BBB";
			if ($rigaq[ordine_stampa] == 1) {
			echo "<div id=riquadro_prodotto_abbass>";
			} else {
			echo "<div id=riquadro_prodotto>";
			}
		  echo "<div id=raggruppamento_".$riga." class=raggruppo>";
		  echo "<div id=componente_descrizione>";
		  echo "<div class=Titolo_famiglia>";
		  switch ($_SESSION[lang]) {
			case "it":
			echo str_replace("_"," ",substr($rigaq[categoria3_it],4));
			break;
			case "en":
			  if ($rigaq[categoria3_en] == "") {
				echo str_replace("_"," ",substr($rigaq[categoria3_it],4));
			  } else {
				echo str_replace("_"," ",substr($rigaq[categoria3_en],4));
			  }
			break;
		  }					
		  echo "</div>";
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
		  echo "<div id=variante class=Titolo_famiglia>";
		  if  ($rigaq[categoria4_en] == "") {
			echo stripslashes(str_replace("_"," ",$rigaq[categoria4_it]));
		  } else {
			switch ($_SESSION[lang]) {
			  case "it":
			  echo stripslashes(str_replace("_"," ",$rigaq[categoria4_it]));
			  break;
			  case "en":
			  echo stripslashes(str_replace("_"," ",$rigaq[categoria4_en]));
			  break;
			}					
		  }
		  echo "</div>";
		  echo "</div>";
		  echo "<div id=componente_dati>";
		  echo "<div class=Titolo_famiglia></div>"; 
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
		  if ($rigaq[ordine_stampa] == 1) {
			$oggetto = "Ordine_etichette_Adr_codice_".$rigaq[codice_art];
			echo "<a href=mailto:adv@publiem.it?bcc=mara.girardi@publiem.it&Subject=".$oggetto."><div style=\"margin-top:50px;width:120px; height:auto; padding:10px; background-color:red; color:white; float:left; text-align:center;font-size:14px;font-weight:bold; text-decoration:none;\">";
		  switch ($_SESSION[lang]) {
			case "it":
				echo "Etichetta in fase di approvazione;<br>per richiedere informazioni<br>CLICCA QUI";
			break;
			case "en":
				echo "Label on approval.<br>To request information<br>CLICK HERE";
			break;
		  }
			echo "</div></a>";
		  }
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
		  //componente bottoni
		  echo "<div id=componente_bottoni>";
		  echo "<div class=comandi_primo>";
				switch ($rigaq[azienda]) {
				  case "SOL":
					echo '<img src="immagini/bottone-sol.png">';
				  break;
				  case "VIVISOL":
					echo '<img src="immagini/bottone-vivisol.png">';
				  break;
				}
		  echo "</div>"; 
		  echo "<div class=comandi>";
		  $nome_gruppo = mt_rand(1000,9999);
		  //operazioni di costruzione della gallery
			if ($rigaq[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' AND precedenza = '2'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
		  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' ORDER BY precedenza ASC";
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
			}
		  //fine  costruzione gallery
		  echo "</div>";
		  if ($rigaq[percorso_pdf] != "") {
			echo "<a href=documenti/".$rigaq[percorso_pdf]." target=_blank>";
			echo "<div class=comandi>";
			echo "<span class=pulsante_scheda>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo "Scheda tecnica";
			  break;
			  case "en":
			  echo "Technical sheet";
			  break;
			}
			echo "</span>";
			echo "</div></a>"; 
		  }
		  if ($nofunz != "") {
		  } else {
			echo "<div class=comandi_spazio>";
			echo "</div>"; 
			$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
			$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			$preferiti_presenti = mysql_num_rows($risulteee);
			if ($preferiti_presenti > 0) {
			  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigaq[id]."&negozio_prod=".$rigaq[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
			  echo "<div class=comandi>";
			  echo "<span class=pulsante_preferiti>";
			  switch ($_SESSION[lang]) {
				case "it":
				echo "Elimina dai preferiti";
				break;
				case "en":
				echo "Remove from favourites";
				break;
			  }
			  echo "</span>";
			} else {
			  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
			  echo "<div class=comandi>";
			  echo "<span class=pulsante_preferiti>";
			  switch ($_SESSION[lang]) {
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
		echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigaq[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		echo "<div class=comandi>";
		echo "<span class=pulsante_stampa>";
		switch ($_SESSION[lang]) {
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
		$modulo = "popup_modifica_scheda.php";
		if ($vis_admin == 1) {
		//echo "<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
		}
		echo "</div>"; 	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 
//		if ($rigaq[extra] != "") {
		  switch ($_SESSION[lang]) {
			case "it":
			$scritta_puls = "Scegli quantit&agrave;";
			break;
			case "en":
			$scritta_puls = "Choose quantity";
			break;
		  }
		  if ($rigaq[ordine_stampa] == 1) {
			echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
		  } else {
		  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
		  }
		  echo $scritta_puls;
		  echo "</div></a>";
		  //}
		}
		//fine div componente_bottoni
		echo "</div>"; 
		//fine div riquadro_prodotto
		echo "</div>"; 
					
	  //********************************************************
	  //fine if rif famiglia == id
	  //***********************************************************
//********************************************************
//inizio etichetta simboli allegata
//***********************************************************
if (($negozio == "labels") AND ($rigaq[rif_simboli] != "")) {
	$pos_fam = stripos($rigaq[rif_simboli],"#");
	if ($pos_fam > 0) {
	  $array_famiglia = explode("#",$rigaq[rif_simboli]);
	} else {
	  $array_famiglia = array($rigaq[rif_simboli]);
	}
	//echo "array_famiglia: ";
	//print_r($array_famiglia);
	//echo "<br>: ";
	foreach ($array_famiglia as $sing_comp_fam) {
		$sqlk = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$sing_comp_fam' ORDER BY id ASC";
		$risultk = mysql_query($sqlk) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigak = mysql_fetch_array($risultk)) {
			echo "CCC";
			if ($rigaq[ordine_stampa] == 1) {
			echo "<div id=riquadro_prodotto_abbass>";
			} else {
			echo "<div id=riquadro_prodotto>";
			}
		//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
		echo "<div id=raggruppamento>";
		echo "<div class=Titolo_famiglia>";
		switch ($_SESSION[lang]) {
			case "it":
		echo str_replace("_"," ",$rigak[categoria2_it]);
		break;
			case "en":
		echo str_replace("_"," ",$rigak[categoria2_en]);
		break;
		}
		echo "</div>";
		echo "<div id=componente_descrizione>";
		echo "<div class=descr_famiglia>";
		switch ($_SESSION[lang]) {
			case "it":
		echo stripslashes($rigak[descrizione2_it]);
		break;
			case "en":
		echo stripslashes($rigak[descrizione2_en]);
		break;
		}
		echo "</div>";
		  echo "<div id=variante class=Titolo_famiglia>";
		  switch ($_SESSION[lang]) {
			case "it":
			echo stripslashes(str_replace("_"," ",$rigak[categoria4_it]));
			break;
			case "en":
			echo stripslashes(str_replace("_"," ",$rigak[categoria4_en]));
			break;
		  }					
		  echo "</div>";
		switch ($_SESSION[lang]) {
		case "it":
		  echo "<br>".$rigak[descrizione3_it];
		break;
		case "en":
		  echo "<br>".$rigak[descrizione3_en];
		break;
		}
		echo "</div>";
		//echo "</div>";
		
		echo "<div id=componente_dati>";
		
		
		echo "<div class=scritte_bottoncini>".$code."</div>"; 
			  echo "<div class=bottoncini>";
			  if (substr($rigak[codice_art],0,1) != "*") {
				echo $rigak[codice_art];
			  } else {
				echo substr($rigak[codice_art],1);
			  }
			  echo "</div>";
		echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>";
		if ($rigak[prezzo] > 0) {
			echo number_format($rigak[prezzo],2,",",".");
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
				  echo $rigak[confezione];
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$rigak[confezione]);
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
		  if ($rigak[ordine_stampa] == 1) {
			$oggetto = "Ordine_etichette_Adr_codice_".$rigak[codice_art];
			echo "<a href=mailto:adv@publiem.it?bcc=mara.girardi@publiem.it&Subject=".$oggetto."><div style=\"margin-top:50px;width:120px; height:auto; padding:10px; background-color:red; color:white; float:left; text-align:center;font-size:14px;font-weight:bold; text-decoration:none;\">";
		  switch ($_SESSION[lang]) {
			case "it":
				echo "Etichetta in fase di approvazione;<br>per richiedere informazioni<br>CLICCA QUI";
			break;
			case "en":
				echo "Label on approval.<br>To request information<br>CLICK HERE";
			break;
		  }
			echo "</div></a>";
		  }
		echo "</div>";
		
		echo "</div>";
		
		echo "<div id=componente_immagine>";
					if ($rigak[foto] != "") {
		echo "<img src=files/".$rigak[foto]." width=248 height=248>";
					} else {
					echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
					}
		echo "</div>";
		//componente bottoni
		echo "<div id=componente_bottoni>";
		echo "<div class=comandi_primo>";
				switch ($rigaq[azienda]) {
				  case "SOL":
					echo '<img src="immagini/bottone-sol.png">';
				  break;
				  case "VIVISOL":
					echo '<img src="immagini/bottone-vivisol.png">';
				  break;
				}
		echo "</div>"; 
		echo "<div class=comandi>";
		//operazioni di costruzione della gallery
			if ($rigaq[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' AND precedenza = '3'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
		$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigak[codice_art]' ORDER BY precedenza ASC";
		$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$num_img = mysql_num_rows($risultz);
		if ($num_img > 0) {
		$a = 1;
		while ($rigaz = mysql_fetch_array($risultz)) {
		if ($a == 1) {
		   echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$x."]><span class=pulsante_galleria>".$gallery."</span></a> ";
		} else {
		  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$x."]></a> ";
		}
		$a = $a + 1;
		}
		}
			}
		//fine  costruzione gallery
		echo "</div>"; 
		echo "<div class=comandi>";
		if ($rigak[percorso_pdf]) {
		echo "<a href=documenti/".$rigak[percorso_pdf]." target=_blank><span class=pulsante_scheda style=\"text-decoration:none;\">";
		switch ($_SESSION[lang]) {
		  case "it":
		  echo "Scheda tecnica";
		  break;
		  case "en":
		  echo "Technical sheet";
		  break;
		}
		echo "</span></a>";
		}
		echo "</div>"; 
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigak[id]' AND id_utente = '$_SESSION[user_id]'";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
		  if ($preferiti_presenti > 0) {
			echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigak[id]."&negozio_prod=".$rigak[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$x.")}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
					case "it":
					echo "Elimina dai preferiti";
					break;
					case "en":
					echo "Remove from favourites";
					break;
					}

				echo "</span>";
			} else {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS(".$x.")}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
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
		echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$rigak[negozio]."&id=".$rigak[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		echo "<div class=comandi>";
		echo "<span class=pulsante_stampa>";
				switch ($_SESSION[lang]) {
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
		$modulo = "popup_modifica_scheda.php";
		if ($vis_admin == 1) {
		echo "<a href=".$modulo."?action=edit&id=".$rigak[id]."&negozio=".$rigak[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
		}
		echo "</div>"; 

	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 


	//if ($rigaq[extra] != "") {
	//if ($flag_etichette_pharma == "1") {
	switch ($_SESSION[lang]) {
	case "it":
	$scritta_puls = "Scegli quantit&agrave;";
	break;
	case "en":
	$scritta_puls = "Choose quantity";
	break;
	}
//if ($rigak[ordine_stampa] == 1) {
	//echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
	//} else {
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
	echo $scritta_puls;
	//}
	echo "</div></a>";
	//}
	//} else {
/*if ($rigak[ordine_stampa] == 1) {
	echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
	} else {
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
	switch ($_SESSION[lang]) {
	case "it":
	echo "Inserisci nel carrello";
	break;
	case "en":
	echo "Add to cart";
	break;
	}
	echo "</div></a>";
	}
}
*/



		//fine div componente_bottoni
		echo "</div>"; 
		//********************************************************
		//fine etichette allegate
		//***********************************************************
		echo "</div>"; 
		//fine while 
		}
		//fine foreach famiglia
	}
	//fine if (($negozio == "labels") AND ($rigaq[rif_famiglia] != "")) 
}
	  }
	  //********************
	  //********************
	  //riquadro per il blister neutro nel caso la categoria 3 sia "foglietti_illustrativi"
	  //il campo "simbolo_blister" del DB deve essere vuoto per poter visuaiizzare il blister neutro
	  //ATTENZIONE!!! Ogni blister visualizza un blister vuoto; per evitare questa cosa bisogna mettere 
	  // un "no" o un carattere qualsiasi nel campo "simbolo_blister"
	  //********************
	  //********************
/*	  
	  if (($categoria3 == "120_Fogli_illustrativi") AND ($rigaq[simbolo_blister] == "")) {
		//inizio div riquadro_prodotto
		echo "CCC";
			if ($rigaq[ordine_stampa] == 1) {
			echo "<div id=riquadro_prodotto_abbass>";
			} else {
			echo "<div id=riquadro_prodotto>";
			}
		$sqld = "SELECT * FROM qui_prodotti_labels WHERE cf='PL_blister' AND categoria3_it = '120_Fogli_illustrativi' ORDER BY id ASC LIMIT 1";
		$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		while ($rigad = mysql_fetch_array($risultd)) {
		  //raggruppamento contenente titolo, descrizione e dati
		  echo "<div id=raggruppamento_".$riga." class=raggruppo>";
		  echo "<div class=Titolo_famiglia style=\"float:left;\">";
		  switch ($_SESSION[lang]) {
			case "it":
			  if ($negozio == "labels") {
				echo str_replace("_"," ",substr($rigad[categoria3_it],4));
			  } else {
				echo str_replace("_"," ",$rigad[categoria3_it]);
			  }
			break;
			case "en":
			  if ($rigaq[categoria3_en] == "") {
				if ($negozio == "labels") {
				  echo str_replace("_"," ",substr($rigad[categoria3_it],4));
				} else {
				  echo str_replace("_"," ",$rigad[categoria3_it]);
				}
			  } else {
				echo str_replace("_"," ",$rigad[categoria3_en]);
			  }
			break;
		  }					
		  echo "</div>";
		  echo "<div id=componente_descrizione>";
		  echo "<div class=descr_famiglia>";
		  switch ($_SESSION[lang]) {
			case "it":
			echo stripslashes($rigad[descrizione2_it]);
			break;
			case "en":
			echo stripslashes($rigad[descrizione2_en]);
			break;
		  }					
		  echo "</div>";
		  echo "</div>";
		  echo "<div id=dati_".$riga." class=blocco_dati>";
		  echo "<div class=scritte_bottoncini>".$code."</div>"; 
		  echo "<div class=bottoncini>".$rigad[codice_art]."</div>";
		  echo "<div class=scritte_bottoncini>".$grmerci."</div>"; 
		  echo "<div class=bottoncini>".$rigad[gruppo_merci]."</div>";
		  echo "<div class=scritte_bottoncini>".$package."</div>"; 
		  echo "<div class=bottoncini>".$rigad[confezione]."</div>";
		  echo "</div>";
		  echo "<div id=variante_".$riga." class=Titolo_famiglia>";
		  echo $rigad[categoria4_it];
		  echo "</div>";
		  echo "<div class=componente_iconcine>";
		  echo "</div>";
		  //fine raggruppamento
		  echo "</div>";
		  echo "<div id=componente_immagine>";
		  if ($rigad[foto] != "") {
			echo "<img src=files/".$rigad[foto]." width=248 height=248>";
		  } else {
			echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
		  }
		  echo "</div>";

		  //componente bottoni
		  echo "<div id=componente_bottoni_".$riga." class=componente_bottoni_ph>";
		  echo "<div class=comandi>";
		  echo "</div>"; 
		  echo "<div class=comandi>";
		  $nome_gruppo = mt_rand(1000,9999);
		  echo "</div>"; 
		  echo "<div class=comandi>";
		  if ($rigaq[percorso_pdf] != "") {
			echo "<a href=documenti/".$rigaq[percorso_pdf]." target=_blank>";
			echo "<span class=pulsante_scheda>";
			switch ($_SESSION[lang]) {
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
		  if ($nofunz != "") {
		  } else {
			$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigad[id]' AND id_utente = '$_SESSION[user_id]'";
			$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			$preferiti_presenti = mysql_num_rows($risulteee);
			  if ($preferiti_presenti > 0) {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigad[id]."&negozio_prod=".$rigad[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
				  case "it":
				  echo "Elimina dai preferiti";
				  break;
				  case "en":
				  echo "Remove from favourites";
				  break;
				}
				echo "</span>";
			  } else {
			  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigad[negozio]."&id_prod=".$rigad[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
			  echo "<div class=comandi>";
			  echo "<span class=pulsante_preferiti>";
			  switch ($_SESSION[lang]) {
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
			echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigad[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
			echo "<div class=comandi>";
			echo "<span class=pulsante_stampa>";
			switch ($_SESSION[lang]) {
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
			$modulo = "popup_modifica_scheda.php";
			if ($vis_admin == 1) {
			  echo "<a href=".$modulo."?action=edit&id=".$rigad[id]."&negozio=".$rigad[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
			}
			echo "</div>"; 
	
			echo "<div class=spazio_puls_carrello>";
			echo "</div>"; 
			if ($rigaq[extra] != "") {
			  switch ($_SESSION[lang]) {
				case "it":
				$scritta_puls = "Scegli quantit&agrave;";
				break;
				case "en":
				$scritta_puls = "Choose quantity";
				break;
			  }
			  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigad[negozio]."&id_prod=".$rigad[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
			  echo $scritta_puls;
			  echo "</div></a>";
			} else {
			  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigad[negozio]."&id_prod=".$rigad[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
			  switch ($_SESSION[lang]) {
				case "it":
				echo "Inserisci nel carrello";
				break;
				case "en":
				echo "Add to cart";
				break;
			  }
			  echo "</div></a>";
			  }
			}
			//fine div componente_bottoni
			echo "</div>"; 
		  }
		  //fine div riquadro_prodotto
		  echo "</div>";
		}
*/		
		//***************
		//fine blister neutro
		//***************

		//********************
		//********************
		//riquadro per l'aggancio simboli etichette ADR in caso nella colonna simbolo ci sia l'indicazione del simbolo relativo
		//********************
		//********************
		if (($categoria3 == "110_Etichette_Adr") AND ($rigaq[cf] != "")) {
		  //inizio div riquadro_prodotto
		  echo "DDD";
			if ($rigaq[ordine_stampa] == 1) {
			echo "<div id=riquadro_prodotto_abbass>";
			} else {
			echo "<div id=riquadro_prodotto>";
			}
		  $sqld = "SELECT * FROM qui_prodotti_labels WHERE simbolo_blister='".$rigaq[cf]."' ORDER BY id ASC LIMIT 1";
		  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		  while ($rigad = mysql_fetch_array($risultd)) {
			//raggruppamento contenente titolo, descrizione e dati
			echo "<div id=raggruppamento_".$riga." class=raggruppo>";
			echo "<div class=Titolo_famiglia style=\"float:left;\">";
			switch ($_SESSION[lang]) {
			  case "it":
				if ($negozio == "labels") {
				  echo str_replace("_"," ",substr($rigad[categoria3_it],4));
				} else {
				  echo str_replace("_"," ",$rigad[categoria3_it]);
				}
			  break;
			  case "en":
				if ($rigaq[categoria3_en] == "") {
				  if ($negozio == "labels") {
					echo str_replace("_"," ",substr($rigad[categoria3_it],4));
				  } else {
					echo str_replace("_"," ",$rigad[categoria3_it]);
				  }
				} else {
				  echo str_replace("_"," ",$rigad[categoria3_en]);
				}
			  break;
			  }					
			  echo "</div>";
			  echo "<div id=componente_descrizione>";
			  echo "<div class=descr_famiglia>";
			  switch ($_SESSION[lang]) {
				case "it":
				echo stripslashes($rigad[descrizione2_it]);
				break;
				case "en":
				echo stripslashes($rigad[descrizione2_en]);
				break;
			  }					
			  echo "</div>";
			  echo "</div>";
			  echo "<div id=dati_".$riga." class=blocco_dati>";
			  echo "<div class=scritte_bottoncini>".$code."</div>"; 
			  echo "<div class=bottoncini>";
			  if (substr($rigad[codice_art],0,1) != "*") {
				echo $rigad[codice_art];
			  } else {
				echo substr($rigad[codice_art],1);
			  }
			  echo "</div>";
			  echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>";
		if ($rigad[prezzo] > 0) {
			echo number_format($rigad[prezzo],2,",",".");
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
				  echo $rigad[confezione];
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$rigad[confezione]);
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
		  if ($rigad[ordine_stampa] == 1) {
			$oggetto = "Ordine_etichette_Adr_codice_".$rigad[codice_art];
			echo "<a href=mailto:adv@publiem.it?bcc=mara.girardi@publiem.it&Subject=".$oggetto."><div style=\"margin-top:50px;width:120px; height:auto; padding:10px; background-color:red; color:white; float:left; text-align:center;font-size:14px;font-weight:bold; text-decoration:none;\">";
		  switch ($_SESSION[lang]) {
			case "it":
				echo "Etichetta in fase di approvazione;<br>per richiedere informazioni<br>CLICCA QUI";
			break;
			case "en":
				echo "Label on approval.<br>To request information<br>CLICK HERE";
			break;
		  }
			echo "</div></a>";
		  }
			  echo "</div>";
			  echo "<div id=variante_".$riga." class=Titolo_famiglia>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo str_replace("_", " ",stripslashes($rigad[categoria4_it]));
			  break;
			  case "en":
			  echo str_replace("_", " ",stripslashes($rigad[categoria4_en]));
			  break;
			}					
			  echo "</div>";
			  echo "<div class=componente_iconcine>";
			  echo "</div>";
			  //fine raggruppamento
			  echo "</div>";
			  echo "<div id=componente_immagine>";
			  if ($rigad[foto] != "") {
				echo "<img src=files/".$rigad[foto]." width=248 height=248>";
			  } else {
				echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
			  }
			  echo "</div>";

			  //componente bottoni
			  echo "<div id=componente_bottoni_".$riga." class=componente_bottoni_ph>";
			  echo "<div class=comandi_primo>";
				switch ($rigad[azienda]) {
				  case "SOL":
					echo '<img src="immagini/bottone-sol.png">';
				  break;
				  case "VIVISOL":
					echo '<img src="immagini/bottone-vivisol.png">';
				  break;
				}
			  echo "</div>"; 
			  echo "<div class=comandi>";
			  $nome_gruppo = mt_rand(1000,9999);
			  //operazioni di costruzione della gallery
		  /*
			if ($rigaq[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' AND precedenza = '3'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
		  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' ORDER BY precedenza ASC";
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
			}
		  */
			  //fine  costruzione gallery
			  echo "</div>"; 
			  echo "<div class=comandi>";
			  if ($rigaq[percorso_pdf] != "") {
				echo "<a href=documenti/".$rigaq[percorso_pdf]." target=_blank>";
				echo "<span class=pulsante_scheda>";
				switch ($_SESSION[lang]) {
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
			  if ($nofunz != "") {
			  } else {
				$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigad[id]' AND id_utente = '$_SESSION[user_id]'";
				$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
				$preferiti_presenti = mysql_num_rows($risulteee);
				if ($preferiti_presenti > 0) {
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigad[id]."&negozio_prod=".$rigad[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				  echo "<div class=comandi>";
				  echo "<span class=pulsante_preferiti>";
				  switch ($_SESSION[lang]) {
					case "it":
					echo "Elimina dai preferiti";
					break;
					case "en":
					echo "Remove from favourites";
					break;
				  }
				  echo "</span>";
				} else {
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigad[negozio]."&id_prod=".$rigad[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				  echo "<div class=comandi>";
				  echo "<span class=pulsante_preferiti>";
				  switch ($_SESSION[lang]) {
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
				echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigad[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_stampa>";
				switch ($_SESSION[lang]) {
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
				$modulo = "popup_modifica_scheda.php";
				if ($vis_admin == 1) {
				  echo "<a href=".$modulo."?action=edit&id=".$rigad[id]."&negozio=".$rigad[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
				}
				echo "</div>"; 
				echo "<div class=spazio_puls_carrello>";
				echo "</div>"; 
				if ($rigaq[extra] != "") {
				  switch ($_SESSION[lang]) {
					case "it":
					$scritta_puls = "Scegli quantit&agrave;";
					break;
					case "en":
					$scritta_puls = "Choose quantity";
					break;
				  }
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigad[negozio]."&id_prod=".$rigad[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
				  echo $scritta_puls;
				  echo "</div></a>";
				} else {
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigad[negozio]."&id_prod=".$rigad[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
				  switch ($_SESSION[lang]) {
				  case "it":
					echo "Inserisci nel carrello";
					break;
					case "en":
					echo "Add to cart";
					break;
				  }
				  echo "</div></a>";
				}
			  }
			//fine div componente_bottoni
			echo "</div>"; 
		  }
		//fine div riquadro_prodotto
		echo "</div>";
		}
		//***************
		//fine aggancio simboli per etichette ADR
		//***************
		} else {
		//da qui in poi SE NON SONO ETICHETTE PHARMA
		//questo array serve per identificare quali categorie hanno le dipendenze
		$array_cat_dipendenze = array("	Etichette_ADR");
		//********************************************************
		//visualizzazione articolo unico con varianti a tendina
		//********************************************************
		  //********************************************************
		  //inizio caso elementi famiglia senza riferimento famiglia, (tutti elementi diversi tra loro)
		  //***********************************************************
		  if ($rigaq[rif_famiglia] == "") {
			//echo "EEE";
			echo "<div id=riquadro_prodotto>";
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
			echo "<br>";
			if ($rigag[id_valvola] != "") {
			  $sqlj = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigaq[id_valvola]'";
			  $risultj = mysql_query($sqlj) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigaj = mysql_fetch_array($risultj)) {
				echo "VALVOLA ".$rigaj[descrizione1_it]."<br>";
			  }
			}
			if ($rigaq[id_cappellotto] != "") {
			  echo "CAPPELLOTTO ".$rigaq[cappellotto];
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
			//componente bottoni
			if ($_GET['schedaVis'] == "") {
			echo "<div id=componente_bottoni>";
			echo "<div class=comandi_primo>";
				switch ($rigaq[azienda]) {
				  case "SOL":
					echo '<img src="immagini/bottone-sol.png">';
				  break;
				  case "VIVISOL":
					echo '<img src="immagini/bottone-vivisol.png">';
				  break;
				}
			echo "</div>"; 
			echo "<div class=comandi>";
			$nome_gruppo = mt_rand(1000,9999);
			//operazioni di costruzione della gallery
			if ($rigaq[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' AND precedenza = '3'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
			$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' ORDER BY precedenza ASC";
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
			}
			//fine  costruzione gallery
			echo "</div>"; 
			echo "<div class=comandi>";
			if ($rigaq[percorso_pdf] != "") {
			  echo "<a href=documenti/".$rigaq[percorso_pdf]." target=_blank>";
			  echo "<span class=pulsante_scheda>";
			  switch ($_SESSION[lang]) {
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
			if ($nofunz != "") {
			} else {
			  $sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
			  $risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $preferiti_presenti = mysql_num_rows($risulteee);
				if ($preferiti_presenti > 0) {
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigaq[id]."&negozio_prod=".$rigaq[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				  echo "<div class=comandi>";
				  echo "<span class=pulsante_preferiti>";
					switch ($_SESSION[lang]) {
					  case "it":
					  echo "Elimina dai preferiti";
					  break;
					  case "en":
					  echo "Remove from favourites";
					  break;
					}
					echo "</span>";
				  } else {
					echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
					echo "<div class=comandi>";
					echo "<span class=pulsante_preferiti>";
					switch ($_SESSION[lang]) {
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
				  echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigaq[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
				  echo "<div class=comandi>";
				  echo "<span class=pulsante_stampa>";
				  switch ($_SESSION[lang]) {
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
					echo "<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
				  }
				  echo "</div>"; 
			  
				  echo "<div class=spazio_puls_carrello>";
				  echo "</div>"; 
/*				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
				  switch ($_SESSION[lang]) {
					case "it":
					echo "Inserisci nel carrello";
					break;
					case "en":
					echo "Add to cart";
					break;
				  }
				  echo "</div></a>";
*/	
		  switch ($_SESSION[lang]) {
			case "it":
			$scritta_puls = "Scegli quantit&agrave;";
			break;
			case "en":
			$scritta_puls = "Choose quantity";
			break;
		  }
		  if ($rigaq[ordine_stampa] == 1) {
			echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
		  } else {
		  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
		  }
		  echo $scritta_puls;
		  echo "</div></a>";
				}
//fine div componente_bottoni
				echo "</div>";
			}
			  echo "</div>"; 
			//********************************************************
			//fine if elementi famiglia senza icone, (tutti elementi diversi tra loro)
			//***********************************************************
			} else {
			
			if (in_array($rigaq[categoria1_it],$array_cat_dipendenze)) {
			//********************************************************
			// per le etichette si visualizza per prima l'etichetta principale richiesta  e poi, di seguito, tutte le dipendenze, ovvero
			// tutti i prodotti che nel campo rif  famiglia riportano l'id del principale
			//***********************************************************
			if ($rigaq[rif_famiglia] == $rigaq[id]) {
			  $array_etichette = array($rigaq[id]);
			  $sqlm = "SELECT * FROM qui_prodotti_".$negozio." WHERE categoria1_it = '$rigaq[categoria1_it]' ORDER BY id ASC";
			  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigam = mysql_fetch_array($risultm)) {
				$array_dip_sing_etich = explode(",",$rigam[rif_famiglia]);
				if (in_array($rigaq[id],$array_dip_sing_etich)) {
				  $add_id = array_push($array_etichette,$rigam[id]);
				}
			  }
			  //print_r($array_etichette);
			  foreach ($array_etichette as $sing_etich_dipendenze) {
				echo "FFF";
				echo "<div id=riquadro_prodotto>";
				echo "<div id=raggruppamento>";
				echo "<div id=componente_descrizione>";
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
				echo "<div id=variante class=Titolo_famiglia>";
				switch ($_SESSION[lang]) {
				  case "it":
				  echo stripslashes($rigaq[categoria4_it]);
				  break;
				  case "en":
				  echo stripslashes($rigaq[categoria4_en]);
				  break;
				}					
				echo "</div>";
				echo "</div>";
				echo "<div id=componente_dati>";
				echo "<div class=Titolo_famiglia></div>"; 
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
				//componente bottoni
				echo "<div id=componente_bottoni>";
				echo "<div class=comandi_primo>";
				switch ($rigaq[azienda]) {
				  case "SOL":
					echo '<img src="immagini/bottone-sol.png">';
				  break;
				  case "VIVISOL":
					echo '<img src="immagini/bottone-vivisol.png">';
				  break;
				}
				echo "</div>"; 
				echo "<div class=comandi>";
				$nome_gruppo = mt_rand(1000,9999);
				//operazioni di costruzione della gallery
			if ($rigaq[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' AND precedenza = '3'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
				$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' ORDER BY precedenza ASC";
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
			}
				//fine  costruzione gallery
				echo "</div>"; 
				echo "<div class=comandi>";
				if ($rigaq[percorso_pdf] != "") {
				  echo "<a href=documenti/".$rigaq[percorso_pdf]." target=_blank>";
				  echo "<span class=pulsante_scheda>";
				  switch ($_SESSION[lang]) {
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
				if ($nofunz != "") {
				} else {
				  $sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
				  $risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
				  $preferiti_presenti = mysql_num_rows($risulteee);
				  if ($preferiti_presenti > 0) {
					echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigaq[id]."&negozio_prod=".$rigaq[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
					echo "<div class=comandi>";
					echo "<span class=pulsante_preferiti>";
					switch ($_SESSION[lang]) {
					  case "it":
					  echo "Elimina dai preferiti";
					  break;
					  case "en":
					  echo "Remove from favourites";
					  break;
					}
					echo "</span>";
				} else {
				  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				  echo "<div class=comandi>";
				  echo "<span class=pulsante_preferiti>";
				  switch ($_SESSION[lang]) {
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
				echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigaq[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_stampa>";
				switch ($_SESSION[lang]) {
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
				  echo "<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
				}
				echo "</div>"; 
				echo "<div class=spazio_puls_carrello>";
				echo "</div>"; 
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
				switch ($_SESSION[lang]) {
				  case "it":
				  echo "Inserisci nel carrello";
				  break;
				  case "en":
				  echo "Add to cart";
				  break;
				}
				echo "</div></a>";
			  }
			  //fine div componente_bottoni
			  echo "</div>"; 
			  //fine div riquadro_prodotto
			  echo "</div>";
			//fine foreach 
			}
			//********************************************************
			//fine if rif famiglia == id
			//***********************************************************
		  }
		} else {
		  //********************************************************
		  // if elementi famiglia con icone, (tutte le categorie tranne le etichette)
		  // per tutte le categorie vale la regola che si visualizza solo il capo famiglia (rif_famiglia = id) 
		  // e tutti gli elementi collegati con l'id vanno a formare il set di icone
		  //***********************************************************
		  if ($rigaq[rif_famiglia] == $rigaq[id]) {
			$sqlm = "SELECT * FROM qui_prodotti_".$negozio." WHERE rif_famiglia = '$rigaq[id]' AND obsoleto = '0' ORDER BY id ASC";
			$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			while ($rigam = mysql_fetch_array($risultm)) {
				if ($rigam[categoria2_it] != "Pescanti") {
			  $blocco_cat4 .= "<div class=icona_singola><a href=#><img src=immagini/".$rigam[categoria4_it].".png border=0 onClick=\"compilazione(".$rigam[id].",".$rigam[rif_famiglia].")\"></a></div>";
				} else {
	  $blocco_cat4 .= "<div class=icona_singola style=\"cursor:pointer;\"><img src=immagini/".$rigam[categoria4_it]."l.png name=imm_".$rigam[categoria4_it]."l id=imm_".$rigam[categoria4_it]."l border=0 onClick=\"compilazione(".$rigam[id].",".$rigam[rif_famiglia].")\"></div>";
		}
			}
			echo "GGG";
			echo "<div id=riquadro_prodotto>";
			//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
			echo "<div id=raggruppamento>";
			echo "<div id=componente_descrizione>";
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
			echo "<div id=variante_".$rigaq[rif_famiglia]." class=Titolo_famiglia>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo str_replace("_"," ",stripslashes($rigaq[categoria4_it]));
			  break;
			  case "en":
			  echo str_replace("_"," ",stripslashes($rigaq[categoria4_en]));
			  break;
			}					
			echo "</div>";
			echo "</div>";
			//echo "<div id=risultato>";
			echo "<div class=componente_dati id=componente_dati_".$rigaq[rif_famiglia].">";
			echo "<div class=Titolo_famiglia></div>"; 
			echo "<div class=scritte_bottoncini>".$code."</div>"; 
			if ($_GET['codice_art'] != "") {
			  echo "<div class=bottoncini>";
			  if (substr($_GET['codice_art'],0,1) != "*") {
				echo $_GET['codice_art'];
			  } else {
				echo substr($_GET['codice_art'],1);
			  }
			  echo "</div>";
			} else {
			  echo "<div class=bottoncini>";
			  if (substr($rigaq[codice_art],0,1) != "*") {
				echo $rigaq[codice_art];
			  } else {
				echo substr($rigaq[codice_art],1);
			  }
			  echo "</div>";
			}
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
			echo $blocco_cat4;
			$blocco_cat4 = "";	
			echo "</div>";
			echo "</div>";
			echo "<div id=componente_immagine_".$rigaq[rif_famiglia]." class=componente_immagine>";
			  if ($rigaq[foto] != "") {
				echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
			  } else {
				echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
			  }
			echo "</div>";
			//componente bottoni
			echo "<div id=componente_bottoni_".$rigaq[rif_famiglia]." class=componente_bottoni>";
			echo "<div class=comandi_primo>";
				switch ($rigaq[azienda]) {
				  case "SOL":
					echo '<img src="immagini/bottone-sol.png">';
				  break;
				  case "VIVISOL":
					echo '<img src="immagini/bottone-vivisol.png">';
				  break;
				}
			echo "</div>"; 
			echo "<div class=comandi>";
			$nome_gruppo = mt_rand(1000,9999);
			//operazioni di costruzione della gallery
			if ($rigaq[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' AND precedenza = '3'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
			$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigaq[codice_art]' ORDER BY precedenza ASC";
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
			}
			//fine  costruzione gallery
			echo "</div>"; 
			echo "<div class=comandi>";
			if ($rigaq[percorso_pdf] != "") {
			  echo "<a href=documenti/".$rigaq[percorso_pdf]." target=_blank>";
			  echo "<span class=pulsante_scheda>";
			  switch ($_SESSION[lang]) {
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
			if ($nofunz != "") {
			} else {
			  $sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
			  $risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $preferiti_presenti = mysql_num_rows($risulteee);
			  if ($preferiti_presenti > 0) {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigaq[id]."&negozio_prod=".$rigaq[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
				  case "it":
				  echo "Elimina dai preferiti";
				  break;
				  case "en":
				  echo "Remove from favourites";
				  break;
				}
				echo "</span>";
			  } else {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				echo "<div class=comandi>";
				echo "<span class=pulsante_preferiti>";
				switch ($_SESSION[lang]) {
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
			  echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigaq[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
			  echo "<div class=comandi>";
			  echo "<span class=pulsante_stampa>";
			  switch ($_SESSION[lang]) {
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
				echo "<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
			  }
			  echo "</div>"; 
	
			  echo "<div class=spazio_puls_carrello>";
			  echo "</div>"; 
/*			  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
			  switch ($_SESSION[lang]) {
				case "it":
				echo "Inserisci nel carrello";
				break;
				case "en":
				echo "Add to cart";
				break;
			  }
			  echo "</div></a>";
*/
		  switch ($_SESSION[lang]) {
			case "it":
			$scritta_puls = "Scegli quantit&agrave;";
			break;
			case "en":
			$scritta_puls = "Choose quantity";
			break;
		  }
		  if ($rigaq[ordine_stampa] == 1) {
			echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
		  } else {
		  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
		  }
		  echo $scritta_puls;
		  echo "</div></a>";

}
			//fine div componente_bottoni
			echo "</div>"; 
			//fine div riquadro_prodotto
			echo "</div>"; 
					
			//********************************************************
			//fine if rif famiglia == id
			//***********************************************************
		  }
			
		//fine if in_array (etichette)
		}
	  //fine if rif famiglia
	  }
	}
	//fine while principale
  }
} else {
//layout x visualizzazione in tinybox
$sqlq = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$_GET[codice_art]'";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
  		  //echo "HHH";
			if ($rigaq[ordine_stampa] == 1) {
			echo "<div id=riquadro_prodotto_abbass>";
			} else {
			echo "<div id=riquadro_prodotto>";
			}
		  echo "<div id=raggruppamento_".$riga." class=raggruppo>";
		  echo "<div id=componente_descrizione>";
		  echo "<div class=Titolo_famiglia>";
		  switch ($_SESSION[lang]) {
			case "it":
			if ($rigaq[negozio] == "labels") {
			echo str_replace("_"," ",substr($rigaq[categoria3_it],4));
			  } else {
			echo str_replace("_"," ",$rigaq[categoria3_it]);
			  }
			break;
			case "en":
			if ($rigaq[negozio] == "labels") {
			  if ($rigaq[categoria3_en] == "") {
				echo str_replace("_"," ",substr($rigaq[categoria3_it],4));
			  } else {
				echo str_replace("_"," ",substr($rigaq[categoria3_en],4));
			  }
			} else {
			  if ($rigaq[categoria3_en] == "") {
				echo str_replace("_"," ",$rigaq[categoria3_it]);
			  } else {
				echo str_replace("_"," ",$rigaq[categoria3_en]);
			  }
			}
			break;
		  }					
		  echo "</div>";
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
		  echo "<div id=variante class=Titolo_famiglia>";
		  if  ($rigaq[categoria4_en] == "") {
			echo stripslashes(str_replace("_"," ",$rigaq[categoria4_it]));
		  } else {
			switch ($_SESSION[lang]) {
			  case "it":
			  echo stripslashes(str_replace("_"," ",$rigaq[categoria4_it]));
			  break;
			  case "en":
			  echo stripslashes(str_replace("_"," ",$rigaq[categoria4_en]));
			  break;
			}					
		  }
		  echo "</div>";
		  echo "</div>";
		  echo "<div id=componente_dati>";
		  echo "<div class=Titolo_famiglia></div>"; 
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
		  //componente bottoni
		  echo "<div id=componente_bottoni>";
		//fine div componente_bottoni
		echo "</div>"; 
		//fine div riquadro_prodotto
		echo "</div>"; 
}
	}
  
//********************************
//********************************
//SCHEDE PRODOTTI VIRTUALI BILOCATI
//********************************
//********************************
		  echo "VVV";

$query_virtual = "SELECT * FROM qui_prodotti_labels_dupli WHERE obsoleto = '0' AND categoria2_it = '$categoria2' AND negozio = 'labels' AND categoria1_it = '$categoria1' AND categoria3_it = '$categoria3' AND (paese = '$paese' OR prodotto_multilingue LIKE '%$paese%') ORDER BY precedenza_int ASC";
//echo "<br>".$query_virtual."<br>";
$risultf = mysql_query($query_virtual) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$query_retour = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$rigaf[codice_art]'";
//echo "<br>".$query_virtual."<br>";
$risult0 = mysql_query($query_retour) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigac = mysql_fetch_array($risult0)) {
	$id_prod = $rigac[id];
		  $foto_fam = $rigac[foto];
			if ($rigac[ordine_stampa] == 1) {
			echo "<div id=riquadro_prodotto_abbass>";
			} else {
			echo "<div id=riquadro_prodotto>";
			}
		  echo "<div id=raggruppamento_".$riga." class=raggruppo>";
		  echo "<div id=componente_descrizione>";
		  echo "<div class=Titolo_famiglia>";
		  switch ($_SESSION[lang]) {
			case "it":
			echo str_replace("_"," ",substr($rigac[categoria3_it],4));
			break;
			case "en":
			  if ($rigac[categoria3_en] == "") {
				echo str_replace("_"," ",substr($rigac[categoria3_en],4));
			  } else {
				echo str_replace("_"," ",substr($rigac[categoria3_it],4));
			  }
			break;
		  }					
		  echo "</div>";
		  echo "<div class=descr_famiglia>";
		  switch ($_SESSION[lang]) {
			case "it":
			echo stripslashes($rigac[descrizione2_it]);
			break;
			case "en":
			echo stripslashes($rigac[descrizione2_en]);
			break;
		  }					
		  echo "</div>";
		  echo "<div id=variante class=Titolo_famiglia>";
		  if  ($rigac[categoria4_en] == "") {
			echo stripslashes(str_replace("_"," ",$rigac[categoria4_it]));
		  } else {
			switch ($_SESSION[lang]) {
			  case "it":
			  echo stripslashes(str_replace("_"," ",$rigac[categoria4_it]));
			  break;
			  case "en":
			  echo stripslashes(str_replace("_"," ",$rigac[categoria4_en]));
			  break;
			}					
		  }
		  echo "</div>";
		  echo "</div>";
		  echo "<div id=componente_dati>";
		  echo "<div class=Titolo_famiglia></div>"; 
		  echo "<div class=scritte_bottoncini>".$code."</div>"; 
			  echo "<div class=bottoncini>";
			  if (substr($rigac[codice_art],0,1) != "*") {
				echo $rigac[codice_art];
			  } else {
				echo substr($rigac[codice_art],1);
			  }
			  echo "</div>";
		  echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>";
		if ($rigac[prezzo] > 0) {
			echo number_format($rigac[prezzo],2,",",".");
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
				  echo $rigac[confezione];
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$rigac[confezione]);
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
		  if ($rigac[ordine_stampa] == 1) {
			$oggetto = "Ordine_etichette_Adr_codice_".$rigaq[codice_art];
			echo "<a href=mailto:adv@publiem.it?bcc=mara.girardi@publiem.it&Subject=".$oggetto."><div style=\"margin-top:50px;width:120px; height:auto; padding:10px; background-color:red; color:white; float:left; text-align:center;font-size:14px;font-weight:bold; text-decoration:none;\">";
		  switch ($_SESSION[lang]) {
			case "it":
				echo "Etichetta in fase di approvazione;<br>per richiedere informazioni<br>CLICCA QUI";
			break;
			case "en":
				echo "Label on approval.<br>To request information<br>CLICK HERE";
			break;
		  }
			echo "</div></a>";
		  }
		  echo "</div>";
		  
		  echo "<div id=componente_iconcine>";
		  echo "</div>";
		  echo "</div>";
		  
		  echo "<div id=componente_immagine>";
		  if ($rigac[foto] != "") {
			echo "<img src=files/".$rigac[foto]." width=248 height=248>";
		  } else {
			echo "<img src=files/TO-BE-UPDATED.jpg width=248 height=248>";
		  }
		  echo "</div>";
		  //componente bottoni
		  echo "<div id=componente_bottoni>";
		  echo "<div class=comandi_primo>";
				switch ($rigac[azienda]) {
				  case "SOL":
					echo '<img src="immagini/bottone-sol.png">';
				  break;
				  case "VIVISOL":
					echo '<img src="immagini/bottone-vivisol.png">';
				  break;
				}
		  echo "</div>"; 
		  echo "<div class=comandi>";
		  $nome_gruppo = mt_rand(1000,9999);
		  //operazioni di costruzione della gallery
			if ($rigaf[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigac[codice_art]' AND precedenza = '2'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
		  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigac[codice_art]' ORDER BY precedenza ASC";
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
			}
		  //fine  costruzione gallery
		  echo "</div>";
		  if ($rigac[percorso_pdf] != "") {
			echo "<a href=documenti/".$rigac[percorso_pdf]." target=_blank>";
			echo "<div class=comandi>";
			echo "<span class=pulsante_scheda>";
			switch ($_SESSION[lang]) {
			  case "it":
			  echo "Scheda tecnica";
			  break;
			  case "en":
			  echo "Technical sheet";
			  break;
			}
			echo "</span>";
			echo "</div></a>"; 
		  }
		  if ($nofunz != "") {
		  } else {
			echo "<div class=comandi_spazio>";
			echo "</div>"; 
			$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigac[id]' AND id_utente = '$_SESSION[user_id]'";
			$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			$preferiti_presenti = mysql_num_rows($risulteee);
			if ($preferiti_presenti > 0) {
			  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$id_prod."&negozio_prod=".$rigac[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
			  echo "<div class=comandi>";
			  echo "<span class=pulsante_preferiti>";
			  switch ($_SESSION[lang]) {
				case "it":
				echo "Elimina dai preferiti";
				break;
				case "en":
				echo "Remove from favourites";
				break;
			  }
			  echo "</span>";
			} else {
			  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigac[negozio]."&id_prod=".$id_prod."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:180,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
			  echo "<div class=comandi>";
			  echo "<span class=pulsante_preferiti>";
			  switch ($_SESSION[lang]) {
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
		echo "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$id_prod."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		echo "<div class=comandi>";
		echo "<span class=pulsante_stampa>";
		switch ($_SESSION[lang]) {
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
		$modulo = "popup_modifica_scheda.php";
		if ($vis_admin == 1) {
		//echo "<a href=".$modulo."?action=edit&id=".$rigaq[id]."&negozio=".$rigaq[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
		}
		echo "</div>"; 	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 
//		if ($rigaq[extra] != "") {
		  switch ($_SESSION[lang]) {
			case "it":
			$scritta_puls = "Scegli quantit&agrave;";
			break;
			case "en":
			$scritta_puls = "Choose quantity";
			break;
		  }
		  if ($rigac[ordine_stampa] == 1) {
			echo "<div class=pulsante_carrello title=\"$scritta_puls\">";
		  } else {
		  echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigac[negozio]."&id_prod=".$id_prod."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
		  }
		  echo $scritta_puls;
		  echo "</div></a>";
		  }
		//fine div componente_bottoni
		echo "</div>"; 
		//fine div riquadro_prodotto
		echo "</div>"; 
		}
}
					
	  //********************************************************
	  //fine if prodotti bilocati
	  //***********************************************************
?>

</div>

<script type="text/javascript">
function compilazione_pharma(id,riga){
						/*alert('#dati_'+riga);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_dati_pharma.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#dati_'+riga).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_bottoni_pharma.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_bottoni_'+riga).html(output).show();
						}
						});

				$.ajax({
						type: "GET",   
						url: "aggiorna_variante_pharma.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#variante_'+riga).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_descr_pharma.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#descrpharma_'+riga).html(output).show();
						}
						});
}

function compilazione(id,famiglia){
						/*alert(riga);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_dati.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_dati_'+famiglia).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_immagine.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_immagine_'+famiglia).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_bottoni.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_bottoni_'+famiglia).html(output).show();
						}
						});

				$.ajax({
						type: "GET",   
						url: "aggiorna_variante.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#variante_'+famiglia).html(output).show();
						}
						});
}
</script>
<SCRIPT type="text/javascript">
function closeJS(){
  //window.location.href = window.location.href;
				$.ajax({
						type: "GET",   
						url: "aggiornamento_carrello.php",   
						data: "aggiungi=1&cat=",
						success: function(output) {
						$('#vis_carrello').html(output).show();
						//alert('closed')
						}
						});
}
</SCRIPT>

<script type="text/javascript" src="tinybox.js"></script>

</body>
</html>
