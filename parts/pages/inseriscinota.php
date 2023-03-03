<?php
	include 'fun.php';

	$ut = $_POST['dati'];
	// iserisciNota($id_nps, $testo, $id_operatore)
	iserisciNota($ut[0][0], $ut[0][1], $ut[0][2]);

?>