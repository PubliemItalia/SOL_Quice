  <div style="width: 100%; min-height: 70px; overflow:hidden; height: auto; background-color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; border-top:1px solid #000; color: rgb(0,0,0);">
    <div style="width: 45%; height: 50px; float: left; padding:10px;">
	  <?php 

		echo "<strong>".$file_presente."</strong><br>";
		echo "<strong>".stripslashes(stripslashes($_SESSION[nome]))."</strong><br>".stripslashes($_SESSION[nomeunita]);
		switch ($_SESSION[ruolo]) {
		case "utente":
		switch ($_SESSION[lang]) {
		case "it":
		$role = "utente";
		break;
		case "en":
		$role = "user";
		break;
		}
		break;
		case "responsabile":
		switch ($_SESSION[lang]) {
		case "it":
		$role = "responsabile";
		break;
		case "en":
		$role = "manager";
		break;
		}
		break;
		case "admin":
		switch ($_SESSION[lang]) {
		case "it":
		$role = "admin";
		break;
		case "en":
		$role = "admin";
		break;
		}
		break;
		}
		if ($_SESSION[negozio_buyer] != "") {
				  $role = "buyer";
		}
		 echo "<br><strong>".ucfirst($role)."</strong>";
		 if ($_SESSION[ruolo] == "utente") {
			  switch ($_SESSION[lang]) {
			  case "it":
		 echo "<br>Responsabile ";
			  break;
			  case "en":
		 echo "<br>Manager ";
			  break;
			  }
		 echo $_SESSION[nome_resp];
		 }
		 echo "<span>";
       //    echo "<br><strong>".ucfirst($_SESSION[ruolo])."</strong>";
	  ?>
    </div>
    <div style="width: 45%; height: 40px; float: right; padding:35px 0px 0px 0px;">
      <div style="cursor:pointer; float:right; margin-right:20px;" onClick="window.close();">
          Torna al Qui C&acute;&egrave;
      </div>
    </div>
  </div>
  <?php
	$padding_menu_nav = '10px 0px 0px 10px';
	$padding_testata = '10px 0px 0px 20px';
	switch ($file_presente) {
		case "menu_interm.php":
		  $colore_sfondo = '#003c80';
		  $padding_testata = '10px 0px 0px 130px';
		  $navigazione = '<div style="float:left; padding: '.$padding_testata.';">Amministrazione</div>';
		break;
		case "report_fatturazione.php":
		case "ordini_sap.php":
		case "ordini.php":
		  $colore_sfondo = '#F63';
		  if ($file_presente == "report_fatturazione.php") {
			switch ($doc) {
				case "G":
				  $colore_giroc = $colore_sfondo;
				  $colore_fatt = "#000";
				break;
				case "F":
				  $colore_fatt = $colore_sfondo;
				  $colore_giroc = "#000";
				break;
			}
		  } else {
			  $colore_fatt = "#000";
			  $colore_giroc = "#000";
		  }
		  if ($file_presente == "ordini_sap.php") {
			  $colore_ord_sap = $colore_sfondo;
		  } else {
			  $colore_ord_sap = "#000";
		  }
		  if ($file_presente == "ordini.php") {
			  $colore_ord = $colore_sfondo;
		  } else {
			  $colore_ord = "#000";
		  }
		  $sottomenu = '<a href="report_fatturazione.php?doc=G"><div style="cursor:pointer; padding: 10px; float:left; border-right:1px solid #000; color:'.$colore_giroc.';">
						  Giroconti
						</div></a>
						<a href="report_fatturazione.php?doc=F"><div style="cursor:pointer; padding: 10px; float:left; border-right:1px solid #000; color:'.$colore_fatt.';">
						  Fatture
						</div></a>
						<a href="ordini_sap.php"><div style="cursor:pointer; padding: 10px; float:left; border-right:1px solid #000; color:'.$colore_ord_sap.';">
						  Ordini SAP
						</div></a>
						<a href="ordini.php"><div style="cursor:pointer; padding: 10px; float:left; border-right:1px solid #000; color:'.$colore_ord.';">
						  Ordini Fornitore
						</div></a>';
		  $navigazione = '<a href="menu_interm.php"><div style="float:left; padding: '.$padding_testata.';">Amministrazione</div></a><div style="float:left; padding: '.$padding_menu_nav.';">>></div><div style="float:left; padding: '.$padding_menu_nav.';">Contabilit&agrave;</div>';
		  if (isset($tipo_documento)) {
			$navigazione .= '<div style="float:left; padding: '.$padding_menu_nav.';">>></div><div style="float:left; padding: '.$padding_menu_nav.';">'.$tipo_documento.'</div>';
		  }
		break;
		case "report_righe_admin.php":
		case "report_rda.php":
		case "report_scorte_magazzino.php":
		case "lista_pl.php":
		  $colore_sfondo = '#06F';
		  if ($file_presente == "report_righe_admin.php") {
			  $colore_righe = $colore_sfondo;
		  } else {
			  $colore_righe = "#000";
		  }
		  if ($file_presente == "lista_pl.php") {
			  $colore_pl = $colore_sfondo;
		  } else {
			  $colore_pl = "#000";
		  }
		  if ($file_presente == "report_rda.php") {
			  $colore_rda = $colore_sfondo;
		  } else {
			  $colore_rda = "#000";
		  }
		  if ($file_presente == "report_scorte_magazzino.php") {
			  $colore_scorte = $colore_sfondo;
		  } else {
			  $colore_scorte = "#000";
		  }
		  $sottomenu = '<a href="report_righe_admin.php"><div style="cursor:pointer; padding: 10px; float:left; border-right:1px solid #000; color:'.$colore_righe.';">
						  Report Righe
						</div></a>
						<a href="report_rda.php"><div style="cursor:pointer; padding: 10px; float:left; border-right:1px solid #000; color:'.$colore_rda.';">
						  Report RdA
						</div></a>
						<a href="lista_pl.php"><div style="cursor:pointer; padding: 10px; float:left; border-right:1px solid #000; color:'.$colore_pl.';">
						  Report Packing List
						</div></a>
						<a href="report_scorte_magazzino.php"><div style="cursor:pointer; padding: 10px; float:left; border-right:1px solid #000; color:'.$colore_scorte.';">
						  Gestione Scorte
						</div></a>';
		  $navigazione = '<a href="menu_interm.php"><div style="float:left; padding: '.$padding_testata.';">Amministrazione</div></a><div style="float:left; padding: '.$padding_menu_nav.';">>></div><div style="float:left; padding: '.$padding_menu_nav.';">Reportistica</div>';
		break;
	}
//echo '<span style="color:#000;">file_presente: '.$file_presente.'<br>';
//echo 'colore_evid: '.$colore_evid.'</span><br>';
?>
  <div style="width: 100%; float: left; height: 40px; background-color:<?php echo $colore_sfondo; ?>; color: #fff; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <?php echo $navigazione; ?>
  </div>
  <div style="width: 100%; float: left; height: 60px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:16px; margin-top:5px;">
    <?php echo $sottomenu; ?>
  </div>
