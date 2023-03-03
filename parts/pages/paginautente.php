<?php
	include 'fun.php';
	$db = new dbObj();
	$connString = $db->getConnstring();
	$cec = mysqli_query($connString, "SELECT * FROM `login` WHERE login.id = $id ") or die("database error:" . mysqli_error($connString));
	$row = mysqli_fetch_array($cec, MYSQLI_ASSOC);
?>
<style>
  th, tr {
      cursor: pointer;
  }
  tr:hover{
    background: rgba(200,200,200,0.4)
  }
  .site-min-height {
    min-height: calc(100vh - 113px);
  }
</style>
<section class="wrapper site-min-height">
  <h3><i class="fa fa-angle-right"></i> UTENTE <?php echo tellMeUtente($id); ?></h3>
  <div class="row mt">
    <div class="col-lg-12">
      <div class="form-group">
        <label class="col-sm-2 col-sm-2 control-label"><strong>Aggiorna Password</strong></label>
        <div class="col-sm-2 col-sm-2 control-label">
          <input type="password" id="password"class="form-control">
          <span class="help-block">Cambia la password per l'utente.</span>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <button type="button" class="btn btn-primary btn-lg" onclick="modUtente();return false;">Salva</button>
    </div>
  </div>
	<?php
		if($row['role'] == 2){

			$sedi = tellMeSedi();
			$testsedi = '';
			foreach ($sedi as $s) {
					// echo '<option value="' . $s['codice'] . '">' . $s['nome'] . '</option>';
					$testsedi = $testsedi . '<option value="' . $s['codice'] . '">' . addslashes($s['nome']) . '</option>';
			}


			?>
			<script>
				var testate = '<?php echo $testsedi;?>';
				var scripts = '<script> $("#SELECTsedi").chosen({width: "100%",allow_single_deselect: true,placeholder_text: "Seleziona Sede",max_selected_options: 1,no_results_text: "Sede non trovata: "}); <\/script>';
				var testosedi = '<select id="SELECTsedi" class="sedi" multiple="" > ' + testate + ' </select>' + scripts;
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
				inserisciEdEsegui('isMan', testosedi);

			</script>
		<div class="row mt">
			<div class="col-lg-12">
				<div class="form-group">
					<label class="col-sm-12 col-sm-12 control-label"><strong>Aggiorna Sede (CANCELLA PRECEDENTE)</strong></label>
					<div class="col-sm-12 col-sm-12 control-label">
					<div id="isMan" style="padding: 24px;">

					</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<button type="button" class="btn btn-primary btn-lg" onclick="modSedi();return false;">Aggiorna Sede</button>
			</div>
		</div>

		<div class="row mt">
			<div class="col-lg-12">
				<div class="form-group">
					<label class="col-sm-12 col-sm-12 control-label"><strong>Sede Associata</strong></label>
					<div class="col-sm-12 col-sm-12 control-label">
						<div id="sedi" style="padding: 24px;">
							<?php
								$sedis = json_decode($row['sedi']);
								// print_r($sedis);
								if($sedis != ''){
									foreach ($sedis as $s) {
										echo '<h4>';
										echo tellMeSede($s);
										echo '</h4>';
									}
								}else{
									echo '<h4> Nessuna sede associata </h4>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>


	<?php	}?>
</section>
<script>
	function retdati(){
		var idutente = <?php echo $id;?>;
		var password = document.getElementById('password').value;
		var datincl = [idutente,password];
		return datincl;
	}

	function retSedi(){
		var idutente = <?php echo $id;?>;
		var sedi = $('#SELECTsedi').val();
		var datincl = [idutente,sedi];
		return datincl;
	}

	function modSedi(){
		var dato = new Array();
		dato[0] = retSedi();
		var r = confirm("Aggiornare l'utente ?")
		if (r) {
			$.post('parts/pages/modsediutente.php', {
				dati: dato
			}, function(data) {
				$("#main-content").html(data).show();
			});
		}

	}

	function modUtente(){
		var dato = new Array();
		dato[0] = retdati();
		var r = confirm("Aggiornare l'utente ?")
		if (r) {
			$.post('parts/pages/modutente.php', {
				dati: dato
			}, function(data) {
				$("#main-content").html(data).show();
			});
		}

	}

</script>