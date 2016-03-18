<?php
$n_fatt = $_POST[n_fatt];
$n_rda = $_POST[n_rda];
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

//aggiorno l'rda
$query = "UPDATE qui_rda SET n_fatt_sap = '$n_fatt' WHERE id = '$n_rda'"; 
if (mysql_query($query)) {
	//$out_value .= "riga aggiornata: ".$n_rda." con fattura ".$n_fatt."<br>";
} else {
$out_value .= "Errore durante l'inserimento". mysql_error();
}

//aggiorno anche le righe relative
$query = "UPDATE qui_righe_rda SET n_fatt_sap = '$n_fatt' WHERE id_rda = '$n_rda'"; 
if (mysql_query($query)) {
	//$out_value .= "riga aggiornata: ".$n_rda." con fattura ".$n_fatt."<br>";
} else {
$out_value .= "Errore durante l'inserimento". mysql_error();
}

$queryh = "SELECT * FROM qui_rda WHERE id = '$n_rda'";
$resulth = mysql_query($queryh);
while ($row = mysql_fetch_array($resulth)) {
$queryk = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_resp]'";
$resultk = mysql_query($queryk);
while ($rowk = mysql_fetch_array($resultk)) {
$nome_resp = $rowk[nome];
}
$n_fatt_sap = $row[n_fatt_sap];
$out_value .= "<div class=box_450 style=\"width:850px;\">";
$out_value .= "RdA ".$n_rda."<img src=immagini/spacer.gif width=15 height=4>| ".date("d/m/Y",$row[data_inserimento])."<img src=immagini/spacer.gif width=15 height=4>| Responsabile ".$nome_resp;
$out_value .= "<img src=immagini/spacer.gif width=15 height=4>| Unit&agrave; ".$row[nome_unita];
$out_value .= "</div>";
$out_value .= "<div style =\"width:80px; height:20px; margin-top:5px; float:left;\">";
if ($n_fatt_sap != "") {
$out_value .= "PL ".$n_fatt_sap;
}
$out_value .= "</div>";
}
echo $out_value;
?>