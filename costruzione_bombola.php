<?php
/* Read the image */
//$fondo = new Imagick("componenti/fondo.png");
$corpo = new Imagick("componenti/bombole/Alluminio_RAL_9006_striscia_Beige_20cm_RAL_1001.png");
$ogiva = new Imagick("componenti/ogiva/Marrone_rossiccio_RAL_3009.png");
$valvola = new Imagick("componenti/valvola/val_ottone.png");
$cappellotto = new Imagick("componenti/cappellotto/CAP001.png");


/* Clone the image and flip it */
$bombola = $corpo->clone();

/* Composite i pezzi successivi sopra il fondo in questo ordine */
//$bombola->compositeImage($corpo, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($ogiva, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($cappellotto, imagick::COMPOSITE_OVER, 0, 0);
$bombola->compositeImage($valvola, imagick::COMPOSITE_OVER, 0, 0);
$timecode= date("dmYHi",time());
$nomefile = "temp_bombole/bomb_".$timecode.".png";
$bombola->writeImage($nomefile);
echo "<img src=".$nomefile.">";

/* Output the image*/
/*header("Content-Type: image/png");
echo $bombola;
*/
//unlink($nomefile);
?>
