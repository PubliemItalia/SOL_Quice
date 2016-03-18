<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$lingua = $_GET[lang];
$id = $_GET[id];
$negozio = $_GET[negozio];
$prezzo_pescante_variato = $_GET[prezzo_pescante];
switch ($lingua) {
  case "it":
  $code = "Codice";
  $price = "Prezzo";
  $inserisci_carrello = "Inserisci nel carrello";
  $scheda_tecnica = "Scheda tecnica";
  $voce_stampa = "Stampa";
  $add_favoriti = "Aggiungi ai preferiti";
  $elim_favoriti = "Elimina dai preferiti";
  $gallery = "Galleria immagini";
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
  $bomb_compl = "Whole cylinder";
  break;
}

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($rigak = mysql_fetch_array($result)) {
  //recupero informazioni valvola
  if ($rigak[id_valvola] != "") {
	$sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_valvola]'";
	$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
	while ($rigam = mysql_fetch_array($risultm)) {
	  $prezzo_valvola = $rigam[prezzo];
	}
  }
  //recupero informazioni cappellotto
  if ($rigak[id_cappellotto] != "") {
	$sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_cappellotto]'";
	$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
	while ($rigan = mysql_fetch_array($risultn)) {
	  $prezzo_cappellotto = $rigan[prezzo];
	}
  }
  //recupero informazioni pescante
  switch ($rigak[id_pescante]) {
	  case "":
		$prezzo_pescante = "0";
	  break;
	  case "NO":
		$prezzo_pescante = "0";
	  break;
	  case "SI":
		$prezzo_pescante = "4";
	  break;
  }
$out = "<span style=\"color:rgb(0,0,0);\">bomb ".$rigak[prezzo]." valv ".$prezzo_valvola." capp ".$prezzo_cappellotto." pesc ".$prezzo_pescante."</span>";
  if ($prezzo_pescante_variato > 0) {
	$prezzo_totale = $rigak[prezzo]+$prezzo_valvola+$prezzo_cappellotto+$prezzo_pescante_variato;
  } else {
	$prezzo_totale = $rigak[prezzo]+$prezzo_valvola+$prezzo_cappellotto+$prezzo_pescante;
  }
	  $div_dati .= "<div class=\"Titolo_famiglia_bombole\" style=\"width:250px; height:auto; margin-bottom:5px; float:right; font-size:12px; text-align:right;\">";
		$div_dati .= "<span style=\"font-weight:normal;\">".$code."</span> ";
		$div_dati .= $rigak[codice_art];
	  $div_dati .= "</div>"; 
	  $div_dati .= "<div class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:340px; height:auto; text-align:right; color:#0079ca; float:right\">";
		$div_dati .= "<span style=\"font-weight:normal;\">".$price." ".$bomb_compl."</span> ".number_format($prezzo_totale,2,",",".");
	  $div_dati .= "</div>";
	  $div_dati .= "<div id=componente_dati class=componente_dati_bombola style=\"margin-left:5px; width:340px; height:auto; text-align:right; float:right; margin-top:25px; font-family:Arial;\">";
		//echo "<div class=\"scritte_bottoncini_bomb\" style=\"width:130px;\">";
		  switch ($_SESSION[lang]) {
			case "it":
			  $div_dati .= "<strong>Costi orientativi.<br>Contattare i buyer per i prezzi aggiornati!</strong>";
			break;
			case "en":
			  $div_dati .= "<strong>Costs may not be real.<br>Please contact buyers for updated prices!</strong>";
			break;
		  }
		//echo "</div>"; 
	  //fine div componente_dati_bombola
	  $div_dati .= "</div>";
}
//output finale
	echo $div_dati;
//	echo "out";

?>
