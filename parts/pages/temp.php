<?php
include 'fun.php';
$sede =  $dati['sede'];
$piazzali =  tellMePiazzaliSEDE($sede);
?>
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
<div class="form-group">
  <p class="label bb1"> Flotta</p>
  <!-- <input class="input-sm" type="text" id="flotta" autocomplete="on" list="flotte"> -->
  <select class="input-sm" id="flotta">
    <option>ALD</option>
    <option>ALD_FINELEASING</option>
    <option>ALD_NUOVO</option>
    <option>LEASEPLAN</option>
    <option>LEASYS</option>
    <option>SIFA</option>
    <option>RENT2GO</option>
    <option>UNIPOL_RENT</option>
    <option>VOLKSWAGER_LEASEY</option>
    <option>ATHLON</option>
    <option>ALPHABET</option>
    <option>B-RENT</option>
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
  <label class="label bb"> Bolla di Arrivo<input class="input-sm selezioni" type="checkbox" id="bolla_arrivo" checked><span class="checkmark"></span></label>
  <hr class="inn">
  <label class="label bb"> Doppia Chiave<input class="input-sm selezioni" type="checkbox" id="doppia_chiave" checked><span class="checkmark"></span></label>
  <hr class="inn">
  <label class="label bb"> Libretto di Circolazione<input class="input-sm selezioni" type="checkbox" id="libretto_circolazione" checked><span class="checkmark"></span></label>
  <hr class="inn">
  <label class="label bb"> SD Card<input class="input-sm selezioni" type="checkbox" id="sd_card" checked><span class="checkmark"></span></label>
  <hr class="inn">
  <label class="label bb"> Tappetini<input class="input-sm selezioni" type="checkbox" id="tappetini" checked><span class="checkmark"></span></label>
  <hr class="inn">
  <label class="label bb"> Ruota di Scorta/Kit Gonfiaggio<input class="input-sm selezioni" type="checkbox" id="rscorta_gonfiaggio" checked><span class="checkmark"></span></label>
  <hr class="inn">
  <label class="label bb"> Antenna<input class="input-sm selezioni" type="checkbox" id="antenna" checked><span class="checkmark"></span></label>
  <hr class="inn">
  <label class="label bb"> Libretto Uso/Manutenzione<input class="input-sm selezioni" type="checkbox" id="libretto_manutenzione" checked><span class="checkmark"></span></label>
</div>
<p class="label bb"> Note</p><textarea class="input-sm" type="text" id="note"></textarea>

<script>
  $("#piazzale").chosen({
    width: "240px",
    allow_single_deselect: true,
    placeholder_text: "Seleziona Piazzale",
    max_selected_options: 25,
    no_results_text: "Piazzale non trovato: "
  });

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
</script>