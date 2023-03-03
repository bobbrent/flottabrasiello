<?php
include 'fun.php';
$pagina = 'lavorazioni';
// if (!isset($dati['ricerca'])) {
//   if (isset($dati['paginator'])) {
//     $paginator = $dati['paginator'];
//     $offset = $dati['offset'];
//   } else {
//     $paginator = 10;
//     $offset = 1;
//   }
//   $veicoli = tellMeCarsLavorazioni($paginator, $offset);
// } else {
//   $veicoli = tellMeCarsLavorazioni(10, 1);
// }


if (isset($dati['ricerca'])) {
  $filter = filtra_stringa($dati['ricerca']);
  $filter = strtolower($filter);
  // `targa`, `telaio`, `marca`, `modello`
  if ($dati['who'] == 'admin') {
    $quer = "SELECT * FROM `macchina` where 
      lower(`targa`) like '%$filter%' or
      lower(`telaio`) like '%$filter%' or
      lower(`marca`) like '%$filter%' or
      lower(`modello`) like '%$filter%'";
    $totale_lavorazioni = tellMeTotaleLavorazioni();
  } else {
    $sede = addslashes($dati['sede']);
    $quer = "SELECT * FROM `macchina` WHERE `sede` = '$sede' and (
      lower(`targa`) like '%$filter%' or
      lower(`telaio`) like '%$filter%' or
      lower(`marca`) like '%$filter%' or
      lower(`modello`) like '%$filter%')";
    $totale_lavorazioni = tellMeTotaleLavorazioni($dati['sede']);
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
    $quer = "SELECT * FROM `macchina` $limit";
    $totale_lavorazioni = tellMeTotaleLavorazioni();
  } else {
    $sede = addslashes($dati['sede']);
    $quer = "SELECT * FROM `macchina` WHERE `sede` = '$sede' $limit";
    $totale_lavorazioni = tellMeTotaleLavorazioni($dati['sede']);
    // $totale_bolle = 0;
  }
}


$veicoli = tellMeCarsLavorazioni($quer);
$numero_di_veicoli = count($veicoli);
?>
<style>
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
  .content-panel {
    padding: 66px;
  }

  .site-min-height {
    min-height: calc(100vh - 113px);
  }

  tr {
    font-size: 11px;
    font-weight: 300;
  }

  th,
  tr {
    cursor: pointer;
  }

  th {
    background: rgba(200, 200, 200, 0.4)
  }

  tr:hover {
    background: rgba(33, 36, 41, 0.2)
  }
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
              Risultati ricerca: <?php echo $numero_di_veicoli; ?>
            <?php
            }
            ?>
          </p>
        </div>
        <div class="adv-table">
          <table cellpadding="0" cellspacing="0" border="0" class="veicoli display table table-bordered">
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
                <th>App. Base</th>
                <th>App. Premium</th>
              </tr>
            </thead>
            <tbody>
              <?
              // print_r($veicoli);
              if ($dati['who'] == 'admin') {
                foreach ($veicoli as $v) {
                  $stringa = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
                  printf($stringa, $v['targa'], $v['telaio'], $v['marca'], $v['modello'], $v['id'], $v['id'], $v['id']);
                }
              } else {
                foreach ($veicoli as $v) {
                  if ($v['sede'] == $dati['sede']) {
                    $lavorazioni_fatte = tellMeLavorazioniMacchina($v['id']);
                    $testo_lavorazioni = '';
                    if (is_array($lavorazioni_fatte)) {
                      if ($lavorazioni_fatte[0][2] == 3) {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='smontaggio' id='%s' checked></td>";
                      } else {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='smontaggio' id='%s'></td>";
                      }
                      if ($lavorazioni_fatte[0][3] == 6) {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='lavaggio' id='%s' checked></td>";
                      } else {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='lavaggio' id='%s'></td>";
                      }
                      if ($lavorazioni_fatte[0][4] == 10) {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='lavaggioest' id='%s' checked></td>";
                      } else {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='lavaggioest' id='%s'></td>";
                      }
                      if ($lavorazioni_fatte[0][5] == 10) {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='foto' id='%s' checked></td>";
                      } else {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='foto' id='%s'></td>";
                      }
                      if ($lavorazioni_fatte[0][6] == 1) {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='appbase' id='%s' checked></td>";
                      } else {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='appbase' id='%s'></td>";
                      }
                      if ($lavorazioni_fatte[0][7] == 1) {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='apppremium' id='%s' checked></td>";
                      } else {
                        $testo_lavorazioni = $testo_lavorazioni . "<td><input type='checkbox' name='apppremium' id='%s'></td>";
                      }
                    } else {
                      $testo_lavorazioni = "<td><input type='checkbox' name='smontaggio' id='%s'></td><td><input type='checkbox' name='lavaggio' id='%s'></td><td><input type='checkbox' name='lavaggioest' id='%s'></td><td><input type='checkbox' name='foto' id='%s'></td><td><input type='checkbox' name='appbase' id='%s'></td><td><input type='checkbox' name='apppremium' id='%s'></td>";
                    }
                    if($testo_lavorazioni != ''){
                      $stringa = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td>$testo_lavorazioni</tr>";
                      printf($stringa, $v['targa'], $v['telaio'], $v['marca'], $v['modello'], $v['id'], $v['id'], $v['id'], $v['id'], $v['id'], $v['id']);
                      // print_r($stringa . " | " . $v['targa'] . " | " . $v['telaio'] . " | " . $v['marca'] . " | " . $v['modello'] . " | " . $v['id'] . " | " . $v['id'] . " | " . $v['id'] . " | " . $v['id'] . " | " . $v['id'] . " | " . $v['id']);
                    }
                    // print_r($v['id']);  
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
  $('input[name=smontaggio]').on("click", function() {
    var id = $(this).attr('id');

    if ($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type: 'GET',
      url: 'parts/pages/agglavorazioni.php',
      data: 'id= ' + id + '&lavorazione=smontaggio&valore=' + click
    });
    // console.log('id: ' + id);
  });

  $('input[name=lavaggio]').on("click", function() {
    var id = $(this).attr('id');

    if ($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type: 'GET',
      url: 'parts/pages/agglavorazioni.php',
      data: 'id= ' + id + '&lavorazione=lavaggio&valore=' + click
    });
    // console.log( click);
  });

  $('input[name=foto]').on("click", function() {
    var id = $(this).attr('id');

    if ($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type: 'GET',
      url: 'parts/pages/agglavorazioni.php',
      data: 'id= ' + id + '&lavorazione=foto&valore=' + click
    });
    // console.log('id: ' + id);
  });

  $('input[name=lavaggioest]').on("click", function() {
    var id = $(this).attr('id');

    if ($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type: 'GET',
      url: 'parts/pages/agglavorazioni.php',
      data: 'id= ' + id + '&lavorazione=lavaggioest&valore=' + click
    });
    // console.log('id: ' + id);
  });

  $('input[name=appbase]').on("click", function() {
    var id = $(this).attr('id');

    if ($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type: 'GET',
      url: 'parts/pages/agglavorazioni.php',
      data: 'id= ' + id + '&lavorazione=appbase&valore=' + click
    });
    // console.log('id: ' + id);
  });

  $('input[name=apppremium]').on("click", function() {
    var id = $(this).attr('id');

    if ($(this).is(':checked')) {
      var click = 1;
    } else {
      var click = 0;
    }
    $.ajax({
      type: 'GET',
      url: 'parts/pages/agglavorazioni.php',
      data: 'id= ' + id + '&lavorazione=apppremium&valore=' + click
    });
    // console.log('id: ' + id);
  });

  $(document).ready(function() {
    var oTable = $('.veicoli').dataTable({
      "aaSorting": [
        [1, 'desc']
      ],
      "oLanguage": {
        "sEmptyTable": "Nessun veicolo presente nella tabella",
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
        "sProcessing": "Elaborazione...",
        "sSearch": "Cerca:",
        "sZeroRecords": "La ricerca non ha portato alcun risultato.",
        "oPaginate": {
          "sFirst": "Inizio",
          "sPrevious": "Precedente",
          "sNext": "Successivo",
          "sLast": "Fine"
        },
        "oAria": {
          "sSortAscending": ": attiva per ordinare la colonna in ordine crescente",
          "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
        }
      }
    });
  });

  function ricerca_db() {
    let ricerca = document.getElementById('ricerca_tabella').value;
    if (ricerca != null && ricerca != '' && ricerca.length > 3) {
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