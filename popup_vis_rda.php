<?php
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
include "funzioni.js";
include "functions.php";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id = $_GET[id];
$a = $_GET[a];
$report = $_GET[report];
if ($_GET['pers'] != "") {
$pers = $_GET['pers'];
} else {
$pers = $_POST['pers'];
}
//echo $_SERVER['HTTP_USER_AGENT'];
$browser = get_browser();
//print_r($browser);
$report = $_GET[report];
$negozio_rda = $_GET[negozio_rda];
$id_riga = $_GET[id_riga];
$id_prodotto = $_GET[id_prodotto];
$mode = $_GET[mode];
$modifica_quant = $_GET[modifica_quant];
$quant = $_GET[quant];
$ok_resp2 = $_GET[ok_resp2];
$ok_buyer = $_GET[ok_buyer];
$chiusura = $_GET[chiusura];
$lingua = $_GET[lang];
$lingua = $_SESSION[lang];
$textarea = levapar6($_GET['textarea']);
$conferma = $_GET['conferma'];
$conferma_nota = $_GET['conferma_nota'];
$ruolo_ins = $_GET['ruolo_ins'];
$check_buyer = $_GET['check_buyer'];
$modifica_quant = $_GET['modifica_quant'];
$change_status = $_GET['change_status'];
$deseleziona = $_GET['deseleziona'];
$nome_sessione = $_SESSION[nome];
if ($a == 1) {
$querys = "UPDATE qui_righe_rda SET quant_modifica = '' WHERE id_rda = '$id'";
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
if ($deseleziona == 1) {
$status_nuovo = 1;
} else {
$status_nuovo = 0;
}
//if ($deseleziona == 1 AND $change_status == 1) {
if ($change_status == 1) {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$status_nuovo' WHERE id_rda = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
if (isset($_GET['limit'])) {
$limit = $_GET['limit'];
} else {
$limit = $_POST['limit'];
}
if (isset($_GET['page'])) {
$page = $_GET['page'];
} else {
$page = $_POST['page'];
}

if (isset($_GET['modifica_quant'])) {
$queryx = "SELECT * FROM qui_righe_rda WHERE id = '$id_riga'";
$resultx = mysql_query($queryx);
while ($rowx = mysql_fetch_array($resultx)) {
$id_riga_rda = $rowx[id];
$id_carrello_riga_rda = $rowx[id_carrello];
$negozio_riga_rda = $rowx[negozio];
$id_unita_riga_rda = $rowx[id_unita];
$nome_unita_riga_rda = $rowx[nome_unita];
$categoria_riga_rda = $rowx[categoria];
$id_utente_riga_rda = $rowx[id_utente];
$id_resp_riga_rda = $rowx[id_resp];
$id_prodotto_riga_rda = $rowx[id_prodotto];
$codice_art_riga_rda = $rowx[codice_art];
$descrizione_riga_rda = $rowx[descrizione];
$confezione_riga_rda = $rowx[confezione];
$quant_riga_rda = $rowx[quant];
$prezzo_riga_rda = $rowx[prezzo];
$totale_riga_rda = $rowx[totale];
$data_inserimento_riga_rda = $rowx[data_inserimento];
$data_ultima_modifica_riga_rda = $rowx[data_ultima_modifica];
$data_chiusura = $rowx[data_chiusura];
$id_rda_riga_rda = $rowx[id_rda];
$stato_ordine_riga_rda = $rowx[stato_ordine];
$flag_buyer_riga_rda = $rowx[flag_buyer];
$flag_chiusura_riga_rda = $rowx[flag_chiusura];
$output_mode_riga_rda = $rowx[output_mode];
$file_sap_riga_rda = $rowx[file_sap];
}
switch ($negozio_rda) {
case "assets":
$queryb = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto'";
break;
case "consumabili":
$queryb = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto'";
break;
case "spare_parts":
$queryb = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto'";
break;
case "labels":
$queryb = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prodotto'";
break;
case "vivistore":
$queryb = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prodotto'";
break;
}
$resultb = mysql_query($queryb) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowb = mysql_fetch_array($resultb)) {
$prezzo_aggiornato = $rowb[prezzo];
}
$totale_aggiornato = $prezzo_aggiornato *$quant;
$query = "UPDATE qui_righe_rda SET quant = '$quant', totale = '$totale_aggiornato' WHERE id = '$id_riga'";
if (mysql_query($query)) {
$ok_modifica = 1;
//duplicazione della riga originale nella tabella righe_rda_originali_variate
$queryd = "INSERT INTO qui_righe_rda_originali_variate (id_riga_originale, id_carrello, negozio, id_unita, nome_unita, categoria, id_utente, id_resp, id_prodotto, codice_art, descrizione, confezione, quant, prezzo, totale, data_inserimento, data_ultima_modifica, id_rda, stato_ordine, flag_buyer, flag_chiusura, output_mode, file_sap) VALUES ('$id_riga_rda', '$id_carrello_riga_rda', '$negozio_riga_rda', '$id_unita_riga_rda', '$nome_unita_riga_rda', '$categoria_riga_rda', '$id_utente_riga_rda', '$id_resp_riga_rda', '$id_prodotto_riga_rda', '$codice_art_riga_rda', '$descrizione_riga_rda', '$confezione_riga_rda', '$quant_riga_rda', '$prezzo_riga_rda', '$totale_riga_rda', '$data_inserimento_riga_rda', '$data_ultima_modifica_riga_rda', '$id_rda_riga_rda', '$stato_ordine_riga_rda', '$flag_buyer_riga_rda', '$flag_chiusura_riga_rda', '$output_mode_riga_rda', '$file_sap_riga_rda')";
if (mysql_query($queryd)) {
} else {
echo "Errore durante l'inserimento2". mysql_error();
}
//fine duplicazione
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//inserimento nel LOG
$riepilogo = "modifica quant (".$quant.")riga RdA (".$id_riga.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $_SESSION['nome'];
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'righe_rda', '$id_riga', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

}

if ($check_buyer != "") {
$query = "UPDATE qui_righe_rda SET flag_buyer = '$check_buyer' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}

if ($conferma_nota != "") {
if ($ruolo_ins == "responsabile") {
$query = "UPDATE qui_rda SET note_resp = '$textarea', nome_resp = '$_SESSION[nome]' WHERE id = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
if ($ruolo_ins == "buyer") {
$query = "UPDATE qui_rda SET note_buyer = '$textarea', nome_buyer = '$_SESSION[nome]' WHERE id = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
}
//echo "lingua: ".$_SESSION[lang]."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
$id_utente = $_SESSION[user_id];
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$data_attuale = mktime();
if ($ok_buyer != "") {
$query = "UPDATE qui_rda SET stato = '3', data_output = '$data_attuale', buyer_output = '$id_utente' WHERE id = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//inserimento nel LOG
$riepilogo = "Output rda (".$id.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $_SESSION['nome'];
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}
if ($chiusura != "") {
$query = "UPDATE qui_rda SET stato = '4', data_chiusura = '$data_attuale', id_utente_chiusura = '$id_utente' WHERE id = '$id'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
//inserimento nel LOG
$riepilogo = "Chiusura rda (".$id.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $_SESSION['nome'];
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
}
if (isset($_GET['modifica_quant'])) {
switch ($negozio_rda) {
case "assets":
$queryb = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prod_riga'";
break;
case "consumabili":
$queryb = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prod_riga'";
break;
case "spare_parts":
$queryb = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prod_riga'";
break;
case "labels":
$queryb = "SELECT * FROM qui_prodotti_labels WHERE id = '$id_prod_riga'";
break;
case "vivistore":
$queryb = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prod_riga'";
break;
}
$resultb = mysql_query($queryb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rowb = mysql_fetch_array($resultb)) {
$prezzo_aggiornato = $rowb[prezzo];
}
$totale_aggiornato = $prezzo_aggiornato *$quant;
$query = "UPDATE qui_righe_rda SET quant = '$quant', totale = '$totale_aggiornato' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$riepilogo = "Modifica quant riga rda (".$id_rda.") utente ".$id_utente;
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$operatore = $_SESSION['nome'];
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riga, riepilogo) VALUES ('$operatore', '$datalogtx', '$datalog', 'rda', '', '$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

}

$sqleee = "SELECT * FROM qui_rda WHERE id = '$id'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
switch($lingua) {
case "it":
$descrizione = $rigaeee[descrizione_it];
break;
case "en":
$descrizione = $rigaeee[descrizione_en];
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
$id_rda = $rigaeee[id];
$negozio_rda = $rigaeee[negozio];
$nome_utente = $rigaeee[nome_utente];
$note_utente = $rigaeee[note_utente];
$id_utente_rda = $rigaeee[id_utente];
$id_resp_rda = $rigaeee[id_resp];
$note_resp = $rigaeee[note_resp];
$nome_resp = $rigaeee[nome_resp];
$buyer_chiusura = $rigaeee[buyer_chiusura];
$id_buyer = $rigaeee[buyer_output];
$note_buyer = $rigaeee[note_buyer];
$note_magazziniere = $rigaeee[note_magazziniere];
$data_inserimento = $rigaeee[data_inserimento];
$data_approvazione = $rigaeee[data_approvazione];
$data_output = $rigaeee[data_output];
$data_chiusura = $rigaeee[data_chiusura];
$data_ultima_modifica = $rigaeee[data_ultima_modifica];
$stato_rda = $rigaeee[stato];
}
$array_ordini = array();
	$queryb = "SELECT * FROM qui_ordini_for WHERE id_rda = '$id'";
	$resultb = mysql_query($queryb);
	$presenza_ordine = mysql_num_rows($resultb);
	if ($presenza_ordine > 0) {
		while ($rowb = mysql_fetch_array($resultb)) {
			$add_ordine = array_push($array_ordini,$rowb[id]);
		}
	}
//echo "<br>RdA: ".$id."<br>";
//echo "presenza_ordine: ".$presenza_ordine."<br>";
//print_r($array_ordini);
//echo "<br>";
include "traduzioni_interfaccia.php";
$array_buyers = array();
$queryh = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$resulth = mysql_query($queryh);
while ($rigah = mysql_fetch_array($resulth)) {
	if (!in_array($rigah[id_buyer],$array_buyers)) {
	  $add_buyer = array_push($array_buyers,$rigah[id_buyer]);
	}
}
if (!in_array("999",$array_buyers)) {
$sqlb = "SELECT * FROM qui_utenti WHERE user_id = '$array_buyers[0]'";
$risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigab = mysql_fetch_array($risultb)) {
$nome_buyer = $rigab[nome]." - ".$testo_info_buyer_rda;
}
} else {
$nome_buyer = $testo_info_buyer_rda;
}
if ($stato_rda == "4") {
$chiusura = $testo_info_chiusura_rda.$chiusura_sistema_rda;
}
//echo "array buyers: ";
//print_r($array_buyers);
//echo "<br>";
//condizioni per evitare errori
if((!$limit) OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 25; //default
 } 

if((!$page) OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
      $page = 1; //default
 } 
//determino quanti sono in tutto gli articoli trovati nell'rda
//non mi interessa l'ordinamento, che viene stabilito più sotto
$queryb = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$resultb = mysql_query($queryb);
$total_items = mysql_num_rows($resultb);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);

/*echo "user id: ".$_SESSION[user_id]."<br>";
echo "total_items: ".$total_items."<br>";
echo "total_pages: ".$total_pages."<br>";
echo "set_limit: ".$set_limit."<br>";
*/

if ($_GET['ordinamento'] != "") {
$ordinamento = $_GET['ordinamento'];
} else {
$ordinamento = "data_inserimento ASC";
}
//recupero gli importi delle righe della rda e aggiorno il totale nella tabella rda
$queryd = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$resultd = mysql_query($queryd) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowd = mysql_fetch_array($resultd)) {
$importo_rda = $importo_rda + $rowd[totale];
}
$tot_rda_aggiornato = $importo_rda + $totale_aggiornato;
$querys = "UPDATE qui_rda SET totale_rda = '$tot_rda_aggiornato' WHERE id = '$id'";
if (mysql_query($querys)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
$querye = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id'";
$resulte = mysql_query($querye) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
$righe_totali = mysql_num_rows($resulte);
$queryn = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND flag_buyer > '0' AND output_mode = ''";
$resultn = mysql_query($queryn) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
$righe_attive_totali = mysql_num_rows($resultn);
//echo "righe_attive_totali: ".$righe_attive_totali."<br>";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dettaglio RdA <?php echo $id_rda; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<style type="text/css">
<!--
#lingua_scheda {
	width:930px;
	margin: auto;
	background-color: #727272;
	margin-bottom: 10px;
	color: #FFFFFF;
	height: 20px;
	font-weight: bold;
}
#main_container {
	width:930px;
	margin: auto;
}
body {
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
}
.btnFreccia a {
    background: url("immagini/btn_green_freccia_120x19.jpg") no-repeat scroll 0 0 transparent;
    color: #fff;
    cursor: pointer;
    display: block;
    height: 19px;
    line-height: 19px;
    text-align: left;
    width: 117px;
    padding-left: 3px;
	float:left;
}
.forn {
    height: 100px;
    text-align: left;
    width: 235px;
    padding-left: 3px;
	float:left;
}
.btnFreccia a:hover {
    background: url("immagini/btn_green_freccia_120x19.jpg") no-repeat scroll 0 -29px transparent;
}
.casella_input {
	font-size: 10px;
	font-family: Arial, Helvetica, sans-serif;
}
.sfondoRigaColor{
	background-color:#F0F0F0;
	width:100%;
	height:auto;
	padding:5px 0px;
	margin-bottom:5px;
	float:left;
	color:#000;
	
}
.sfondoRigaColor:hover{
	background: #b8e3f6;
}
.sfondoRigaBianco{
	background-color:#FFF;
	width:100%;
	height:auto;
	padding:5px 0px;
	margin-bottom:5px;
	float:left;
	color:#000;
}
.sfondoRigaBianco:hover{
	background: #b8e3f6;
}
.cont_generale{
	background-color:#FFF;
	width:100%;
	height:20px;
	margin-top:15px;
	margin-bottom:5px;
	float:left;
	color:#000;
}

-->
</style>
<script language="javascript">
<!--

function controllo(){
var valore = document.form1.textarea.value;
if(valore=="Note")
   document.form1.textarea.value = "";
}


//-->
</script>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
function controllo(){
with(document.carrello) {
	
if(quant.value=="0") {
alert("Errore: 0 non è un valore accettabile. In alternativa cancellare la riga");
quant.focus();
return false;
}
}
return true
 }
<!-- Fine script per campi obbligatori Form -->
</script>
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<script type="text/javascript">
function refreshParent() {
  window.parent.location.href = window.parent.location.href;

  if (window.parent.progressWindow)
		
 {
    window.parent.progressWindow.close()
  }
/*window.close();*/
}
</script>
<script>
function changetitle()
{
/*alert(window.document.title);*/
window.document.statusbar.enable = false;
window.document.titlebar.enable = false;
window.document.addressbar.enable = false;
}
</script>
	<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<SCRIPT type="text/javascript">
function closeJS(){
//alert('closed')
  /*window.location.href = window.location.href;*/
  location.href = "popup_vis_rda.php?id=<?php echo $id; ?>&lang=<?php echo $lingua; ?>";

}
</SCRIPT>
</head>
<?php
if ($ok_resp2 != "") {
echo "<body onLoad=\"TINY.box.show({iframe:'popup_notifica_rda_processata.php?avviso=ok_resp2&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=". $lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
} else {
if ($mode == "print") {
echo "<body onLoad=\"javascript:window.print()\">";
} else {
//echo '<body onUnload="refreshParent();">';
echo '<body>';
}
}
?>
<div id="lingua_scheda">
  <div style="width:810px; height:15px; float:left;">
  </div>
  <div style="width:100px; height:15px; text-align:right; float:left; padding-right:20px;">
    <form name="form1" method="get" action="popup_vis_rda.php">
    <?php
    if ($mode == "print") {
    } else {
      switch($lingua) {
        case "it":
          if ($pers != "") {
            echo "<a href=popup_vis_rda.php?mode=print&id=". $id."&negozio_rda=".$negozio_rda."lang=".$lingua."><span class=Stile1>Stampa</span></a>";
          } else {
            echo "<a href=stampa_rda.php?id_rda=".$id."&mode=print&lang=".$lingua."><span class=Stile1>Stampa</span></a>";
          }
          $bottone_stampa = "btn_green_freccia_stampa_ita.png";
          $bottone_chiudi = "btn_green_freccia_chiudi_ita.png";
        break;
        case "en":
          if ($pers != "") {
            echo "<a href=popup_vis_rda.php?mode=print&id=". $id."&negozio_rda=".$negozio_rda."lang=".$lingua."><span class=Stile1>Print</span></a>";
          } else {
            echo "<a href=packing_list.php?id=".$id."&mode=print&lang=".$lingua."><span class=Stile1>Print</span></a>";
          }
          $bottone_stampa = "btn_green_freccia_stampa_eng.png";
          $bottone_chiudi = "btn_green_freccia_chiudi_eng.png";
        break;
      }
    }
    ?>
    </form>
  </div>
</div>
<!--fine lingua scheda-->
<div id="main_container">
  <!--indicazione RdA-->
  <div style="width:100%; height:30px; float:left; margin-top:20px;">
    <span class="titolo_scheda"><?php echo "<span style=\"font-size:16px; color:rgb(0,0,0);\"><strong>RdA ".$id_rda."</strong></span>"; ?></span>
  </div>
  <!--testata-->
  <div class="format_testata" style="width:100%; height:20px; float:left; background-color:#8e8e8e; padding-top:5px;">
    <div style="width:70px; height:auto; float:left; margin-left:10px;">
	  <?php echo $testata_codice; ?>
    </div>
    <div style="width:70px; min-height: 20px; overflow:hidden; height:auto; float:left;">
	  <?php echo $testata_nazione; ?>
    </div>
    <div style="width:270px; min-height: 20px; overflow:hidden; height:auto; float:left;">
	  <?php echo $testata_descrizione; ?>
    </div>
    <div style="width:80px; min-height: 20px; overflow:hidden; height:auto; float:left; text-align:center;">
	  <?php echo $testata_imballo; ?>
    </div>
    <div style="width:80px; min-height: 20px; overflow:hidden; height:auto; float:left; text-align:center;">
	  <?php echo $testata_prezzo; ?>
    </div>
    <div style="width:80px; min-height: 20px; overflow:hidden; height:auto; float:left;">
	  <?php echo $testata_quant; ?>
    </div>
    <div style="width:60px; min-height: 20px; overflow:hidden; height:auto; float:left;">
	  <?php echo $testata_ordine; ?>
    </div>
    <div style="width:80px; min-height: 20px; overflow:hidden; height:auto; float:left;">
	  <?php echo $testata_totale; ?>
    </div>
    <div style="width:60px; min-height: 20px; overflow:hidden; height:auto; float:left;">
	  <?php
      if ($_SESSION[ruolo] == "buyer") {
	  if ($report != 1) {
		if (!isset($deseleziona)) {
		  echo "<a href=popup_vis_rda.php?deseleziona=1&limit=".$limit."&page=".$page."&id=".$id."&change_status=1>".$deseleziona_tutto."</a>";
		} else {
		  if ($deseleziona == "") {
			echo "<a href=popup_vis_rda.php?deseleziona=1&limit=".$limit."&page=".$page."&id=".$id."&change_status=1>".$deseleziona_tutto."</a>";
		  } else {
			echo "<a href=popup_vis_rda.php?deseleziona=&limit=".$limit."&page=".$page."&id=".$id."&change_status=1>".$seleziona_tutto."</a>";
		  }
		}
	  }
      }
	  ?>
    </div>
  </div>
  <?php
  if ($id != "") {
	//script di aggiornamento
	$queryc = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' ORDER BY ".$ordinamento;
	$resultc = mysql_query($queryc);
	while ($rowc = mysql_fetch_array($resultc)) {
	  $id_riga = $rowc[id];
	  $id_prod_riga = $rowc[id_prodotto];
	  $codice_art_riga = $rowc[codice_art];
	  $quant_riga = $rowc[quant];
	} 

	$queryb = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE id_rda = '$id'";
	$resultb = mysql_query($queryb);
	list($somma) = mysql_fetch_array($resultb);
	$totale_rda = $somma;
  }
  $array_date_chiusura = array();
  //$querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
  $querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' ORDER BY ".$ordinamento;
  $sf = 1;
  //inizia il corpo della tabella
  $result = mysql_query($querya);
  while ($row = mysql_fetch_array($result)) {
	  $id_prodotto = "";
	$tot = $tot + 1;
	$data_leggibile = date("d.m.Y",$row[data]);
	$id_prod_riga = $row[id_prodotto];
	$codice_art_riga = $row[codice_art];
	$descrizione_prodotto = $row[descrizione];
	if ($row[stato_ordine == 4]) {
	  $add_data = array_push($array_date_chiusura,$row[data_ultima_modifica]);
	}
	switch ($negozio_rda) {
	  case "assets":
		$queryc = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$codice_art_riga'";
	  break;
	  case "consumabili":
		$queryc = "SELECT * FROM qui_prodotti_consumabili WHERE codice_art = '$codice_art_riga'";
	  break;
	  case "spare_parts":
		$queryc = "SELECT * FROM qui_prodotti_spare_parts WHERE codice_art = '$codice_art_riga'";
	  break;
	  case "labels":
		$queryc = "SELECT * FROM qui_prodotti_labels WHERE codice_art = '$codice_art_riga'";
	  break;
	  case "vivistore":
		$queryc = "SELECT * FROM qui_prodotti_vivistore WHERE codice_art = '$codice_art_riga'";
	  break;
	}

	$resultc = mysql_query($queryc);
	while ($rowc = mysql_fetch_array($resultc)) {
	  $id_prodotto = $rowc[codice_art];
	  $nazione_prodotto = $rowc[paese];
/*	  switch($lingua) {
		case "it":
		  $descrizione_prodotto = $rowc[descrizione1_it];
		break;
		case "en":
		  $descrizione_prodotto = $rowc[descrizione1_en];
		  $descrizione_ita = $rowc[descrizione1_it];
		break;
		case "fr":
		  $descrizione_prodotto = $rowc[descrizione1_fr];
		break;
		case "de":
		  $descrizione_prodotto = $rowc[descrizione1_de];
		break;
		case "es":
		  $descrizione_prodotto = $rowc[descrizione1_es];
		break;
	  }
*/	  if ($row[negozio] == "labels") {
		$descrizione_prodotto .= " - ".$rowc[categoria4_it];
		$descrizione_ita .= " - ".$rowc[categoria4_it];
	  }
	  $prezzo_prodotto = $rowc[prezzo];
	  $confezione_prodotto = $rowc[confezione];
	}
	if ($row[negozio] == "labels") {
	  $confezione_prodotto = "";
	  $id_prodotto = $row[codice_art];
	  $prezzo_prodotto = "";
	  //echo "ord stamp: ".$ord_stamp."<br>";
	  $totale_art = $row[totale];
	}
	
	//echo "<form name=carrello method=get action=popup_vis_rda.php#".$row[id].">";
	if ($sf == 1) {
	  echo "<div class=sfondoRigaColor>";
	} else {
	  echo "<div class=sfondoRigaBianco>";
	}
  echo "<div style=\"width:70px; height:auto; float:left; margin-left:10px;\">";
	if (substr($id_prodotto,0,1) != "*") {
	  echo $id_prodotto;
	} else {
	  echo substr($id_prodotto,1);
	}
  echo "</div>";
  echo "<div style=\"width:70px; height:20px; float:left;\">";
	echo $nazione_prodotto;
  echo "</div>";
  echo '<div style="width:270px; height:auto; float:left;">';
	if (strlen($descrizione_prodotto) < 3) {
	  echo $descrizione_ita." <strong>(da tradurre)</strong>";
	} else {
	  echo $descrizione_prodotto;
	}
	//echo $descrizione_prodotto;
	$descrizione_prodotto = "";
	$descr_ita = "";
  echo '</div>';
  echo '<div style="width:80px; height:20px; float:left; text-align: center;">';
	echo $confezione_prodotto;
  echo '</div>';
  echo '<div style="width:80px; height:20px; float:left; text-align: center;">';
    echo number_format($prezzo_prodotto,2,",","");
  echo '</div>';
  echo '<div style="width:60px; height:auto; float:left;">';
	echo '<form name="carrello" method="get" action="popup_vis_rda.php" onSubmit="return controllo();">';
	switch ($_SESSION[ruolo]) {
	  case "utente":
		echo '<div id="q_'.$tot.'" style="width:60px; text-align:center;">';
		  echo number_format($row[quant],0,",",".");
		echo '</div>';
	  break;
	  case "responsabile":
		if ($row[negozio] != "labels") {
		  if ($row[stato_ordine] == 1) {
			//echo "<input name=quant type=text class=tabelle8 id=quant size=3 maxlength=8 onkeypress = \"return ctrl_solo_num(event)\" value=".number_format($row[quant],0,",","").">";
			echo '<div id="q_'.$tot.'" style="width:60px; text-align:center;">';
			echo '<input name="'.$tot.'" type="text" class="casella_input" id="c_'.$tot.'" style="text-align:right;" size="4" maxlength="4" onkeypress="return ctrl_solo_num(event)" onKeyUp="axc('.$row[id].',this.value,'.$tot.');" onBlur="ripristinaquantriga('.$row[id].','.$tot.')"';
			if ($row[quant_modifica] != "") {
			echo " value=".number_format($row[quant_modifica],0,",","");
			} else {
			echo " value=".number_format($row[quant],0,",","");
			}
			echo ">";
			echo "</div>";
			//echo "<input type=submit name=button id=button value=OK>";
			echo "<input name=lang type=hidden id=lang value=".$lingua.">";
			echo "<input name=id type=hidden id=id value=".$id.">";
			echo "<input name=id_prodotto type=hidden id=id_prodotto value=".$row[id_prodotto].">";
			echo "<input name=negozio_rda type=hidden id=negozio_rda value=".$row[negozio].">";
			echo "<input name=id_riga type=hidden id=id_riga value=".$row[id].">";
			echo "<input name=modifica_quant type=hidden id=modifica_quant value=1>";
			echo "<input name=limit type=hidden id=limit value=".$limit.">";
			echo "<input name=page type=hidden id=page value=".$page.">";
			} else {
			echo '<div id="q_'.$tot.'" style="width:60px; text-align:center;">';
			echo number_format($row[quant],0,",",".");
			echo "</div>";
			}
		  } else {
			echo '<div id="q_'.$tot.'" style="width:60px; text-align:center;">';
			echo number_format($row[quant],0,",",".");
			echo "</div>";
		}
	  break;
	  case "buyer":
		if ($row[negozio] != "labels") {
		if ($row[stato_ordine] < 3) {
		//echo "<input name=quant type=text class=tabelle8 id=quant size=5 maxlength=8 onkeypress = \"return ctrl_solo_num(event)\" onBlur=\"this.form.submit()\" value=".number_format($row[quant],0,",","").">";
		echo '<div id="q_'.$tot.'" style="width:60px; text-align:center;">';
		echo '<input name='.$tot.' type="text" class="casella_input" id="c_'.$tot.'" size="4" maxlength="4" onkeypress="return ctrl_solo_num(event)" onKeyUp="axc('.$row[id].',this.value,'.$tot.');" onBlur="ripristinaquantriga('.$row[id].','.$tot.')"';
		if ($row[quant_modifica] != "") {
		echo " value=".number_format($row[quant_modifica],0,",","");
		} else {
		echo " value=".number_format($row[quant],0,",","");
		}
		echo ">";
		echo "</div>";
		//echo "<input name=quant type=text class=tabelle8 id=quant size=3 maxlength=8 onkeypress = \"return ctrl_solo_num(event)\" value=".number_format($row[quant],0,",","").">";
		//echo "<input type=submit name=button id=button value=OK>";
		echo "<input name=lang type=hidden id=lang value=".$lingua.">";
		echo "<input name=id type=hidden id=id value=".$id.">";
		echo "<input name=id_prodotto type=hidden id=id_prodotto value=".$row[id_prodotto].">";
		echo "<input name=negozio_rda type=hidden id=negozio_rda value=".$row[negozio].">";
		echo "<input name=id_riga type=hidden id=id_riga value=".$row[id].">";
		echo "<input name=modifica_quant type=hidden id=modifica_quant value=1>";
		echo "<input name=limit type=hidden id=limit value=".$limit.">";
		echo "<input name=page type=hidden id=page value=".$page.">";
		} else {
		echo '<div id="q_'.$tot.'" style="width:60px; text-align:center;">';
		echo number_format($row[quant],0,",",".");
		echo "</div>";
		}
		} else {
		echo '<div id="q_'.$tot.'" style="width:60px; text-align:center;">';
		echo number_format($row[quant],0,",",".");
		echo "</div>";
		}
	  break;
	}
	echo "</form>"; 
  echo '</div>';
  echo '<div style="width:60px; min-height: 20px; overflow: hidden; height:auto; float:left;">';
	echo "<div id=avvisi_".$tot.">";
	if ($row[quant_modifica] != "") {
	  if ($row[quant_modifica] == 0) {
		echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$row[id]."&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><span title=\"$elimina_articolo\" style=\"color:red;\">Rimuovere</span></a>";
	  } else {
		echo '<a href="javascript:void(0);" onClick="total_general('.$row[id].','.$tot.')"><span style="color:green !important; text-decoration:none;">Aggiorna</span></a>';
	  }
	}
	echo '</div>';
  echo '</div>';
  echo '<div style="width:50px; height:auto; float:left; text-align:right; margin-right:10px;">';
	echo "<div id=tot_".$tot.">";
	  echo number_format($row[totale],2,",","");
	echo '</div>';
  echo '</div>';
  echo '<div style="width:30px; min-height: 20px; overflow: hidden; height:auto; float:left;">';
	if ($_SESSION[ruolo] == "buyer") {
	if ($report != 1) {
	if ($row[output_mode] != "") {
	//echo "<input name=check_buyer type=radio disabled checked value=0>";
	//echo "<input name=check_buyer type=checkbox disabled value=1 checked>";
	} else {
	echo "<form name=elem_rda method=get action=popup_vis_rda.php>";
	echo "<input name=limit type=hidden id=limit value=".$limit.">";
	echo "<input name=page type=hidden id=page value=".$page.">";
	switch ($row[flag_buyer]) {
	case "0":
	//echo "<input name=check_buyer type=checkbox value=1>";
	echo "<input name=check_buyer type=radio onClick=\"this.form.submit()\" value=1 title=\"".$seleziona_radio."\">";
	break;
	case "1":
	//echo "<input name=check_buyer type=checkbox value=0 checked>";
	echo "<input name=check_buyer type=radio onClick=\"this.form.submit()\" value=0 checked title=\"".$annulla_radio."\">";
	break;
	}
	if ($row[flag_buyer] > 0) {
	$contatoreXPulsante = $contatoreXPulsante+1;
	}
	echo "<input name=id_riga type=hidden id=id_riga value=".$row[id].">";
	echo "<input name=id type=hidden id=id value=".$id.">";
	
	//echo "<input name=aggiorna_flag_buyer type=hidden id=aggiorna_flag_buyer value=1>";
	echo "</form>";
	}
	}
	}	
  echo '</div>';
  echo '<div style="width:auto; height:20px; float:left;">';
	echo $row[output_mode];
	switch ($row[output_mode]) {
		case "mag":
	if ($row[evaso_magazzino] == 1) {
		echo " evaso";
	}
		break;
		case "sap":
	if ($row[flag_chiusura] == 1) {
		echo " evaso";
	}
		break;
	}
  echo '</div>';
  echo '<div class="sel_all_riga" style="width:auto; padding:3px 10px 0px 10px; float: right;">';
  //echo 'neg: '.$rigan[negozio].'<br>';
  if ($row[azienda_prodotto] == "VIVISOL") {
	echo '<img src="immagini/bottone-vivisol.png">';
  }
  if ($row[azienda_prodotto] == "SOL") {
	echo '<img src="immagini/bottone-sol.png">';
  }
  echo "</div>";
  echo '<div style="width:50px; height:20px; float:right; text-align:right; margin:3px 20px 0px 5px;">';
	switch ($_SESSION[ruolo]) {
	case "utente":
	if ($row[stato_ordine] == 1) {
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$row[id]."&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
	} else {
		if ($row[ord_fornitore] != "") {
		echo "Ord ".stripslashes($row[fornitore_tx])." ".$row[ord_fornitore];
		} else {
		  if ($row[data_ultima_modifica] > 10000) {
			echo date("d.m.Y",$row[data_ultima_modifica]);
		  }
		}
	}
	break;
	case "responsabile":
	if ($row[stato_ordine] == 1) {
	//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$row[id]."&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop2',400,140);\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
	
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$row[id]."&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:190,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
	} else {
		if ($row[ord_fornitore] != "") {
		echo "Ord ".stripslashes($row[fornitore_tx])." ".$row[ord_fornitore];
		} else {
		  if ($row[data_ultima_modifica] > 10000) {
			echo date("d.m.Y",$row[data_ultima_modifica]);
		  }
		}
	}
	break;
	case "buyer":
	if ($row[stato_ordine] < 3) {
	//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$row[id]."&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop2',400,140);\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
	echo "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$row[id]."&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
	} else {
		if ($row[ord_fornitore] != "") {
		echo "Ord ".stripslashes($row[fornitore_tx])." ".$row[ord_fornitore];
		} else {
		  if ($row[data_ultima_modifica] > 10000) {
			echo date("d.m.Y",$row[data_ultima_modifica]);
		  }
		}
	}
	break;
	}
  echo "</div>";
echo "</div>";

  if ($sf == 1) {
  $sf = $sf + 1;
  } else {
  $sf = 1;
  }
  }
  if ($id != "") {
	echo '<div class="sfondoRigaColor" style="background-color=#FFFFCC;">';
	  echo '<div style="width:650px; height:auto; float:left;">';
		echo '<span class="noteRda" style="font-size:16px;"><strong>'.$testo_totale_rda.'</strong></span>';
	  echo '</div>';
		echo '<div id="tot_gen" class="noteRda" style="width:100px; height:auto; float:left;font-size:16px; text-align:right;">';
		echo '<strong>'.number_format($totale_rda,2,",","").'</strong>';
		echo '</div>';
	echo '</div>'; 
  }
switch ($_SESSION[lang]) {
	case "it":
	$testo_alert = "Il valore della quantità non può essere zero. In alternativa cancellare la riga!";
	break;
	case "en":
	$testo_alert = "The quantity cannot be zero. Alternatively delete this row!";
	break;
}
 ?>
  <div style="width:100%; height:auto; float:left; border-bottom:1px solid rgb(0,0,0); border-top:1px solid rgb(0,0,0); margin-top:10px;">
    <div style="width:250px; height:auto; float:left; padding-top:10px; margin-right:10px;">
	  <?php
		$querym = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' AND stato_ordine = '4' ORDER BY data_ultima_modifica ASC";
		$resultm = mysql_query($querym);
		$righe_evase = mysql_num_rows($resultm);
		while ($rowm = mysql_fetch_array($resultm)) {
		  $data_ultima_modifica = $rowm[data_ultima_modifica];
		  if ($rowm[data_chiusura] > 0) {
				$data_chiusura = $rowm[data_chiusura];
		  }
		}
		$queryn = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' ORDER BY data_ultima_modifica DESC";
		$resultn = mysql_query($queryn);
		$righe_totali_rda = mysql_num_rows($resultn);
		  echo "<div style=\"width:90%; height:auto; float:left; margin-top:7px;\">";
		   echo "<span class=noteRda><strong>".date("d.m.Y - H:i:s",$data_inserimento)."</strong><br>".stripslashes($nome_utente)." - ".$testo_info_utente_rda."</span>";
		  echo "</div>"; 
		  echo "<div style=\"width:90%; height:auto; float:left; margin-top:7px;\">";
	if ($data_approvazione > 0) {
		   echo "<span class=noteRda><strong>".date("d.m.Y - H:i:s",$data_approvazione)."</strong><br>".stripslashes($nome_resp)." - ".$testo_info_resp_rda."</span>";
		  } else {
	if ($id_utente_rda == $id_resp_rda) {
		   echo "<span class=noteRda><strong>".date("d.m.Y - H:i:s",$data_inserimento)."</strong><br>".stripslashes($nome_utente)." - ".$testo_info_resp_rda."</span>";
		}
	}
		  echo "</div>"; 
	if ($data_output > 0) {
		  echo "<div style=\"width:90%; height:auto; float:left; margin-top:7px;\">";
		   echo "<span class=noteRda><strong>".date("d.m.Y - H:i:s",$data_output)."</strong><br>".stripslashes($nome_buyer)."</span>";
		  echo "</div>"; 
	}
	//if (count($array_ordini) > 0) {
	  foreach($array_ordini as $sing_ordine) {
		$queryb = "SELECT * FROM qui_ordini_for WHERE id = '$sing_ordine'";
		$resultb = mysql_query($queryb);
		while ($rowb = mysql_fetch_array($resultb)) {
		  echo "<div style=\"width:90%; height:auto; float:left; margin-bottom:15px;\">";
		 echo "<span class=noteRda>Ordine n. ".$sing_ordine." del ".date("d/m/Y",$rowb[data_ordine])."</span>";
		  echo "</div>"; 
		}
	  }
	//}
	
	if ($righe_totali_rda == $righe_evase) {
		if ($data_chiusura > 0) {
			$data_finale = $data_chiusura;
		} else {
			$data_finale = $data_ultima_modifica;
		}
		  echo "<div style=\"width:90%; height:auto; float:left; margin-top:7px; margin-bottom:15px;\">";
		   echo "<span class=noteRda><strong>".date("d.m.Y - H:i:s",$data_finale)."</strong><br>".$rda_chiusa."</span>";
		  echo "</div>"; 
	} else {
		  echo "<div style=\"width:90%; height:auto; float:left; margin-top:7px; margin-bottom:15px;\">";
		   echo "<span class=noteRda>".$rda_attesa_chiusura."</span>";
		  echo "</div>"; 
	}
       ?>
    
    </div>
    <!--COLONNA CON AREA PER SCRIVERE NOTE-->
      <div style="width:225px; height:auto; float:left; margin:10px 10px 0px 0px;">
           <form name=form1 method=get action=popup_vis_rda.php>
            <?php
            if ($report != 1) {
            switch ($_SESSION[ruolo]) {
            case "responsabile":
            if ($stato_rda == 1) {
            if ($note_resp != "") {
  //        echo "<textarea name=textarea style=width:480px; rows=5 class=tabelle8 id=textarea onBlur=\"this.form.submit()\">".str_replace("<br>","\n",$note_resp)."</textarea>";
          echo '<textarea name="textarea" rows="5" style="width:225px;" class="tabelle8" id="textarea" onBlur="this.form.submit()">'.str_replace("<br>","\n",$note_resp).'</textarea>';
          } else {
     echo '<textarea name="textarea" rows="5" style="width:225px;" class="tabelle8" id="textarea" onClick="controllo()" onBlur="this.form.submit()">Note</textarea>';
          }
  
            echo "<input type=hidden name=id id=id value=".$id.">";
              echo "<input type=hidden name=id_utente id=id_utente value=".$id_utente.">";
              echo "<input type=hidden name=ruolo_ins id=ruolo_ins value=responsabile>";
              echo "<input name=lang type=hidden id=lang value=".$lingua.">";
              echo "<input name=conferma_nota type=hidden id=conferma_nota value=1>";
            }
            break;
            case "buyer":
            if ($stato_rda <= 3) {
                  if ($note_buyer != "") {
          echo '<textarea name="textarea" style="width:225px;" rows="5" class="tabelle8" id="textarea" onBlur="this.form.submit()">'.str_replace("<br>","\n",$note_buyer).'</textarea>';
          } else {
     echo '<textarea name="textarea" style="width:225px;" rows="5" class="tabelle8" id="textarea"  onClick="controllo()" onBlur="this.form.submit()">Note</textarea>';
          }
            echo "<input type=hidden name=id id=id value=".$id.">";
              echo "<input type=hidden name=id_utente id=id_utente value=".$id_utente.">";
              echo "<input type=hidden name=ruolo_ins id=ruolo_ins value=buyer>";
              echo "<input name=lang type=hidden id=lang value=".$lingua.">";
              echo "<input name=conferma_nota type=hidden id=conferma_nota value=1>";
            }
            break;
            }
            }
            ?>
      </form>
      </div>
      <!--COLONNA CON AREA PER LE NOTE GIA' ESISTENTI-->
      <div style="width:275px; height:auto; float:left; margin:10px 10px 0px 0px;">
		<?php
		 if ($note_utente != "") {
		  echo '<div style="width:100%; height:auto; float:left; margin-top: 3px;">
		  <span class="noteRda"><strong>Utente '.stripslashes($nome_utente).': </strong><br>'.$note_utente.'</span>
		  </div>'; 
		  }
		if ($note_resp != "") {
		  echo '<div style="width:100%; height:auto; float:left; margin-top: 3px;">
		  <span class="noteRda"><strong>Responsabile '.stripslashes($nome_resp).': </strong><br>'.$note_resp.'</span>
		  </div>'; 
		}
		if ($note_buyer != "") {
		  echo '<div style="width:100%; height:auto; float:left; margin-top: 3px;">
		  <span class="noteRda"><strong>Buyer '.stripslashes($nome_buyer).': </strong><br>'.$note_buyer.'</span>
		  </div>'; 
		}
		if ($note_magazziniere != "") {
		  echo '<div style="width:100%; height:auto; float:left; margin-top: 3px;">
		  <span class="noteRda"><strong>Magazziniere: </strong><br>'.$note_magazziniere.'</span>
		  </div>'; 
		}
	   ?>
      </div>
      <!--COLONNA CON AREA PER LE NOTE GIA' ESISTENTI-->
      <div style="width:140px; height:auto; float:right; margin:10px 5px 0px 0px;">
      <?php
		switch ($_SESSION[ruolo]) {
		  case "responsabile":
			if ($stato_rda < 2) {
				if ($report != 1) {
				  //include "form_rda.php"; 
				  echo "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_modal_approva_rda_resp.php?avviso=approva_rda_resp&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><strong>".$invia_buyer."</strong></a></div>";       
				}
			}
		  break;
		  case "buyer":
			if ($righe_attive_totali > 0) {
			  if ($stato_rda < 4) {
				if ($negozio_rda == "assets") {
				  include "form_rda_buyer_assets.php"; 
				} else {
				  //include "form_rda_buyer.php"; 
				  if ($report != 1) {
				   echo "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:300,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><strong>".$processa_buyer."</strong></a></div>";
				  }
				}
			  }
			}
		  break;
		}
	  ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function axc(id_riga,valoreQuant,id){
	//if (valoreQuant == '' || valoreQuant == '0') {
		/*alert(id);*/
						$.ajax({
								type: "GET",   
								url: "aggiorna_avvisi_rda.php",
								cache: "false",   
								data: "id_riga="+id_riga+"&id="+id+"&quant="+valoreQuant,
								success: function(output) {
								$('#avvisi_'+id).html(output).show();
						}
						})
		//refreshParent();
}
function ripristinaquantriga(id_riga,ord){
	var id_campo = document.getElementById('c_'+ord).value;
		

	if (id_campo == '') {
		/*alert(id_campo);*/
		//alert("<?php //echo $testo_alert; ?>");
						$.ajax({
								type: "GET",   
								url: "aggiorna_ripristinaquant_rda.php",
								cache: "false",   
								data: "id_riga="+id_riga+"&ord="+ord,
								success: function(output) {
								$('#q_'+ord).html(output).show();
						}
						})
	}
	}

	function total_general(id_riga,id){
	var quant = document.getElementById('c_'+id).value;
		/*alert('beccato');*/
						$.ajax({
								type: "GET",   
								url: "calcolo_totale_rda.php",   
								data: "id_riga="+id_riga+"&id="+id+"&quant="+quant,
								async: "false",
								cache: "false",
								success: function(output) {
								$('#tot_'+id).html(output).show();
						/*alert(div_agg+","+id_riga+","+valoreQuant);*/
								$.ajax({
										type: "GET",   
										url: "aggiorna_totale_rda.php",
										cache: "false",   
										data: "id_riga="+id_riga,
										success: function(output) {
										$('#tot_gen').html(output).show();
								}
								})
						}
						})

						$.ajax({
								type: "GET",   
								url: "aggiorna_avvisi_rda.php",
								cache: "false",   
								data: "id_riga="+id_riga+"&id="+id+"&salvataggio=1",
								success: function(output) {
								$('#avvisi_'+id).html(output).show();
						}
						})
}
</SCRIPT>


</body>
</html>
