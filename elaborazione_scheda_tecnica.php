<?php
$contenitore_immagini_princ = "documenti/";

//elaborazione immagine 1
if ($_FILES['scheda']['tmp_name'] != "") {
$lung_immagine = strlen($_FILES['scheda']['name']);
$estens = substr($_FILES['scheda']['name'],($lung_immagine-4),($lung_immagine-1));
//if ($codice != "") {
//$nuovo_nome = $codice."_".$_FILES['scheda']['name'];
//} else {
$nuovo_nome = $_FILES['scheda']['name'];
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
if (is_uploaded_file($_FILES['scheda']['tmp_name'])) {
$percorso_immagine = $contenitore_immagini_princ.$nuovo_nome_immagine;
if (!move_uploaded_file($_FILES['scheda']['tmp_name'], $contenitore_immagini_princ.$nuovo_nome_immagine)) {
$msg = "<p>Errore nel caricamento della scheda!!</p>";
} else {
}
}
$querya = "UPDATE qui_prodotti_".$negozio_prod." SET percorso_pdf = '$nuovo_nome_immagine' WHERE id = '$id_prod'";
if (mysql_query($querya)) {
} else {
echo "Errore durante l'inserimento1: ".mysql_error();
}

}
?>