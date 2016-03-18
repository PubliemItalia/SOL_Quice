<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$lingua = $_SESSION[lang];
$id = $_GET[id];
$negozio = $_GET[negozio];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
	$sqlx = "SELECT * FROM qui_buyer_funzioni WHERE user_id = '$_SESSION[user_id]'";
            $risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione8" . mysql_error());
            while($rigax = mysql_fetch_array($risultx)) {
				$vis_report = $rigax[F_report];
				$vis_fatturazione = $rigax[F_fatturazione];
				$vis_gestione = $rigax[F_gestione];
				$vis_magazzino = $rigax[F_magazzino];
				$vis_admin = $rigax[F_amm_prodotti];
				$vis_ordini = $rigax[F_amm_ordini];
			  }
$sqlm = "SELECT * FROM qui_prodotti_labels WHERE id = '$id' ORDER BY id ASC";
				$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
				while ($rigam = mysql_fetch_array($risultm)) {

//componente bottoni
			  $div_dati .= "<div class=comandi>";
			  $div_dati .= "</div>"; 
			  $div_dati .= "<div class=comandi>";
			  $nome_gruppo = mt_rand(1000,9999);
			  //operazioni di costruzione della gallery
			if ($rigam[negozio] == "labels") {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigam[codice_art]' AND precedenza = '3'";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
				while ($rigaz = mysql_fetch_array($risultz)) {
					$div_dati .= "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  }
				  } else {
			  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigam[codice_art]' ORDER BY precedenza ASC";
			  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $num_img = mysql_num_rows($risultz);
			  if ($num_img > 0) {
				$a = 1;
				while ($rigaz = mysql_fetch_array($risultz)) {
				  if ($a == 1) {
					$div_dati .= "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>".$gallery."</span></a> ";
				  } else {
					$div_dati .= "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]></a> ";
				  }
				$a = $a + 1;
				}
			  }
			}
			  //fine  costruzione gallery
			  $div_dati .= "</div>"; 
			  $div_dati .= "<div class=comandi>";
			  if ($rigam[percorso_pdf] != "") {
				$div_dati .= "<a href=documenti/".$rigam[percorso_pdf]." target=_blank>";
				$div_dati .= "<span class=pulsante_scheda>";
				switch ($lingua) {
				  case "it":
				  $div_dati .= "Scheda tecnica";
				  break;
				  case "en":
				  $div_dati .= "Technical sheet";
				  break;
				}
			  $div_dati .= "</span>";
			  $div_dati .= "</a>";
			  }
			  $div_dati .= "</div>"; 
			  $div_dati .= "<div class=comandi_spazio>";
			  $div_dati .= "</div>"; 
			  $sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigam[id]' AND id_utente = '$_SESSION[user_id]'";
			  $risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  $preferiti_presenti = mysql_num_rows($risulteee);
			  if ($preferiti_presenti > 0) {
				$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigam[id]."&negozio_prod=".$rigam[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				$div_dati .= "<div class=comandi>";
				$div_dati .= "<span class=pulsante_preferiti>";
				switch ($lingua) {
				  case "it":
				  $div_dati .= "Elimina dai preferiti";
				  break;
				  case "en":
				  $div_dati .= "Remove from favourites";
				  break;
				}
				$div_dati .= "</span>";
			  } else {
				$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$rigam[negozio]."&id_prod=".$rigam[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				$div_dati .= "<div class=comandi>";
				$div_dati .= "<span class=pulsante_preferiti>";
				switch ($lingua) {
				  case "it":
				  $div_dati .= "Aggiungi ai preferiti";
				  break;
				  case "en":
				  $div_dati .= "Add to favourites";
				  break;
				}
				$div_dati .= "</span>";
			  }
			  $div_dati .= "</div>"; 
			  $div_dati .= "</a>";
			  $div_dati .= "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigam[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
			  $div_dati .= "<div class=comandi>";
			  $div_dati .= "<span class=pulsante_stampa>";
			  switch ($lingua) {
				case "it":
				$div_dati .= "Stampa";
				break;
				case "en":
				$div_dati .= "Print";
				break;
			  }
			  $div_dati .= "</span>";
			  $div_dati .= "</div>"; 
			  $div_dati .= "</a>";
			  $div_dati .= "<div class=comandi_spazio>";
			  $div_dati .= "</div>"; 
			  $div_dati .= "<div class=comandi>";
			  $modulo = "popup_modifica_scheda.php";
			  /*if ($vis_admin == 1) {
				$div_dati .= "<a href=".$modulo."?action=edit&id=".$rigam[id]."&negozio=".$rigam[negozio]."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
			  }*/
			  $div_dati .= "</div>"; 
	
			  $div_dati .= "<div class=spazio_puls_carrello>";
			  $div_dati .= "</div>"; 
			  if ($rigam[extra] != "") {
				switch ($lingua) {
				  case "it":
				  $scritta_puls = "Scegli quantit&agrave;";
				  break;
				  case "en":
				  $scritta_puls = "Choose quantity";
				  break;
				}
				if ($rigam[ordine_stampa] == 1) {
				  $div_dati .= "<div class=pulsante_carrello title=\"$scritta_puls\">";
				} else {
				  $div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigam[negozio]."&id_prod=".$rigam[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
				  $div_dati .= $scritta_puls;
				}
				$div_dati .= "</div></a>";
			  } else {
				if ($rigam[ordine_stampa] == 1) {
				  $div_dati .= "<div class=pulsante_carrello title=\"$scritta_puls\">";
				} else {
				  $div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$rigam[negozio]."&id_prod=".$rigam[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">";
				  switch ($lingua) {
					case "it":
					$div_dati .= "Inserisci nel carrello";
					break;
					case "en":
					$div_dati .= "Add to cart";
					break;
				  }
				  $div_dati .= "</div></a>";
				}
			  }
			}
				

	//output finale
	echo $div_dati;






?>
