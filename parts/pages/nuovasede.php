<?php
  include 'fun.php';
  
?>
<style>
	.site-min-height {
		min-height: calc(100vh - 113px);
	}
</style>
<section class="wrapper site-min-height">
  <div class="row mt">
    <div class="col-lg-12">
      <h4>Nuova Sede</h4>
        <div class="form-group">
          <div class="col-sm-10">
            <input type="text" class="form-control" id="codice" placeholder="CODICE">
            <input type="text" class="form-control" id="descrizione" placeholder="DESCRIZIONE">
            <input type="text" class="form-control" id="via" placeholder="VIA">
            <input type="text" class="form-control" id="citta" placeholder="CITTÀ">
            <input type="text" class="form-control" id="numero" placeholder="NUMERO CIVICO ES. 2 o SNC">
            <input type="text" class="form-control" maxlength="2" id="provincia" placeholder="PROVINCIA">
            <input type="text" class="form-control" id="cap" placeholder="CAP">
            <input type="text" class="form-control" id="telefono" placeholder="TELEFONO">
            <input type="text" class="form-control" id="mail" placeholder="MAIL">
            <input type="text" class="form-control" maxlength="2" id="slug" placeholder="SLUG(2 LETTERE, PREFISSO BOLLA)">
            <input type="number" class="form-control" id="progressivo" placeholder="ULTIMO PROGRESSIVO">
          </div>
        <button type="button" class="btn btn-primary btn-sm" onclick="nuovaSede();return false;">Aggiungi Sede</button>
    </div>
  </div>
</div>

</section>

<script>

	function retdati(){
		var codice = document.getElementById('codice').value;
		var descrizione = document.getElementById('descrizione').value;
		var via = document.getElementById('via').value;
		var citta = document.getElementById('citta').value;
		var numero = document.getElementById('numero').value;
		var provincia = document.getElementById('provincia').value;
		var cap = document.getElementById('cap').value;
		var telefono = document.getElementById('telefono').value;
		var mail = document.getElementById('mail').value;
		var slug = document.getElementById('slug').value;
		var progressivo = document.getElementById('progressivo').value;

    var datincl = [codice,descrizione,via,citta,numero,provincia,cap,telefono,mail,slug,progressivo];
    return datincl;
		console.log(datincl) ;
	}

	function nuovaSede(){
		var dato = new Array();
		dato[0] = retdati();
		var r = confirm("Aggiungere " + dato[0][0] +  "?")
		if (r) {
			$.post('parts/pages/sedeaggiunta.php', {
				dati: dato
			}, function(data) {
				$("#main-content").html(data).show();
			});
		}
	}

	function inserisciEdEsegui(id, text) {
    document.getElementById(id).innerHTML = text;
    var scripts = Array.prototype.slice.call(document.getElementById(id).getElementsByTagName("script"));
    for (var i = 0; i < scripts.length; i++) {
			if (scripts[i].src != "") {
				var tag = document.createElement("script");
				tag.src = scripts[i].src;
				document.getElementsByTagName("head")[0].appendChild(tag);
			}
			else {
				eval(scripts[i].innerHTML);
			}
    }
	}

	$(document).on('change', '#ruolo', function() {
		if($('#ruolo').val() == 2){
			inserisciEdEsegui('isMan', testosedi);
		}else{
			$("#isMan")[0].innerHTML = '';
		}
	});


</script>
