<?php
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

$elimina_immagine = $_GET[elimina_immagine];
$codice_mod = $_GET[codice];
$conferma_modifiche = $_POST[conferma_modifiche];
$immagine1 = $_POST[immagine1];
include "query.php";
include "traduzioni_interfaccia.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$sqleee = "SELECT * FROM qui_prodotti_".$negozio_prod." WHERE id = '$id_prod'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
$codice_art = $rigaeee[codice_art];
}
if ($elimina_immagine != "") {
$querya = "UPDATE qui_prodotti_".$negozio_prod." SET foto = '' WHERE id = '$id_prod'";
if (mysql_query($querya)) {
} else {
echo "Errore durante l'inserimento1: ".mysql_error();
}
}
if ($conferma_modifiche != "") {
include "elaborazione_immagine_princ.php";
}
/*echo "id: ".$id_prod."<br>";
echo "negozio_prod: ".$negozio_prod."<br>";
echo "codice_art: ".$codice_art."<br>";
echo "conferma_modifiche: ".$conferma_modifiche."<br>";
echo "immagine2: ".$immagine2."<br>";
echo "array files: ";
print_r($_FILES);
echo "<br>";
*/
$sqlz = "SELECT * FROM qui_prodotti_".$negozio_prod." WHERE id = '$id_prod'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_img = mysql_num_rows($risultz);
while ($rigaz = mysql_fetch_array($risultz)) {
$image1 = $rigaz[foto];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
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
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="gestione_immagine_princ.php" enctype="multipart/form-data">
<table width="432" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td colspan="4">
    <span class="Stile2"><?php echo $titolo_gestione_img_princ; ?></span><br />
    <img src=immagini/spacer.gif width=5 height=20 /><br />
  <span class="Stile3"><?php echo $dim_predefinita_img_princ; ?></span><br />
  <span class="Stile4"><a href="http://www.ipiccy.com" target="_blank">Photo edit</a></span><br />
  <span class="Stile3"><?php echo $dida_ipiccy; ?></span><br />
  <img src=immagini/spacer.gif width=5 height=20 />  </td>
  </tr>
<tr>
  <td class="Stile4">
    <!--<div align="right">
      <input name="photoediting" type="button" class="Stile4" id="photoediting" onClick="MM_goToURL('blank','http://www.ipiccy.com');return document.MM_returnValue" value="Photo edit">
      </div>--></td>
  <td></td>
  <td class="Stile3" colspan="2"></td>
  </tr>
<tr>
  <td colspan="4"><img src=immagini/riga_prev_GREY.jpg width=432 height=1></td>
  </tr>
<tr>
              <td width="221">
                <input name="immagine1" type="file" id="immagine1" size="15" />
              </td>
              <td width="13"><img src="immagini/spacer.gif" width="5" height="40" /></td>
              <td width="104"><div align="center"><?php
		  if ($image1 != "") {
		  echo "<img src=files/".$image1." width=30 height=30>";
		  } else {
		  echo "<img src=immagini/spacer.gif width=30 height=30>";
		  }
		  ?>
              </div></td>
              <td width="111"><div align="right">
                <?php
		  if ($image1 != "") {
echo "<a href=gestione_immagine_princ.php?elimina_immagine=1&id_prod=".$id_prod."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."&negozio_prod=".$negozio_prod."><img src=immagini/btn_rimuovi.png width=19 height=19 border=0 title=".$elimina_image_gallery."></a>";
		  }
		  ?>              
              </div></td>
            </tr>
<tr>
  <td colspan="4"><img src=immagini/riga_prev_GREY.jpg width=432 height=1></td>
  </tr>

<tr>
  <td colspan="4"><img src=immagini/riga_prev_GREY.jpg width=432 height=1></td>
  </tr>
            <tr>
              <td colspan="4"><div align="center">
                <p><br />
                  <input type="submit" name="button" id="button" value="<?php echo $salva_gestione_gallery; ?>" />
                  <input name="negozio_prod" type="hidden" id="negozio_prod" value="<?php echo $negozio_prod; ?>" />
                  <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>" />
                  <input name="conferma_modifiche" type="hidden" id="conferma_modifiche" value="1" />
                  <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>" />
                </p>
                </div></td>
            </tr>
          </table>
</form>

</body>
</html>
