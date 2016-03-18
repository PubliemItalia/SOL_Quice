<?php
//echo "messaggio: ".$messaggio."<br>";
switch ($negozio) {
case "assets":
$negozio_rda = $tasto_asset;
break;
case "consumabili":
$negozio_rda = $tasto_consumabili;
break;
case "spare_parts":
$negozio_rda = $tasto_spare_parts;
break;
case "labels":
$negozio_rda = $tasto_labels;
break;
}
$messaggio_resp = "<strong>PL ".$n_pl."</strong><br><br>";
$messaggio_resp .= "Utente:<br><strong>".$nome_utente."</strong><br>";
$messaggio_resp .= "Unit&agrave;:<br><strong>".$unit_name."</strong><br>";
$messaggio_resp .= "Indirizzo:<br>".$nome_unita."<br>";

$oggetto = "Nuova spedizione - PL ".$n_pl;
//**********************************************************************
//SEZIONE SPEDIZIONE EMAIL
//**********************************************************************


$mittente = "server@sol.it";
require("PHPMailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
/*switch ($_SERVER["REMOTE_ADDR"]) {
case "10.5.0.25":
//sol interno
$mail->Host = "10.0.1.148";  // specify main and backup server
break;
case "95.252.15.147":
//aruba
$mail->Host = "smtp.sol-quice.it";  // specify main and backup server
break;
case "xxxxx":
//publiem
$mail->Host = "smtp.fastweb.it";  // specify main and backup server
break;
case "192.168.1.161":
//casa
$mail->Host = "out.aliceposta.it";  // specify main and backup server
break;

}
*/$mail->Host = "10.0.1.148";  // specify main and backup server
//$mail->SMTPAuth = false;     // turn on SMTP authentication
//$mail->Username = "jswan";  // SMTP username
//$mail->Password = "secret"; // SMTP password

$mail->From = $mittente;
$mail->FromName = "Qui c'e' - ".$negozio." - ".stripslashes($_SESSION[nome]);
//$mail->FromName = "Qui c'e' - ".$negozio_rda." - ".stripslashes($_SESSION[nome]);
$dataora = mktime();
//$email_operatore = "luigi.riva@dtpc.it";
//$allegato = "C:\\xampp\htdocs\\topcolor\\phpmysqlautobackup\\backups\\".$backup_file_name;
//$allegato = $percorso_backup.$backup_file_name;

//echo "allegato: ".$allegato."<br>";
//$solonome_file = "/www.dtpc.it/mysql_topcolor_27_May_2011_time_10_15_54.sql.gz";
//$solonome_file = $backup_file_name;

/*if (is_file($allegato)) {
echo "<br>File ok<br>";
}
*/
//$mail->AddAddress($mail_destinatario);
foreach($array_mail as $sing_mail) {
$mail->AddAddress($sing_mail);
}
//$mail->AddBcc("diego.sala@publiem.it");
//$mail->AddBcc("luigi.riva@dtpc.it");
//$mail->AddBcc("b.boncompagni@sol.it");
//}
$mail->WordWrap = 50;  // set word wrap to 50 characters
$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $messaggio_resp;
if ($ok_resp != "") {
$mail->AltBody = "Invio comunicazione PL ".$n_pl." da spedire";
}

//if ($mail_destinatario != "") {
if(!$mail->Send()) {
   echo "Le email non possono essere spedite a causa di: " . $mail->ErrorInfo;
   $causa = $mail->ErrorInfo;
$esito = "NO";
//   exit;
} else {
$esito = "OK";
//echo "<span class=nero_grassettosx12>Email correttamente inviata></span><br>";
}
/*} else {
echo $indirizzo_mancante."<br>";
echo "<input name=button type=button onClick=window.close() value=OK>";
exit;
}
*/
//inserimento in db della mail appena spedita
foreach($array_mail as $mail_destinatario) {
  $data_attuale = mktime();
  $messaggio_resp = addslashes($messaggio_resp);
  $queryb = "INSERT INTO qui_mail_inviate (data, mittente, destinatario, messaggio, esito, causa_fallimento) VALUES ('$data_attuale', '$mail_inviante', '$mail_destinatario', '$messaggio_resp', '$esito', '$causa')";
  if (mysql_query($queryb)) {
  } else {
  echo "Errore durante l'inserimento". mysql_error();
  }
}
//**************************
//fine routine x email
//**************************

?>