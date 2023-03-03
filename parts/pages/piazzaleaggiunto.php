<?php
include 'fun.php';

$piazzale = $_POST['dati'];
aggiungiPiazzale($piazzale[0]);


?>
<section class="wrapper site-min-height">
    <div class="row mt">
      <div class="col-lg-12">
        <div class="col-md-6">
          <h4>Piazzale Aggiunto</h4>
        </div>
        <div class="col-md-6">

        </div>
        <div class="col-md-6" id="ordine" style="background: white;padding: 15px;border-radius: 10px;">
          <h4>Sede: <?php echo $piazzale[0][0]; ?></h4>
        </div>
        <div class="col-md-6">
        </div>
      </div>
    </div>
</section>
