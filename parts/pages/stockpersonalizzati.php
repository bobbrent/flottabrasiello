<?php
include 'fun.php';

$sede =  $dati['sede'];
$flotta = tellMeFlottaSede($sede);
?>
<style>
  .tastone {
    background: darkgray;
    color: white;
    padding: 11px;
    border-radius: 11px;
    margin: 0 auto;
    font-size: x-large;
    font-weight: 200;
  }

  th,
  tr {
    cursor: pointer;
  }

  tr:hover {
    background: rgba(200, 200, 200, 0.4)
  }

  .site-min-height {
    min-height: calc(100vh - 113px);
  }
</style>
<section class="wrapper site-min-height">
  <div class="row mb">
    <div class="content-panel">
      <div class="col-lg-12">
        <?
        if (isset($_SESSION['is_admin'])) {
        ?>
          L'utente Admin non ha sedi associate
        <?
        } else { ?>
          <h2>DRIVALIA</h2>
          <a class="tastone" href="exdrivalia.php?sede=<? echo $sede; ?>" target="_blank">INVENTARIO STOCK</a><br><br>
          <a class="tastone" href="exdrivalia.1.php?sede=<? echo $sede; ?>" target="_blank">USATO IN ENTRATA</a><br><br>
          <a class="tastone" href="exdrivalia.2.php?sede=<? echo $sede; ?>" target="_blank">USATO IN USCITA</a><br><br>
        <?
        } ?>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  // $(document).ready(function() {
  //   var oTable = $('.sedi').dataTable({
  //     "aaSorting": [
  //       [1, 'desc']
  //     ],
  //     "oLanguage": {
  //         "sEmptyTable":     "Nessuna sede presente nella tabella",
  //         "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ sedi",
  //         "sInfoEmpty":      "Vista da 0 a 0 di 0 sedi",
  //         "sInfoFiltered":   "(filtrati da _MAX_ sedi totali)",
  //         "sInfoPostFix":    "",
  //         "sInfoThousands":  ".",
  //         "sLengthMenu":     "Visualizza _MENU_ sedi",
  //         "sLoadingRecords": "Caricamento...",
  //         "sProcessing":     "Elaborazione...",
  //         "sSearch":         "Cerca:",
  //         "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
  //         "oPaginate": {
  //             "sFirst":      "Inizio",
  //             "sPrevious":   "Precedente",
  //             "sNext":       "Successivo",
  //             "sLast":       "Fine"
  //         },
  //         "oAria": {
  //             "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
  //             "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
  //         }
  //     }
  //   });
  // });
</script>