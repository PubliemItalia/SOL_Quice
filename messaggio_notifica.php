<?php
$avviso = $_GET[avviso];
$rda = $_GET[rda];
switch($avviso) {

case "ordine_sap":
$dicitura = "Il numero d'ordine SAP relativo alla RdA<br>&egrave; stato inserito";
break;
case "fattura_sap":
$dicitura = "Il numero di fattura SAP relativo alla RdA<br>&egrave; stato inserito";
break;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conferma</title>
<script> 
setTimeout("window.close();", 3000); 
</script>
<link href="tabelle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div style="width:100%; margin-top:20px; color:red; font-family:Arial; font-size:18px; font-weight:bold; text-align:center"><?php echo $dicitura; ?></div>

</body>
</html>
