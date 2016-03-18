<?php
// copia il contenuto di un file in una stringa
function leggifile($filename){
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
return $contents;
}
//fine funzione
//switch ($avviso) {
//case "genera_rda":
$messaggio_resp=leggifile("quice_email_template.html");
//break;
//case "approva_rda_resp":
//$messaggio_resp=leggifile("quice_email_template_buyer.html");
//break;
//}
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
}
$array_mail = array("luigi.riva@dtpc.it","mara.girardi@publiem.it");
foreach($array_mail as $ogni_mail) {
$mail_destinatario .= $ogni_mail.";";
}
echo "mail_destinatario: ".$mail_destinatario."<br>";
echo "fin qui tutto bene<br>";

$messaggio_resp = str_replace("#RdA_information#",$titolo_mail,$messaggio_resp);
$messaggio_resp = str_replace("#Order_detail#",$dettaglio_mail,$messaggio_resp);
$messaggio_resp = str_replace("numero_rda",$id_rda,$messaggio_resp);
$messaggio_resp = str_replace("mail_mittente",$mail_inviante,$messaggio_resp);
$messaggio_resp = str_replace("mail_destinatario",$mail_destinatario,$messaggio_resp);


$messaggio_resp = str_replace("#Order_number:#",$testo_num_rda,$messaggio_resp);
$messaggio_resp = str_replace("#Order_date:#",$testo_data_rda,$messaggio_resp);
$messaggio_resp = str_replace("#E-mail_responsabile:#",$testo_mail_responsabile,$messaggio_resp);
$messaggio_resp = str_replace("#E-mail_buyer:#",$testo_mail_buyer,$messaggio_resp);
$messaggio_resp = str_replace("#Indirizzo_filiale:#",$testo_mail_indirizzo_filiale,$messaggio_resp);
$messaggio_resp = str_replace("#Shop:#",$testo_mail_negozio,$messaggio_resp);
$messaggio_resp = str_replace("data_rda",date("d.m.Y", mktime()),$messaggio_resp);
$messaggio_resp = str_replace("negozio_rda",$negozio_rda,$messaggio_resp);
$messaggio_resp = str_replace("indirizzo_unita",$unita_rda,$messaggio_resp);

//conclusione template x mail
$tx_mara .= "</body>";
$tx_mara .= "</html>";

//accodamento parte dinamica tabellina righe rda
$messaggio_resp .= $tx_mara;

$oggetto = "Etichette da stampare RdA ".$id_rda;
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
$mail->FromName = "Qui c'e' - ".stripslashes($_SESSION[nome])." - Etichette da stampare";
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
foreach($array_mail as $sing_mail) {
$mail->AddAddress($sing_mail);
}
//$mail->AddBcc("diego.sala@publiem.it");
//$mail->AddBcc("luigi.riva@dtpc.it");
//}
$mail->WordWrap = 50;  // set word wrap to 50 characters
$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $messaggio_resp;
$mail->AltBody = "Invio RdA ".$id;

if(!$mail->Send()) {
   echo "Le email non possono essere spedite a causa di: " . $mail->ErrorInfo;
   $causa = $mail->ErrorInfo;
$esito = "NO";
//   exit;
} else {
$esito = "OK";
echo "<span class=nero_grassettosx12>Email correttamente inviata></span><br>";
}
/*} else {
echo $indirizzo_mancante."<br>";
echo "<input name=button type=button onClick=window.close() value=OK>";
exit;
}
*/
//inserimento in db della mail appena spedita
$data_attuale = mktime();
$messaggio_resp = addslashes($messaggio_resp);
include "query.php";
$queryb = "INSERT INTO qui_mail_inviate (data, mittente, destinatario, messaggio, esito, causa_fallimento) VALUES ('$data_attuale', '$mail_inviante', '$mail_destinatario', '$messaggio_resp', '$esito', '$causa')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
//**************************
//fine routine x email
//**************************

?>