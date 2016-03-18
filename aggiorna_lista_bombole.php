<?php
session_start();
$materiale = $_GET[materiale];
$pressione = $_GET[pressione];
$capacita = $_GET[capacita];
$_SESSION[materiale] = $materiale;
$_SESSION[pressione] = $pressione;
$_SESSION[capacita] = $capacita;
$lang = $_SESSION[lang];
$categoria1 = $_SESSION[categoria1];
$categoria2 = $_SESSION[categoria2];
$categoria3 = $_SESSION[categoria3];
$categoria4 = $_SESSION[categoria4];
$paese = $_SESSION[paese];
$id_valvola = $_SESSION[id_valvola];
$negozio = $_SESSION[negozio];
switch ($_SESSION[lang]) {
  case "it":
  $code = "Codice";
  $price = "Prezzo";
  $inserisci_carrello = "Inserisci nel carrello";
  $scheda_tecnica = "Scheda tecnica";
  $voce_stampa = "Stampa";
  $add_favoriti = "Aggiungi ai preferiti";
  $elim_favoriti = "Elimina dai preferiti";
  $gallery = "Galleria immagini";
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
  break;
}

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

//costruzione query
$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE obsoleto = '0' AND negozio = '$negozio' AND categoria1_it = '$categoria1' AND categoria2_it = '$categoria2' AND categoria3_it = '$categoria3' AND id_valvola = '$id_valvola' AND paese = '$paese' "; 

if ($materiale != "") {
$testoQuery .= "AND materiale = '$materiale' ";
}
if ($pressione != "") {
$testoQuery .= "AND pressione = '$pressione' ";
}
if ($capacita != "") {
$testoQuery .= "AND categoria4_it = '$capacita' ";
}

$testoQuery .= " ORDER BY materiale ASC, categoria4_it ASC, pressione ASC";




$risultk = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione7" . mysql_error());

		while ($rigak = mysql_fetch_array($risultk)) {

				$output .= "<div id=riquadro_bombole>";
				//$output .= "<a href=\"javascript:void(0);\" onClick=\"aggiornaCaratteristiche(".$capo_famiglia.");\">";
				$output .= "<div id=raggruppamento>";
				$output .= "<div id=componente_descrizione".$ord." class=componente_descrizione_bombola>";
				switch ($_SESSION[lang]) {
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

				$output .= "<div class=Titolo_famiglia>".str_replace("_"," ",$cat3_bomb)." - ".$mat_bomb."</div>";
				$output .= "<div class=descr_famiglia>".stripslashes($desc2_bomb)." - <strong>".$rigak[prezzo]."</strong></div>";
				//recupero informazioni valvola
				if ($rigak[id_valvola] != "Senza_valvola") {
		$sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_valvola]'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
		//echo "<br>query:".$sqlk."<br>";
		while ($rigam = mysql_fetch_array($risultm)) {
			$prezzo_valvola = $rigam[prezzo];
				$output .= "<div class=descr_famiglia>";
					switch ($_SESSION[lang]) {
							case "it":
							$descr_valvola = $rigam[descrizione2_it];
							break;
							case "en":
							if ($rigam[descrizione2_en] != "") {
							$descr_valvola = $rigam[descrizione2_en];
							} else {
							$descr_valvola = $rigam[descrizione2_it];
							}
							break;
						}
				$output .= stripslashes($descr_valvola);
				$output .= " - <strong>".$prezzo_valvola." &euro;</strong>";
				$output .= "</div>";
		}
				}
				//recupero informazioni cappellotto
				if ($rigak[id_cappellotto] != "") {
		$sqln = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$rigak[id_cappellotto]'";
$risultn = mysql_query($sqln) or die("Impossibile eseguire l'interrogazione5bis" . mysql_error());
		//echo "<br>query:".$sqlk."<br>";
		while ($rigan = mysql_fetch_array($risultn)) {
			$prezzo_cappellotto = $rigan[prezzo];
				$output .= "<div class=descr_famiglia>";
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
				$output .= stripslashes($descr_cappellotto);
				$output .= " - <strong>".$prezzo_cappellotto." &euro;</strong>";
				$output .= "</div>";
		}
				}
				//recupero informazioni pescante
		if ($rigak[id_pescante] == "SI") {
			$prezzo_pescante = "5.00";
		}

				//$output .= "<div id=variante class=Titolo_famiglia>".stripslashes($rigak[categoria4_it])."</div>";
				$output .= "</div>";
				//$output .= "<div id=risultato>";
				$output .= "<div id=componente_dati".$ord." class=componente_dati_bombola>";
				
				//$output .= "<span class=Titolo_bianco_xspazio>DATI</span><br>";
				$output .= "<div class=Titolo_famiglia></div>"; 
				$output .= "<div class=scritte_bottoncini>".$code."</div>"; 
				$output .= "<div class=bottoncini>".$rigak[codice_art]."</div>";
				$output .= "<div class=scritte_bottoncini>".$price."</div>"; 
				$prezzo_totale = $rigak[prezzo]+$prezzo_valvola+$prezzo_cappellotto+$prezzo_pescante;
				$output .= "<div class=bottoncini>".number_format($prezzo_totale,2,",",".")."</div>";
				$output .= "<div class=scritte_bottoncini><br></div>"; 
				$output .= "<div class=bottoncini><br></div>";
						$output .= "<div class=scritte_bottoncini>";
						switch ($_SESSION[lang]) {
							case "it":
							$output .= "<br><br><strong>Costi orientativi.<br>Contattare i buyer per i prezzi aggiornati!</strong>";
							break;
							case "en":
							$output .= "<br><br><strong>Costs may not be real.<br>Please contact buyers for updated prices!</strong>";
							break;
						}
						$output .= "</div>"; 
				$output .= "</div>";
				//fine div raccoglitore
				$output .= "</div>";
				//**********************************
				//**********************************
				$prezzo_pescante = "";
				$prezzo_valvola = "";
				$prezzo_cappellotto = "";

// Read the image
//$fondo = new Imagick("componenti/fondo.png");
$corpo = new Imagick("componenti/bombole/".str_replace(" ","_",$rigak[descrizione3_it]).".png");
$ogiva = new Imagick("componenti/ogiva/".str_replace(" ","_",$rigak[descrizione4_it]).".png");
$valvola = new Imagick("componenti/valvola/".str_replace(" ","_",$rigak[id_valvola]).".png");
$cappellotto = new Imagick("componenti/cappellotto/".str_replace(" ","_",$rigak[id_cappellotto]).".png");


// Clone the image and flip it 
$bombola = $corpo->clone();

// Composite i pezzi successivi sopra il fondo in questo ordine 
//$bombola->compositeImage($corpo, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($ogiva, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($valvola, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($cappellotto, imagick::COMPOSITE_OVER, 0, 0);
$timecode= date("dmYHi",time());
$nomefile = "temp_bombole/".$timecode."_".$rigak[codice_art].".png";
$bombola->writeImage($nomefile);
//************************************
//*************************************
				$output .= "<div id=componente_immagine".$ord." class=componente_immagine_bombola>";
				$output .= "<img src=".$nomefile." width=248 height=248>";
				$output .= "</div>";
		//componente bottoni
		$output .= "<div id=componente_bottoni".$ord." class=componente_bottoni_bombole>";
		//modulo con pulsanti attivi
		$output .= "<div class=comandi>";
		$output .= "</div>"; 
		$output .= "<div class=comandi>";
		//$output .= "<span class=pulsante_galleria>Galleria immagini</span>";
		$output .= "</div>"; 
		$output .= "<div class=comandi>";
		$output .= "<span class=pulsante_scheda>".$scheda_tecnica."</span>";
		$output .= "</div>"; 
		$output .= "<div class=comandi_spazio>";
		$output .= "</div>"; 
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigaq[id]' AND id_utente = '$_SESSION[user_id]'";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
			if ($preferiti_presenti > 0) {
				$output .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigak[id]."&negozio_prod=".$rigak[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				$output .= "<div class=comandi>";
				$output .= "<span class=pulsante_preferiti>".$elim_favoriti."</span>";
			} else {
				$output .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				$output .= "<div class=comandi>";
				$output .= "<span class=pulsante_preferiti>".$add_favoriti."</span>";
			}
		$output .= "</div>"; 
		$output .= "</a>";
		$output .= "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$rigak[negozio]."&id=".$rigak[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		$output .= "<div class=comandi>";
		$output .= "<span class=pulsante_stampa>".$voce_stampa."</span>";
		$output .= "</div>"; 
		$output .= "</a>";
		$output .= "<div class=comandi_spazio>";
		$output .= "</div>"; 
		$output .= "<div class=comandi>";
			if ($categoria1 == "Bombole") {
				$modulo = "popup_modifica_scheda_bombola.php";
			} else {
				$modulo = "popup_modifica_scheda.php";
			}
		//$output .= "<a href=".$modulo."?action=edit&id=".$rigak[id]."&negozio=".$rigak[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
		$output .= "</div>"; 
/*		$output .= "<div class=comandi>";
		$output .= "<a href=".$modulo."?action=duplicate&id=".$rigak[id]."&negozio=".$rigak[negozio]."&lang=".$lingua."><span class=Stile3>".$duplicate."</span></a>";
		$output .= "</div>"; 
*/	
	
		$output .= "<div class=spazio_puls_carrello_bombole>";
		$output .= "</div>"; 
$output .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigak[negozio]."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">".$inserisci_carrello."</div></a>";
//$output .= "id: ".$rigaq[id]."<br>";
		
		//fine div componente_bottoni
		$output .= "</div>";
		//fine div riquadro_prodotto
		$output .= "</div>"; 
//fine while generale
		}
		
$output .= "<div class=barra_paginazione>";		
		//tabella navigazione tra le pagine
$output .= "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      $output .= "<tr>";
        $output .= "<td class=num_pag>";
//posizione per paginazione
$last_page = $total_pages;
   if ($total_pages <= 10) {
  	 	$pag_iniz = 1;
  	 	$pag_fin = $total_pages -1;
   } else {
	   if ($page < ($total_pages - 10)) {
			$pag_iniz = $page;
			$pag_fin = $page + 9;
	   } else {
			$pag_iniz = $total_pages - 10;
			$pag_fin = $total_pages -1;
	   }
   }
$prev_page = $page - 1;

if($prev_page >= 1) { 



  $output .= "<b></b> <a href=scheda_visuale_bombole.php?negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&id_valvola=".$id_valvola."&materiale=".$materiale."&pressione=".$pressione."&capacita=".$capacita."&limit=".$limit."&page=".$prev_page."&lang=".$lingua."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      $output .= ("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  $output .= ("  <a href=scheda_visuale_bombole.php?negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&id_valvola=".$id_valvola."&materiale=".$materiale."&pressione=".$pressione."&capacita=".$capacita."&limit=".$limit."&page=".$a."&lang=".$lingua."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   $output .= "<a href=scheda_visuale_bombole.php?negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&id_valvola=".$id_valvola."&materiale=".$materiale."&pressione=".$pressione."&capacita=".$capacita."&limit=".$limit."&page=".$next_page."&lang=".$lingua."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."><b>>></b></a>"; 
} 
   $output .= "<a href=scheda_visuale_bombole.php?negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&id_valvola=".$id_valvola."&materiale=".$materiale."&pressione=".$pressione."&capacita=".$capacita."&limit=".$limit."&page=".$last_page."&lang=".$lingua."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."><b>".$last_page."</b></a>"; 
        $output .= "</td>";
      $output .= "</tr>";
   $output .= "</table> ";
$output .= "<img src=immagini/spacer.gif width=25 height=25>";
    $output .= "</div>";
$output .= "</div>";

	//output finale
	echo $output;
?>
