<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$lingua = $_GET[lang];
$id = $_GET[id];
$negozio = $_GET[negozio];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$sqlm = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id' ORDER BY id ASC";
				$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
				while ($rigam = mysql_fetch_array($risultm)) {

//componente bottoni
		//$div_dati .= $negozio;
		$div_dati .= "<div class=comandi>";
		$div_dati .= "</div>"; 
		$div_dati .= "<div class=comandi>";
		//operazioni di costruzione della gallery
		$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigam[codice_art]' ORDER BY precedenza ASC";
		$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$num_img = mysql_num_rows($risultz);
		if ($num_img > 0) {
		$a = 1;
		while ($rigaz = mysql_fetch_array($risultz)) {
		if ($a == 1) {
		   $div_dati .= "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[roadtrip]><span class=pulsante_galleria>Galleria immagini</span></a> ";
		} else {
		  $div_dati .= "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[roadtrip]><span class=pulsante_galleria>Galleria immagini</span></a> ";
		}
		$a = $a + 1;
		}
		}
		//fine  costruzione gallery
		
		//$div_dati .= "<span class=pulsante_galleria>Galleria immagini</span>";
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
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$id' AND id_utente = '$_SESSION[user_id]'";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
			if ($preferiti_presenti > 0) {
				$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$id."&negozio_prod=".$negozio."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				$div_dati .= "<div class=comandi>";
				$div_dati .= "<span class=pulsante_preferiti>Elimina dai preferiti</span>";
			} else {
				$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$negozio."&id_prod=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				$div_dati .= "<div class=comandi>";
				$div_dati .= "<span class=pulsante_preferiti>Aggiungi ai preferiti</span>";
			}
		$div_dati .= "</div>"; 
		$div_dati .= "</a>";
		$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigam[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		$div_dati .= "<div class=comandi>";
		$div_dati .= "<span class=pulsante_stampa>Stampa</span>";
		$div_dati .= "</div>"; 
		$div_dati .= "</a>";
		$div_dati .= "<div class=comandi_spazio>";
		$div_dati .= "</div>"; 
		$div_dati .= "<div class=comandi>";
			if ($_SESSION[categoria1] == "Bombole") {
				$modulo = "popup_modifica_scheda_bombola.php";
			} else {
				$modulo = "popup_modifica_scheda.php";
			}
		$div_dati .= "<a href=".$modulo."?action=edit&id=".$id."&negozio=".$negozio."&lang=".$lingua."><span class=pulsante_admin>Admin</span></a>";
		$div_dati .= "</div>"; 
/*		$div_dati .= "<div class=comandi>";
		$div_dati .= "<a href=".$modulo."?action=duplicate&id=".$rigak[id]."&negozio=".$negozio."&lang=".$lingua."><span class=Stile3>".$duplicate."</span></a>";
		$div_dati .= "</div>"; 
*/	
	
		$div_dati .= "<div class=spazio_puls_carrello>";
		$div_dati .= "</div>"; 
				switch ($_SESSION[lang]) {
				  case "it":
				  $scritta_puls = "Scegli quantit&agrave;";
				  break;
				  case "en":
				  $scritta_puls = "Choose quantity";
				  break;
				}

$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$negozio."&id_prod=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless2',width:610,height:480,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
//$div_dati .= "id: ".$rigak[id]."<br>";
		  $div_dati .= $scritta_puls;
		  $div_dati .= "</div></a>";


//$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$negozio."&id_prod=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$tooltip_inserisci_carrello\">Inserisci nel carrello</div></a>";
}
//$div_dati .= "id: ".$id."<br>";
	//output finale
	echo $div_dati;



?>
