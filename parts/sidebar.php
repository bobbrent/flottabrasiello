<?php
	include 'fun.php';
	$utente = $_SESSION['login_user'];
	$sede_1 = tellMeSedeUser($utente);
	$sede = json_decode($sede_1);
?>
<aside>
	<div id="sidebar" class="nav-collapse ">
		<ul class="sidebar-menu" id="nav-accordion">
			<li class="mt">
				<?php
					if(isset($_SESSION['is_admin'])){
						?>
							<a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'home', 'pag': 'home', 'who':'admin'});clearR();return false;">
						<?
					}else{
					?>
						<a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'home', 'pag': 'home', 'who':'utente', 'sede' : '<?php echo $sede[0];?>'});clearR();return false;">
					<?
					}
				?>
						<i class="fa fa-dashboard"></i>
						<span>Home</span>
						</a>
			</li>
			<li class="sub-menu">
				<a class="active" href="javascript:;">
					<i class="fa fa-book"></i>
					<span>FN Personalizzate</span>
					</a>
				<ul class="sub">
						<?php
						if(isset($_SESSION['is_admin'])){
							?>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'stockpersonalizzati', 'pag': 'stockpersonalizzati', 'who':'admin'});clearR();">STOCK</a></li>
							<?php
						}else if(isset($sede[0])){	
							$sede_competenza = 	$sede[0];					
							?>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'stockpersonalizzati', 'pag': 'stockpersonalizzati', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">STOCK</a></li>
							<?
						}
					?>
				</ul>
			</li>
			<li class="sub-menu">
				<a class="active" href="javascript:;">
					<i class="fa fa-book"></i>
					<span>STORICO</span>
					</a>
				<ul class="sub">
						<?php
						if(isset($_SESSION['is_admin'])){
							?>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicolitotale', 'pag': 'listaveicolitotale', 'who':'admin'});clearR();">TOTALE</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicoli', 'pag': 'listaveicoli', 'who':'admin'});clearR();">STORICO USATO</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicolinuovo', 'pag': 'listaveicolinuovo', 'who':'admin'});clearR();">STORICO NUOVO</a></li>
							<?php
						}else if(isset($sede[0])){	
							$sede_competenza = 	$sede[0];					
							?>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicolitotale', 'pag': 'listaveicolitotale', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">TOTALE</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicoli', 'pag': 'listaveicoli', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">STORICO USATO</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicolinuovo', 'pag': 'listaveicolinuovo', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">STORICO NUOVO</a></li>
							<?
						}
					?>
				</ul>
			</li>
			<li class="sub-menu">
				<a class="active" href="javascript:;">
					<i class="fa fa-book"></i>
					<span>VEICOLI IN SEDE</span>
					</a>
				<ul class="sub">
						<?php
						if(isset($_SESSION['is_admin'])){
							?>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicoliinsedetotale', 'pag': 'listaveicoliinsedetotale', 'who':'admin'});clearR();">TOTALE</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicoliinsede', 'pag': 'listaveicoliinsede', 'who':'admin'});clearR();">VEICOLI IN SEDE USATO</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicoliinsedenuovo', 'pag': 'listaveicoliinsedenuovo', 'who':'admin'});clearR();">VEICOLI IN SEDE NUOVO</a></li>
							<?php
						}else if(isset($sede[0])){	
							$sede_competenza = 	$sede[0];					
							?>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicoliinsedetotale', 'pag': 'listaveicoliinsedetotale', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">TOTALE</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicoliinsede', 'pag': 'listaveicoliinsede', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">VEICOLI IN SEDE USATO</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'listaveicoliinsedenuovo', 'pag': 'listaveicoliinsedenuovo', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">VEICOLI IN SEDE NUOVO</a></li>
							<?
						}
					?>
				</ul>
			</li>
			<li class="sub-menu">
				<a class="active" href="javascript:;">
					<i class="fa fa-book"></i>
					<span>INS/LAVORAZIONI</span>
					</a>
				<ul class="sub">
						<?php
						if(isset($_SESSION['is_admin'])){
							?><li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'ingressoveicoli', 'pag': 'ingressoveicoli', 'who':'admin'});clearR();">Ingresso</a></li>
							<!-- <li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'lavorazioni', 'pag': 'lavorazioni', 'who':'admin'});clearR();">Lavorazioni</a></li> -->
							<?php
						}else if(isset($sede[0])){	
							$sede_competenza = 	$sede[0];					
							?>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'ingressoveicoli', 'pag': 'ingressoveicoli', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">Ingresso</a></li>
							<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'lavorazioni', 'pag': 'lavorazioni', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();">Lavorazioni</a></li>
							<?
						}
					?>
				</ul>
			</li>
			<li class="sub-menu">
					<?php
						if(isset($_SESSION['is_admin'])){
							?>
								<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'bolle', 'pag': 'bolle', 'who':'admin'});clearR();"><i class="fa fa-book"></i>Bolle</a></li>
							<?php
						}else if(isset($sede[0])){	
							$sede_competenza = 	$sede[0];			
							?>
								<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'bolle', 'pag': 'bolle', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();"><i class="fa fa-book"></i>Bolle</a></li>
							<?php
						}
					?>
			</li>
			<li class="sub-menu">
					<?php
						if(isset($_SESSION['is_admin'])){
							?>
								<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'nuovabolla', 'pag': 'nuovabolla', 'who':'admin'});clearR();"><i class="fa fa-book"></i>Nuova Bolla</a></li>
							<?php
						}else if(isset($sede[0])){	
							$sede_competenza = 	$sede[0];			
							?>
								<li class="active"><a href="#" onclick="rldescend({ 'fxf': 'full', 'c1': 'nuovabolla', 'pag': 'nuovabolla', 'who':'utente', 'sede' : '<?php echo $sede_competenza;?>'});clearR();"><i class="fa fa-book"></i>Nuova Bolla</a></li>
							<?php
						}
					?>
			</li>
			<?php
				if(isset($_SESSION['is_admin'])){
					?>
					<li class="sub-menu">
						<a class="active" href="javascript:;">
						<i class="fa fa-book"></i>
						<span>Utenti</span>
						</a>
						<ul class="sub">
							<li class="active"><a href="#" onclick="dAzN('utenti');return false;">Lista Utenti</a></li>
							<li class="active"><a href="#" onclick="dAzN('nuovoutente');return false;">Nuovo Utente</a></li>
						</ul>
					</li>
					<li class="sub-menu">
						<a class="active" href="javascript:;">
						<i class="fa fa-book"></i>
						<span>EXTRA</span>
						</a>
						<ul class="sub">
							<li class="active"><a href="#" onclick="dAzN('cancellamacchine');return false;">Cancellazione Veicoli</a></li>
							<li class="active"><a href="#" onclick="dAzN('uscitaebolla');return false;">Elimina Uscita</a></li>
						</ul>
					</li>
					<li class="sub-menu">
						<a class="active" href="javascript:;">
						<i class="fa fa-bars"></i>
						<span>Impostazioni</span>
						</a>
						<ul class="sub">
							<li class="active"><a href="#" onclick="dAzN('progressivi');return false;">Settaggio Sedi</a></li>
							<li class="active"><a href="#" onclick="dAzN('nuovasede');return false;">Nuova Sede</a></li>
							<li class="active"><a href="#" onclick="dAzN('piazzali');return false;">Modifica Piazzali</a></li>
							<li class="active"><a href="#" onclick="dAzN('nuovopiazzale');return false;">Nuovo Piazzale</a></li>
						</ul>
					</li>
					<?php
				}
			?>
		</ul>
	</div>
</aside>

