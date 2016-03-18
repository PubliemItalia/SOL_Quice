<?php
$avviso = $_GET[avviso];
$n_vero_bolla = $_GET[n_vero_bolla];

switch($avviso) {
case "ddt":
$dicitura = "Il DdT &egrave; stato creato correttamente!";
break;
case "config":
$dicitura = "I dati sono stati modificati correttamente!";
break;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<script> 
if('ddt'=='<?php echo $avviso; ?>') {
setTimeout("window.open('ddt.php?stampa=1&n_vero_bolla=<?php echo $n_vero_bolla; ?>','DdT','status=no,toolbar=no,menubar=no,location=no,scrollbars=yes,left=50,top=50');", 1400);
} 
setTimeout("window.close();", 1500); 
</script>
<link href="tabelle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" height="70"><tr><td width="100%" align="center"  valign="middle" class="verde_grassettocx"><?php echo $dicitura; ?></td>
</tr></table>


</body>
</html>
