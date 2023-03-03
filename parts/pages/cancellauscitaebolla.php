<section class="wrapper site-min-height">
  <h3 id="testo"><i class="fa fa-angle-right"></i> </h3>
  <div class="row mt">
    <div class="col-lg-12">
      <pre>
        <?php
          include 'fun.php';
          $id_veicolo = $dati['id'];
          $bolla = tellMeIdBolla($dati['progressivo'])[0][0];
          $dettagli = tellMeDettagliBolla($bolla);
          $id_macchine = json_decode($dettagli[0][4]);
          $veicoli = tellMeMacchineBolla($id_macchine);
          $testo = '';
          $testo .= '<br>'.togliUscitaEBolla($id_veicolo).'<br>';
          $testo .= togliMacchinaDaBolla($id_veicolo, $id_macchine, $bolla);
          // echo $dettagli[0][$id_veicolo];
          // print_r($bolla);
          // echo "</pre>";
          // echo "veicoli <pre>";
          // print_r($veicoli);
          // echo "</pre>";
          // echo "veicoli <pre>";
          // print_r($veicoli[cercaMacchina($veicoli,$id_veicolo)]);
          $dettagli_macchina = $veicoli[cercaMacchina($veicoli,$id_veicolo)];
          $testo .= "<br>Per il veicolo ". $dettagli_macchina[6] . " " . $dettagli_macchina[7];
          if($dettagli_macchina[4]){
            $testo .= " Targa: ". $dettagli_macchina[4];
          }else{
            $testo .= " Telaio: ". $dettagli_macchina[5];
          }
          echo $testo;

          function cercaMacchina($ar,$id){
            $cont = 0;
            foreach($ar as $x){
              foreach($x as $y => $z){
                if($z == $id){
                  return $cont;
                }
              }
              $cont++;
            }
            return 0;
          }

        ?>
      </pre>
    </div>
  </div>
</section>