<?php
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
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
if ($_GET[lang] != "") {
$lingua = $_GET[lang];
} else {
$lingua = $_POST[lang];
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
if ($modifica_prodotto != "") {
//se cambio l'immagine faccio il controllo che non esista già
//comunque sia l'immagine viene copiata nella cartella con un codice davanti. 
//se c'è l'immagine con lo stesso nome avverto e, se la risposta è si, cancello la vecchia immagine e rinomino quella nuova come quella vecchia
//se la risposta è no torno alla pagina precedente e cancello l'immagine nuova
if ($_FILES['immagine1']['tmp_name'] != "") {
include "copia_immagine_princ.php";
$elenco_immagini=elencafiles("files/");
//print_r ($elenco_immagini);
//echo "<br>";
if (in_array($_FILES['immagine1']['name'],$elenco_immagini)) {
//se esiste già l'immagine con il nome uguale, faccio uscire l'alert




echo "<img src=immagini/spacer.gif width=368 height=20> ";

echo "<table width=240 border=0 cellspacing=0 cellpadding=0 align=center>";
    echo "<tr>";
      echo "<td colspan=2 valign=top>";
   echo "<div align=center><span class=Stile4>".$alert_sost_imm."</span><br></div>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
      echo "<td width=120 valign=top>";
echo "<form name=form1 method=post action=popup_scheda.php>";
    echo "<div align=center>";
      echo "<input type=submit name=button id=button value=OK>";
      echo "<input name=descrizione1_it type=hidden id=descrizione1_it value=".$descrizione1_it_mod.">";
      echo "<input name=descrizione2_it type=hidden id=descrizione2_it value=".$descrizione2_it_mod.">";
      echo "<input name=descrizione3_it type=hidden id=descrizione3_it value=".$descrizione3_it_mod.">";
      echo "<input name=descrizione4_it type=hidden id=descrizione4_it value=".$descrizione4_it_mod.">";
      echo "<input name=descrizione1_en type=hidden id=descrizione1_en value=".$descrizione1_en_mod.">";
      echo "<input name=descrizione2_en type=hidden id=descrizione2_en value=".$descrizione2_en_mod.">";
      echo "<input name=descrizione3_en type=hidden id=descrizione3_en value=".$descrizione3_en_mod.">";
      echo "<input name=descrizione4_en type=hidden id=descrizione4_en value=".$descrizione4_en_mod.">";
      echo "<input name=confezione type=hidden id=confezione value=".$confezione_mod.">";
      echo "<input name=codice type=hidden id=codice value=".$codice.">";
      echo "<input name=prezzo type=hidden id=prezzo value=".$prezzo_mod.">";
      echo "<input name=gruppo_merci type=hidden id=gruppo_merci value=".$gruppo_merci_mod.">";
      echo "<input name=lang type=hidden id=lang value=".$lingua.">";
      echo "<input name=negozio type=hidden id=negozio value=".$negozio.">";
      echo "<input name=id type=hidden id=id value=".$id.">";
      echo "<input name=modifica_prodotto type=hidden id=modifica_prodotto value=1>";
      echo "<input name=consenso type=hidden id=consenso value=1>";
    echo "</div>";
echo "</form>";
      echo "</td>";
      echo "<td width=120 valign=top>";
                    echo "<div align=center>";
                   echo "<input name=indietro type=button class=tabellegrandecentro onClick=history.go(-1) value=NO id=indietro>";
                    echo "</div>";
      echo "</td>";
    echo "</tr>";
  echo "</table>";
 

exit;


}
}
$sqlh = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
$vecchio_cod_art = $rigah[codice_originale_duplicato];
}
include "elaborazione_immagini.php";
//$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione3_it = '$descrizione3_it_mod', descrizione4_it = '$descrizione4_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', descrizione3_en = '$descrizione3_en_mod', descrizione4_en = '$descrizione4_en_mod', prezzo = '$prezzo_mod', codice_art = '$codice_mod', confezione = '$confezione_mod', gruppo_merci = '$gruppo_merci_mod' WHERE id = '$id'";

//***********************************
//non si modifica più il codice art in quanto viene creato automaticamente
$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione3_it = '$descrizione3_it_mod', descrizione4_it = '$descrizione4_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', descrizione3_en = '$descrizione3_en_mod', descrizione4_en = '$descrizione4_en_mod', prezzo = '$prezzo_mod', confezione = '$confezione_mod', gruppo_merci = '$gruppo_merci_mod', wbs = '$wbs_mod' WHERE id = '$id'";
//$titolo_pop1 = levapar($_POST[titolo_pop1]);
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento4: ".mysql_error();
}
$riepilogo = "Modifica prodotto id".$id." negozio ".$negozio." - utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = addslashes($_SESSION['nome']);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'prodotti', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

if ($consenso != "") {
$imm_temp_length = strlen($_SESSION[imm_temp]);
$pos_us = stripos($_SESSION[imm_temp],"_");
if ($pos_us === false) {
} else {
$nome_file = substr($_SESSION[imm_temp],($pos_us+1),$imm_temp_length);
}

unlink("files/".$nome_file);
$sorgente = "files/".$_SESSION[imm_temp];
$destinazione = "files/".$nome_file;
rename($sorgente,$destinazione);
$_SESSION[imm_temp] = "";
$querya = "UPDATE qui_prodotti_".$negozio." SET foto = '$nome_file' WHERE id = '$id'";
if (mysql_query($querya)) {
} else {
echo "Errore durante l'inserimento1: ".mysql_error();
}
}
//aggiornamento prodotti della gallery eventualmente inseriti prima del salvataggio della modifica in fase di duplicazione
$array_gallery = array();
$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$vecchio_cod_art'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaz = mysql_fetch_array($risultz)) {
$add_gallery = array_push($array_gallery,$rigaz[codice_originale_duplicato]);
}
if (count($array_gallery) > 0) {
foreach ($array_gallery as $sing_img) {
$queryg = "UPDATE qui_gallery SET id_prodotto = '$codice_mod' WHERE id = '$sing_img'";
if (mysql_query($queryg)) {
} else {
echo "Errore durante l'inserimento5: ".mysql_error();
}
//fine foreach
}
//fine if count
}
}
//fine modifica prodotto
$sqleee = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
$categoria1_it = $rigaeee[categoria1_it];
$categoria2_it = $rigaeee[categoria2_it];
$categoria3_it = $rigaeee[categoria3_it];
$categoria4_it = $rigaeee[categoria4_it];
$categoria1_en = $rigaeee[categoria1_en];
$categoria2_en= $rigaeee[categoria2_en];
$categoria3_en = $rigaeee[categoria3_en];
$categoria4_en = $rigaeee[categoria4_en];
$descrizione1_it = stripslashes($rigaeee[descrizione1_it]);
$descrizione2_it = stripslashes($rigaeee[descrizione2_it]);
$descrizione3_it = stripslashes($rigaeee[descrizione3_it]);
$descrizione4_it = stripslashes($rigaeee[descrizione4_it]);
$descrizione1_en = $rigaeee[descrizione1_en];
$descrizione2_en = $rigaeee[descrizione2_en];
$descrizione3_en = $rigaeee[descrizione3_en];
$descrizione4_en = $rigaeee[descrizione4_en];
switch($lingua) {
case "it":
$categoria1 = $rigaeee[categoria1_it];
$categoria2 = $rigaeee[categoria2_it];
if ($negozio == "labels") {
$categoria3 = substr($rigaeee[categoria3_it],4);
} else {
$categoria3= $rigaeee[categoria3_it];
}
$categoria4 = $rigaeee[categoria4_it];
$descrizione1 = stripslashes($rigaeee[descrizione1_it]);
$descrizione2 = stripslashes($rigaeee[descrizione2_it]);
$descrizione3 = stripslashes($rigaeee[descrizione3_it]);
$descrizione4 = stripslashes($rigaeee[descrizione4_it]);
break;
case "en":
$categoria1 = $rigaeee[categoria1_en];
$categoria2 = $rigaeee[categoria2_en];
$categoria3 = $rigaeee[categoria3_en];
$categoria4 = $rigaeee[categoria4_en];
$descrizione1 = $rigaeee[descrizione1_en];
$descrizione2 = $rigaeee[descrizione2_en];
$descrizione3 = $rigaeee[descrizione3_en];
$descrizione4 = $rigaeee[descrizione4_en];
break;
case "fr":
$descrizione = $rigaeee[descrizione_fr];
break;
case "de":
$descrizione = $rigaeee[descrizione_de];
break;
case "es":
$descrizione = $rigaeee[descrizione_es];
break;
}
$foto = $rigaeee[foto];
if (substr($rigaeee[codice_art],0,1) != "*") {
  $codice_art = $rigaeee[codice_art];
} else {
  $codice_art = substr($rigaeee[codice_art],1);
}
$paese = $rigaeee[paese];
$prezzo = $rigaeee[prezzo];
$confezione = $rigaeee[confezione];
$gruppo_merci = $rigaeee[gruppo_merci];
$wbs = $rigaeee[wbs];
$id_valvola = $rigaeee[id_valvola];
$id_cappellotto = $rigaeee[id_cappellotto];
}

switch($lingua) {
case "it":
$titolo_scheda = "Scheda prodotto";
break;
case "en":
$titolo_scheda = "Product sheet";
break;
}

$sqlq = "SELECT DISTINCT categoria1_it FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
if ($rigaq[categoria1_it] == $categoria1_it) {
$blocco_cat1_it .= "<option selected value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_it])."</option>";
} else {
$blocco_cat1_it .= "<option value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_it])."</option>";
}
}
$sqlr = "SELECT DISTINCT categoria2_it FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigar = mysql_fetch_array($risultr)) {
if ($rigar[categoria2_it] == $categoria2_it) {
$blocco_cat2_it .= "<option selected value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_it])."</option>";
} else {
$blocco_cat2_it .= "<option value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_it])."</option>";
}
}
$ssls = "SELECT DISTINCT categoria3_it FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risults = mysql_query($ssls) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigas = mysql_fetch_array($risults)) {
if ($rigas[categoria3_it] == $categoria3_it) {
$blocco_cat3_it .= "<option selected value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_it])."</option>";
} else {
$blocco_cat3_it .= "<option value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_it])."</option>";
}
}
$stlt = "SELECT DISTINCT categoria4_it FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultt = mysql_query($stlt) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigat = mysql_fetch_array($risultt)) {
if ($rigat[categoria4_it] == $categoria4_it) {
$blocco_cat4_it .= "<option selected value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_it])."</option>";
} else {
$blocco_cat4_it .= "<option value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_it])."</option>";
}
}




$sqlq = "SELECT DISTINCT categoria1_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigaq = mysql_fetch_array($risultq)) {
if ($rigaq[categoria1_en] == $categoria1_en) {
$blocco_cat1_en .= "<option selected value=".$rigaq[categoria1_en].">".str_replace("_"," ",$rigaq[categoria1_en])."</option>";
} else {
$blocco_cat1_en .= "<option value=".$rigaq[categoria1_en].">".str_replace("_"," ",$rigaq[categoria1_en])."</option>";
}
}
$sqlr = "SELECT DISTINCT categoria2_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigar = mysql_fetch_array($risultr)) {
if ($rigar[categoria2_en] == $categoria2_en) {
$blocco_cat2_en .= "<option selected value=".$rigar[categoria2_en].">".str_replace("_"," ",$rigar[categoria2_en])."</option>";
} else {
$blocco_cat2_en .= "<option value=".$rigar[categoria2_en].">".str_replace("_"," ",$rigar[categoria2_en])."</option>";
}
}
$ssls = "SELECT DISTINCT categoria3_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risults = mysql_query($ssls) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rigas = mysql_fetch_array($risults)) {
if ($rigas[categoria3_en] == $categoria3_en) {
$blocco_cat3_en .= "<option selected value=".$rigas[categoria3_en].">".str_replace("_"," ",$rigas[categoria3_en])."</option>";
} else {
$blocco_cat3_en .= "<option value=".$rigas[categoria3_en].">".str_replace("_"," ",$rigas[categoria3_en])."</option>";
}
}
$stlt = "SELECT DISTINCT categoria4_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultt = mysql_query($stlt) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigat = mysql_fetch_array($risultt)) {
if ($rigat[categoria4_en] == $categoria4_en) {
$blocco_cat4_en .= "<option selected value=".$rigat[categoria4_en].">".str_replace("_"," ",$rigat[categoria4_en])."</option>";
} else {
$blocco_cat4_en .= "<option value=".$rigat[categoria4_en].">".str_replace("_"," ",$rigat[categoria4_en])."</option>";
}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titolo_scheda; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<style type="text/css">
<!--
#main_container {
	width:800px;
	margin: auto;
	height: auto;
	overflow:hidden;
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
			switch($lingua) {
case "it":
echo "<a href=popup_scheda.php?mode=print&id=". $id."&negozio=".$negozio."&lang=".$lingua."><span class=Stile1>Stampa</span></a>";
$bottone_stampa = "btn_green_freccia_stampa_ita.png";
$bottone_chiudi = "btn_green_freccia_chiudi_ita.png";
break;
case "en":
echo "<a href=popup_scheda.php?mode=print&id=". $id."&negozio=".$negozio."&lang=".$lingua."><span class=Stile1>Print</span></a>";
$bottone_stampa = "btn_green_freccia_stampa_eng.png";
$bottone_chiudi = "btn_green_freccia_chiudi_eng.png";
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
<div id="main_container"><br>
<div class=titolo_scheda>
<?php
switch ($negozio) {
case "consumabili":
echo "<strong>".ucfirst($tasto_consumabili)." - ".str_replace("_"," ",$categoria1)."</strong>";
break;
case "spare_parts":
echo "<strong>".ucfirst($tasto_spare_parts)." - ".str_replace("_"," ",$categoria1)."</strong>";
break;
case "assets":
echo "<strong>".ucfirst($tasto_asset)." - ".str_replace("_"," ",$categoria1)."</strong>";
break;
case "labels":
echo "<strong>".ucfirst($tasto_labels)."</strong>";
break;
}
switch ($negozio) {
case "consumabili":
echo "<br>".$descrizione1;
break;
case "spare_parts":
echo "<br>".$descrizione1;
break;
case "labels":
echo "<br>".$descrizione1;
break;
case "assets":
if ($categoria2 != "") {
echo "<br>".str_replace("_"," ",$categoria2);
}
if ($categoria3 != "") {
echo " - ".str_replace("_"," ",$categoria3);
}
if ($categoria4 != "") {
echo " - ".str_replace("_"," ",$categoria4);
}
break;
}
echo "<br><br>";
echo "<img src=immagini/riga_prev_GREY.jpg width=760 height=1><br><br>";
?>
</div>
<div class=testo_scheda>
<?php
echo "<strong>".$codifica."</strong><br>";
echo $codice_art."<br>";
echo str_replace("_"," ",$categoria1)." - ".$paese."<br>";
if ($categoria2 != "") {
echo str_replace("_"," ",$categoria2)."<br>";
}
if ($categoria3 != "") {
echo str_replace("_"," ",$categoria3)."<br>";
}
if ($categoria4 != "") {
echo str_replace("_"," ",$categoria4)."<br>";
}
echo "<img src=immagini/spacer.gif width=20 height=10><br>";
echo "<strong>".$testata_descrizione."</strong><br>";
echo $descrizione2."<br>";
if ($descrizione3 != "") {
echo $descrizione3."<br>";
}
if ($descrizione4 != "") {
echo $descrizione4."<br>";
}
if ($id_valvola != "") {
$querys = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$id_valvola'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
echo "<br><strong>Valvola</strong><br>".stripslashes($rows[descrizione1_it])."<br>";
}
}
if ($id_cappellotto != "") {
$queryt = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$id_cappellotto'";
$resultt = mysql_query($queryt);
while ($rowt = mysql_fetch_array($resultt)) {
echo "<br><strong>Cappellotto</strong><br>".stripslashes($rowt[descrizione1_it])."<br>";
}
}
echo "<img src=immagini/spacer.gif width=20 height=10><br>";
if ($confezione != "") {
echo "<strong>".$testata_imballo."</strong><br>".$confezione;
}
//echo "<strong>modello: </strong>".$modello."<br>";
//echo "<strong>mercato: </strong>".$mercato."<br>";
//echo "<strong>prezzo: </strong>".number_format($prezzo,2,",",".")."<br>";
//echo "<strong>gruppo_merci: </strong>".$gruppo_merci."<br>";
?>
</div> 
<div class=contenitore_links_scheda>
 <div class=gallery_pdf_docs_scheda>
 
<!--  <span class="Stile1"><strong><?php //echo $crea_pdf; ?></strong></span><br>
  <img src="immagini/spacer.gif" width="20" height="10">
  <img src=immagini/riga_prev_GREY.jpg width=250 height=1>
  <img src="immagini/spacer.gif" width="20" height="10"><br>
-->  <?php
/*$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' ORDER BY precedenza ASC";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_img = mysql_num_rows($risultz);
if ($num_img > 0) {
$a = 1;
while ($rigaz = mysql_fetch_array($risultz)) {
if ($a == 1) {
  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[roadtrip]><span class=Stile5_gallery>".$gallery."</span></a> ";
} else {
  echo "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[roadtrip]><span class=Stile2_hidden>".$gallery."</span></a> ";
}
  $a = $a + 1;
}
}*/

$sqls = "SELECT * FROM qui_docs WHERE id_prodotto = '$codice_art' ORDER BY precedenza ASC";
$risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigas = mysql_fetch_array($risults)) {
echo $rigas[documento]."<br>";
echo "<img src=immagini/riga_prev_GREY.jpg width=120 height=1><br>";
}
if (($_SESSION[ruolo] == "buyer") OR ($_SESSION[ruolo] == "admin")) {
if ($num_img > 0) {
echo "<br><br>";
}
//SEZIONE PULSANTI MODIFICA/ELIMINA/DUPLICA
/*echo "<img src=immagini/riga_prev_GREY.jpg width=120 height=1><br>";
echo "<a href=popup_modal_elimina_prodotto.php?avviso=elimina_prodotto&id_prod=".$id."&negozio=".$negozio."&lang=".$lingua."><span class=Stile3>".$delete."</span></a>";
echo "<img src=immagini/spacer.gif width=120 height=5>";
echo "<img src=immagini/riga_prev_GREY.jpg width=120 height=1><br>";
echo "<a href=popup_modifica_scheda.php?action=edit&id=".$id."&negozio=".$negozio."&lang=".$lingua."><span class=Stile3>".$edit."</span></a>";
echo "<img src=immagini/spacer.gif width=120 height=5>";
echo "<img src=immagini/riga_prev_GREY.jpg width=120 height=1><br>";
echo "<a href=popup_modifica_scheda.php?action=duplicate&id=".$id."&negozio=".$negozio."&lang=".$lingua."><span class=Stile3>".$duplicate."</span></a>";
*/
}
  ?>
</div> 
  </div>
 
<div class=immagine id="immagine">
<?php
if ($categoria1 == "Bombole") {
// Read the image
//$fondo = new Imagick("componenti/fondo.png");
$corpo = new Imagick("componenti/bombole/".str_replace(" ","_",$descrizione3_it).".png");
$ogiva = new Imagick("componenti/ogiva/".str_replace(" ","_",$descrizione4_it).".png");
$valvola = new Imagick("componenti/valvola/".str_replace(" ","_",$id_valvola).".png");
if ($id_cappellotto != "") {
$cappellotto = new Imagick("componenti/cappellotto/".str_replace(" ","_",$id_cappellotto).".png");
}

// Clone the image and flip it 
$bombola = $corpo->clone();

// Composite i pezzi successivi sopra il fondo in questo ordine 
//$bombola->compositeImage($corpo, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($ogiva, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($valvola, imagick::COMPOSITE_OVER, 0, 0);
if ($id_cappellotto != "") {
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
				echo "<img src=".$nomefile." width=300 height=300>";
} else {
if ($foto != "") {
		    list($width, $height, $type, $attr) = getimagesize("files/".$foto);
			$larg = 300;
			$rapp = $larg/$width;
			$alt = $height * $rapp;
  echo "<img src=files/".$foto." width=".$larg." height=".$alt.">";
}
}
  ?>
  </div>
</div>
</body>
</html>
