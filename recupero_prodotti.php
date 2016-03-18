<?php
session_start();
///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
//impostazione variabili per costruzione query
$lingua = $_SESSION[lang];
$limit = $_SESSION[limit];
$page = $_SESSION[page];
$categoria1 = $_SESSION[categoria1];
$categoria2 = $_SESSION[categoria2];
$categoria3 = $_SESSION[categoria3];
$categoria4 = $_SESSION[categoria4];
$ordinamento = $_SESSION[ordinamento];
$asc_desc = $_SESSION[asc_desc];
$codiceDaModulo = $_SESSION[codice];
$nazioneDaModulo = $_SESSION[nazione_ric];
$descrizioneDaModulo = $_SESSION[descrizione];
$negozio = $_SESSION[negozio];


if ($codiceDaModulo != "") {
$a = "codice_art LIKE '%$codiceDaModulo%'";
$clausole++;
}

if ($nazioneDaModulo != "") {
$b = "nazione LIKE '%$nazioneDaModulo%'";
$clausole++;
}
switch($lingua) {
case "it":
$categoria1_lang = "categoria1_it";
$categoria2_lang = "categoria2_it";
$categoria3_lang = "categoria3_it";
$categoria4_lang = "categoria4_it";
break;
case "en":
$categoria1_lang = "categoria1_en";
$categoria2_lang = "categoria2_en";
$categoria3_lang = "categoria3_en";
$categoria4_lang = "categoria4_en";
break;
}

if ($categoria2 != "") {
$c = "categoria2_it = '$categoria2'";
$clausole++;
}

if ($negozio != "") {
$d = "negozio = '$negozio'";
$clausole++;
}

if ($categoria1 != "") {
$e = "categoria1_it = '$categoria1'";
$clausole++;
}
if ($categoria3 != "") {
$f = "categoria3_it = '$categoria3'";
$clausole++;
}
if ($categoria4 != "") {
$g = "categoria4_it = '$categoria4'";
$clausole++;
}
if ($paese != "") {
$h = "paese = '$paese'";
$clausole++;
}



//costruzione query, query diversa a seconda del negozio prescelto
switch ($negozio) {
case "assets":
$testoQuery = "SELECT * FROM qui_prodotti_assets ";
break;
case "consumabili":
$testoQuery = "SELECT * FROM qui_prodotti_consumabili ";
break;
case "spare_parts":
$testoQuery = "SELECT * FROM qui_prodotti_spare_parts ";
break;
}
if ($clausole > 0) {
$testoQuery .= "WHERE obsoleto = '0' AND ";
if ($clausole == 1) {
if ($a != "") {
$testoQuery .= $a;
}
if ($b != "") {
$testoQuery .= $b;
}
if ($c != "") {
$testoQuery .= $c;
}
if ($d != "") {
$testoQuery .= $d;
}
if ($e != "") {
$testoQuery .= $e;
}
if ($f != "") {
$testoQuery .= $f;
}
if ($g != "") {
$testoQuery .= $g;
}
if ($h != "") {
$testoQuery .= $h;
}
} else {
if ($a != "") {
$testoQuery .= $a." AND ";
}
if ($b != "") {
$testoQuery .= $b." AND ";
}
if ($c != "") {
$testoQuery .= $c." AND ";
}
if ($d != "") {
$testoQuery .= $d." AND ";
}
if ($e != "") {
$testoQuery .= $e." AND ";
}
if ($f != "") {
$testoQuery .= $f." AND ";
}
if ($g != "") {
$testoQuery .= $g." AND ";
}
if ($h != "") {
$testoQuery .= $h;
}
}

//} else {
//$testoQuery .= "WHERE obsoleto = '' ";
}
$lung = strlen($testoQuery);
$finale = substr($testoQuery,($lung-5),5);
if ($finale == " AND ") {
$testoQuery = substr($testoQuery,0,($lung-5));
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
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";

$querya = $testoQuery;
$resulta = mysql_query($querya);
$total_items = mysql_num_rows($resulta);

$total_pages = ceil($total_items / $limit);
$set_limit = $page * $limit - ($limit);


$testoQuery .= " ORDER BY ".$ordinamento." ".$asc_desc." LIMIT $set_limit, $limit";

//echo "testoQuery: ".$testoQuery."<br>";
//echo "finale: |".$finale."|<br>";
///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////



//tabellina con navigazione preferenze quante linee per pagina
$tabella_prodotti .= "<table width=960 border=0 cellspacing=0 cellpadding=0>";
  $tabella_prodotti .= "<tr>";
    $tabella_prodotti .= "<td width=661 class=ecoformdestra>";
    //$tabella_prodotti .= $elementi_pagina;
    $tabella_prodotti .= "</td>";
    $tabella_prodotti .= "<td width=339 class=Stile_griglia>";
	$tabella_prodotti .= "<div align=right>".$lista1." | ".$griglia." | <a href=\"ricerca_prodotti.php?limit=10&page=1&negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."\">10</a> | <a href=\"ricerca_prodotti.php?limit=25&page=1&negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."\">25</a> | <a href=\"ricerca_prodotti.php?limit=50&page=1&negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."\">50</a>";
    $tabella_prodotti .= "</div>";
    $tabella_prodotti .= "</td>";
  $tabella_prodotti .= "</tr>";
$tabella_prodotti .= "</table>";

//tabella risultato prodotti
$tabella_prodotti .= "<table width=960 border=0 cellpadding=0 cellspacing=0>";

//testata
  $tabella_prodotti .= "<tr bgcolor=#8e8e8e>";
//TESTATA colonna codice
$tabella_prodotti .= "<td width=10 valign=middle><img src=immagini/spacer.gif width=10 height=25 /></td>";
$tabella_prodotti .= "<td width=80 valign=middle class=codeTitle>";
$tabella_prodotti .= "<span class=format_testata>";
    $tabella_prodotti .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=".$page."&negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&ordinamento=codice_art&";
	if ($ordinamento == "codice_art") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "asc_desc=DESC>";
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	$tabella_prodotti .= $testata_codice;
	if ($ordinamento == "codice_art") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	$tabella_prodotti .= "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	$tabella_prodotti .= "</a>";
   $tabella_prodotti .= "</span></td>";
//TESTATA colonna nazione-->
    $tabella_prodotti .= "<td width=90 valign=middle class=codeTitle_nopadding>";
	$tabella_prodotti .= "<span class=format_testata>";
    $tabella_prodotti .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=".$page."&negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&ordinamento=paese&";
	if ($ordinamento == "paese") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "asc_desc=DESC>";
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	$tabella_prodotti .= $testata_nazione;
	if ($ordinamento == "paese") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	$tabella_prodotti .= "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	$tabella_prodotti .= "</a>";
    $tabella_prodotti .= "</span></td>";
    $tabella_prodotti .= "<td width=465 valign=middle class=codeTitle_nopadding>";
$tabella_prodotti .= "<span class=format_testata>";
    $tabella_prodotti .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=".$page."&negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&ordinamento=descrizione1_it&";
	if ($ordinamento == "descrizione1_it") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "asc_desc=DESC>";
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	$tabella_prodotti .= $testata_prodotto;
	if ($ordinamento == "descrizione1_it") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	$tabella_prodotti .= "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	$tabella_prodotti .= "</a>";
    $tabella_prodotti .= "</span></td>";
    $tabella_prodotti .= "<td width=100 valign=middle class=codeTitle_nopadding>";
	$tabella_prodotti .= "<span class=format_testata>";
	if ($negozio != "assets") {
    $tabella_prodotti .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=".$page."&negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&ordinamento=confezione&";
	if ($ordinamento == "confezione") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "asc_desc=DESC>";
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	$tabella_prodotti .= $testata_imballo;
	if ($ordinamento == "confezione") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	$tabella_prodotti .= "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	$tabella_prodotti .= "</a>";
	}
    $tabella_prodotti .= "</span></td>";
    $tabella_prodotti .= "<td width=80 valign=middle class=codeTitle_dx>";
	$tabella_prodotti .= "<span class=format_testata>";
    $tabella_prodotti .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=".$page."&negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&ordinamento=prezzo&";
	if ($ordinamento == "prezzo") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "asc_desc=DESC>";
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	} else {
	$tabella_prodotti .= "asc_desc=ASC>";
	}
	$tabella_prodotti .= $testata_prezzo." &euro;";
	if ($ordinamento == "prezzo") {
	if ($asc_desc == "ASC") {
	$tabella_prodotti .= "<img src=immagini/arrow-asc.png width=13 height=13 border=0>";
	} else {
	$tabella_prodotti .= "<img src=immagini/arrow-desc.png width=13 height=13 border=0>";
	}
	}
	$tabella_prodotti .= "</a>";
    $tabella_prodotti .= "</span></td>";
//<th width=100 class=tabellecentro>".$testata_quant."</th>";    
    $tabella_prodotti .= "<td width=45 valign=middle>&nbsp;</td>";
    $tabella_prodotti .= "<td width=45 valign=middle>";
	//$tabella_prodotti .= $testata_preferito;
	$tabella_prodotti .= "</td>";
    $tabella_prodotti .= "<td width=45 valign=middle>";
	$tabella_prodotti .= $testata_carrello;
	$tabella_prodotti .= "</td>";
    $tabella_prodotti .= "</tr>";

 $querya = $testoQuery;
 $sf = 1;
//inizia il corpo della tabella
$result = mysql_query($querya);
$num_righe_trovate = mysql_num_rows($result);
if ($num_righe_trovate > 0) {
while ($row = mysql_fetch_array($result)) {
$data_leggibile = date("d.m.Y",$row[data]);
//*******************************************
//RIFERIMENTO PER RITORNO A LISTA
//echo "<tr><td colspan=8><a name=".$row[id]."><img src=immagini/riga_prev.jpg width=960 height=1></a></td></tr>";
//*******************************************
//echo "<tr class=btnav onmouseover=style.backgroundColor='".$sfondo_highlight."'; onmouseout=style.backgroundColor='".$sfondo."'>";
if ($sf == 1) {
$tabella_prodotti .= "<tr class=\"row rdaColor\">";
} else {
$tabella_prodotti .= "<tr class=\"row bianco\">";
}
//$tabella_prodotti .= "<tr valign=middle class=".$sfondo.">";
$tabella_prodotti .= "<td><img src=immagini/spacer.gif width=10 height=20/>";
$tabella_prodotti .= "</td>";
$tabella_prodotti .= "<td class=codice_lista_nopadding>";
$tabella_prodotti .= $row[codice_art];
$tabella_prodotti .= "</td>";
$tabella_prodotti .= "<td class=codice_lista_nopadding>".stripslashes($row[paese])."</td>";
$tabella_prodotti .= "<td class=codice_lista_nopadding>";
switch($lingua) {
case "it":
$descr_prod = str_replace(" Capacità","",$row[descrizione1_it]);
break;
case "en":
$descr_prod = str_replace(" Capacity","",$row[descrizione1_en]);
break;
case "fr":
$descr_prod = $row[descrizione_fr];
break;
case "de":
$descr_prod = $row[descrizione_de];
break;
case "es":
$descr_prod = $row[descrizione_es];
break;
}
if ($row[categoria1_it] == "Bombole") {
$querys = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$row[id_valvola]'";
$results = mysql_query($querys);
while ($rows = mysql_fetch_array($results)) {
$descr_valvola = $rows[descrizione1_it];
}
$queryt = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$row[id_cappellotto]'";
$resultt = mysql_query($queryt);
while ($rowt = mysql_fetch_array($resultt)) {
$descr_cappellotto = $rowt[descrizione1_it];
}

}
if ($descr_prod == "") {
$tabella_prodotti .= $row[descrizione1_it]." <strong>(da tradurre)</strong>";
} else {
if ($row[categoria1_it] == "Bombole") {
//$tabella_prodotti .= "<a href=# title=".str_replace(" ","_",$descr_valvola).">";
$tabella_prodotti .= $descr_prod;
if ($descr_valvola != "") {
$tabella_prodotti .= " - ".$descr_valvola;
}
if ($descr_cappellotto != "") {
$tabella_prodotti .= " - ".$descr_cappellotto;
}
//$tabella_prodotti .= "</a>";
} else {
$tabella_prodotti .= $descr_prod;
}
}
$descr_prod = "";
$descr_valvola = "";
$descr_cappellotto = "";
$tabella_prodotti .= "</td>";
$tabella_prodotti .= "<td class=codice_lista_nopadding>";
if ($row[foto] != "") {
$tabella_prodotti .= "<img src=files/".$row[foto]." width=19 height=19><img src=immagini/spacer.gif width=10 height=10/>";
}
$tabella_prodotti .= $row[confezione];
$tabella_prodotti .= "</td>";
$tabella_prodotti .= "<td class=price>";
$tabella_prodotti .= number_format($row[prezzo],2,",",".");
$tabella_prodotti .= "</td>";
/*$tabella_prodotti .= "<td valign=top class=tabelledestra>";
$tabella_prodotti .= "<input name=quant type=hidden class=tabelle8 id=quant value=1>";
$tabella_prodotti .= "</td>";
*/
$tabella_prodotti .= "<td class=open>";
$tabella_prodotti .= "<a href=\"javascript:void(0);\" onclick=\"MM_openBrWindow('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."','Scheda','scrollbars=yes,left=50,top=20,width=960,height=500')\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
//$tabella_prodotti .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_scheda.php?negozio=".$row[negozio]."&id=".$row[id]."&lang=".$lingua."', 'myPop1',960,600);\"><img src=immagini/btn_lente.png width=19 height=19 border=0 title=\"$tooltip_visualizza_scheda\"></a>";
$tabella_prodotti .= "</td>";
$tabella_prodotti .= "<td class=bookmark>";
$sqleee = "SELECT * FROM qui_preferiti WHERE id_prod = '$row[id]' AND id_utente = '$_SESSION[user_id]'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$preferiti_presenti = mysql_num_rows($risulteee);
if ($preferiti_presenti > 0) {
//$tabella_prodotti .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,140);\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";

$tabella_prodotti .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_modal.php?avviso=del_bookmark&id_prod=".$row[id]."&negozio_prod=".$row[negozio]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella.png width=19 height=19 border=0 title=\"$tooltip_elimina_preferito\"></a>";
} else {

$tabella_prodotti .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";

//$tabella_prodotti .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_notifica.php?avviso=bookmark&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,100);\"><img src=immagini/btn_stella_off.png width=19 height=19 border=0 title=\"$tooltip_registra_preferito\"></a>";
}
$tabella_prodotti .= "<a name=".$row[id]."><img src=immagini/spacer.gif width=10 height=10></a>";
$tabella_prodotti .= "</td>";
$tabella_prodotti .= "<td class=cart>";
$tabella_prodotti .= "<a href=\"javascript:void(0);\" onclick=\"TINY.box.show({iframe:'popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";
//$tabella_prodotti .= "<a href=\"javascript:void(0);\" onclick=\"PopupCenter('popup_ins_cart.php?avviso=ins_quant&negozio=".$row[negozio]."&id_prod=".$row[id]."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."', 'myPop1',400,100);\"><img src=immagini/btn_carrello.png width=19 height=19 border=0 title=\"$tooltip_inserisci_carrello\"></a>";

$tabella_prodotti .= "</td>";
$tabella_prodotti .= "</tr>"; 
if ($sf == 1) {
$sf = $sf + 1;
} else {
$sf = 1;
}
$sfondo = "";
}
//$tabella_prodotti .= "<tr><td colspan=8><img src=immagini/riga_prev.jpg width=960 height=1></td></tr>";
} else {
    $tabella_prodotti .= "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      $tabella_prodotti .= "<tr>";
        $tabella_prodotti .= "<td class=tabelle8><br><strong>".$risultato_ricerca."</strong></td>";
      $tabella_prodotti .= "</tr>";
    $tabella_prodotti .= "</table>";
}
$tabella_prodotti .= "</table>";
$tabella_prodotti .= "<br>";


//tabella navigazione tra le pagine
$tabella_prodotti .= "<table width=960 border=0 cellspacing=0 cellpadding=0>";
      $tabella_prodotti .= "<tr>";
        $tabella_prodotti .= "<td class=num_pag>";
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
  $tabella_prodotti .= "<b></b> <a href=ricerca_prodotti.php?negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&limit=".$limit."&page=".$prev_page."&lang=".$lingua."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."><b><<</b></a>"; 
} 
//for($a = 1; $a <= $total_pages; $a++)
for($a = $pag_iniz; $a <= $pag_fin; $a++)
{
   if($a == $page) {
      $tabella_prodotti .= ("<span class=current_num_pag> $a</span><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>"); //no link
	 } else {
  $tabella_prodotti .= ("  <a href=ricerca_prodotti.php?negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&limit=".$limit."&page=".$a."&lang=".$lingua."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."> $a </a><img src=immagini/spacer.gif width=4 height=4>|<img src=immagini/spacer.gif width=4 height=4>");
     } 
} 
$next_page = $page + 1;
if($next_page <= $total_pages) {
   $tabella_prodotti .= "<a href=ricerca_prodotti.php?negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&limit=".$limit."&page=".$next_page."&lang=".$lingua."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."><b>>></b></a>"; 
} 
   $tabella_prodotti .= "<a href=ricerca_prodotti.php?negozio=".$negozio."&paese=".$paese."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&categoria4=".$categoria4."&limit=".$limit."&page=".$last_page."&lang=".$lingua."&ordinamento=".$ordinamento."&asc_desc=".$asc_desc."><b>".$last_page."</b></a>"; 
        $tabella_prodotti .= "</td>";
      $tabella_prodotti .= "</tr>";
   $tabella_prodotti .= "</table> ";
    //echo "sessione carrello: ".$_SESSION[carrello]."<br>";
$tabella_prodotti .= "<img src=immagini/spacer.gif width=25 height=25>";
    $tabella_prodotti .= "</div>";
	//output finale
	echo $tabella_prodotti;
?>
