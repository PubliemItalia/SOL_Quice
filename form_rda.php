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
<div style="width:400px; height:40px; float:left;">
  </div>
<div style="width:300px; height:40px; float:left;">
</div>
<div style="width:200px; height:40px; float:left;">
<?php
if ($report != 1) {
  echo "<div class=btnFreccia><a href=\"javascript:void(0);\" onClick=\"TINY.box.show({iframe:'popup_modal_approva_rda_resp.php?avviso=approva_rda_resp&id_rda=".$id."&id_utente=".$_SESSION[user_id]."&lang=".$lingua."',boxid:'frameless',width:400,height:170,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})\"><strong>".$invia_buyer."</strong></a></div>";       
}
?>  
  </div>
</div>

</body>
</html>
