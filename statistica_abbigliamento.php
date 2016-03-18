<?php
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
echo '<table width="900" border="1" cellpadding="1" cellspacing="1">
<tr><td>Codice</td><td>Descrizione</td><td>Taglia</td><td>quant 2013</td><td>totale 2013</td><td>giacenza</td></tr>';
/*
//vivisol
$sqlg = "SELECT codice_art, descrizione1_it, categoria4_it, giacenza FROM qui_prodotti_vivistore WHERE categoria1_it = 'Abbigliamento' ORDER BY codice_art DESC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
	
//	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1420070400' AND '1451520000')";//2015
//	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1388617200' AND '1420066800')";//2014
	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1357081200' AND '1388530800')";//2013
//	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1325458800' AND '1356994800')";//2012
	$resultf = mysql_query($sqlf);
	list($somma) = mysql_fetch_array($resultf);
//	$sqlh = "SELECT SUM(quant) as sommaquant FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1420070400' AND '1451520000')";//2015
//	$sqlh = "SELECT SUM(quant) as sommaquant FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1388617200' AND '1420066800')";//2014
	$sqlh = "SELECT SUM(quant) as sommaquant FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1357081200' AND '1388530800')";//2013
//	$sqlh = "SELECT SUM(quant) as sommaquant FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1325458800' AND '1356994800')";//2012
	$resulth = mysql_query($sqlh);
	list($sommaquant) = mysql_fetch_array($resulth);
	echo '<tr>
	<td>'.$rigag[codice_art].'</td><td>'.$rigag[descrizione1_it].'</td><td>'.$rigag[categoria4_it].'</td><td>'.number_format($sommaquant,2,",",".").'</td><td>'.number_format($somma,2,",",".").'</td><td>'.$rigag[giacenza].'</td>';
	echo '</tr>';
	$totale_quant = $totale_quant + $sommaquant;
	$totale_valore = $totale_valore + $somma;
}
*/
//SOL
$sqlg = "SELECT codice_art, descrizione1_it, categoria4_it, giacenza FROM qui_prodotti_consumabili WHERE categoria2_it = 'Abbigliamento_Sol' ORDER BY codice_art DESC";
$risultg = mysql_query($sqlg) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigag = mysql_fetch_array($risultg)) {
	
//	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1420070400' AND '1451520000')";//2015
//	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1388617200' AND '1420066800')";//2014
	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1357081200' AND '1388530800')";//2013
//	$sqlf = "SELECT SUM(totale) as somma FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1325458800' AND '1356994800')";//2012
	$resultf = mysql_query($sqlf);
	list($somma) = mysql_fetch_array($resultf);
//	$sqlh = "SELECT SUM(quant) as sommaquant FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1420070400' AND '1451520000')";//2015
//	$sqlh = "SELECT SUM(quant) as sommaquant FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1388617200' AND '1420066800')";//2014
	$sqlh = "SELECT SUM(quant) as sommaquant FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine < '3' AND (data_inserimento BETWEEN '1357081200' AND '1388530800')";//2013
//	$sqlh = "SELECT SUM(quant) as sommaquant FROM qui_righe_rda WHERE codice_art = '".$rigag[codice_art]."' AND stato_ordine = '4' AND (data_inserimento BETWEEN '1325458800' AND '1356994800')";//2012
	$resulth = mysql_query($sqlh);
	list($sommaquant) = mysql_fetch_array($resulth);
	echo '<tr>
	<td>'.$rigag[codice_art].'</td><td>'.$rigag[descrizione1_it].'</td><td>'.$rigag[categoria4_it].'</td><td>'.number_format($sommaquant,2,",",".").'</td><td>'.number_format($somma,2,",",".").'</td><td>'.$rigag[giacenza].'</td>';
	echo '</tr>';
}
	echo '<tr>
	<td>Totali</td><td></td><td></td><td>'.number_format($totale_quant,2,",",".").'</td><td>'.number_format($totale_valore,2,",",".").'</td><td></td>';
	echo '</tr>';
echo '</table>';
?>