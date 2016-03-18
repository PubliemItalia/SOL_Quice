<?php
//funzione x l'elenco della directory
function elencafiles($dirname){
$arrayfiles=Array();
if(file_exists($dirname)){
$handle = opendir($dirname);
while (false !== ($file = readdir($handle))) {
if(is_file($dirname.$file)){
array_push($arrayfiles,$file);
}
}
$handle = closedir($handle);
}
sort($arrayfiles);
return $arrayfiles;
}
//fine funzione
$arrayfiles_temp = elencafiles("temp_bombole/");
//echo "lista immagini da cancellare: ";
//print_r($arrayfiles_temp);
//echo "<br>";
$data_attuale = date("dmYHi",time());
foreach ($arrayfiles_temp as $single_image) {
	$data_file = substr($single_image,0,12);
	if (($data_attuale - $data_file) >= 20000000000) {
		unlink("temp_bombole/".$single_image);
		//echo $single_image. "da cancellare<br>";
	}
}
?>