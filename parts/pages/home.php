<?php
  include 'fun.php';

  $sede =  $dati['sede'];
  $flotta = tellMeFlottaSede($sede);
?>
<style>
  .tastone{
    background: darkgray;
    color: white;
    padding: 11px;
    border-radius: 11px;
    margin: 0 auto;
    font-size: x-large;
    font-weight: 200;
  }
  th, tr {
      cursor: pointer;
  }
  tr:hover{
    background: rgba(200,200,200,0.4)
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
							if(isset($_SESSION['is_admin'])){
                ?>
                  L'utente Admin non ha sedi associate
                <?
              }else{?>
        <h2>Excel ALD</h2>
        <a class="tastone" href="ex.php?sede=<?echo $sede;?>" target="_blank">INVENTARIO STOCK</a><br><br>
        <a class="tastone" href="ex.1.php?sede=<?echo $sede;?>" target="_blank">USATO IN ENTRATA</a><br><br>
        <a class="tastone" href="ex.2.php?sede=<?echo $sede;?>" target="_blank">USATO IN USCITA</a><br><br>
        <?
        if(count($flotta) > 1){
          ?>
          <hr>
            <h3>ALTRE FLOTTE</h3>
          <?
        }
        foreach($flotta as $f){
          if($f[0] != 'ALD' && $f[0] != 'DRIVALIA'){
            ?>
              <h3>Excel <?echo $f[0];?></h3>
              <a class="tastone" href="ex.like.php?sede=<?echo $sede;?>&like=<?echo $f[0];?>" target="_blank">INVENTARIO STOCK <?echo $f[0];?></a><br><br>
              <a class="tastone" href="ex.1.like.php?sede=<?echo $sede;?>&like=<?echo $f[0];?>" target="_blank">USATO IN ENTRATA <?echo $f[0];?></a><br><br>
              <a class="tastone" href="ex.2.like.php?sede=<?echo $sede;?>&like=<?echo $f[0];?>" target="_blank">USATO IN USCITA <?echo $f[0];?></a><br><br>
            <?
          }
        }

      }?>
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

