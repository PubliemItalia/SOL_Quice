<?
session_start();
$contenitore_immagini_princ = "/files/";

//elaborazione immagine 1
if ($_FILES['immagine1']['tmp_name'] != "") {
$lung_immagine1 = strlen($_FILES['immagine1']['name']);
$estens = substr($_FILES['immagine1']['name'],($lung_immagine1-4),($lung_immagine1-1));
$nuovo_nome = $codice."_".$_FILES['immagine1']['name'];
//$nuovo_nome = $_FILES['immagine1']['name'];
$nuovo_nome_immagine1_noEst = str_replace(" ","_",$nuovo_nome);
$nuovo_nome_immagine1_noEst = str_replace("/","-",$nuovo_nome_immagine1_noEst);
//$nuovo_nome_immagine1_noEst = str_replace(".","_",$nuovo_nome_immagine1_noEst);
$nuovo_nome_immagine1_noEst = str_replace("$","_",$nuovo_nome_immagine1_noEst);
$nuovo_nome_immagine1_noEst = str_replace("?","_",$nuovo_nome_immagine1_noEst);
$nuovo_nome_immagine1_noEst = str_replace("!","_",$nuovo_nome_immagine1_noEst);
$nuovo_nome_immagine1_noEst = str_replace("(","_",$nuovo_nome_immagine1_noEst);
$nuovo_nome_immagine1_noEst = str_replace(")","_",$nuovo_nome_immagine1_noEst);
$nuovo_nome_immagine1 = $nuovo_nome_immagine1_noEst;
if (is_uploaded_file($_FILES['immagine1']['tmp_name'])) {
//$percorso_immagine1 = $contenitore_immagini_princ.$codice."_".$nuovo_nome;
$percorso_immagine1 = $contenitore_immagini_princ.$_FILES['immagine1']['name'];
$_SESSION[imm_temp] = $_FILES['immagine1']['name'];
if (!move_uploaded_file($_FILES['immagine1']['tmp_name'], $percorso_immagine1)) {
$msg = "<p>Errore nel caricamento dell'immagine1 in alta!!</p>";
} else {
}
}
}
echo "imm: ".$nuovo_nome."<br>";
echo "codice: ".$codice."<br>";
echo "percorso_immagine1: ".$percorso_immagine1."<br>";

?>