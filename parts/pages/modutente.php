<?php
include 'fun.php';

$ut = $_POST['dati'];

aggiornaUtente($ut[0][0], $ut[0][1]);

?>

<section class="wrapper site-min-height">
    <h3><i class="fa fa-angle-right"></i> Utente Aggiornato</h3>
    <div class="row mt">
      <div class="col-lg-12">
        <div class="col-md-6">
        </div>
      </div>
    </div>
  </section>
