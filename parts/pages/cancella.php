<?php
  include 'fun.php';
  $id = $dati['id'];
  switch($dati['cosa']){
    case 'utente': $where = 'login';break;
    case 'veicolo': $where = 'macchina';break;
  }
  cancella($where, $id);
?>
<section class="wrapper site-min-height">
  <h3><i class="fa fa-angle-right"></i> <?php echo 'Eliminazione '.ucfirst($dati['cosa']);?></h3>
  <div class="row mt">
    <div class="col-lg-12">
      <pre>
        <?php
          echo ucfirst($dati['cosa']) . " Eliminato.";
        ?>
      </pre>
    </div>
  </div>
</section>