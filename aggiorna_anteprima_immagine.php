<?php
session_start();
$id = $_GET[id];
$negozio = $_GET[shop];
$tipo_immagine = $_GET[tipo_immagine];

include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

$testoQuery = "SELECT * FROM qui_prodotti_".$negozio." WHERE id = '$id'";
$result = mysql_query($testoQuery);
while ($row = mysql_fetch_array($result)) {
$codice_art = $row[codice_art];
if ($row[foto_sost] != "") {
  $immagine = $row[foto_sost];
} else {
  $immagine = $row[foto];
}
//fine while
}
	  if ($_SESSION[cod_temp] != "") {
		  $codice_art = $_SESSION[cod_temp];
	  }
switch ($tipo_immagine) {
case "1":
  $div_image .= "<img src=files/".$immagine." width=248 height=248>";
break;
case "2":
	  //$div_image .= "Immagini (principale e galleria fotografica)";
	  //$div_image .= "<input name=immagine_princ type=hidden id=immagine_princ value=".$immagine.">";
  $sqlp = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' ORDER BY precedenza ASC";
  $risultp = mysql_query($sqlp) or die("Impossibile eseguire l'interrogazione6" . mysql_error());
  $num_image_gallery = mysql_num_rows($risultp);
  if ($num_image_gallery > 0) {
	while ($rigap = mysql_fetch_array($risultp)) {
	  $div_image .= "<img src=files/gallery/".$rigap[immagine]." width=30 height=30>";
	  $div_image .= "<img src=immagini/spacer.gif width=10 height=30>";
	}
  }
break;
case "3":
  $nome_gruppo = mt_rand(1000,9999);
  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' ORDER BY precedenza ASC";
  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_img = mysql_num_rows($risultz);
  if ($num_img > 0) {
	$a = 1;
	while ($rigaz = mysql_fetch_array($risultz)) {
	  if ($a == 1) {
		$div_image .= "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]><span class=pulsante_galleria>Galleria fotografica</span></a> ";
	  } else {
		$div_image .= "<a href=files/gallery/".$rigaz[immagine]." rel=lightbox[".$nome_gruppo."]></a> ";
	  }
	  $a = $a + 1;
	}
  }
break;
case "4":
  $div_image .= "<img src=files/".$immagine." width=30 height=30>";
  $div_image .= "<input name=immagine_princ type=hidden id=immagine_princ value=".$immagine.">";
break;
}
	//output finale
	echo $div_image;
?>
