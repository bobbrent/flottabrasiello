<?php
  include 'fun.php';
  $sede =  $dati['sede'];
  $piazzali = tellMePiazzaliSEDE($sede);
  $marche = tellMeMarche();
  $modelli = tellMeModelli();
  $flotta = tellMeFlotta();
?>
<style>
  #piazzale{
    width:140px;
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
            Scegli data: <input type="text" class="dates" id="data_scelta" style="color: black;" autocomplete="off">
            ora:
            <select onclick="cambia();" class="input-sm" id="ora_scelta">
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
            <select onclick="cambia();" class="input-sm" id="minuti_scelta">
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
          <div class="form-group">         
              <p class="label bb1"> Flotta</p>
              <!-- <input class="input-sm" type="text" id="flotta" autocomplete="on" list="flotte"> -->
              <select class="input-sm" id="flotta">
                <option>ALD</option>
                <option>ALD_FINELEASING</option>
                <option>ALD_NUOVO</option>
                <option>ALPHABET</option>
                <option>ATHLON</option>
                <option>B-RENT</option>
                <option>DRIVALIA</option>
                <option>LEASEPLAN</option>
                <option>LEASYS</option>
                <option>RENT2GO</option>
                <option>SIFA</option>
                <option>UNIPOL_RENT</option>
                <option>VENDITA</option>
                <option>VOLKSWAGER_LEASEY</option>
              </select>
              <p class="label bb1"> Tipo Veicolo</p><input class="input-sm" type="text" id="tipo_veicolo" autocomplete="on" list="tipo">
               <p class="label bb1"> Piazzale</p>
              <select id="piazzale">
               <option> -- </option>
               <?     
                for($i = 0; $i<2; $i++){
                  printf('<option value="%d">%s</option>', $piazzali[$i][0], addslashes($piazzali[$i][1]));
                }
               ?>
              </select>
             <!-- <p class="label bb1"> Piazzale</p><input class="input-sm w150" type="text" id="piazzale"> -->
             <p class="label bb1"> Targa</p><input class="input-sm" type="text" id="targa">
             <p class="label bb1"> Telaio</p><input class="input-sm" type="text" id="telaio">
          </div>
          <div class="form-group">         
            <p class="label bb1"> Marca</p><input class="input-sm" type="text" id="marca" autocomplete="on" list="marche">
            <p class="label bb1"> Modello</p><input class="input-sm" type="text" id="modello" autocomplete="on" list="modelli">
            <p class="label bb1"> Colore</p><input class="input-sm" type="text" id="colore" autocomplete="on" list="colori">
            <p class="label bb1"> Km</p><input class="input-sm" type="text" id="km">
          </div>
          <div class="form-group" style="width:15px">         
            <label class="label bb"> Bolla di Arrivo<input class="input-sm selezioni" type="checkbox" id="bolla_arrivo" checked><span class="checkmark"></span></label><hr class="inn">
            <label class="label bb"> Doppia Chiave<input class="input-sm selezioni" type="checkbox" id="doppia_chiave" checked><span class="checkmark"></span></label><hr class="inn">
            <label class="label bb"> Libretto di Circolazione<input class="input-sm selezioni" type="checkbox" id="libretto_circolazione" checked><span class="checkmark"></span></label><hr class="inn">
            <label class="label bb"> SD Card<input class="input-sm selezioni" type="checkbox" id="sd_card" checked><span class="checkmark"></span></label><hr class="inn">
            <label class="label bb"> Tappetini<input class="input-sm selezioni" type="checkbox" id="tappetini" checked><span class="checkmark"></span></label><hr class="inn">
            <label class="label bb"> Ruota di Scorta/Kit Gonfiaggio<input class="input-sm selezioni" type="checkbox" id="rscorta_gonfiaggio" checked><span class="checkmark"></span></label><hr class="inn">
            <label class="label bb"> Antenna<input class="input-sm selezioni" type="checkbox" id="antenna" checked><span class="checkmark"></span></label><hr class="inn">
            <label class="label bb"> Libretto Uso/Manutenzione<input class="input-sm selezioni" type="checkbox" id="libretto_manutenzione" checked><span class="checkmark"></span></label>
          </div>
          <p class="label bb"> Note</p><textarea class="input-sm" type="text" id="note"></textarea>
        </div>
        <div class="col-lg-6">
          <button class="pulsante" onclick="inserisci();" id="inserisci">Inserisci Veicolo</button>
          <button class="pulsante" onclick="selezionaTutto();">Seleziona Tutti</button> 
          <button class="pulsante" onclick="pulisciSelezione();">Deseleziona</button> 
        </div>
      </div>
    </div>
  </div>
  <div class="row mb">
    <div class="content-panel">
      <div class="col-lg-12">
        <h4>Veicoli Inseriti</h4>
        <div class="adv-table">
					<table  cellpadding="0" cellspacing="0" border="0"  class="veicoli display table table-bordered">
						<thead>
							<tr>
								<th>TIPO</th>
								<th>PIAZZALE</th>
								<th>TARGA</th>
								<th>TELAIO</th>
								<th>MARCA</th>
								<th>MODELLO</th>
								<th>COLORE</th>
								<th>KILOMETRAGGIO</th>
								<th>B.ARRIVO</th>
								<th>D.CHIAVE</th>
								<th>L.CIRC.</th>
								<th>SD</th>
								<th>TAPP.</th>
								<th>R.SCOR./KIT G.</th>
								<th>ANT.</th>
								<th>L.MANUT.</th>
								<th>NOTE</th>
							</tr>
						</thead>
						<tbody id="bodytab">

						</tbody>
					</table>
        </div>
      </div>
    </div>
  </div>
</section>

<datalist id="marche">
  <?
    foreach($marche as $m){
      echo "<option>".$m[0]."</option>";
    }
  ?>
</datalist>

<datalist id="modelli">
  <?
    foreach($modelli as $m){
      echo "<option>".$m[0]."</option>";
    }
  ?>
</datalist>

<datalist id="colori">
  <option>Bianco</option>
  <option>Nero</option>
  <option>Rosso</option>
  <option>Blu</option>
  <option>Giallo</option>
  <option>Verde</option>
  <option>Viola</option>
  <option>Grigio</option>
  <option>Beige</option>
  <option>Marrone</option>
  <option>Porpora</option>
  <option>Azzurro</option>
</datalist>

<datalist id="tipo">
  <option>Nuovo</option>
  <option>Usato</option>
  <option>Dissequestro</option>
</datalist>

<!-- <datalist id="flotte">
  <?
    // foreach($flotta as $f){
      ?>
        <option><?
        // echo $f[0];
        ?></option>
      <?
    // }
  ?>
</datalist> -->

<script type="text/javascript">
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

  $(document).ready(function() {
    // var oTable = $('.veicoli').dataTable({
    //   "aaSorting": [
    //     [1, 'desc']
    //   ],
    //   "oLanguage": {
    //       "sEmptyTable":     "Nessun veicolo inserito",
    //       "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ veicoli",
    //       "sInfoEmpty":      "Vista da 0 a 0 di 0 veicoli",
    //       "sInfoFiltered":   "(filtrati da _MAX_ veicoli totali)",
    //       "sInfoPostFix":    "",
    //       "sInfoThousands":  ".",
    //       "sLengthMenu":     "Visualizza _MENU_ veicoli",
    //       "sLoadingRecords": "Caricamento...",
    //       "sProcessing":     "Elaborazione...",
    //       "sSearch":         "Cerca:",
    //       "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
    //       "oPaginate": {
    //           "sFirst":      "Inizio",
    //           "sPrevious":   "Precedente",
    //           "sNext":       "Successivo",
    //           "sLast":       "Fine"
    //       },
    //       "oAria": {
    //           "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
    //           "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
    //       }
    //   }
    // });
  });

  function inserisci(){
    rcr = tiraArray();
    var cc = 0;
    for(i=0;i<8;i++){
      if(rcr[i] === ""){
        cc++;
      }
    }
    if(cc > 2 || rcr[6] === "" || rcr [0] === " -- "){
      alert('Controllare i dati inseriti.');
    }else{
      aggiungiadb(rcr);
    }
  }

  Number.prototype.padLeft = function(base,chr){
    var  len = (String(base || 10).length - String(this).length)+1;
    return len > 0? new Array(len).join(chr || '0')+this : this;
  }

  function cambia(){
    var d = new Date;
    dformat =  d.getFullYear() + '-'
             + ('0' + (d.getMonth()+1)).slice(-2) + '-'
             + ('0' + d.getDate()).slice(-2);

    document.getElementById('data_scelta').value = dformat;
  }

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
      }else if(ora < 10 && ora > 0){
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
    console.log(dformat);
		dato = ar;
    if(!data_scelta){
		  var r = confirm("Aggiungere " + dato[4] + " "+ dato[5] +  " per la data " + dformat +" ?")

    }else{
		  var r = confirm("Aggiungere " + dato[4] + " "+ dato[5] +  " per la data " + data_scelta +" ?")
    }
		if (r) {
			$.post('parts/pages/nuovoveicolo.php', {
				dati: dato,
        sede: '<?php echo $sede;?>',
        datas: dformat
			}, function(data) {
				// $("#main-content").html(data).show();
        console.log(data);
        if(data == 3){
          $('#bodytab').append( "<tr style='    color: red;'><td>VEICOLO<BR>NON<BR>INSERITO<br>ERRORE<BR>DATA</td><td>" + $('#piazzale option:selected').text()  + 
            "</td><td>" + dato[1] + 
            "</td><td>" + dato[2] + 
            "</td><td>" + dato[3] + 
            "</td><td>" + dato[4] + 
            "</td><td>" + dato[5] + 
            "</td><td>" + dato[6] + 
            "</td><td>" + dato[8] + 
            "</td><td>" + dato[9] + 
            "</td><td>" + dato[10] + 
            "</td><td>" + dato[11] + 
            "</td><td>" + dato[12] + 
            "</td><td>" + dato[13] + 
            "</td><td>" + dato[14] + 
            "</td><td>" + dato[15] + 
            "</td><td>" + dato[7] + 
            "</td></tr>" );

            nuovoVeic({ 'fxf': 'full', 'c1': 'temp', 'pag': 'temp', 'who':'utente', 'sede':'<?php echo $sede;?>'});
            clearR();

        }else{
          if(data == 1){
            $('#bodytab').append( "<tr><td>" + rcr[16] + 
            "</td><td>" + $('#piazzale option:selected').text()  + 
            "</td><td>" + dato[1] + 
            "</td><td>" + dato[2] + 
            "</td><td>" + dato[3] + 
            "</td><td>" + dato[4] + 
            "</td><td>" + dato[5] + 
            "</td><td>" + dato[6] + 
            "</td><td>" + dato[8] + 
            "</td><td>" + dato[9] + 
            "</td><td>" + dato[10] + 
            "</td><td>" + dato[11] + 
            "</td><td>" + dato[12] + 
            "</td><td>" + dato[13] + 
            "</td><td>" + dato[14] + 
            "</td><td>" + dato[15] + 
            "</td><td>" + dato[7] + 
            "</td></tr>" );

            nuovoVeic({ 'fxf': 'full', 'c1': 'temp', 'pag': 'temp', 'who':'utente', 'sede':'<?php echo $sede;?>'});
            clearR();

          }else{
            $('#bodytab').append( "<tr style='    color: red;'><td>VEICOLO<BR>NON<BR>INSERITO</td><td>" + $('#piazzale option:selected').text()  + 
            "</td><td>" + dato[1] + 
            "</td><td>" + dato[2] + 
            "</td><td>" + dato[3] + 
            "</td><td>" + dato[4] + 
            "</td><td>" + dato[5] + 
            "</td><td>" + dato[6] + 
            "</td><td>" + dato[8] + 
            "</td><td>" + dato[9] + 
            "</td><td>" + dato[10] + 
            "</td><td>" + dato[11] + 
            "</td><td>" + dato[12] + 
            "</td><td>" + dato[13] + 
            "</td><td>" + dato[14] + 
            "</td><td>" + dato[15] + 
            "</td><td>" + dato[7] + 
            "</td></tr>" );

            nuovoVeic({ 'fxf': 'full', 'c1': 'temp', 'pag': 'temp', 'who':'utente', 'sede':'<?php echo $sede;?>'});
            clearR();

          }
        }
			});
		}
  }

  function tiraArray(){
    var libusma = $('#libretto_manutenzione').is(':checked');
    var antenna = $('#antenna').is(':checked');
    var rscogo = $('#rscorta_gonfiaggio').is(':checked');
    var tappetini = $('#tappetini').is(':checked');
    var sd = $('#sd_card').is(':checked');
    var libcir = $('#libretto_circolazione').is(':checked');
    var dchiave = $('#doppia_chiave').is(':checked');
    var bolla = $('#bolla_arrivo').is(':checked');

    // var piazzale = $('#piazzale option:selected').text();
    var piazzale = $('#piazzale option:selected').val();
    var tipo = $('#tipo_veicolo').val().toUpperCase();
    var flotta = $('#flotta').val().toUpperCase();
    var targa = $('#targa').val().toUpperCase();
    var telaio = $('#telaio').val().toUpperCase();
    var marca = $('#marca').val().toUpperCase();
    var modello = $('#modello').val().toUpperCase();
    var colore = $('#colore').val().toUpperCase();
    var km = $('#km').val();
    var note = $('#note').val().toUpperCase();
    var rcr = [piazzale, targa, telaio, marca, modello, colore, km, note, libusma, antenna, rscogo, tappetini, sd, libcir, dchiave, bolla, tipo, flotta];
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

  $("#piazzale").chosen({
    width: "240px",
    allow_single_deselect: true,
    placeholder_text: "Seleziona Piazzale",
    max_selected_options: 25,
    no_results_text: "Piazzale non trovato: "
    });
</script>