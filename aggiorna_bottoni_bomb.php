<?php
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$lingua = $_GET[lang];
$id = $_GET[id];
$negozio = $_GET[negozio];
$prezzo_pescante = $_GET[prezzo_pescante];
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

$testoQuery = "SELECT * FROM qui_prodotti_assets WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($rigak = mysql_fetch_array($result)) {
		$div_dati .= "<div class=comandi>";
		$div_dati .= "</div>"; 
		$div_dati .= "<div class=comandi>";
		$nome_gruppo = mt_rand(1000,9999);
		//operazioni di costruzione della gallery
		$sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$rigak[codice_art]' ORDER BY precedenza ASC";
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
		//fine  costruzione gallery
		$div_dati .= "</div>"; 
		$div_dati .= "<div class=comandi>";
		if ($rigak[percorso_pdf] != "") {
			$div_dati .= "<a href=documenti/".$rigak[percorso_pdf]." target=_blank>";
		  $div_dati .= "<span class=pulsante_scheda style=\"text-decoration:none;\">".$scheda_tecnica."</span>";
		  $div_dati .= "</a>";
		}
		$div_dati .= "</div>"; 
		$div_dati .= "<div class=comandi_spazio>";
		$div_dati .= "</div>"; 
		$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$rigak[id]' AND id_utente = '$_SESSION[user_id]'";
		$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$preferiti_presenti = mysql_num_rows($risulteee);
	  if ($preferiti_presenti > 0) {
		  $div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$rigak[id]."&negozio_prod=".$negozio."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				$div_dati .= "<div class=comandi>";
				$div_dati .= "<span class=pulsante_preferiti>".$elim_favoriti."</span>";
			} else {
				$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$negozio."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\">";
				$div_dati .= "<div class=comandi>";
				$div_dati .= "<span class=pulsante_preferiti>".$add_favoriti."</span>";
			}
		$div_dati .= "</div>"; 
		$div_dati .= "</a>";
		$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?mode=print&negozio=".$negozio."&id=".$rigak[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\">";
		$div_dati .= "<div class=comandi>";
		$div_dati .= "<span class=pulsante_stampa>".$voce_stampa."</span>";
		$div_dati .= "</div>"; 
		$div_dati .= "</a>";
		$div_dati .= "<div class=comandi_spazio>";
		$div_dati .= "</div>"; 
		$div_dati .= "<div class=comandi>";
		$div_dati .= "</div>"; 
	
	
		$div_dati .= "<div class=spazio_puls_carrello>";
		//$div_dati .= $rigak[id];
		$div_dati .= "</div>"; 
				switch ($_SESSION[lang]) {
				  case "it":
				  $scritta_puls = "Scegli quantit&agrave;";
				  break;
				  case "en":
				  $scritta_puls = "Choose quantity";
				  break;
				}

$div_dati .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart_etich_pharma.php?avviso=ins_quant&negozio=".$rigak[negozio]."&prezzo_pescante=".$prezzo_pescante."&id_prod=".$rigak[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless3',width:640,height:520,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><div class=pulsante_carrello title=\"$scritta_puls\">";
//$div_dati .= "id: ".$rigak[id]."<br>";
		  $div_dati .= $scritta_puls;
		  $div_dati .= "</div></a>";
//echo "id: ".$rigak[id]."<br>";
		//fine div componente_bottoni
		$div_dati .= "</div>"; 
}
	//output finale
	echo $div_dati;
//	echo $rigak[id];
?>
