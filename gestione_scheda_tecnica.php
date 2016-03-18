<?php
if ($_GET[mode] != "") {
$mode = $_GET[mode];
} else {
$mode = $_POST[mode];
}
if ($_GET[id_prod] != "") {
$id_prod = $_GET[id_prod];
} else {
$id_prod = $_POST[id_prod];
}
if ($_GET[negozio_prod] != "") {
$negozio_prod = $_GET[negozio_prod];
} else {
$negozio_prod = $_POST[negozio_prod];
}
if ($_GET[lang] != "") {
$lingua = $_GET[lang];
} else {
$lingua = $_POST[lang];
}
//echo "<span style=\"color:rgb(0,0,0);\">".$id_prod."<br>";
$elimina_immagine = $_GET[elimina_immagine];
$conferma_elimina = $_GET[conferma_elimina];
$codice_mod = $_GET[codice];
$conferma_modifiche = $_POST[conferma_modifiche];
$scheda = $_POST[scheda];
include "query.php";
include "traduzioni_interfaccia.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
if ($elimina_immagine != "") {
	echo "<div style=\"width:360px; height:auto; padding-top:60px; margin:auto; \">
			<div style=\"width=100%; height:auto; text-align:center; font-family: Arial; color: green; font-size: 16px; font-weight: bold; margin-bottom:20px;\">
			  Vuoi davvero eliminare definitivamente<br>la scheda tecnica attualmente inserita nel prodotto?
			</div>
			<div style=\"width:50%; height:70px; float:left; padding-top:20px; text-decoration:none;\">
			  <a href=gestione_scheda_tecnica.php?id_prod=".$id_prod."&negozio_prod=".$negozio_prod."&lang=".$lingua."&conferma_elimina=1>
				<div style=\"width:70px; height:auto; margin:auto; padding:10px 0px 10px 0px; font-family:Arial; font-weight:bold; color:white; background-color:green; font-size:18px; text-align:center; border:2px solid green;\">
				  OK
				</div>
			  </a>
			</div>
			<div style=\"width:50%; height:70px; float:left; padding-top:20px; text-decoration:none;\">
			  <a href=gestione_scheda_tecnica.php?id_prod=".$id_prod."&negozio_prod=".$negozio_prod."&lang=".$lingua.">
				<div style=\"width:70px; height:auto; margin:auto; padding:10px 0px 10px 0px; font-family:Arial; font-weight:bold; color:green; background-color:white; font-size:18px; text-align:center; border:2px solid green;\">
				  NO
				</div>
			  </a>
			</div>
		  </div>";
	exit;
}
if ($conferma_elimina != "") {
$querya = "UPDATE qui_prodotti_".$negozio_prod." SET percorso_pdf = '' WHERE id = '$id_prod'";
if (mysql_query($querya)) {
} else {
echo "Errore durante l'inserimento1: ".mysql_error();
}
}
if ($conferma_modifiche != "") {
if ($_FILES['scheda']['name'] != "") {
	include "elaborazione_scheda_tecnica.php";
}
}
$sqlz = "SELECT * FROM qui_prodotti_".$negozio_prod." WHERE id = '$id_prod'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_img = mysql_num_rows($risultz);
while ($rigaz = mysql_fetch_array($risultz)) {
	if ($rigaz[filepath] != "") {
	  if ($rigaz[filepath] == "eliminare") {
	  $scheda = "";
	  } else {
	  $scheda = $rigaz[filepath];
	  }
	} else {
	  $scheda = $rigaz[percorso_pdf];
	}
}
/*
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
  <link href="css/modifica_scheda.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Stile1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
}
.Stile2 {
	font-family: Arial, Helvetica, sans-serif;
	color: #33CCFF;
	font-weight: bold;
}
.Stile3 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
.Stile4 {
	font-family: Arial, Helvetica, sans-serif;
	color: #FF9900;
	font-weight: bold;
	font-size: 14px;
}
.bottoni_notifiche {
	width:70px;
	height: 40px;
	margin: auto;
	margin-top: 10px;
	padding: 5px;
	font-family: Arial;
	font-weight: bold;
	color: white;
	background-color:green;
	font-size: 18px;
	text-align: center;
	border:2px solid green;
}
.bottoni_notifiche_neg {
	width:70px;
	height: 40px;
	margin: auto;
	margin-top: 10px;
	padding: 5px;
	font-family: Arial;
	font-weight: bold;
	color: green;
	background-color:white;
	font-size: 18px;
	text-align: center;
	border:2px solid green;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="gestione_scheda_tecnica.php" enctype="multipart/form-data">
<table width="432" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td colspan="5">
    <span class="Stile2">Carica la scheda tecnica dal tuo computer</span><br />
    <img src=immagini/spacer.gif width=5 height=20 /><br />
  <span class="Stile3">Il file della scheda tecnica che inserisci<br />
  può essere solo in formato pdf</span><br />
  <img src=immagini/spacer.gif width=5 height=20 />  </td>
</tr>
<tr>
              <td width="209" bgcolor="#FFFF99">
                <input name="scheda" type="file" id="scheda" size="15" />
              </td>
              <td width="14" bgcolor="#FFFF99"><img src="immagini/spacer.gif" width="5" height="40" /></td>
      <td width="104" bgcolor="#FFFF99"><?php if ($scheda != "") {
		  echo $scheda;
		  }
		  ?>
      </td>
      <td width="105" bgcolor="#FFFF99"><?php
		  if ($scheda != "") {
echo "<a href=gestione_scheda_tecnica.php?elimina_immagine=1&id_prod=".$id_prod."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."&negozio_prod=".$negozio_prod."><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=".$elimina_image_gallery."></a>";
		  }
		  ?></td>
    </tr>
<tr>
  <td colspan="5"><img src=immagini/riga_prev_GREY.jpg width=432 height=1></td>
  </tr>
<tr>
  <td colspan="5"><img src=immagini/riga_prev_GREY.jpg width=432 height=1></td>
  </tr>
            <tr>
              <td colspan="5"><div align="center">
                <br />
                <!--<input type="button" name="button2" id="button2" onclick="window.close();" value="Esci" />--> 
               <input class="bottone_carica-cambia" style="height:28px !important;" type="submit" name="button" id="button" value="Carica scheda" >
                <input name="negozio_prod" type="hidden" id="negozio_prod" value="<?php echo $negozio_prod; ?>" />
                <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>" />
                <input name="conferma_modifiche" type="hidden" id="conferma_modifiche" value="1" />
                <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>" />
                
              </div></td>
            </tr>
          </table>
</form>

</body>
</html>
