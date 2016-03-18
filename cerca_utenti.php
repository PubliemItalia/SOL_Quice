<?php 
include "query.php";
mysql_set_charset("utf8"); //settare la codifica della connessione al db
$q = $_GET['term'];
	$tendina_utenti = '<select name="IDUser" class="campi" id="IDUser" onChange="aggiorna()">';
	$x = 1;
	$sqlt = "SELECT * FROM qui_utenti WHERE nome LIKE '%".$q."%' ORDER BY nome ASC";
    $risultt = mysql_query($sqlt) or die("Impossibile eseguire l'interrogazione9" . mysql_error());
	$trovati = mysql_num_rows($risultt);
    while ($rigat = mysql_fetch_array($risultt)) { 
	if ($x == 1) {
	  $tendina_utenti .= '<option selected value="'.$rigat[user_id].'">'.$rigat[nome].'</option>';
	} else {
	  $tendina_utenti .= '<option value="'.$rigat[user_id].'">'.$rigat[nome].'</option>';
	}
	$user_id = $rigat[user_id];
	}
	$tendina_utenti .= '</select>';
	if ($trovati == 1) {
	  $hh = "SELECT * FROM qui_utenti WHERE user_id = '$user_id'";
		$risulthh = mysql_query($hh) or die("Impossibile eseguire l'interrogazione" . mysql_error());
		$num_righe = mysql_num_rows($risulthh);
		while ($rowh = mysql_fetch_array($risulthh)) {
		$nome = ($rowh['nome']);
		$posta = ($rowh['posta']);
		$idlocalita = ($rowh['idlocalita']);
		$idunita = ($rowh['idunita']);
		$indirizzo = ($rowh['indirizzo']);
		$CAP = ($rowh['cap']);
		$company = ($rowh['company']);
		$localita = ($rowh['localita']);
		$nazione = ($rowh['nazione']);
		$nomeunita = ($rowh['nomeunita']);
		$IDResp = ($rowh['idresp']);
		$ruolo = ($rowh['ruolo']);
		$login = ($rowh['login']);
		$negozio_buyer = ($rowh['negozio_buyer']);
		}
	}

     $output .= '<div class="labels">Utente</div>
              <div id="tendina_user" class="fields">'.$tendina_utenti.'</div>
              <div class="labels">Login</div>
              <div class="fields"><input name="login" type="text" id="login" class="campi" value="'.$login.'"></div>
              <div class="labels">Nome</div>
              <div class="fields"><input name="nome" type="text" id="nome" class="campi" value="'.$nome.'"></div>
              <div class="labels">Mail</div>
              <div class="fields"><input name="posta" type="text" id="posta" class="campi" value="'.$posta.'"></div>
              <div class="labels">ID Località</div>
              <div class="fields"><input name="idlocalita" type="text" id="idlocalita"class="campi" value="'.$idlocalita.'" ></div>
              <div class="labels">ID unità</div>
              <div class="fields"><input name="idunita" type="text" id="idunita" class="campi" value="'.$idunita.'"></div>
              <div class="labels">Indirizzo</div>
              <div class="fields"><input name="indirizzo" type="text" id="indirizzo" class="campi" value="'.$indirizzo.'"></div>
              <div class="labels">C.A.P.</div>
              <div class="fields"><input name="CAP" type="text" id="CAP" class="campi" value="'.$CAP.'"></div>
              <div class="labels">Località</div>
              <div class="fields"><input name="localita" type="text" id="localita" class="campi" value="'.$localita.'"></div>
              <div class="labels">Company</div>
              <div class="fields"><input name="company" type="text" id="company" class="campi" value="'.$company.'"></div>
              <div class="labels">Nazione</div>
              <div class="fields"><input name="nazione" type="text" id="nazione" class="campi" value="'.$nazione.'"></div>
              <div class="labels">Nome unità</div>
              <div class="fields"><input name="nomeunita" type="text" id="nomeunita" class="campi" value="'.$nomeunita.'"></div>
              <div class="labels">ID resp</div>
              <div class="fields"><input name="IDResp" type="text" id="IDResp" class="campi" value="'.$IDResp.'"></div>';
	echo $output;
?>
