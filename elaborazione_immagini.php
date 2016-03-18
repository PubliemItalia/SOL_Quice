<?php
// copia il contenuto di un file in una stringa
function leggifile($filename){
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
return $contents;
}
//fine funzione
$contenitore_immagini_princ = "files/";
$contenitore_immagini_gallery = "files/gallery/";
if ($mode == "ins") {
  $codice_art = $cod_temp;
}
//cancellazione immagini gallery
/*if ($img_gallery1_rem == "1") {
$sql = "DELETE FROM qui_gallery WHERE id_prodotto = '$codice_art' AND precedenza = '1'";
$risultato = mysql_query($sql) or die("Impossibile eseguire l'interrogazione");
}
if ($img_gallery2_rem == "1") {
$sql = "DELETE FROM qui_gallery WHERE id_prodotto = '$codice_art' AND precedenza = '2'";
$risultato = mysql_query($sql) or die("Impossibile eseguire l'interrogazione");
}
if ($img_gallery3_rem == "1") {
$sql = "DELETE FROM qui_gallery WHERE id_prodotto = '$codice_art' AND precedenza = '3'";
$risultato = mysql_query($sql) or die("Impossibile eseguire l'interrogazione");
}
if ($img_gallery4_rem == "1") {
$sql = "DELETE FROM qui_gallery WHERE id_prodotto = '$codice_art' AND precedenza = '4'";
$risultato = mysql_query($sql) or die("Impossibile eseguire l'interrogazione");
}
*/

//elaborazione immagine 2
if ($_FILES['immagine2']['tmp_name'] != "") {
$lung_immagine = strlen($_FILES['immagine2']['name']);
$estens = substr($_FILES['immagine2']['name'],($lung_immagine-4),($lung_immagine-1));
//if ($codice != "") {
//$nuovo_nome = $codice."_".$_FILES['immagine2']['name'];
//} else {
$nuovo_nome = $_FILES['immagine2']['name'];
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
if (is_uploaded_file($_FILES['immagine2']['tmp_name'])) {
$percorso_immagine = $contenitore_immagini_gallery.$nuovo_nome_immagine;
if (!move_uploaded_file($_FILES['immagine2']['tmp_name'], $contenitore_immagini_gallery.$nuovo_nome_immagine)) {
$msg = "<p>Errore nel caricamento dell'immagine2 in alta!!</p>";
} else {
}
}
$queryd = "INSERT INTO qui_gallery (id_prodotto, immagine, precedenza, temp) VALUES ('$codice_art', '$nuovo_nome_immagine', '2', 'T')";
if (mysql_query($queryd)) {
} else {
echo "Errore durante l'inserimento2". mysql_error();
}
}
//elaborazione immagine 3
if ($_FILES['immagine3']['tmp_name'] != "") {
$lung_immagine = strlen($_FILES['immagine3']['name']);
$estens = substr($_FILES['immagine3']['name'],($lung_immagine-4),($lung_immagine-1));
//if ($codice != "") {
//$nuovo_nome = $codice."_".$_FILES['immagine3']['name'];
//} else {
$nuovo_nome = $_FILES['immagine3']['name'];
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
if (is_uploaded_file($_FILES['immagine3']['tmp_name'])) {
$percorso_immagine = $contenitore_immagini_gallery.$nuovo_nome_immagine;
if (!move_uploaded_file($_FILES['immagine3']['tmp_name'], $contenitore_immagini_gallery.$nuovo_nome_immagine)) {
$msg = "<p>Errore nel caricamento dell'immagine3 in alta!!</p>";
} else {
$queryd = "INSERT INTO qui_gallery (id_prodotto, immagine, precedenza, temp) VALUES ('$codice_art', '$nuovo_nome_immagine', '3', 'T')";
if (mysql_query($queryd)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
}
}
//elaborazione immagine 4
if ($_FILES['immagine4']['tmp_name'] != "") {
$lung_immagine = strlen($_FILES['immagine4']['name']);
$estens = substr($_FILES['immagine4']['name'],($lung_immagine-4),($lung_immagine-1));
//if ($codice != "") {
//$nuovo_nome = $codice."_".$_FILES['immagine4']['name'];
//} else {
$nuovo_nome = $_FILES['immagine4']['name'];
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
if (is_uploaded_file($_FILES['immagine4']['tmp_name'])) {
$percorso_immagine = $contenitore_immagini_gallery.$nuovo_nome_immagine;
if (!move_uploaded_file($_FILES['immagine4']['tmp_name'], $contenitore_immagini_gallery.$nuovo_nome_immagine)) {
$msg = "<p>Errore nel caricamento dell'immagine4 in alta!!</p>";
} else {
$queryd = "INSERT INTO qui_gallery (id_prodotto, immagine, precedenza, temp) VALUES ('$codice_art', '$nuovo_nome_immagine', '4', 'T')";
if (mysql_query($queryd)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
}
}
//elaborazione immagine 5
if ($_FILES['immagine5']['tmp_name'] != "") {
$lung_immagine = strlen($_FILES['immagine5']['name']);
$estens = substr($_FILES['immagine5']['name'],($lung_immagine-4),($lung_immagine-1));
//if ($codice != "") {
//$nuovo_nome = $codice."_".$_FILES['immagine5']['name'];
//} else {
$nuovo_nome = $_FILES['immagine5']['name'];
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
if (is_uploaded_file($_FILES['immagine5']['tmp_name'])) {
$percorso_immagine = $contenitore_immagini_gallery.$nuovo_nome_immagine;
if (!move_uploaded_file($_FILES['immagine5']['tmp_name'], $contenitore_immagini_gallery.$nuovo_nome_immagine)) {
$msg = "<p>Errore nel caricamento dell'immagine5 in alta!!</p>";
} else {
$queryd = "INSERT INTO qui_gallery (id_prodotto, immagine, precedenza, temp) VALUES ('$codice_art', '$nuovo_nome_immagine', '5', 'T')";
if (mysql_query($queryd)) {
} else {
echo "Errore durante l'inserimento: ".mysql_error();
}
}
}
}


?>