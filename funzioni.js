<!-- inizio script per controllo caratteri Form -->
<script language="JavaScript">
		function isSpecialKey(e) {
			var evtobj=window.event? event : e
			return (evtobj.altKey || evtobj.ctrlKey || evtobj.metaKey)
			? true : false
		}
		function ctrl_decimali(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==44 || unicode==46	  // komma, punkt
			) 
			? true : false
		}

				function ctrl_tel(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==43 || unicode==44 || unicode==46 || unicode==20	  // plus, komma, punkt, space
			) 
			? true : false
		}
				function ctrl_cod_pag(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==43 									  // plus, 
				|| (unicode>=65 && unicode<=90)							// A - Z
			) 
			? true : false
		}

		function ctrl_prezzi(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==44 || unicode==46	  // komma, punkt
			) 
			? true : false
			}
		function ctrl_cod_fisc(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| (unicode>=97 && unicode<=122)							// a - z
				|| (unicode>=65 && unicode<=90)							// A - Z
			) 
			? true : false
			}
		function ctrl_cod_fisc_undscore(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==95										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| (unicode>=97 && unicode<=122)							// a - z
				|| (unicode>=65 && unicode<=90)							// A - Z, _
			) 
			? true : false
			}
		function ctrl_solo_num(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
			) 
			? true : false
			}
		function ctrl_solo_num_neg(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==45 || unicode==44									//- ,
			) 
			? true : false
			}
		function ctrl_testonormale(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| (unicode>=97 && unicode<=122)							// a - z
				|| (unicode>=64 && unicode<=90)							// @, A - Z
				|| (unicode>=192 && unicode<=220)							// accentate, umlaut e cediglia maiuscole
				|| (unicode>=224 && unicode<=252)							// accentate, umlaut e cediglia minuscole
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==46 || unicode==45 || unicode==95 	  // punkt, -, _
				|| unicode==32 || unicode==40 || unicode==41	  //space, (, )
			) 
			? true : false
		}
		function ctrl_mail(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| (unicode>=97 && unicode<=122)							// a - z
				|| (unicode>=64 && unicode<=90)							// @, A - Z
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==46 || unicode==45 || unicode==95 	  // punkt, -, _
			) 
			? true : false
		}
		function ctrl_codice(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| (unicode>=97 && unicode<=122)							// a - z
				|| (unicode>=64 && unicode<=90)							// @, A - Z
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==45 || unicode==95 	  					// @, -, _
			) 
			? true : false
		}
		function ctrl_alfanum_spazi(e) {
			var unicode=e.charCode? e.charCode : e.keyCode
			if (isSpecialKey(e)) return true
			return (
				(unicode>=48 && unicode<=57)							// 0 - 9
				|| unicode>60000												// arrow-keys, enf
				|| unicode<14										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| unicode==95										// backspace=8, tab=9, Enter=13, Enter (Numblock)=3
				|| (unicode>=97 && unicode<=122)							// a - z
				|| (unicode>=65 && unicode<=90)							// A - Z
				|| unicode==32											//space
			) 
			? true : false
			}
</script>