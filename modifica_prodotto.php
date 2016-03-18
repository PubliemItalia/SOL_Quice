<?php
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
$lingua = $_GET[lang];

$modifica_prodotto = $_POST[modifica_prodotto];
include "query.php";
if ($modifica_prodotto != "") {
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
echo "<form name=form1 method=post action=popup_modifica_scheda.php>";
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
$risulth = mysql_query($sqlh) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
$vecchio_cod_art = $rigah[codice_originale_duplicato];
}
include "elaborazione_immagini.php";
//$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione3_it = '$descrizione3_it_mod', descrizione4_it = '$descrizione4_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', descrizione3_en = '$descrizione3_en_mod', descrizione4_en = '$descrizione4_en_mod', prezzo = '$prezzo_mod', codice_art = '$codice_mod', confezione = '$confezione_mod', gruppo_merci = '$gruppo_merci_mod' WHERE id = '$id'";

//***********************************
//non si modifica più il codice art in quanto viene creato automaticamente
//per le valvole in particolare la descrizione4 non va modificata 
//in quanto contiene l'indicazione dei mercati multipli per l'appartenenza delle valvole
$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione3_it = '$descrizione3_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', descrizione3_en = '$descrizione3_en_mod', prezzo = '$prezzo_mod', confezione = '$confezione_mod', gruppo_merci = '$gruppo_merci_mod', wbs = '$wbs_mod' WHERE id = '$id'";
//$query = "UPDATE qui_prodotti_".$negozio." SET descrizione1_it = '$descrizione1_it_mod', descrizione2_it = '$descrizione2_it_mod', descrizione3_it = '$descrizione3_it_mod', descrizione4_it = '$descrizione4_it_mod', descrizione1_en = '$descrizione1_en_mod', descrizione2_en = '$descrizione2_en_mod', descrizione3_en = '$descrizione3_en_mod', descrizione4_en = '$descrizione4_en_mod', prezzo = '$prezzo_mod', confezione = '$confezione_mod', gruppo_merci = '$gruppo_merci_mod', wbs = '$wbs_mod' WHERE id = '$id'";
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
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
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
//fine modifica prodotto
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title></title>
<script type="text/javascript">

function redirectUser(){
window.location = "<?php echo $_SESSION[pagina]; ?>?id=<?php echo $id; ?>&categoria1=<?php echo $_SESSION[categoria1]; ?>&categoria2=<?php echo $_SESSION[categoria2]; ?>&categoria3=<?php echo $_SESSION[categoria3]; ?>&categoria4=<?php echo $_SESSION[categoria4]; ?>&negozio=<?php echo $negozio; ?>&lang=<?php echo $lingua; ?>";
}

    /*location.href = "http://10.171.1.176/quice_publiem/<?php echo $_SESSION[pagina]; ?>?id=<?php echo $id; ?>&categoria1=<?php echo $_SESSION[categoria1]; ?>&categoria2=<?php echo $_SESSION[categoria2]; ?>&categoria3=<?php echo $_SESSION[categoria3]; ?>&categoria4=<?php echo $_SESSION[categoria4]; ?>&negozio=<?php echo $negozio; ?>&lang=<?php echo $lingua; ?>";*/


</script>    
  </head>
<body onload="redirectUser();">

  </body>
</html>