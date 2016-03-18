<?php
include "query.php";
// Create a MySQL table in the selected database
$nome_tabella = "statistica_venduto_".date("Ymd_Hi",mktime());
mysql_query("CREATE TABLE ".$nome_tabella."(
id INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
 codice VARCHAR(30), 
 categoria1 VARCHAR(30), 
 fatturato float(14,2), 
 quant INT)")
 or die(mysql_error());  

echo "Table Created!";
$array_ricerca = array("Etichette_ADR","Etichette_e_fogli_AIC","Etichette_Medical_Device","Etichette_e_collari");
$array_codici = array();
foreach ($array_ricerca as $sing_cat) {
	
//$querym = "SELECT DISTINCT codice_art FROM qui_righe_rda WHERE categoria = '".$sing_cat."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1357027200' AND '1388521800')";
$querym = "SELECT DISTINCT codice_art FROM qui_righe_rda WHERE categoria = '".$sing_cat."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1357027200' AND '1388521800')";
$resultm = mysql_query($querym);
while ($rowm = mysql_fetch_array($resultm)) {
	$add_cod = array_push($array_codici,$rowm[codice_art]);
	}

}
print_r($array_codici);
foreach ($array_codici as $sing_cod) {
$queryf = "SELECT * FROM qui_righe_rda WHERE codice_art = '".$sing_cod."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1357027200' AND '1388521800')";
$resultf = mysql_query($queryf);
while ($rowf = mysql_fetch_array($resultf)) {
	$somma_euro = $somma_euro + $rowf[totale];
	$somma_quant = $somma_quant + $rowf[quant];
	$categ = $rowf[categoria];
}
	$queryb = "INSERT INTO ".$nome_tabella." (codice, categoria1, fatturato, quant) VALUES ('$sing_cod', '$categ', '$somma_euro', '$somma_quant')";
if (mysql_query($queryb)) {
echo "inserito art ".$sing_cod." - fatturato: ".$somma_euro." - numero: ".$somma_quant."<br>";
} else {
echo "Errore durante l'inserimento3". mysql_error();
}
$somma_euro = "";
$somma_quant = "";
}
/*	//$totale_articolo_euro = $rowm['SUM(totale)'];
	//$totale_articolo_quant = $rowm['SUM(quant)'];
$resultb = mysql_query($sumquery);
list($somma) = mysql_fetch_array($resultb);
$totale_storico_rda = $somma;
*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento senza titolo</title>
</head>

<body>
</body>
</html>