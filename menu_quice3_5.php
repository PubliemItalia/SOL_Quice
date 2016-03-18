<?php
//header("Pragma: no-cache"); 
if ($_GET[lang] != "") {
$lingua_alt = $_GET[lang];
} else {
$lingua_alt = $_POST[lang];
}
/*if ($_SESSION[user_id] == "") {
switch ($lingua_alt) {
case "":
$avv = "Si &egrave; verificato un problema durante l&acute;accesso a QUICE.<br>Per riprovare chiudi questa finestra del browser oppure <a href=http://www.solgroup/Pub/DITP/DIMM/SMR/ordine.asp>clicca qui!</a>";
break;
case "it":
$avv = "Si &egrave; verificato un problema durante l&acute;accesso a QUICE.<br>Per riprovare chiudi questa finestra del browser oppure <a href=http://www.solgroup/Pub/DITP/DIMM/SMR/ordine.asp>CLICCA QUI!</a>";
break;
case "en":
$avv = "There was a problem with your access to QUICE.<br>Try another time by closing this browser window or <a href=http://www.solgroup/Pub/DITP/DIMM/SMR/ordine.asp>CLICK HERE!</a>";
break;
}
echo "<table width=500 border=0 align=center cellpadding=0 cellspacing=0 bgcolor=#FFFFCC>";
  echo "<tr>";
    echo "<td class=Stile_alert><div align=center>".$avv."</div></td>";
  echo "</tr>";
echo "</table>";
exit;
}
*/
$num_righeXcolonna = 4;
$negozio = $_GET[negozio];
$lista = $_GET[lista];
$archive = $_GET[archive];
$preferiti = $_GET[preferiti];
$stile = $_GET[stile];
$posizione = ($_GET[posizione]);
$categoria1 = $_GET['categoria1'];
$paese = $_GET['paese'];
$id_utente = $_SESSION[user_id];

//echo '<span style="color:#000;">Negozio: '.$negozio.'</span><br>';
//query per la traduzione della categoria1 del percorso
if ($categoria1 != "") {
$sqlf = "SELECT * FROM qui_prodotti_".$negozio." WHERE categoria1_it = '$categoria1' LIMIT 1";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
switch($lingua) {
case "it":
$categoria1_percorso = $rigaf[categoria1_it];
break;
case "en":
if ($rigaf[categoria1_en] != "") {
$categoria1_percorso = $rigaf[categoria1_en];
} else {
$categoria1_percorso = $rigaf[categoria1_it];
}
break;
}
}
}
//query per la traduzione della categoria2 del percorso
if ($categoria2 != "") {
$sqlf = "SELECT * FROM qui_prodotti_".$negozio." WHERE categoria2_it = '$categoria2' LIMIT 1";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
switch($lingua) {
case "it":
$categoria2_percorso = $rigaf[categoria2_it];
break;
case "en":
if ($rigaf[categoria2_en] != "") {
$categoria2_percorso = $rigaf[categoria2_en];
} else {
$categoria2_percorso = $rigaf[categoria2_it];
}
break;
}
}
}
//query per la traduzione della categoria3 del percorso
if ($categoria3 != "") {
$sqlf = "SELECT * FROM qui_prodotti_".$negozio." WHERE categoria3_it = '$categoria3' LIMIT 1";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
switch($lingua) {
case "it":
if ($negozio == "labels") {
$categoria3_percorso = substr($rigaf[categoria3_it],4);
} else {
$categoria3_percorso = $rigaf[categoria3_it];
}
break;
case "en":
if ($rigaf[categoria3_en] != "") {
if ($negozio == "labels") {
$categoria3_percorso = substr($rigaf[categoria3_en],4);
} else {
$categoria3_percorso = $rigaf[categoria3_en];
}
} else {
if ($negozio == "labels") {
$categoria3_percorso = substr($rigaf[categoria3_it],4);
} else {
$categoria3_percorso = $rigaf[categoria3_it];
}
}
break;
}
}
}

$sqld = "SELECT * FROM qui_carrelli WHERE id_utente = '$id_utente' AND attivo = '1'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione1" . mysql_error());
$num_carrelli = mysql_num_rows($risultd);
//echo "num_carrelli: ".$num_carrelli."<br>";
//c'è un carello attivo
if ($num_carrelli > 0) {
while ($rigad = mysql_fetch_array($risultd)) {
$id_carrello = $rigad[id];
$negozio_carrello = $rigad[negozio];
}
$querya = "SELECT * FROM qui_righe_carrelli WHERE id_carrello = '$id_carrello' AND cancellato = '0'";
$result = mysql_query($querya);
$elementi_in_carrello = mysql_num_rows($result);
}
//echo "SESSION[idunita]: ".$_SESSION[idunita]."<br>";
//echo "SESSION[nomeunita]: ".stripslashes($_SESSION[nomeunita])."<br>";
//echo "negozio_carrello: ".$negozio_carrello."<br>";
//echo "id_carrello: ".$id_carrello."<br>";
/*
$array_categorie_assets = array();
//$sqlq = "SELECT DISTINCT categoria1_it FROM qui_prodotti_assets ORDER BY precedenza ASC";
$sqlq = "SELECT DISTINCT ".$categoria1_lang." FROM qui_prodotti_assets ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
$num_categorie = mysql_num_rows($risultq);
$num_colonne = ceil(($num_categorie/$num_righeXcolonna));
while ($rigaq = mysql_fetch_array($risultq)) {
$add_categ = array_push($array_categorie_assets,$rigaq[$categoria1_lang]);
}
foreach ($array_categorie_assets as $sing_categ) {
  $contatore = $contatore +1;
  if ($contatore == 1) {
  //scrivo colonna della tabella contenitore
$tabella_sottomenu_assets .= "<div class=col>";
//$tabella_sottomenu_assets .= "<ul>";
  }
  //scrivo le righe da 1 al numero di righe impostato
  if ($contatore <= $num_righeXcolonna) {
  $tabella_sottomenu_assets .= "<li>";
  $tabella_sottomenu_assets .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=1&negozio=assets&categoria1=".$sing_categ.">".str_replace("_"," ",$sing_categ)."</a>";
  $tabella_sottomenu_assets .= "</li>";
  }
  //se sono arrivato al numero di righe impostato chiudo la tabella del sottomenu  e la colonna della tabella contenitore
  if ($contatore == $num_righeXcolonna) {
  //$tabella_sottomenu_assets .= "</ul>";
  $tabella_sottomenu_assets .= "</div>";
  $contatore = 0;
  }

//fine foreach      
}

$contatore = 0;
$quoz = intval($num_categorie/$num_righeXcolonna);
$resto = $num_categorie - ($quoz * $num_righeXcolonna);
if ($resto > 0) {
  //$tabella_sottomenu_assets .= "</ul>";
  $tabella_sottomenu_assets .= "</div>";
}
$quoz = "";
$resto = "";
$num_categorie = "";
*/



switch($lingua) {
case "it":
$categoria1_lang = "categoria1_it";
break;
case "en":
$categoria1_lang = "categoria1_en";
break;
}
$array_categorie_assets_paesi = array("Bombole","Valvole","Pacchi_bombole","Cylinder","Valves","Cylinder_bundles");
$array_categorie_assets = array();
$array_categorie_assets_vis = array();
$sqlq = "SELECT DISTINCT categoria1_it,categoria1_en FROM qui_prodotti_assets WHERE obsoleto = '0' ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
$num_categorie = mysql_num_rows($risultq);
$num_colonne = ceil(($num_categorie/$num_righeXcolonna));
while ($rigaq = mysql_fetch_array($risultq)) {
$add_categ = array_push($array_categorie_assets,$rigaq[categoria1_it]);
$add_categ_vis = array_push($array_categorie_assets_vis,$rigaq[$categoria1_lang]);
}
$elem_att = 0;
$tabella_sottomenu_assets .= '<div style="float: left; width: auto; height: auto; overflow: hidden; min-height:30px;">';
foreach ($array_categorie_assets_vis as $sing_categ_vis) {
  $contatore = $contatore +1;
  if ($contatore == 1) {
  //scrivo colonna della tabella contenitore
$tabella_sottomenu_assets .= "<div class=col>";
//$tabella_sottomenu_assets .= "<ul>";
  }
  //scrivo le righe da 1 al numero di righe impostato
  if ($contatore <= $num_righeXcolonna) {
  $tabella_sottomenu_assets .= '<li class="evidgrey">';
  if (in_array($sing_categ_vis,$array_categorie_assets_paesi)) {
	//if (is_file("staging.php")) {
		$tabella_sottomenu_assets .= "<a href=ricerca_assets.php?limit=".$limit."&page=1&negozio=assets&categoria1=".$array_categorie_assets[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
	//} else {
  //$tabella_sottomenu_assets .= "<a href=sospensione.php?limit=".$limit."&page=1&negozio=assets&categoria1=".$array_categorie_assets[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
	//}
  } else {
  if ($sing_categ_vis != ".") {
  $tabella_sottomenu_assets .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=1&negozio=assets&categoria1=".$array_categorie_assets[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
  }
  }
  $tabella_sottomenu_assets .= "</li>";
  }
  //se sono arrivato al numero di righe impostato chiudo la tabella del sottomenu  e la colonna della tabella contenitore
  if ($contatore == $num_righeXcolonna) {
  //$tabella_sottomenu_assets .= "</ul>";
  $tabella_sottomenu_assets .= "</div>";
  $contatore = 0;
  }
  
$elem_att = $elem_att+1;
//fine foreach      
}
$tabella_sottomenu_assets .= '</div>';

$contatore = 0;
$quoz = intval($num_categorie/$num_righeXcolonna);
$resto = $num_categorie - ($quoz * $num_righeXcolonna);
if ($resto > 0) {
  //$tabella_sottomenu_assets .= "</ul>";
  $tabella_sottomenu_assets .= '<div style="float:right; width:100px; height: auto; min-height: 20px; overflow: hidden; margin-top:20px;">';
  //$tabella_sottomenu_assets .= "lorem ipsum dolor amet";
  $tabella_sottomenu_assets .= "</div>";
  $tabella_sottomenu_assets .= "</div>";
}
$quoz = "";
$resto = "";
$num_categorie = "";
$elem_att = "";






/*echo "array cat assets: ";
print_r($array_categorie_assets);
echo "<br>";
*/
//tabella sottomenu consumabili
$array_categorie_consumabili = array();
$array_categorie_consumabili_vis = array();
$sqlq = "SELECT DISTINCT categoria1_it,categoria1_en FROM qui_prodotti_consumabili ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
$num_categorie = mysql_num_rows($risultq);
$num_colonne = ceil(($num_categorie/$num_righeXcolonna));
while ($rigaq = mysql_fetch_array($risultq)) {
$add_categ = array_push($array_categorie_consumabili,$rigaq[categoria1_it]);
$add_categ_vis = array_push($array_categorie_consumabili_vis,$rigaq[$categoria1_lang]);
}
$elem_att = 0;
foreach ($array_categorie_consumabili_vis as $sing_categ_vis) {
  $contatore = $contatore +1;
  if ($contatore == 1) {
  //scrivo colonna della tabella contenitore
$tabella_sottomenu_consumabili .= "<div class=col>";
//$tabella_sottomenu_consumabili .= "<ul>";
  }
  //scrivo le righe da 1 al numero di righe impostato
  if ($contatore <= $num_righeXcolonna) {
  $tabella_sottomenu_consumabili .= "<li>";
  //if ($sing_categ_vis == "Documentazione_Pharma") {
    //$tabella_sottomenu_consumabili .= "<a href=ricerca_etichette_pharma.php?limit=".$limit."&page=1&negozio=consumabili&categoria1=".$array_categorie_consumabili[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
//} else {
    $tabella_sottomenu_consumabili .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=1&negozio=consumabili&categoria1=".$array_categorie_consumabili[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
//}
  $tabella_sottomenu_consumabili .= "</li>";
  }
  //se sono arrivato al numero di righe impostato chiudo la tabella del sottomenu  e la colonna della tabella contenitore
  if ($contatore == $num_righeXcolonna) {
  //$tabella_sottomenu_consumabili .= "</ul>";
  $tabella_sottomenu_consumabili .= "</div>";
  $contatore = 0;
  }

$elem_att = $elem_att+1;
//fine foreach      
 }

  $contatore = 0;
$quoz = intval($num_categorie/$num_righeXcolonna);
$resto = $num_categorie - ($quoz * $num_righeXcolonna);
if ($resto > 0) {
 // $tabella_sottomenu_consumabili .= "</ul>";
  $tabella_sottomenu_consumabili .= "</div>";
}
$quoz = "";
$resto = "";
$num_categorie = "";
$elem_att = "";


//fine tabella consumabili
//tabella sottomenu spare parts
$array_categorie_spare_parts = array();
$array_categorie_spare_parts_vis = array();
$sqlq = "SELECT DISTINCT categoria1_it,categoria1_en FROM qui_prodotti_spare_parts ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
$num_categorie = mysql_num_rows($risultq);
$num_colonne = ceil(($num_categorie/$num_righeXcolonna));
while ($rigaq = mysql_fetch_array($risultq)) {
$add_categ = array_push($array_categorie_spare_parts,$rigaq[categoria1_it]);
$add_categ_vis = array_push($array_categorie_spare_parts_vis,$rigaq[$categoria1_lang]);
}
$elem_att = 0;
foreach ($array_categorie_spare_parts_vis as $sing_categ_vis) {
  $contatore = $contatore +1;
  if ($contatore == 1) {
  //scrivo colonna della tabella contenitore
$tabella_sottomenu_spare_parts .= "<div class=col>";
//$tabella_sottomenu_assets .= "<ul>";
  }
  //scrivo le righe da 1 al numero di righe impostato
  if ($contatore <= $num_righeXcolonna) {
  $tabella_sottomenu_spare_parts .= '<li class="evidgrey">';
  $tabella_sottomenu_spare_parts .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=1&negozio=spare_parts&categoria1=".$array_categorie_spare_parts[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
  $tabella_sottomenu_spare_parts .= "</li>";
  }
  //se sono arrivato al numero di righe impostato chiudo la tabella del sottomenu  e la colonna della tabella contenitore
  if ($contatore == $num_righeXcolonna) {
  //$tabella_sottomenu_assets .= "</ul>";
  $tabella_sottomenu_spare_parts .= "</div>";
  $contatore = 0;
  }
  
$elem_att = $elem_att+1;
//fine foreach      
}

$contatore = 0;
$quoz = intval($num_categorie/$num_righeXcolonna);
$resto = $num_categorie - ($quoz * $num_righeXcolonna);
if ($resto > 0) {
  //$tabella_sottomenu_assets .= "</ul>";
  $tabella_sottomenu_spare_parts .= "</div>";
}
$quoz = "";
$resto = "";
$num_categorie = "";
$elem_att = "";

//tabella sottomenu labels
$array_categorie_labels = array();
$array_categorie_labels_vis = array();
$sqlq = "SELECT DISTINCT categoria1_it,categoria1_en FROM qui_prodotti_labels ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
$num_categorie = mysql_num_rows($risultq);
$num_colonne = ceil(($num_categorie/$num_righeXcolonna));
while ($rigaq = mysql_fetch_array($risultq)) {
$add_categ = array_push($array_categorie_labels,$rigaq[categoria1_it]);
$add_categ_vis = array_push($array_categorie_labels_vis,$rigaq[$categoria1_lang]);
}
$elem_att = 0;
foreach ($array_categorie_labels_vis as $sing_categ_vis) {
  $contatore = $contatore +1;
  if ($contatore == 1) {
  //scrivo colonna della tabella contenitore
$tabella_sottomenu_labels .= "<div class=col>";
//$tabella_sottomenu_consumabili .= "<ul>";
  }
  //scrivo le righe da 1 al numero di righe impostato
  if ($contatore <= $num_righeXcolonna) {
  $tabella_sottomenu_labels .= "<li>";
    $tabella_sottomenu_labels .= "<a href=ricerca_etichette_pharma.php?limit=".$limit."&page=1&negozio=labels&categoria1=".$array_categorie_labels[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
  $tabella_sottomenu_labels .= "</li>";
  }
  //se sono arrivato al numero di righe impostato chiudo la tabella del sottomenu  e la colonna della tabella contenitore
  if ($contatore == $num_righeXcolonna) {
  //$tabella_sottomenu_consumabili .= "</ul>";
  $tabella_sottomenu_labels .= "</div>";
  $contatore = 0;
  }

$elem_att = $elem_att+1;
//fine foreach      
 }

$quoz = intval($num_categorie/$num_righeXcolonna);
$resto = $num_categorie - ($quoz * $num_righeXcolonna);
if ($resto > 0) {
 // $tabella_sottomenu_labels .= "</ul>";
  $tabella_sottomenu_labels .= "</div>";
}
$contatore = 0;
$quoz = "";
$resto = "";
$num_categorie = "";
$elem_att = "";
//fine tabella labels

//tabella sottomenu vivistore
  $array_categorie_vivistore = array();
  $array_categorie_vivistore_vis = array();

$sqlq = "SELECT DISTINCT categoria1_it,categoria1_en FROM qui_prodotti_vivistore WHERE obsoleto = '0' ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
$num_categorie = mysql_num_rows($risultq);
$num_colonne = ceil(($num_categorie/$num_righeXcolonna));
while ($rigaq = mysql_fetch_array($risultq)) {
$add_categ = array_push($array_categorie_vivistore,$rigaq[categoria1_it]);
$add_categ_vis = array_push($array_categorie_vivistore_vis,$rigaq[$categoria1_lang]);
}
$elem_att = 0;


foreach ($array_categorie_vivistore_vis as $sing_categ_vis) {
  $contatore = $contatore +1;
  if ($contatore == 1) {
  //scrivo colonna della tabella contenitore
$tabella_sottomenu_vivistore .= "<div class=col>";
//$tabella_sottomenu_vivistore .= "<ul>";
  }
  //scrivo le righe da 1 al numero di righe impostato
  if ($contatore <= $num_righeXcolonna) {
  $tabella_sottomenu_vivistore .= '<li class="evidgreen">';
  $tabella_sottomenu_vivistore .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=".$page."&negozio=vivistore&categoria1=".$array_categorie_vivistore[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
  $tabella_sottomenu_vivistore .= "</li>";
  }
  //se sono arrivato al numero di righe impostato chiudo la tabella del sottomenu  e la colonna della tabella contenitore
  if ($contatore == $num_righeXcolonna) {
 // $tabella_sottomenu_vivistore .= "</ul>";
  $tabella_sottomenu_vivistore .= "</div>";
  $contatore = 0;
  }

$elem_att = $elem_att+1;
//fine foreach      
 }

  $contatore = 0;
$quoz = intval($num_categorie/$num_righeXcolonna);
$resto = $num_categorie - ($quoz * $num_righeXcolonna);
if ($resto > 0) {
  //$tabella_sottomenu_vivistore .= "</ul>";
  $tabella_sottomenu_vivistore .= "</div>";
}
$quoz = "";
$resto = "";
$num_categorie = "";
$elem_att = "";

/*
//tabella sottomenu labels
$array_categorie_labels = array();
$array_categorie_labels_vis = array();
//$sqlq = "SELECT DISTINCT paese FROM qui_prodotti_labels ORDER BY paese ASC";
$sqlq = "SELECT DISTINCT categoria3_it FROM qui_prodotti_labels WHERE categoria3_it != '' ORDER BY categoria3_it ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
$num_categorie = mysql_num_rows($risultq);
$num_colonne = ceil(($num_categorie/$num_righeXcolonna));
while ($rigaq = mysql_fetch_array($risultq)) {
$add_categ = array_push($array_categorie_labels,$rigaq[paese]);
$add_categ_vis = array_push($array_categorie_labels_vis,$rigaq[paese]);
}
$elem_att = 0;
foreach ($array_categorie_labels_vis as $sing_categ_vis) {
  $contatore = $contatore +1;
  if ($contatore == 1) {
  //scrivo colonna della tabella contenitore
$tabella_sottomenu_labels .= "<div class=col>";
//$tabella_sottomenu_consumabili .= "<ul>";
  }
  //scrivo le righe da 1 al numero di righe impostato
  if ($contatore <= $num_righeXcolonna) {
  $tabella_sottomenu_labels .= "<li>";
//  if ($sing_categ_vis == "Documentazione_Pharma") {
//$tabella_sottomenu_labels .= "<a href=ricerca_etichette_pharma.php?limit=".$limit."&page=1&categoria1=Documentazione_Pharma&negozio=labels>".str_replace("_"," ",$sing_categ_vis)."</a>";
$tabella_sottomenu_labels .= "<a href=ricerca_etichette_pharma.php?limit=".$limit."&page=1&categoria1=Documentazione_Pharma&negozio=labels>Testo da sostituire</a>";
//} else {
    //$tabella_sottomenu_labels .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=1&categoria1=Documentazione_Pharma&negozio=labels&paese=".$array_categorie_labels[$elem_att].">".str_replace("_"," ",$sing_categ_vis)."</a>";
//}
  $tabella_sottomenu_labels .= "</li>";
  }
  //se sono arrivato al numero di righe impostato chiudo la tabella del sottomenu  e la colonna della tabella contenitore
  if ($contatore == $num_righeXcolonna) {
  //$tabella_sottomenu_consumabili .= "</ul>";
  $tabella_sottomenu_labels .= "</div>";
  $contatore = 0;
  }

$elem_att = $elem_att+1;
//fine foreach      
 }

  $contatore = 0;
$quoz = intval($num_categorie/$num_righeXcolonna);
$resto = $num_categorie - ($quoz * $num_righeXcolonna);
if ($resto > 0) {
 // $tabella_sottomenu_labels .= "</ul>";
  $tabella_sottomenu_labels .= "</div>";
}
$quoz = "";
$resto = "";
$num_categorie = "";
$elem_att = "";
//fine tabella labels
*/


//tabella sottomenu labels
/*$tabella_sottomenu_labels .= "<div class=col>";
$tabella_sottomenu_labels .= "<li>";
$tabella_sottomenu_labels .= "<a href=ricerca_etichette_pharma.php?limit=".$limit."&page=1&categoria1=Documentazione_Pharma&negozio=labels>";
switch ($lang) {
	case "":
$tabella_sottomenu_labels .= "L'utilizzo della sezione Pharma labels<br> è destinato esclusivamente <br>ai responsabili del settore medicale. <br>Clicca qui per proseguire >>>"; 
	break;
	case "it":
$tabella_sottomenu_labels .= "L'utilizzo della sezione Pharma labels<br> è destinato esclusivamente <br>ai responsabili del settore medicale. <br>Clicca qui per proseguire >>>"; 
	break;
	case "en":
$tabella_sottomenu_labels .= "The use of Pharma Labelssection <br>is intended for those responsible <br>of the medical department. <br>Click here to continue >>>";
	break;
}
$tabella_sottomenu_labels .= "</a>";
  $tabella_sottomenu_labels .= "</li>";
  $tabella_sottomenu_labels .= "</div>";
*/
//fine tabella labels
//tabella sottomenu meddevice
/*  $array_categorie_meddevice = array();
//$sqlq = "SELECT DISTINCT categoria1_it FROM qui_prodotti ORDER BY categoria1_it ASC";
$sqlq = "SELECT DISTINCT ".$categoria1_lang." FROM qui_prodotti_meddevice ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
$num_categorie = mysql_num_rows($risultq);
$num_colonne = ceil(($num_categorie/$num_righeXcolonna));
while ($rigaq = mysql_fetch_array($risultq)) {
$add_categ = array_push($array_categorie_meddevice,$rigaq[$categoria1_lang]);
}
foreach ($array_categorie_meddevice as $sing_categ) {
  $contatore = $contatore +1;
  if ($contatore == 1) {
  //scrivo colonna della tabella contenitore
$tabella_sottomenu_meddevice .= "<div class=col>";
//$tabella_sottomenu_meddevice .= "<ul>";
  }
  //scrivo le righe da 1 al numero di righe impostato
  if ($contatore <= $num_righeXcolonna) {
  $tabella_sottomenu_meddevice .= "<li>";
  $tabella_sottomenu_meddevice .= "<a href=ricerca_prodotti.php?limit=".$limit."&page=".$page."&negozio=meddevice&categoria1=".$sing_categ.">".str_replace("_"," ",$sing_categ)."</a>";
  $tabella_sottomenu_meddevice .= "</li>";
  }
  //se sono arrivato al numero di righe impostato chiudo la tabella del sottomenu  e la colonna della tabella contenitore
  if ($contatore == $num_righeXcolonna) {
  //$tabella_sottomenu_meddevice .= "</ul>";
  $tabella_sottomenu_meddevice .= "</div>";
  $contatore = 0;
  }

//fine foreach      
 }

  $contatore = 0;
$quoz = intval($num_categorie/$num_righeXcolonna);
$resto = $num_categorie - ($quoz * $num_righeXcolonna);
if ($resto > 0) {
  //$tabella_sottomenu_meddevice .= "</ul>";
  $tabella_sottomenu_meddevice .= "</div>";
}
$quoz = "";
$resto = "";
$num_categorie = "";
*/
//determino il colore di sfondo delle righe al mouseover
$sfondo_highlight = "hilightcolor";
//determino i colori di sfondo delle righe alternate al bianco delle tABELLE
switch ($negozio) {
case "assets":
//$sfondo_righe_tab = "#d9d9d9";
$sfondo_righe_tab = "assetColor";
//$sfondo_righe_tab = "#F0F0F0";
break;
case "consumabili":
//$sfondo_righe_tab = "#ffd9d9";
////$sfondo_righe_tab = "#ffd9d9";
$sfondo_righe_tab = "consumableColor";
break;
case "spare_parts":
//$sfondo_righe_tab = "#e3dbe8";
$sfondo_righe_tab = "sparePartsColor";
break;
case "labels":
//$sfondo_righe_tab = "#ffd9d9";
////$sfondo_righe_tab = "#ffd9d9";
$sfondo_righe_tab = "labelsColor";
break;
case "vivistore":
//$sfondo_righe_tab = "#d9f2e5";
$sfondo_righe_tab = "vivistoreColor";
break;
case "meddevice":
//$sfondo_righe_tab = "#d9e6ff";
//$sfondo_righe_tab = "#F0F0F0";
$sfondo_righe_tab = "medDeviceColor";
break;
case "carrello":
//$sfondo_righe_tab = "#d9e6ff";
$sfondo_righe_tab = "carrelloColor";
//$sfondo_righe_tab = "#F0F0F0";
break;
case "rda":
//$sfondo_righe_tab = "#d9e6ff";
$sfondo_righe_tab = "rdaColor";
//$sfondo_righe_tab = "#F0F0F0";
break;
case "Preferiti":
//$sfondo_righe_tab = "#d9e6ff";
$sfondo_righe_tab = "consumableColor";
//$sfondo_righe_tab = "#F0F0F0";
break;
//case "search":
//$sfondo_righe_tab = "#fff7d9";
//$sfondo_righe_tab = "searchColor";
//break;
}
if ($carrello != "") {
$sfondo_righe_tab = "#d9e6ff";
}
$sqld = "SELECT * FROM qui_carrelli WHERE id_utente = '$id_utente' AND attivo = '1' AND ordine = '0'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione7" . mysql_error());
$num_carrelli = mysql_num_rows($risultd);
if ($num_carrelli > 0) {
while ($rigad = mysql_fetch_array($risultd)) {
$id_carrello = $rigad[id];
}
}

include "traduzioni_interfaccia.php";
//echo '<span style="color:#000;">negozio menu: '.$negozio.'<br>';
//echo '<span style="color:#000;">Negozio: '.$negozio.'</span><br>';

?>
<!DOCTYPE html><head>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $("#data_inizio" ).datepicker();
  });
  $(function() {
    $("#data_fine" ).datepicker();
  });
  </script>
  <SCRIPT type="text/javascript">
function aggiorna(){
document.form_lingua.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
document.form_lingua.submit();
}
</SCRIPT>
<!--<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/
<?php
/*switch ($lingua) {
case "it":
echo "calendar.js";
break;
case "en":
echo "calendar_en.js";
break;
}
*/?>"></script>-->
<style type="text/css">
<!--
.Stile_alert {
	font-size: 16px;
	font-family: Arial;
	color: #FF0000;
	font-weight: bold;
}
.Stile2 {
	font-size: 12px;
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Stile3 {
	font-size: 12px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.modulo_percorso {
	float:left;
font-family:Arial;
font-size:16px;
font-weight:bold;
width:auto;
height:auto;
padding-right:5px;
color:#000;
cursor:pointer;
}
.modulo_percorso_rosso {
font-family:Arial;
font-size:16px;
font-weight:bold;
width:auto;
height:auto;
padding-right:5px;
color:#F00;
	float:left;
}
.Stile4 {font-family: Arial}
-->
</style>
</head>
<?php
if ($_SESSION[user_id] == "") {
echo "<body onLoad=location.replace('http://www.solgroup/Pub/DITP/DIMM/SMR/ordine.asp');>";
exit;
} else {
echo "<body>";
}
?>

<div id="wrap" style="text-align:left;">
<div id="lingua">
<!--<div style="width:194px; height:15px; float:left;">-->
<div style="width:110px; height:15px; float:left;">

<!--vuoto-->
</div>
<a href=chiusura.php>
<div style="width:110px; height:10px; float:left; cursor:pointer; color:rgb(0,0,0);">
Logout
</div>
</a>
<!--<div style="width:212px; height:15px; float:left;">-->
<div style="width:295px; height:15px; float:left;">
<!--vuoto-->
</div>
	<?php 
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
	echo "<div style=\"width:100px; height:15px; float:left;\">";
	//vuoto-->
	echo "</div>";
if (($vis_fatturazione != "") OR ($vis_ordini != "") OR ($vis_report != "")) {
	echo "<div style=\"width:100px; height:15px; float:left; cursor:pointer;\">";
	echo "<a href=menu_interm.php target=_blank>";
	echo "<span style=\"color:rgb(0,0,0);\">";
	echo "Amministrazione";
	echo "</span>";
	echo "</a>";
} else {
	echo "<div style=\"width:100px; height:15px; float:left;\">";
	//vuoto-->
}
echo "</div>";
?>
<a href="mailto:adv@publiem.it?bcc=publiem@publiem.it&Subject=Qui C'e'">
<div style="width:100px; height:15px; float:left; cursor:pointer; color:rgb(0,0,0);">
 Scrivici
</div>
</a>
<div style="width:130px; height:15px; float:left; text-align:right;">
<form id="form_lingua" name="form_lingua" method="get" action="<?php echo $azione_form; ?>">
          <select name="lang" class="btnProsegui" id="lang" onchange="aggiorna()">
            <?php
            $sqlx = "SELECT * FROM qui_lingue WHERE idioma = '$_SESSION[lang]' AND attiva = '1'";
            $risultx = mysql_query($sqlx) or die("Impossibile eseguire l'interrogazione8" . mysql_error());
            $num_lang = mysql_num_rows($risultx);
            while($rigax = mysql_fetch_array($risultx)) {
              if ($rigax[lang] == $_SESSION[lang]) {
                echo "<option selected value=".$rigax[lang].">".$rigax[desc]."</option>";
                } 
              else{
                echo "<option value=".$rigax[lang].">".$rigax[desc]."</option>";
              }
            }
          ?>
          </select>
          <input name="mod_lang" type="hidden" id="mod_lang" value="1" />
          <input name="page" type="hidden" id="page" value="<?php echo $page; ?>" />
          <input name="limit" type="hidden" id="limit" value="<?php echo $limit; ?>" />
          <input name="paese" type="hidden" id="paese" value="<?php echo $paese; ?>" />
          <input name="negozio" type="hidden" id="negozio" value="<?php echo $negozio; ?>" />
          <input name="categoria1" type="hidden" id="categoria1" value="<?php echo $categoria1; ?>" />
          <input name="categoria2" type="hidden" id="categoria2" value="<?php echo $categoria2; ?>" />
          <input name="categoria3" type="hidden" id="categoria3" value="<?php echo $categoria3; ?>" />
          <input name="categoria4" type="hidden" id="categoria4" value="<?php echo $categoria4; ?>" />
          <?php 
      		if ($posizione != "") {
        		echo "<input name=posizione type=hidden id=posizione value=".$posizione.">";
        		}
      		if ($lista != "") {
        		echo "<input name=lista type=hidden id=lista value=".$lista.">";
        		}
      		if ($archive != "") {
        		echo "<input name=archive type=hidden id=archive value=".$archive.">";
        		}
      //		if ($preferiti != "") {
      		  echo "<input name=Preferiti type=hidden id=Preferiti value=".$preferiti.">";
      //		}
      		?>
    </form>
</div>
<div style="width:20px; height:15px; float:left;">
<!--vuoto-->
<?php 
if ($posizione != "") {
	echo "<input name=posizione type=hidden id=posizione value=".$posizione.">";
	}
if ($lista != "") {
	echo "<input name=lista type=hidden id=lista value=".$lista.">";
	}
if ($archive != "") {
	echo "<input name=archive type=hidden id=archive value=".$archive.">";
	}
//		if ($preferiti != "") {
  echo "<input name=Preferiti type=hidden id=Preferiti value=".$preferiti.">";
//		}
?>
</div>

</div><!--END DIV_LINGUA-->

<div id="testa">
    <div id="logo"><a href="index.php"><img src="immagini/logo-quice.png" width="90" height="70" border="0" /></a></div>
  <!--END LOGO-->
      <?php 
  		  echo "<span style=\"color: rgb(0,0,0);\"><strong>".stripslashes(stripslashes($_SESSION[nome]))."</strong><br>".stripslashes($_SESSION[nomeunita]);
		  switch ($_SESSION[ruolo]) {
		  case "utente":
		  switch ($_SESSION[lang]) {
		  case "it":
		  $role = "utente";
		  break;
		  case "en":
		  $role = "user";
		  break;
		  }
		  break;
		  case "responsabile":
		  switch ($_SESSION[lang]) {
		  case "it":
		  $role = "responsabile";
		  break;
		  case "en":
		  $role = "manager";
		  break;
		  }
		  break;
/*		  case "buyer":
		  switch ($_SESSION[lang]) {
		  case "it":
		  $role = "buyer";
		  break;
		  case "en":
		  $role = "buyer";
		  break;
		  }
		  break;
*/
		  case "admin":
		  switch ($_SESSION[lang]) {
		  case "it":
		  $role = "admin";
		  break;
		  case "en":
		  $role = "admin";
		  break;
		  }
		  break;
		  }
if ($_SESSION[negozio_buyer] != "") {
		  $role = "buyer";
}

     echo "<br><strong>".ucfirst($role)."</strong>";
	 if ($_SESSION[ruolo] == "utente") {
		  switch ($_SESSION[lang]) {
		  case "it":
	 echo "<br>Responsabile ";
		  break;
		  case "en":
	 echo "<br>Manager ";
		  break;
		  }
	 echo $_SESSION[nome_resp];
	 }
	 echo "<span>";
     //    echo "<br><strong>".ucfirst($_SESSION[ruolo])."</strong>";
		  ?>
    <div id="bottoni_testata">
		  <a href=pag_ricerca.php?posizione=Ricerca>
          <div class="btnRicerca">
          <?php
            echo "<br>";
            echo $testo_ricerca;
          ?>
          </div><!--END BOTTONE RICERCA-->
         </a>
          <a href="carrello.php?a=1&negozio=carrello&id_cart=<?php echo $id_carrello; ?>">
          <div class="btnCarrello" id="vis_carrello">
            <?php
			
              if ($elementi_in_carrello > 0) {
              if ($elementi_in_carrello == 1) {
                  echo $elementi_in_carrello." ".$testo_prodotto."<br>";
              } else {
                  echo $elementi_in_carrello." ".$testo_prodotti."<br>";
              }
                	echo "<strong>".$testo_carrello."</strong>";
              } else{
                echo "<br><strong>".$testo_carrello_vuoto."</strong>";
              }

            ?>
       </div><!--END BOTTONE CARRELLO-->
          </a>
   </div>
    <!--END BOTTONI TESTATA-->

  </div>
<div id="menu">

		<a id="menuAsset" class="voce_top_menu_grey" href="#" onmouseover="visualizza('asset');" onmouseout="nascondi('asset');"><?php echo $tasto_asset; ?></a>
		<a id="menuSpareParts" class="voce_top_menu_blue_grey" href="#" onmouseover="visualizza('spareParts');" onmouseout="nascondi('spareParts');"><?php echo $tasto_spare_parts; ?></a>
		<a id="menuConsumable" class="voce_top_menu_dark_blue" href="#" onmouseover="visualizza('consumable');" onmouseout="nascondi('consumable');"><?php echo $tasto_consumabili; ?></a>
        <a id="menuLabels" class="voce_top_menu" href="#" onmouseover="visualizza('labels');" onmouseout="nascondi('labels');"><?php echo $tasto_labels; ?></a>
        <a id="menuVivistore" class="voce_top_menu_viv" href="#" onmouseover="visualizza('vivistore');" onmouseout="nascondi('vivistore');"><?php echo $tasto_vivistore; ?></a>
		<a class="select_market" href="#"></a>

		

  </div><!--END MENU-->

<div id="asset" onmouseover="visualizza('asset')" onmouseout="nascondi()">
<?php echo $tabella_sottomenu_assets; ?>	
</div>
<!--END ASSET-->

<div id="consumable" onmouseover="visualizza('consumable')" onmouseout="nascondi()">
<?php echo $tabella_sottomenu_consumabili; ?>	
</div>
<!--END CONSUMABLES-->

<div id="spareParts" onmouseover="visualizza('spareParts')" onmouseout="nascondi()">
<?php echo $tabella_sottomenu_spare_parts; ?>	
</div>
<!--END SPARE PARTS-->

<div id="labels" onmouseover="visualizza('labels')" onmouseout="nascondi()">
<?php echo $tabella_sottomenu_labels; ?>	
</div>
<!--END LABELS-->

<div id="vivistore" onmouseover="visualizza('vivistore')" onmouseout="nascondi()">
<?php echo $tabella_sottomenu_vivistore; ?>	
</div>
<!--END vivistore-->

<!--<div id="medDevice" onmouseover="visualizza('medDevice')" onmouseout="nascondi()">
<?php //echo $tabella_sottomenu_meddevice; ?>	
</div>
<!--END MED DEVICE-->

<!--		<div id="search" onmouseover="visualizza('search')" onmouseout="nascondi()">
<?php
//echo $tabella_sottomenu_search;
?>	
		</div>
-->
<!--END SEARCH-->
<?php
if ($file_presente == "lista_rda.php") {
  if ($archive != "") {
	  $classe_archiviate = "subsub_evid";
	  $classe_attive = "subsub";
	} else {
	  $classe_archiviate = "subsub";
	  $classe_attive = "subsub_evid";
  }
} else {
	  $classe_archiviate = "subsub";
	  $classe_attive = "subsub";
}
if ($file_presente == "lista_preferiti.php") {
	  $classe_pref = "subsub_evid";
} else {
	  $classe_pref = "subsub";
}
if ($file_presente == "report_righe_nuovo.php") {
	  $classe_process = 'subsub_evid"';
} else {
	  $classe_process = 'subsub" style="color:red;';
}
?>
	<div id="subMenu">
				<a href="lista_preferiti.php?a=1&Preferiti=1&negozio=Preferiti"><div class="<?php echo $classe_pref; ?>"><?php echo $tasto_bookmark; ?></div></a>
				<a href="lista_rda.php?a=1&archive=1&lista=RdA&pers=1"><div class="<?php echo $classe_archiviate; ?>"><?php echo $tasto_archivio; ?></div></a>
				<a href="lista_rda.php?a=1&lista=RdA&pers=1"><div class="<?php echo $classe_attive; ?>"><?php echo $tasto_rda; ?></div></a>
				<?php
					if ($vis_magazzino == "1") {
                //echo "<li style=\"color:red;\">"; 
                //echo "<li style=\"color:red;\">"; 
        //echo "<a href=lista_rda.php?a=1&archive=1&lista=RdA><div class=subsub style=\"color:red;\">";
					//echo $tasto_arch_gen;
                //echo "</li>"; 
                //echo "</div></a>"; 
				switch ($_SESSION[nome]) {
					case "Giorgio Gaiani":
					  echo '<a href="report_righe_mag.php"><div class="'.$classe_process.'">';
					break;
					case "AAA-MAGAZZINIERE":
					  echo '<a href="report_righe_nuovo.php"><div class="subsub"'.$classe_process.'">';
					break;
				}
				//perchè comporta la visualizzazione a righe delle RdA su Staging
				//una volta approvata, scomparirà quella classica a RDA intere
				echo $tasto_rda_lav;
                //echo "</li>"; 
                echo "</div></a>"; 
					}
					if ($vis_gestione == "1") {
                //echo "<li style=\"color:red;\">"; 
        /*echo "<a href=lista_rda.php?a=1&archive=1&lista=RdA><div class=subsub style=\"color:red;\">";
							echo $tasto_arch_gen;
                //echo "</li>"; 
                echo "</div></a>"; */
                //echo "<li style=\"color:red;\">"; 
        echo "<a href=report_righe_nuovo.php><div class=subsub style=\"color:red;\">";
							echo $tasto_rda_lav;
                //echo "</li>"; 
                echo "</div></a>"; 
					}
				?>
  </div>
	<!--END MENU 2-->
    <?php
	//echo "ruolo: ".$_SESSION[ruolo]."<br>";
	//echo "ruolo_report: ".$_SESSION[ruolo_report]."<br>";
	?>
    
  <div class="contenitore_percorso_nuovo">
    <div id="percorso">
    	<a href=index.php>
        <div class="modulo_percorso">
        Home
        </div>
        </a> 
        <?php
if ($negozio == "Preferiti") {
  echo "<div class=modulo_percorso_rosso>";
	switch($lingua) {
	case "it":
			echo $tasto_bookmark." di ".stripslashes($_SESSION[nome]);
	break;
	case "en":
			echo stripslashes($_SESSION[nome])." ".$tasto_bookmark;
	break;
	}
  echo "</div>";
}
		switch($negozio) {
		case "assets":
		$negozio_percorso = $tasto_asset;break;
		case "consumabili":
		$negozio_percorso = $tasto_consumabili;break;
		case "spare_parts":
		$negozio_percorso = $tasto_spare_parts;break;
		case "labels":
		$negozio_percorso = $tasto_labels;break;
		case "vivistore":
		$negozio_percorso = $tasto_vivistore;break;
		case "meddevice":
		$negozio_percorso = $tasto_meddevice;break;
		}



		if (($negozio != "") AND ($negozio != "carrello") AND ($negozio != "preferiti")) {
       
        echo "<div class=modulo_percorso>";
		  echo ucfirst($negozio_percorso);
        echo "</div>";
		}
		if ($negozio != "" AND $negozio == "carrello") {
        
        echo "<div class=modulo_percorso>";
		  switch($lingua) {
		  case "it":
				  echo $testata_carrello." ".stripslashes($_SESSION[nome]);
		  break;
		  case "en":
				  echo stripslashes($_SESSION[nome])." ".$testata_carrello;
		  break;
		  }
        echo "</div>";
		}
		/*if ($posizione != "") {
		 
		  echo "<div class=modulo_percorso>";
			echo "<a href=pag_ricerca.php?posizione=".$posizione."><span class=percorso_rosso>".$testo_ricerca."</span></a>";
		  echo "</div>";
		}*/
		$array_switch_paesi = array("Bombole");
		if (in_array($categoria1,$array_switch_paesi)) {
			$pag_var = "ricerca_assets.php";
		} else {
		if ($negozio == "labels") {
			$pag_var = "ricerca_etichette_pharma.php";
		} else {
			$pag_var = "ricerca_prodotti.php";
		}
		}
if ($id_valvola != "") {
	if ($id_valvola == "Senza_valvola") {
			if ($_SESSION[lang] == "it") {
			$descrizione_valvola = "Senza_valvola";
			} else {
			$descrizione_valvola = "No_valve";
			}
	} else {
			$sqlm = "SELECT * FROM qui_prodotti_assets WHERE codice_art = '$id_valvola'";
$risultm = mysql_query($sqlm) or die("Impossibile eseguire l'interrogazione4bis" . mysql_error());
		//echo "<br>query:".$sqlk."<br>";
		while ($rigam = mysql_fetch_array($risultm)) {
			if ($_SESSION[lang] == "it") {
			$descrizione_valvola = $rigam[descrizione1_it];
			} else {
			$descrizione_valvola = $rigam[descrizione1_en];
			}
		}
		}
		
		echo "<a href=".$pag_var."?negozio=".$negozio."&categoria1=".$categoria1.">";
		  echo "<div class=modulo_percorso>";
			echo str_replace("_"," ",$categoria1_percorso);
		  echo "</div>";
		echo "</a>";
	
		if ($categoria1 == "Bombole") {
		echo "<a href=ricerca_settore_bombole_prec.php?negozio=".$negozio."&categoria1=".$categoria1."&paese=".$paese.">";
		} else {
		echo "<a href=ricerca_prodotti.php?negozio=".$negozio."&categoria1=".$categoria1."&paese=".$paese.">";
		}
		if ($paese != "") {
		  echo "<div class=modulo_percorso>";
			echo str_replace("_"," ",$paese);
		  echo "</div>";
		echo "</a>";
		}
	
		if ($categoria1 == "Bombole") {
		  echo "<a href=ricerca_settore_bombole.php?negozio=".$negozio."&categoria1=".$categoria1."&categoria2=".$categoria2."&paese=".$paese.">";
		  echo "<div class=modulo_percorso>";
			echo str_replace("_"," ",ucfirst($categoria2_percorso));
		  echo "</div>";
		  echo "</a>";
		} else {
		echo "<a href=ricerca_prodotti.php?negozio=".$negozio."&categoria1=".$categoria1."&categoria2=".$categoria2."&paese=".$paese.">";
		  echo "<div class=modulo_percorso>";
			echo str_replace("_"," ",$categoria2_percorso);
		  echo "</div>";
		echo "</a>";
		}
	
		echo "<a href=ricerca_prodotti.php?negozio=".$negozio."&categoria1=".$categoria1."&categoria2=".$categoria2."&categoria3=".$categoria3."&paese=".$paese.">";
		  echo "<div class=modulo_percorso>";
			echo str_replace("_"," ",$categoria3_percorso);
		  echo "</div>";
		echo "</a>";

		echo "<div class=modulo_percorso_rosso>";
		echo str_replace("_"," ",$descrizione_valvola);
		echo "</div>";
		} else {
		if ($categoria3 != "") {

		echo "<a href=".$pag_var."?negozio=".$negozio."&categoria1=".$categoria1.">";
		  echo "<div class=modulo_percorso>";
			echo str_replace("_"," ",$categoria1_percorso);
		  echo "</div>";
		echo "</a>";

		if ($categoria1 == "Bombole") {
		if ($paese != "") {
		  echo "<a href=ricerca_settore_bombole_prec.php?negozio=".$negozio."&categoria1=".$categoria1."&paese=".$paese.">";
			echo "<div class=modulo_percorso>";
			  echo str_replace("_"," ",$paese);
			echo "</div>";
		  echo "</a>";
		}
		} else {
			if ($paese != "") {
		  echo "<a href=ricerca_prodotti.php?negozio=".$negozio."&categoria1=".$categoria1."&paese=".$paese.">";
			echo "<div class=modulo_percorso>";
			  echo str_replace("_"," ",$paese);
			echo "</div>";
		  echo "</a>";
			}
		}

		if ($categoria1 == "Bombole") {
		  echo "<a href=ricerca_settore_bombole.php?negozio=".$negozio."&categoria1=".$categoria1."&categoria2=".$categoria2."&paese=".$paese.">";
			echo "<div class=modulo_percorso>";
			  echo str_replace("_"," ",ucfirst($categoria2_percorso));
			echo "</div>";
		  echo "</a>";
		} else {
		  echo "<a href=ricerca_prodotti.php?negozio=".$negozio."&categoria1=".$categoria1."&categoria2=".$categoria2."&paese=".$paese.">";
			echo "<div class=modulo_percorso>";
			  echo str_replace("_"," ",$categoria2_percorso);
			echo "</div>";
		  echo "</a>";
		}

		echo "<div class=modulo_percorso_rosso>";
		  echo str_replace("_"," ",$categoria3_percorso);
		echo "</div>";
		} else {
		if ($categoria2 != "") {

		echo "<a href=".$pag_var."?negozio=".$negozio."&categoria1=".$categoria1.">";
		  echo "<div class=modulo_percorso>";
			echo str_replace("_"," ",$categoria1_percorso);
			echo "</div>";
		  echo "</a>";

		  if ($paese != "") {
			if ($categoria1 == "Bombole") {
				echo "<a href=ricerca_settore_bombole_prec.php?negozio=".$negozio."&categoria1=".$categoria1."&paese=".$paese.">";
			  } else {
				echo "<a href=ricerca_prodotti.php?negozio=".$negozio."&categoria1=".$categoria1."&paese=".$paese.">";
			  }
				echo "<div class=modulo_percorso>";
					echo str_replace("_"," ",$paese);
				echo "</div>";
			  echo "</a>";
		  }
		echo "<div class=modulo_percorso_rosso>";
		  echo str_replace("_"," ",ucfirst($categoria2_percorso));
		echo "</div>";
		} else {
		if ($paese != "") {

		echo "<a href=".$pag_var."?negozio=".$negozio."&categoria1=".$categoria1.">";
		  echo "<div class=modulo_percorso>";
			echo str_replace("_"," ",$categoria1_percorso);
			echo "</div>";
		  echo "</a>";

		echo "<div class=modulo_percorso_rosso>";
		  echo str_replace("_"," ",$paese);
		echo "</div>";
		} else {
		if ($categoria1 != "") {

		echo "<div class=modulo_percorso_rosso>";
		  echo str_replace("_"," ",$categoria1_percorso);
		echo "</div>";
		}
		}
		}
		}
		}

if ($pag_attuale == "guida") {
switch($lingua) {
case "it":
echo " > Guida";
break;
case "en":
echo " > Tutorial";
break;
}
}
if ($pag_attuale == "report_fatturazione") {
switch($lingua) {
case "it":
echo " > Packing List";
break;
case "en":
echo " > Packing List";
break;
}
}
if ($pag_attuale == "report_righe") {
switch($lingua) {
case "it":
echo " > RdA da processare";
break;
case "en":
echo " > Orders being processed";
break;
}
}
if ($pag_attuale == "report_righe_admin") {
switch($lingua) {
case "it":
echo " > Report righe";
break;
case "en":
echo " > Order details";
break;
}
}
if ($pag_attuale == "report_rda.php") {
switch($lingua) {
case "it":
echo " > Report RdA";
break;
case "en":
echo " > Order report";
break;
}
}
if ($pag_attuale == "ordini") {
switch($lingua) {
case "it":
echo " > Ordini fornitore";
break;
case "en":
echo " > Supplyer's orders";
break;
}
}
?>
		</div><!--END PERCORSO-->
        </div>
 <?php

	
//echo "file_presente: ".$file_presente."<br>";
//echo "negozio_ricerca: ".$negozio_ricerca."<br>";
if ($file_presente == "pag_ricerca.php") { 
echo "<div id=ricerca class=submenuRicerca style=\"float:left; width:100%; height:105px; margin-bottom:20px; padding-top:0px;\">";
echo "<div id=formRicerca>";
//echo "PIPPO";
echo "<form action=".$azione_form." method=get name=form_filtri>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$testata_codice.":</strong><br>";
echo "<input name=codice type=text class=tabelle8 id=codice size=10 value=".$codiceDaModulo.">";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$testata_descrizione.":</strong><br>";
echo "<input name=descrizione type=text class=tabelle8 id=descrizione size=20 value=".$descrizioneDaModulo.">";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<strong>".$testo_mail_negozio.":</strong><br>";
echo "<select name=negozio_ricerca class=codice_lista_nopadding id=negozio_ricerca>";
switch ($negozio_ricerca) {
case "":
//echo "<option selected value=0>Tutti i negozi</option>";
echo "<option selected value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "0":
echo "<option selected value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "1":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option selected value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "2":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option selected value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "3":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option selected value=3>".$tasto_spare_parts."</option>";
echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "4":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
echo "<option selected value=4>".$tasto_vivistore."</option>";
echo "<option value=5>".$tasto_labels."</option>";
break;
case "5":
echo "<option value=0>".$tasto_tutti."</option>";
echo "<option value=1>".$tasto_asset."</option>";
echo "<option value=2>".$tasto_consumabili."</option>";
echo "<option value=3>".$tasto_spare_parts."</option>";
echo "<option value=4>".$tasto_vivistore."</option>";
echo "<option selected value=5>".$tasto_labels."</option>";
break;
}
echo "</select>";
echo "</div>";
echo "<div class=col style=\"color:rgb(0,0,0);\">";
echo "<td class=nero_grassettosx12><br><input type=submit name=button id=button value=Filtra>";
echo "</div>";
echo "<input name=posizione type=hidden id=posizione value=".$posizione."> ";
echo "<input name=criterio type=hidden id=criterio value=1> ";

echo "</form>";
echo "</div>";//fine formRicerca

echo "</div>";//fine div id=ricerca class=submenuRicerca

}




?>
</div>

<!--END WRAP-->


<script type="text/javascript">
	//Menu
	var menuAsset = document.getElementById('menuAsset');
	var menuConsumable = document.getElementById('menuConsumable');
	var menuSpareParts = document.getElementById('menuSpareParts');
	var menuLabels = document.getElementById('menuLabels');
	var menuVivistore = document.getElementById('menuVivistore');
	//var menuMedDevice = document.getElementById('menuMedDevice');
	//var menuSearch = document.getElementById('menuSearch');

	//Tendine
	var asset = document.getElementById('asset');
	var consumable = document.getElementById('consumable');
	var spareParts = document.getElementById('spareParts');
	var labels = document.getElementById('labels');
	var vivistore = document.getElementById('vivistore');
	//var medDevice = document.getElementById('medDevice');
	//var search = document.getElementById('search');

	asset.className = 'hide';
	consumable.className = 'hide';
	spareParts.className = 'hide';
	labels.className = 'hide';
	vivistore.className = 'hide';
	//medDevice.className = 'hide';
	//search.className = 'hide';    //COMMENTATO 

	function visualizza(mercato){
		//Menu
		menuAsset.className = mercato == 'asset' ? 'voce_top_menu_grey_hover assetColor' : 'voce_top_menu_grey';
		menuConsumable.className = mercato == 'consumable' ? 'voce_top_menu_dark_blue_hover consumableColor' : 'voce_top_menu_dark_blue';
		menuSpareParts.className = mercato == 'spareParts' ? 'voce_top_menu_blue_grey_hover sparePartsColor' : 'voce_top_menu_blue_grey';
		menuLabels.className = mercato == 'labels' ? 'voce_top_menu_hover labelsColor' : 'voce_top_menu';
		menuVivistore.className = mercato == 'vivistore' ? 'voce_top_menu_viv_hover vivistoreColor' : 'voce_top_menu_viv';
		//menuMedDevice.className = mercato == 'medDevice' ? 'voce_top_menu_hover medDeviceColor' : 'voce_top_menu';
		//menuSearch.className = mercato == 'search' ? 'voce_top_menu_hover search' : 'voce_top_menu';  //COMMENTATO
		
		//Tendine
		asset.className = mercato == 'asset' ? 'show menuAssetBg' : 'hide';
		consumable.className = mercato == 'consumable' ? 'show menuConsumableBg' : 'hide';
		spareParts.className = mercato == 'spareParts' ? 'show menuSpBg' : 'hide';
		labels.className = mercato == 'labels' ? 'show menuLabelsBg' : 'hide';
		vivistore.className = mercato == 'vivistore' ? 'show menuVivistoreBg' : 'hide';
		//medDevice.className = mercato == 'medDevice' ? 'show medDeviceColor' : 'hide';
		//search.className = mercato == 'search' ? 'show search' : 'hide';    //COMMENTATO
	}
	function nascondi(mercato){
		//Menu
		menuAsset.className = 'voce_top_menu_grey';
		menuConsumable.className = 'voce_top_menu_dark_blue';
		menuSpareParts.className = 'voce_top_menu_blue_grey';
		menuLabels.className = 'voce_top_menu';
		menuVivistore.className = 'voce_top_menu_viv';
		//menuMedDevice.className = 'voce_top_menu';
		//menuSearch.className = 'voce_top_menu';  //COMMENTATO
		//Tendine
		asset.className = 'hide';
		consumable.className = 'hide';
		spareParts.className = 'hide';
		labels.className = 'hide';
		vivistore.className = 'hide';
		//medDevice.className = 'hide';
		//search.className = 'hide';  //COMMENTATO

	}
</script>

</body>
</html>