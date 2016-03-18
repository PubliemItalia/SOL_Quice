<?php
session_start();
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
    <table width=960 border=0 cellspacing=0 cellpadding=0>
      <tr>
        <td width="596" rowspan="2">
  <form name=formnote method=get action=carrello.php><br>
   <?php 
		if ($note != "") {
   echo "<textarea name=textarea style=width:480px; rows=5 class=tabelle8 id=textarea onBlur=\"this.form.submit()\">".$note."</textarea>";
		} else {
   echo "<textarea name=textarea style=width:480px; rows=5 class=tabelle8 id=textarea onclick=\"controllo()\" onBlur=\"this.form.submit()\">Note</textarea>";
		}
		 ?>
          <input type=hidden name=id_cart id=id_cart value="<?php echo $carrello; ?>">
          <input type=hidden name=id_utente id=id_utente value="<?php echo $_SESSION[user_id]; ?>">
            <input name=lang type=hidden id=lang value="<?php echo $lingua; ?>">
            <input name=conferma_nota type=hidden id=conferma_nota value=1>
    </form>        </td>
        <td width="210" valign="top"><div class="btnSvuota"><a href="javascript:void(0);" onClick="TINY.box.show({iframe:'popup_modal_svuota_carrello.php?avviso=svuota_carrello&id_carrello=<?php echo $carrello; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:410,height:200,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"><strong><?php echo $svuota_carrello; ?></strong></a></div>
       </td>
        <td width="154" valign="top"><div class="btn btnFreccia"><a href="javascript:void(0);" onClick="TINY.box.show({iframe:'popup_modal_gen_rda.php?avviso=genera_rda&negozio_carrello=<?php echo $negozio_carrello; ?>&id_carrello=<?php echo $carrello; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>',boxid:'frameless',width:410,height:220,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"><strong><?php echo $crea_rda; ?></strong></a>
        
        
        <!--<a href="javascript:void(0);" onClick="PopupCenter2('popup_modal_gen_rda.php?avviso=genera_rda&id_carrello=<?php echo $carrello; ?>&id_utente=<?php echo $_SESSION[user_id]; ?>&lang=<?php echo $lingua; ?>', 'myPop1',400,140)"><strong><?php echo $crea_rda; ?></strong></a>-->
        </div>
       <?php
  if ($negozio_riga == "labels") {
       echo "<div style=\"margin-top:70px; margin-left:40px; font-family:Arial; font-size:12px;\"><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'spedizioni.php',boxid:'frameless960',width:960,height:480,fixed:false,maskid:'bluemask',maskopacity:40})\"><strong><span style=\"color:red; text-decoration:none;\">";
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
       echo "</span></strong></a></div>";
  }
	   ?>
</div>
</td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><div align="right"><span class="Stile2">
        <?php 
		if ($_SESSION[ruolo] == "utente") {
		echo $scritta_carrello;
		}
		?></span></div></td>
      </tr>
    </table>
<img src=immagini/spacer.gif width=960 height=20>

</body>
</html>
