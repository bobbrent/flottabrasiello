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
      <h4>Nuovo Piazzale</h4>
        <div class="form-group">
          <div class="col-sm-10">
            <input type="text" class="form-control" id="indirizzo" placeholder="INDIRIZZO COMPLETO Es. VIA SALOMONE, 72 MILANO">
            <input type="text" class="form-control" id="sede" placeholder="SEDE"  autocomplete='on' list='sedi'>
          </div>
        <button type="button" class="btn btn-primary btn-sm" onclick="nuovoPiazzale();return false;">Aggiungi Piazzale</button>
    </div>
  </div>
</div>

</section>

<datalist id="sedi">
  <?
    $sedi = tellMeSedi();
    foreach($sedi as $s){
      echo "<option>".$s['codice']."</option>";
    }
  ?>
</datalist>

<script>

	function retdati(){
		var indirizzo = document.getElementById('indirizzo').value.toUpperCase();
		var sede = document.getElementById('sede').value;

    var datincl = [indirizzo, sede];
    return datincl;
		console.log(datincl) ;
	}

	function nuovoPiazzale(){
		var dato = new Array();
		dato[0] = retdati();
		var r = confirm("Aggiungere " + dato[0][0] +  "?")
		if (r) {
			$.post('parts/pages/piazzaleaggiunto.php', {
				dati: dato
			}, function(data) {
				$("#main-content").html(data).show();
			});
		}
	}


</script>
