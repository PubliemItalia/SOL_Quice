<?php
$avviso = $_GET[avviso];
$id_rda = $_GET[id];
$id_utente = $_GET[id_utente];
$lingua = $_GET[lang];
include "query.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Richiesta</title>
<link href="css/popup_modal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
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
function chiusura() {
    window.opener.chiusura(<?php echo $id_rda; ?>)
}
</script>
</head>

<body onUnload="chiusura()">
<div id="pop_container" style="padding-top: 40px;">
  Sei sicuro di voler archiviare la RdA selezionata?

<div id="scelta">
<table width="240" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="120">
<form name="form1" method="get" action="popup_notifica.php">
    <div align="center">
      <input type="submit" class="bottoni_notifiche" name="button" id="button" value="OK">
      <input name="id_rda" type="hidden" id="id_rda" value="<?php echo $id_rda; ?>">
      <input name="id_utente" type="hidden" id="id_utente" value="<?php echo $id_utente; ?>">
      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
    <input name="avviso" type="hidden" id="avviso" value="chiusura_rda">
    </div>
</form>
      </td>
      <td width="120">
        <form name="form2" method="get" action="popup_notifica.php">
                    <div align="center">
                      <input type="submit" class="bottoni_notifiche_neg" name="button" id="button" value="NO">
                      <input name="avviso" type="hidden" id="avviso" value="op_annullata">
                      <input name="lang" type="hidden" id="lang" value="<?php echo $lingua; ?>">
                            </div>
            </form>
      
      </td>
    </tr>
  </table>
            
        

</div><!--fine div scelta-->
</div><!--fine div POP container-->


</body>
</html>
