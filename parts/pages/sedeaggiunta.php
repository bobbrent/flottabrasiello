<?php
include 'fun.php';

$sede = $_POST['dati'];
aggiungiSede($sede[0]);


?>
<section class="wrapper site-min-height">
    <div class="row mt">
      <div class="col-lg-12">
        <div class="col-md-6">
          <h4>Sede Aggiunta</h4>
        </div>
        <div class="col-md-6">

        </div>
        <div class="col-md-6" id="ordine" style="background: white;padding: 15px;border-radius: 10px;">
          <h4>Sede: <?php echo $sede[0][0]; ?></h4>
        </div>
        <div class="col-md-6">
        </div>
      </div>
    </div>
</section>
