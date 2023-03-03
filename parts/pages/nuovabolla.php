<?php
  include 'fun.php';

  if($dati['who'] == 'utente'){
    $sede =  $dati['sede'];
    $prg = tellMeProgressivo($sede);
    $dat = date('y');
    $next = $prg[0][3] + 1;
    $numero_bolla = $prg[0][2]."-".$dat."/".$next;
    $veicoli = tellMeCarForDDT($sede);
    // print_r($veicoli);
    // echo $numero_bolla;
  }if($dati['who'] == 'admin'){
    $numero_bolla = "<h1>QUEST UTENTE NON PUÒ OPERARE SUI VEICOLI</h1>";
    ?>
    <script>dAzN('home')</script>
    <?
  }

  $data = date('Y-m-d H:i');
  
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
        <div><?php 
          if(isset($dati['ultima_bolla'])){ 
            $idds = tellMeIdBolla($dati['ultima_bolla']);
            printf("<a target='_blank' href='pdfbolla.php?bolla=%d'>UltimaBolla %s</a>", $idds[0][0], $dati['ultima_bolla']);
            }?>
            </div>
        <div class="form" id="nuovomezzo">
          <div class="form-group">         
             <h3> DDT N <br><h2><? echo $numero_bolla;?></h2> <br>del <? echo formattaDataLogin($data);?></h3> <br>
             <div class="form-group">
              Scegli data: <input type="text" class="dates" id="data_scelta" style="color: black;" autocomplete="off">
              ora:
              <select class="input-sm" id="ora_scelta">
                  <option value="0">00</option>
                  <option value="1">01</option>
                  <option value="2">02</option>
                  <option value="3">03</option>
                  <option value="4">04</option>
                  <option value="5">05</option>
                  <option value="6">06</option>
                  <option value="7">07</option>
                  <option value="8" selected>08</option>
                  <option value="9">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                </select>
              minuti: 
              <select class="input-sm" id="minuti_scelta">
                  <option>00</option>
                  <option>10</option>
                  <option>15</option>
                  <option>20</option>
                  <option>25</option>
                  <option>30</option>
                  <option>35</option>
                  <option>40</option>
                  <option>45</option>
                  <option>50</option>
                  <option>55</option>
                </select>
            </div>

             <!-- <p class="label bb1"> Piazzale</p><input class="input-sm w150" type="text" id="piazzale"> -->
             DESTINATARIO<hr>
             <p class="label bb1"> Nome/Ditta</p><input class="input-sm" type="text" style="width:100%" id="nome" required><br>
             Indirizzo<br>
             <p class="label bb1"> Via</p><input class="input-sm" type="text" id="viadest">
             <p class="label bb1"> Città</p><input class="input-sm" type="text" id="cittadest">
             <p class="label bb1"> Prov</p><input class="input-sm" maxlength="2" type="text" id="provdest">
             <p class="label bb1"> Cap</p><input class="input-sm" type="text" id="capdest"><br>
             Cod. Fiscale/P.IVA<br>
             <input class="input-sm" type="text" id="codpiva"><hr>
              LUOGO DI DESTINAZIONE<BR> (lasciare vuoto se uguale)<br>
             <p class="label bb1"> Via</p><input class="input-sm" type="text" id="vialuo">
             <p class="label bb1"> Città</p><input class="input-sm" type="text" id="cittaluo">
             <p class="label bb1"> Prov</p><input class="input-sm" maxlength="2" type="text" id="provluo">
             <p class="label bb1"> Cap</p><input class="input-sm" type="text" id="capluo">
          </div>
          <div class="form-group">   
            CAUSALE DEL TRASPORTO 
           <textarea style="width:100%" id="causale"></textarea>
          </div>
          <div class="form-group">   
            VETTORI
            <br><input class="input-sm" type="text" style="width:100%" id="vettore"><br>
            ANNOTAZIONI
           <textarea style="width:100%" id="annotazioni"></textarea>
          </div>
          <div class="form-group">         
            <select id="veicoli" multiple="">
              <?
                foreach($veicoli as $v){
                  echo "<option value='".$v[0]."'>".$v[6]." ".$v[7]." ".$v[8]." ".$v[4]." ".$v[5]."</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <button class="pulsante" onclick="inserisci();" id="inserisci">Crea DDT</button>
        </div>
        <br><br><br><br>
      </div>
    </div>
  </div>
 
</section>
<script type="text/javascript">

  function inserisci(){
    rcr = tiraArray();
    // console.log(rcr);
    var cc = 0;
    for(i=0;i<13;i++){
      if(rcr[i] == ""){
        cc++;
      }
    }
    if(cc > 8){
      alert('Controllare i dati inseriti.');
    }else if(!rcr[13]){
      alert('Nessun Veicolo Selezionato.');
    }else{
      aggiungiadb(rcr);
    }
  }

  Number.prototype.padLeft = function(base,chr){
    var  len = (String(base || 10).length - String(this).length)+1;
    return len > 0? new Array(len).join(chr || '0')+this : this;
  }

  // var inizio = new Date();
  // var inizioformattato = [inizio.getFullYear().padLeft(),
  //             (inizio.getMonth()+1).padLeft(),
  //             inizio.getDate()].join('-');

  // $("#data_scelta")[0].value = inizioformattato;
  // $("#ora_scelta")[0].value = inizio.getHours().padLeft();
  // $("#minuti_scelta")[0].value = inizio.getMinutes().padLeft();

  function aggiungiadb(ar){
    var data_scelta = document.getElementById('data_scelta').value;
    if(!data_scelta){
      var d = new Date,
      dformat = [d.getFullYear().padLeft(),
                (d.getMonth()+1).padLeft(),
                d.getDate()].join('-') +' ' +
                [d.getHours().padLeft(),
                  d.getMinutes().padLeft(),
                  d.getSeconds().padLeft()].join(':');
    }else{
      var ora = document.getElementById('ora_scelta').value ;
      var minuti = document.getElementById('minuti_scelta').value;

      if(ora === "0"){
        ora = "0" + ora;
      }else if(ora < 10){
        ora = ora - 1; 
        ora = "0" + ora;
      }else{
        ora = ora - 1;
      }

 

      var orario = "T" + ora + ":" + minuti + ":00Z";

      console.log(orario);
      var d = new Date(data_scelta + orario);
      dformat = [d.getFullYear().padLeft(),
                (d.getMonth()+1).padLeft(),
                d.getDate()].join('-') +' ' +
                [d.getHours().padLeft(),
                  d.getMinutes().padLeft(),
                  d.getSeconds().padLeft()].join(':');
    }
    // console.log(ar);
		dato = ar;
		var r = confirm("Emettere Bolla per " + dato[0]  +  "?")
		if (r) {
			$.post('parts/pages/bolla.php', {
				dati: dato,
        sede: '<?php if($dati['who'] == 'utente') echo $sede;?>',
        datas: dformat,
        progressivo: '<?php echo $numero_bolla;?>',
        ultimo: '<?php if($dati['who'] == 'utente')  echo $next;?>'
			}, function(data) {
				// $("#main-content").html(data).show();
        // console.log(data);
        rldescend({ 'fxf': 'full', 'c1': 'nuovabolla', 'pag': 'nuovabolla', 'who':'utente', 'sede' : '<?php echo $dati['sede'];?>', ultima_bolla: '<?php echo $numero_bolla;?>'});clearR();
			});

      // nuovoVeic({ 'fxf': 'full', 'c1': 'temp', 'pag': 'temp', 'who':'utente'});
      // clearR();
		}
  }

  function tiraArray(){
    var nome = $('#nome').val();
    var viadest = $('#viadest').val();
    var cittadest = $('#cittadest').val();
    var provdest = $('#provdest').val();
    var capdest = $('#capdest').val();

    var vialuo = $('#vialuo').val();
    var cittaluo = $('#cittaluo').val();
    var provluo = $('#provluo').val();
    var capluo = $('#capluo').val();

    var codpiva = $('#codpiva').val();
    var vettore = $('#vettore').val();

    var causale = $('#causale').val();
    var annotazioni = $('#annotazioni').val(); 

    var veicoli = $('#veicoli').val();

    var rcr = [nome, viadest, cittadest, provdest, capdest, vialuo, cittaluo, provluo, capluo, codpiva, vettore, causale, annotazioni, veicoli];

    return rcr;
  }

  function pulisciSelezione(){
    $( "input[type='checkbox']" ).prop( "checked", function( i, val ) {
      return false;
    });
  }

  function selezionaTutto(){
    $( "input[type='checkbox']" ).prop( "checked", function( i, val ) {
      return true;
    });
  }

  $("#veicoli").chosen({
    width: "100%",
    placeholder_text: "Seleziona Veicolo/i",
    max_selected_options: 25,
    no_results_text: "Veicolo non trovato: ",
    search_contains: true
  });

  $(document).ready(function () {
      $(".dates").datepicker({
      closeText: "Chiudi",
      prevText: "&#x3C;Prec",
      nextText: "Succ&#x3E;",
      currentText: "Oggi",
      monthNames: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
      monthNamesShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
      dayNames: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"],
      dayNamesShort: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"],
      dayNamesMin: ["Do", "Lu", "Ma", "Me", "Gi", "Ve", "Sa"],
      weekHeader: "Sm",
      dateFormat: "yy-mm-dd",
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ""
    });
  });

</script>