<?php
session_start();
$lingua = $_SESSION[lang];
if (isset($_GET[id_cart])) {
$_SESSION[carrello] = $_GET[id_cart];
}
$carrello = $_SESSION[carrello];
//echo "lingua: ".$lingua."<br>";
include "query.php";
include "functions.php";
include "traduzioni_interfaccia.php";
$azione_form = $_SERVER['PHP_SELF'];
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
$modifica_quant = $_GET['modifica_quant'];
$quant = str_replace(",",".",$_GET['quant']);
$id_riga = $_GET['id_riga'];
$id_prodotto = $_GET['id_prodotto'];

$apertura_scheda = $_GET['apertura_scheda'];
$textarea = levapar6($_GET['textarea']);
$conferma = $_GET['conferma'];
$conferma_nota = $_GET['conferma_nota'];

if ($conferma_nota != "") {
$query = "UPDATE qui_carrelli SET note = '$textarea' WHERE id = '$carrello'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
mysql_set_charset("utf8"); //settare la codifica della connessione al db

echo "<br>";
//echo "sess lingua: ".$_SESSION[lang]."<br>";

if ($_GET['modifica_quant'] != "") {
switch ($_SESSION[tipo_carrello]) {
case "assets":
$queryb = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto'";
break;
case "consumabili":
$queryb = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto'";
break;
case "spare_parts":
$queryb = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto'";
break;
case "vivistore":
$queryb = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prodotto'";
break;
}
$resultb = mysql_query($queryb) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
while ($rowb = mysql_fetch_array($resultb)) {
$prezzo_aggiornato = $rowb[prezzo];
}
$totale_aggiornato = $prezzo_aggiornato *$quant;
$query = "UPDATE qui_righe_carrelli SET quant = '$quant', totale = '$totale_aggiornato' WHERE id = '$id_riga'";
if (mysql_query($query)) {
//echo "aggiornato prezzo<br>";
$ok_modifica = 1;
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}

if ($_POST['id'] != "") {
$id = $_POST['id'];
} else {
$id = $_GET['id'];
}
if ($_GET['ordinamento'] != "") {
$ordinamento = $_GET['ordinamento'];
} else {
$ordinamento = "data_inserimento ASC";
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
$queryb = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0'";
$resultb = mysql_query($queryb);
$total_items = mysql_num_rows($resultb);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);


$queryc = "SELECT * FROM qui_carrelli WHERE id = '$carrello'";
$resultc = mysql_query($queryc) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rowc = mysql_fetch_array($resultc)) {
$carrello_attivo = $rowc[attivo];
$carrello_ordinato = $rowc[ordine];
$negozio_carrello = $rowc[negozio];
$note = stripslashes($rowc[note]);
$note = str_replace("<br>","\n",$note);
$data_ordine = date("d.m.Y H:i",$rowc[data_ultima_modifica]);
}

//tabella risultato carrello
	
//div contenitore testata	
	$tabella_carrello .= "<div id=columns_testata>";
	
	$tabella_carrello .= "<div id=1spazio>";
	$tabella_carrello .= "<img src=immagini/spacer.gif width=10 height=25 />";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=2codice>";
	$tabella_carrello .= "<span class=format_testata>";
    $tabella_carrello .= "<a href=carrello.php?limit=".$limit."&page=".$page."&ordinamento=codice_art&";
	if ($ordinamento == "codice_art") {
	if ($asc_desc == "ASC") {
	$tabella_carrello .= "asc_desc=DESC>";
	} else {
	$tabella_carrello .= "asc_desc=ASC>";
	}
	} else {
	$tabella_carrello .= "asc_desc=ASC>";
	}
	$tabella_carrello .= $testata_codice;
	//$tabella_carrello .= "ciao";
	if ($ordinamento == "codice_art") {
	if ($asc_desc == "ASC") {
	$tabella_carrello .= "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	$tabella_carrello .= "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	$tabella_carrello .= "</a>";
    $tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=3nazione>";
	$tabella_carrello .= "<span class=format_testata>";
	$tabella_carrello .= $testata_nazione;
    $tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=4descrizione>";
	$tabella_carrello .= "<span class=format_testata>";
    $tabella_carrello .= "<a href=carrello.php?limit=".$limit."&page=".$page."&ordinamento=descrizione_it&";
	if ($ordinamento == "descrizione_it") {
	if ($asc_desc == "ASC") {
	$tabella_carrello .= "asc_desc=DESC>";
	} else {
	$tabella_carrello .= "asc_desc=ASC>";
	}
	} else {
	$tabella_carrello .= "asc_desc=ASC>";
	}
	$tabella_carrello .= $testata_descrizione;
	if ($ordinamento == "descrizione_it") {
	if ($asc_desc == "ASC") {
	$tabella_carrello .= "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	$tabella_carrello .= "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	$tabella_carrello .= "</a>";
    $tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=5confezione>";
	$tabella_carrello .= "<span class=format_testata>";
    $tabella_carrello .= "<a href=carrello?limit=".$limit."&page=".$page."&ordinamento=confezione&";
	if ($ordinamento == "tipo") {
	if ($asc_desc == "ASC") {
	$tabella_carrello .= "asc_desc=DESC>";
	} else {
	$tabella_carrello .= "asc_desc=ASC>";
	}
	} else {
	$tabella_carrello .= "asc_desc=ASC>";
	}
	$tabella_carrello .= $testata_imballo;
	if ($ordinamento == "tipo") {
	if ($asc_desc == "ASC") {
	$tabella_carrello .= "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	$tabella_carrello .= "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	$tabella_carrello .= "</a>";
    $tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=6prezzo>";
	$tabella_carrello .= "<span class=format_testata>";
	$tabella_carrello .= $testata_prezzo." &euro;";
    $tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=7quant>";
	$tabella_carrello .= "<span class=format_testata>";
	$tabella_carrello .= $testata_quant;
    $tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=8totale>";
	$tabella_carrello .= "<span class=format_testata>";
	$tabella_carrello .= $testata_totale;
    $tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=9scheda>";
$tabella_carrello .= "<span class=codice_lista_nopadding>";
$tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=10elimina>";
$tabella_carrello .= "<span class=codice_lista_nopadding>";

$tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
//fine contenitore colonne testata
$tabella_carrello .= "</div>";
	
if ($carrello != "") {
 if ($carrello_attivo == 1) {
  //script di aggiornamento
 $queryc = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0' ORDER BY ".$ordinamento;
$resultc = mysql_query($queryc);
while ($rowc = mysql_fetch_array($resultc)) {
$id_riga = $rowc[id];
$id_prod_riga = $rowc[id_prodotto];
$quant_riga = $rowc[quant];
$negozio_riga = $rowc[negozio];
switch ($negozio_riga) {
case "assets":
$queryv = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prod_riga'";
break;
case "consumabili":
$queryv = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prod_riga'";
break;
case "spare_parts":
$queryv = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prod_riga'";
break;
case "vivistore":
$queryv = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prod_riga'";
break;
}

$resultv = mysql_query($queryv) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
while ($rowv = mysql_fetch_array($resultv)) {
$prezzo_riga = $rowv[prezzo];
}
$totale_prodotto_riga_aggiornato = $quant_riga*$prezzo_riga;
$query = "UPDATE qui_righe_carrelli SET prezzo = '$prezzo_riga', totale = '$totale_prodotto_riga_aggiornato' WHERE id = '$id_riga'";
if (mysql_query($query)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}

} 
  $queryb = "SELECT SUM(totale) as somma FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0'";
$resultb = mysql_query($queryb);
list($somma) = mysql_fetch_array($resultb);
$totale_carrello = $somma;
//}
$querya = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$carrello' AND cancellato = '0' ORDER BY ".$ordinamento." LIMIT $set_limit, $limit";
 $sf = 1;
//inizia il corpo della tabella
$result = mysql_query($querya);
while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
$id_prodotto_attuale = $row[id_prodotto];
switch ($negozio_riga) {
case "assets":
$queryh = "SELECT * FROM qui_prodotti_assets WHERE id = '$id_prodotto_attuale'";
break;
case "consumabili":
$queryh = "SELECT * FROM qui_prodotti_consumabili WHERE id = '$id_prodotto_attuale'";
break;
case "spare_parts":
$queryh = "SELECT * FROM qui_prodotti_spare_parts WHERE id = '$id_prodotto_attuale'";
break;
case "vivistore":
$queryv = "SELECT * FROM qui_prodotti_vivistore WHERE id = '$id_prodotto_attuale'";
break;
}
$resulth = mysql_query($queryh) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
while ($rowh = mysql_fetch_array($resulth)) {
$codice_art = $rowh[codice_art];
switch($lingua) {
case "it":
$descr_prod = $rowh[descrizione1_it];
break;
case "en":
$descr_prod = $rowh[descrizione1_en];
$descr_ita = $rowh[descrizione1_it];
break;
case "fr":
$descr_prod = $rowh[descrizione_fr];
break;
case "de":
$descr_prod = $rowh[descrizione_de];
break;
case "es":
$descr_prod = $rowh[descrizione_es];
break;
}
$paese = $rowh[paese];
$confezione = $rowh[confezione];
$tipo = $rowh[tipo];
$prezzo = $rowh[prezzo];
}


if ($sf == 1) {
//$tabella_carrello .= "<tr class=\"row carrelloColor\">";
$tabella_carrello .= "<div id=columns1>";
//echo "<tr class=\"row ".$sfondo_righe_tab."\">";
//$sfondo = $sfondo_righe_tab;
//echo "<tr class=\"btnav\" onmouseover=\"style.backgroundColor='#84C1DF';\"";
//echo "onmouseout=\"style.backgroundColor='#d9e6ff'\">";
} else {
//$sfondo = "#FFFFFF";
$tabella_carrello .= "<div id=columns0>";

//$tabella_carrello .= "<tr class=\"row bianco\">";
//echo "<tr class=\"btnav2\" onmouseover=\"style.backgroundColor='#84C1DF';\"";
//echo "onmouseout=\"style.backgroundColor='#FFFFFF'\">";
}
//echo "<tr valign=middle class=".$sfondo.">";
//echo "<form name=carrello method=get action=carrello.php#".$row[id].">";
	
$tabella_carrello .= "<div id=1spazio><img src=immagini/spacer.gif width=10 height=25/></div>";
$tabella_carrello .= "<div id=2codice>";
$tabella_carrello .= "<span class=codice_lista_nopadding>".$codice_art."</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=3nazione>";
$tabella_carrello .= "<span class=codice_lista_nopadding>".$paese."</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=4descrizione>";
if (strlen($descr_prod) < 3) {
$tabella_carrello .= "<span class=codice_lista_nopadding>".$descr_ita." <strong>(da tradurre)</strong></span>";
} else {
$tabella_carrello .= "<span class=codice_lista_nopadding>".$descr_prod."</span>";
}
$descr_prod = "";
$descr_ita = "";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=5confezione>";
$tabella_carrello .= "<span class=codice_lista_nopadding>".$confezione."</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=6prezzo>";
$tabella_carrello .= "<span class=price>".number_format($prezzo,2,",","")."</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=7quant>";
$tabella_carrello .= "<span class=price>";
if ($conferma != "") {
$tabella_carrello .= number_format($row[quant],0,",","");
} else {
$tabella_carrello .= "<form name=carrello method=get action=carrello.php>";
//echo "<input name=quant type=text class=tabelle8 id=quant size=5 maxlength=8 onkeypress = \"return ctrl_solo_num(event)\" onBlur=\"this.form.submit()\" value=".number_format($row[quant],0,",","").">";
$tabella_carrello .= "<input name=".$row[id]." type=text class=tabelle8 id=".$row[id]." size=5 maxlength=8 onKeyUp=\"axc(".$row[id].",this.value,this.id);\" value=".number_format($row[quant],0,",","").">";
//$tabella_carrello .= "<input type=submit name=button id=button value=OK>";
}
$tabella_carrello .= "<input name=lang type=hidden id=lang value=".$lingua.">";
$tabella_carrello .= "<input name=id_cart type=hidden id=id_cart value=".$row[id_carrello].">";
$tabella_carrello .= "<input name=id_prodotto type=hidden id=id_prodotto value=".$row[id_prodotto].">";
$tabella_carrello .= "<input name=id_riga type=hidden id=id_riga value=".$row[id].">";
$tabella_carrello .= "<input name=modifica_quant type=hidden id=modifica_quant value=1>";
$tabella_carrello .= "<input name=negozio type=hidden id=negozio value=carrello>";
$tabella_carrello .= "<input name=limit type=hidden id=limit value=".$limit.">";
$tabella_carrello .= "<input name=page type=hidden id=page value=".$page.">";
$tabella_carrello .= "</form>"; 
$tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
$contarighe = $contarighe+1;
$id_tot = "8".str_pad($contarighe, 2, "0", STR_PAD_LEFT);
$tabella_carrello .= "<div id=".$id_tot.">";
$tabella_carrello .= "<span class=price>".number_format($row[totale],2,",","")."</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=9scheda>";
$tabella_carrello .= "<span class=codice_lista_nopadding>";
$tabella_carrello .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$negozio_riga."&id=".$row[id_prodotto]."&lang=".$lingua."', 'myPop1',960,600);\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
$tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=10elimina>";
$tabella_carrello .= "<span class=codice_lista_nopadding>";
if ($conferma == "") {
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_modal_elimina_riga_carrello.php?avviso=del_riga&id_riga_carrello=".$row[id]."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,140);\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";

$tabella_carrello .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal_elimina_riga_carrello.php?avviso=del_riga&id_riga_carrello=".$row[id]."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:160,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=\"$elimina_articolo\"></a>";
}
$tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
//contenitore colonne
$tabella_carrello .= "</div>";

$codice = "";
$tipo = "";
$materiale = "";
$colore = "";
$prezzo = "0";
$descrizione_art = "";


if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}
//riga spaziatrice sopra il totale
	$tabella_carrello .= "<div id=columns0>";
$tabella_carrello .= "<img src=immagini/spacer.gif width=960 height=10>";
$tabella_carrello .= "</div>";
  if ($carrello != "") {
//riga del totale
	$tabella_carrello .= "<div id=columns_totale>";
	$tabella_carrello .= "<div id=1spazio class=codeTitle_nopadding>";
	$tabella_carrello .= "<img src=immagini/spacer.gif width=10 height=25 />";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=2codice class=codeTitle_nopadding>";
	$tabella_carrello .= "<span class=tot_carrello>";
$tabella_carrello .= "<strong>".$testo_totale_carrello."<strong>";
    $tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=3nazione class=codeTitle_nopadding>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=4descrizione class=codeTitle_nopadding>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=5confezione class=codeTitle_nopadding>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=6prezzo class=codeTitle_dx>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=7quant class=codeTitle_dx>";
$tabella_carrello .= "<strong>".number_format($totale_carrello,2,",","")."</strong>";
$tabella_carrello .= "</div>";
	$tabella_carrello .= "<div id=8totale class=codeTitle_dx>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=9scheda>";
$tabella_carrello .= "<span class=codice_lista_nopadding>";
$tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
$tabella_carrello .= "<div id=10elimina>";
$tabella_carrello .= "<span class=codice_lista_nopadding>";
$tabella_carrello .= "</span>";
$tabella_carrello .= "</div>";
//fine contenitore colonne totale
$tabella_carrello .= "</div>";
//riga spaziatrice sotto il totale
$tabella_carrello .= "<div id=columns0>";
$tabella_carrello .= "<img src=immagini/spacer.gif width=960 height=10>";
$tabella_carrello .= "</div>";
}
}
}
	

// if (($carrello_attivo == 1) AND ($carrello_ordinato == 0)) {
 if ($carrello_attivo != 1) {
//include "form_carrello.php";
//   echo "<form name=form1 method=get action=genera_rda.php>";
  if ($conferma != "") {
    $tabella_carrello .= "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      $tabella_carrello .= "<tr>";
        $tabella_carrello .= "<td class=grande_18rossochiaro>Note</td>";
      $tabella_carrello .= "</tr>";
      $tabella_carrello .= "<tr>";
        $tabella_carrello .= "<td class=tabelle8>".$note."</td>";
      $tabella_carrello .= "</tr>";
     $tabella_carrello .= "<tr>";
        $tabella_carrello .= "<td class=tabelle8><br><strong>Il tuo carrello &egrave; stato trasformato in ordine in data ".$data_ordine_leggibile."</strong></td>";
      $tabella_carrello .= "</tr>";
      $tabella_carrello .= "<tr>";
        $tabella_carrello .= "<td>";
		//<div class="btn btnFreccia"><a href="#" onClick="MM_openBrWindow('','','')">Crea RdA</a></div>
			$tabella_carrello .= "<div class=btn btnFreccia><a href=# onClick=\"this.form.submit()\">";
		$tabella_carrello .= "<div align=right><strong>Crea RdA</strong></div></a>";
		$tabella_carrello .= "</div>";
          $tabella_carrello .= "<div align=right>";
//echo "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_rda.php?avviso=genera_rda&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,140);\"><img src=immagini/crea_rda.png width=137 height=23 border=0></a>";


            $tabella_carrello .= "<input type=hidden name=id_carrello id=id_carrello value=".$carrello.">";
            $tabella_carrello .= "<input type=hidden name=id_utente id=id_utente value=".$_SESSION[user_id].">";
            $tabella_carrello .= "<input name=lang type=hidden id=lang value=".$lingua.">";
            $tabella_carrello .= "<input name=avviso type=hidden id=avviso value=genera_rda>";
          $tabella_carrello .= "</div></td>";
      $tabella_carrello .= "</tr>";
    $tabella_carrello .= "</table>";
    } else {
    $tabella_carrello .= "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      $tabella_carrello .= "<tr>";
        $tabella_carrello .= "<td class=tabelle8><br><strong>".$carrello_vuoto."</strong></td>";
      $tabella_carrello .= "</tr>";
    $tabella_carrello .= "</table>";
}
} else {
//include "form_carrello.php";

    $tabella_carrello .= "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      $tabella_carrello .= "<tr>";
        $tabella_carrello .= "<td width=596 rowspan=2>";
  $tabella_carrello .= "<form name=form1 method=get action=carrello.php><br>";
		if ($note != "") {
   $tabella_carrello .= "<textarea name=textarea style=width:480px; rows=5 class=tabelle8 id=textarea onBlur=\"this.form.submit()\">".$note."</textarea>";
		} else {
   $tabella_carrello .= "<textarea name=textarea style=width:480px; rows=5 class=tabelle8 id=textarea  onClick=\"controllo()\" onBlur=\"this.form.submit()\">Note</textarea>";
		}
          $tabella_carrello .= "<input type=hidden name=id_cart id=id_cart value=".$carrello.">";
          $tabella_carrello .= "<input type=hidden name=id_utente id=id_utente value=".$_SESSION[user_id].">";
            $tabella_carrello .= "<input name=lang type=hidden id=lang value=".$lingua.">";
            $tabella_carrello .= "<input name=conferma_nota type=hidden id=conferma_nota value=1>";
    $tabella_carrello .= "</form>";
	$tabella_carrello .= "</td>";
	$tabella_carrello .= "<td width=210 valign=top>";
	switch($lingua) {
	case "it":
    $tabella_carrello .= "<a href=javascript:void(0); onClick=\"TINY.box.show({iframe:'popup_modal_svuota_carrello.php?avviso=svuota_carrello&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:410,height:200,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_svuota_carr_ita_off_117x19.gif name=svuota width=120 height=20 id=svuota onmouseover=\"MM_swapImage('svuota','','immagini/btn_svuota_carr_ita_on_117x19.gif',1)\" onmouseout=\"MM_swapImgRestore()\" /></a>";
	break;
	case "en":
    $tabella_carrello .= "<a href=javascript:void(0); onClick=\"TINY.box.show({iframe:'popup_modal_svuota_carrello.php?avviso=svuota_carrello&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:410,height:200,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_svuota_carr_en_off_117x19.gif name=svuota width=120 height=20 id=svuota onmouseover=\"MM_swapImage('svuota','','immagini/btn_svuota_carr_en_on_117x19.gif',1)\" onmouseout=\"MM_swapImgRestore()\" /></a>";
	break;
	}
       $tabella_carrello .= "</td>";
        $tabella_carrello .= "<td width=154 valign=top>";
	switch($lingua) {
	case "it":
        $tabella_carrello .= "<a href=javascript:void(0); onClick=\"TINY.box.show({iframe:'popup_modal_gen_rda.php?avviso=genera_rda&negozio_carrello=".$negozio_carrello."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:410,height:200,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_rda_ita_off_117x19.gif name=crea width=120 height=20 id=crea onmouseover=\"MM_swapImage('crea','','immagini/btn_rda_ita_on_117x19.gif',1)\" onmouseout=\"MM_swapImgRestore()\" /></a>";
break;
	case "en":
        $tabella_carrello .= "<a href=javascript:void(0); onClick=\"TINY.box.show({iframe:'popup_modal_gen_rda.php?avviso=genera_rda&negozio_carrello=".$negozio_carrello."&id_carrello=".$carrello."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:410,height:200,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_rda_en_off_117x19.gif name=crea width=120 height=20 id=crea onmouseover=\"MM_swapImage('crea','','immagini/btn_rda_en_on_117x19.gif',1)\" onmouseout=\"MM_swapImgRestore()\" /></a>";
break;
}       
  $tabella_carrello .= "</td>";
      $tabella_carrello .= "</tr>";
      $tabella_carrello .= "<tr>";
        $tabella_carrello .= "<td colspan=2 valign=top><div align=right><span class=Stile2>";
        
		if ($_SESSION[ruolo] == "utente") {
		$tabella_carrello .= $scritta_carrello;
		}
		$tabella_carrello .= "</span></div></td>";
      $tabella_carrello .= "</tr>";
    $tabella_carrello .= "</table>";
$tabella_carrello .= "<img src=immagini/spacer.gif width=960 height=20>";

   }

	//output finale
	
	
	
	
	echo $tabella_carrello;
	

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<title>Documento senza titolo</title>
<style type="text/css">

.Stile1 {
	color: #999999;
	font-size: 10px;
}
.Stile2 {font-size: 12px}
-->
#columns_totale {
	width: 960px;
	background: #FFFFCC;
	height:25px;
}
#columns_testata {
	width: 960px;
	background: #8e8e8e;
	height:25px;
}
#columns0 {
	width: 960px;
	background: #fff;
	height:25px;
}
#columns1 {
	width: 960px;
	background:#F0F0F0;
	height:25px;
}
#1spazio {
	float: left;
	width: 10px;
	height:25px;
}
#2codice {
	float: left;
	width: 80px;
	height:25px;
}
#3nazione {
	float: left;
	width: 70px;
	height:25px;
}
#4descrizione {
	float: left;
	width: 300px;
	height:25px;
}
#5confezione {
	float: left;
	width: 80px;
	height:25px;
}
#6prezzo {
	float: left;
	width: 90px;
	height:25px;
}
#7quant {
	float: left;
	width: 150px;
	height:25px;
}
#8totale {
	float: left;
	width: 90px;
	height:25px;
}
#9scheda {
	float: left;
	width: 45px;
	height:25px;
}
#10elimina {
	float: left;
	width: 45px;
	height:25px;
}

#801{
	float: left;
	width: 90px;
	height:25px;
	}
#802{
	float: left;
	width: 90px;
	height:25px;
	}
</style>
<script type="text/javascript" src="tinybox.js"></script>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head><body onLoad="MM_preloadImages('immagini/btn_rda_ita_on_117x19.gif','immagini/btn_svuota_carr_ita_on_117x19.gif')">
<div id="columns_totale">
  <div id="1spazio">Inserire qui il contenuto per  id "1codice"</div>
  <div id="2codice">Inserire qui il contenuto per  id "1codice"</div>
  <div id="2codice">Inserire qui il contenuto per  id "1codice"</div>
  <div id="2codice">Inserire qui il contenuto per  id "1codice"</div>
  <div id="111">Inserire qui il contenuto per  id "1codice"</div>
  <div id="3descrizione">Inserire qui il contenuto per  id "1codice"</div>
  
</div>
</body>