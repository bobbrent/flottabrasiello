<?php
include 'fun.php';
$pagina = 'bolle';
if (isset($dati['ricerca'])) {
  $filter = filtra_stringa($dati['ricerca']);
  $filter = strtolower($filter);

  if ($dati['who'] == 'admin') {
    $quer = "SELECT * FROM `bolla` where 
    lower(`progressivo`) like '%$filter%' or
    lower(`data_bolla`) like '%$filter%' or
    lower(`destinatario`) like '%$filter%' or
    lower(`luogo_destinazione`) like '%$filter%' or
    lower(`vettori`) like '%$filter%' or
    lower(`annotazioni`) like '%$filter%'";
    $totale_bolle = tellMeTotaleBolle();
  } else {
    $sede = addslashes($dati['sede']);
    $quer = "SELECT * FROM `bolla` WHERE `sede` = '$sede' and (
    lower(`progressivo`) like '%$filter%' or
    lower(`data_bolla`) like '%$filter%' or
    lower(`destinatario`) like '%$filter%' or
    lower(`luogo_destinazione`) like '%$filter%' or
    lower(`vettori`) like '%$filter%' or
    lower(`annotazioni`) like '%$filter%')";
    $totale_bolle = tellMeTotaleBolle($dati['sede']);
  }
} else {
  if (isset($dati['paginator'])) {
    $paginator = $dati['paginator'];
    $pagina_iniziale = false;
    $offset = $dati['offset'] + $dati['paginator'];
    $limit = ' ORDER BY  `data_bolla` DESC LIMIT ' . $offset . ', ' . $dati['paginator'];
  } else {
    $pagina_iniziale = true;
    $paginator = 10;
    $offset = 1;
    $limit = ' ORDER BY `data_bolla` DESC LIMIT ' . $offset . ', ' . $paginator;
  }
  if ($dati['who'] == 'admin') {
    $quer = "SELECT * FROM `bolla` $limit";
    $totale_bolle = tellMeTotaleBolle();
  } else {
    $sede = addslashes($dati['sede']);
    $quer = "SELECT * FROM `bolla` WHERE `sede` = '$sede' $limit";
    $totale_bolle = tellMeTotaleBolle($dati['sede']);
    // $totale_bolle = 0;
  }
}


$bolle = tellMeBolle($quer);
$numero_di_bolle = count($bolle);
$ultima_bolla = 0;
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
  .nuvau {
    margin: 0px 0px 5% -40%;
  }

  .bb {
    display: block;
    position: relative;
    padding-left: 35px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  .bb input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
  }

  .bb:hover input~.checkmark {
    background-color: #ccc;
  }

  .bb input:checked~.checkmark {
    background-color: black;
  }

  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  .bb input:checked~.checkmark:after {
    display: block;
  }

  .bb .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .inn {
    margin-top: 7px;
    margin-bottom: 2px;
    width: 180px;
  }

  .input-sm {
    margin: 5px 0px;
  }

  button:active {
    background-color: lightgray;
    border-radius: 3px;
  }

  .w150 {
    width: 335px;
  }

  .bb {
    color: black;
    padding-top: 8px;
  }

  .bb1 {
    color: black;
  }

  .form {
    text-align: center;
    display: inline-grid;
  }

  .content-panel {
    padding: 66px;
  }

  .site-min-height {
    min-height: calc(100vh - 113px);
  }

  th,
  tr {
    cursor: pointer;
  }

  th {
    background: rgba(200, 200, 200, 0.4)
  }

  tr:hover {
    background: rgba(200, 200, 200, 0.4)
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
              Risultati ricerca: <?php echo $numero_di_bolle; ?>
            <?php
            }
            ?>
          </p>
        </div>
        <div class="adv-table">
          <table cellpadding="0" cellspacing="0" border="0" class="veicoli display table table-bordered">
            <thead>
              <tr>
                <th>N BOLLA</th>
                <th>DATA</th>
                <th>DESTINAZIONE</th>
                <th>VETTORE</th>
                <th>NOTE</th>
              </tr>
            </thead>
            <tbody>
              <?
              foreach ($bolle as $v) {
                $stringa = "<tr><td><a target='_blank' href='pdfbolla.php?bolla=%d'>%s</a></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
                $destinatario = json_decode($v[5]);
                $destinazione = json_decode($v[6]);

                $desti = $destinatario[0] . " | Via " . $destinazione[0] . " n " . $destinazione[1] . ", (" . $destinazione[2] . ") " . $destinazione[3];
                printf($stringa, $v[0], $v[1], formattaDataLogin($v[2]), $desti, $v[8], $v[9]);
                // $ultima_bolla = $v[0];
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
  $(document).ready(function() {
    var oTable = $('.veicoli').dataTable({
      "aaSorting": [
        [1, 'desc']
      ],
      "oLanguage": {
        "sEmptyTable": "Nessuna bolla presente nella tabella",
        <?php
        if (isset($paginator)) {
        ?> "sInfo": "Vista da <?php echo $offset; ?> a <?php echo $paginator; ?> di <?php print_r($totale_bolle); ?> <?php echo  $pagina; ?>",
        <?php
        } else {
        ?> "sInfo": " <?php print_r($numero_di_bolle); ?> trovate su <?php print_r($totale_bolle); ?> <?php echo  $pagina; ?>",
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