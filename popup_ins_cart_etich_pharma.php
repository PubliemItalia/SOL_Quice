<?php
session_start();
$IDResp = $_SESSION[IDResp];
$id_prod = $_GET[id_prod];
$id_utente = $_GET[id_utente];
$lingua = $_GET[lang];
$quant = $_GET[quant];
$negozio= $_GET[negozio];
$prezzo_pescante= $_GET[prezzo_pescante];
//echo "lingua: ".$lingua."<br>";
//echo "id: ".$id_prod."<br>";
$array_flusso_BMC = array('bmc','htc');
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
//$sqld = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prod'";
$sqld = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id_prod'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
//echo "categoria1: ".$rigad[categoria1_it]."<br>";
$chk_cat = $rigad[categoria2_it];
$chk_giac = $rigad[giacenza];
$flusso = $rigad[flusso];
$extra_flusso = $rigad[extra];
if ($rigad[categoria1_it] == "Bombole") {
  if ($prezzo_pescante == "") {
	echo "<div style=\"margin:50px auto; width:500px; height:80px; font-family: Arial; color: green; font-size: 16px; font-weight: bold; text-align:center;\">";
	echo "Per poter procedere con l&acute;ordine della bombola prescelta<br>&egrave; obbligatorio indicare se la si vuole ordinare<br>con o senza pescante.<br>";
	echo "</div>";
	echo "<div style=\"margin:auto; width:500px; height:50px; font-family: Arial; color:green; font-size: 16px; font-weight: bold; text-align:center;text-decoration:underlined;\">";
	echo "Chiudi questa finestra e specifica<br>la scelta del pescante.";
	echo "</div>";
	exit;
  }
}
switch ($lingua) {
	case "it":
	$dicitura_carrello = 'Il prodotto che vuoi inserire<br>non fa parte del negozio<br>a cui appartiene il carrello corrente';
	$dicitura_flusso = 'Il prodotto che vuoi inserire<br>viene gestito da un gruppo di buyer diversi.<br>Puoi inserire solo prodotti della categoria<br>';
	$dic_prezzo = "Prezzo euro";
	$dic_quant = "Quantit&agrave;";
	$titolino1 = "Stampa Laser (&lt; 150 copie)<br>Consegna veloce";
	$titolino2 = "Stampa tipografica (&gt; 150 copie)<br>Massima qualit&agrave;";
	$titolino3 = "Stampa tipografica<br>Massima qualit&agrave;";
	$titolino_blister = "Stampa e confezione";
	$dic_altre_quant = "Altre quantit&agrave;";
	$dida = "<strong>Stampa laser (&lt; 150 copie)</strong><br>consegna in circa 5 giorni lavorativi.<br><br><strong>Stampa tipografica (&gt; 150 copie)</strong><br>consegna in circa 20 giorni lavorativi.<br>La stampa tipografica pu&ograve; avere una tolleranza di &plusmn; 10 % delle quantit&agrave; indicate.";
	break;
	case "en":
	$dicitura_carrello = 'The product you&acute;re ordering<br>doesn&acute;t belong to the shop<br>of your current cart';
	$dicitura_flusso = 'The product you&acute;re ordering<br>is managed by another buyer group.<br>You can order only product belonging to category<br>';
	$dic_prezzo = "Price euro";
	$dic_quant = "Quantity";
	$titolino1 = "Laser print (&lt; 150 copies)<br>Quick delivery";
	$titolino2 = "Printing Press (&gt; 150 copies)<br>High quality";
	$titolino3 = "Printing Press<br>High quality";
	$titolino_blister = "Printing & packaging";
	$dic_altre_quant = "Other quantities";
	$dida = "<strong>Laser printing</strong><br>delivery will take 5 working days.<br><br><strong>Printing Press</strong><br>Delivery will take 20 working days.<br>The printing process can have a tolerance of ± 10% of the ordered quantities.";
	break;
}
switch($lingua) {
case "it":
$descrizione_art = $rigad[descrizione1_it];
$confezione = $rigad[confezione];
$dic_pescante = "con pescante";
break;
case "en":
$descrizione_art = $rigad[descrizione1_en];
$confezione = str_replace("confezioni da", "package of",$rigad[confezione]);
$confezione = str_replace("blocchi da", "blocks of",$confezione);
$confezione = str_replace("fogli da", "sheets of",$confezione);
$confezione = str_replace("blister singoli", "one piece",$confezione);
$confezione = str_replace("bustina singola", "one bag",$confezione);
$confezione = str_replace("etichetta singola", "one label",$confezione);
$confezione = str_replace("etichette", "labels",$confezione);
$confezione = str_replace("fogli", "sheets",$confezione);
$confezione = str_replace("bustine", "bags",$confezione);
$dic_pescante = "with deep tube";
break;
case "fr":
$descrizione_art = $rigad[descrizione1_fr];
break;
case "de":
$descrizione_art = $rigad[descrizione1_de];
break;
case "es":
$descrizione_art = $rigad[descrizione1_es];
break;
}
$tipologia = $rigad[extra];
$codice_art = $rigad[codice_art];
if (($rigad[negozio] == "assets") AND ($rigad[categoria1_it] == "Bombole")) {
	if ($prezzo_pescante > 0) {
		$descrizione_art .= " - ".$dic_pescante;
	}
//recupero informazioni valvola
if ($rigad[id_valvola] != "") {
  $sqlm = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigad[id_valvola]'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	$prezzo_valvola = $rigam[prezzo];
  }
}
//recupero informazioni cappellotto
if ($rigad[id_cappellotto] != "") {
  $sqln = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigad[id_cappellotto]'";
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
  while ($rigan = mysql_fetch_array($risultn)) {
	$prezzo_cappellotto = $rigan[prezzo];
  }
}
$prezzo_art = $rigad[prezzo] + $prezzo_valvola + $prezzo_cappellotto + $prezzo_pescante;
} else {
$prezzo_art = $rigad[prezzo];
}
$etich_x_foglio = $rigad[confezione];
$categoria1 = $rigad[categoria1_it];
$categoria3 = $rigad[categoria3_it];
switch($lingua) {
  case "it":
	$categoria4 = $rigad[categoria4_it];
  break;
  case "en":
	if ($rigad[categoria4_en] != "") {
	  $categoria4 = $rigad[categoria4_en];
	} else {
	  $categoria4 = $rigad[categoria4_it];
	}
  break;
}
$um = $rigad[um];
$posx = stripos($um,"-");
$ric_mag = $rigad[ric_mag];
}
  $sqlm = "SELECT * FROM qui_messaggi_carrello WHERE ric_mag = '$ric_mag'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	switch ($lingua) {
	  case "it":
	  $messaggio_carrello = $rigam[testo_it];
	  break;
	  case "en":
	  $messaggio_carrello = $rigam[testo_en];
	  break;
	}
  }
if ($posx > 0) {
	$array_um = explode("-",$um);
	$unit = $array_um[0];
	$conf = $array_um[1];
} else {
$unit = $um;
$conf = "";
}
switch ($lingua) {
  case "it":
	$unit = $unit;
	$conf = $conf;
  break;
  case "en":
  $unit = str_replace("confezioni", "packages",$unit);
  $unit = str_replace("blocchi", "blocks",$unit);
  $unit = str_replace("fogli", "sheets",$unit);
  $unit = str_replace("bustine", "bags",$unit);
  $unit = str_replace("etichette", "labels",$unit);
  $unit = str_replace("fogli", "sheets",$unit);
  $unit = str_replace("pezzi", "pieces",$unit);
  $unit = str_replace("articoli", "items",$unit);
  $unit = str_replace("Articolo_singolo", "Single_item",$unit);
  $conf = str_replace("confezioni", "packages",$conf);
  $conf = str_replace("blocchi", "blocks",$conf);
  $conf = str_replace("fogli", "sheets",$conf);
  $conf = str_replace("bustine", "bags",$conf);
  $conf = str_replace("etichette", "labels",$conf);
  $conf = str_replace("fogli", "sheets",$conf);
  $conf = str_replace("pezzi", "pieces",$conf);
  $conf = str_replace("articoli", "items",$conf);
  break;
}
if ($negozio == "labels") {
	  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = 'Mod_laser'";
	  $risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigag = mysql_fetch_array($risultg)) {
		$prezzo_unitario_laser = $rigag[prezzo_unitario];
	  }

	  $sqlt = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia'";
	  $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  $quant_esist = mysql_num_rows($risultt);
	  if ($quant_esist > 0) {
	  $sqls = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND prezzo > '0' ORDER BY quant ASC LIMIT 1";
	  $risults = mysql_query($sqls) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigas = mysql_fetch_array($risults)) {
		$prezzo_basso = $rigas[prezzo];
	  }
	  
	  $sqlr = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND prezzo > '0' ORDER BY quant DESC LIMIT 1";
	  $risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigar = mysql_fetch_array($risultr)) {
		$prezzo_alto = $rigar[prezzo];
	  }
	  }
}

//echo "categoria3: ".$categoria3."<br>";
//echo "categoria4: ".$categoria4."<br>";

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
window.close();
}
</script>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery.validate.js"></script>
<script type="text/javascript">
function validateForm() {
var x=document.forms["form1"]["blocco"].value;
if (x==1) {
  /*alert("Indicare una quantità consentita!");
  return false;*/
  }
}
function ctrl_solo_num(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)		// 0 - 9
				|| unicode>60000					// arrow-keys, enf
				|| unicode<14						// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
			) 
			? true : false
			}
</script>
<script language = "Javascript">
function formSubmit()
{
document.getElementById("form1").submit();
}
</script>
<?php include "funzioni.js"; ?>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/visual.css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Stile1 {
	font-family: Arial;
	color: green;
	font-size: 16px;
	font-weight: bold;
	text-align:center;
}
.container {
	margin:auto;
	width:600px;
	height:380px;
	font-family: Arial;
	color: black;
}
.contenitore_filo {
	margin:10px auto;
	width:100%;
	height:auto;
	float:left;
	/*border-bottom:1px solid black;*/
}
.colonna {
	width:50%;
	min-height:310px;
	height:auto;
	margin-bottom:10px;
	float:left;
}
.colonna_bassa {
	width:50%;
	min-height:100px;
	overflow:hidden;
	height:auto;
	margin-bottom:10px;
	float:left;
}
.titolo_colonna {
	width:250px;
	height:auto;
	font-size: 12px;
	margin-top:5px;
	float:left;
	font-weight: bold;
}
.colonnino_interno_testata {
	width:119px;
	height:auto;
	padding:3px 3px;
	font-size: 12px;
	font-weight:bold;
	color:white;
	background-color:rgb(0, 60, 128);
	margin:10px 0px;
	float:left;
}
.colonnino_interno_riga_filo {
	width:102px;
	height:10px;
	padding:3px 4px;
	font-size: 12px;
	font-weight:bold;
	color:black;
	background-color:white;
	float:left;
}
.colonnino_interno_riga_dispari {
	width:112px;
	height:auto;
	padding:2px 4px;
	font-size: 12px;
	font-weight:bold;
	color:black;
	background-color:white;
	float:left;
}
.colonnino_interno_riga_pari {
	width:112px;
	height:auto;
	padding:2px 4px;
	font-size: 12px;
	font-weight:bold;
	color:black;
	background-color:rgb(221, 221, 221);
	float:left;
}
.riga_generale {
	width:250px;
	height:25px;
	float:left;
	padding-top:3px;
	border-top:1px solid rgb(0,0,0);
}
.cifra_trasp {
	width:65px;
	height:auto;
	text-align:left;
	float:left;
}
.pallino {
	width:30px;
	height:auto;
	float:left;
}
-->
</style></head>

<body onUnload="refreshParent()">
   <form name="form1" method="get" action="inserimento_etich_pharma.php">
    	<?php
		$array_eccezioni_bomb = array("Bombole", "Pacchi_bombole");
		if (in_array($categoria1,$array_eccezioni_bomb)) {
			$stile_colonna = "colonna_bassa";
		} else {
			$stile_colonna = "colonna";
		}
		?>
   
<div class="container">
<?php
$sqld = "SELECT * FROM qui_carrelli WHERE id_utente = '$id_utente' AND attivo = '1'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_carrelli = mysql_num_rows($risultd);
//echo "num_carrelli: ".$num_carrelli."<br>";
//c'è un carello attivo
if ($num_carrelli == 0) {
  $negozio_carrello = $negozio;
  $flusso_carrello = $flusso;
} else {
  while ($rigad = mysql_fetch_array($risultd)) {
  $id_carrello = $rigad[id];
  $negozio_carrello = $rigad[negozio];
  $note_carrello = $rigad[note];
  $flusso_carrello = $rigad[flusso];
  }
}
if ($flusso_carrello != "") {
$sqlx = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello' ORDER BY id ASC LIMIT 1";
$risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risultx);
if ($num_righe > 0) {
  while ($rigax = mysql_fetch_array($risultx)) {
  $categoria_carrello = str_replace("_"," ",$rigax[categoria]);
  }
}
}

if ($negozio_carrello != $negozio) {
	echo '<div style="text-align:center; width:100%; height:auto; margin-top:40px; color: red; font-size:18px; font-weight:bold">';
		echo $dicitura_carrello;
	echo '</div>';
	exit;
} else {
//if (($flusso != "") && ($flusso_carrello != $flusso)) {
if ($flusso_carrello != $flusso) {
	echo '<div style="text-align:center; width:100%; height:auto; margin-top:40px; color: red; font-size:18px; font-weight:bold">';
		echo $dicitura_flusso.'"'.$categoria_carrello.'"';
	echo '</div>';
	exit;
	}

}
$array_scorte_gestite = array("Abbigliamento_Sol","Abbigliamento_Vivisol");
if ((in_array($chk_cat,$array_scorte_gestite)) && ($chk_giac <= 0)) {
	echo '<div style="text-align:center; width:100%; height:auto; margin-top:40px; color: red; font-size:18px; font-weight:bold">';
	switch ($lingua) {
	  case "it":
		echo 'Siamo spiacenti; questo articolo<br>non è attualmente disponibile a magazzino!';
	  break;
	  case "en":
		echo 'Sorry! This item is not currently available.';
	  break;
	}
	echo '</div>';
	exit;
}
  echo '<div class="contenitore_filo">';
    //colonna 1-->
    echo '<div class="'.$stile_colonna.'">';
      /*echo '<div style="width:270px; float:left; font-family:Arial; font-size:12px; font-weight:bold;">
    	<?php //echo $titolino2; ?>
      </div>
      <div style="width:30px; float:left;">
    	<?php //echo $pulsantino_verde; ?>
      </div>*/
       echo '<div class="colonnino_interno_testata" style="text-align:left; width:159px;">';
		echo $dic_quant;
      echo '</div>';
       echo '<div class="colonnino_interno_testata" style="text-align:right; width:79px;">';
        echo $dic_prezzo;
      echo '</div>';
		//$contatore = 1;
		//$contarighe = 0;
switch($ric_mag) {
case "RIC":
	//se ci sono quantità prefissate, si prendono quelle che Vengono agganciate nella tabella "prezzi/quant , più il campo della quantità variabile
	  //$a = 1;
	  $sqlg = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia' AND prezzo > '0' ORDER BY quant ASC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_qprefissate = mysql_num_rows($risultg);
while ($rigag = mysql_fetch_array($risultg)) {
  $a = $a+1;
	//$prezzo = round($rigag[prezzo]);
  if ($a == 1) {
	$quant_prec = $rigag[quant];
	$prezzo = round($rigag[prezzo]);
	$valore_iniziale_serie = round($rigag[prezzo]);
	$coeff_in_uso = $rigag[coefficiente];
  } else {
	  //echo "coeff_in_uso: ".$coeff_in_uso."<br>";
	$prezzo = $prezzo + ((($rigag[quant]-$quant_prec)/100)*$coeff_in_uso);
	$quant_prec = $rigag[quant];
	$coeff_in_uso = $rigag[coefficiente];
  }
	echo "<div class=riga_generale>";
	  echo "<div class=colonnino_interno_riga_filo>";
		echo "<div class=cifra_trasp>";
		echo $rigag[quant];
		echo "</div>";
		echo "<div class=pallino style=\"padding:0px\">";
		echo "<input style=\"font-size:10px\" type=radio name=quant value=".$rigag[quant]." id=quant_".$contarighe." onClick=\"aggiorna_quant(".$rigag[id].",1)\">";
		echo "</div>";
	  echo "</div>";
	  echo "<div class=colonnino_interno_riga_filo style=\"padding-bottom:4px\">";
		echo "<div style=\"text-align:right;\">";
	  echo number_format($prezzo,2,",",".");
		echo "</div>";
	  echo "</div>";
	echo "</div>";
}
    echo "<div class=riga_generale>";
	  echo "<div class=colonnino_interno_riga_filo>";
		echo "<div class=cifra_trasp>";
		echo $rigag[quant];
		echo "</div>";
		echo "<div class=pallino style=\"padding:0px\">";
		if (in_array($categoria1,$array_eccezioni_bomb)) {
		  echo "<input name=custom_qty id=custom_qty type=text onkeypress=\"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_pacchi(this.value,'3','".trim($tipologia)."')\" style=\"width:100px; height:15px;font-size:10px;\">";
		} else {
		  echo "<input name=custom_qty id=custom_qty type=text onkeypress=\"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_quant3(this.value,'3','".trim($tipologia)."')\" style=\"width:100px; height:15px;font-size:10px;\">";
		}
		echo "</div>";
	  echo "</div>";
	  echo "<div id=prezzo_calcolato class=\"colonnino_interno_riga_filo\" style=\"text-align:right;\">";
	  echo $dic_altre_quant;
	  echo "</div>";
	echo "</div>";
   echo "<div id=quant_nasc style=\"width:150px; hight:30px;\">";
   echo "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";
   echo "<input type=hidden name=blocco id=blocco value=1>";
	echo "</div>";
break;
case "PUB":
case "riv":
case "mag":
	//se non ci sono quantità prefissate, si prende il prezzo unitario che è nel campo prezzo dell'articolo
    echo "<div class=riga_generale>";
	  echo "<div class=colonnino_interno_riga_filo>";
		if (in_array($categoria1,$array_eccezioni_bomb)) {
		  echo "<input name=custom_qty id=custom_qty type=text onkeypress=\"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_pacchi(this.value,'3','".trim($tipologia)."')\" style=\"width:100px; height:15px;font-size:10px;\">";
		} else {
		  echo "<input name=custom_qty id=custom_qty type=text onkeypress=\"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_quant3(this.value,'4','".trim($tipologia)."')\" style=\"width:120px; height:35px; font-size:14px; font-weight: bold;\">";
		}
		echo "</div>";
	  echo "<div id=prezzo_calcolato class=\"colonnino_interno_riga_filo\" style=\"text-align:right; margin-left:10px; background-color:transparent;\">";
	  echo $prezzo_art;
	  echo "</div>";
   echo "<div id=quant_nasc style=\"width:10px; height:30px;\">";
   echo "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";
   echo "<input type=hidden name=blocco id=blocco value=1>";
	echo "</div>";
	  echo "</div>";
break;
case "maglab":
	//solo per le etichette, il prezzo è da recuperare nella tabella "qui_pharma_quant_prezzi" prezzo unitario senza considerare coefficienti da iperbole
    echo "<div class=riga_generale>";
	  echo "<div class=colonnino_interno_riga_filo>";
		  echo "<input name=custom_qty id=custom_qty type=text onkeypress=\"return ctrl_solo_num(event);\" onKeyUp=\"aggiorna_quant3(this.value,'4','".trim($tipologia)."')\" style=\"width:120px; height:35px; font-size:14px; font-weight: bold;\">";
		echo "</div>";
	  echo "<div id=prezzo_calcolato class=\"colonnino_interno_riga_filo\" style=\"text-align:right; margin-left:10px; background-color:transparent;\">";
	  $sqlr = "SELECT * FROM qui_pharma_quant_prezzi WHERE tipologia = '$tipologia'";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigar = mysql_fetch_array($risultr)) {
	echo $rigar[prezzo];
  }
	  echo "</div>";
   echo "<div id=quant_nasc style=\"width:10px; height:30px;\">";
   echo "<input type=hidden name=quant_std_nasc id=quant_std_nasc value=0>";
   echo "<input type=hidden name=blocco id=blocco value=1>";
	echo "</div>";
	  echo "</div>";
break;
}
//per visualizzazione info confezione
	echo "<div style=\"float:left; width:100%; font-weight:normal; font-size:12px; margin-top:30px;\">";
  if ($negozio == "labels") {
	echo ucfirst($confezione);
  } else {
	if ($conf != "") {
	  echo ucfirst($conf)." da ".$confezione." ".ucfirst($unit);
	} else {
		
	  if ($confezione == "1") {
		echo str_replace("_"," ",ucfirst($unit));
	  } else {
		switch ($lingua) {
		  case "it":
			  echo "Confezioni da ".$confezione." articoli";
		  break;
		  case "en":
			  echo "Packages of ".$confezione." items";
		  break;
		}
	  }
	}
  }
	echo "</div>";

    echo '</div>';
    
    //colonna 2
    echo '<div class="'.$stile_colonna.'">';
/*<div style="width:90%; height:100px; padding:10px; background-color:rgb(253,237,147);">
      <div style="width:70%; float:left; font-family:Arial; font-size:12px; font-weight:bold;">
    	<?php //echo $titolino1; ?>
      </div>
      <div style="width:20%; float:left;">
    	<?php //echo $pulsantino_verde; ?>
      </div>
       <div class="colonnino_interno_testata" style="text-align:left; width:95%; margin:10px auto;">
        <?php //echo $dic_quant." (".$unit.")"; ?>
      </div>
      <div class="colonnino_interno_riga_filo" style="background-color:transparent;">
        <input name=quant_publiem type=text id=quant_publiem style="width:100px; height:15px;font-size:10px;" maxlength=4 onkeypress = "return ctrl_solo_num(event);" onKeyUp="aggiorna_quant2(this.value,'0','Mod_laser')">
	</div>
</div>*/
echo '<div id="messaggi" style="width:240px; margin-top:10px; float:left; font-size:12px;">'.$messaggio_carrello;
echo '</div>';

/*
if ((in_array($flusso, $array_flusso_BMC)) && ($extra_flusso != "")) {
	  $sqlp = "SELECT * FROM qui_spedizioni WHERE flusso = '".$flusso."' ORDER BY id ASC";
	  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  $presenza_sped = mysql_num_rows($risultp);
	  if ($presenza_sped > 0) {
		echo '<div id="scelte" style="width:240px; margin-top:10px; font-size:12px; min-height: 20px; float: left;">';
			  while ($rigap = mysql_fetch_array($risultp)) {
				switch ($lingua) {
				  case "it":
					  $descr =  $rigap[descrizione_it];
				  break;
				  case "en":
					  $descr =  $rigap[descrizione_en];
				  break;
				}
				  if ($rigap[precedenza] == "1") {
				switch ($lingua) {
				  case "it":
					  $spiega =  $rigap[spiega_it];
				  break;
				  case "en":
					  $spiega =  $rigap[spiega_en];
				  break;
				}
					$tendina_sped .= '<option selected value="'.$rigap[id].'">'.$descr.'</option>';
				  } else {
					$tendina_sped .= '<option value="'.$rigap[id].'">'.$descr.'</option>';
				  }
			  }
			  echo '<select name="spedizione" id="spedizione" class="codice_lista_nopadding" style="height:27px;" onchange="aggiorna_spiega_sped(this.value)">'.$tendina_sped.'</select>';
		echo '</div>';
		echo '<div id="spiega_sped" style="width:240px; margin-top:5px; font-size:12px; min-height: 20px; float: left; font-weight: bold;">';
		echo $spiega;
		echo '</div>';
	  }
}
*/



//echo "flusso: ".$flusso."<br>";
//echo "array flusso: ";
//print_r($array_flusso_BMC);
//echo "<br>";
//echo "extra_flusso: ".$extra_flusso."<br>";
if (in_array($flusso, $array_flusso_BMC)) {
  if ($extra_flusso != "") {
	  $array_particolari = explode(",",$extra_flusso);
	  foreach($array_particolari as $sing_partic) {
//echo "sing_partic: ".$sing_partic."<br>";
		echo '<div id="scelte" style="width:240px; margin-top:10px; font-size:12px; min-height: 20px; float: left;">';
		$sqld = "SELECT * FROM qui_flussi_extra WHERE flusso = '$flusso' AND extra = '$sing_partic'";
		$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		  while ($rigad = mysql_fetch_array($risultd)) {
			switch ($lingua) {
			  case "it":
				  $particolare = $rigad[descrizione_it];
			  break;
			  case "en":
				  $particolare = $rigad[descrizione_en];
			  break;
			}
			$sqlg = "SELECT * FROM ".$rigad[tab_extra_collegata]." ORDER BY id ASC";
			$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigag = mysql_fetch_array($risultg)) {
				  if ($rigag[def] == 1) {
					$blocco_opzioni .= '<option selected value="'.$rigag[cod].'">'.$rigag[descrizione].'</option>';
				  } else {
					$blocco_opzioni .= '<option value="'.$rigag[cod].'">'.$rigag[descrizione].'</option>';
				  }
			  }
			}
			$sost_select = '<select class="codice_lista_nopadding" style="height:27px; margin-top: 10px;" name=';
		  $particolare = str_replace("<select name=",$sost_select,$particolare);
		  $particolare = str_replace("*opzioni*",$blocco_opzioni,$particolare);
		  echo $particolare;
		  $blocco_opzioni = '';
		}
	echo '</div>';
  }
}

echo '</div>';
if (in_array($categoria1,$array_eccezioni_bomb)) {
	echo '<div id="avvisi_pacco" style="width:100%; margin-top:10px; float:left; font-size:12px; height:200px;"></div>';
}
echo '</div>';
    
    echo '<div style="border:1px solid rgb(0,0,0); width:100%; height:80px; float:left; margin-bottom:20px;">
      <div class="contenitore_filo" style="border:none;">
      <div class="titolo_colonna" style="height:25px; margin-left:20px;">';
     //echo $descrizione_art."<br>".ucfirst($confezione);
	  echo $descrizione_art.'<br>';
	  echo $categoria4;
  echo '</div>
      <div id="risultati" class="titolo_colonna" style="height:15px; width:310px;">
     <div class="colonnino_interno_riga_dispari" style="width:125px; float:none; margin-left:10px;">';
        echo $dic_quant;
  echo '</div>
     <div class="colonnino_interno_riga_dispari" style="width:125px; float:none; margin-left:10px;">';
        echo $dic_prezzo;
  echo '</div>
  </div>

    </div>
    <div style="width:100%; margin-top:60px; float:right;">';
				switch ($lingua) {
					case "it":
					$puls_carr = "Inserisci nel carrello";
					break;
					case "en":
					$puls_carr = "Add to cart";
					break;
					}
    echo '<div id="pulsante_invio">';
   echo '<input type="submit" name="submit" style="float:right; height:25px;" onClick="validateForm()" id="submit" value="'.$puls_carr.'" disabled>
      </div>
    <div id="deposito_id">
      <input type="hidden" name="id_prod" id="id_prod" value="'.$id_prod.'">
      <input type="hidden" name="prezzo_pescante" id="prezzo_pescante" value="'.$prezzo_pescante.'">
      <input type="hidden" name="negozio" id="negozio" value="'.$negozio.'">
      <div id="tip_dep">
        <input type="hidden" name="tipologia" id="tipologia" value="'.$tipologia.'">
      </div>
    </div>

    </div>
  </div>';
?>
</div>   
</form>

<script type="text/javascript">
function aggiorna_quant(id,mode){
	$("#quant_publiem").val("");
	$("#custom_qty").val("");
	$("#prezzo_calcolato").html("<?php echo $dic_altre_quant; ?>").show();
	$("#avviso_rosso").html("");
						/*alert(mode);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_quant_etich.php",   
						data: "id="+id+"&mode="+mode+"&id_prod=<?php echo $id_prod; ?>"+"&negozio=<?php echo $negozio; ?>",
						success: function(output) {
						$('#risultati').html(output).show();
						}
						})
	$.ajax({
			type: "GET",   
			url: "aggiorna_bottone_invio.php",   
			data: "id="+id+"&mode="+mode+"&id_prod=<?php echo $id_prod; ?>"+"&negozio=<?php echo $negozio; ?>",
			success: function(output) {
			$('#pulsante_invio').html(output).show();
			}
			})
	$.ajax({
			type: "GET",   
			url: "aggiorna_quant_nasc.php",   
			data: "id="+id+"&mode="+mode+"&id_prod=<?php echo $id_prod; ?>"+"&negozio=<?php echo $negozio; ?>",
			success: function(output) {
			$('#quant_nasc').html(output).show();
			}
			})

}
function aggiorna_quant2(quant,mode,tipologia){
	$("#custom_qty").val("");
	$('input[name="quant"]').prop('checked', false);
	$("#prezzo_calcolato").html("<?php echo $dic_altre_quant; ?>").show();
  var id_prod = document.getElementById('id_prod').value;
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_quant_etich.php",   
	  data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&id_prod="+id_prod+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#risultati').html(output).show();
	  }
	})
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_tipologia.php",   
	  data: "tipologia="+tipologia+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#tip_dep').html(output).show();
	  }
	})
	/*alert(tipologia);*/
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_avvisiquant.php",   
	  data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&id_prod="+id_prod+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#avviso_rosso').html(output).show();
	  }
	})
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_quant_nasc.php",   
	  data: "quant="+quant+"&mode="+mode+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#quant_nasc').html(output).show();
	  }
	})
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_bottone_invio.php",   
	  data: "quant="+quant+"&mode="+mode+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#pulsante_invio').html(output).show();
	  }
	})
}

function aggiornamento_pacchi(conf){
  $.ajax({
	type: "GET",   
	url: "aggiorna_campo_note_bomb.php",   
	data: "conf="+conf,
	success: function(output) {
	$('#note_bombole').html(output).show();
	}
  })
  $.ajax({
	type: "GET",   
	url: "aggiorna_bottone_invio_bomb.php",   
	data: "conf="+conf,
	success: function(output) {
	$('#pulsante_invio').html(output).show();
	}
  })
}

function aggiorna_solo_bottone_invio_bomb(conf){
  $.ajax({
	type: "GET",   
	url: "aggiorna_bottone_invio_bomb.php",   
	data: "conf="+conf,
	success: function(output) {
	$('#pulsante_invio').html(output).show();
	}
  })
}

function aggiorna_pacchi(quant,mode,tipologia){
var id_prod = document.getElementById('id_prod').value;
	$("#quant_publiem").val("");
	$('input[name="quant"]').prop('checked', false);
	var id_prod = document.getElementById('id_prod').value;
	var prezzo_pescante = document.getElementById('prezzo_pescante').value;
  $.ajax({
	type: "GET",   
	url: "aggiorna_quant_etich.php",   
	data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&prezzo_pescante="+prezzo_pescante+"&id_prod="+id_prod+"&negozio=<?php echo $negozio; ?>",
	success: function(output) {
	$('#risultati').html(output).show();
	}
  })
  $.ajax({
	type: "GET",   
	url: "aggiorna_quant_etich.php",   
	data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&prezzo_pescante="+prezzo_pescante+"&id_prod="+id_prod+"&rid=1"+"&negozio=<?php echo $negozio; ?>",
	success: function(output) {
	$('#prezzo_calcolato').html(output).show();
	}
  })
  $.ajax({
	type: "GET",   
	url: "aggiorna_quant_nasc.php",   
	data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&prezzo_pescante="+prezzo_pescante+"&id_prod="+id_prod+"&negozio=<?php echo $negozio; ?>",
	success: function(output) {
	$('#quant_nasc').html(output).show();
	}
  })
  $.ajax({
	type: "GET",   
	url: "aggiorna_quant_nasc.php",   
	data: "mode="+mode+"&ads=1"+"&lang=<?php echo $lingua; ?>&id_prod=<?php echo $id_prod; ?>"+"&negozio=<?php echo $negozio; ?>",
	success: function(output) {
	$('#messaggi').html(output).show();
	}
  })
  $.ajax({
	type: "GET",   
	url: "aggiorna_package.php",   
	data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&id_prod="+id_prod+"&negozio=<?php echo $negozio; ?>"+"&lang=<?php echo $lingua; ?>",
	success: function(output) {
	$('#avvisi_pacco').html(output).show();
	}
  })
}

function aggiorna_quant3(quant,mode,tipologia){
	/*alert(quant);*/
	$("#quant_publiem").val("");
	$('input[name="quant"]').prop('checked', false);
	var id_prod = document.getElementById('id_prod').value;
	var prezzo_pescante = document.getElementById('prezzo_pescante').value;
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_quant_etich.php",   
	  data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&prezzo_pescante="+prezzo_pescante+"&id_prod="+id_prod+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#risultati').html(output).show();
	  }
	})
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_quant_etich.php",   
	  data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&prezzo_pescante="+prezzo_pescante+"&id_prod="+id_prod+"&rid=1"+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#prezzo_calcolato').html(output).show();
	  }
	})
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_quant_nasc.php",   
	  data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&prezzo_pescante="+prezzo_pescante+"&id_prod="+id_prod+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#quant_nasc').html(output).show();
	  }
	})
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_bottone_invio.php",   
	  data: "quant="+quant+"&mode="+mode+"&tipologia="+tipologia+"&prezzo_pescante="+prezzo_pescante+"&id_prod="+id_prod+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#pulsante_invio').html(output).show();
	  }
	})
	$.ajax({
	  type: "GET",   
	  url: "aggiorna_quant_nasc.php",   
	  data: "mode="+mode+"&ads=1"+"&lang=<?php echo $lingua; ?>&id_prod=<?php echo $id_prod; ?>"+"&negozio=<?php echo $negozio; ?>",
	  success: function(output) {
	  $('#messaggi').html(output).show();
	  }
	})
}
function aggiorna_spiega_sped(id){
  $.ajax({
	type: "GET",   
	url: "aggiorna_spiega_sped.php",   
	data: "id="+id+"&lang=<?php echo $lingua; ?>",
	success: function(output) {
	$('#spiega_sped').html(output).show();
	}
  })
}
function goToCylinders(){
	//alert("chiuditi");
window.parent.TINY.box.hide();
window.parent.location.href = "ricerca_assets.php?limit=&page=1&negozio=assets&categoria1=Bombole&lang=<?php echo $lingua; ?>";
}
function chiudi_finestra(){
this.hide();
}
</script>
</body>
</html>