<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$lingua = $_GET[lang];
$id = $_GET[id];
$negozio = $_GET[negozio];
$famiglia = $_GET[famiglia];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$testoQuery = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($rigak = mysql_fetch_array($result)) {
  switch ($lingua) {
	case "it":
	  $desc_bomb = $rigak[descrizione1_it];
	break;
	case "en":
	  if ($rigak[descrizione1_en] != "") {
		$desc_bomb = $rigak[descrizione1_en];
	  } else {
		$desc_bomb = $rigak[descrizione1_it];
	  }
	break;
	
  }
 $prezzo_corpo = $rigak[prezzo];
 
  //recupero informazioni valvola
if ($rigak[id_valvola] != "") {
  $sqlm = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigak[id_valvola]'";
  $risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
  while ($rigam = mysql_fetch_array($risultm)) {
	$prezzo_valvola = $rigam[prezzo];
	switch ($_SESSION[lang]) {
	  case "it":
//		$descr_valvola = $rigak[id_valvola]." ".$rigam[descrizione1_it];
		$descr_valvola = $rigam[descrizione1_it];
	  break;
	  case "en":
		if ($rigam[descrizione1_en] != "") {
		  $descr_valvola = $rigam[descrizione1_en];
		} else {
		  $descr_valvola = $rigam[descrizione1_it];
		}
	  break;
	}
		$descr_valvola .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'scheda_visuale.php?schedaVis=1&categoria1=Valvole&categoria2=".$rigam[categoria2_it]."&categoria3=".$rigam[categoria3_it]."&negozio=assets&codice_art=".$rigam[codice_art]."&lang=".$_SESSION[lang]."&id_utente=".$_SESSION[user_id]."',boxid:'frameless960',width:960,height:310,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});\">";
	$descr_valvola .= " <span style=\"color:#666; text-decoration:none; font-weight:normal; font-size:12px;\">";
	switch ($_SESSION[lang]) {
	  case "it":
		$descr_valvola .= "Scheda";
	  break;
	  case "en":
		$descr_valvola .= "Sheet";
	  break;
	}
	$descr_valvola .= "</a>";

  }
}


//recupero informazioni cappellotto
if ($rigak[id_cappellotto] != "") {
  $sqln = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$rigak[id_cappellotto]'";
  $risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
  while ($rigan = mysql_fetch_array($risultn)) {
	$prezzo_cappellotto = $rigan[prezzo];
	switch ($_SESSION[lang]) {
	  case "it":
		stripslashes($descr_cappellotto = $rigan[descrizione1_it]);
	  break;
	  case "en":
		if ($rigan[descrizione1_en] != "") {
		  stripslashes($descr_cappellotto = $rigan[descrizione1_en]);
		} else {
		  stripslashes($descr_cappellotto = $rigan[descrizione1_it]);
		}
	  break;
	}
  }
}




$div_dati .= "<div class=\"Titolo_famiglia_bombole\" style=\"width:490px; height:71px; margin-bottom:2px;\">";
	  $div_dati .= $desc_bomb."<br>".$descr_valvola."<br>".$descr_cappellotto."<br>";
  		//***********************************************************
		$div_dati .= "<input type=hidden name=id".$famiglia." id=id".$famiglia." value=".$id.">";
		//***********************************************************

	  $div_dati .= "</div>";
	  $div_dati .= "<div class=\"Titolo_famiglia_bombole\" style=\"margin-left:5px; width:40px; height:auto; text-align:right; font-size:12px; font-weight:normal; line-height:140%;\">";
		$div_dati .= number_format($prezzo_corpo,2,",",".")."<br>";
		if ($rigak[id_valvola] != "") {
			$div_dati .= number_format($prezzo_valvola,2,",",".");
		}
	  $div_dati .= "<br>";
		if ($rigak[id_cappellotto] != "") {
		  $div_dati .= number_format($prezzo_cappellotto,2,",",".");
		}
	  $div_dati .= "</div>"; 
  }

//output finale
	echo $div_dati;
//	echo $id;
?>
