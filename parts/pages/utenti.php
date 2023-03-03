<?php
  include ('fun.php');
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `login` ORDER BY `id`  DESC ") or die("database error:". mysqli_error($connString));

?>
<style>
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
  <h3><i class="fa fa-angle-right"></i> <?php echo strtoupper($pagina);?></h3>
  <div class="row mb">
    <div class="content-panel">
      <div class="adv-table">
        <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
          <thead>
            <tr>
              <th>Username</th>
              <th>Ruolo</th>
              <th>Ultimo Login</th>
              <th class="hidden-phone"></th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($cec as $prod){
                if($prod['role'] == 0){
                  // echo "<tr><td>".$prod['username']."</td><td>".tellMeRuolo($prod['role'])."</td></tr>";
                }else{
                  echo "<tr><td onclick=\"dAzNid('paginautente', ".$prod['id'].")\">".$prod['username']."</td><td>".tellMeRuolo($prod['role'])."</td><td>".formattaDataLogin($prod['ultimo_login'])."</td><td class=\"hidden-phone\"><button  onclick=\"dAzNids('cancella', ".$prod['id'].", 'utente')\">Elimina</button></td></tr>";
                }
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  $(document).ready(function() {
    var oTable = $('#hidden-table-info').dataTable({
      "aaSorting": [
        [1, 'asc']
      ],
      "oLanguage": {
          "sEmptyTable":     "Nessun utente presente nella tabella",
          "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ utenti",
          "sInfoEmpty":      "Vista da 0 a 0 di 0 utenti",
          "sInfoFiltered":   "(filtrati da _MAX_ utenti totali)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ".",
          "sLengthMenu":     "Visualizza _MENU_ utenti",
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