<?php
	include 'fun.php';
	$sedi = tellMeSedi();
?>
<style>
	.site-min-height {
		min-height: calc(100vh - 113px);
	}
</style>
<section class="wrapper site-min-height">
  <div class="row mt">
    <div class="col-lg-12">
      <h4>Nuovo Utente</h4>
      <span id="nuovoutente">
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Username</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="username" placeholder="Username">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password" placeholder="Password">
          </div>
				</div>
				<br>
        <div class="form-group" style="margin-top: 50px;padding-top: 38px;">
          <label class="col-sm-2 col-sm-2 control-label">Ruolo</label>
          <div class="col-sm-10">
            <select id="ruolo">
              <option value="1">Admin</option>
              <option value="2">Utente</option>
            </select>
					</div>
					<div id="isMan" style="padding: 24px;">


					</div>
          <hr>
            <button type="button" class="btn btn-primary btn-sm" onclick="nuovoUtente();return false;">Aggiungi Utente</button>
        </div>
      </span>
    </div>
  </div>

</section>

<?php
	$testsedi = '';
	foreach ($sedi as $s) {
		// echo '<option value="' . $s['codice'] . '">' . $s['nome'] . '</option>';
		$testsedi = $testsedi . '<option value="' . $s['codice'] . '">' . addslashes($s['nome']) . '</option>';
	}
?>
<script>
	var testate = '<?php echo $testsedi;?>';
	var scripts = '<script> $("#SELECTsedi").chosen({width: "100%",allow_single_deselect: true,placeholder_text: "Seleziona Sede",max_selected_options: 25,no_results_text: "Sede non trovata: "}); <\/script>';
	var testosedi = '<select id="SELECTsedi" class="sedi" multiple="" > ' + testate + ' </select>' + scripts;

	function retdati(){
		var utente = document.getElementById('username').value;
		var password = document.getElementById('password').value;
		var ruolo = document.getElementById('ruolo').value;
		if($('#ruolo').val() == 2){
			var sedi = $('#SELECTsedi').val();
			var datincl = [utente,password,ruolo, sedi];
		}else{
			var datincl = [utente,password,ruolo];
		}
		return datincl;
	}

	function nuovoUtente(){
		var dato = new Array();
		dato[0] = retdati();
		var r = confirm("Aggiungere " + dato[0][0] +  "?")
		if (r) {
			$.post('parts/pages/utenteaggiunto.php', {
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
