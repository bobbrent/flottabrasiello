<?php
  include 'fun.php';
  $veicoli = tellMeCarsLavorazioni();
?>
<style>
	.content-panel {
		padding: 66px;
	}
	.site-min-height {
		min-height: calc(100vh - 113px);
	}
	tr{
		font-size: 11px;
    font-weight: 300;
	}
	th, tr {
    cursor: pointer;
	}
	th{
		background: rgba(200,200,200,0.4)
	}
	tr:hover{
		background: rgba(33, 36, 41,0.2)
	}
</style>
<section class="wrapper site-min-height">
  <div class="row mb">
    <div class="content-panel">
      <div class="col-lg-12">
				<div class="adv-table">
					<table  cellpadding="0" cellspacing="0" border="0"  class="veicoli display table table-bordered">
						<thead>
							<tr>
								<th>TARGA</th>
								<th>TELAIO</th>
								<th>MARCA</th>
								<th>MODELLO</th>
								<th>SMONTAGGIO TARGHE</th>
								<th>LAVAGGIO</th>
								<th>LAVAGGIO ESTERNO/INTERNO</th>
								<th>FOTO</th>
							</tr>
						</thead>
						<tbody>
              <?
              if($dati['who'] == 'admin'){
                foreach ( $veicoli as $v ){
                  $stringa = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
                  printf($stringa, $v['targa'],$v['telaio'],$v['marca'],$v['modello'],$v['id'],$v['id'],$v['id']);
                }
              }else{
                foreach ( $veicoli as $v ){
                  if($v['sede'] == $dati['sede']){
                    $lavorazioni_fatte = tellMeLavorazioniMacchina($v['id']);
                    $testo_lavorazioni = '';
                    if(is_array($lavorazioni_fatte)){
                      if($lavorazioni_fatte[0][2] == 3){
                        $testo_lavorazioni = $testo_lavorazioni."<td><input type='checkbox' name='smontaggio' id='%s' checked></td>";
                      }else{
                        $testo_lavorazioni = $testo_lavorazioni."<td><input type='checkbox' name='smontaggio' id='%s'></td>";
                      }
                      if($lavorazioni_fatte[0][3] == 6){
                        $testo_lavorazioni = $testo_lavorazioni."<td><input type='checkbox' name='lavaggio' id='%s' checked></td>";
                      }else{
                        $testo_lavorazioni = $testo_lavorazioni."<td><input type='checkbox' name='lavaggio' id='%s'></td>";
                      }
                      if($lavorazioni_fatte[0][4] == 10){
                        $testo_lavorazioni = $testo_lavorazioni."<td><input type='checkbox' name='lavaggioest' id='%s' checked></td>";
                      }else{
                        $testo_lavorazioni = $testo_lavorazioni."<td><input type='checkbox' name='lavaggioest' id='%s'></td>";
                      }
                      if($lavorazioni_fatte[0][5] == 10){
                        $testo_lavorazioni = $testo_lavorazioni."<td><input type='checkbox' name='foto' id='%s' checked></td>";
                      }else{
                        $testo_lavorazioni = $testo_lavorazioni."<td><input type='checkbox' name='foto' id='%s'></td>";
                      }
                    }else{
                      $testo_lavorazioni = "<td><input type='checkbox' name='smontaggio' id='%s'></td><td><input type='checkbox' name='lavaggio' id='%s'></td><td><input type='checkbox' name='lavaggioest' id='%s'></td><td><input type='checkbox' name='foto' id='%s'></td>";
                    }

                    $stringa = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td>$testo_lavorazioni</tr>";
                    printf($stringa, $v['targa'],$v['telaio'],$v['marca'],$v['modello'],$v['id'],$v['id'],$v['id'],$v['id']);
                    // print_r($lavorazioni_fatte);  
                  }
                }
              }

              ?>
						</tbody>
					</table>
      	</div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">

  $('input[name=smontaggio]').on("click",function(){
    var id = $(this).attr('id');

    if($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type:'GET',
      url:'parts/pages/agglavorazioni.php',
      data:'id= ' + id + '&lavorazione=smontaggio&valore='+click
    });
    // console.log('id: ' + id);
  });

  $('input[name=lavaggio]').on("click",function(){
    var id = $(this).attr('id');

    if($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type:'GET',
      url:'parts/pages/agglavorazioni.php',
      data:'id= ' + id + '&lavorazione=lavaggio&valore='+click
    });
    // console.log( click);
  });

  $('input[name=foto]').on("click",function(){
    var id = $(this).attr('id');

    if($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type:'GET',
      url:'parts/pages/agglavorazioni.php',
      data:'id= ' + id + '&lavorazione=foto&valore='+click
    });
    // console.log('id: ' + id);
  });

  $('input[name=lavaggioest]').on("click",function(){
    var id = $(this).attr('id');

    if($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type:'GET',
      url:'parts/pages/agglavorazioni.php',
      data:'id= ' + id + '&lavorazione=lavaggioest&valore='+click
    });
    // console.log('id: ' + id);
  });

  $(document).ready(function() {
    var oTable = $('.veicoli').dataTable({
      "aaSorting": [
        [1, 'desc']
      ],
      "oLanguage": {
          "sEmptyTable":     "Nessun veicolo presente nella tabella",
          "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ veicoli",
          "sInfoEmpty":      "Vista da 0 a 0 di 0 veicoli",
          "sInfoFiltered":   "(filtrati da _MAX_ veicoli totali)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ".",
          "sLengthMenu":     "Visualizza _MENU_ veicoli",
          "sLoadingRecords": "Caricamento...",
          "sProcessing":     "Elaborazione...",
          "sSearch":         "Cerca:",
          "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
          "oPaginate": {
              "sFirst":      "Inizio",
              "sPrevious":   "Precedente",
              "sNext":       "Successivo",
              "sLast":       "Fine"
          },
          "oAria": {
              "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
              "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
          }
      }
    });
  });
</script>