<?php
session_start();
    switch ($lingua) {
	  case "":
	  case "it":
	  $pulsante_crea = '<img src="immagini/btn_crearda.png" width="160" height="25">';
	  $pulsante_svuota = '<img src="immagini/btn_svuotacarrello.png" width="160" height="25">';
	  break;
	  case "en":
	  $pulsante_crea = '<img src="immagini/btn_createanorder.png" width="160" height="25">';
	  $pulsante_svuota = '<img src="immagini/btn_emptycart.png" width="160" height="25">';
	  break;
  }


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<title>form carrello</title>
<script language="javascript">
<!--

function controllo(){
var valore = document.formnote.textarea.value;
alert("ok");
if(valore=="Note") {
   document.formnote.textarea.value = "";
}
}
//-->
</script>
<script>
function PopupCenter2(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="tinybox.js"></script>

<style type="text/css">
<!--
.Stile1 {
	color: #999999;
	font-size: 10px;
}
.Stile2 {font-size: 12px}
-->
</style>
</head>

<body>
    <div id="form_carrello">
        <form name=formnote method=get action=carrello.php><br>
<div id="col01e" class="riga" style="width: 100%; border-top: 1px solid #c4c4c4; min-height:30px; overflow: hidden; height: auto; padding-top: 10px; color: #000; margin-bottom: 10px;">
  <div id="col02e" style="width: 703px; float: left; min-height: 40px; overflow: hidden; height: auto;">
	<div id="col03e" style="width: 20%; float: left; height: auto; margin-left: 10px; margin-right: 1%; padding-bottom: 2px;"></div>
	<div id="col04e" style="width: 35%; float: left; height: auto; margin-right: 1%; padding-bottom: 2px;"></div>
	<div id="col05e" style="width: 35%; float: left; height: 20px;"><strong>Notes</strong></div>
	<div id="col06e" style="width: 20%; float: left; min-height: 20px; overflow: hidden; height: auto; margin-right: 1%;"></div>
	<div id="col07e" style="width: 35%; float: left; min-height: 20px; overflow: hidden; height: auto; margin-right: 1%;"></div>
    <div id="col08e" style="width: 35%; float: left; min-height: 20px; overflow: hidden; height: auto;">
         <?php 
		  if ($note != "") {
			 echo '<textarea name="textarea" style="width:230px;" rows="5" class="tabelle8" id="textarea" onFocus="azzera_nota()" onBlur="this.form.submit()">'.$note.'</textarea>';
		  } else {
			 echo '<textarea name="textarea" style="width:230px;" rows="5" class="tabelle8" id="textarea" onFocus="azzera_nota()" onclick="controllo()" onBlur="this.form.submit()">Note</textarea>';
		  }
		 ?>
        <input type=hidden name=id_cart id=id_cart value="<?php echo $carrello; ?>">
        <input type=hidden name=id_utente id=id_utente value="<?php echo $_SESSION[user_id]; ?>">
          <input name=lang type=hidden id=lang value="<?php echo $lingua; ?>">
          <input name=conferma_nota type=hidden id=conferma_nota value=1>
    </div>
  </div>
  <div id="pulsanti" class="col02e-pulsante" style="width: 250px; float: left; min-height: 50px; overflow: hidden; height: auto;">
<div id="puls_processa_*sost_id_riga*" style="width: 195px; min-height: 20px; overflow: hidden; height: auto; margin: 0px 0px 5px 35px; text-align: left;">
<div id="crea_rda_carrello"><a href="javascript:void(0);" onClick="TINY.box.show({iframe:'popup_modal_gen_rda.php?avviso=genera_rda&negozio_carrello=<?php echo $negozio_carrello; ?>&id_carrello=<?php echo $carrello; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:500,height:380,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"><?php echo $pulsante_crea; ?></a></div>
</div>
<div id="puls_stampa" style="width: 195px; min-height: 20px; overflow: hidden; height: auto; margin: 0px 0px 5px 35px; text-align: left;">
<div id="svuota_carrello"><a href="javascript:void(0);" onClick="TINY.box.show({iframe:'popup_modal_svuota_carrello.php?avviso=svuota_carrello&id_carrello=<?php echo $carrello; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:460,height:200,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"><?php echo $pulsante_svuota; ?></a></div>
			 <?php
        if ($negozio_riga == "labels") {
             echo "<a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'spedizioni.php',boxid:'frameless960',width:960,height:480,fixed:false,maskid:'bluemask',maskopacity:40})\"><div id=\"costi_spedizione\"><strong><span>";
             switch($_SESSION[lang]) {
      case "it":
      $spediz = "Costi di spedizione";
      break;
      case "en":
      $spediz = "Delivery costs";
      break;
      case "fr":
      $spediz = "Delivery costs";
      break;
      case "de":
      $spediz = "Delivery costs";
      break;
      case "es":
      $spediz = "Delivery costs";
      break;
      }
      echo $spediz;
             echo "</span></strong></div></a>";
        }
	 ?>
      <div id="scritta_misteriosa">
            <?php 
            if ($_SESSION[ruolo] == "utente") {
            echo $scritta_carrello;
            }
            ?></span>
      </div>

</div>
</div>
</div>
    </div>
    
    
     </div>
      </form>
  </div>

</body>
</html>
