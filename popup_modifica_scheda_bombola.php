<?php
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$id = $_GET[id];
$action = $_GET[action];
$codice_mod = $_GET[codice];
$categoria1_it_mod = $_GET[categoria1_it];
$categoria2_it_mod = $_GET[categoria2_it];
$categoria3_it_mod = $_GET[categoria3_it];
$categoria4_it_mod = $_GET[categoria4_it];
$categoria1_en_mod = $_GET[categoria1_en];
$categoria2_en_mod = $_GET[categoria2_en];
$categoria3_en_mod = $_GET[categoria3_en];
$categoria4_en_mod = $_GET[categoria4_en];

$negozio = $_GET[negozio];
$lingua = $_GET[lang];
//$lingua = $_SESSION[lang];
//echo "sess_immtemp: ".$_SESSION[imm_temp]."<br>";
if (is_file("files/".$_SESSION[imm_temp])) {
unlink("files/".$_SESSION[imm_temp]);
}

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

//caso duplicazione prodotto
if ($action == "duplicate") {
/*$sqlb = "SELECT * FROM qui_prodotti_".$negozio." ORDER BY id DESC LIMIT 1";
$risultb = mysql_query($sqlb) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigab = mysql_fetch_array($risultb)) {
}
*/
$sqlf = "SELECT * FROM qui_prodotti_".$negozio." ORDER BY id DESC LIMIT 1";
$risultf = mysql_query($sqlf) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaf = mysql_fetch_array($risultf)) {
$nuovo_codice_art = intval($rigaf[codice_art])+1;
}

$sqld = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$risultd = mysql_query($sqld) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigad = mysql_fetch_array($risultd)) {
$categoria1_it = $rigad[categoria1_it];
$categoria2_it = $rigad[categoria2_it];
$categoria3_it = $rigad[categoria3_it];
$categoria4_it = $rigad[categoria4_it];
$categoria1_en = $rigad[categoria1_en];
$categoria2_en = $rigad[categoria2_en];
$categoria3_en = $rigad[categoria3_en];
$categoria4_en = $rigad[categoria4_en];
$descrizione1_it = addslashes($rigad[descrizione1_it]);
$descrizione2_it = addslashes($rigad[descrizione2_it]);
$descrizione3_it = addslashes($rigad[descrizione3_it]);
$descrizione4_it = addslashes($rigad[descrizione4_it]);
$descrizione1_en = addslashes($rigad[descrizione1_en]);
$descrizione2_en = addslashes($rigad[descrizione2_en]);
$descrizione3_en = addslashes($rigad[descrizione3_en]);
$descrizione4_en = addslashes($rigad[descrizione4_en]);
$precedenza = $rigad[precedenza];
$foto = $rigad[foto];
$paese = $rigad[paese];
$prezzo = $rigad[prezzo];
$confezione = $rigad[confezione];
$gruppo_merci = $rigad[gruppo_merci];
$wbs = $rigad[wbs];
}
mysql_query("INSERT INTO qui_prodotti_".$negozio." (negozio, paese, categoria1_it, categoria2_it, categoria3_it, categoria4_it, descrizione1_it, descrizione2_it, descrizione3_it, descrizione4_it, codice_art, gruppo_merci, wbs, prezzo, confezione, foto, categoria1_en, categoria2_en, categoria3_en, categoria4_en, descrizione1_en, descrizione2_en, descrizione3_en, descrizione4_en, precedenza) VALUES ('$negozio', '$paese', '$categoria1_it', '$categoria2_it', '$categoria3_it', '$categoria4_it', '$descrizione1_it', '$descrizione2_it', '$descrizione3_it', '$descrizione4_it', '$nuovo_codice_art', '$gruppo_merci', '$wbs', '$prezzo', '$confezione', '$foto', '$categoria1_en', '$categoria2_en', '$categoria3_en', '$categoria4_en', '$descrizione1_en', '$descrizione2_en', '$descrizione3_en', '$descrizione4_en', '$precedenza')");
$id = mysql_insert_id();

}
//fine duplicazione prodotto

$sqleee = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
$categoria1_it = $rigaeee[categoria1_it];
$categoria2_it = $rigaeee[categoria2_it];
$categoria3_it = $rigaeee[categoria3_it];
$categoria4_it = $rigaeee[categoria4_it];
$categoria1_en = $rigaeee[categoria1_en];
$categoria2_en = $rigaeee[categoria2_en];
$categoria3_en = $rigaeee[categoria3_en];
$categoria4_en = $rigaeee[categoria4_en];
$descrizione1_it = $rigaeee[descrizione1_it];
$descrizione2_it = $rigaeee[descrizione2_it];
$descrizione3_it = $rigaeee[descrizione3_it];
$descrizione4_it = $rigaeee[descrizione4_it];
$descrizione1_en = $rigaeee[descrizione1_en];
$descrizione2_en = $rigaeee[descrizione2_en];
$descrizione3_en = $rigaeee[descrizione3_en];
$descrizione4_en = $rigaeee[descrizione4_en];
$foto = $rigaeee[foto];
$codice_art = $rigaeee[codice_art];
$paese = $rigaeee[paese];
$prezzo = str_replace(".",",",$rigaeee[prezzo]);
$confezione = $rigaeee[confezione];
$gruppo_merci = $rigaeee[gruppo_merci];
$wbs = $rigaeee[wbs];
switch($lingua) {
case "it":
$categoria1 = $rigaeee[categoria1_it];
$categoria2 = $rigaeee[categoria2_it];
$categoria3 = $rigaeee[categoria3_it];
$categoria4 = $rigaeee[categoria4_it];
$descrizione1 = $rigaeee[descrizione1_it];
$descrizione2 = $rigaeee[descrizione2_it];
$descrizione3 = $rigaeee[descrizione3_it];
$descrizione4 = $rigaeee[descrizione4_it];
break;
case "en":
$categoria1 = $rigaeee[categoria1_en];
$categoria2 = $rigaeee[categoria2_en];
$categoria3 = $rigaeee[categoria3_en];
$categoria4 = $rigaeee[categoria4_en];
$descrizione1 = $rigaeee[descrizione1_en];
$descrizione2 = $rigaeee[descrizione2_en];
$descrizione3 = $rigaeee[descrizione3_en];
$descrizione4 = $rigaeee[descrizione4_en];
break;
case "fr":
$descrizione = $rigaeee[descrizione_fr];
break;
case "de":
$descrizione = $rigaeee[descrizione_de];
break;
case "es":
$descrizione = $rigaeee[descrizione_es];
break;
}
$valvola_db = $rigaeee[id_valvola];
$cappellotto_db = $rigaeee[id_cappellotto];
$capacita_db = $rigaeee[categoria4_it];
$pescante_db = $rigaeee[id_pescante];
$colore_corpo_db = $rigaeee[corpo_colore_it];
$colore_ogiva_db = $rigaeee[ogiva_colore_it];
$materiale_corpo_db = $rigaeee[corpo_materiale_it];

}
include "traduzioni_interfaccia.php";
switch($lingua) {
case "it":
$titolo_scheda = "Scheda prodotto";
break;
case "en":
$titolo_scheda = "Product sheet";
break;
}

$sqlq = "SELECT DISTINCT categoria1_it FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
$num1 = mysql_num_rows($risultq);
if ($num1 > 1) {
while ($rigaq = mysql_fetch_array($risultq)) {
if ($rigaq[categoria1_it] == $categoria1_it) {
$blocco_cat1_it .= "<option selected value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_it])."</option>";
} else {
$blocco_cat1_it .= "<option value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_it])."</option>";
}
}
}
$sqlr = "SELECT DISTINCT categoria2_it FROM qui_prodotti_".$negozio." WHERE categoria1_it = '$categoria1_it' ORDER BY precedenza ASC";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
$num2 = mysql_num_rows($risultr);
if ($num2 > 1) {
while ($rigar = mysql_fetch_array($risultr)) {
if ($rigar[categoria2_it] == $categoria2_it) {
$blocco_cat2_it .= "<option selected value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_it])."</option>";
} else {
$blocco_cat2_it .= "<option value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_it])."</option>";
}
}
}
$ssls = "SELECT DISTINCT categoria3_it FROM qui_prodotti_".$negozio." WHERE categoria2_it = '$categoria2_it' ORDER BY precedenza ASC";
$risults = mysql_query($ssls) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
$num3 = mysql_num_rows($risults);
if ($num3 > 1) {
while ($rigas = mysql_fetch_array($risults)) {
if ($rigas[categoria3_it] == $categoria3_it) {
$blocco_cat3_it .= "<option selected value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_it])."</option>";
} else {
$blocco_cat3_it .= "<option value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_it])."</option>";
}
}
}
$stlt = "SELECT DISTINCT categoria4_it FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY precedenza ASC";
$risultt = mysql_query($stlt) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
$num4 = mysql_num_rows($risultt);
if ($num4 > 1) {
while ($rigat = mysql_fetch_array($risultt)) {
if ($rigat[categoria4_it] == $capacita_db) {
$blocco_cat4_it .= "<option selected value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_it])."</option>";
} else {
$blocco_cat4_it .= "<option value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_it])."</option>";
}
}
}





$sqlq = "SELECT DISTINCT categoria1_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
if ($num1 > 1) {
while ($rigaq = mysql_fetch_array($risultq)) {
if ($rigaq[categoria1_en] == $categoria1_it) {
$blocco_cat1_en .= "<option selected value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_en])."</option>";
} else {
$blocco_cat1_en .= "<option value=".$rigaq[categoria1_it].">".str_replace("_"," ",$rigaq[categoria1_en])."</option>";
}
}
}
$sqlr = "SELECT DISTINCT categoria2_en FROM qui_prodotti_".$negozio." WHERE categoria1_it = '$categoria1_it' ORDER BY precedenza ASC";
$risultr = mysql_query($sqlr) or die("Impossibile eseguire l'interrogazione2" . mysql_error());
if ($num2 > 1) {
while ($rigar = mysql_fetch_array($risultr)) {
if ($rigar[categoria2_it] == $categoria2_it) {
//if ($rigar[categoria2_en] == $categoria2_en) {
$blocco_cat2_en .= "<option selected value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_en])."</option>";
} else {
$blocco_cat2_en .= "<option value=".$rigar[categoria2_it].">".str_replace("_"," ",$rigar[categoria2_en])."</option>";
}
}
}
$ssls = "SELECT DISTINCT categoria3_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risults = mysql_query($ssls) or die("Impossibile eseguire l'interrogazione3" . mysql_error());
if ($num3 > 1) {
while ($rigas = mysql_fetch_array($risults)) {
if ($rigas[categoria3_it] == $categoria3_it) {
//if ($rigas[categoria3_en] == $categoria3_en) {
$blocco_cat3_en .= "<option selected value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_en])."</option>";
} else {
$blocco_cat3_en .= "<option value=".$rigas[categoria3_it].">".str_replace("_"," ",$rigas[categoria3_en])."</option>";
}
}
}
$stlt = "SELECT DISTINCT categoria4_en FROM qui_prodotti_".$negozio." ORDER BY precedenza ASC";
$risultt = mysql_query($stlt) or die("Impossibile eseguire l'interrogazione4" . mysql_error());
if ($num4 > 1) {
while ($rigat = mysql_fetch_array($risultt)) {
if ($rigat[categoria4_it] == $categoria4_it) {
//if ($rigat[categoria4_en] == $categoria4_en) {
$blocco_cat4_en .= "<option selected value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_en])."</option>";
} else {
$blocco_cat4_en .= "<option value=".$rigat[categoria4_it].">".str_replace("_"," ",$rigat[categoria4_en])."</option>";
}
}
}
$stlv = "SELECT * FROM qui_gruppo_merci ORDER BY gruppo_merce ASC";
$risultv = mysql_query($stlv) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigav = mysql_fetch_array($risultv)) {
if ($rigav[gruppo_merce] == $gruppo_merci) {
$blocco_gruppo_merci .= "<option selected value=".$rigav[gruppo_merce].">".$rigav[gruppo_merce]."</option>";
} else {
$blocco_gruppo_merci .= "<option value=".$rigav[gruppo_merce].">".$rigav[gruppo_merce]."</option>";
}
}


$stlv = "SELECT DISTINCT paese FROM qui_prodotti_".$negozio." ORDER BY paese ASC";
$risultv = mysql_query($stlv) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigav = mysql_fetch_array($risultv)) {
if ($rigav[paese] == $paese) {
$blocco_nazioni .= "<option selected value=".$rigav[paese].">".$rigav[paese]."</option>";
} else {
$blocco_nazioni .= "<option value=".$rigav[paese].">".$rigav[paese]."</option>";
}
}
$stlh = "SELECT DISTINCT categoria2_it FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY categoria2_it ASC";
$risulth = mysql_query($stlh) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigah = mysql_fetch_array($risulth)) {
if ($rigah[categoria2_it] == $categoria2_it) {
$blocco_mercati .= "<option selected value=".$rigah[categoria2_it].">".$rigah[categoria2_it]."</option>";
} else {
$blocco_mercati .= "<option value=".$rigah[categoria2_it].">".$rigah[categoria2_it]."</option>";
}
}
$stlk = "SELECT DISTINCT categoria3_it FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY categoria3_it ASC";
$risultk = mysql_query($stlk) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[categoria3_it] == $categoria3_it) {
$blocco_gas .= "<option selected value=".$rigak[categoria3_it].">".$rigak[categoria3_it]."</option>";
} else {
$blocco_gas .= "<option value=".$rigak[categoria3_it].">".$rigak[categoria3_it]."</option>";
}
}
$stlk = "SELECT DISTINCT categoria3_it FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY categoria3_it ASC";
$risultk = mysql_query($stlk) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[categoria3_it] == $categoria3_it) {
$blocco_gas .= "<option selected value=".$rigak[categoria3_it].">".$rigak[categoria3_it]."</option>";
} else {
$blocco_gas .= "<option value=".$rigak[categoria3_it].">".$rigak[categoria3_it]."</option>";
}
}
$stlk = "SELECT DISTINCT id_valvola FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY id_valvola ASC";
$risultk = mysql_query($stlk) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[id_valvola] != "") {
if ($rigak[id_valvola] == $valvola_db) {
$blocco_valvole .= "<option selected value=".$rigak[id_valvola].">".$rigak[id_valvola]."</option>";
} else {
$blocco_valvole .= "<option value=".$rigak[id_valvola].">".$rigak[id_valvola]."</option>";
}
}
}
$stlk = "SELECT DISTINCT id_cappellotto FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY id_cappellotto ASC";
$risultk = mysql_query($stlk) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[id_cappellotto] != "") {
if ($rigak[id_cappellotto] == $cappellotto_db) {
$blocco_cappellotti .= "<option selected value=".$rigak[id_cappellotto].">".$rigak[id_cappellotto]."</option>";
} else {
$blocco_cappellotti .= "<option value=".$rigak[id_cappellotto].">".$rigak[id_cappellotto]."</option>";
}
}
}
$stlk = "SELECT DISTINCT id_pescante FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY id_pescante ASC";
$risultk = mysql_query($stlk) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[id_pescante] != "") {
if ($rigak[id_pescante] == $pescante_db) {
$blocco_pescanti .= "<option selected value=".$rigak[id_pescante].">".$rigak[id_pescante]."</option>";
} else {
$blocco_pescanti .= "<option value=".$rigak[id_pescante].">".$rigak[id_pescante]."</option>";
}
}
}
$stlk = "SELECT DISTINCT corpo_colore_it FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY corpo_colore_it ASC";
$risultk = mysql_query($stlk) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[corpo_colore_it] != "") {
if ($rigak[corpo_colore_it] == $colore_corpo_db) {
$blocco_colori_corpo .= "<option selected value=".$rigak[corpo_colore_it].">".$rigak[corpo_colore_it]."</option>";
} else {
$blocco_colori_corpo .= "<option value=".$rigak[corpo_colore_it].">".$rigak[corpo_colore_it]."</option>";
}
}
}
$stlk = "SELECT DISTINCT ogiva_colore_it FROM qui_prodotti_".$negozio." WHERE categoria1_it = 'Bombole' ORDER BY ogiva_colore_it ASC";
$risultk = mysql_query($stlk) or die("Impossibile eseguire l'interrogazione5" . mysql_error());
while ($rigak = mysql_fetch_array($risultk)) {
if ($rigak[ogiva_colore_it] != "") {
if ($rigak[ogiva_colore_it] == $colore_ogiva_db) {
$blocco_colori_ogiva .= "<option selected value=".$rigak[ogiva_colore_it].">".$rigak[ogiva_colore_it]."</option>";
} else {
$blocco_colori_ogiva .= "<option value=".$rigak[ogiva_colore_it].">".$rigak[ogiva_colore_it]."</option>";
}
}
}
/*          <?php echo $blocco_materiali; ?>
            <?php echo $blocco_colori_corpo; ?>
            <?php echo $blocco_capacita; ?>
            <?php echo $blocco_colori_ogiva; ?>
            <?php echo $blocco_valvole; ?>
            <?php echo $blocco_cappellotti; ?>
            <?php echo $blocco_pescanti; ?>
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $titolo_scheda; ?></title>
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/modifica_scheda.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="tinybox2/styletiny_gallery.css" />
<style type="text/css">
<!--
.Stile1 {color: #FF0000}
.Stile2 {
	color: #33CCFF;
	font-weight: bold;
}
.Stile3 {
	color: #000000;
	font-weight: bold;
}
select {
    font: 12px Verdana, Arial, Helvetica, sans-serif;
    color: #000000;
    /*background: #CCCCCC;*/
    width: 170px;
    } -->
</style>

<script type="text/javascript" src="tinybox.js"></script>
</head>

<body>
<div id="wrap">
    <div id="lingua_scheda">
      
    </div><!--END LINGUA SCHEDA-->

    <div class="titolo_scheda_modifica">
      <?php
        switch ($negozio) {
        case "consumabili":
        $titolo = $tasto_consumabili;
        break;
        case "spare_parts":
        echo $spare_parts;
        break;
        case "assets":
        $titolo = $tasto_asset;
        break;
        }
        echo "<strong>".ucfirst($titolo)." - ".str_replace("_"," ",$categoria1)."</strong>";
        switch ($negozio) {
        case "consumabili":
        echo "<br>".$descrizione1;
        break;
        case "spare_parts":
        echo "<br>".$descrizione1;
        break;
        case "assets":
        if ($categoria2 != "") {
        echo "<br>".str_replace("_"," ",$categoria2);
        }
        if ($categoria3 != "") {
        echo " - ".str_replace("_"," ",$categoria3);
        }
        if ($categoria4 != "") {
        echo " - ".str_replace("_"," ",$categoria4);
        }
        break;
        }
      ?>
    </div><!--END TITOLO_SCHEDA-->

    <!--INIZIO DEL FORM-->
 
<form action="popup_scheda.php" method="post" enctype="multipart/form-data" name="form1">

  <div class="strip">
    <div class="colonna ita">
      <div class="selezione">
        Categoria 1 <span class="voce"><?php echo str_replace("_"," ",$categoria1_it); ?></span>
      </div><!--END SELEZIONE-->

      <?php
        if ($categoria1 != "") {
          if ($num2 > 1) {
            echo '<div class="selezione">';
            echo 'Categoria 2 <span class="voce">'.str_replace("_"," ",$categoria2_it).'</span>';
            echo '</div>';
          }
        }
      ?>

      <?php
        if ($categoria2 != "") {
          if ($num3 > 1) {
            echo '<div class="selezione">';
            echo 'Categoria 3 <span class="voce">'.str_replace("_"," ",$categoria3_it).'</span>';
            echo '</div>';
          }
        }
      ?>

        <?php
        if ($categoria3 != "") {
          if ($num4 > 1) {
            echo '<div class="selezione">';
            echo 'Categoria 2 <span class="voce">'.str_replace("_"," ",$categoria4_it).'</span>';
            echo '</div>';
          }
        }
        ?>
      </div><!--END COL ITA-->

      <div class="colonna eng">
        <div class="selezione">
        Category 1 <span class="voce"><?php echo str_replace("_"," ",$categoria1_en); ?></span>
      </div><!--END SELEZIONE-->

      <?php
        if ($categoria1 != "") {
          if ($num2 > 1) {
            echo '<div class="selezione">';
            echo 'Category 2 <span class="voce">'.str_replace("_"," ",$categoria2_en).'</span>';
            echo '</div>';
          }
        }
      ?>

      <?php
        if ($categoria2 != "") {
          if ($num3 > 1) {
            echo '<div class="selezione">';
            echo 'Category 3 <span class="voce">'.str_replace("_"," ",$categoria3_en).'</span>';
            echo '</div>';
          }
        }
      ?>

        <?php
        if ($categoria3 != "") {
          if ($num4 > 1) {
            echo '<div class="selezione">';
            echo 'Category 2 <span class="voce">'.str_replace("_"," ",$categoria4_en).'</span>';
            echo '</div>';
          }
        }
        ?>
      </div><!--END COL ENG-->
    </div> <!--END STRIP-->




    <div class="strip grigia">
      <div class="colonna ita">
        <div class="selezione">
          Codice/Code <strong><span class="menu_markets"><?php echo $codice_art; ?></span></strong>
        </div><!--END SELEZIONE-->
        <div class="selezione">
          Prezzo/Price <input name="prezzo" type="text" class="menu_markets" id="prezzo" value="<?php echo $prezzo; ?>" size="25">
        </div><!--END SELEZIONE-->
        <div class="selezione">
              <?php
			  //echo $gruppo_merci;
        switch ($negozio) {
        case "consumabili":
        echo "Gruppo merci/Goods group <select name=gruppo_merci class=menu_markets id=gruppo_merci>".$blocco_gruppo_merci."</select>";
        break;
        case "spare_parts":
        echo "Gruppo merci/Goods group <select name=gruppo_merci class=menu_markets id=gruppo_merci>".$blocco_gruppo_merci."</select>";
        break;
        case "assets":
        echo "WBS <input name=wbs type=text class=menu_markets id=wbs size=8 value=".$wbs.">";
        break;
        }
?>
        </div><!--END SELEZIONE-->
        <div class="selezione">
        Confezione/Package <input name="confezione" type="text" class="menu_markets" id="confezione" size="25" value="<?php echo $confezione; ?>">
        </div><!--END SELEZIONE-->
      </div><!--END COLONNA ITA-->
      <div class="colonna eng">
        <div class="upload_img">
  <a href="javascript:void(0);" onclick="TINY.box.show({iframe:'gestione_immagine_princ.php?id_prod=<?php echo $id; ?>&negozio_prod=<?php echo $negozio; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:600,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"><span class=Stile2><?php echo $main_image; ?></span></a>
        </div><!--END UPLOAD IMAGE-->
        <div class="upload_img"><br />
  <a href="javascript:void(0);" onclick="TINY.box.show({iframe:'gestione_gallery.php?id_prod=<?php echo $id; ?>&negozio_prod=<?php echo $negozio; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:600,height:400,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"><span class=Stile2><?php echo $gallery; ?></span></a>
        </div><!--END UPLOAD IMAGE-->
      </div><!--END COLONNA ENG-->
    </div><!--END STRIP GRIGIA-->


    <div class="strip">
      <div class="colonna ita">
        <div class="tit_strip">Caratteristiche generali</div> <!--END TIT STRIP-->
        <div class="tendine_bombole">
          Nazione
          <select name="materiale_corpo" id="materiale_corpo">
            <?php echo $blocco_nazioni; ?>
          </select></div>
        <!--END TENDINA NAZIONI-->
        <div class="tendine_bombole">
          Mercato
          <select name="materiale_corpo" id="materiale_corpo">
            <?php echo $blocco_mercati; ?>
          </select></div>
        <!--END TENDINA MERCATI-->
        <div class="tendine_bombole">
          Gas  
          <select name="materiale_corpo" id="materiale_corpo">
            <?php echo $blocco_gas; ?>
          </select></div>
        <!--END TENDINA GAS-->
        <div class="tendine_bombole"></div>
        <div class="tit_strip">Corpo bombola</div>
        <div class="tendine_bombole">Materiale corpo
          <select name="materiale_corpo" id="materiale_corpo">
            <?php
			switch ($materiale_corpo_db) {
			case "":
			echo "<option selected value=>Scegli</option>";
			echo "<option value=Acciaio>Acciaio</option>";
            echo "<option value=Alluminio>Alluminio</option>";
			break;
			case "Acciaio":
			echo "<option value=>Scegli</option>";
			echo "<option selected value=Acciaio>Acciaio</option>";
            echo "<option value=Alluminio>Alluminio</option>";
			break;
			case "Alluminio":
			echo "<option value=>Scegli</option>";
			echo "<option value=Acciaio>Acciaio</option>";
            echo "<option selected value=Alluminio>Alluminio</option>";
			break;
			}
			?>
          </select>
        </div>
        <!--END TENDINA MATERIALI-->
        <div class="tendine_bombole">
          Colore corpo
            <select name="colore_corpo" id="colore_corpo">
            <?php echo $blocco_colori_corpo; ?>
            </select> 
        </div>
        <!--END TENDINA COLORI CORPO-->
        <div class="tendine_bombole">
          Capacità 
            <select name="capacita" id="capacita">
            <?php echo $blocco_cat4_it; ?>
            </select> 
        </div>
        <!--END TENDINA CAPACITA'-->
        <div class="tendine_bombole">
          Colore ogiva
          <select name="colore_ogiva" id="colore_ogiva">
            <?php echo $blocco_colori_ogiva; ?>
          </select> 
        </div>
        <!--END TENDINA COLORI OGIVA-->
      </div>
      
      <!--END COLONNA ITA-->
      
      <div class="colonna eng">
      <div class="tit_strip"></div>
      <div class="tit_strip_nobottommargin"></div> 
      
      <!--END TIT STRIP-->
        <div class="tendine_bombole"></div>
        <!--END TENDINA MATERIALI-->
        <div class="tendine_bombole"></div>
        <!--END TENDINA COLORI CORPO-->
        <div class="tendine_bombole"></div>
        <div class="tendine_bombole"></div>
        <!--END TENDINA CAPACITA'-->
        <div class="tit_strip">Componenti  bombola</div> 
      <!--END TIT STRIP-->
        <div class="tendine_bombole">Valvola
          <select name="valvola" id="valvola">
            <?php echo $blocco_valvole; ?>
          </select>
        </div>
        <!--END TENDINA VALVOLE-->
        <div class="tendine_bombole">
          Cappellotto
            <select name="cappellotto" id="cappellotto">
            <?php echo $blocco_cappellotti; ?>
          </select> 
        </div>
        <!--END TENDINA CAPPELLOTTI-->
        <div class="tendine_bombole">
          Pescante 
            <select name="pescante" id="pescante">
            <?php echo $blocco_pescanti; ?>
          </select> 
        </div>
        <!--END TENDINA PESCANTI-->
      </div>
      
      <!--END COLONNA ENG-->
    </div>
    <!--END STRIP-->
    <!--END STRIP GRIGIA-->

    <div class="strip">
      <div class="buttons">
        <input name="indietro" type="button" class="tabellegrandecentro" onClick="history.go(-2)" value="<?php echo $back; ?>" id="indietro">
        <input type="submit" name="button" id="button" value="<?php echo $salva; ?>">
        <input name="id" type="hidden" value="<?php echo $id; ?>">
        <input name="codice" type="hidden" value="<?php echo $codice_art; ?>">
        <input name="modifica_prodotto" type="hidden" value="1">
        <input name="negozio" type="hidden" value="<?php echo $negozio; ?>">
        <input name="lang" type="hidden" value="<?php echo $lingua; ?>">

      
      </div><!--END BUTTONS-->
    </div><!--END STRIP-->

  </form>
</div><!--END WRAP-->
</body>
</html>
