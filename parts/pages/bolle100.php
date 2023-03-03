<?php
  include 'fun.php';
  
  if($dati['who'] == 'admin'){
    $quer = "SELECT * FROM `bolla`";
  }else{
    $sede = addslashes($dati['sede']);
    $quer = "SELECT * FROM `bolla` WHERE `sede` = '$sede'";
  }
  
  $bolle = tellMeBolle($quer);
  
?>
<style>
  .nuvau{
    margin: 0px 0px 5% -40%;
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
				<div class="adv-table">
					<table  cellpadding="0" cellspacing="0" border="0"  class="veicoli display table table-bordered">
						<thead>
							<tr>
								<th>N BOLLA</th>
								<th>DATA</th>
								<th>DESTINAZIONE</th>
								<th>VETTORE</th>
								<th>NOTE</th>
							</tr>
						</thead>
						<tbody>
            <?
            foreach ( $bolle as $v ){
                $stringa = "<tr><td><a target='_blank' href='pdfbolla.php?bolla=%d'>%s</a></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
                $destinatario = json_decode($v[5]);
                $destinazione = json_decode($v[6]);

                $desti = $destinatario[0]." | Via ".$destinazione[0]." n ".$destinazione[1].", (".$destinazione[2].") ".$destinazione[3];
                printf($stringa, $v[0], $v[1],formattaDataLogin($v[2]),$desti,$v[8],$v[9]);  
            }
            ?>
						</tbody>
					</table>
      	</div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function() {
    var oTable = $('.veicoli').dataTable({
      "aaSorting": [
        [1, 'desc']
      ],
      "oLanguage": {
          "sEmptyTable":     "Nessuna bolla presente nella tabella",
          "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ bolle",
          "sInfoEmpty":      "Vista da 0 a 0 di 0 bolle",
          "sInfoFiltered":   "(filtrati da _MAX_ bolle totali)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ".",
          "sLengthMenu":     "Visualizza _MENU_ bolle",
          "sLoadingRecords": "Caricamento...",
          "sProcessing":     "Elaborazione...",
          "sSearch":         "Cerca:",
          "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
          "oPaginate": {
              "sFirst":      "Inizio",
              "sPrevious":   "Precedente",
              "sNext":       "Successivo",
              "sLast":       "Fine"
          },
          "oAria": {
              "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
              "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
          }
      }
    });
  });
</script>