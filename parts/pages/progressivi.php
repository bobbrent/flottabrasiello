<?php
  include 'fun.php';
  $sedi = tellMeSedi();
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
								<th>CODICE</th>
								<th>DESCRIZIONE</th>
								<th>VIA</th>
								<th>NUMERO</th>
								<th>CITTA</th>
								<th>PROV</th>
								<th>CAP</th>
								<th>TELEFONO</th>
								<th>EMAIL</th>
								<th>SLUG</th>
								<th>PROGRESSIVO</th>
							</tr>
						</thead>
						<tbody>
            <?
              foreach ( $sedi as $v ){
                $p = tellMeProgressivo($v['codice']);
                $c = $v['codice'];

                $editabili = "<td><input type='text' class='editabili' name='telefono' id='%s' value='%s'></td><td><input type='text' class='editabili' name='mail' id='%s' value='%s'></td><td><input type='text' class='editabili' name='slug' id='%s' value='%s'></td><td><input type='number' class='editabili' name='progressivo' id='%s' value='%s'></td>";
                // print_r($v);
                $stringa = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>$editabili</tr>";
                printf($stringa, $v['codice'],$v['descrizione'],$v['via'],$v['numero'],$v['citta'],$v['prov'],$v['cap'],$c,$v['telefono'],$c,$v['email'],$c,$p[0][2],$c,$p[0][3]);
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

$('input[name=telefono]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggsede.php', {
				id: id,
        campo: 'telefono',
        valore: valore
			}, function(data) {
        console.log(data);
			}); 
  });

$('input[name=mail]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggsede.php', {
				id: id,
        campo: 'mail',
        valore: valore
			}, function(data) {
        console.log(data);
			}); 
  });

$('input[name=slug]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggsede.php', {
				id: id,
        campo: 'slug',
        valore: valore
			}, function(data) {
        console.log(data);
			});
  });

$('input[name=progressivo]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggsede.php', {
				id: id,
        campo: 'progressivo',
        valore: valore
			}, function(data) {
        console.log(data);
			});
  });



  $(document).ready(function() {
    var oTable = $('.veicoli').dataTable({
      "aaSorting": [
        [6, 'desc']
      ],
      "oLanguage": {
          "sEmptyTable":     "Nessuna sede presente nella tabella",
          "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ sedi",
          "sInfoEmpty":      "Vista da 0 a 0 di 0 veicoli",
          "sInfoFiltered":   "(filtrati da _MAX_ sedi totali)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ".",
          "sLengthMenu":     "Visualizza _MENU_ sedi",
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