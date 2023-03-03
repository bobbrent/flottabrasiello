<?php

require '../../lib/SimpleXLSX.php';
include '../../functions/db.php';

include '../../config/struct.php';
$db = new dbObj();
$connString = $db->getConnstring();

$aggiunti = 0;
$aggiornati = 0;
$saltati = 0;

if ($xlsx = SimpleXLSX::parse('../../upload/upload/prodotti.xlsx')) {
    $prodotti = $xlsx->rows();
    $i = 0;
    foreach ($prodotti as $prod) {
        if ($i > 1) {
            if ($prod[3] != '') {
                if ($i <= count($prodotti)) {
                    $cod = $prod[3];
                    $cec1 = mysqli_query($connString, "SELECT * FROM `prodotti` where `cod` = $cod") or die("database error:" . mysqli_error($connString));
                    $row_cnt = mysqli_num_rows($cec1);
                    if ($row_cnt >= 1) {
                        $cat = $prod[2];
                        $desc = addslashes($prod[4]);
                        $pbanco = $prod[5];
                        $priv = $prod[6];
                        $pserr = $prod[7];
                        $rapp = $prod[8];
                        $um = $prod[9];
                        $tip = $prod[10];
                        // echo $cat . $cod . $desc . $pbanco . $priv . $pserr . $rapp . $um . $tip . '<br>';
                        $cec = mysqli_query($connString, "UPDATE `prodotti` SET `categoria`='" .
                            $cat . "',`descrizione`='" . $desc . "',`pbanco`='" . $pbanco . "',`privenditore`='" . $priv .
                            "',`pserramentisti`='" . $pserr . "',`rappresentanza`='" . $rapp . "',`um`='" . $um .
                            "',`tipologia`='" . $tip . "' WHERE `cod` = '" . $cod . "'") or die("database error:" . mysqli_error($connString));
                        $i++;
                        $aggiornati++;
                        $cat = '';
                        $cod = '';
                        $desc = '';
                        $pbanco = '';
                        $priv = '';
                        $pserr = '';
                        $rapp = '';
                        $um = '';
                        $tip = '';
                    } else {
                        $cat = $prod[2];
                        $cod = $prod[3];
                        $desc = addslashes($prod[4]);
                        $pbanco = $prod[5];
                        $priv = $prod[6];
                        $pserr = $prod[7];
                        $rapp = $prod[8];
                        $um = $prod[9];
                        $tip = $prod[10];
                        // echo $cat . $cod . $desc . $pbanco . $priv . $pserr . $rapp . $um . $tip . '<br>';
                        $cec = mysqli_query($connString, "INSERT INTO `prodotti`(`categoria`, `cod`, `descrizione`, `pbanco`, `privenditore`, `pserramentisti`, `rappresentanza`, `um`, `tipologia`) VALUES ('" .
                            $cat . "','" . $cod . "','" . $desc . "','" . $pbanco . "','" . $priv . "','" . $pserr . "','" . $rapp . "','" . $um . "','" . $tip . "')") or die("database error:" . mysqli_error($connString));
                        $i++;
                        $aggiunti++;
                        $cat = '';
                        $cod = '';
                        $desc = '';
                        $pbanco = '';
                        $priv = '';
                        $pserr = '';
                        $rapp = '';
                        $um = '';
                        $tip = '';
                    }
                }
            } else {
                $i++;
                $saltati++;
            }
        } else {
            $i++;
        }
		}
		?>
<section class="wrapper site-min-height">
	<div class="row mt">
		<div class="col-lg-12">
			<?php
echo "<h3>Aggiunti <strong>$aggiunti</strong> prodotti, Aggiornati <strong>$aggiornati</strong> prodotti, Saltati <strong>$saltati</strong> prodotti </h3> ";
?>
		</div>
	</div>
</section>
<?php

unlink('../../upload/upload/prodotti.xlsx');
} else {
    echo SimpleXLSX::parseError();
}




?>