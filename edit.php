<?php
require_once 'db.php';
require_once "Konyvek.php";

$konyvId = $_GET['id'] ?? null;

if ($konyvId === null){
   header('Location: index.php');
   exit();
}

$konyv = Konyvek::getById($konyvId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ujiro = $_POST['iro'] ?? '' ;
    $ujcim = $_POST['cim'] ?? '' ;
    $ujoldalszam = $_POST['oldalszam'] ?? '' ;
    $ujmufaj = $_POST['mufaj'] ?? '' ;
    $ujkiadasdatum = $_POST['kiadasdatum'] ?? '' ;

    if(empty($_POST['iro'])){
       $ujiro = $konyv->getIro();
    } 
    if(empty($_POST['cim'])){
        $ujcim = $konyv->getCim();
     } 
     if(empty($_POST['oldalszam'])){
        $ujoldalszam = $konyv->getOldalszam();
     } 
     if(empty($_POST['mufaj'])){
        $ujmufaj = $konyv->getMufaj();
     } 
     if(empty($_POST['kiadasdatum'])){
        $ujkiadasdatum = $konyv->getKiadasdatum()->format('Y-m-d');
     } 

    $konyv->setIro($ujiro);
    $konyv->setCim($ujcim);
    $konyv->setOldalszam($ujoldalszam);
    $konyv->setMufaj($ujmufaj);
    $konyv->setKiadasdatum(new DateTime($ujkiadasdatum));
    
    $konyv->mentes($konyvId);
    
    header('Location: index.php');
    exit();
   
}


?><!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <title>Edit</title>
</head>
<body>
   <div class="container">
      <div class= "modositas">
      <form method="post">
         
         <div class="iro">
            <div class="row">
               <p class="col-6">Író</p>
               <input required class="col-6" type="text" name="iro" placeholder="<?php echo $konyv->getIro()?>">
            </div>
         </div><br>

         <div class = "cim">
            <div class="row">
               <p class= col-6>Cím</p>
               <input required class="col-6" type="text" name="cim" placeholder="<?php echo $konyv->getCim()?>">
            </div>
         </div><br>

         <div class = "oldalszam">
            <div class ="row">
               <p class="col-6">Oldalszám</p>
               <input required class="col-6" type="number" name="oldalszam" placeholder="<?php echo $konyv->getOldalszam()?>">
            </div>
         </div><br>

         <div class ="mufaj">
            <div class="row">
               <p class="col-6">Műfaj</p>
            <input required class="col-6" type="text" name="mufaj" placeholder="<?php echo $konyv->getMufaj()?>">  
            </div>
         </div><br>

         <div class="kiadas">
            <div class="row">
               <p class="col-6"> Kiadás Dátum</p>
           <input class="col-6" type="date" name="kiadasdatum" placeholder="<?php echo $konyv->getKiadasdatum()->format('Y-m-d')?>">
            </div>
         </div><br>

         <div class= "kesz">
            <input class="hozzaad" type="submit" value="Kész" >
         </div>
      </form>
</div>
</div>
</body>
</html>