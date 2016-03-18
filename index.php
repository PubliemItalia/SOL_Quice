<?php 
session_start();
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);
require('query.php');
mysql_set_charset("utf8"); //settare la codifica della connessione al db

if ($_POST['IDUser'] == "") {
$riepilogo = "tentativo di login da nessun utente ";
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riepilogo) VALUES ('nessun id', '$datalogtx', '$datalog', 'login','$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}

/*$pagina = "pippo.php";
echo "Non sei stato riconosciuto come utente di quice: per accedere <a href=".$pagina.">clicca qui!</a>";
exit;
*/
} else {
//$riepilogo = "tentativo di login da ".addslashes($_POST[nome])." - ".$_POST[IDUser]." - ".$_POST[IDResp]." - ".$_POST[posta]." - ".addslashes($_POST[login])." - ".addslashes($_POST[idlocalita])." - ".$_POST[idunita]." - ".addslashes($_POST[indirizzo])." - ".$_POST[CAP]." - ".addslashes($_POST[localita])." - ".addslashes($_POST[company])." - "addslashes($_POST[nazione])." - ".addslashes($_POST[nomeunita]);
$datalog = mktime();
$datalogtx = date("d.m.Y H:i",$datalog);
$queryb = "INSERT INTO qui_log_utenti (operatore, datatx, data, tabella, riepilogo) VALUES ('$_POST[IDUser]', '$datalogtx', '$datalog', 'login','$riepilogo')";
if (mysql_query($queryb)) {
} else {
echo "Errore durante l'inserimento". mysql_error();
}
 	$sqlz = "SELECT * FROM connessione_server_anagrafiche";
	$risultz = mysql_query($sqlz) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigaz = mysql_fetch_array($risultz)) {
		if ($rigaz[type] == "servername") {
		  $mssql_servername = $rigaz[value];
		}
		if ($rigaz[type] == "username") {
		  $mssql_username = $rigaz[value];
		}
		if ($rigaz[type] == "password") {
		  $mssql_password = $rigaz[value];
		}
		if ($rigaz[type] == "database") {
		  $mssql_database = $rigaz[value];
		}
	}
	// CONNESSIONE AL DATABASE DELLA INTRANET
  $conn = mssql_connect($mssql_servername, $mssql_username, $mssql_password);
  
  // Check connection
  if (!$conn) {
	  die("Connection failed: " . mssql_get_last_message());
  }
  //echo "Connected successfully<br>";
  mssql_select_db($mssql_database,$conn);
  
  //AGGIORNAMENTO DELLE COMPANY
//Declare the SQL statement that will query the database
  $query4 = 'SELECT * FROM [tcompany]';
//Execute the SQL query and return records
$result = mssql_query($query4)
	or die('A error occured: ' . mssql_error());
//Show result
	while ( $row = mssql_fetch_array($result) ) {
	$company = iconv("Latin1","UTF-8",$row["Company"]);
	include "query.php";
	mysql_set_charset("utf8"); //settare la codifica della connessione al db
	$queryz = "SELECT * FROM qui_company WHERE IDCompany = '$row[IDCompany]'";
	  $resultz = mysql_query($queryz);
	  $presenza_company = mysql_num_rows($resultz);
	  if ($presenza_company > 0) {
		$query = "UPDATE qui_company SET IDCompany = '$row[IDCompany]', Company = '$company', Ordine = '$row[Ordine]', CodSAP = '$row[CodSAP]', IDNazione = '$row[IDNazione]', Prefisso = '$row[Prefisso]' WHERE IDCompany = '$row[IDCompany]'"; 
		if (mysql_query($query)) {
		} else {
		echo "Errore durante l'inserimento3". mysql_error();
		}
	  } else {
		$queryss = "INSERT INTO qui_company (IDCompany, Company, Ordine, CodSAP, IDNazione, Prefisso) VALUES ('$row[IDCompany]', '$company', '$row[Ordine]', '$row[CodSAP]', '$row[IDNazione]', '$row[Prefisso]')";
		if (mysql_query($queryss)) {
		} else {
		  echo "Errore durante l'inserimento1". mysql_error();
		}
	  }
	}

	
}
/*echo 'user_id = ' . $_POST[IDUser] . "<br>";
echo 'posta = ' . $_POST[posta] . "<br>";
echo 'login = ' . $_POST[login] . "<br>";
echo 'nome = ' . $_POST[nome] . "<br>";
echo 'idunita = ' . $_POST[idunita] . "<br>";
echo 'nomeunita = ' . $_POST[nomeunita] . "<br>";
*/
if (!isset($_SESSION[lang])) {
$_SESSION[lang] = "it";
}
if ((isset($_POST[mod_lang])) AND ($_POST[lang] != "")) {
$_SESSION[lang] = $_POST[lang];
}
if ((isset($_GET[mod_lang])) AND ($_GET[lang] != "")) {
$_SESSION[lang] = $_GET[lang];
}
$lingua = $_SESSION[lang];
$ingresso = $_POST['ingresso'];
//echo "ingresso: ".$ingresso."<br>";
//echo "user id: ".$_POST['IDUser']."<br>";
//echo "IDResp: ".$_POST['IDResp']."<br>";
//echo "idunita: ".$_POST['idunita']."<br>";
include "functions.php";
if ($_POST['IDUser'] != "") {
$user_id = $_POST['IDUser'];
  //RECUPERO INFO UTENTE
//se è un utente della SOL (non publiem)
if ($user_id < 10000) {
	  $query4 = "SELECT * FROM [nomi] WHERE ID = '$user_id'";
	//Execute the SQL query and return records
	$result = mssql_query($query4)
		or die('A error occured: ' . mssql_error());
	//Show result
	while ( $row = mssql_fetch_array($result) ) {
	  $login = addslashes(iconv("Latin1","UTF-8",$row["Login"]));
	  $nome = addslashes(iconv("Latin1","UTF-8",$row["Nome"]).' '.iconv("Latin1","UTF-8",$row["Cognome"]));
	  $posta = addslashes($row["Posta"]);
	  $idlocalita = addslashes($row["IDLocalita"]);
	  $idunita = addslashes($row["IDUnit"]);
	  $resp_utente = addslashes($row["Resp"]);
	  //RECUPERO INDIRIZZO
		$query0 = "SELECT * FROM [tLocalita] WHERE IDLocalita = '$idlocalita'";
		//Execute the SQL query and return records
		$result0 = mssql_query($query0)
			or die('A error occured: ' . mssql_error());
		//Show result
		while ( $row0 = mssql_fetch_array($result0) ) {
		  $indirizzo = addslashes(iconv("Latin1","UTF-8",$row0["Indirizzo"]));
		  $CAP = addslashes($row0["CAP"]);
		  $localita = addslashes(iconv("Latin1","UTF-8",$row0["Localita"]));
		  $IDnazione = addslashes(iconv("Latin1","UTF-8",$row0["Nazione"]));
			//RECUPERO NAZIONE
			$query5 = "SELECT * FROM [tNazioni] WHERE IDnazione = '$IDnazione'";
		  //Execute the SQL query and return records
		  $result5 = mssql_query($query5)
			  or die('A error occured: ' . mssql_error());
		  //Show result
		  while ( $row3 = mssql_fetch_array($result5) ) {
			$nazione = addslashes(iconv("Latin1","UTF-8",$row3["Nazione"]));
		  }
		}
	  //RECUPERO UNITA'
	  $sql2 = "SELECT * FROM [unità] WHERE IDUnit = '$idunita'";
	  $sql2 = iconv("UTF-8","Latin1",$sql2);
	  //Execute the SQL query and return records
	  $query2 = mssql_query($sql2)
		  or die('A error occured: ' . mssql_error());
	  //Show result
	  while ( $row1 = mssql_fetch_array($query2) ) {
		  $IDCompany = $row1["IDCompany"];
		  $nomeunita = addslashes($row1['Codice']);
		  $descrunita = addslashes($row1['Unit']);
		  $company = addslashes($row1['CodSAP']);
			//RECUPERO RESPONSABILE
			$query5 = "SELECT * FROM [tResp] WHERE IDUnit = '$idunita' AND Diretto = '1'";
		  //Execute the SQL query and return records
		  $result5 = mssql_query($query5)
			  or die('A error occured: ' . mssql_error());
		  //Show result
		  while ( $row3 = mssql_fetch_array($result5) ) {
			$IDResp = $row3['IDResp'];
		  }
		  //RECUPERO COMPANY
		  $query4 = "SELECT * FROM [tcompany] WHERE IDCompany = '$IDCompany'";
		//Execute the SQL query and return records
		$result = mssql_query($query4)
			or die('A error occured: ' . mssql_error());
		//Show result
		while ( $row2 = mssql_fetch_array($result) ) {
		  $companyName = iconv("Latin1","UTF-8",$row2["Company"]);
  /*  
	*/
		}
	  }
	}
	//RECUPERO INFO RESPONSABILE
	  $query6 = "SELECT * FROM [nomi] WHERE ID = '$IDResp'";
	//Execute the SQL query and return records
	$result6 = mssql_query($query6)
		or die('A error occured: ' . mssql_error());
	//Show result
	while ( $row6 = mssql_fetch_array($result6) ) {
	  $nome_agg_resp = addslashes(iconv("Latin1","UTF-8",$row6["Nome"]).' '.iconv("Latin1","UTF-8",$row6["Cognome"]));
	  $posta_agg_resp = addslashes($row6["Posta"]);
	}
	/*
  */  
  //Free result set memory
  mssql_free_result($result);
  //Close the connection
  mssql_close($dbhandle);
//*********************************  
//GESTIONE ECCEZIONI RESPONSABILI
//nella tabella ci sono gli utenti di cui vanno sostituiti i responsabili (sono gli unici record di cui è indicato l'id utente)
if ($user_id != 0) {
  $cc = "SELECT * FROM conversione_responsabili WHERE id_utente = '$user_id'";
  $risultcc = mysql_query($cc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $presenzaUtente = mysql_num_rows($risultcc);
  if ($presenzaUtente > 0) {
	  $eccezione = 1;
	while ($rigacc = mysql_fetch_array($risultcc)) {
	  $IDResp = $rigacc[id_sost];
	}
  }
}
//nella tabella ci sono i responsabili da sostituire 1 a 1 e solo quando l'id utente è = a 0 (non è indicato)
  $dd = "SELECT * FROM conversione_responsabili WHERE id_resp = '$IDResp' AND id_utente = '0'";
  $risultdd = mysql_query($dd) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $presenzaResp = mysql_num_rows($risultdd);
  if ($presenzaResp > 0) {
	  $eccezione = 1;
	while ($rigadd = mysql_fetch_array($risultdd)) {
	  $IDResp = $rigadd[id_sost];
	}
  }
/*
*/  
//nella tabella è indicato il nome unità eccez (non preciso, è un gruppo di unità che contioene il codice) ma non id unità eccez e id resp; vado a prendere il responsabili da sostituire
  $ee = "SELECT * FROM conversione_responsabili WHERE nome_unita_eccez != '' AND id_unita_eccez = '0' AND id_resp = '0'";
  $risultee = mysql_query($ee) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $presenzaUnit = mysql_num_rows($risultee);
  if ($presenzaUnit > 0) {
	  $eccezione = 1;
	while ($rigaee = mysql_fetch_array($risultee)) {
		if (strpos($nomeunita, $rigaee[nome_unita_eccez]) !== false) {
			$IDResp = $rigaee[id_sost];
		}
	}
  }
//nella tabella è indicato L'ID unità eccez; vado a prendere il responsabili da sostituire
if ($idunita != 0) {
  $ff = "SELECT * FROM conversione_responsabili WHERE id_unita_eccez = '$idunita'";
  $risultff = mysql_query($ff) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $presenzaIDUnit = mysql_num_rows($risultff);
  if ($presenzaIDUnit > 0) {
	  $eccezione = 1;
	while ($rigaff = mysql_fetch_array($risultff)) {
	  $IDResp = $rigaff[id_sost];
	}
  }
}

//*********************************
} else {
//se invece è un utente publiem
$hh = "SELECT * FROM qui_utenti WHERE user_id = '$user_id'";
$risulthh = mysql_query($hh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigah = mysql_fetch_array($risulthh)) {
  $posta = $rigah[posta];
  $login = $rigah[login];
  $nome = $rigah[nome];
  $idlocalita = $rigah[idlocalita];
  $idunita = $rigah[idunita];
  $IDCompany = $rigah[IDCompany];
  $companyName = $rigah[companyName];
  $nomeunita = $rigah[nomeunita];
  $nazione = $rigah[nazione];
  $IDResp = $rigah[idresp];
  $indirizzo = $rigah[indirizzo];
  $CAP = $rigah[cap];
  $localita = $rigah[localita];
  $company = $rigah[company];
  }
}

//	indirizzo	cap	company	localita	nazione	idresp	ruolo
   $_SESSION[user_id]=$_POST[IDUser];
    $_SESSION[posta]=$posta;
	$_SESSION[login]=$login;
	$_SESSION[nome]=$nome;
	$_SESSION[idlocalita]=$idlocalita;
	$_SESSION[idunita]=$idunita;
	$_SESSION[IDCompany]=$IDCompany;
	$_SESSION[companyName]=$companyName;
	$_SESSION[nomeunita]=$nomeunita;
	$_SESSION[nazione]=$nazione;
  $_SESSION[IDResp]=$IDResp;
	$_SESSION[indirizzo]=$indirizzo;
	$_SESSION[CAP]=$CAP;
	$_SESSION[localita]=$localita;
	$_SESSION[company]=$company;
	
	
//$login = addslashes($_POST['login']);
$pagina = "main.php";
$jj = "SELECT * FROM qui_utenti WHERE user_id = '$IDResp'";
$risultjj = mysql_query($jj) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigaj = mysql_fetch_array($risultjj)) {
  $nome_agg_resp = addslashes($rigaj[nome]);
	  $posta_agg_resp = $rigaj[posta];
  }

 // if ($user_id != $IDResp) {
	  //ogni utente che entra aggiorna il suo responsabile
	  //per cui vado a prendere i dati che mi servono e che recupero grazie all'id_responsabile che mi arriva con l'utente
//if ($eccezione != 1) {
/*	$array_id_CA = array(433,434,435);
	$pos_CA = stripos($nomeunita,"/CA");
	if ($pos_CA !== false) {
	  if (!in_array($idunita,$array_id_CA)) {
		$add_CA_id = array_push($array_id_CA,$idunita);
	  }
		$IDCompany = 48;
	}*/
  $pp = "SELECT * FROM qui_unita WHERE id_unita = '$idunita'";
  $risultpp = mysql_query($pp) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  $unita_presente = mysql_num_rows($risultpp);
if ($unita_presente > 0) {
  //if (!in_array($idunita,$array_id_CA)) {
  $querys = "UPDATE qui_unita SET nome_resp = '$nome_agg_resp', posta = '$posta_agg_resp', id_resp = '$IDResp', IDCompany = '$IDCompany', descrizione = '$descrunita' WHERE id_unita = '$idunita'";
  //} else {
  //$querys = "UPDATE qui_unita SET nome_resp = '$nome_agg_resp', posta = '$posta_agg_resp', id_resp = '$IDResp', descrizione = '$descrunita' WHERE id_unita = '$idunita'";
  //}
	if (mysql_query($querys)) {
	} else {
	  echo "Errore durante l'inserimento5: ".mysql_error();
	}
  } else {
	$queryx = "INSERT INTO qui_unita (id_unita, nome_unita, id_resp, nome_resp, posta, IDCompany, descrizione) VALUES ('$idunita', '$nomeunita', '$IDResp', '$nome_agg_resp', '$posta_agg_resp', '$IDCompany', '$descrunita')";
	if (mysql_query($queryx)) {
	} else {
	  echo "Errore durante l'inserimento10". mysql_error();
	}
  }
//}
/*
  } else {
	$dd = "SELECT * FROM qui_unita WHERE id_unita = '$idunita'";
	$risultdd = mysql_query($dd) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	while ($rigadd = mysql_fetch_array($risultdd)) {
	$IDResp = $rigadd[id_resp];
	  }
  }
*/  
//$array_resp_buyer = array("161");
//if (($user_id == $IDResp) AND (!in_array($user_id,$array_resp_buyer))) {
$nn = "SELECT * FROM qui_utenti WHERE user_id = '$user_id'";
$risultnn = mysql_query($nn) or die("Impossibile eseguire l'interrogazione" . mysql_error());
while ($rigann = mysql_fetch_array($risultnn)) {
  if ($rigann[ruolo_report] != "") {
	$ruolo = $rigann[ruolo_report];
  } else {
	if ($rigann[ruolo] == "buyer") {
	  $ruolo = "buyer";
	} else {
	  if ($user_id == $IDResp) {
	  $ruolo = "responsabile";
	  } else {
	  $ruolo = "utente";
	  $resp_utente = $rigann['IDResp'];
	  }
	}
  }
  $ruolo_report = $rigann['ruolo_report'];
  $negozio_buyer = addslashes($rigann['negozio_buyer']);
  $negozio2_buyer = addslashes($rigann['negozio2_buyer']);
}
//echo "IDResp: ".$IDResp."<br>";

$_SESSION[negozio_buyer]=$negozio_buyer;	
$_SESSION[negozio2_buyer]=$negozio2_buyer;	
$_SESSION[ruolo]=$ruolo;
$_SESSION[ruolo_report]=$ruolo_report;
//$ruolo = addslashes($_POST['ruolo']);
//$negozio_buyer = addslashes($_POST['negozio_buyer']);
//verifico se esiste il responsabile, altrimenti bisogna avvertire
$rr = "SELECT * FROM qui_utenti WHERE user_id = '$resp_utente'";
$risultrr = mysql_query($rr) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$resp_exist = mysql_num_rows($risultrr);


$hh = "SELECT * FROM qui_utenti WHERE user_id = '$_SESSION[user_id]'";
$risulthh = mysql_query($hh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$num_righe = mysql_num_rows($risulthh);
//echo "Utenti trovati: ".$num_righe."<br>";
if ($num_righe > 0) {
    // Esiste un record con questo id:
//se ho trovato l'utente aggiorno i dati, ma solo se non è un buyer
if ($ruolo != "buyer") {
  //if ($ingresso != "1") {
	$queryv = "UPDATE qui_utenti SET nome = '$nome', posta = '$posta', login = '$login', idlocalita = '$idlocalita', idunita = '$idunita', indirizzo = '$indirizzo', cap = '$CAP', localita = '$localita', company = '$company', companyName = '$companyName', nazione = '$nazione', nomeunita = '$nomeunita', idresp = '$IDResp', IDCompany = '$IDCompany', ruolo = '$ruolo' WHERE user_id = '$user_id'";
	if (mysql_query($queryv)) {
	} else {
	echo "Errore durante l'inserimento5: ".mysql_error();
	}
 // }
  $nn = "SELECT * FROM qui_utenti WHERE user_id = '$IDResp'";
  $risultnn = mysql_query($nn) or die("Impossibile eseguire l'interrogazione" . mysql_error());
  while ($rigann = mysql_fetch_array($risultnn)) {
  $nome_resp = $rigann[nome];
  $_SESSION[nome_resp]=$nome_resp;	
  }
} else {
  //if ($ingresso != "1") {
	$queryv = "UPDATE qui_utenti SET company = '$company', companyName = '$companyName', idresp = '$IDResp' WHERE user_id = '$user_id'";
	if (mysql_query($queryv)) {
	} else {
	echo "Errore durante l'inserimento5: ".mysql_error();
	}
  //}
}
} else {
//echo "non ho trovato l'utente<br>";
//se non ho trovato l'utente lo inserisco
$queryg = "INSERT INTO qui_utenti (user_id, login, nome, posta, idlocalita, idunita, indirizzo, cap, company, localita, nazione, nomeunita, idresp, ruolo, negozio_buyer, companyName, IDCompany) VALUES ('$user_id', '$login', '$nome', '$posta', '$idlocalita', '$idunita', '$indirizzo', '$CAP', '$company', '$localita', '$nazione', '$nomeunita', '$IDResp', '$ruolo', '$negozio_buyer', '$companyName', '$IDCompany')";
if (mysql_query($queryg)) {
} else {
echo "Errore durante l'inserimento10". mysql_error();
}
}
$mm = "SELECT * FROM qui_utenti WHERE user_id = '$user_id'";
$risultmm = mysql_query($mm) or die("Impossibile eseguire l'interrogazione" . mysql_error());
 while ($rigamm = mysql_fetch_array($risultmm)) {
$_SESSION[ruolo] = $rigamm[ruolo];
}
}
$queryc = "SELECT * FROM qui_carrelli WHERE id_utente = '$user_id' AND attivo = '1'";
$resultc = mysql_query($queryc) or die("Impossibile eseguire l'interrogazione" . mysql_error());
$carrelli_attivi = mysql_num_rows($resultc);
if ($carrelli_attivi > 0) {
while ($rowc = mysql_fetch_array($resultc)) {
session_start();
$_SESSION[carrello] = $rowc[id];
$_SESSION[tipo_carrello] = $rowc[negozio];
$id_carrello = $rowc[id];
}
} else {
$_SESSION[carrello] = "";
}
$azione_form = $_SERVER['PHP_SELF'];

$timestamp_attuale = mktime();
$data_attuale = date("d.m.Y H:i", $timestamp_attuale);
$settimana = 1209600;
$data_limite = $timestamp_attuale - $settimana;
$dataLimite_in_basso = 1421485699;
$ff = "SELECT * FROM qui_controlli_rda ORDER BY timestamp_controllo DESC LIMIT 1";
$risultff = mysql_query($ff) or die("Impossibile eseguire l'interrogazione" . mysql_error());
//echo 'data_attuale: '.$data_attuale.'<br>';
//echo 'data_limite: '.$data_limite.'<br>';
//echo 'num_controlli: '.$num_controlli.'<br>';
   while ($rigaff = mysql_fetch_array($risultff)) {
	  $ultimo_timestamp = $rigaff[timestamp_controllo];
	  if (($ultimo_timestamp) < $data_limite) {
		$queryj = "INSERT INTO qui_controlli_rda (timestamp_controllo, data_controllo, user_id, user_name) VALUES ('$timestamp_attuale', '$data_attuale', '$user_id', '$nome')";
		if (mysql_query($queryj)) {
		} else {
		  echo "Errore durante l'inserimento10". mysql_error();
		}
		$array_mail = array();
		  $queryx = "SELECT * FROM qui_rda WHERE stato = '1' AND data_inserimento <= '$data_limite' AND data_ultima_modifica >= '$dataLimite_in_basso'";
		  $resultx = mysql_query($queryx) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		  $rda_dormienti = mysql_num_rows($resultx);
		  //echo 'rda_dormienti: '.$rda_dormienti.'<br>';
		  while ($rigad = mysql_fetch_array($resultx)) {
			$messaggio_resp .= 'RdA n. '.$rigad[id];
			if ($rigad[id_unita] != "") {
			  $queryy = "SELECT * FROM qui_unita WHERE id_unita = '$rigad[id_unita]'";
			  $resulty = mysql_query($queryy) or die("Impossibile eseguire l'interrogazione" . mysql_error());
			  while ($rigay = mysql_fetch_array($resulty)) {
				$resp_unita = $rigay[posta];
				$messaggio_resp .= ' - unit&agrave; '.$nome_unita.' - Resp. '.$nome_resp.' ('.$rigay[posta].')';
				if (!in_array($resp_unita,$array_mail)) {
					$add_mail = array_push($array_mail,$resp_unita);
				}
			  }
			}
			$messaggio_resp .= '<br>';
		  }
		  //echo '<span style="color: #000">';
		  //print_r($array_mail);
		  //echo '</span>';
		  //echo "<br>";
	  }
	}
include "menu_quice3.php";
?>

<html>
<head>
  <title>Quice</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tinybox2/styletiny.css" />
<link rel="stylesheet" href="css/report.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.structure.css" type="text/css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.theme.css" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.sfondo_trasp_modal {
position:fixed; width:100%; height:100%; top:0; left:0; z-index: 99998; opacity:0.5; background-color: #000; display: none;
}
.sfondo_trasp_response {
position:fixed; width:100%; height:100%; top:0; left:0; z-index: 99998; opacity:0.5; background-color: #000; display: block;
}
.finestra_modal {
border-radius: 10px; padding:10px; position:fixed; width:40%; min-height:100px; overflow:hidden; height:auto; top:30%; left:30%; z-index: 99999; background-color: #fff; display: none;
}
.finestra_response {
border-radius: 10px; padding:10px; position:fixed; width:40%; min-height:100px; overflow:hidden; height:auto; top:30%; left:30%; z-index: 99999; background-color: #fff; display: block;
}
.container_modal {
	width:90%;
	min-height:30px; 
	height:auto;
	overflow:hidden; 
	margin:20px auto;
}
.quadrati_home {
	width:90%;
	height:100px; 
	width:100px;
	float: left;
}
-->
</style>
<script type="text/javascript" src="jquery-1.7.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="tinybox.js"></script>
</head>

<?php
//if ($resp_exist == 0) {
//echo '<body onLoad="TINY.box.show({iframe:\'popup_notifica.php?avviso=no_resp&id_utente='.$_SESSION[user_id].'&lang='. $lingua.'\',boxid:\'frameless\',width:400,height:180,fixed:false,maskid:\'bluemask\',maskopacity:40})">';
//} else {
  if ($rda_dormienti > 0) {
$messaggio_resp .= $tx_html;
include "spedizione_mail_dormienti.php";
//echo '<body onLoad="TINY.box.show({iframe:\'controllo_rda_dormienti.php?data_limite='.$data_limite.'&lang='. $lingua.'\',boxid:\'frameless\',width:400,height:180,fixed:false,maskid:\'bluemask\',maskopacity:40})">';
  //} else {
  }
	echo "<body>";
//}
?>

<div id="content-home" style="width:960px; height:400px">
  <div id="ext_sx" style="width: 500px; keight: 400px; float: left;">
  <?php
/*  
	$queryt = "SELECT * FROM qui_home ORDER BY cod ASC";
	$resultt = mysql_query($queryt) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	//echo 'rda_dormienti: '.$rda_dormienti.'<br>';
	while ($rigat = mysql_fetch_array($resultt)) {
	  if ($rigat[link] != "") {
		  echo '<a href="'.$rigat[link].'">';
	  }
	  echo '<div id="'.$rigat[cod].'" class="quadrati_home"><img src="immagini/';
	  if ($rigat[contenuto] != "") {
		switch ($lingua) {
		  case 'it':
			echo $rigat[contenuto];
		  break;
		  case 'en':
			echo $rigat[contenuto_en];
		  break;
		}
	  } else {
		  echo $rigat[contenuto_default];
	  }
	  echo '"></div>';
	  if ($rigat[link] != "") {
		  echo '</a>';
	  }
	}
*/  
  ?>
  </div>
  <div id="ext_dx" style="width: 460px; keight: 380px; float: left;">
  <!--<img src="immagini/img home-E.jpg">-->	
  </div>
</div>
<div id="content-home_assets" style="width:960px; height:380px"> </div>
<div id="content-home_ricambi" style="width:960px; height:380px"> </div>
<div id="content-home_consumabili" style="width:960px; height:380px"> </div>
<div id="content-home_etichette" style="width:960px; height:380px"> </div>
<div id="content-home_vivistore" style="width:960px; height:380px"> </div>
	<!--END CONTENT-->

<script type="text/javascript">
function toggle_modal(id)  {  
   /*alert(id);*/
	$("#sfondo_trasp").fadeToggle(700,"swing");
	$("#modal_wish_carr").fadeToggle(700,"swing");
} 
</script>
</body>
</html>