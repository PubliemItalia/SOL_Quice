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
$id_utente = $_SESSION[user_id];
//echo "lingua: ".$lingua."<br>";
//echo "ruolo: ".$_SESSION[ruolo]."<br>";
//echo "id_utente: ".$_SESSION[user_id]."<br>";
//echo "negozio_buyer: ".$_SESSION[negozio_buyer]."<br>";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
	$sqlr = "SELECT * FROM qui_testi_interfaccia WHERE pag = 'gestione_rda'";
    $risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione02" . mysql_error());
    while ($rigar = mysql_fetch_array($risultr)) {
		switch ($rigar[posizione]) {
			case "lista_attesa_approvazione":
			  $lista_attesa_approvazione = $rigar[testo_it];
			  $colore_attesa_approvazione = $rigar[colore_scritta];
			break;
			case "lista_attesa_gestione":
			  $lista_attesa_gestione = $rigar[testo_it];
			  $colore_attesa_gestione = $rigar[colore_scritta];
			break;
			case "lista_gestione_sap":
			  $lista_in_gestione_sap = $rigar[testo_it];
			  $colore_inoltrato_sap = $rigar[colore_scritta];
			break;
			case "lista_gestione_ord":
			  $lista_in_gestione_ord = $rigar[testo_it];
			  $colore_inoltrato_ord = $rigar[colore_scritta];
			break;
			case "lista_gestione_lab":
			  $lista_in_gestione_lab = $rigar[testo_it];
			  $colore_inoltrato_lab = $rigar[colore_scritta];
			break;
			case "lista_gestione_mag":
			  $lista_in_gestione_mag = $rigar[testo_it];
			  $colore_inoltrato_mag = $rigar[colore_scritta];
			break;
			case "finito_ord":
			  $finito_ord = $rigar[testo_it];
			  $colore_finito_ord = $rigar[colore_scritta];
			break;
			case "finito_mag":
			  $finito_mag = $rigar[testo_it];
			  $colore_finito_mag = $rigar[colore_scritta];
			break;
			case "finito_lab":
			  $finito_lab = $rigar[testo_it];
			  $colore_finito_lab = $rigar[colore_scritta];
			break;
			case "finito_sap":
			  $finito_sap = $rigar[testo_it];
			  $colore_finito_sap = $rigar[colore_scritta];
			break;
		}
	}

//include "controllo_rda_0.php";
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
//variabili di paginazione
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
$archive = $_GET['archive'];
include "functions.php";
if ($_GET['a'] != "") {
$_SESSION[criterio] = "";
$_SESSION[codice] = "";
$_SESSION[nazione_ric] = "";
$_SESSION[descrizione] = "";
$_SESSION[negozio] = "";
$_SESSION[categoria] = "";
}
//echo "sess lingua: ".$_SESSION[lang]."<br>";

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
if ($_POST['pers'] != "") {
$pers = $_POST['pers'];
} else {
$pers = $_GET['pers'];
}
$avviso = $_GET['avviso'];
$ordinamento = "data_inserimento DESC";
//include "testata.php";
include "menu_quice3.php";


///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
if (isset($_GET['codice'])) {
$codiceDaModulo = $_GET['codice'];
$_SESSION[cliente] = $_GET['codice'];
} 
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

if (isset($_GET['descrizione'])) {
$descrizioneDaModulo = $_GET['descrizione'];
$_SESSION[descrizione] = $_GET['descrizione'];
} 
if (isset($_POST['descrizione'])) {
$descrizioneDaModulo = $_POST['descrizione'];
$_SESSION[descrizione] = $_POST['descrizione'];
}
if ($descrizioneDaModulo == "") {
$descrizioneDaModulo = $_SESSION[descrizione];
}
if ($descrizioneDaModulo != "") {
$c = "sintesi LIKE '%$descrizioneDaModulo%'";
$clausole++;
}

/*if (isset($_GET['negozio'])) {
$negozioDaModulo = $_GET['negozio'];
$_SESSION[negozio] = $_GET['negozio'];
} 
if (isset($_POST['negozio'])) {
$negozioDaModulo = $_POST['negozio'];
$_SESSION[negozio] = $_POST['negozio'];
}
if ($negozioDaModulo == "") {
$negozioDaModulo = $_SESSION[negozio];
}
if ($negozioDaModulo != "") {
$d = "negozio = '$negozioDaModulo'";
$clausole++;
}
*/
if (isset($_GET['categoria'])) {
$categoriaDaModulo = $_GET['categoria'];
$_SESSION[categoria] = $_GET['categoria'];
} 
if (isset($_POST['categoria'])) {
$categoriaDaModulo = $_POST['categoria'];
$_SESSION[categoria] = $_POST['categoria'];
}
if ($categoriaDaModulo == "") {
$categoriaDaModulo = $_SESSION[categoria];
}
if ($categoriaDaModulo != "") {
$e = "categoria = '$categoriaDaModulo'";
$clausole++;
}



//costruzione query
switch($_SESSION[ruolo]) {
case "utente":
if ($archive != "") {
$testoQuery = "SELECT * FROM qui_rda WHERE id_utente = '$id_utente' AND stato = '4'";
} else {
$testoQuery = "SELECT * FROM qui_rda WHERE id_utente = '$id_utente' AND (stato BETWEEN '1' AND '3')";
}
break;
case "responsabile":
if ($archive != "") {
$testoQuery = "SELECT * FROM qui_rda WHERE id_resp = '$id_utente' AND stato = '4'";
} else {
$testoQuery = "SELECT * FROM qui_rda WHERE id_resp = '$id_utente' AND (stato BETWEEN '1' AND '3')";
}
break;
case "buyer":
case "magazziniere":
$array_resp_ibridi = array("161","544");
if (in_array($id_utente,$array_resp_ibridi)) {
$testoQuery = "SELECT * FROM qui_rda WHERE id_resp = '$id_utente' ";
} else {
$testoQuery .= "SELECT * FROM qui_rda WHERE id_utente = '$id_utente' ";
}
if ($archive != "") {
$testoQuery .= "AND stato = '4' ";
} else {
$testoQuery .= "AND (stato  BETWEEN '1' AND '3') ";
}

//if ($pers != "") {
//$testoQuery .= "AND id_utente = '$id_utente' ";
//}
break;
case "admin":
if ($archive != "") {
$testoQuery = "SELECT * FROM qui_rda WHERE stato = '4'";
} else {
$testoQuery = "SELECT * FROM qui_rda WHERE (stato  BETWEEN '2' AND '3')";
}
break;
}
if ($clausole > 0) {
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
$testoQuery .= $e;
}
}

//} else {
//$testoQuery .= "WHERE obsoleto = '' ";
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
}

//condizioni per evitare errori
if((!$limit) OR (is_numeric($limit) == false)) {
//echo "limit in errore<br>";
     $limit = 25; //default
 } 

if((!$page) OR (is_numeric($page) == false)) {
//echo "page in errore<br>";
      $page = 1; //default
 } 

//determino quanti sono in tutto gli articoli trovati
//non mi interessa l'ordinamento, che viene stabilito più sotto
$querya = $testoQuery;
$resulta = mysql_query($querya);
$total_items = mysql_num_rows($resulta);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);


//if ($clausole > 0) {
$testoQuery .= " ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
//} else {
//$testoQuery .= " ORDER BY ".$ordinamento." LIMIT 20";
//}

//echo '<span style="color: #000;">testoQuery: '.$testoQuery.'</span><br>';
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////

//echo "sess_negozio: ".$_SESSION[negozio]."<br>";
//echo "total_items: ".$total_items."<br>";
?>
<html>
<head>
  <title>Quice - Lista RdA</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/report_balconi.css" />
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
<link rel="stylesheet" href="css/css_release_4.css" />
<style type="text/css">
<!--
#main_container {
	width:960px;
	margin: auto;
	margin-top: 10px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
<?php include "funzioni.js"; ?>
<SCRIPT type="text/javascript">
function aggiorna(){
document.form_lingua.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.form_lingua.submit();
}
</SCRIPT>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>
</head>
<?php

//if ($add_pref != "") {
//echo "<body onLoad=window.open('popup_notifica.php?avviso=bookmark&id_prod=".$id."','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
//echo "<body onLoad=window.open('popup_notifica.php?avviso=config','Conferma','height=100,width=400,status=no,toolbar=no,menubar=no,location=no,left=500,top=350')>";
//} else {
echo "<body>";
//}

?>
<div id="main_container">
  <?php
  $queryv = "SELECT * FROM qui_templates WHERE ref = 'rda'";
  $risultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigav = mysql_fetch_array($risultv)) {
	  if ($rigav[rif_blocco] == 'testata_generale_lista_rda') {
		$blocco_testata_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'riepilogo_sing_rda') {
		$blocco_singola_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'testatina_righe') {
		$blocco_testatina_righe = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'singola_riga') {
		$blocco_singola_riga = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'note_sing_rda') {
		$blocco_note_singola_rda = $rigav[codice_php];
	  }
	  if ($rigav[rif_blocco] == 'indir_rda') {
		$blocco_indir_sing_rda = $rigav[codice_php];
	  }
  }
   switch ($lingua) {
	  case "":
	  case "it":
		$attesa_approvazione = "In attesa di approvazione";
		$attesa_gestione = "In attesa di gestione";
		$gestione = "In gestione";
		$spedito_pl = "Spedito con Packing List n. ";
		$spedito_ord = "Inoltrato al fornitore - ord. n. ";
		$spedito_sap = "Inoltrato ordine SAP n. ";
		$dicitura_aggiornata = "Aggiornato al ";
		$dicitura_codice = "Codice";
		$dicitura_nazione = "Nazione";
		$dicitura_descrizione = "Descrizione";
		$dicitura_confezione = "Confezione";
		$dicitura_prezzo = "Prezzo &euro;";
		$dicitura_quantita = "Quantit&agrave;";
		$dicitura_totale = "Totale &euro;";
		$dicitura_stato = "Stato singolo prodotto";
		$testata_totale = "TOTALE &euro;";
	  break;
	  case "en":
		$attesa_approvazione = "Awaiting approval";
		$attesa_gestione = "Awaiting process";
		$gestione = "Processing";
		$spedito_pl = "Delivered with Packing List n. ";
		$spedito_ord = "Placed Order n. ";
		$spedito_sap = "Placed SAP Order n. ";
		$dicitura_aggiornata = "Updated ";
		$dicitura_codice = "Code";
		$dicitura_nazione = "Country";
		$dicitura_descrizione = "Description";
		$dicitura_confezione = "Packing";
		$dicitura_prezzo = "Price &euro;";
		$dicitura_quantita = "Quantity";
		$dicitura_totale = "Total &euro;";
		$dicitura_stato = "Single product condition";
		$testata_totale = "TOTAL &euro;";
	  break;
  }

//echo "<!-- TESTATA colonna codice-->";
		$codice_php_testata_rda = $blocco_testata_rda;
//echo '<span style="color:#000;">fin qui ok</span><br>';
//echo '<span style="color:#000;">righe: '.mysql_num_rows($risultv).'</span><br>';

$codice_php_testata_rda = str_replace("*testata_id_ordine*",$testata_id_ordine,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_data*",$testata_data,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*unita*",$unita,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_utente*",$testata_utente,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_responsabile*",$testata_responsabile,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_totale*",$testata_totale,$codice_php_testata_rda);
$codice_php_testata_rda = str_replace("*testata_status*",$testata_status,$codice_php_testata_rda);
/**/
//testata generale di pagina
echo $codice_php_testata_rda;
 $querya = $testoQuery;
 $sf = 1;
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
		$codice_php_singola_rda = $blocco_singola_rda;
		$codice_php_testatina_righe = $blocco_testatina_righe;
		$codice_php_note_singola_rda = $blocco_note_singola_rda;
  //if ($sf == 1) {
	  //$classe_riga = "riga row rdaColor";
	  //$colore_fondo_riga = '#F0F0F0';
  //} else {
	  $classe_riga = "riga row bianco";
	  $colore_fondo_riga = '#FFF';
 // }
  $stato_orig_rda = stripslashes($row[stato]);
  $note_utente = stripslashes($row[note_utente]);
  $note_resp = stripslashes($row[note_resp]);
  $note_buyer = stripslashes($row[note_buyer]);
  $note_magazziniere = stripslashes($row[note_magazziniere]);
  $riga_con_id = 'riga_'.$row[id];
  $colore_con_id = 'colore_orig_riga_'.$row[id];
  $open_status_con_id = 'open_status_'.$row[id];
  $pulsante_con_id = 'pulsante_'.$row[id];
  $sost_id_riga = $row[id];
  	$indirizzo_spedizione = $row[indirizzo_spedizione];
	if ($indirizzo_spedizione == "") {
	  $sqld = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_utente]'";
	  $risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigad = mysql_fetch_array($risultd)) {
		if ($rigad[companyName] != "") {
		$indirizzo_spedizione .= "<strong>".$rigad[companyName]."</strong><br>";
		}
		$indirizzo_spedizione .= "<strong>".$rigad[nomeunita]."</strong><br>";
		$indirizzo_spedizione .= $rigad[indirizzo]."<br>";
		$indirizzo_spedizione .= $rigad[cap]." ";
		$indirizzo_spedizione .= $rigad[localita]."<br>";
		$indirizzo_spedizione .= $rigad[nazione];
	  }
	}
  $data_inserimento = date("d.m.Y",$row[data_inserimento]);
  $data_ultima_modifica = date("d.m.Y",$row[data_ultima_modifica]);
  if ($row[data_approvazione] > 0) {
	$data_approvazione = date("d.m.Y",$row[data_approvazione]);
  } else {
	$data_approvazione = 0;
  }
  
  $sost_nome_unita = $row[nome_unita];
  $sqlx = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_utente]'";
  $risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigax = mysql_fetch_array($risultx)) {
	$sost_nome_utente = stripslashes($rigax[nome]);
  }
  $sqly = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
  $risulty = mysql_query($sqly) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigay = mysql_fetch_array($risulty)) {
	$sost_nome_resp = stripslashes($rigay[nome]);
  }
  $queryb = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE id_rda = '$row[id]'";
  $resultb = mysql_query($queryb);
  list($somma) = mysql_fetch_array($resultb);
  $sost_totale_rda = number_format($somma,2,",",".");
  $sqlz = "SELECT * FROM qui_righe_rda WHERE id_rda = '$row[id]'";
  $resultz = mysql_query($sqlz);
  $righe_totali = mysql_num_rows($resultz);
  while ($rowz = mysql_fetch_array($resultz)) {
	  if ($rowz[flag_chiusura] == 1) {
		$righe_chiuse = $righe_chiuse + 1;
	  }
  }
  switch ($row[stato]) {
	case "1":
	//	$sost_imm_status = '<img src="immagini/step1.png" width="90" height="13" title="'.$status1.'">';
	$sost_imm_status = '<img src="immagini/stato1.png" title="'.$status1.'">';
	break;
	case "2":
	//	$sost_imm_status = '<img src="immagini/step2.png" width="90" height="13" title="'.$status2.'">';
	$sost_imm_status = '<img src="immagini/stato2.png" title="'.$status2.'">';
	break;
	case "3":
	  if ($righe_chiuse != $righe_totali) {
		//$sost_imm_status = '<img src="immagini/step3.png" width="90" height="13" title="'.$status3.'">';
		$sost_imm_status = '<img src="immagini/stato3.png" title="'.$status3.'">';
		  $stato_rda = 3;
	  } else {
		  $stato_rda = 4;
		//$sost_imm_status = '<img src="immagini/step4.png" width="90" height="13" title="'.$status3.'">';
		$sost_imm_status = '<img src="immagini/stato4.png" title="'.$status3.'">';
	  }
	break;
	case "4":
		//$sost_imm_status = '<img src="immagini/step5.png" width="90" height="13" title="'.$status4.'">';
		$sost_imm_status = '<img src="immagini/stato4.png" title="'.$status4.'">';
	break;/**/
  }
	$codice_php_singola_rda = str_replace("*classe_riga*",$classe_riga,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*riga_con_id*",$riga_con_id,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*colore_con_id*",$colore_con_id,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*colore_fondo_riga*",$colore_fondo_riga,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_id_riga*",$sost_id_riga,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*data_inserimento*",$data_inserimento,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_nome_unita*",$sost_nome_unita,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_nome_utente*",$sost_nome_utente,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_nome_resp*",$sost_nome_resp,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_totale_rda*",$sost_totale_rda,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*open_status_con_id*",$open_status_con_id,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*sost_imm_status*",$sost_imm_status,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*pulsante_con_id*",$pulsante_con_id,$codice_php_singola_rda);
	$codice_php_singola_rda = str_replace("*visualizza_rda*",$visualizza_rda,$codice_php_singola_rda);
  
//riga riepilogo rda
	  //inizio contenitore singola rda
echo '<div id="rda_n_'.$sost_id_riga.'" class="contenitore_generale_rda">';
  echo $codice_php_singola_rda;
  /*$riga_con_id = "";
  $colore_con_id = "";
  $open_status_con_id = "";
  $pulsante_con_id = "";
  $sost_id_riga = "";*/
  if ($sf == 1) {
  $sf = $sf + 1;
  } else {
  $sf = 1;
  }
	  switch ($file_presente) {
		  case "lista_rdastato 3 - chiusura.php":
			$bottone_select_all = '';
		  break;
		  case "report_righe_nuovo.php":
			$bottone_select_all = '<img src="immagini/bottone-check-all.png" width="12" height="12" title="Seleziona tutto">';
		  break;
	  }
  
  $codice_php_testatina_righe = str_replace("*codice_riga*",$dicitura_codice,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*nazione_riga*",$dicitura_nazione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*descrizione_riga*",$dicitura_descrizione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*confezione_riga*",$dicitura_confezione,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*prezzo_riga*",$dicitura_prezzo,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*quant_riga*",$dicitura_quantita,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*totale_riga*",$dicitura_totale,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*stato_prodotto*",$dicitura_stato,$codice_php_testatina_righe);
  $codice_php_testatina_righe = str_replace("*bottone_select_all*",$bottone_select_all,$codice_php_testatina_righe);
  //DIV CON RIGHE RDA
  echo '<div id="dettaglio_rda_'.$row[id].'" class="riga dettaglio_rda">';
  //include 'popup_vis_rda.php?id='.$row[id];
//testatina righe
  echo $codice_php_testatina_righe;
//elenco righe  

  $queryb = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE id_rda = '$row[id]'";
  $resultb = mysql_query($queryb);
  list($somma) = mysql_fetch_array($resultb);
  $totale_rda = $somma;
  $array_date_chiusura = array();
  //$querya = "SELECT * FROM qui_righe_rda WHERE id_rda = '$id' ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
  $sqln = "SELECT * FROM qui_righe_rda WHERE id_rda = '$row[id]' ORDER BY id ASC";
  $x=1;
  //inizia il corpo della tabella
  $resultn = mysql_query($sqln);
  while ($rown = mysql_fetch_array($resultn)) {
	$codice_php_singola_riga = $blocco_singola_riga;
	$tot = $tot + 1;
	$data_leggibile = date("d.m.Y",$rown[data]);
	$id_prod_riga = $rown[id_prodotto];
	$codice_art_riga = $rown[codice_art];
	$descrizione_prodotto = $rown[descrizione];
	$sqlm = "SELECT * FROM qui_prodotti_".$rown[negozio]." WHERE codice_art='".$rown[codice_art]."'";
	$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
	while ($rigam = mysql_fetch_array($risultm)) {
	  if ($rigam[categoria1_it] == "Bombole") {
		$bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale_bombole.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&paese=&nazione_ric=&negozio=".$rown[negozio]."&codice_art=".$rigam[codice_art]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:400,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	  } else {
		$bottone_lente = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=".$rigam[categoria1_it]."&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&codice_art=".$rigam[codice_art]."&paese=&nazione_ric=&negozio=".$rown[negozio]."&lang=".$lingua."&nofunz=1',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40})\"><img src=immagini/bottone-lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
	  }
	}
	  switch ($file_presente) {
		  case "lista_rda.php":
			$bottone_edit = '';
		  break;
		  case "report_righe_nuovo.php":
			$bottone_edit = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'evasione_parziale_buyer.php?id_riga=".$rown[id]."&id_rda=".$rown[id_rda]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless960',width:960,height:260,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){refresh_rda(".$rown[id_rda].")}})\"><img src=immagini/bottone-edit.png width=19 height=19 border=0 title=\"Evasione parziale\"></a>";
		  break;
	  }
	  if (substr($codice_art_riga,0,1) != "*") {
		$sost_codice_art = $codice_art_riga;
	  } else {
		$sost_codice_art = substr($codice_art_riga,1);
	  }
		$sost_nazione = stripslashes($rown[nazione]);
	  if ($rown[azienda_prodotto] == "") {
		$sost_logo = '<img src="immagini/bottone-sol.png">';
	  }
	  if ($rown[azienda_prodotto] == "VIVISOL") {
		$sost_logo = '<img src="immagini/bottone-vivisol.png">';
	  }
	  if ($rown[azienda_prodotto] == "SOL") {
		$sost_logo = '<img src="immagini/bottone-sol.png">';
	  }
	  if (strlen($descrizione_prodotto) < 3) {
		$sost_descrizione = $descrizione_ita." <strong>(da tradurre)</strong>";
	  } else {
		$sost_descrizione = $descrizione_prodotto;
	  }
	  if ($rown[urgente] == 1) {
		  $sost_descrizione.= '<span style="color:red; font-weight: bold;"> - Urgente</span>';
	  }
	  $sost_confezione = stripslashes($rown[confezione]);
	  $sost_prezzo = number_format($rown[prezzo],2,",","");
	  //if ($rown[stato_ordine] == 1) {
		// $sost_quant = '<input name='.$tot.' type=text class=casella_input id=c_'.$tot.' size="4" maxlength="4" onkeypress = "return ctrl_solo_num(event);" onKeyUp="ayc('.$rown[id].",this.value,".$tot.');" onBlur="ripristinaquantriga('.$rown[id].','.$tot.')"';  
		//if ($rown[quant_modifica] != "") {
		  //$sost_quant .= " value=".number_format($rown[quant_modifica],0,",","");
		//} else {
		  //$sost_quant .= " value=".number_format($rown[quant],0,",","");
		//}
		//$sost_quant .= ">";
	  //} else {
		$sost_quant = intval($rown[quant]);
	  //}
	  $sost_totale_riga = number_format($rown[totale],2,",",".");
	  if ($rown[flag_chiusura] == 1) {
		  //se riga RdA completata
		//$colore_scritta = '#009ee0';
		//$colore_scritta = '#bfbfbe';
		switch ($rown[output_mode]) {
			case "mag":
			case "lab":
		$colore_scritta = $colore_inoltrato_mag;
			  $queryf = "SELECT * FROM qui_packing_list WHERE id = '$rown[pack_list]'";
			  $resultf = mysql_query($queryf);
			  while ($rowf = mysql_fetch_array($resultf)) {
				if ($rowf[data_spedizione] > 0) {
					$data_aggiornata = date("d.m.Y",$rowf[data_spedizione]);
				} else {
				if ($rowf[data_output] > 0) {
					$data_aggiornata = date("d.m.Y",$rowf[data_output]);
				} else {
					$data_aggiornata = date("d.m.Y",$rowf[data_ultima_modifica]);
				}

				}
			  }
			  $dettaglio_stato = '<a href="packing_list.php?mode=print&n_pl='.$rown[pack_list].'&lang='.$lingua.'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_mag.' '.$rown[pack_list].'</span></a>';
			break;

			case "sap":
			  $colore_scritta = $colore_inoltrato_sap;
			  if ($rown[data_chiusura] > 0) {
				  $data_aggiornata = date("d.m.Y",$rown[data_chiusura]);
			  } else {
				  $data_aggiornata = date("d.m.Y",$rown[data_ultima_modifica]);
			  }
			  $dettaglio_stato = $finito_sap.' '.$rown[ord_fornitore].'<br>'.$rown[fornitore_tx];
			break;
			case "ord":
			  $colore_scritta = $colore_inoltrato_ord;
			  $sqlg = "SELECT * FROM qui_righe_ordini_for WHERE id_riga_rda ='".$rown[id]."'";
			  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione14" . mysql_error());
			  while ($rigag = mysql_fetch_array($risultg)) {
				$ordine_for = $rigag[id_ordine_for];
			  }
			  $dettaglio_stato = '<a href="ordine_fornitore.php?id_ord='.$ordine_for."&id_rda=".$rown[id_rda].'&lang='.$lingua.'" target="_blank"><span style="color:'.$colore_scritta.';">'.$finito_ord.' '.$ordine_for.'</span></a>';
			  $data_aggiornata = date("d.m.Y",$rown[data_ultima_modifica]);
			break;
		}
		$ordine_for = '';
	  } else {
		  //se riga RdA non completata
		switch ($rown[output_mode]) {
		  case "":
			switch ($rown[stato_ordine]) {
			  case 1:
				$colore_scritta = $colore_attesa_approvazione;
				$dettaglio_stato = $lista_attesa_approvazione;
				$data_aggiornata = date("d.m.Y",$rown[data_inserimento]);
			  break;
			  case 2:
				$colore_scritta = $colore_attesa_gestione;
				$dettaglio_stato = $lista_attesa_gestione;
				$data_aggiornata = date("d.m.Y",$rown[data_ultima_modifica]);
			  break;
			}
		  break;
		  case "mag":
			if ($rown[data_output] > 0) {
			  $data_aggiornata = date("d.m.Y",$rown[data_output]);
			} else {
			  $data_aggiornata = date("d.m.Y",$rown[data_ultima_modifica]);
			}
				$colore_scritta = $colore_inoltrato_mag;
				//$colore_scritta = '#009036';
				$dettaglio_stato = $lista_in_gestione_mag;
		  break;
		  case "lab":
			if ($rown[data_output] > 0) {
			  $data_aggiornata = date("d.m.Y",$rown[data_output]);
			} else {
			  $data_aggiornata = date("d.m.Y",$rown[data_ultima_modifica]);
			}
				$colore_scritta = $colore_inoltrato_lab;
				//$colore_scritta = '#009036';
				$dettaglio_stato = $lista_in_gestione_lab;
		  break;
		  case "sap":
			if ($rown[data_output] > 0) {
			  $data_aggiornata = date("d.m.Y",$rown[data_output]);
			} else {
			  $data_aggiornata = date("d.m.Y",$rown[data_ultima_modifica]);
			}
				$colore_scritta = $colore_inoltrato_sap;
				//$colore_scritta = '#009ee0';
				$dettaglio_stato = $lista_in_gestione_sap;
		  break;
		  case "ord":
			if ($rown[data_output] > 0) {
			  $data_aggiornata = date("d.m.Y",$rown[data_output]);
			} else {
			  $data_aggiornata = date("d.m.Y",$rown[data_ultima_modifica]);
			}
				$colore_scritta = $colore_inoltrato_ord;
				//$colore_scritta = '#009036';
				$dettaglio_stato = $lista_in_gestione_ord;
		  break;
		}
	  }
		//fine switch ($rown[output_mode])
	  switch ($file_presente) {
		  case "lista_rda.php":
			if ($rown[stato_ordine] == 1) {
			$casella_check = "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_rda.php?avviso=del_riga&id_riga_rda=".$rown[id]."&id_rda=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:190,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,3,".$sost_id_riga.",3)}})\"><img src=immagini/btn_elimina.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
			} else {
			$casella_check = '';
			}
		  break;
		  case "report_righe_nuovo.php":
			$casella_check = '<img src="immagini/bottone-check1.png" width="12" height="12" title="Seleziona">';
		  break;
	  }
	$sost_data_aggiornata = $dicitura_aggiornata.$data_aggiornata;
	$codice_php_singola_riga = str_replace("*bottone_lente*",$bottone_lente,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*bottone_edit*",$bottone_edit,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_codice_art*",$sost_codice_art,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_nazione*",$sost_nazione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_logo*",$sost_logo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_descrizione*",$sost_descrizione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_confezione*",$sost_confezione,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_prezzo*",$sost_prezzo,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_quant*",$sost_quant,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*sost_totale_riga*",$sost_totale_riga,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*colore_scritta*",$colore_scritta,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*dettaglio_stato*",$dettaglio_stato,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*data_aggiornata*",$sost_data_aggiornata,$codice_php_singola_riga);
	$codice_php_singola_riga = str_replace("*casella_check*",$casella_check,$codice_php_singola_riga);
	$colore_scritta = '';
	$sost_logo = '';
	
  echo $codice_php_singola_riga;
  $x = $x+1;
	  $descrizione_prodotto = "";
	  $descr_ita = "";
	//$data_aggiornata = "";
  if ($rown[data_output] > 0) {
	  $data_output = date("d.m.Y",$rown[data_output]);
  } else {
	$data_output = "";
  }
  }
  switch ($lingua) {
	  case "":
	  case "it":
		$inserita = "Inserita il ";
		$approvata = "<br>Approvata il ";
		$evasa = "<br>Evasa completamente il ";
		$inprocesso = "<br>In processo";
		$dicitura_note = "<br><br>NOTE<br>";
		$pulsante_approva = "immagini/btn_approvaordine.png";
		$pulsante_stampa = "immagini/btn_stampa.png";
	  break;
	  case "en":
		$inserita = "Placed on ";
		$approvata = "<br>Approved on ";
		$evasa = "<br>Delivered on ";
		$inprocesso = "<br>Processing";
		$dicitura_note = "<br><br>NOTES<br>";
		$pulsante_approva = "immagini/btn_createanorder.png";
		$pulsante_stampa = "immagini/btn_print.png";
	  break;
  }
  $tracking = $inserita.$data_inserimento;
$data_output = " dal ".$data_output;
  if ($data_approvazione == 0) {
	$data_approvazione = $data_inserimento;
  }
  if ($stato_orig_rda >= 2) {
	$tracking .= $approvata.$data_approvazione;
  }
  switch ($stato_orig_rda) {
	  case 3:
		$tracking .= $inprocesso.$data_output;
	  break;
	  case 4:
	  $tracking .= $evasa.$data_aggiornata;
	  break;
  }
  switch ($_SESSION[ruolo]) {
	  case "magazziniere":
		  if ($note_resp != "") {
			  $sost_note_immodificabili = '<strong>'.$sost_nome_resp.'</strong> - '.$note_resp;
		  } else {
			  $sost_note_immodificabili = '';
		  }
		  if ($note_buyer != "") {
			  $sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer;
		  }
		  if ($note_utente != "") {
			  $sost_note_immodificabili .= '<strong>Utente</strong> - '.$note_utente;
		  }
		  $sost_autore = '<strong>Magazziniere</strong>';
		  $sost_nota_modificabile = '<textarea name="nota_'.$sost_id_riga.'" class="campo_note" id="nota_'.$sost_id_riga.'" onFocus="azzera_nota('.$sost_id_riga.')" onKeyUp="aggiorna_nota(nota_'.$sost_id_riga.','.$sost_id_riga.');">';
		  if ($note_magazziniere != "") {
			 $sost_nota_modificabile .= $note_magazziniere;
		  } else {
			 $sost_nota_modificabile .= 'Note';
		  }
		  $sost_nota_modificabile .= '</textarea>';
		break;
		case "buyer":
		case "utente":
		  if ($note_resp != "") {
			  $sost_note_immodificabili = '<strong>'.$sost_nome_resp.'</strong> - '.$note_resp;
		  } else {
			  $sost_note_immodificabili = '';
		  }
		  if ($note_buyer != "") {
			  $sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer;
		  }
		  if ($note_magazziniere != "") {
			  $sost_note_immodificabili .= '<strong>Magazziniere</strong> - '.$note_magazziniere;
		  }
		  $sost_autore = '<strong>Utente</strong>';
		  $sost_nota_modificabile = '<textarea name="nota_'.$sost_id_riga.'" class="campo_note" id="nota_'.$sost_id_riga.'" onFocus="azzera_nota('.$sost_id_riga.')" onKeyUp="aggiorna_nota(nota_'.$sost_id_riga.','.$sost_id_riga.');">';
		  if ($note_utente != "") {
			 $sost_nota_modificabile .= $note_utente;
		  } else {
			 $sost_nota_modificabile .= 'Note';
		  }
		  $sost_nota_modificabile .= '</textarea>';
		break;
		case "responsabile":
		  if ($note_utente != "") {
			  $sost_note_immodificabili .= '<strong>'.$sost_nome_utente.'</strong> - '.$note_utente;
		  } else {
			  $sost_note_immodificabili .= '';
		  }
		  if ($note_buyer != "") {
			  $sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer;
		  }
		  if ($note_magazziniere != "") {
			  $sost_note_immodificabili .= '<strong>Magazziniere</strong> - '.$note_magazziniere;
		  }
		  $sost_autore = '<strong>Responsabile</strong>';
		  $sost_nota_modificabile = '<textarea name="nota_'.$sost_id_riga.'" class="campo_note" id="nota_'.$sost_id_riga.'" onFocus="azzera_nota('.$sost_id_riga.')" onKeyUp="aggiorna_nota(nota_'.$sost_id_riga.','.$sost_id_riga.');">';
		  if ($note_resp != "") {
			 $sost_nota_modificabile .= $note_resp;
		  } else {
			 $sost_nota_modificabile .= 'Note';
		  }
		  $sost_nota_modificabile .= '</textarea>';
		break;
	  case "utente":
	  case "responsabile":
		if ($note_buyer != "") {
			$sost_note_immodificabili .= '<strong>Buyer</strong> - '.$note_buyer;
		}
		$sost_autore = '<strong>Magazziniere</strong>';
		$sost_nota_modificabile = '<textarea name="nota_'.$sost_id_riga.'" class="campo_note" id="nota_'.$sost_id_riga.'" onFocus="azzera_nota('.$sost_id_riga.')" onKeyUp="aggiorna_nota(nota_'.$sost_id_riga.','.$sost_id_riga.');">';
		if ($note_magazziniere != "") {
		   $sost_nota_modificabile .= $note_magazziniere;
		} else {
		   $sost_nota_modificabile .= 'Note';
		}
		$sost_nota_modificabile .= '</textarea>';
	  break;
  }
		switch ($_SESSION[ruolo]) {
		  case "responsabile":
		  case "buyer":
			if ($stato_orig_rda < 2) {
				//if ($report != 1) {
				  //include "form_rda.php"; 
				  $sost_pulsante_processo = "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_modal_approva_rda_resp.php?avviso=approva_rda_resp&id_rda=".$sost_id_riga."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:190,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){axc(0,3,".$sost_id_riga.",3)}})\"><img src=\"".$pulsante_approva."\" width=\"160\" height=\"25\" border=\"0\"></a>";       
				//}
			}
		  break;
		}
	$sost_pulsante_chiusura = '';
  $sost_pulsante_stampa = '<a href="stampa_rda.php?id_rda='.$sost_id_riga.'&mode=print&lang='.$lingua.'" target="_blank">
	  <img src="'.$pulsante_stampa.'" width="160" height="25" border="0">
	  </a>';
	$sost_ordini = '';
	$codice_php_note_singola_rda = $blocco_note_singola_rda;
	$codice_php_note_singola_rda = str_replace("*sost_autore*",$sost_autore,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*tracking*",$tracking,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_note_immodificabili*",$sost_note_immodificabili,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_nota_modificabile*",$sost_nota_modificabile,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_stampa*",$sost_pulsante_stampa,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_pulsante_processo*",$sost_pulsante_processo,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_ordini*",$sost_ordini,$codice_php_note_singola_rda);
	$codice_php_note_singola_rda = str_replace("*sost_id_riga*",$sost_id_riga,$codice_php_note_singola_rda);
  echo $codice_php_note_singola_rda;
  $sost_note_immodificabili = "";
  $sost_pulsante_processo = "";
  
 $codice_php_indir_singola_rda = $blocco_indir_sing_rda;
$codice_php_indir_singola_rda = str_replace("*testo_indirizzo*",$indirizzo_spedizione,$codice_php_indir_singola_rda);
echo $codice_php_indir_singola_rda;
 
	  //fine contenitore singola rda
  echo "</div>";
	  //fine elenco righe
  echo "</div>";
//echo '<span style="color: #000;">stato rda: '.$stato_rda.'</span><br>';
$data_output = '';
$tracking = '';
}
/*  
*/
 ?>





    <div class="num_pag" style="width: 960px;">
	  <?php
      //posizione per paginazione
      $prev_page = $page - 1;
      
      if($prev_page >= 1) { 
        echo "<b></b> <a href=".$_SERVER['PHP_SELF']."?limit=$limit&page=$prev_page&lang=$lingua&archive=$archive><b><<</b></a>"; 
      } 
      for($a = 1; $a <= $total_pages; $a++)
      {
         if($a == $page) {
            echo("<span class=current_num_pag> $a</span> | "); //no link
           } else {
        echo("  <a href=".$_SERVER['PHP_SELF']."?limit=$limit&page=$a&lang=$lingua&archive=$archive> $a </a> | ");
           } 
      } 
      $next_page = $page + 1;
      if($next_page <= $total_pages) {
         echo "<a href=".$_SERVER['PHP_SELF']."?limit=$limit&page=$next_page&lang=$lingua&archive=$archive><b>>></b></a>"; 
      } 
      ?>
    </div>
</div>
<script type="text/javascript">
function mostra_nascondi(id) {
	var status = document.getElementById('open_status_'+id).value;
	var colore_orig_riga = document.getElementById('colore_orig_riga_'+id).value;
	
	/*
	alert(id);
	*/
	//$("#test"+id).click(function () {
   $('#dettaglio_rda_'+id).slideToggle(500);
   if (status == 0) {
	  document.getElementById('open_status_'+id).value = "1";
	  $('#pulsante_'+id).html('<img src="immagini/a-meno.png" border="0">')
	  $('#riga_'+id).css("background-color", "#80b6e2");/**/
   } else {
	  document.getElementById('open_status_'+id).value = "0";
	  $('#pulsante_'+id).html('<img src="immagini/a-piu.png" border="0">')
	  $('#riga_'+id).css("background-color", colore_orig_riga);/**/
   }
//});
}
function aggiorna_nota(id_nota,id_rda) {
	  var tx_testo = document.getElementById('nota_'+id_rda).value.replace(/\r?\n/g, '<br>');
  /*alert(tx_testo);*/
  $.ajax({
	type: "GET",   
	url: "aggiorna_nota.php",   
	data: "testo="+tx_testo+"&id_rda="+id_rda,
	success: function(output) {
	$('#aaa').html(output).show();
	}
  });
}
function axc(id_riga,valoreCheck,id_rda,sm){
/*
**************PARAMETRI variabile "sm"++++++++++++++++
BUYER => modifica riga singola = 1 - modifica riga multipla = 2 - refresh no modifica = 3
MAGAZZINIERE => modifica riga singola = 4 - modifica riga multipla = 5 - refresh no modifica = 6
alert(id_rda);
*/
  $.ajax({
	type: "GET",   
	url: "imposta_blocco_rdaXlista.php",   
	data: "sm="+sm+"&id_riga="+id_riga+"&check="+valoreCheck+"&id_rda="+id_rda,
	success: function(output) {
	$('#rda_n_'+id_rda).html(output).show();
	}
  })			  
}
function ayc(id_riga,valoreQuant,id){
  var conf = document.getElementById('conf_'+id_riga).value;
  var um = document.getElementById('um_'+id_riga).value;
  $.ajax({
	type: "GET",   
	url: "aggiorna_avvisi_mod_rda.php",
	cache: "false",   
	data: "id_riga="+id_riga+"&id="+id+"&quant="+valoreQuant+"&um="+um+"&conf="+conf,
	success: function(output) {
	$('#avvisi_'+id).html(output).show();
  }
  })
}
function ripristinaquantriga(id_riga,ord){
  var id_campo = document.getElementById('c_'+ord).value;
  if (id_campo == '') {
	/*alert(id_campo);*/
	//alert("<?php //echo $testo_alert; ?>");
	$.ajax({
			type: "GET",   
			url: "aggiorna_ripristinaquant_carrello.php",
			cache: "false",   
			data: "id_riga="+id_riga+"&ord="+ord,
			success: function(output) {
			$('#q_'+ord).html(output).show();
	}
	})
  }
}
function azzera_nota(rda) {
var nota = document.getElementById('nota_'+rda).value;
	/*alert(id_fatt);*/
if(nota == "Note") {
document.getElementById('nota_'+rda).value = '';
}
}
</SCRIPT>
</body>
</html>
