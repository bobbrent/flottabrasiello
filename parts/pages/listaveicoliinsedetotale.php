<?php
  include 'fun.php';
  // $veicoli = tellMeCarsLavorazioniOLD();
  $ubiquity = "`data_uscita` IS NULL";
  $pagina = 'listaveicoliinsedetotale';
  if (isset($dati['ricerca'])) {
    $filter = filtra_stringa($dati['ricerca']);
    $filter = strtolower($filter);
    //  `id`, `id_piazzale`, `tipo_veicolo`, `sede`, `targa`, `telaio`, `marca`, `modello`, `colore`, `data_arrivo`,  `km`,   `data_uscita`,  `note`, `flotta` 
    if ($dati['who'] == 'admin') {
      $quer = "SELECT `id`, `id_piazzale`, `tipo_veicolo`, `sede`, `targa`, `telaio`, `marca`, `modello`, `colore`, `data_arrivo`,  `km`,   `data_uscita`,  `note`, `flotta`  FROM `macchina` where  $ubiquity and (
        lower(`colore`) like '%$filter%' or
        lower(`data_arrivo`) like '%$filter%' or
        lower(`km`) like '%$filter%' or
        lower(`data_uscita`) like '%$filter%' or
        lower(`note`) like '%$filter%' or
        lower(`flotta`) like '%$filter%' or
        lower(`targa`) like '%$filter%' or
        lower(`telaio`) like '%$filter%' or
        lower(`marca`) like '%$filter%' or
        lower(`modello`) like '%$filter%') LIMIT 1000";
      $totale_lavorazioni = tellMeTotaleAutosede();
    } else {
      $sede = addslashes($dati['sede']);
      $quer = "SELECT `id`, `id_piazzale`, `tipo_veicolo`, `sede`, `targa`, `telaio`, `marca`, `modello`, `colore`, `data_arrivo`,  `km`,   `data_uscita`,  `note`, `flotta`  FROM `macchina` WHERE `sede` = '$sede' and $ubiquity and  (
        lower(`colore`) like '%$filter%' or
        lower(`data_arrivo`) like '%$filter%' or
        lower(`km`) like '%$filter%' or
        lower(`data_uscita`) like '%$filter%' or
        lower(`note`) like '%$filter%' or
        lower(`flotta`) like '%$filter%' or
        lower(`targa`) like '%$filter%' or
        lower(`telaio`) like '%$filter%' or
        lower(`marca`) like '%$filter%' or
        lower(`modello`) like '%$filter%') LIMIT 1000";
      $totale_lavorazioni = tellMeTotaleAutosede($dati['sede']);
    }
  } else {
    if (isset($dati['paginator'])) {
      $paginator = $dati['paginator'];
      $pagina_iniziale = false;
      $offset = $dati['offset'] + $dati['paginator'];
      $limit = ' ORDER BY  `data_arrivo` DESC LIMIT ' . $offset . ', ' . $dati['paginator'];
    } else {
      $pagina_iniziale = true;
      $paginator = 10;
      $offset = 1;
      $limit = ' ORDER BY `data_arrivo` DESC LIMIT ' . $offset . ', ' . $paginator;
    }
    if ($dati['who'] == 'admin') {
      $quer = "SELECT `id`, `id_piazzale`, `tipo_veicolo`, `sede`, `targa`, `telaio`, `marca`, `modello`, `colore`, `data_arrivo`,  `km`,   `data_uscita`,  `note`, `flotta`  FROM `macchina` WHERE $ubiquity  $limit";
      $totale_lavorazioni = tellMeTotaleAutosede();
    } else {
      $sede = addslashes($dati['sede']);
      $quer = "SELECT `id`, `id_piazzale`, `tipo_veicolo`, `sede`, `targa`, `telaio`, `marca`, `modello`, `colore`, `data_arrivo`,  `km`,   `data_uscita`,  `note`, `flotta`  FROM `macchina`  WHERE $ubiquity and `sede` = '$sede'  $limit";
      $totale_lavorazioni = tellMeTotaleAutosede($dati['sede']);
      // $totale_bolle = 0;
    }
  }
  
  $veicoli = tellMeCarsLavorazioni($quer);
  $numero_di_veicoli = count($veicoli);
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
  .ricerca {
    padding: 20px 0px;
  }

  #ricerca_tabella {
    padding: 10px;
    margin: 0 auto;
    width: 200px;
    text-align: left;
    font-size: 14px;
    color: black;
    border: 1px solid lightgray;
    border-radius: 5px;
    margin-right: 20px;
  }

  .btn_ricerca {
    text-transform: uppercase;
    font-family: sans-serif;
    padding: 6px 18px;
    border-radius: 7px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    outline: none;
    color: #fff;
    border: none;
    box-shadow: 0 5px #999;
  }

  .btn_ricerca:hover {
    background-color: rgba(0, 0, 0, 0.5);
  }

  .btn_ricerca:active {
    box-shadow: 0 5px #666;
    transform: translateY(4px);
  }
  <?php
  if (isset($filter)) {
  ?>.dataTables_filter {
    display: none;
  }

  .dataTables_paginate.paging_bootstrap.pagination {
    float: right;
    margin-top: -5px;
    margin-bottom: 15px;
  }

  <?php
  } else {
  ?>.dataTables_length,
  .dataTables_filter {
    display: none;
  }

  .dataTables_paginate.paging_bootstrap.pagination {
    float: right;
    margin-top: -5px;
    margin-bottom: 15px;
    display: none;
  }

  <?php
  }
  ?>
</style>
<section class="wrapper site-min-height">
  <div class="row mb">
    <div class="content-panel">
      <div class="col-lg-12">
      <div class="ricerca">
          <?php
          $valore_ricerca = '';
          if (isset($filter)) {
            $valore_ricerca = $filter;
          }
          ?>
          <input type="text" name="ricerca_tabella" id="ricerca_tabella" value="<?php echo $valore_ricerca; ?>">
          <button type="submit" class="btn_ricerca" onclick="ricerca_db();">Cerca</button>
          <p>
            <?php
            if (isset($filter)) {
              ?>
              Risultati ricerca: <?php 
              echo $numero_di_veicoli; 
              if($numero_di_veicoli > 899){
                echo "( i risultati della ricerca sono limitati a 1000 per ragioni di performance )";
              }
              ?> 
            <?php
            }
            ?>
          </p>
        </div>
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
                      $stringa = "<tr><td>%s</td><td>%s</td><td><input type='text' class='editabili' name='targa' id='%s' value='%s'></td><td><input type='text' class='editabili' name='telaio' id='%s' value='%s'></td><td>%s</td><td>%s</td><td>%s</td><td><input style='width: 116px;' type='text' class='editabili' name='datarrivo' id='%s' value='%s'></td><td><input type='text' class='editabili' name='km' id='%s' value='%s'></td><td>%s</td><td><input type='text' class='editabili' name='note' id='%s' value='%s'></td></tr>";
                      printf($stringa, $v['tipo_veicolo'],tellMePiazzale($v['id_piazzale']),$v['id'],$v['targa'],$v['id'],$v['telaio'],$v['marca'],$v['modello'],$v['colore'],$v['id'],$v['data_arrivo'],$v['id'],$v['km'],formattaDataLogin($v['data_uscita']),$v['id'],$v['note']);
                  }
                }else{
                  foreach ( $veicoli as $v ){
                    if($v['sede'] == $dati['sede']){
                      $stringa = "<tr><td>%s</td><td>%s</td><td><input type='text' class='editabili' name='targa' id='%s' value='%s'></td><td><input type='text' class='editabili' name='telaio' id='%s' value='%s'></td><td>%s</td><td>%s</td><td>%s</td><td><input style='width: 116px;' type='text' class='editabili' name='datarrivo' id='%s' value='%s'></td><td>%s</td><td>%s</td><td>%s</td></tr>";
                      printf($stringa, $v['tipo_veicolo'],tellMePiazzale($v['id_piazzale']),$v['id'],$v['targa'],$v['id'],$v['telaio'],$v['marca'],$v['modello'],$v['colore'],$v['id'],$v['data_arrivo'],$v['km'],formattaDataLogin($v['data_uscita']),$v['note']);  
                    }
                  }
                }
              ?>
						</tbody>
					</table>
          <?php
          if (isset($_SESSION['is_admin']) && isset($paginator)) {

            if (!$pagina_iniziale && (($paginator) + $offset) > $paginator) {
          ?>

              <button onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'admin', 'paginator': <?php echo  $paginator; ?>,'offset': <?php echo $offset - ($paginator * 2); ?>});clearR();">Pagina Precedente</button>
              <button onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'admin'});clearR();">Pagina Iniziale</button>
            <?php
            }
            ?>
            <button onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'admin', 'paginator': <?php echo  $paginator; ?>,'offset': <?php echo $offset; ?>});clearR();">Pagina Successiva</button>
          <?php
          } else if (isset($sede[0]) && isset($paginator)) {
            $sede_competenza = $sede;
          ?>
            <?php
            if (!$pagina_iniziale && (($paginator) + $offset) > $paginator) {
            ?>
              <button onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'utente', 'sede' : '<?php echo $sede_competenza; ?>', 'paginator': <?php echo  $paginator; ?>,'offset': <?php echo $offset - ($paginator * 2); ?>});clearR();">Pagina Precedente</button>
              <button onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'utente', 'sede' : '<?php echo $sede_competenza; ?>'});clearR();">Pagina Iniziale</button>
            <?php
            }
            ?>
            <button onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'utente', 'sede' : '<?php echo $sede_competenza; ?>', 'paginator': <?php echo  $paginator; ?>,'offset': <?php echo $offset; ?>});clearR();">Pagina Successiva</button>
          <?php
          }
          ?>
      	</div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">

  $('input[name=note]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggmacchina.php', {
				id: id,
        campo: 'note',
        valore: valore
			}, function(data) {
        // console.log(data);
			}); 
  });
  
  $('input[name=datarrivo]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggmacchina.php', {
				id: id,
        campo: 'data_arrivo',
        valore: valore
			}, function(data) {
        // console.log(data);
			}); 
  });
  
  $('input[name=km]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggmacchina.php', {
				id: id,
        campo: 'km',
        valore: valore
			}, function(data) {
        // console.log(data);
			}); 
  });

  $('input[name=telaio]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggmacchina.php', {
				id: id,
        campo: 'telaio',
        valore: valore
			}, function(data) {
        // console.log(data);
			}); 
  });

  $('input[name=targa]').on("keyup",function(){
    var id = $(this).attr('id');
    var valore = $(this).val();
    $.post('parts/pages/aggmacchina.php', {
				id: id,
        campo: 'targa',
        valore: valore
			}, function(data) {
        // console.log(data);
			}); 
  });

  $(document).ready(function() {
    var oTable = $('.veicoli').dataTable({

      "oLanguage": {
          "sEmptyTable":     "Nessun veicolo presente nella tabella",
          <?php
        if (isset($paginator)) {
        ?> "sInfo": "Vista da <?php echo $offset; ?> a <?php echo $paginator; ?> di <?php print_r($totale_lavorazioni); ?> <?php echo  $pagina; ?>",
        <?php
        } else {
        ?> "sInfo": " <?php print_r($numero_di_veicoli); ?> trovate su <?php print_r($totale_lavorazioni); ?> <?php echo  $pagina; ?>",
        <?php
        }
        ?> 
        "sInfoEmpty": "Vista da 0 a 0 di 0 <?php echo  $pagina; ?>",
        "sInfoFiltered": "(filtrati da _MAX_ <?php echo  $pagina; ?> totali)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "Visualizza _MENU_ <?php echo  $pagina; ?>",
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
  function ricerca_db() {
    let ricerca = document.getElementById('ricerca_tabella').value;
    if (ricerca != null && ricerca != '' && ricerca.length > 2) {
      <?php
      if (isset($_SESSION['is_admin'])) {
      ?>
        rldescend({
          'fxf': 'full',
          'c1': '<?php echo  $pagina; ?>',
          'pag': '<?php echo  $pagina; ?>',
          'who': 'admin',
          'ricerca': ricerca
        });
        clearR();
      <?php
      } else if (isset($sede[0])) {
      ?>
        rldescend({
          'fxf': 'full',
          'c1': '<?php echo  $pagina; ?>',
          'pag': '<?php echo  $pagina; ?>',
          'who': 'utente',
          'sede': '<?php echo $sede; ?>',
          'ricerca': ricerca
        });
        clearR();
      <?php
      }
      ?>
    }
  }
</script>