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
  $price = "Prezzo";
  $inserisci_carrello = "Inserisci nel carrello";
  $scheda_tecnica = "Scheda tecnica";
  $voce_stampa = "Stampa";
  $add_favoriti = "Aggiungi ai preferiti";
  $elim_favoriti = "Elimina dai preferiti";
  $gallery = "Galleria immagini";
  $dic_pesc_con = "Con pescante";
  $dic_pesc_senza = "Senza pescante";
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
  $dic_pesc_con = "With pescante";
  $dic_pesc_senza = "Without pescante";
break;
}
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($rigak = mysql_fetch_array($result)) {
  switch ($lingua) {
	case "it":
	$mat_bomb = "Bombola in ".$rigak[materiale];
	$cat3_bomb = $rigak[categoria3_it];
	$desc2_bomb = $rigak[descrizione2_it];
	break;
	case "en":
	if ($rigak[descrizione2_en] != "") {
	$mat_bomb = "Bombola in ".$rigak[materiale];
	$cat3_bomb = $rigak[categoria3_en];
	$desc2_bomb = $rigak[descrizione2_en];
	} else {
	$mat_bomb = "Bombola in ".$rigak[materiale];
	$cat3_bomb = $rigak[categoria3_it];
	$desc2_bomb = $rigak[descrizione2_it];
	}
	break;
  }
  
  //recupero informazioni valvola
  if ($rigak[id_valvola] != "") {
	$sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_valvola]'";
	$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
	//echo "<br>query:".$sqlk."<br>";
	while ($rigam = mysql_fetch_array($risultm)) {
	  $prezzo_valvola = $rigam[prezzo];
	  switch ($lingua) {
		case "it":
		$descr_valvola = $rigak[id_valvola]." ".$rigam[descrizione2_it];
		break;
		case "en":
		if ($rigam[descrizione2_en] != "") {
		$descr_valvola = $rigam[descrizione2_en];
		} else {
		$descr_valvola = $rigam[descrizione2_it];
		}
		break;
	  }
	}
  }


				$div_dati .= "<div class=Titolo_famiglia_bombole>".str_replace("_"," ",$cat3_bomb)." - ".$mat_bomb."<br>".$descr_valvola."</div>";
				$div_dati .= "<div class=descr_famiglia>".stripslashes($desc2_bomb).stripslashes($punzonatura)." - <strong>".$rigak[prezzo]."</strong></div>";
	  if ($rigak[id_valvola] != "") {
				$div_dati .= "<div class=descr_famiglia>";
				$div_dati .= stripslashes($descr_valvola);
				$div_dati .= " - <strong>".$prezzo_valvola." &euro;</strong>";
				$descr_valvola = "";
				$div_dati .= "</div>";
	  }
				//recupero informazioni cappellotto
				if ($rigak[id_cappellotto] != "") {
		$sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_cappellotto]'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
		//echo "<br>query:".$sqlk."<br>";
		while ($rigan = mysql_fetch_array($risultn)) {
			$prezzo_cappellotto = $rigan[prezzo];
				$div_dati .= "<div class=descr_famiglia>";
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
				$div_dati .= stripslashes($descr_cappellotto);
				$div_dati .= " - <strong>".$prezzo_cappellotto." &euro;</strong>";
				$div_dati .= "</div>";
		}
				}
				//recupero informazioni pescante
		  $div_dati .= "<span style=\"font-weight:normal; font-size:12px;\">".$dic_pesc_senza."<input type=radio name=pescante value=n id=pescante_0>";
		  $div_dati .= $dic_pesc_con."<input type=radio name=pescante value=y id=pescante_1></span>";
  
}

//output finale
	echo $div_dati;
//	echo $id;
?>
