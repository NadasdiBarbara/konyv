<?php

require_once 'db.php';
require_once 'Konyvek.php';

function betoltes($adatsor){
    echo htmlspecialchars($adatsor, ENT_QUOTES);
}

$iroMezo = '';
$cimMezo = '';
$oldalszamMezo = '';
$mufajMezo = '';
$kiadasdatumMezo = '';

$iroHiba = false;
$iroHibaUzenet = '';
$cimHiba = false;
$cimHibaUzenet = '';
$oldalszamHiba = false;
$oldalszamHibaUzenet = '';
$mufajHiba = false;
$mufajHibaUzenet = '';
$kiadasdatumHiba = false;
$kiadasdatumHibaUzenet = '';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iroMezo = $_POST['iro'] ?? '' ;
    $cimMezo = $_POST['cim'] ?? '' ;
    $oldalszamMezo = $_POST['oldalszam'] ?? '' ;
    $mufajMezo = $_POST['mufaj'] ?? '' ;
    $kiadasdatumMezo = $_POST['kiadasdatum'] ?? '' ;
    

$deleteId = $_POST['deleteId'] ?? '';
if ($deleteId !== '') {
    Konyvek::torol($deleteId);
} else {   
    $ujiro = $_POST['iro'] ?? '';
    if(empty($_POST['iro'])){
        $iroHiba = true;
        $iroHibaUzenet = 'Kötelező megadni a könyv íróját!';
    } 
    $ujcim = $_POST['cim'] ?? '';
    if(empty($_POST['cim'])){
        $cimHiba = true;
        $cimHibaUzenet = 'Kötelező megadni a könyv címét!';
    } 
    $ujoldalszam = $_POST['oldalszam'] ?? '';
    if(empty($_POST['oldalszam'])){
        $oldalszamHiba = true;
        $oldalszamHibaUzenet = 'Kötelező megadni a könyv oldalainak számát!';
    } 

    $ujmufaj = $_POST['mufaj'] ?? '';
    if(empty($_POST['mufaj'])){
        $mufajHiba = true;
        $mufajHibaUzenet = 'Kötelező megadni a könyv műfaját!';
    } 

    $ujkiadasdatum = $_POST['kiadasdatum'] ?? '';
    if(empty($_POST['kiadasdatum'])){
        $kiadasdatumHiba = true;
        $kiadasdatumHibaUzenet = 'Kötelező megadni a könyv kiadásának dátumát!';
    } 

    if(!$iroHiba && !$cimHiba && !$oldalszamHiba && !$mufajHiba && !$kiadasdatumHiba){
        
        $ujKonyvek = new Konyvek($ujiro,$ujcim, $ujoldalszam, $ujmufaj, new DateTime($ujkiadasdatum));
        $ujKonyvek->uj();
        $iroMezo = '';
        $cimMezo = '';
        $oldalszamMezo = '';
        $mufajMezo = '';
        $kiadasdatumMezo = '';
        
    }

}
   
}

$konyvek = Konyvek::osszes();

?><!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel='stylesheet' type='text/css' href='main.css' >
    <script src="main.js"></script>
    <title>Könyvek</title>
</head>
<body>
<div class="container">
    <div class= "inputMezo">
    <form method = "POST" name="form" onsubmit ="return adatokKiemel()">
        <div class ="adat">Író:</div>
        <input type = "text" name = 'iro' required value='<?php betoltes($iroMezo) ?>'>
        <div class="hibauzenet"><?php echo $iroHibaUzenet; ?></div>

        <div class ="adat">Cím:</div>
        <input type = "text" name = 'cim' required value='<?php betoltes($cimMezo) ?>'>
        <div class="hibauzenet"><?php echo $cimHibaUzenet; ?></div>

        <div class ="adat">Oldalszám:</div>
        <input type = "number" name = 'oldalszam' required value='<?php betoltes($oldalszamMezo) ?>'>
        <div class="hibauzenet"><?php echo $oldalszamHibaUzenet; ?></div>

        <div class ="adat">Műfaj:</div>
        <input type = "text" name = 'mufaj' required value='<?php betoltes($mufajMezo) ?>'>
        <div class="hibauzenet"><?php echo $mufajHibaUzenet; ?></div>

        <div class ="adat">Kiadás dátuma:</div>
        <input type = "date" name = 'kiadasdatum'  value='<?php betoltes($kiadasdatumMezo) ?>'>
        <div class="hibauzenet"><?php echo $kiadasdatumHibaUzenet; ?></div>

        <br><input class="hozzaad" type= "submit" value= "Új könyv hozzáadása">


    </form>
</div>
    <br>
 
<div class="container">
    <div class="row">


    <?php
        foreach($konyvek as $konyv){
            echo "<div class = 'col-sm-6 col.md-4 col-lg-3 pb-2'>";
                
                    echo "<div class='card-header'>";
                            echo "<h5>" . $konyv->getIro() .  " - "  . $konyv->getCim() .  "</h5>";                         
                    echo "</div>"; 
                    echo "<div class='card-body'>";            
                            echo "<p>"."<i>Oldalszám:</i> " . $konyv->getOldalszam() .  "</p>";
                            echo "<p>" ."<i>Műfaja:</i> " . $konyv->getMufaj() . "</p>";
                            echo "<p>" ."<i>Keletkezés:</i> ". $konyv->getKiadasdatum()->format("Y-m-d") . "</p>"; 
                    echo "</div>";
                    echo "<div class='card-footer'>";
                             echo "<form method='POST'>";          
                            echo "<a class='linkform' href='edit.php?id=" .$konyv->getId(). "'>Szerkeszt</a>";                            
                            echo "<input type='hidden' name='deleteId' value='" . $konyv->getId() . "'>";
                            echo "<button type='submit'>Törlés</button>";
                            echo "</form>";
                    echo "</div>";
                
            echo "</div>";
        }


    ?>
    </div>
</div>

</body>
</html>