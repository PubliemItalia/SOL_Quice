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


$_SESSION[categoria1] = $_GET['categoria1'];
$_SESSION[categoria2] = $_GET['categoria2'];
$_SESSION[categoria3] = $_GET['categoria3'];
$_SESSION[categoria4] = $_GET['categoria4'];
if ($_GET['ordinamento'] == "") {
$ordinamento = "codice_art";
$asc_desc = "ASC";
} else {
$ordinamento = $_GET['ordinamento'];
if ($_GET['asc_desc'] == "") {
$asc_desc = "ASC";
} else {
$asc_desc = $_GET['asc_desc'];
}
}
$_SESSION[ordinamento] = $ordinamento;
$_SESSION[asc_desc] = $asc_desc;

include "functions.php";
include "menu_quice3.php";
if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}

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
$c = "categoria2_it = '$categoria2'";
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
$h = "paese = '$paese'";
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
$testoQuery .= $h;
}
}

}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}


$testoQuery .= " ORDER BY ".$ordinamento." ".$asc_desc;

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
$_SESSION[percorso_indietro] = "scheda_visuale_pacchi.php?categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&paese=".$paese."&negozio=".$negozio."&lang=".$lingua;
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
*/}
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
  $price = "Prezzo";
  $package = "Confezione";
  $pcs = "Pezzi";
  $gallery = "Galleria immagini";
  break;
  case "en":
  $code = "Code";
  $price = "Price";
  $package = "Package";
  $pcs = "Pcs";
  $gallery = "Image gallery";
  break;
}
//partenza delle operazioni di query
$risultq = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
	//********************************************************
	//inizio caso elementi famiglia senza riferimento famiglia, (tutti elementi diversi tra loro)
	//***********************************************************
		echo "<div id=riquadro_prodotto>";
		//echo "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
		echo "<div id=raggruppamento>";
		echo "<div class=Titolo_famiglia>".str_replace("_"," ",$rigaq[categoria3_it])."</div>";
		echo "<div id=componente_descrizione>";
		echo "<div class=descr_famiglia>".stripslashes($rigaq[descrizione2_it])."</div>";
		echo "<div id=variante class=variante_testuale>".stripslashes(str_replace("_"," ",$rigaq[categoria4_it]))."<br>";
		echo "</div>";
		echo "</div>";
		//echo "<div id=risultato>";
		echo "<div id=componente_dati>";
		
		//echo "<span class=Titolo_bianco_xspazio>DATI</span><br>";
		echo "<div class=scritte_bottoncini>".$code."</div>"; 
		echo "<div class=bottoncini>".$rigaq[codice_art]."</div>";
		echo "<div class=scritte_bottoncini>".$price."</div>"; 
		echo "<div class=bottoncini>".number_format($rigaq[prezzo],2,",",".")."</div>";
		echo "<div class=scritte_bottoncini>".$package."</div>"; 
		echo "<div class=bottoncini>".$rigaq[confezione]." ".$pcs."</div>";
/*		echo "<div class=scritte_bottoncini>Gruppo merci</div>"; 
		echo "<div class=bottoncini>".$rigaq[gruppo_merci]."</div>";
*/		echo "</div>";
		
		echo "<div id=componente_iconcine>";
		echo "</div>";
		echo "</div>";
		
		echo "<div id=componente_immagine>";
		echo "<img src=files/".$rigaq[foto]." width=248 height=248>";
		echo "</div>";
		//componente bottoni
		echo "<div id=componente_bottoni>";
		echo "<div class=comandi>";
		echo "</div>"; 
		echo "<div class=comandi>";
		$nome_gruppo = mt_rand(1000,9999);
		//operazioni di costruzione della gallery
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
		//fine  costruzione gallery
		echo "</div>"; 
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
		echo "</div>"; 
		echo "<div class=comandi_spazio>";
		echo "</div>"; 
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
			if ($preferiti_presenti > 0) {
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigaq[id]."&negozio_prod=".$rigaq[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
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
				echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
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
/*		echo "<div class=comandi>";
		echo "<a href=".$modulo."?action=duplicate&id=".$rigak[id]."&negozio=".$rigak[negozio]."&lang=".$lingua."><span class=Stile3>".$duplicate."</span></a>";
		echo "</div>"; 
*/	
	
		echo "<div class=spazio_puls_carrello>";
		echo "</div>"; 
echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigaq[negozio]."&id_prod=".$rigaq[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
				switch ($_SESSION[lang]) {
					case "it":
					echo "Inserisci nel carrello";
					break;
					case "en":
					echo "Add to cart";
					break;
					}
echo "</div></a>";
//echo "id: ".$rigaq[id]."<br>";
		//fine div componente_bottoni
		echo "</div>"; 
		echo "</div>"; 
		//********************************************************
		//fine if elementi famiglia senza icone, (tutti elementi diversi tra loro)
		//***********************************************************
	//} 
		
//fine while principale
}
?>

</div>

<script type="text/javascript">
function compilazione(id){

						/*alert(id);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_dati.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_dati').html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_immagine.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_immagine').html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_bottoni.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_bottoni').html(output).show();
						}
						});

				$.ajax({
						type: "GET",   
						url: "aggiorna_variante.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#variante').html(output).show();
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
