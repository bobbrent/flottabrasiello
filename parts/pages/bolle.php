<?php
include 'fun.php';
include 'funbolle.php';
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
        $offset = 0;
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
      ?>
  .dataTables_filter {
    display: none;
  }

  .dataTables_paginate.paging_bootstrap.pagination {
    float: right;
    margin-top: -5px;
    margin-bottom: 15px;
  }

  <?php
  } else {
      ?>
  .dataTables_length,
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
          <input type="text" name="ricerca_tabella" id="ricerca_tabella"
            value="<?php echo $valore_ricerca; ?>">
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
                <th>FILES</th>
              </tr>
            </thead>
            <tbody>
              <?php
  foreach ($bolle as $v) {
      $filebolla = cercafileperbolla($v[0]);
      if($filebolla) {
          $stringafile = "<a target='__blank' href='/uploads/".$filebolla[2]."'>Download</a>";
          // print_r($filebolla);
      } else {
          $stringafile = " <button onclick='inviafile(%s)' class='pulsantecarica'>
                  Carica 
                </button>";
      }
      $stringa = "<tr><td><a target='_blank' href='pdfbolla.php?bolla=%d'>%s</a></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
                  <td>
                    $stringafile
                  </td>
                </tr>";
      $destinatario = json_decode($v[5]);
      $destinazione = json_decode($v[6]);

      $desti = $destinatario[0] . " | Via " . $destinazione[0] . " n " . $destinazione[1] . ", (" . $destinazione[2] . ") " . $destinazione[3];
      printf($stringa, $v[0], $v[1], formattaDataLogin($v[2]), $desti, $v[8], $v[9], $v[0]);
      // $ultima_bolla = $v[0];
  }
?>
            </tbody>
          </table>
          <?php
          if (isset($_SESSION['is_admin']) && isset($paginator)) {

              if (!$pagina_iniziale && (($paginator) + $offset) > $paginator) {
                  ?>

          <button
            onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'admin', 'paginator': <?php echo  $paginator; ?>,'offset': <?php echo $offset - ($paginator * 2); ?>});clearR();">Pagina
            Precedente</button>
          <button
            onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'admin'});clearR();">Pagina
            Iniziale</button>
          <?php
              }
              ?>
          <button
            onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'admin', 'paginator': <?php echo  $paginator; ?>,'offset': <?php echo $offset; ?>});clearR();">Pagina
            Successiva</button>
          <?php
          } elseif (isset($sede[0]) && isset($paginator)) {
              $sede_competenza = $sede;
              ?>
          <?php
                if (!$pagina_iniziale && (($paginator) + $offset) > $paginator) {
                    ?>
          <button
            onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'utente', 'sede' : '<?php echo $sede_competenza; ?>', 'paginator': <?php echo  $paginator; ?>,'offset': <?php echo $offset - ($paginator * 2); ?>});clearR();">Pagina
            Precedente</button>
          <button
            onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'utente', 'sede' : '<?php echo $sede_competenza; ?>'});clearR();">Pagina
            Iniziale</button>
          <?php
                }
              ?>
          <button
            onclick="rldescend({ 'fxf': 'full', 'c1': '<?php echo  $pagina; ?>', 'pag': '<?php echo  $pagina; ?>', 'who':'utente', 'sede' : '<?php echo $sede_competenza; ?>', 'paginator': <?php echo  $paginator; ?>,'offset': <?php echo $offset; ?>});clearR();">Pagina
            Successiva</button>
          <?php
          }
?>

        </div>
      </div>
    </div>
  </div>
</section>

<modal class="modalecaricamento">
  <p class="chiudimodale" onclick="chiudimodale();"></p>
  <h4 class="titolomodale">
    Carica il file collegandolo alla bolla
  </h4>
  <div class="partecentralemodale">
    <div class="file-upload__wrapper">
      <div class="form-parent">
        <form action="#" class="file-upload__form">
          <input type="hidden" name="numerobolla" id="numerobolla" value="">
          <input class="file-input" type="file" name="file" />
        </form>
        <button class="pulsantecarica" onclick="caricafile();">Invia</button>
      </div>
    </div>
  </div>
</modal>
<style>
  .titolomodale {
    position: absolute;
    width: 91%;
    text-align: center;
    color: black;
    text-transform: uppercase;
    font-weight: 900;
  }

  .partecentralemodale {
    height: calc(100% - 68px);
    width: 98%;
    border-bottom-right-radius: 17px;
    border-bottom-left-radius: 17px;
    margin: 59px auto;
  }

  .modalecaricamento {
    display: none;
    opacity: 0;
    background: white;
    position: absolute;
    width: 70%;
    height: 70%;
    top: 12%;
    left: 20%;
    border: 1px solid;
    border-radius: 17px;
    box-shadow: 6px 6px 8px 0px rgba(0, 0, 0, 0.4);
    transition: opacity .5s;
  }

  .modaleblock {
    display: block;
  }

  .modaleopaca {
    opacity: 1;
  }

  .chiudimodale:after {
    display: inline-block;
    content: "\00d7";
    position: absolute;
    right: 0;
    padding: 0px 14px;
    border: 1px solid;
    border-top-right-radius: 16px;
    box-shadow: -2px 1px 5px 1px;
    font-size: 40px;
    font-weight: 900;
  }

  .chiudimodale {
    cursor: pointer;
  }

  .pulsantecarica {
    background: #22242a;
    color: white;
    text-transform: uppercase;
    border: none;
    padding: 10px;
    border-radius: 7px;
  }

  .pulsantecarica:active {
    background-color: lightgray;
    border-radius: 3px;
    box-shadow: 2px 2px 4px 1px #22242a;
  }

  /*! CSS Used from: Embedded ; media=all */
  @media all {
    .fas {
      -moz-osx-font-smoothing: grayscale;
      -webkit-font-smoothing: antialiased;
      display: inline-block;
      font-style: normal;
      font-variant: normal;
      text-rendering: auto;
      line-height: 1;
    }

    .fa-cloud-upload-alt:before {
      content: "\f382";
    }

    .fa-file-alt:before {
      content: "\f15c";
    }

    .fas {
      font-family: "Font Awesome 5 Free";
    }

    .fas {
      font-weight: 900;
    }
  }

  /*! CSS Used from: http://localhost/upp/main.css */
  .file-upload__wrapper {
    width: 100%;
    height: 100%;
    background: #fff;
    border-radius: 5px;
    padding: 35px;
    box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.05);
  }

  .file-upload__wrapper header {
    color: #cb67e9;
    font-size: 2rem;
    text-align: center;
    margin-bottom: 20px;
  }

  .form-parent {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .file-upload__wrapper form.file-upload__form {
    height: 100%;
    width: 100%;
    cursor: pointer;
    margin: 30px 0;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    border-radius: 6px;
    padding: 10px;
  }

  form.file-upload__form :where(i, p) {
    color: #cb67e9;
  }

  form.file-upload__form i {
    font-size: 50px;
  }

  form.file-upload__form p {
    font-size: 1rem;
    margin-top: 15px;
  }

  .uploaded-container {
    overflow-y: scroll;
    max-height: 230px;
  }

  .uploaded-container .row .content-wrapper {
    display: flex;
    align-items: center;
  }

  .uploaded-container .row .details-wrapper {
    display: flex;
    flex-direction: column;
    margin-left: 15px;
  }

  .uploaded-container .row .details-wrapper .name span {
    color: green;
    font-size: 10px;
  }

  .uploaded-container .row .details-wrapper .file-size {
    color: #404040;
    font-size: 11px;
  }
</style>

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
            ?>
        "sInfo": "Vista da <?php echo $offset; ?> a <?php echo $paginator; ?> di <?php print_r($totale_bolle); ?> <?php echo  $pagina; ?>",
        <?php
        } else {
            ?>
        "sInfo": " <?php print_r($numero_di_bolle); ?> trovate su <?php print_r($totale_bolle); ?> <?php echo  $pagina; ?>",
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
      } elseif (isset($sede[0])) {
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

  const uploadForm = document.querySelector(".file-upload__form"),
    fileInput = document.querySelector(".file-input");
  // uploadForm.addEventListener("click", () => {
  //   fileInput.click();
  // });

  fileInput.onchange = ({
    target
  }) => {
    let file = target.files[0];
    if (file) {
      let fileName = file.name;
      if (fileName.length >= 12) {
        let splitName = fileName.split(".");
        fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
      }
      console.log(fileName);
    }
  };

  function inviafile(id) {
    let modale = document.getElementsByClassName('modalecaricamento')[0];
    modale.classList.toggle('modaleblock');
    document.getElementById('numerobolla').value = id;
    setTimeout(() => {
      modale.classList.toggle('modaleopaca');
    }, 50)
  }

  function chiudimodale() {
    let modale = document.getElementsByClassName('modalecaricamento')[0];
    modale.classList.toggle('modaleopaca');
    setTimeout(() => {
      modale.classList.toggle('modaleblock');
    }, 550)
  }

  function caricafile() {
    let xhrRequest = new XMLHttpRequest();
    const endpoint = "/uploadbolle/upload.php";
    xhrRequest.onreadystatechange = function() {
      if (xhrRequest.readyState == XMLHttpRequest.DONE) {
        console.log(xhrRequest.responseText);
        let risposta = JSON.parse(xhrRequest.responseText);
        if (risposta[0] === 'errore') {
          alert('Errore: ' + risposta[1]);
        } else {
          alert(risposta[1]);
          setTimeout(() => {
            chiudimodale();
          }, 50);
          setTimeout(() => {
            <?php
                  if(isset($_SESSION['is_admin'])) {
                      ?>
            rldescend({
              'fxf': 'full',
              'c1': 'bolle',
              'pag': 'bolle',
              'who': 'admin'
            });
            clearR();
            <?php
                  } elseif(isset($sede[0])) {
                      $sede_competenza = 	$sede[0];
                      ?>
            rldescend({
              'fxf': 'full',
              'c1': 'bolle',
              'pag': 'bolle',
              'who': 'utente',
              'sede': '<?php echo $sede_competenza;?>'
            });
            clearR();
            <?php
                  }
?>
          }, 70);
        }
      }
    }
    xhrRequest.open("POST", endpoint);
    let data = new FormData(uploadForm);
    xhrRequest.send(data);
  }
</script>