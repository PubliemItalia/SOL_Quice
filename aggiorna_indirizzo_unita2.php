<?php
session_start();
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$id = $_GET['id'];
$mode = $_GET['mode'];
switch ($mode) {
	case "unita":
	  $sqlq = "SELECT * FROM qui_company WHERE id = '$id'";
	  $risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaq = mysql_fetch_array($risultq)) {
			  if ($rigaq[denominazione] != "") {
				$indirizzo_originario = '<strong>'.stripslashes($rigaq[denominazione]).'</strong><br>';
			  if ($rigaq[denominazione2] != "") {
				$indirizzo_originario .= stripslashes($rigaq[denominazione2]).'<br>';
			  }
				$indirizzo_originario .= stripslashes($rigaq[indirizzo]).'<br>';
				$indirizzo_originario .= stripslashes($rigaq[cap]).' ';
				$indirizzo_originario .= stripslashes($rigaq[localita]).'<br>';
				$indirizzo_originario .= stripslashes($rigaq[nazione]);
			  } else {
				$indirizzo_originario = $rigaq[Company];
			  }
		   //$indirizzo_originario .= '<br>('.$rigaq[nomeunita].')<br>'.$rigaq[indirizzo].'<br>'.$rigaq[cap].' '.$rigaq[localita].'<br>('.$rigaq[nazione].')';
	  }
	break;
	case "sped":
	  $sqlq = "SELECT * FROM qui_tBMC_Clienti WHERE id = '$id'";
	  $risultq = mysql_query($sqlq) or die("Impossibile eseguire l'interrogazione" . mysql_error());
	  while ($rigaq = mysql_fetch_array($risultq)) {
		  //$indirizzo_originario = $rigaq[DescrInd];
		   $indirizzo_originario .= $rigaq[NAME1].'<br>'.$rigaq[STRAS].'<br>'.$rigaq[PSTLZ].' '.$rigaq[ORT01].' ('.$rigaq[LAND1].')<br>'.$rigaq[KUNNR];
	  }
	break;
}
  
//output finale
echo $indirizzo_originario;
 ?>
