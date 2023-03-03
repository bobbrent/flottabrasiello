<?php
include 'fun.php';

$utent = $_POST['dati'];
if($utent[0][2] == 2){
	$sedi = json_encode($utent[0][3]);
	$idutente = nuovoutenteStation($utent[0][0], $utent[0][1], $utent[0][2], $sedi);
} else{
	$idutente = nuovoutente($utent[0][0], $utent[0][1], $utent[0][2]);
}

$utente = tellMeUtente($idutente);

?>
<section class="wrapper site-min-height">
    <div class="row mt">
      <div class="col-lg-12">
        <div class="col-md-6">
          <h4>Utente Aggiunto</h4>
        </div>
        <div class="col-md-6">

        </div>
        <div class="col-md-6" id="ordine" style="background: white;padding: 15px;border-radius: 10px;">
          <h4>Utente: <?php echo $utente; ?></h4>
        </div>
        <div class="col-md-6">

        </div>
      </div>
    </div>
</section>
