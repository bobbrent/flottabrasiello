<?php
  include 'fun.php';

  $veicoli = tellMeCarsCancellazione();
  function formattaDatano($data){
    if($data == "0000-00-00 00:00:00"){
      return "";
    }else if($data == NULL){
  
    }else{
      $right = date('d/m/Y', strtotime($data));
      return $right;
    }
  }
  // echo "<pre>";
  // print_r($veicoli);
  // echo "</pre>";
?>
<style>
  .pulsante{
    float:left;
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
 
  .bb:hover input ~ .checkmark {
    background-color: #ccc;
  }
 
  .bb input:checked ~ .checkmark {
    background-color: black;
  } 

  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }
  
  .bb input:checked ~ .checkmark:after {
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

  .inn{
    margin-top: 7px;
    margin-bottom: 2px;
    width: 180px;
  }

  .input-sm{
    margin: 5px 0px;
  }

  button:active{
    background-color:lightgray;
    border-radius:3px;
  }

  .w150{
    width: 335px;
  }

  .bb{
    color:black;
    padding-top: 8px;
  }

  .bb1{
    color:black;
  }

  .form{
    text-align: center;
    display: inline-grid;
  }

	.content-panel {
		padding: 66px;
	}

	.site-min-height {
		min-height: calc(100vh - 113px);
	}

	th, tr {
    cursor: pointer;
	}

	th{
		background: rgba(200,200,200,0.4)
	}

	tr:hover{
		background: rgba(200,200,200,0.4)
	}
</style>
<section class="wrapper site-min-height">
  <div class="row mb">
    <div class="content-panel">
      <div class="col-lg-12">
        <div class="form" id="nuovomezzo">
          <div class="form-group">         
            
          <div class="form-group">         
            <select id="veicoli" >
              <?
              //  [id] => 1
              //  [id_piazzale] => 6
              //  [sede] => NA_BRAS01-
              //  [tipo_veicolo] => NUOVO
              //  [targa] => 
              //  [telaio] => WFOWXXGCEWHM69626
              //  [marca] => FORD
              //  [modello] => C-MAX
              //  [colore] => 
              //  [data_arrivo] => 2017-04-28 08:00:00
              //  [presenza_bolla_arrivo] => 0
              //  [km] => 0
              //  [doppia_chiave] => 0
              //  [libretto_circolazione] => 0
              //  [sd_card] => 0
              //  [tappetini] => 0
              //  [rscorta_gonfiaggio] => 0
              //  [antenna] => 0
              //  [libretto_manutenzione] => 0
              //  [data_uscita] => 2017-06-06 08:00:00
              //  [bolla_uscita] => 
              //  [note] => 
              //  [flotta] => ALD
                foreach($veicoli as $v){
                  echo "<option value='".$v['id']."'>SEDE: ".$v['sede']." | ".$v['tipo_veicolo']." | ".$v['marca']." ".$v['modello']." TA.: ".$v['targa']." TE.: ".$v['telaio']." D.ING.: ".formattaDatano($v['data_arrivo'])." D.USC.: ".formattaDatano($v['data_uscita'])."</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <button class="pulsante" onclick="cancella();" id="cancella">Cancella Veicolo</button>
        </div>
        <br><br><br><br>
      </div>
    </div>
  </div>
 
</section>
<script type="text/javascript">

  function cancella(){
    var id_macchina = $('#veicoli').val();
    var co = $('#veicoli')[0][$('#veicoli')[0].selectedIndex].innerText;
    var r = confirm("Cancellare " + co + " ?");
		if (r) {
      dAzNids('cancella', id_macchina, 'veicolo');
    }
  }


  $("#veicoli").chosen({
    width: "900px",
    placeholder_text: "Seleziona Veicolo/i",
    max_selected_options: 25,
    no_results_text: "Veicolo non trovato: ",
    search_contains: true
  });


</script>