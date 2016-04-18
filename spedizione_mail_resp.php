<?php
// copia il contenuto di un file in una stringa
function leggifile($filename){
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
return $contents;
}
//fine funzione
$messaggio_resp=leggifile("quice_email_template_buyer.html");
//echo "messaggio: ".$messaggio."<br>";
switch($lingua) {
case "it":
$testo_mail_responsabile = "E-mail responsabile";
$testo_mail_buyer = "E-mail buyer";
break;
case "en":
$testo_mail_responsabile = "Manager E-mail";
$testo_mail_buyer = "Buyer E-mail";
break;
}

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
$tx_html .= "</body>";
$tx_html .= "</html>";

//accodamento parte dinamica tabellina righe rda
$messaggio_resp .= $tx_html;

$oggetto = $oggetto_invio." ".$id_rda;
//**********************************************************************
//SEZIONE SPEDIZIONE EMAIL
//**********************************************************************
$mittente = "server@sol.it";
require("PHPMailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP

$mail->Host = "10.0.1.148";  // specify main and backup server

$mail->From = $mittente;
$mail->FromName = "Qui c'e' - ".$negozio_rda." - ".stripslashes($_SESSION[nome]);
$dataora = mktime();
//echo "mail=> fin qui ok<br>";
//$mail->AddAddress($mail_destinatario);
foreach($array_mail_buyer as $sing_mail) {
$mail->AddAddress($sing_mail);
}
$mail->AddBcc("diego.sala@publiem.it");
$mail->AddBcc("luigi.riva@publiem.it");
//if ($negozio_rda == "Labels") {
$mail->AddBcc("mara.girardi@publiem.it");
//}
//$mail->AddBcc("b.boncompagni@sol.it");
//}
$mail->WordWrap = 50;  // set word wrap to 50 characters
$mail->AddAttachment($allegato); // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail->IsHTML(true); // set email format to HTML

$mail->Subject = $oggetto;
$mail->Body    = $messaggio_resp;
$mail->AltBody = "Invio RdA ".$id." al buyer";

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
//inserimento in db della mail appena spedita
$data_attuale = mktime();
$messaggio_resp = addslashes($messaggio_resp);
$queryb = "INSERT INTO qui_mail_inviate (data, mittente, destinatario, messaggio, esito, causa_fallimento) VALUES ('$data_attuale', '$mail_inviante', '$mail_destinatario', '$messaggio_resp', '$esito', '$causa')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
$mail_destinatario = "";
//**************************
//fine routine x email resp
//**************************

//VECCHIA PROCEDURA se c'è qualche etichetta che dobbiamo stampare noi
/*if ($ord_stamp > 0) {
$messaggio_resp=leggifile("quice_email_template.html");
$array_mail = array("mara.girardi@publiem.it");
foreach($array_mail as $ogni_mail) {
$mail_destinatario .= $ogni_mail.";";
}
//echo "mail_destinatario: ".$mail_destinatario."<br>";
//echo "fin qui tutto bene<br>";

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
//SEZIONE SPEDIZIONE EMAIL A MARA

$mail2 = new PHPMailer();

$mail2->IsSMTP();                                      // set mailer to use SMTP
$mail2->Host = "10.0.1.148";  // specify main and backup server
$mail2->From = $mittente;
$mail2->FromName = "Qui c'e' - ".stripslashes($_SESSION[nome])." - Etichette da stampare";
$dataora = mktime();
foreach($array_mail as $sing_mail) {
$mail2->AddAddress($sing_mail);
}
$mail2->AddBcc("diego.sala@publiem.it");
$mail2->AddBcc("luigi.riva@dtpc.it");
//}
$mail2->WordWrap = 50;  // set word wrap to 50 characters
$mail2->AddAttachment($allegato); // add attachments
//$mail2->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
$mail2->IsHTML(true); // set email format to HTML

$mail2->Subject = $oggetto;
$mail2->Body    = $messaggio_resp;
$mail2->AltBody = "Invio RdA ".$id;

if(!$mail2->Send()) {
   echo "Le email non possono essere spedite a causa di: " . $mail->ErrorInfo;
   $causa = $mail->ErrorInfo;
$esito = "NO";
//   exit;
} else {
$esito = "OK";
//echo "<span class=nero_grassettosx12>Email correttamente inviata></span><br>";
}
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
//fine routine x email a Mara
//**************************

}
*/
?>