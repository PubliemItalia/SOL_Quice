<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<title>Documento senza titolo</title>
<script>
function PopupCenter2(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} </script>
</head>

<body>
<div class="cont_generale">
<div style="width:400px; height:100px; float:left;">
  <?php
include "modulo_riepilogo_dati_rda.php";
?>
  </div>
<div style="width:300px; height:100px; float:left;">
          <form name=form1 method=get action=popup_vis_rda.php>
          <?php
 		  if ($report != 1) {
		  switch ($_SESSION[ruolo]) {
		  case "responsabile":
		  if ($stato_rda == 1) {
        echo "<textarea name=textarea style=width:280px; rows=5 class=tabelle8 id=textarea onBlur=\"this.form.submit()\">".str_replace("<br>","\n",$note_resp)."</textarea>";
//        echo "<textarea name=textarea rows=5 class=tabelle8 id=textarea onBlur=\"this.form.submit()\">".str_replace("<br>","\n",$note_resp)."</textarea>";
          echo "<input type=hidden name=id id=id value=".$id.">";
            echo "<input type=hidden name=id_utente id=id_utente value=".$id_utente.">";
            echo "<input type=hidden name=ruolo_ins id=ruolo_ins value=responsabile>";
            echo "<input name=lang type=hidden id=lang value=".$lingua.">";
            echo "<input name=conferma_nota type=hidden id=conferma_nota value=1>";
		  }
		  break;
		  case "buyer":
		  if ($stato_rda <= 3) {
        echo "<textarea name=textarea style=width:280px; rows=5 class=tabelle8 id=textarea onBlur=\"this.form.submit()\">".str_replace("<br>","\n",$note_buyer)."</textarea>";
//        echo "<textarea name=textarea rows=5 class=tabelle8 id=textarea onBlur=\"this.form.submit()\">".str_replace("<br>","\n",$note_buyer)."</textarea>";
          echo "<input type=hidden name=id id=id value=".$id.">";
            echo "<input type=hidden name=id_utente id=id_utente value=".$id_utente.">";
            echo "<input type=hidden name=ruolo_ins id=ruolo_ins value=buyer>";
            echo "<input name=lang type=hidden id=lang value=".$lingua.">";
            echo "<input name=conferma_nota type=hidden id=conferma_nota value=1>";
		  }
		  break;
		  }
		  } else {
		  switch ($_SESSION[ruolo]) {
		  case "responsabile":
			echo str_replace("<br>","\n",$note_resp);
		  break;
		  case "buyer":
			echo str_replace("<br>","\n",$note_buyer);
		  break;
		  }
		  }
		  ?>
    </form>
  </div> 
</div>
<div style="width:200px; height:100px; float:left;">
<?php
 		  if ($report != 1) {
       echo "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'output.php?id=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:460,height:300,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><strong>".$processa_buyer."</strong></a></div>";
		  }
?>  
</div>
</div>

</body>
</html>
