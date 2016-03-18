<?php
include "query_publiem_etic.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento senza titolo</title>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
</head>

<body>
<?php
	$sqlt = "SELECT * FROM qui_packing_list WHERE logo = 'vivisol' ORDER BY id DESC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione03" . mysql_error());
    while ($rigat = mysql_fetch_array($risultt)) {
		  echo '<div style="background-color:#000; color:#fff; cursor:pointer; width:auto; height:30px; margin:auto;">PL '.$rigat[id].'</div>';
	}

?>
</body>

</html>