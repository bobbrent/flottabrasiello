<?php
  include 'fun.php';
  $veicoli = tellMeCars();
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
								<th>TIPO</th>
								<th>PIAZZALE</th>
								<th>TARGA</th>
								<th>TELAIO</th>
								<th>MARCA</th>
								<th>MODELLO</th>
								<th>COLORE</th>
								<th>ARRIVO</th>
								<th>KILOMETRAGGIO</th>
								<th>USCITA</th>
								<th>NOTE</th>
							</tr>
						</thead>
						<tbody>
              <?
                if($dati['who'] == 'admin'){
                  foreach ( $veicoli as $v ){
                      $stringa = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
                      printf($stringa, $v['tipo_veicolo'],tellMePiazzale($v['id_piazzale']),$v['targa'],$v['telaio'],$v['marca'],$v['modello'],$v['colore'],formattaDataLogin($v['data_arrivo']),$v['km'],formattaDataLogin($v['data_uscita']),$v['note']);
                  }
                }else{
                  foreach ( $veicoli as $v ){
                    if($v['sede'] == $dati['sede']){
                      $stringa = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
                      printf($stringa, $v['tipo_veicolo'],tellMePiazzale($v['id_piazzale']),$v['targa'],$v['telaio'],$v['marca'],$v['modello'],$v['colore'],formattaDataLogin($v['data_arrivo']),$v['km'],formattaDataLogin($v['data_uscita']),$v['note']);  
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
  $(document).ready(function() {
    var oTable = $('.veicoli').dataTable({

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