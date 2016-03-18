<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$lingua = $_GET[lang];
$id = $_GET[id];
$negozio = $_GET[negozio];
switch ($lingua) {
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

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$testoQuery = "SELECT * FROM qui_prodotti_labels WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($row = mysql_fetch_array($result)) {
switch ($_SESSION[lang]) {
case "it":
$descr_prod_scelta = $row[descrizione1_it];
break;
case "en":
$descr_prod_scelta = $row[descrizione1_en];
break;
case "fr":
$descr_prod_scelta = $row[descrizione_fr];
break;
case "de":
$descr_prod_scelta = $row[descrizione_de];
break;
case "es":
$descr_prod_scelta = $row[descrizione_es];
break;
}

if ($descr_prod_scelta == "") {
$descr_prod_scelta = $row[descrizione1_it];
}

//dati fondamentali da visualizzare
$confezione = $row[confezione];
$codice = $row[codice_art];
$gruppo_merci = $row[gruppo_merci];
$descrizione = $row[categoria4_it];
$prezzo = $row[prezzo];
//fine while
}
//$div_dati .= "<div id=dati_".$riga." class=blocco_dati>";
			  $div_dati .= "<div class=scritte_bottoncini>".$code."</div>"; 
			  $div_dati .= "<div class=bottoncini>";
			  if (substr($codice,0,1) != "*") {
				$div_dati .= $codice;
			  } else {
				$div_dati .= substr($codice,1);
			  }
			  $div_dati .= "</div>";
			  $div_dati .= "<div class=scritte_bottoncini>".$price."</div>"; 
		$div_dati .= "<div class=bottoncini>";
		if ($prezzo > 0) {
			$div_dati .= number_format($prezzo,2,",",".");
		} else {
		  switch ($_SESSION[lang]) {
			case "it":
			  $div_dati .= "da calcolare";
			break;
			case "en":
			  $div_dati .= "to be quoted";
			break;
		  }
		}
		$div_dati .= "</div>";
			  $div_dati .= "<div class=scritte_bottoncini>".$package."</div>"; 
			  $div_dati .= "<div class=bottoncini>";
			  switch ($_SESSION[lang]) {
				case "it":
				  $div_dati .= $confezione;
				break;
				case "en":
				$conf = str_replace("confezioni da", "package of",$confezione);
				$conf = str_replace("blocchi da", "blocks of",$conf);
				$conf = str_replace("fogli da", "sheets of",$conf);
				$conf = str_replace("blister singoli", "one piece",$conf);
				$conf = str_replace("bustina singola", "one bag",$conf);
				$conf = str_replace("etichetta singola", "one label",$conf);
				$conf = str_replace("etichette", "labels",$conf);
				$conf = str_replace("fogli", "sheets",$conf);
				$conf = str_replace("bustine", "bags",$conf);
				  $div_dati .= $conf;
				break;
			  }

	//output finale
	echo $div_dati;
?>
