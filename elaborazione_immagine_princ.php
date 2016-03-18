<?php
$contenitore_immagini_princ = "files/";

//elaborazione immagine 1
if ($_FILES['immagine1']['tmp_name'] != "") {
$lung_immagine = strlen($_FILES['immagine1']['name']);
$estens = substr($_FILES['immagine1']['name'],($lung_immagine-4),($lung_immagine-1));
//if ($codice != "") {
//$nuovo_nome = $codice."_".$_FILES['immagine1']['name'];
//} else {
$nuovo_nome = $codice_art."_".$_FILES['immagine1']['name'];
//}
$nuovo_nome_immagine_noEst = str_replace(" ","_",$nuovo_nome);
$nuovo_nome_immagine_noEst = str_replace("/","-",$nuovo_nome_immagine_noEst);
//$nuovo_nome_immagine_noEst = str_replace(".","_",$nuovo_nome_immagine_noEst);
$nuovo_nome_immagine_noEst = str_replace("$","_",$nuovo_nome_immagine_noEst);
$nuovo_nome_immagine_noEst = str_replace("?","_",$nuovo_nome_immagine_noEst);
$nuovo_nome_immagine_noEst = str_replace("!","_",$nuovo_nome_immagine_noEst);
$nuovo_nome_immagine_noEst = str_replace("(","_",$nuovo_nome_immagine_noEst);
$nuovo_nome_immagine_noEst = str_replace(")","_",$nuovo_nome_immagine_noEst);
$nuovo_nome_immagine = $nuovo_nome_immagine_noEst;
if (is_uploaded_file($_FILES['immagine1']['tmp_name'])) {
$percorso_immagine = $contenitore_immagini_princ.$nuovo_nome_immagine;
if (!move_uploaded_file($_FILES['immagine1']['tmp_name'], $contenitore_immagini_princ.$nuovo_nome_immagine)) {
$msg = "<p>Errore nel caricamento dell'immagine1 in alta!!</p>";
} else {
}
}
$querya = "UPDATE qui_prodotti_".$negozio_prod." SET foto_sost = '$nuovo_nome_immagine' WHERE id = '$id_prod'";
if (mysql_query($querya)) {
} else {
echo "Errore durante l'inserimento1: ".mysql_error();
}

}
?>