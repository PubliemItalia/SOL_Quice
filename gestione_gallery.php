<?php
session_start();
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
if ($_GET[mode] != "") {
$mode = $_GET[mode];
} else {
$mode = $_POST[mode];
}

$elimina_immagine = $_GET[elimina_immagine];
$codice_mod = $_GET[codice];
$conferma_modifiche = $_POST[conferma_modifiche];
$immagine1 = $_POST[immagine1];
$immagine2 = $_POST[immagine2];
$immagine3 = $_POST[immagine3];
$immagine4 = $_POST[immagine4];
include "query.php";
include "traduzioni_interfaccia.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$sqleee = "SELECT * FROM qui_prodotti_".$negozio_prod." WHERE id = '$id_prod'";
$risulteee = mysql_query($sqleee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigaeee = mysql_fetch_array($risulteee)) {
$codice_art = $rigaeee[codice_art];
}
if ($elimina_immagine != "") {
$sql = "DELETE FROM qui_gallery WHERE id_prodotto = '$codice_art' AND precedenza = '$elimina_immagine'";
$risultato = mysql_query($sql) or die("Impossibile eseguire l'interrogazione");
}
if ($conferma_modifiche != "") {
	if ($mode == "ins") {
	$part1 = mt_rand(1000,4999);
	$part2 = mt_rand(5000,9999);
	$cod_temp = $part1."-".$part2;
	$_SESSION[cod_temp] = $cod_temp;
	}
if ($_FILES['immagine1']['name'] != "") {
	include "elaborazione_immagine_princ.php";
}
if (($_FILES['immagine2']['name'] != "") OR ($_FILES['immagine3']['name'] != "") OR ($_FILES['immagine4']['name'] != "")) {
	//SOLO PER LA GALLERY
	include "elaborazione_immagini.php";
}
}
$sqlz = "SELECT * FROM qui_prodotti_".$negozio_prod." WHERE id = '$id_prod'";
$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_img = mysql_num_rows($risultz);
while ($rigaz = mysql_fetch_array($risultz)) {
	if ($rigaz[foto_sost] != "") {
		$foto_temp = 1;
$image1 = $rigaz[foto_sost];
	} else {
$image1 = $rigaz[foto];
	}
}
if ($mode == "ins") {
	$codice_art = $_SESSION[cod_temp];
}
  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' AND precedenza = '2'";
  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_img = mysql_num_rows($risultz);
  while ($rigaz = mysql_fetch_array($risultz)) {
  $image_gallery2 = $rigaz[immagine];
  }
  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' AND precedenza = '3'";
  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_img = mysql_num_rows($risultz);
  while ($rigaz = mysql_fetch_array($risultz)) {
  $image_gallery3 = $rigaz[immagine];
  }
  $sqlz = "SELECT * FROM qui_gallery WHERE id_prodotto = '$codice_art' AND precedenza = '4'";
  $risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $num_img = mysql_num_rows($risultz);
  while ($rigaz = mysql_fetch_array($risultz)) {
  $image_gallery4 = $rigaz[immagine];
  }
/*echo "id: ".$id_prod."<br>";
echo "negozio_prod: ".$negozio_prod."<br>";
echo "codice_art: ".$codice_art."<br>";
echo "conferma_modifiche: ".$conferma_modifiche."<br>";
echo "immagine1: ".$immagine1."<br>";
echo "immagine2: ".$immagine2."<br>";
echo "array files: ";
print_r($_FILES);
echo "<br>";
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
<style type="text/css">
<!--
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #EDEDED;
	color:rgb(0,0,0);
	text-align:center;
}
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
.stripN {
	width:100%;
	min-height:40px;
	overflow: hidden; 
	height:auto; 
	float:left; 
	font-size:11px;
	margin-top:30px;
}
.diciture_pag_modifica {
	 font-family:Arial;
	 font-weight:normal; 
	font-size:14px;
	width:100%;
	text-align:left;
}
.bottone_carica-cambia {
	cursor:pointer;
	color:#5e5e5e; 
	font-size: 15px;
	width:120px; 
	height:19px;
	padding-top: 3px; 
	float:none; 
	margin: auto;
	margin-top:20px;
	border: 2px solid #ebebeb;
	background-color: #dddddd;
	text-align:center;
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px; 
	border-radius: 5px; 
}
.bottone_carica-cambia:hover {
	border: 2px solid #3fa9f5;
	background-color: #d4efff;
	text-align:center;
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px; 
	border-radius: 5px; 
}
.bottone_servizio-esterno {
	color:#fff; 
	width:100px; 
	height:30px; 
	font-family: Arial;
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px; 
	border-radius: 5px; 
}
.bottone_servizio-icona {
	width:auto;
	height:auto; 
	float:left; 
	margin:7px 5px 0px 5px; 
}
.bottone_servizio-testo {
	width:65px; 
	height:auto; 
	float:left; 
	font-size:11px;
	margin-top:3px;
	text-align:center;
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
<form id="form1" name="form1" method="post" action="gestione_gallery.php" enctype="multipart/form-data">
  <div style="width:540px; height:540px; margin:20px auto;">
      <div id="disp_azione" style="background-color:#fff; width:auto; min-height: 40px; overflow: hidden; height:auto; border: 1px solid #EBEBEB; padding:10px; margin-top:20px; float: none;">
        <div id="icona_titolo" style="width:auto; height:auto; margin-right: 10px; float: left;">
          <img src="immagini/icon_silhouette_image.png" />
        </div>
        <div id="titolo" style="width:auto; height:auto; color:#727272; float: left; font-size:20px; padding-top:3px; font-family:Arial;">
          Carica/cambia immagine
        </div>
      </div>
    <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:15px 0px 0px 0px;">
       Il file dell&acute;immagine inserita<br />non deve superare 1 Mb
    </div>
    <!-- stripN RIGA IMMAGINE PRINCIPALE-->
    <div class="stripN">
      <div class="colonna" style="width:100%; background-color:#FFF; min-height: 40px; overflow: hidden; height:auto; padding:20px 0px;" >
        <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:0px 0px 0px 20px;">
           Immagine principale
        </div>
          <div class="diciture_pag_modifica" style="float:left; width: 50%; margin:0px 20px 20px 20px;">
            <input name="immagine1" type="file" id="immagine1" size="15" />
          </div>

          <div style="width:20%; height:auto; float:left;">
            <?php
                if ($image1 != "") {
                echo "<img src=files/".$image1." width=30 height=30>";
                } else {
                echo "<img src=immagini/spacer.gif width=30 height=30>";
                }
              ?>
          </div>
           <div id="checkdiv1" style="width:50%; height:auto; float:left;">
           <!--vuoto, serve per il javascript che inserisce il campo hidden del check per far comparire il pulsante-->
          </div>
      </div><!--END colonna-->
    </div><!--END stripN RIGA IMMAGINE PRINCIPALE-->
    <!-- stripN RIGA GALLERY-->
    <div class="stripN">
      <div class="colonna" style="width:100%; background-color:#FFF; min-height: 40px; overflow: hidden; height:auto; padding:20px 0px;" >
        <div class="diciture_pag_modifica" style="float:none; width:auto; height: 30px; margin:0px 0px 0px 20px;">
           Galleria fotografica
        </div>
         <div id="checkdiv2" style="width:10px; height:auto; float:left;">
         <!--vuoto, serve per il javascript che inserisce il campo hidden del check per far comparire il pulsante-->
        </div>
         <!--PRIMA IMMAGINE GALLERY-->
        <div class="diciture_pag_modifica" style="float:left; width: 50%; margin:0px 20px 20px 20px;">
          <input name="immagine2" type="file" id="immagine2" size="15"/>
        </div>
        <div style="width:20%; height:auto; float:left;">
          <?php
			if ($image_gallery2 != "") {
			echo "<img src=files/gallery/".$image_gallery2." width=30 height=30>";
			} else {
			echo "<img src=immagini/spacer.gif width=30 height=30>";
			}
		  ?>
        </div>
        <div style="width:10%; height:auto; float:left;">
          <?php
			if ($image_gallery2 != "") {
			  echo '<a href="gestione_gallery.php?elimina_immagine=2&id_prod='.$id_prod.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'&negozio_prod='.$negozio_prod.'"><img src="immagini/button_elimina.gif" width="19" height="19" border="0" title="'.$elimina_image_gallery.'1"></a>';
			}
		  ?>
        </div>
         <!--END PRIMA IMMAGINE GALLERY-->
         <!--SECONDA IMMAGINE GALLERY-->
        <div class="diciture_pag_modifica" style="float:left; width: 50%; margin:0px 20px 20px 20px;">
          <input name="immagine3" type="file" id="immagine3" size="15" />
        </div>
        <div style="width:20%; height:auto; float:left;">
          <?php
			if ($image_gallery3 != "") {
			echo "<img src=files/gallery/".$image_gallery3." width=30 height=30>";
			} else {
			echo "<img src=immagini/spacer.gif width=30 height=30>";
			}
		  ?>
        </div>
        <div style="width:10%; height:auto; float:left;">
          <?php
			if ($image_gallery3 != "") {
  echo '<a href="gestione_gallery.php?elimina_immagine=3&id_prod='.$id_prod.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'&negozio_prod='.$negozio_prod.'"><img src="immagini/button_elimina.gif " width="19" height="19" border="0" title="'.$elimina_image_gallery.'"2></a>';
			}
		  ?>
         <div id="checkdiv2" style="width:10px; height:auto; float:left;">
         <!--vuoto, serve per il javascript che inserisce il campo hidden del check per far comparire il pulsante-->
        </div>
        </div>
         <!--END SECONDA IMMAGINE GALLERY-->
         <!--TERZA IMMAGINE GALLERY-->
        <div class="diciture_pag_modifica" style="float:left; width: 50%; margin:0px 20px 20px 20px;">
          <input name="immagine4" type="file" id="immagine4" size="15" />
        </div>
        <div style="width:20%; height:auto; float:left;">
          <?php
			if ($image_gallery4 != "") {
			echo "<img src=files/gallery/".$image_gallery4." width=30 height=30>";
			} else {
			echo "<img src=immagini/spacer.gif width=30 height=30>";
			}
		  ?>
        </div>
        <div style="width:10%; height:auto; float:left;">
          <?php
			if ($image_gallery4 != "") {
  echo '<a href="gestione_gallery.php?elimina_immagine=4&id_prod='.$id_prod.'&id_utente='.$_SESSION[user_id].'&lang='.$lingua.'&negozio_prod='.$negozio_prod.'"><img src="immagini/button_elimina.gif" width="19" height="19" border="0" title="'.$elimina_image_gallery.'"3></a>';
			}
		  ?>
         <div id="checkdiv2" style="width:10px; height:auto; float:left;">
         <!--vuoto, serve per il javascript che inserisce il campo hidden del check per far comparire il pulsante-->
        </div>
        </div>
         <!--END TERZA IMMAGINE GALLERY-->
      </div><!--END colonna-->
    </div><!--END stripN -->
    <!-- stripN PULSANTE SALVA-->
    <div class="stripN">
         <!--PULSANTE DI CARICO-->

        <div class="bottone_servizio-esterno" style="background-color: #3fa9f5; border:1px solid #4485d3; cursor:pointer; margin:auto;" onclick="submission()">
          <div class="bottone_servizio-icona">
            <img src="immagini/icona_segno_spunta.png" width="17" height="17">
          </div>
          <div class="bottone_servizio-testo">
            CARICA<br />IMMAGINI
         </div>
       </div>
      <input name="negozio_prod" type="hidden" id="negozio_prod" value="<?php echo $negozio_prod; ?>" />
      <input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>" />
      <input name="conferma_modifiche" type="hidden" id="conferma_modifiche" value="1" />
      <input name="mode" type="hidden" id="mode" value="<?php echo $mode; ?>" />
      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>" />
    </div><!--END stripN -->
  </div>
</form>
<script type="text/javascript">
function submission() {
document.getElementById("form1").submit();
}
  function checkimmagine() {
	var check_completato = document.getElementById('check').value;
	if (check_completato == "OK") {
    //Genera il link alla pagina che si desidera raggiungere
    location.href = "<?php echo $_SESSION[percorso_modifica]; ?>";
}
  }
  window.setInterval("checkimmagine()", 1000);
</script>

</body>
</html>
