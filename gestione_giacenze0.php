<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
session_start();
$_SESSION[pagina] = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION[lang])) {
$_SESSION[lang] = "it";
}
if ((isset($_POST[mod_lang])) AND ($_POST[lang] != "")) {
$_SESSION[lang] = $_POST[lang];
}
if ((isset($_GET[mod_lang])) AND ($_GET[lang] != "")) {
$_SESSION[lang] = $_GET[lang];
}
$lingua = $_SESSION[lang];
//echo "lingua: ".$lingua."<br>";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
include "traduzioni_interfaccia.php";
$azione_form = $_SERVER['PHP_SELF'];
$file_presente = basename($azione_form);
$_SESSION[file_ritorno] = $file_presente;


if ($_GET[aggiorna] != "") {
$aggiorna = $_GET[aggiorna];
} else {
$aggiorna = $_POST[aggiorna];
}
if ($_GET[codice_art] != "") {
$codice_art = $_GET[codice_art];
} else {
$codice_art = $_POST[codice_art];
}
if ($_GET[negozio] != "") {
$negozio = $_GET[negozio];
} else {
$negozio = $_POST[negozio];
}
if ($_GET[quant] != "") {
$quant = $_GET[quant];
} else {
$quant = $_POST[quant];
}

if ($aggiorna == 1) {
$queryt = "SELECT * FROM qui_prodotti_".$negozio." WHERE codice_art = '$codice_art'";
    $risultt = mysql_query($queryt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
    while ($rigat = mysql_fetch_array($risultt)) {
	  $a_scaffale = $rigat[giacenza];
	  $id_prod = $rigat[id];
	}
	$nuovo_dato_giacenza = $a_scaffale + $quant;
	$querys = "UPDATE qui_prodotti_".$negozio." SET giacenza = '$nuovo_dato_giacenza' WHERE codice_art = '$codice_art'";
if (mysql_query($querys)) {
$avviso = "giacenza prodotto modificata correttamente";
$_SESSION[quant] = $nuovo_dato_giacenza;
} else {
$avviso = "Errore durante l'inserimento: ".mysql_error();
$_SESSION[quant] = "";
}

}

///////////////////////////////////////////////
//INIZIO COSTRUZIONE QUERY
///////////////////////////////////////////////
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
case "labels":
$testoQuery = "SELECT * FROM qui_prodotti_labels ";
break;
case "vivistore":
$testoQuery = "SELECT * FROM qui_prodotti_vivistore ";
break;
}
$testoQuery .= "WHERE codice_art = '$codice_art'";
    $risultx = mysql_query($testoQuery) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
    while ($rigax = mysql_fetch_array($risultx)) {
	  $descrizione = stripslashes($rigax[descrizione1_it]);
	  $giacenza = $rigax[giacenza];
	}

///////////////////////////////////////////////
//FINE COSTRUZIONE QUERY
///////////////////////////////////////////////
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Quice - Prodotti</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/visual.css" />
<link href="css/lightbox3.css" rel="stylesheet" />
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<style type="text/css">
<!--
#main_container {
	width:940px;
	margin: 10px auto;
	margin-top: ;
	height: 250px;
	font-family:Arial;
/*	background-color: #CCCCCC;
*/
}
.colonnine {
	width:22%;
	margin-right: 1%;
	min-height: 25px;
	overflow:hidden;
	height:auto;
	float:left;
}
-->
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox3.js"></script>
<SCRIPT type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</SCRIPT>
</head>
<body>
<div id="main_container">
  <div style="width: 920px; height: auto; padding:20px 10px; border-bottom: 1px solid #999; font-size:18px; font-weight:bold;">
  Gestione scorte di magazzino
  </div>
  <div style="width: 920px; height: auto; padding:10px 10px; border-bottom: 1px solid #999; font-size:16px; font-weight:normal;">
  <?php
  echo 'Cod. '.$codice_art.' - '.$descrizione;

  ?>
  </div>
  <div style="width: 920px; min-height: 30px; overflow:hidden; height: auto; padding:5px 10px; border-bottom: 1px solid #999; font-size:12px; font-weight:bold;">
    <div class="colonnine">
      A scaffale
    </div>
    <div class="colonnine">
      Ordinati(3)
    </div>
    <div class="colonnine">
      In approvazione (1-2)
    </div>
    <div class="colonnine">
      Venduti
    </div>
  </div>
  <div style="width: 920px; min-height: 30px; overflow:hidden; height: auto; padding:5px 10px; border-bottom: 1px solid #999; font-size:12px; font-weight:normal;">
    <div class="colonnine">
      <?php
	  echo $giacenza;
	  ?>
    </div>
    <div class="colonnine">
      <?php
		$queryb = "SELECT SUM(quant) as somma_inordineOK FROM qui_righe_rda WHERE negozio = '".$negozio."' AND codice_art = '".$codice_art."' AND stato_ordine = '3'";
		$resultb = mysql_query($queryb);
		list($somma_inordineOK) = mysql_fetch_array($resultb);
		echo intval($somma_inordineOK);
		//fine div ordinati stato 3
	  ?>
    </div>
    <div class="colonnine">
      <?php
		$queryc = "SELECT SUM(quant) as somma_inordine FROM qui_righe_rda WHERE negozio = '".$negozio."' AND codice_art = '".$codice_art."' AND (stato_ordine = '1' OR stato_ordine = '2')";
		$resultc = mysql_query($queryc);
		list($somma_inordine) = mysql_fetch_array($resultc);
		echo intval($somma_inordine);
		//fine div ordinati stato 1 e 2
	  ?>
    </div>
    <div class="colonnine">
      <?php
		$queryd = "SELECT SUM(quant) as somma_evase FROM qui_righe_rda WHERE negozio = '".$negozio."' AND codice_art = '".$codice_art."' AND stato_ordine = '4'";
		$resultd = mysql_query($queryd);
		list($somma_evase) = mysql_fetch_array($resultd);
		echo intval($somma_evase);
	  ?>
    </div>
  </div>
  <div style="width: 920px; min-height: 40px; overflow:hidden; height: auto; padding:15px 10px; font-size:12px; font-weight:normal;">
  <form id="go_giacenze" name="go_giacenze" method="get" action="<?php echo $azione_form; ?>">
    <div class="colonnine" style="width: 160px;">
      Articoli da caricare
    </div>
    <div class="colonnine">
      <input style="width:50px; height:20px; text-align:center;" name="quant" type="text" id="quant">
      <input name="aggiorna" type="hidden" id="aggiorna" value="1">
      <input name="codice_art" type="hidden" id="codice_art" value="<?php echo $codice_art; ?>">
      <input name="negozio" type="hidden" id="negozio" value="<?php echo $negozio; ?>">
    </div>
    <div class="colonnine" style="width: 100px;">
      <a href="javascript:void(0);" onclick="go_giacenze.submit()">
        <div style="text-decoration:none; width: 70px; padding: 5px 0px; background-color:#0C0; text-align:center;">
          <span style="color:#fff; font-size:18px; font-family:Arial;">
            Carica
          </span>
        </div>
      </a>
    </div>
    <div class="colonnine" style="color:red; font-size:16px; width:240px;">
    <?php echo $avviso; ?>
    </div>
  </form>
  </div>
  <div id="colonna_opzioni" style="width: 920px min-height: 40px; overflow:hidden; height: auto; padding:15px 10px; font-size:12px; font-weight:normal;">
    <div class="colonnine" style="width: 100px; float:left; margin:10px 0px 0px 0px; text-align:left;">Gestione scorta</div>
     <div id="check_gestione" class="caselle <?php
     if ($gestione_scorta == "1") {
         echo "caselle_spuntate";
     } else {
         echo "caselle_vuote";
     }
     ?>" style="float: left; margin-top:10px;" onclick="solviv(this.id)">
    </div>
    <div class="colonnine" style="width: 100px; float:left; margin:10px 0px 0px 10px; text-align:left;">Quantit&agrave;<br />minima</div>
    <div id="campo_soglia" style="width:70px; float:left; margin-top:10px;">
    <?php
    switch ($gestione_scorta) {
        case 0:
          echo '<input name="soglia" type="text" id="soglia" class="campo_norm" disabled="disabled" onkeypress = "return ctrl_solo_num_neg(event)" value="'.$soglia.'">';
        break;
        case 1:
          echo '<input name="soglia" type="text" id="soglia" class="campo_norm" onkeypress = "return ctrl_solo_num_neg(event)" value="'.$soglia.'">';
        break;
    }
    ?>
       <input name="gestione_scorta" type="hidden" id="gestione_scorta" value="<?php echo $gestione_scorta; ?>">
    </div>
     <div class="bottone_carica-cambia" style="margin-top:10px; margin-left:20px; width:80px; float:left;" onClick="carico_magazzino2(2);">Salva</div>
      <div id="avviso_gestione" style="width:220px; float:left; margin:10px 0px 0px 10px; text-align:left; color:red; font-weight:bold; font-size: 16px;"></div>
  </div>
</div>

</div>

<script type="text/javascript">
function compilazione_pharma(id,riga){
						/*alert('#dati_'+riga);*/
				$.ajax({
						type: "GET",   
						url: "aggiorna_dati_pharma.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#dati_'+riga).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_bottoni_pharma.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#componente_bottoni_'+riga).html(output).show();
						}
						});

				$.ajax({
						type: "GET",   
						url: "aggiorna_variante_pharma.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#variante_'+riga).html(output).show();
						}
						});
				$.ajax({
						type: "GET",   
						url: "aggiorna_descr_pharma.php",   
						data: "id="+id+"&negozio="+"<?php echo $negozio; ?>"+"&lang="+"<?php echo $lingua; ?>",
						success: function(output) {
						$('#descrpharma_'+riga).html(output).show();
						}
						});
}

</SCRIPT>
</body>
</html>
