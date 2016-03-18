<?php
$inserimento_pl = $_POST["inserimento_pl"];
$n_pl = $_POST["n_pl"];
//echo '<div style="color: #000;">dati_packing_list: '.$dati_packing_list.'<br>
//dati_rda: '.$dati_rda.'<br>
//</div>';
//echo "dati_rda: ".$dati_rda."<br>";
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db

if ($inserimento_pl != "") {
$queryv = "SELECT * FROM qui_packing_list WHERE id = '$n_pl'";
$resultv = mysql_query($queryv);
while ($rowv = mysql_fetch_array($resultv)) {
$id_pack = stripslashes($rowv[id]);
$indirizzo_spedizione = stripslashes($rowv[indirizzo_spedizione]);
$utente = stripslashes($rowv[utente]);
$responsabile = stripslashes($rowv[responsabile]);
  if ($rowv[note] == "") {
	  $note = 'Note';
  } else {
	  $note = stripslashes($rowv[note]);
  }
$colli = stripslashes($rowv[colli]);
$peso = stripslashes($rowv[peso]);
$data_spedizione = date("d/m/Y H:i",$rowv[data_spedizione]);
$data_spedizionextestata = date("d/m/Y",$rowv[data_spedizione]);
$indirizzo_vettore = stripslashes($rowv[vettore]);
$id_vettore = $rowv[id_vettore];
	switch ($rowv[logo]) { 
	  case "sol":
		$container_class = "sol_brand_container";
	  break;
	  case "vivisol":
		$container_class = "vivisol_brand_container";
	  break;
	}
$dati_packing_list .= "|".$rowv[id]."|;|".$rowv[logo]."|;|".$rowv[check_completato]."|;|".$rowv[dest_contab]."|;|".$rowv[rda]."|;|".$rowv[id_unita]."|;|".$rowv[indirizzo_spedizione]."|;|".$rowv[utente]."|;|".$rowv[responsabile]."|;|".$rowv[note]."|;|".$rowv[colli]."|;|".$rowv[peso]."|;|".$rowv[volume]."|;|".$rowv[id_vettore]."|;|".$rowv[vettore]."|;|".$rowv[data_spedizione]."|;|".$rowv[data_chiusura]."|;|".$rowv[data_chiusura_tx]."|;|".$rowv[magazziniere]."|;|".$rowv[operatore_chiusura]."|;|".$rowv[n_ord_sap]."|;|".$rowv[n_fatt_sap]."|;";
$dati_packing_list = str_replace("||","|0|",$dati_packing_list);
//$dati_packing_list .= "||";
}

//spedizione dati PL
include("http://www.publiem.eu/quice/inserimento_PL_da_sol.php?inserimento_pl=1&dati_packing_list=".$dati_packing_list);

$sql = "SELECT * FROM qui_righe_rda WHERE pack_list = '$n_pl'";
$risult = mysql_query($sql);
while ($row = mysql_fetch_array($risult)) {
	$sqla = "SELECT * FROM qui_utenti WHERE user_id = '$row[id_utente]'";
	$risulta = mysql_query($sqla);
	while ($rowa = mysql_fetch_array($risulta)) {
		$dati_utente .= "|".$rowa[user_id]."|;|".$rowa[login]."|;|".$rowa[nome]."|;|".$rowa[posta]."|;|".$rowa[idlocalita]."|;|".$rowa[idunita]."|;|".$rowa[indirizzo]."|;|".$rowa[cap]."|;|".$rowa[company]."|;|".$rowa[localita]."|;|".$rowa[nazione]."|;|".$rowa[nomeunita]."|;|".$rowa[companyName]."|;|".$rowa[IDCompany]."|;|".$rowa[idresp]."|;|".$rowa[ruolo]."|;|".$rowa[ruolo_report]."|;|".$rowa[negozio_buyer]."|;|".$rowa[negozio2_buyer]."|;|".$rowa[precedenza_buyer]."|;|".$rowa[pwd]."|;|".$rowa[flag_etichette_pharma]."|;";
	 // $dati_utente .= "||";
	}
	  $dati_rda .= "|".$row[id]."|;|".$row[id_carrello]."|;|".$row[negozio]."|;|".$row[id_unita]."|;|".$row[nome_unita]."|;|".$row[categoria]."|;|".$row[azienda_prodotto]."|;|".$row[azienda_utente]."|;|".$row[dest_contab]."|;|".$row[id_utente]."|;|".$row[id_resp]."|;|".$row[id_prodotto]."|;|".$row[codice_art]."|;|".$row[descrizione]."|;|".$row[confezione]."|;|".$row[quant]."|;|".$row[quant_modifica]."|;|".$row[prezzo]."|;|".$row[totale]."|;|".$row[data_inserimento]."|;|".$row[data_output]."|;|".$row[data_chiusura]."|;|".$row[data_ultima_modifica]."|;|".$row[id_rda]."|;|".$row[pack_list]."|;|".$row[stato_ordine]."|;|".$row[flag_buyer]."|;|".$row[flag_chiusura]."|;|".$row[flag_packing_list]."|;|".$row[output_mode]."|;|".$row[file_sap]."|;|".$row[n_ord_sap]."|;|".$row[n_fatt_sap]."|;|".$row[evaso_magazzino]."|;|".$row[vecchio_codice]."|;|".$row[report_select]."|;|".$row[gruppo_merci]."|;|".$row[wbs]."|;|".$row[ordine_stampa]."|;|".$row[id_buyer]."|;|".$row[id_magazz]."|;|".$row[nazione]."|;|".$row[assegnaz_fornitore]."|;|".$row[fornitore_tx]."|;|".$row[ord_fornitore]."|;|".$row[logo_ordine]."|;";
	  $dati_rda = str_replace("||","|0|",$dati_rda);
	  //$dati_rda .= "||";
include("http://www.publiem.eu/quice/inserimento_PL_da_sol.php?inserimento_righe=1&dati_rda=".$dati_rda);
	  
}

}
?>

<html>
<head>
<title>PBM</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="tabelle.css" rel="stylesheet" type="text/css">
</head>

<body>
</body>
</html>