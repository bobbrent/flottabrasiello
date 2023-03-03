<?php
	include 'fun.php';
	include '../php/func.php';


	$datinps = infoNps($id);
	$numero_contratto = $datinps['804856X13X106'];
	$voto = valuTacsat($datinps['804856X13X81SQ001']);
	$risolto = risoluzioneNps($id);
	$commento =  htmlXspecialchars($datinps['804856X13X82']);
	$note = tellMeNoteNps($id);
?>
<style>
	.second-part {
		width: 45% !important;
	}
	.group-rom .third-part {
		width: 30% !important;
	}
	#nuova_nota{
		margin: 0 auto;
		max-width: 81px;
    font-size: 10px;
    padding: 9px;
	}
	.chat-tools {
		float: right;
		padding: 8px;
		width: 127px;
		height: 35px;
		line-height: 11px;
		border-radius: 3px;
		-webkit-border-radius: 3px;
		text-align: center;
		margin-top: 6px;
		margin-left: 10px;
	}
</style>

<section class="wrapper site-min-height">
	<div class="chat-room mt">
		<aside class="mid-side">
			<div class="chat-room-head" style="background: #97BF0E;">
				<h3>Note Contratto:  <?php echo $numero_contratto;?> |  Stato:  <?php echo $risolto; ?> </h3>
			</div>
			<?php
				$cont = 0;
				$count = 0;
				if(is_array($note)){
					foreach($note as $n){
						if($count < count($note) - 1){$group_class = "group-rom"; $count++;}else{$group_class = "group-rom last-group";}
						if($cont == 0){$class = 'first-part odd'; $cont = 1;}else{$class = 'first-part';$cont = 0;}
						?>
						<div class="<?php echo $group_class;?>">
							<div class="<?php echo $class;?>"><?php echo tellMeOperatore($n[0]);?></div>
							<div class="second-part"><?php echo htmlXspecialchars($n[1]);?></div>
							<div class="third-part"><?php echo formattaDataLogin($n[2]);?></div>
						</div>
						<?php
					}
				}else{
					?>
					<div class="group-rom">
						<div class="first-part odd">Nessuna Nota</div>
						<div class="second-part"></div>
						<div class="third-part"></div>
					</div>
					<?php
				}
			?>
			<footer>
				<div class="chat-txt">
					<input type="text" id="testo_nota" class="form-control">
				</div>
				<button class="btn btn-theme" onclick="nota();" id="nuova_nota">Ins. Nota</button>
				<button class="btn btn-theme" onclick="refresh();">Ricarica Note</button>
			</footer>
		</aside>
		<aside class="right-side">
			<div class="user-head" style="height: 115px;margin-bottom: 15px;">
				<a href="#"  onclick="risolviNota();" class="chat-tools btn-theme"><i class="fa fa-check"></i> Risolto</a>
			</div>

			<h4 style="color: black;margin: 0 10px;">Stato:</h4>
			<ul class="chat-available-user">
				<li> <?php echo $risolto;?> </li>
			</ul>
			<h4 style="color: black;margin: 0 10px;">Commento:</h4>
			<ul class="chat-available-user">
				<li> <?php echo $commento;?> </li>
			</ul>
		</aside>
	</div>
</section>
<script>
	function retdati(){
		var idnps = <?php echo $id;?>;
		var testo = document.getElementById('testo_nota').value;
		var idutente = "<?php  echo tellMeUser($_SESSION['login_user']); ?>";
		var datincl = [idnps,testo,idutente];
		console.log(idutente);
		return datincl;
	}

	function refresh(){
		rldescend({'fxf' : 'pid', 'c1':'note', 'pag': 'note', 'id':<?php echo $id;?>});
	}

	function nota(){
		var dato = new Array();
		dato[0] = retdati();
		var r = confirm("Inserire Nota?")
		if (r) {
			$.post('parts/pages/inseriscinota.php', {
				dati: dato
			}, function(data) {
				rldescend({'fxf' : 'pid', 'c1':'note', 'pag': 'note', 'id':<?php echo $id;?>});
				// console.log(data);
			});
		}

	}

	function risolviNota(){
		var dato = new Array();
		dato[0] = retdati();
		var r = confirm("Risolvere Nota?")
		if (r) {
			$.post('parts/pages/risolvinota.php', {
				dati: dato
			}, function(data) {
				// $("#main-content").html(data).show();
				activateS("<?php $datinps = infoNps($id);echo $datinps['804856X13X91'];?>");
				// rldescend({'fxf' : 'pid', 'c1':'note', 'pag': 'note', 'id':<?php $datinps = infoNps($id);echo $datinps['804856X13X91'];?>});
				console.log(data);
			});
			// console.log(dato);
		}

	}

</script>

