<?php
  include 'fun.php';
  $piazzali = tellMePiazzali();
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
  .editabili{
    width: 250px;
  }
</style>
<section class="wrapper site-min-height">
  <div class="row mb">
    <div class="content-panel">
      <div class="col-lg-12">
				<div class="adv-table">
					<table  cellpadding="0" cellspacing="0" border="0"  class="piazzali display table table-bordered">
						<thead>
							<tr>
								<th>INDIRIZZO</th>
								<th>SEDE</th>
							</tr>
						</thead>
						<tbody>
            <?
              foreach ( $piazzali as $v ){
                $id = $v[0];
                $indirizzo = tellMePiazzale($id);
                $sede = $v[2];
                $stringa = '<tr><td><input type="text" class="editabili" name="indirizzo" id="'.$id.'" value="'.$indirizzo.'"></td><td><input type="text" class="editabili" name="sede" id="'.$id.'" value="'.$sede.'"  autocomplete="on" list="sedi"></td></tr>';
                // printf($stringa, $id,$v[1],$id,$v[2]);
                echo $stringa;
              }
            ?>
						</tbody>
					</table>
      	</div>
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

<script type="text/javascript">

$('input[name=indirizzo]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggpiazzale.php', {
				id: id,
        campo: 'denominazione',
        valore: valore
			}, function(data) {
        // console.log(data);
			}); 
  });

$('input[name=sede]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggpiazzale.php', {
				id: id,
        campo: 'sede',
        valore: valore
			}, function(data) {
        // console.log(data);
			}); 
  });

  $(document).ready(function() {
    var oTable = $('.piazzali').dataTable({
      "aaSorting": [
        [6, 'desc']
      ],
      "oLanguage": {
          "sEmptyTable":     "Nessun piazzale presente nella tabella",
          "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ piazzali",
          "sInfoEmpty":      "Vista da 0 a 0 di 0 piazzali",
          "sInfoFiltered":   "(filtrati da _MAX_ sedi piazzali)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ".",
          "sLengthMenu":     "Visualizza _MENU_ piazzali",
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